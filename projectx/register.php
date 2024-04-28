<?php
include("php/config.php");

if (isset($_POST['register'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $uname = $_POST['uname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];
    
    $stmt = $con->prepare("SELECT uname, email FROM users WHERE uname = ? OR email = ?");
    $stmt->bind_param("ss", $uname, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row["uname"] === $uname) {
                $error = "Ez a felhasználónév már foglalt!";
                break;
            } else if ($row["email"] === $email) {
                $error = "Ezen az email címen már van fiók regisztrálva!";
                break;
            }
        }
    }

    if (!isset($error)) {
        if ($password === $repassword) {
            $password = md5($password);
            $stmt = $con->prepare("INSERT INTO users (uname, lname, fname, email, password) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $uname, $lname, $fname, $email, $password);
            if ($stmt->execute()) {
                header("Location: ./login.php");
                exit;
            } else {
                $error = "Hiba történt a regisztráció során.";
            }
        } else {
            $error = "A megadott jelszavak nem egyeznek!";
        }
    }

    if (isset($error)) {
        // Handle error: log it, or display it on the registration page.
    }

    $con->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Regisztáció</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p>Álomgumi</p>
        </div>
        <div class="rightside">
            <a href="login.php"><button>Bejelentkezés</button></a>
            <a href="register.php"><button>Regisztráció</button></a>
        </div>
    </div>
    <div class="error">
        <?php if (!empty($error)): ?>
            <p style="color:white; background-color:red; border-radius:10px; padding: 10px; width:30%"><?= $error ?></p>
        <?php endif; ?>
    </div>
    <div class="container">
        <div class="login-box">
            <header>Regisztráció</header>
            <form action="" method="post">
                <div class="input">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="fname" id="fname" placeholder="Vezetéknév" required>
                </div>
                <div class="input">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="lname" id="lname" placeholder="Keresztnév" required>
                </div>
                <div class="input">
                    <i class="fa-regular fa-user"></i>
                    <input type="text" name="uname" id="uname" placeholder="Felhasználónév" required>
                </div>
                <div class="input">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="email" id="email" placeholder="Email" required>
                </div>
                <div class="input">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" id="password" placeholder="Jelszó" required>
                </div>
                <div class="input">
                    <i class="fa-solid fa-repeat"></i>
                    <input type="password" name="repassword" id="repassword" placeholder="Jelszó újra" required>
                </div>
                <div class="submit-btn">
                    <button type="submit" name="register">Regisztráció</button>
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
