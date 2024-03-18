<?php
include("php/config.php");

if(isset($_POST['submit'])){
    $uname = $_POST['uname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];

    // Check if email already exists
    $verify_query = mysqli_query($con, "SELECT email FROM users WHERE email='$email'");
    if(mysqli_num_rows($verify_query) != 0) {
        echo "<div class='message'>
                <p>Már fiók ehhez az emailhez!</p>
            </div> <br>";
        echo "<a href='javascript:self.history.back()'><button class='btn'>Back</button></a>";
    } else {
        // Insert user into database without hashing passwords
        $insert_query = mysqli_query($con, "INSERT INTO users(uname, email, password, repassword) VALUES ('$uname', '$email', '$password', '$repassword')");
        if($insert_query) {
            echo "<div class='message'>
                    <p>Sikeres regisztráció</p>
                </div> <br>";
            echo "<a href='login.php'><button class='btn'>Login Now</button>";
        } else {
            echo "Error: " . mysqli_error($con);
        }
    }
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
            <a href="login.php"><button>Bejelentkezés</button></a>
            <a href="register.php"><button>Regisztráció</button></a>
        </div>
    </div>
    <div class="container">
        <div class="login-box">
            <header>Regisztráció</header>
            <form action="" method="post">
                <div class="input">
                    <label for="uname"></label>
                    <input type="text" name="uname" id="uname" placeholder="Felhasználónév" required>
                </div>
                <div class="input">
                    <label for="email"></label>
                    <input type="email" name="email" id="email" placeholder="Email" required>
                </div>
                <div class="input">
                    <label for="password"></label>
                    <input type="password" name="password" id="password" placeholder="Jelszó" required>
                </div>
                <div class="input">
                    <label for="repassword"></label>
                    <input type="password" name="repassword" id="repassword" placeholder="Jelszó újra" required>
                </div>
                <div class="submit-btn">
                    <button type="submit" name="submit">Regisztráció</button>
                </div>
                <div class="bottom-content">
                    <label for="noaccount">Van már fiókom
                        <a href="login.php">Bejelentkezés</a>
                    </label>
                </div>
                
                <div class="input" type="password" for="password"></div>
            </form>
        </div>
    </div>
</body>
</html>
