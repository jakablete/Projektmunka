<?php
session_start();
include("php/config.php");
if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $result = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND password='$password' ") or die(mysqli_error($con));

    if($row = mysqli_fetch_assoc($result)){
        $_SESSION['valid'] = $row['email'];
        $_SESSION['uname'] = $row['uname'];
        $_SESSION['id'] = $row['id'];
        header("Location: test.php");
        exit;
    }else{
        echo "<div class='message'>
            <p>Hibás jelszó!</p>
            </div> <br>";
        echo "<a href='login.php'><button class='btn'>Back</button></a>";
    }
} else {
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
            <a href="login.php"><button>Bejelentkezés</button></a>
            <a href="register.php"><button>Regisztráció</button></a>
        </div>
    </div>
    <div class="container">
        <div class="login-box">
            <header>Bejelentkezés</header>
            <form action="" method="post">
                <div class="input">
                    <label for="email"></label>
                    <input type="email" name="email" id="email" placeholder="Email">
                </div>
                <div class="input">
                    <label for="password"></label>
                    <input type="password" name="password" id="password" placeholder="Jelszó">
                </div>
                <div class="bottom-content">
                    <input type="checkbox" value="remember" id="remember">
                    <label>Emlékezz rám</label>
                    <a href="#">Elfelejtett jelszó</a>
                </div>
                <div class="submit-btn">
                    <button type="submit" name="submit">Bejelentkezés</button>
                </div>
                <div class="bottom-content">
                    <label for="noaccount">Nincs még fiókom
                        <a href="register.php">Regisztráció</a>
                    </label>
                </div>
                
                <div class="input" type="password" for="password"></div>
            </form>
        </div>
    </div>
<?php } ?>
</body>
</html>
