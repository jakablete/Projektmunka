<?php
include('../session.php');
access("ADMIN");

include ('../php/config.php');

$kat = mysqli_query($con, "SELECT * FROM kategoria");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nev = $_POST['termek_neve'];
    $kategoria = $_POST['kategoria'];
    $ar = $_POST['ar'];
    $mennyiseg = $_POST['mennyiseg'];
    $szelesseg = $_POST['szelesseg'];
    $profil = $_POST['profil'];
    $atmero = $_POST['atmero'];
    $leiras = $_POST['leiras'];

    $file_name = $_FILES['feltoltes']['name'];
    $destination = '../uploads/' . $file_name;
    $extension = pathinfo($file_name, PATHINFO_EXTENSION);
    $kep = $_FILES['feltoltes']['tmp_name'];

    if (move_uploaded_file($kep, $destination)) {
        $file_type = pathinfo($file_name, PATHINFO_EXTENSION);
        $file_size = filesize($destination);

        $image_query = "INSERT INTO `kepek` (file_name, file_type, file_size)
                    VALUES  ('$file_name', '$file_type', '$file_size')";

        if (mysqli_query($con, $image_query)) {
            $_last_imageId = mysqli_insert_id($con);

            $query = mysqli_query($con, "INSERT INTo `termekek` (nev, szelesseg, profil, atmero, kategoria_id, kep_id, ar, mennyiseg, leiras)
        VALUES ('$nev', '$szelesseg', '$profil', '$atmero', '$kategoria', '$_last_imageId', '$ar', '$mennyiseg', '$leiras')");
        }
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
            <li class="nav__item">
                    <a href="./adminlist.php" class="nav__link" id="webshopadmin">Termékek</a>
                </li>
                <li class="nav__item">
                    <a href="./upload.php" class="nav__link" id="webshopadmin">Új termék</a>
                </li>
                <li class="nav__item">
                    <a href="./rendelesek.php" class="nav__link" id="orders">Rendelések</a>
                </li>
                <li class="nav_item">
                    <a href="../logout.php" class="nav__link" style="color:red" id="logout">Kijelentkezés</a>
                </li>
            </ul>

        </nav>
    </header>
    <div class="upload-form">
        <form method="post" enctype="multipart/form-data">
            <h3>Termék feltöltése</h3>
            <div class="product-group">
                <div class="row">
                    <div class="product">
                        <input type="text" class="product_value" name="termek_neve" placeholder="Termék neve" value=""
                            required="required">
                        <select class="product_value" id="kategoria" name="kategoria" required>
                            <option value="" disabled selected hidden>Kategória</option>
                            <?php
                            while ($kat_row = mysqli_fetch_assoc($kat)) { ?>
                                <option value="<?php echo $kat_row['kategoria_id']; ?>"><?php echo $kat_row['nev'] ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="product-group">
                <div class="row">
                    <div class="product">
                        <input type="text" class="product_value" name="ar" value="" placeholder="Ár (Ft)"
                            required="required">
                        <input type="text" class="product_value" name="mennyiseg" value="" placeholder="Mennyiség (db)"
                            required="required">
                    </div>
                </div>
            </div>

            <div class="product-group">
                <div class="row">
                    <div class="product">
                        <input type="text" class="product_value" name="szelesseg" value="" placeholder="Szélesség"
                            required="required">
                        <input type="text" class="product_value" name="profil" value="" placeholder="Profilarány"
                            required="required">
                            <input type="text" class="product_value" name="atmero" value="" placeholder="Átmérő"
                            required="required">
                    </div>
                </div>
            </div>

            <div class="product-group">
                <textarea class="product_value" name="leiras" style="height: 120px;" placeholder="Leírás"></textarea>
            </div>
            <script>
                function preview() {
                    thumb.src = URL.createObjectURL(event.target.files[0]);
                }
            </script>
            <div class="product-group">
                <div class="row">
                    <div class="col">
                        <h4>Kép feltöltése: </h4>
                    </div>
                    <input type="file" id="feltoltes" onchange="preview()" name="feltoltes" style="margin-top: 10px;"
                        accept="image/*" value="" />
                    <img id="thumb" src="" width="150px" />
                </div>
            </div>
            <div class="product-group">
                <button class="btn upload" type="submit" name="upload">Termék feltöltése</button>
            </div>
        </form>
    </div>
</body>

</html>