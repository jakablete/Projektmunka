<?php
include('../php/config.php');

if (isset($_POST['delete'])) {
    // Delete the specified item
    $id = $_POST['delete'];
    $query = "DELETE FROM kosar WHERE kosar_id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Redirect back to the cart page
header('Location: kosar.php');
exit;
?>
