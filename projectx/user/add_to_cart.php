<?php
include ('../php/config.php');
session_start();

// Get user input from the form
$user = mysqli_query($con, "SELECT id from users WHERE uname = '$_SESSION[loggedin]'");
$user_r = mysqli_fetch_array($user);

$userId = $user_r['id'];
$termekId = $_POST['termekId'];
$termekNev = $_POST['termekNev'];
$szelesseg = $_POST['szelesseg'];
$mennyiseg = $_POST['mennyiseg'];
$ar = $_POST['ar'];

// Check if the product already exists in the cart
$checkQuery = "SELECT * FROM kosar WHERE kosarbane = 0 AND user_id= ? AND termek_id = ?";
if ($checkStmt = mysqli_prepare($con, $checkQuery)) {
    mysqli_stmt_bind_param($checkStmt, "ii", $userId, $termekId);
    mysqli_stmt_execute($checkStmt);
    mysqli_stmt_store_result($checkStmt);

    if (mysqli_stmt_num_rows($checkStmt) > 0) {
        // If product exists in the cart, redirect with an error message
        mysqli_stmt_close($checkStmt);
        mysqli_close($con);
        header("Location: vasarlas.php?error=alreadyInCart");
        exit;
    }
    mysqli_stmt_close($checkStmt);
}
// Prepare SQL query to insert the data into the cart table
$query = "INSERT INTO kosar (termek_id, user_id, termek_neve, szelesseg, darab, ara) VALUES (?, ?, ?, ?, ?, ?)";
if ($stmt = mysqli_prepare($con, $query)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "iisiii", $termekId, $userId, $termekNev, $szelesseg, $mennyiseg, $ar);

    // Execute the query
    mysqli_stmt_execute($stmt);

    // Check for successful insertion
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        // Close statement
        mysqli_stmt_close($stmt);
        // Close connection
        mysqli_close($con);

        // Redirect to vasarlas.php
        header('Location: vasarlas.php');
        exit;
    } else {
        echo "Error adding product to cart.";
        // Close statement
        mysqli_stmt_close($stmt);
    }
} else {
    echo "Error: " . mysqli_error($con);
}

// Close connection
mysqli_close($con);
?>