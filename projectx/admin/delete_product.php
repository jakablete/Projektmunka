<?php

include ('../session.php');
access("ADMIN");
include('../php/config.php');

$user = mysqli_query($con, "SELECT id from users WHERE uname = '$_SESSION[loggedin]'");
$user_r = mysqli_fetch_array($user);

if (isset($_POST['delete'])) {
    $termek_id = $_POST['termek_id']; // Ellenőrizd, hogy valóban át lett-e adva
    $query = "DELETE FROM termekek WHERE termek_id = ?"; // Helyes SQL szintaxis
    if ($stmt = mysqli_prepare($con, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $termek_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header('Location: ./adminlist.php'); // Sikeres törlés után átirányítás
    } else {
        echo "Hiba történt: " . mysqli_error($con);
    }
}


mysqli_close($con);
?>