<?php
// include("../session.php");
include('../php/config.php');



// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $login_user = $_SESSION['bejelentkezett'];
//     $login_email = $_SESSION['bejelentkezett_email'];
//     $result = mysqli_query($connect, "SELECT user_id FROM user WHERE (username = '$login_user' OR email = '$login_email')");
//     $row = mysqli_fetch_assoc($result);
//     $id = $row['user_id'];
//     $termek_neve = $_POST['termek_neve'];
//     $kategoria = $_POST['kategoria'];
//     $mennyiseg = $_POST['mennyiseg'];
//     $ar = $_POST['ar'];
//     $leiras = $_POST['leiras'];
//     $feltoltes_date = date("Y-m-d h:i:s");

//     $file_name = $_FILES['feltoltes']['name'];
//     $destination = '../uploads/' . $file_name;
//     $extension = pathinfo($file_name, PATHINFO_EXTENSION);
//     $kep = $_FILES['feltoltes']['tmp_name'];

//     if (move_uploaded_file($kep, $destination)) {
//         $file_type = pathinfo($file_name, PATHINFO_EXTENSION);
//         $file_size = filesize($destination);
//         $upload_date = date('Y-m-d h:i:s');
//         $kep_leiras = "Kép a termékhez: $termek_neve";

//         $image_query = "INSERT INTO `kepek` (file_name, file_type, file_size, upload_date, kep_leiras)
//                         VALUES  ('$file_name', '$file_type', '$file_size', '$upload_date', '$kep_leiras')";

//         if (mysqli_query($connect, $image_query)) {
//             $_last_imageId = mysqli_insert_id($connect);

//             $query = "INSERT INTO `termekek` (kategoria_id, hirdeto_id, nev, leiras, mennyiseg, ar, kep_id, feltoltes_date, jovahagyva, torolve)
//                     VALUES ('$kategoria', '$id', '$termek_neve', '$leiras', '$mennyiseg', '$ar', '$_last_imageId', '$feltoltes_date', '0', '0')";

//             if (mysqli_query($connect, $query)) {
//                 header("Location: ../user/hirdeteseim.php");
//             } else {
//                 echo "Sikertelen hirdetés feladás!";
//             }
//         } else {
//             echo "Hiba történt a kép feltöltése során!";
//         }
//     } else {
//         echo "Hiba történt a kép feltöltése során!";
//     }
// }

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
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        
        <!------boxicons link-->
        <link rel="stylesheet"
        href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

        <!------style sheets-->
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="stylesheet" href="upload.css">
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
    <div class="upload-form">
        <form method="post">
            <h2>Termék feltöltése</h2>
            <div class="product-group">
                <div class="row">
                    <div class="product"><input type="text" class="product_value"  name="termek_neve" placeholder="Termék neve" value="" required="required"></div>

                    </div>
                </div>
            </div>

            <div class="product-group">
                <div class="row">
                    <div class="col"><input type="text" class="product_value" name="ar" value="" placeholder="Ár" required="required"></div>
                </div>
            </div>
            <div class="product-group">
                <textarea class="product_value"  name="leiras" style="height: 150px;" placeholder="Leírás"></textarea>
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
                    <input type="file" id="feltoltes" onchange="preview()" name="feltoltes" style="margin-top: 10px;" accept="image/*" value="" />
                    <img id="thumb" src="" width="150px"/>
                </div>
            </div>
            <div class="product-group">
                <button class="btn upload" type="submit" name="upload">Termék feltöltése</button>
            </div>
        </form>
    </div>
</body>

</html>