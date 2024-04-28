<!-- <?php
include ('connect.php');

session_start();

function access($right)
{
    if ($right == "ADMIN") {
        if (isset($_SESSION["ACCESS"]) && !$_SESSION["ACCESS"][$right]) {
            header("location: upload.php");
        }
    }

    if($right == "USER") {
        if (isset($_SESSION["ACCESS"]) && !$_SESSION["ACCESS"][$right]) {
            header("location: index.php");
        }
    }
}

$_SESSION["ACCESS"]["ADMIN"] = isset($_SESSION["access"]) && $_SESSION["access"] == '1';
$_SESSION["ACCESS"]["USER"] = isset($_SESSION["access"]) && $_SESSION["access"] == '0';

if (!isset($_SESSION['loggedin'])) {
    header("location: ../login.php");
    die();
}
?> -->