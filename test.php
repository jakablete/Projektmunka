<?php
session_start();

include("php/config.php");
if(!isset($_SESSION['valid'])){
    header("Location: test.php");
}

$id = $_SESSION['id'];
$query = mysqli_query($con,"SELECT * FROM users WHERE id=$id");

while($result = mysqli_fetch_assoc($query)){
    $re_uname = $result['uname'];
    $re_email = $result['email'];
    $re_id = $result['id'];
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Bejelentkezés</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p>Cégnév és logo</p>
        </div>
        <div class="rightside">
            <a href="#">Profilom</a>
            <a href="login.php"><button>Kijelentkezés</button></a>
        </div>
    </div>
    <main>
        <div class="main-box top">
            <div class="top">
                <div class="box">
                    <p>Üdvözöljük oldalunkon, <b><?php echo $re_uname; ?></b></p>
                </div>
                <div class="box">
                    <p>A felhasználóneved <b><?php echo $re_uname; ?></b></p>
                </div>
            </div>
            <div class="bottom">
                <div class="box">
                    <p>Az emailed <b><?php echo $re_email; ?></b></p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>