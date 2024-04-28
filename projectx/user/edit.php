<?php
include('../session.php');
access("USER");

include('../php/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $userId = $_SESSION['user_id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $uname = $_POST['uname'];
    $email = $_POST['email'];

    $query = "UPDATE users SET fname = ?, lname = ?, uname = ?, email = ? WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ssssi", $fname, $lname, $uname, $email, $userId);
    $stmt->execute();

    if ($stmt->affected_rows === 1) {
        header('Location: profile.php');
        exit();
    } else {
        echo "Nem történt változás.";
    }

    $stmt->close();
}
?>
