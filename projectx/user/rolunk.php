<?php

include ('../session.php');
access("USER");

include ('../php/config.php');

$user = mysqli_query($con, "SELECT id from users WHERE uname = '$_SESSION[loggedin]'");
$user_r = mysqli_fetch_array($user);

$user_id = $user_r['id'];

$cartQuery = "SELECT COUNT(*) as itemCount FROM kosar WHERE kosarbane = 0 AND user_id = ?";
if ($cartStmt = mysqli_prepare($con, $cartQuery)) {
    mysqli_stmt_bind_param($cartStmt, "i", $user_id);
    mysqli_stmt_execute($cartStmt);
    mysqli_stmt_bind_result($cartStmt, $itemCount);
    mysqli_stmt_fetch($cartStmt);
    mysqli_stmt_close($cartStmt);
} else {
    $itemCount = 0; // Default to 0 in case the query fails
}

?>

<!DOCTYPE html>
<html lang="en" data-theme="light">

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
    <link rel="stylesheet" href="../css/rolunk.css">

</head>

<body>
    <header>
        <nav class="nav" id="navbar">


            <ul class="nav__list" id="navlinkitems">
                <li class="nav__item main-item" style=" position:relative; right: 500px">
                    <span class="workspace-title"><a href="index.php" class="nav__link" id="home">Műhely</a></span>
                </li>
                <li class="nav__item">
                    <a href="./rolunk.php" class="nav__link" id="about">Rólunk</a>
                </li>
                <li class="nav__item">
                    <a href="./vasarlas.php" class="nav__link" id="service">Webshop</a>
                </li>
                <li class="nav__item">
                    <a href="./kosar.php" class="nav__link" id="cart">Kosár <span
                            class="cart-count"><?= $itemCount ?></span></a>
                </li>
                <li class="nav__item">
                    <a href="./rendeleseim.php" class="nav__link" id="orders">Rendeléseim</a>
                </li>
                <li class="nav__item">
                    <a href="./profile.php" class="nav__link" id="contact">Profilom</a>
                </li>
                <li class="nav_item">
                    <a href="../logout.php" class="nav__link" style="color:red" id="logout">Kijelentkezés</a>
                </li>
            </ul>

        </nav>
    </header>
    <section>
        <div class="about-us">
            <h3>Műhelyünkről</h3>
        </div>

        <div class="about">
            <div class="row">
                <div class="column lb">
                    <div class="topic">
                        <button id="1" class="button-27 topic_btn active" onclick="swap(this.id)">Bemutatkozás</button>
                        <button id="2" class="button-27 topic_btn" onclick="swap(this.id)">Szervízünk</button>
                        <button id="3" class="button-27 topic_btn" onclick="swap(this.id)">Webshopunk</button>
                        <button id="4" class="button-27 topic_btn" onclick="swap(this.id)">Elérhetőségek</button>
                    </div>
                </div>
                <div class="column">
                    <div class="description">
                        <p id="szoveg1" class="text">Üdvözöljük a Gumiszervízben, ahol gumiabroncsaink széles
                            választékát kínáljuk webshopunkban és helyszíni szervizünkben egyaránt. Legyen szó új
                            abroncs vásárlásról vagy szakszerű szerelésről, nálunk megtalálja a megfelelő szolgáltatást.
                            Böngésszen kényelmesen online, vagy látogasson el műhelyünkbe személyesen. Minőség és
                            megbízhatóság – minden, amire autója és Ön számíthat. Forduljon hozzánk bizalommal!</p>
                        <p id="szoveg2" class="text" style="display: none;">Szervízünk évtizedek óta biztosítja
                            ügyfeleink számára a gyors, megbízható és rugalmas kerék, illetve gumiabroncs cseréket.
                            ezen kívül még igény esetén átvizsgáljuk a kerék levétele során láthatóvá váló alkatrészeket
                            is, hogy az ügyfél az esetleges problémákról időben értesüljön.
                        </p>
                        <p id="szoveg3" class="text" style="display: none;">
                            Webshopunk széles kínálatában vásárlóink könnyedén meg tudják találni a számukra megfelelő
                            abroncsot a gumi méretének megadásával. Raktárunkban, szinte minden mértetben találhatóak
                            gumik, így tudjuk biztosítani a gyors termékfeladást az ügyfeleink számára.
                        </p>
                        <p id="szoveg4" class="text" style="display: none;">
                            Telefon: <br>
                            +36701111111 <br>
                            0674412541 <br><br>
                            E-mail: <br>
                            gumi@szerviz.hu <br><br>
                            Szervízünk címe: <br>
                            7100 Szekszárd, Ödön utca 15. <br>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <section class="footer">
            <div class="footer__content">
                <img src="media/logo.svg">
                <p>This is a paragraph</p>
                <div class="footer__icons">
                    <a href="#"><i class='bx bxl-facebook-circle'></i></a>
                    <a href="#"><i class='bx bxl-instagram-alt'></i></a>
                </div>
            </div>
            <div class="footer__content">
                <h4>Szolgáltatások</h4>
                <li><a href="#">Webshop</a></li>
                <li><a href="#">Gumicsere</a></li>
                <li><a href="#">Általános szervíz</a></li>
            </div>
            <div class="footer__content">
                <h4>Rólunk</h4>
                <li><a href="#">Cégünkről</a></li>
                <li><a href="#">Kapcsolat</a></li>
                <li><a href="#">Nyitvatartás</a></li>
            </div>
            <div class="footer__content">
                <h4>Továbbiak</h4>
                <li><a href="#">Adatkezelési tájékoztató</a></li>
                <li><a href="#">Süti tájékoztató</a></li>
                <li><a href="#">GYIK</a></li>
            </div>
        </section>
    </footer>
</body>

</html>

<script>
    function swap(id) {
        var clicked = document.getElementById(id);
        var newDescription = document.getElementById("szoveg" + id);

        var buttons = document.getElementsByClassName('topic_btn');
        for (var i = 0; i < buttons.length; i++) {
            buttons[i].classList.remove('active');
        }

        clicked.classList.add('active');

        var szovegek = document.getElementsByClassName('text');
        for (var i = 0; i < szovegek.length; i++) {
            szovegek[i].style.opacity = 0; // Az összes szöveg átlátszóságát nullázuk
            szovegek[i].style.display = "none"
        }

        newDescription.style.opacity = 1; // Az új szöveg átlátszóságát beállítjuk 1-re
        newDescription.style.display = "";
    }
</script>