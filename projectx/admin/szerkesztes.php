<?php
include ('../session.php');
access("ADMIN");

include ('../php/config.php');

$kat = mysqli_query($con, "SELECT * FROM kategoria");

$termek_id = $_POST['termek_id'];

$termek_adat = mysqli_query($con, "SELECT * FROM termekek WHERE termek_id = '$termek_id'");
$row = mysqli_fetch_assoc($termek_adat);

if (isset($_POST['upload'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $termek_id = $_POST['termek_id'];
        $nev = $_POST['termek_neve'];
        $kategoria = $_POST['kategoria'];
        $ar = $_POST['ar'];
        $mennyiseg = $_POST['mennyiseg'];
        $szelesseg = $_POST['szelesseg'];
        $profil = $_POST['profil'];
        $atmero = $_POST['atmero'];
        $leiras = $_POST['leiras'];

        $sql = mysqli_query($con, "UPDATE termekek SET nev = '$nev', szelesseg = '$szelesseg', profil = '$profil', atmero = '$atmero',
        kategoria_id = '$kategoria', ar = '$ar', mennyiseg = '$mennyiseg', leiras = '$leiras' WHERE termek_id = '$termek_id'");

        header("location: ./adminlist.php");

    }
}

?>

<!DOCTYPE html>
<html lang="hu" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gyász szervíz</title>

    <!------google fonts link-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!------boxicons link-->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

    <!------style sheets-->
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="upload.css">
</head>

<body>
    <header>
        <nav class="nav" id="navbar">
            <ul class="nav__list" id="navlinkitems">
                <li class="nav__item" style=" position:relative; right: 1200px">
                    <a href="./adminlist.php" class="nav__link" id="back">Vissza</a>
            </ul>

        </nav>
    </header>
    <div class="upload-form">
        <form method="post" enctype="multipart/form-data">
            <h3>Termék feltöltése</h3>
            <div class="product-group">
                <div class="row">
                    <div class="product">
                        <input type="text" class="product_value" name="termek_neve" placeholder="Termék neve"
                            value="<?php echo $row['nev'] ?>" required="required">
                        <select class="product_value" id="kategoria" name="kategoria" required>
                            <option value="" disabled selected hidden>Kategória</option>
                            <?php
                            $selected = $row['kategoria_id'];
                            while ($kat_row = mysqli_fetch_assoc($kat)) {
                                if ($kat_row['kategoria_id'] == $selected) { ?>
                                    <option value="<?php echo $kat_row['kategoria_id']; ?>" selected>
                                        <?php echo $kat_row['nev']; ?>
                                    </option>
                                    <?php

                                } else {
                                    ?>
                                    <option value="<?php echo $kat_row['kategoria_id']; ?>"><?php echo $kat_row['nev'] ?>
                                    </option>
                                    <?php

                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="product-group">
                <div class="row">
                    <div class="product">
                        <input type="text" class="product_value" name="ar" value="<?php echo $row['ar'] ?>"
                            placeholder="Ár (Ft)" required="required">
                        <input type="text" class="product_value" name="mennyiseg"
                            value="<?php echo $row['mennyiseg'] ?>" placeholder="Mennyiség (db)" required="required">
                    </div>
                </div>
            </div>

            <div class="product-group">
                <div class="row">
                    <div class="product">
                        <input type="text" class="product_value" name="szelesseg"
                            value="<?php echo $row['szelesseg'] ?>" placeholder="Szélesség" required="required">
                        <input type="text" class="product_value" name="profil" value="<?php echo $row['profil'] ?>"
                            placeholder="Profilarány" required="required">
                        <input type="text" class="product_value" name="atmero" value="<?php echo $row['atmero'] ?>"
                            placeholder="Átmérő" required="required">
                    </div>
                </div>
            </div>

            <div class="product-group">
                <textarea class="product_value" name="leiras" style="height: 120px;"
                    placeholder="Leírás"><?php echo $row['leiras'] ?></textarea>
            </div>
            <div class="product-group">
                <input type="hidden" name="termek_id" value="<?php echo $termek_id ?>">
                <button class="btn upload" type="submit" name="upload">Módosítás</button>
            </div>
        </form>
    </div>
</body>

</html>