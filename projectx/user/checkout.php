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

// Adatbázisból a termékek lekérdezése
$query = "SELECT termek_nev, darab, ar FROM rendeles WHERE user_id = ? AND aktiv = 1";
if ($stmt = mysqli_prepare($con, $query)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $total = 0;
    $termekek = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $termekek[] = $row;
        $total += $row['ar'] * $row['darab'];  // Az ár és a darabszám szorzata hozzáadódik az összeséghez
    }
    mysqli_stmt_close($stmt);
} else {
    echo 'Nincs megrendelehető termék a kosárban';
}

if (isset($_POST['returnToCart'])) {
    $queryKosar = "UPDATE kosar SET kosarbane = 0 WHERE user_id = ?";
    if ($stmtKosar = mysqli_prepare($con, $queryKosar)) {
        mysqli_stmt_bind_param($stmtKosar, "i", $user_id);
        mysqli_stmt_execute($stmtKosar);
        mysqli_stmt_close($stmtKosar);
    }

    // Töröljük azokat a sorokat a rendeles táblából, ahol az aktiv értéke 0
    $queryRendeles = "DELETE FROM rendeles WHERE user_id = ? AND aktiv = 1";
    if ($stmtRendeles = mysqli_prepare($con, $queryRendeles)) {
        mysqli_stmt_bind_param($stmtRendeles, "i", $user_id);
        mysqli_stmt_execute($stmtRendeles);
        mysqli_stmt_close($stmtRendeles);
    }

    mysqli_close($con);

    // Átirányítás a kosar.php oldalra
    header('Location: kosar.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../css/styles.css">

    <style>
        button.btn-secondary {
            background-color: #007BFF;
            /* Világoskék háttér */
            color: white;
            /* Fehér szöveg */
            padding: 10px 20px;
            /* Bőséges padding a jobb érzésért */
            border: none;
            /* Eltávolítjuk a keretet */
            border-radius: 5px;
            /* Enyhe lekerekítés a sarkokon */
            cursor: pointer;
            /* Mutató ikon változik, ha ráviszik az egeret */
            transition: all 0.3s;
            /* Sima átmenet a színváltozáshoz */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Enyhe árnyék hozzáadása */
            font-size: 16px;
            /* Nagyobb szövegméret a könnyű olvashatóságért */
        }

        /* A gomb állapotai, mint hover és focus */
        button.btn-secondary:hover,
        button.btn-secondary:focus {
            background-color: #0056b3;
            /* Kissé sötétebb kék, amikor hover állapotban van */
            outline: none;
            /* Megakadályozzuk, hogy böngésző által generált körvonal jelenjen meg */
        }

        /* A gomb aktív állapota, például amikor megnyomják */
        button.btn-secondary:active {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            /* Mélyebb árnyék a "lenyomott" hatáshoz */
            transform: translateY(2px);
            /* Enyhe eltolás lefelé, mint ha lenyomva lenne */
        }
    </style>
</head>

<body>
    <header>
        <nav class="nav" id="navbar">
            <ul class="nav__list" id="navlinkitems">
                <li class="nav__item main-item" style=" position:relative; right: 700px">
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
                    <a href="./profile.php" class="nav__link" id="contact">Profilom</a>
                </li>
                <li class="nav_item">
                    <a href="../logout.php" class="nav__link" style="color:red" id="logout">Kijelentkezés</a>
                </li>
            </ul>
        </nav>
    </header>
    <h3 style="margin-left: 200px">Rendelés</h3>
    <form action="" method="post">
        <button type="submit" name="returnToCart" class="btn btn-secondary" style="margin-bottom: 10px;">Vissza a
            kosárhoz</button>
    </form>
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>Termék Név</th>
                    <th>Darabszám</th>
                    <th>Ár</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($termekek as $termek): ?>
                    <tr>
                        <td><?= htmlspecialchars($termek['termek_nev']) ?></td>
                        <td><?= $termek['darab'] ?></td>
                        <td><?= number_format($termek['ar'] * $termek['darab'], 2) ?> Ft</td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <th colspan="2">Összesen</th>
                    <th><?= number_format($total, 2) ?> Ft</th>
                </tr>
            </tbody>
        </table>
        <form action="process_order.php" method="post">
            <div class="form-group">
                <label for="deliveryType">Szállítási mód:</label>
                <select class="form-control" id="deliveryType" name="deliveryType" onchange="toggleDeliveryOptions();">
                    <option value="pickup">Átvétel</option>
                    <option value="delivery">Kiszállítás</option>
                </select>
            </div>
            <div id="pickupOptions" class="form-group" style="display: none;">
                <label for="pickupDate">Átvételi időpont:</label>
                <input type="text" class="form-control" name="plastName" placeholder="Vezetéknév">
                <input type="text" class="form-control" name="pfirstName" placeholder="Keresztnév">
                <input type="text" class="form-control" name="pphone" placeholder="Telefonszám">
            </div>
            <div id="deliveryOptions" class="form-group" style="display: none;">
                <input type="text" class="form-control" name="lastName" placeholder="Vezetéknév">
                <input type="text" class="form-control" name="firstName" placeholder="Keresztnév">
                <input type="text" class="form-control" name="zipCode" placeholder="Irányítószám">
                <input type="text" class="form-control" name="street" placeholder="Utca">
                <input type="number" class="form-control" name="addnum" placeholder="Házszám">
                <input type="text" class="form-control" name="phone" placeholder="Telefonszám">
            </div>
            <button type="submit" class="btn btn-primary">Rendelés megerősítése</button>
        </form>
    </div>
    <script>
        function toggleDeliveryOptions() {
            var deliveryType = $('#deliveryType').val();
            if (deliveryType == 'pickup') {
                $('#pickupOptions').show();
                $('#deliveryOptions').hide();
            } else if (deliveryType == 'delivery') {
                $('#deliveryOptions').show();
                $('#pickupOptions').hide();
            }
        }
        $(document).ready(function () {
            toggleDeliveryOptions();
        });
    </script>
</body>

</html>
<style>
    body {
        background-color: #f4f4f4;
        color: #333;
        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    }

    .container {
        background: white;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
        padding: 20px;
    }

    h1 {
        color: #007bff;
    }

    table {
        margin-top: 20px;
    }

    th,
    td {
        text-align: center;
    }

    .table thead th {
        background-color: #007bff;
        color: white;
    }

    .form-group {
        margin-top: 20px;
    }

    label {
        font-weight: bold;
    }

    input[type="date"],
    input[type="text"],
    select.form-control {
        margin-top: 5px;
    }

    #pickupOptions,
    #deliveryOptions {
        background: #eee;
        padding: 10px;
        border-radius: 5px;
        margin-top: 10px;
    }

    button.btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        margin-top: 20px;
        width: 100%;
    }

    button.btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }
</style>