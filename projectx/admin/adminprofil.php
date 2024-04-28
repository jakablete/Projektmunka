<?php
include('../session.php');
access("ADMIN");

include('../php/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $oldpassword = $_POST['oldpassword'];
    $newpassword = $_POST['newpassword'];
    $newpassword2 = $_POST['newpassword2'];

    $login_user = $_SESSION['loggedin'];
    $sql = mysqli_query($connect, "SELECT * FROM user WHERE (username = '$login_user' OR email = '$login_email')");
    $row = mysqli_fetch_assoc($sql);
    $username = $row['username'];
    if (md5($oldpassword) == $row['password']) {
        if ($newpassword == $newpassword2) {
            $set_password = md5($newpassword);
            $update = mysqli_query($connect, "UPDATE user SET password = '$set_password' WHERE username =  '$username'");
            echo "Sikeres jelszó változtatás!";
        } else {
            echo "A jelszavak nem egyeznek!";
        }
    } else {
        echo "Hibás régi jelszó!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profilom</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway|Open+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto|Oswald:300,400" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        @import url(../style/navstyle.css);
    </style>
</head>

<body>
    <nav class="navbar navbar-default navbar-expand-lg navbar-light">
        <div class="navbar-header">
            <a class="navbar-brand" href="../admin/adminkezdolap.php"><b>Admin</b> Felület</a>
            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                <span class="navbar-toggler-icon"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="../admin/felh_eltav.php">Felhasználók eltávolítása</a></li>
                <li><a href="">Üzenetek</a></li>
                <li class="active"><a href="../admin/adminprofil.php">Profilom</a></li>
            </ul>
            <ul class="nav navbar-form form-inline navbar-right ml-auto">
                <li style="float: right;text-align:right; color: black;"><a href="../logout.php">Kijelentkezés</a></li>
            </ul>
        </div>
    </nav>
    <style>
        table {
            color: #000000;
            font-family: arial, sans-serif;
            border-collapse: collapse;
            margin-left: 100px;
            width: 50%;
        }

        td,
        th {
            text-align: left;
            padding: 8px;
        }
    </style>
    <table>
        <tr>
            <th colspan="4">Profil adatok</th>
        </tr>
        <?php
        $user = mysqli_query($connect, "SELECT * FROM user WHERE username = '$_SESSION[loggedin]'");
        while ($row = mysqli_fetch_assoc($user)) {
            echo "
        <tr><td>Vezetéknév:</td><td>" . $row['lname'] . "</td></tr>
        <tr><td>Keresztnév:</td><td>" . $row['fname'] . "</td></tr>
        <tr><td>felhasználónév:</td><td>" . $row['username'] . "</td></tr>
        <tr><td>E-mail:</td><td>" . $row['email'] . "</td></tr>
        ";
        }
        ?>
        <form action="" method="post">
            <tr>
                <td>Jelszó megváltoztatása</td>
                <td><input type="password" id="oldpassword" name="oldpassword" placeholder="Régi jelszó" require></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="password" id="newpassword" name="newpassword" placeholder="Új jelszó" require></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="password" id="newpassword2" name="newpassword2" placeholder="Új jelszó ismét" require></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Change"></td>
            </tr>
        </form>
    </table>
</body>

</html>