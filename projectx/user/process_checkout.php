<?php

include('../session.php');
access("USER");

include('../php/config.php');

$user = mysqli_query($con, "SELECT id from users WHERE uname = '$_SESSION[loggedin]'");
$user_r = mysqli_fetch_array($user);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if deletion was requested
    if (isset($_POST['delete'])) {
        // Delete the specified item
        $id = $_POST['delete'];
        $query = "DELETE FROM kosar WHERE kosar_id = ?";
        if ($stmt = mysqli_prepare($con, $query)) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
        header('Location: kosar.php');
        exit;
    } elseif (isset($_POST['termek_id'])) { // Check if checkout process was requested
        $userId = $user_r['id'];
        $termek_ids = $_POST['termek_id'];
        $termek_nevek = $_POST['termek_neve'];
        $darabszamok = $_POST['darab'];
        $arak = $_POST['ara'];
        $aktiv = 1;

        for ($i = 0; $i < count($termek_ids); $i++) {
            $termek_id = $termek_ids[$i];
            $termek_nev = $termek_nevek[$i];
            $darab = $darabszamok[$i];
            $ar = $arak[$i];

            // Adjust this query if 'ar' is supposed to be the price of individual items
            $query = "INSERT INTO rendeles (user_id, termek_id, termek_nev, ar, darab, aktiv) VALUES (?, ?, ?, ?, ?, ?)";
            if ($stmt = mysqli_prepare($con, $query)) {
                mysqli_stmt_bind_param($stmt, "iisiii", $userId, $termek_id, $termek_nev, $ar, $darab, $aktiv); // Note: $total might be incorrect here
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }
        }
        header('Location: checkout.php');
        exit;
    }
}

// Close connection
mysqli_close($con);
?>
?>
