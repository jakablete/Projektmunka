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
    $itemCount = 0;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webshop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        function updateQuantity(elem) {
            var kosarId = $(elem).data('id');
            var newQuantity = $(elem).val();
            $.ajax({
                url: 'update_cart_quantity.php',
                type: 'POST',
                data: { kosar_id: kosarId, quantity: newQuantity },
                success: function (response) {
                    console.log('Quantity updated successfully');
                    location.reload();
                },
                error: function () {
                    alert('Error updating quantity');
                }
            });
        }
    </script>
    <style>
.table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
}

th, td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
}

thead {
    background-color: #007bff;
    color: #ffffff;
}

tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

tfoot th {
    background-color: #e9e9e9;
    font-size: 1.1em;
}

input[type="number"] {
    width: 60px;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    text-align: center;
}

/* Button Styling */
button, .btn {
    padding: 8px 15px;
    border-radius: 5px;
    border: none;
    color: #fff;
    font-size: 1em;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-primary {
    background-color: #007bff;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.btn-danger {
    background-color: #dc3545;
}

.btn-danger:hover {
    background-color: #bd2130;
}

/* Utility Classes */
.quantity {
    margin-top: 5px;
    margin-bottom: 5px;
}
    </style>
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
    <div class="container">
        <!-- Main content -->
    </div>
</body>
<?php

$user = mysqli_query($con, "SELECT id from users WHERE uname = '$_SESSION[loggedin]'");
$user_r = mysqli_fetch_array($user);
// Lekérdezi csak azokat a termékeket, amelyek aktiv értéke 0
$query = "SELECT k.*, t.mennyiseg as max_mennyiseg FROM kosar k LEFT JOIN termekek t ON k.termek_id = t.termek_id WHERE k.user_id = ? AND k.kosarbane = 0";
if ($stmt = mysqli_prepare($con, $query)) {
    mysqli_stmt_bind_param($stmt, "i", $user_r['id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $total = 0;

    echo "<form action='process_checkout.php' method='post' class='container mt-5'>";
    echo "<table class='table'>";
    echo "<thead class='thead-dark'><tr><th>Termék Név</th><th>Szélesség</th><th>Darab</th><th>Ár</th><th>Művelet</th></tr></thead>";
    echo "<tbody>";

    while ($row = mysqli_fetch_assoc($result)) {
        $subtotal = $row['darab'] * $row['ara'];
        $total += $subtotal;

        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['termek_neve']) . "</td>";
        echo "<input type='hidden' name='user_id' value='" . $user_r['id'] . "'>";
        echo "<input type='hidden' name='termek_neve[]' value='" . htmlspecialchars($row['termek_neve']) . "'>";
        echo "<input type='hidden' name='ara[]' value='" . $row['ara'] . "'>";
        echo "<input type='hidden' name='termek_id[]' value='" . $row['termek_id'] . "'>";
        echo "<input type='hidden' name='darab[]' value='" . $row['darab'] . "'>";
        echo "<td>" . htmlspecialchars($row['szelesseg']) . "</td>";
        echo "<td><input type='number' name='mennyiseg[" . $row['kosar_id'] . "]' value='" . $row['darab'] . "' min='1' max='" . $row['max_mennyiseg'] . "' class='form-control quantity' data-id='" . $row['kosar_id'] . "' data-max='" . $row['max_mennyiseg'] . "' onchange='updateQuantity(this)'></td>";
        echo "<td>" . $row['ara'] . " Ft/db</td>";
        echo "<td><button type='submit' name='delete' value='" . $row['kosar_id'] . "' class='btn btn-danger'>Törlés</button></td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "<tfoot><tr><th colspan='3'>Összesen</th><th>" . $total . " Ft</th><th></th></tr></tfoot>";
    echo "</table>";
    echo "<a style='margin-bottom: 1%;' href='vasarlas.php' class='btn btn-primary'>Vásárlás folytatása</a>";
    echo "<button type='submit' class='btn btn-primary'>Tovább a megrendelésre</button>";
    echo "</form>";

    mysqli_stmt_close($stmt);
} else {
    echo "Error: " . mysqli_error($con);
}

mysqli_close($con);
?>

</html>