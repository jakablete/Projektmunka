<!DOCTYPE html>
<html lang="en" data-theme="light">
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
        <link rel="stylesheet" href="css/styles.css">
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
                    <a href="index.php" id="logo">
                        <h1> <i class="fas fa-code" style="font-size: 20px;"></i>neve</h1>
                    </a>
                </div>
    
    
                <ul class="nav__list" id="navlinkitems">
                    <li class="nav__item">
                        <a href="#home-section" class="nav__link" id="home">Kezdőlap</a>
                    </li>
                    <li class="nav__item">
                        <a href="#about-section" class="nav__link" id="about">Rólunk</a>
                    </li>
                    <li class="nav__item">
                        <a href="./user/vasarlas.php" class="nav__link" id="service">Webshop</a>
                    </li>
                    <li class="nav__item">
                        <a href="./admin/upload.php" class="nav__link" id="service">Webshop(admin)</a>
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
                </ul>
    
            </nav>
        </header>
        <section class="hero__wrapper">
            <div class="hero__content-wrapper container">
                <h1 class="divider-on-bottom">Minden ami autókkal kapcsolatos</h1>
                <p>Úton maradni sosem volt ennyire könnyű - Kiváló szerviz és gumiabroncsok egy helyen! Vásárolj nálunk vagy foglalj online időpontot.</p>
                <div class="hero__buttons-wrapper">
                    <button class="primary__button">Időpont foglalás</button>
                    <button class="secondary__button">Kinálatunk</button>
                </div>
                <div class="hero__social-wrapper">
                    <a href="#"><i class='bx bxl-facebook-circle hero__social-icon'></i></a>
                    <a href="#"><i class='bx bxl-instagram-alt hero__social-icon' ></i></a>
                </div>
            </div>
            <div class="hero__image-wrapper">
                <img src="media/gumik.png" class="hero__image">
            </div>
        </section>
        <section class="services__wrapper">
            <div class="services__content-wrapper">
                <div class="services__headline-wrapper">
                    <h2 class="services__headline divider-on-left">Szolgáltatások</h2>
                </div>
                <p class="services__text">Legyen szó defektről, gumicseréről, olajcseréről vagy bármi féle hiba amit szívesen megnézetnél egy szakemberrel, fordulj hozzánk bizalommal. Nálunk minden elérhető egy helyen!</p>
            </div>
            <div class="cards__wrapper">
                <div class="card">
                    <h3 class="card__headline">Gumicsere</h3>
                    <p class="card__text">
                        Az autóban található folyadékokat, 
                        illetve szűrőket érdemes rendszeresen cserélni, 
                        a jármű hosszú élettartam-ának érdekében
                    </p>
                </div>
                <div class="card">
                    <h3 class="card__headline">Általános szervíz</h3>
                    <p class="card__text">
                        Kijött a jó idő és már lekéne cserélni a téli gumikat nyárira?
                        Látogass el hozzánk és segítünk!
                    </p>
                </div>
                <div class="card">
                    <h3 class="card__headline">Hiba feltárás</h3>
                    <p class="card__text">
                        Átnézzük járművedet és feltárjuk az esetleges hibáit. 
                        Ezt követően a javításról adunk egy árajánlatot
                    </p>
                </div>
            </div>
        </section>
        <section class="prices__wrapper">
            <div class="prices__content-wrapper">
                <div class="prices__headline-wrapper">
                    <h2 class="prices__headline divider-on-left">Gumival kapcsolatos áraink</h2>
                </div>
                <p class="prices__text">Foglaljon most időpontot szervizünkben, és bízza ránk autóját. Kényelmes online foglalási rendszerünkkel könnyedén megtervezheti szervizlátogatását, így nem kell vesződnie a telefonos egyeztetéssel vagy a várakozással.</p>
            </div>
            <div class="cards__wrapper">
                <div class="card">
                    <div class="card__header-wrapper divider-on-left">
                        <div class="card__header">
                            <h3 class="card__headline">Gumicsere #1</h3>
                            <p class="card__price">7500 Ft</p>
                        </div>
                    </div>
                    <div>
                        <p class="card__text">
                            Felnin lévő gumiabroncs cseréje. Gumiabroncsok állapotának ellenőrzése és kereket centírozása.
                        </p>
                    </div>
                    <div class="card__button-wrapper">
                        <button class="primary__button">Foglalás</button>
                    </div>
                </div>
                <div class="card">
                    <div class="card__header-wrapper divider-on-left">
                        <div class="card__header">
                            <h3 class="card__headline">Gumicsere #2</h3>
                            <p class="card__price">5000 Ft</p>
                        </div>
                    </div>
                    <div>
                        <p class="card__text">
                            Gumi cseréje felnire előre felszerelt esetben. 
                            Gumiabroncsok állapotának ellenőrzése és kereket centírozása.
                        </p>
                    </div>
                    <div class="card__button-wrapper">
                        <button class="primary__button">Foglalás</button>
                    </div>
                </div>
                <div class="card">
                    <div class="card__header-wrapper divider-on-left">
                        <div class="card__header">
                            <h3 class="card__headline">Defekt</h3>
                            <p class="card__price">6200 Ft</p>
                        </div>
                    </div>
                    <div>
                        <p class="card__text">
                            Defektes gumiabroncsok javítása.
                        </p>
                    </div>
                    <div class="card__button-wrapper">
                        <button class="primary__button">Foglalás</button>
                    </div>
                </div>
            </div>
        </section>
    </body>
    <footer>
        <section class="footer">
            <div class="footer__content">
                <img src="media/logo.svg">
                <p>This is a paragraph</p>
                <div class="footer__icons">
                    <a href="#"><i class='bx bxl-facebook-circle'></i></a>
                    <a href="#"><i class='bx bxl-instagram-alt' ></i></a>
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
</html>