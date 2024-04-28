Levente Jakab
<?php
session_start();
include('../php/config.php');


$user = mysqli_query($con, "SELECT id from users WHERE uname = '$_SESSION[loggedin]'");
$user_r = mysqli_fetch_array($user);

$user_id = $user_r['id'];  // Bejelentkezett felhasználó azonosítója
$date = date('Y-m-d');
echo "Formatted date: " . $date; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $deliveryType = $_POST['deliveryType'];
    $lastName = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $zipCode = $_POST['zipCode'];
    $street = $_POST['street'];
    $addnum = $_POST['addnum'];
    $phone = $_POST['phone'];
    $user_id = $user_r['id'];

    $plastName = $_POST['plastName'];
    $pfirstName = $_POST['pfirstName'];
    $pphone = $_POST['pphone'];
    $date = date('Y-m-d');
    

    // Szállítási opció és aktív állapot beállítása
    $aktiv = ($deliveryType == 'delivery' || $deliveryType == 'pickup') ? 2 : 1;
    $shipping = ($deliveryType == 'delivery') ? 1 : 0;

    if ($deliveryType == 'delivery') {
        $query = "UPDATE rendeles SET lastName = ?, firstName = ?, iranyitoszam = ?, utca = ?, hazszam = ?, phone = ?, szallitas = ?, aktiv = ?, date = ? WHERE user_id = ? AND aktiv = 1";
        if ($stmt = mysqli_prepare($con, $query)) {
            mysqli_stmt_bind_param($stmt, "ssssisiiss", $lastName, $firstName, $zipCode, $street, $addnum, $phone, $shipping, $aktiv, $date, $user_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
        updateCart($con, $user_id);
    } elseif ($deliveryType == 'pickup') {
        $query = "UPDATE rendeles SET lastName = ?, firstName = ?, phone = ?, szallitas = ?, aktiv = ?, date = ? WHERE user_id = ? AND aktiv = 1";
        if ($stmt = mysqli_prepare($con, $query)) {
            mysqli_stmt_bind_param($stmt, "sssiiss", $plastName, $pfirstName, $pphone, $shipping, $aktiv, $date, $user_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
        updateCart($con, $user_id);
    }

    mysqli_close($con);

    // Sikeres frissítés után átirányítás
    header('Location: thanks.php');
    exit();
} else {
    // Ha a kérés nem POST, visszairányítás a főoldalra
    header('Location: ../index.php');
    exit();
}

function updateCart($con, $user_id) {
    $decrementStockQuery = "
        UPDATE termekek t
        JOIN kosar k ON t.termek_id = k.termek_id
        SET t.mennyiseg = t.mennyiseg - k.darab
        WHERE k.user_id = ? AND k.kosarbane = 0";

    if ($decrementStockStmt = mysqli_prepare($con, $decrementStockQuery)) {
        mysqli_stmt_bind_param($decrementStockStmt, "i", $user_id);
        mysqli_stmt_execute($decrementStockStmt);
        mysqli_stmt_close($decrementStockStmt);
    }
    $updateCartQuery = "UPDATE kosar SET kosarbane = 1 WHERE user_id = ?";
    if ($updateCartStmt = mysqli_prepare($con, $updateCartQuery)) {
        mysqli_stmt_bind_param($updateCartStmt, "i", $user_id);
        mysqli_stmt_execute($updateCartStmt);
        mysqli_stmt_close($updateCartStmt);
    }
}
?>