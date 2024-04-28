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

$termek_id = $_POST['termekId'];

$termek = mysqli_query($con, "SELECT * FROM termekek WHERE `termek_id` = '$termek_id'");
$termek_r = mysqli_fetch_assoc($termek);

$kep = mysqli_query($con, "SELECT * FROM kepek WHERE `kep_id` = '$termek_r[kep_id]'");
$kep_r = mysqli_fetch_assoc($kep);

$kat = mysqli_query($con, "SELECT * FROM kategoria WHERE `kategoria_id` = '$termek_r[kategoria_id]'");
$kat_r = mysqli_fetch_assoc($kat);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>title</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!------style sheets-->
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../user/megtekint.css">
</head>

<body>
    <header>
        <nav class="nav" id="navbar">


            <ul class="nav__list" id="navlinkitems">
                <li class="nav__item main-item" style=" position:relative; right: 700px">
                    <span class="workspace-title"><a href="./index.php" class="nav__link" id="home">Műhely</a></span>
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
                    <a href="./profile.php" class="nav__link" id="contact">Profilom</a>
                </li>
                <li class="nav_item">
                    <a href="../logout.php" class="nav__link" style="color:red" id="logout">Kijelentkezés</a>
                </li>
            </ul>

        </nav>
    </header>
    <div class="card">
        <div class="row">
            <aside class="col-sm-5 border-right">
                <article class="gallery-wrap">
                    <div class="img-big-wrap">
                        <div> <a href="#"><img src="../uploads/<?php echo $kep_r['file_name'] ?>"></a></div>
                    </div>
                </article>
            </aside>
            <aside class="col-sm-7">
                <article class="card-body p-5">
                    <h3 class="title mb-3"><?php echo $termek_r['nev'] ?></h3>

                    <dl class="param param-feature">
                        <dt>Ár:</dt>
                        <dd><?php echo $termek_r['ar'] . " Ft / db" ?></dd>
                    </dl>
                    <dl class="item-property">
                        <dt>Leírás:</dt>
                        <dd>
                            <p><?php echo $termek_r['leiras'] ?></p>
                        </dd>
                    </dl>
                    <dl class="param param-feature">
                        <dt>Kategória:</dt>
                        <dd><?php echo $kat_r['nev'] ?></dd>
                    </dl> <!-- item-property-hor .// -->
                    <dl class="param param-feature">
                        <dt>Méret:</dt>
                        <dd><?php echo $termek_r['szelesseg'] . " / " . $termek_r['profil'] . " / " . $termek_r['atmero'] ?>
                        </dd>
                    </dl> <!-- item-property-hor .// -->
                    <dl class="param param-feature">
                        <dt>Elérhető mennyiség:</dt>
                        <dd> <?php
                        if ($termek_r['mennyiseg'] > 0) {
                            echo $termek_r['mennyiseg'] . " db";
                        } else {
                            echo "Nincs raktáron";
                        }
                        ?></dd>
                    </dl> <!-- item-property-hor .// -->

                    <hr>
                    <?php if ($termek_r['mennyiseg'] > 0): ?>
                        <form action="add_to_cart.php" method="POST">
                            <input type="hidden" name="termekId" value="<?php echo $termek_r['termek_id']; ?>">
                            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                            <!-- <input type="hidden" name="userId" value="{USER_ID_HERE}"> Replace {USER_ID_HERE} with the actual user ID -->
                            <input type="hidden" name="termekNev" value="<?php echo $termek_r['nev']; ?>">
                            <input type="hidden" name="szelesseg" value="<?php echo $termek_r['szelesseg']; ?>">
                            <input type="hidden" name="darab" value="<?php echo $termek_r['mennyiseg']; ?>">
                            <input type="hidden" name="ar" value="<?php echo $termek_r['ar']; ?>">
                            <div class="row">
                                <div class="col-sm-5">
                                    <dl class="param param-inline">
                                        <dt>Kívánt mennyiség: </dt>
                                        <dd>
                                            <select name="mennyiseg" style="width: 65px">
                                                <?php for ($i = 1; $i <= $termek_r['mennyiseg']; $i++): ?>
                                                    <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                                <?php endfor; ?>
                                            </select> db
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-lg btn-outline-primary text-uppercase">
                                <i class="fas fa-shopping-cart"></i> Add to cart
                            </button>
                        </form>
                    <?php else: ?>
                        <p>Kérjük, rendeljen emailben vagy telefonon.</p>
                        <button class="btn btn-lg text-uppercase" style="color:gray; background-color:lightgray;" disabled>
                            <i class="fas fa-shopping-cart"></i> Kosárba
                        </button>
                    <?php endif; ?>
                </article> <!-- card-body.// -->
            </aside> <!-- col.// -->
        </div> <!-- row.// -->
    </div> <!-- card.// -->


    </div>
    <!--container.//-->
</body>

</html>