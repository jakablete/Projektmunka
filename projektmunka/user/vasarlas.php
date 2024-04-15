<?php
// include("../session.php");
include('../php/config.php');



// $login_user = $_SESSION['bejelentkezett'];
// $login_email = $_SESSION['bejelentkezett_email'];
// $login = mysqli_query($connect, "SELECT user_id FROM user WHERE (username = '$login_user' OR email = '$login_email')");
// $login_row = mysqli_fetch_assoc($login);
// $login_id = $login_row['user_id'];
// $termekek = mysqli_query($connect, "SELECT * FROM termekek WHERE hirdeto_id != '$login_id' AND jovahagyva = '1' AND torolve = '0' ORDER BY termek_id DESC");
// $kepek = mysqli_query($connect, "SELECT * FROM kepek INNER JOIN termekek WHERE kepek.kep_id = termekek.kep_id");
// $kep_row = mysqli_fetch_assoc($kepek);


// if (isset($_POST['keres'])) {
//     $termek_neve = $_POST['termek_neve'];
//     $termekek = mysqli_query($connect, "SELECT * FROM termekek
//                                             WHERE hirdeto_id != '$login_id'
//                                             AND jovahagyva = '1'
//                                             AND torolve = '0'
//                                             AND (nev LIKE '%$termek_neve%')
//                                             ORDER BY termek_id DESC");

//     $kepek = mysqli_query($connect, "SELECT * FROM kepek INNER JOIN termekek WHERE kepek.kep_id = termekek.kep_id");
//     $kep_row = mysqli_fetch_assoc($kepek);

//     if (isset($_POST['kategoria']) && $_POST['kategoria'] != '0') {
//         $termek_kategoria = $_POST['kategoria'];
//         $termekek = mysqli_query($connect, "SELECT * FROM termekek
//                                             WHERE hirdeto_id != '$login_id'
//                                             AND jovahagyva = '1'
//                                             AND torolve = '0'
//                                             AND (nev LIKE '%$termek_neve%')
//                                             AND (kategoria_id = '$termek_kategoria')
//                                             ORDER BY termek_id DESC");
//         $kepek = mysqli_query($connect, "SELECT * FROM kepek INNER JOIN termekek WHERE kepek.kep_id = termekek.kep_id");
//         $kep_row = mysqli_fetch_assoc($kepek);
//     }
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gyász szervíz</title>

        <!------google fonts link-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        
        <!------boxicons link-->
        <link rel="stylesheet"
        href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

        <!------style sheets-->
        <link rel="stylesheet" href="../css/styles.css">
    </head>
    <body>
        <header>
            <button class="nav-toggle">
                <span class="hamburger"></span>
            </button>
            <div class="smalllogo">
                <a href="#welcome-section" class="logolink">
                    <h2> <i class="fas fa-code"></i> műhely neve</h2>
                </a>
            </div>
    
            <nav class="nav" id="navbar">
                <div class="logo">
                    <a href="../index.php" id="logo">
                        <h1> <i class="fas fa-code" style="font-size: 20px;"></i>neve</h1>
                    </a>
                </div>
    
    
                <ul class="nav__list" id="navlinkitems">
                    <li class="nav__item">
                        <a href="../index.php" class="nav__link" id="home">Kezdőlap</a>
                    </li>
                    <li class="nav__item">
                        <a href="#about-section" class="nav__link" id="about">Rólunk</a>
                    </li>
                    <li class="nav__item">
                        <a href="/projektmunka/user/vasarlas.php" class="nav__link" id="service">Webshop</a>
                    </li>
                    <li class="nav__item">
                        <a href="./upload.php" class="nav__link" id="service">Webshop(admin)</a>
                    </li>
                    <li class="nav__item">
                        <a href="#javítás-section" class="nav__link" id="work">Javítás</a>
                    </li>
    
                    <li class="nav__item">
                        <a href="#contacts-section" class="nav__link" id="contact">Elérhetőségeink</a>
                    </li>
                    <li class="nav__item">
                        <a href="#profile-section" class="nav__link" id="contact">Profilom</a>
                    </li>
                    <li class="nav_item">
                        <a href="../logout.php" class="nav__link" style="color:red" id="logout">Kijelentkezés</a>
                    </li>
                </ul>
    
            </nav>
        </header>
    <form method="post">
        <div class="container-fluid">
        </div>
        <section class="search-sec">
            <div class="container">
                <form method="post" novalidate="novalidate">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-12 p-0">
                                    <input type="text" name="termek_neve" class="form-control search-slt" placeholder="Termék neve" value="<?php if (isset($_POST['termek_neve'])) {
                                                                                                                                                echo $_POST['termek_neve'];
                                                                                                                                            } ?>">
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-12 p-0">
                                    <select class="form-control search-slt" name="kategoria" id="kategoria">
                                        < <option value="0">Mind</option>
                                            <?php
                                            while ($kat_row = mysqli_fetch_assoc($kat_all)) {
                                                if ($kat_row['kategoria_id'] == $_POST['kategoria']) { ?>
                                                    <option value="<?php echo $kat_row['kategoria_id']; ?>" selected><?php echo $kat_row['nev']; ?></option>
                                                <?php
                                                } else { ?>
                                                    <option value="<?php echo $kat_row['kategoria_id']; ?>"><?php echo $kat_row['nev']; ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-12 p-0">
                                    <button type="submit" name="keres" class="btn wrn-btn" style="background-color: #3f9b3f; color: white">Keresés</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <section>
            <div class="container">
                <div class="row">
                    <?php
                    if (isset($termekek)) {
                        if (mysqli_num_rows($termekek) == '0') {
                            echo "&nbsp &nbsp &nbsp Nincs a megadott keresési feltételeknek megfelelő termék";
                        }
                        while ($row = mysqli_fetch_assoc($termekek)) {
                            $hirdeto_id = $row['hirdeto_id'];
                            $hirdeto = mysqli_query($connect, "SELECT lname, fname FROM user WHERE user_id = '$hirdeto_id'");
                            $hirdeto_row = mysqli_fetch_assoc($hirdeto);
                            $hirdeto_name = $hirdeto_row['lname'] . ' ' . $hirdeto_row['fname'];
                            $kepid = $row['kep_id'];
                            $kepek = mysqli_query($connect, "SELECT * FROM kepek WHERE kep_id =  '$kepid'");
                            $kep_row = mysqli_fetch_assoc($kepek); ?>
                            <div class="col-md-4 col-sm-4 col-xs-12 text-center">
                                <div class="panel panel-pricing">
                                    <div class="panel-heading">
                                        <i class="fa"><img src="../uploads/<?php echo $kep_row['file_name'] ?>" style="width: auto; height: 100px;" alt="" /></i>
                                        <h3><?php echo $row['nev']; ?></h3>
                                    </div>
                                    <div class="panel-body text-center">
                                        <p class="p-title">Hirdető neve: &nbsp; <?php echo $hirdeto_name; ?></p>
                                        <p class="p-title">Elérhető mennyiség: &nbsp;
                                            <?php if ($row['kategoria_id'] == 1 || $row['kategoria_id'] == 2) {
                                                echo $row['mennyiseg'] . " kg";
                                            } else if ($row['kategoria_id'] == 3 || $row['kategoria_id'] == 4) {
                                                echo $row['mennyiseg'] . " üveg";
                                            } else if ($row['kategoria_id'] == 5 || $row['kategoria_id'] == 6) {
                                                echo $row['mennyiseg'] . " liter";
                                            } else {
                                                echo $row['mennyiseg'] . " db";
                                            } ?></p>
                                        <p class="p-title">Ár/<?php if ($row['kategoria_id'] == 1 || $row['kategoria_id'] == 2) {
                                                                    echo "kg: &nbsp;" . $row['ar'] . " Ft";
                                                                } else if ($row['kategoria_id'] == 3 || $row['kategoria_id'] == 4) {
                                                                    echo "üveg: &nbsp;" . $row['ar'] . " Ft";
                                                                } else if ($row['kategoria_id'] == 5 || $row['kategoria_id'] == 6) {
                                                                    echo "liter: &nbsp;" . $row['ar'] . " Ft";
                                                                } else {
                                                                    echo "db: &nbsp;" . $row['ar'] . " Ft";
                                                                } ?></p>
                                    </div>
                                    <?php
                                    $maxLength = 18;

                                    if (isset($row['leiras'])) {
                                        $leiras = $row['leiras'];
                                        if (strlen($leiras) > $maxLength) {
                                            $shortDescription = substr($leiras, 0, $maxLength);
                                            $shortDescription .= '...';
                                        } else {
                                            $shortDescription = $leiras;
                                        }
                                    }
                                    ?>
                                    <div class="panel-body text-center">
                                        <p class="p-info">Leírás: &nbsp; <?php echo $shortDescription; ?></p>
                                    </div>
                                    <?php $termek_id = $row['termek_id']; ?>
                                    <div class="panel-body text-center">
                                        <form method="post" action="../user/veglegesit.php">
                                            <input type="hidden" name="termekId" value="<?php echo $termek_id; ?>">
                                            <input type="submit" class="btn sub-btn" name="szerk" id="szerk" value="Megtekintés">
                                        </form>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>


                </div>

            </div>
        </section>
    </form>
</body>

</html>