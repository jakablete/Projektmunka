<?php
include("php/config.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['login'])) {
    $uname = $_POST['uname'];  
    $password = $_POST['password'];

    $password_md5 = md5($password);

    $user = mysqli_query($con, "SELECT * FROM users WHERE (`uname` = '$uname' AND `password` = '$password_md5' AND `admin` = 0)");
    $u_row = mysqli_fetch_assoc($user);

    $admin = mysqli_query($con, "SELECT * FROM users WHERE (`uname` = '$uname' AND `password` = '$password_md5' AND `admin` = 1)");
    $a_row = mysqli_fetch_assoc($admin);

    $ucount = mysqli_num_rows($user);
    $acount = mysqli_num_rows($admin);

    if($acount == 1) {
        $_SESSION['loggedin'] = $uname;
        $_SESSION['user_id'] = $u_row['id'];
        $_SESSION['access'] = 1;
        $error = "";
        header("location: ./admin/upload.php");
    } else if($ucount == 1) {
        $_SESSION['loggedin'] = $uname;
        $_SESSION['user_id'] = $a_row['id'];
        $_SESSION['access'] = 0;
        $error = "";
        header("location: ./user/index.php");
    } else {
        $error = "Hibás felhasználónév vagy jelszó";
    }


    // $stmt = $con->prepare("SELECT * FROM users WHERE uname = ? AND password = ?");
    // $stmt->bind_param("ss", $uname, $password_md5);
    // $stmt->execute();
    // $result = $stmt->get_result();
    // $user = $result->fetch_assoc();

    // if ($user) {
    //     $_SESSION['user_id'] = $user['id'];
    //     $_SESSION['user_name'] = $user['uname'];

    //     header("Location: index.php");
    //     exit;
    // } else {
    //     $error = "Hibás felhasználónév vagy jelszó!";
    // }
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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
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
            <header>Bejelentkezés</header>
            <form action="" method="post">
                <div class="input">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="uname" id="uname" placeholder="Felhasználónév" required>
                </div>
                <div class="input">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" id="password" placeholder="Jelszó">
                </div>
                <div class="bottom-content">
                    <input type="checkbox" value="remember" id="remember">
                    <label>Emlékezz rám</label>
                    <a href="#">Elfelejtett jelszó</a>
                </div>
                <div class="submit-btn">
                    <button type="submit" name="login">Bejelentkezés</button>
                </div>
                <div class="bottom-content">
                    <label for="noaccount">Nincs még fiókom
                        <a href="register.php">Regisztráció</a>
                    </label>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
