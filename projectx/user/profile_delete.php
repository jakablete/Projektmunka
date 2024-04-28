<?php
include('../session.php');
access("USER");

include('../php/config.php');

$userId = $_SESSION['user_id'];
$query = "DELETE FROM users WHERE id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();

if ($stmt->affected_rows === 1) {
    session_destroy();
    header('Location: /projektmunka/login.php'); 
    exit();
} else {
    echo "Profil törlése nem sikerült.";
}

$stmt->close();
?>
