<?php
include('../php/config.php');

if(isset($_POST['kosar_id']) && isset($_POST['quantity'])) {
    $kosarId = $_POST['kosar_id'];
    $quantity = $_POST['quantity'];

    $query = "UPDATE kosar SET darab = ? WHERE kosar_id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ii", $quantity, $kosarId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

mysqli_close($con);
?>
