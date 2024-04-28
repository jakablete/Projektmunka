<?php

include ('../session.php');
access("USER");

include ('../php/config.php');

$user = mysqli_query($con, "SELECT id from users WHERE uname = '$_SESSION[loggedin]'");
$user_r = mysqli_fetch_array($user);

$user_id = $user_r['id'];

$cartQuery = "SELECT COUNT(*) as itemCount FROM kosar WHERE kosarbane = 0 AND user_id = ?";
if ($cartStmt = mysqli_prepare($con, $cartQuery)) {
    mysqli_stmt_bind_param($cartStmt, "i", $user_id);
    mysqli_stmt_execute($cartStmt);
    mysqli_stmt_bind_result($cartStmt, $itemCount);
    mysqli_stmt_fetch($cartStmt);
    mysqli_stmt_close($cartStmt);
} else {
    $itemCount = 0; // Default to 0 in case the query fails
}

$uname = $_SESSION['loggedin'];
$query = "SELECT uname, email, fname, lname FROM users WHERE uname = '$uname'";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "Nincs ilyen felhasználó.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
            rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
        <title>Profil Oldal</title>
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="stylesheet" href="../css/profile.css">
    </head>

<body>
    <header>
        <nav class="nav" id="navbar">

            <ul class="nav__list" id="navlinkitems">
                <li class="nav__item main-item" style=" position:relative; right: 500px">
                    <span class="workspace-title"><a href="index.php" class="nav__link" id="home">Műhely</a></span>
                </li>
                <li class="nav__item">
                    <a href="./rolunk.php" class="nav__link" id="about">Rólunk</a>
                </li>
                <li class="nav__item">
                    <a href="./vasarlas.php" class="nav__link" id="service">Webshop</a>
                </li>
                <li class="nav__item">
                    <a href="./kosar.php" class="nav__link" id="cart">Kosár <span
                            class="cart-count"><?= $itemCount ?></span></a>
                </li>
                <li class="nav__item">
                    <a href="./rendeleseim.php" class="nav__link" id="orders">Rendeléseim</a>
                </li>
                <li class="nav__item">
                    <a href="./profile.php" class="nav__link" id="contact">Profilom</a>
                </li>
                <li class="nav_item">
                    <a href="../logout.php" class="nav__link" style="color:red" id="logout">Kijelentkezés</a>
                </li>
            </ul>

        </nav>
    </header>
    <section class="home">
        <div class="profil">
            <h1>Profil adatok</h1>
            <table class="user-info">
                <tr>
                    <th>Vezetéknév</th>
                    <td><?php echo htmlspecialchars($user['fname']); ?></td>
                </tr>
                <tr>
                    <th>Keresztnév</th>
                    <td><?php echo htmlspecialchars($user['lname']); ?></td>
                </tr>
                <tr>
                    <th>Felhasználónév</th>
                    <td><?php echo htmlspecialchars($user['uname']); ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                </tr>
            </table>
            <div class="buttons">
                <a href="profile_edit.php" class="button">Profil szerkesztése</a>
                <a href="profile_delete.php" class="button" id="deleteProfileButton">Profil törlése</a>
            </div>
            <div id="deleteConfirmationModal" class="modal" style="display:none;">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <p>Biztosan törölni szeretnéd a profilodat?</p>
                    <button id="confirmDelete">Igen</button>
                    <button id="cancelDelete">Mégse</button>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
<script>
    document.getElementById('deleteProfileButton').onclick = function (event) {
        event.preventDefault(); // Megakadályozza a link alapértelmezett működését
        document.getElementById('deleteConfirmationModal').style.display = 'block';
    }

    document.getElementsByClassName('close')[0].onclick = function () {
        document.getElementById('deleteConfirmationModal').style.display = 'none';
    }

    document.getElementById('cancelDelete').onclick = function () {
        document.getElementById('deleteConfirmationModal').style.display = 'none';
    }

    document.getElementById('confirmDelete').onclick = function () {
        window.location.href = 'profile_delete.php'; // A tényleges törlési folyamat elindítása
    }
</script>