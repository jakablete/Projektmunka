<?php
include ('../session.php');
access("ADMIN");
include ('../php/config.php');

$kategoria_query = mysqli_query($con, "SELECT * FROM kategoria");
$kategoria_items = [];
while ($kategoria_row = mysqli_fetch_assoc($kategoria_query)) {
    $kategoria_items[] = $kategoria_row;
}

$query = "SELECT termekek.*, kepek.file_name FROM termekek LEFT JOIN kepek ON termekek.kep_id = kepek.kep_id";

if (isset($_POST['keres']) && ($_POST['termek_neve'] != '' || $_POST['kategoria'] != '0')) {
    $termek_neve = mysqli_real_escape_string($con, $_POST['termek_neve']);
    $termek_kategoria = $_POST['kategoria'];

    $query .= " WHERE 1=1";

    if (!empty($termek_neve)) {
        $query .= " AND nev LIKE '%$termek_neve%'";
    }
    if ($termek_kategoria != '0') {
        $query .= " AND kategoria_id = '$termek_kategoria'";
    }
}
$user = mysqli_query($con, "SELECT id from users WHERE uname = '$_SESSION[loggedin]'");
$user_r = mysqli_fetch_array($user);

$query .= " ORDER BY termek_id DESC";
$termekek = mysqli_query($con, $query);
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
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webshop</title>

    <!------google fonts link-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!------boxicons link-->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

    <!------style sheets-->
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../user/buy.css">
</head>

<body>
    <?php
    include ('../php/config.php');

    if (isset($_GET['error']) && $_GET['error'] == 'alreadyInCart') {
        echo "<div id='alertBox' style='position: fixed; top: 100px; background: red; border: 1px solid #ccc; padding: 10px; z-index: 2000;'>
                Ezt a terméket már hozzáadatad egyszer a kosaradhoz
                <a href=\"vasarlas.php\" onclick='document.getElementById(\"alertBox\").style.display=\"none\";' class='button'>Bezár</a>
            </div>";

    }
    ?>
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
    <div class="search-bar" style="margin-top:100px">
        <form method="post" action="">
            <input type="text" name="termek_neve" placeholder="Keresés termék neve alapján..."
                value="<?php echo isset($_POST['termek_neve']) ? $_POST['termek_neve'] : ''; ?>" />
            <select name="kategoria">
                <option value="0">Összes kategória</option>
                <?php foreach ($kategoria_items as $item): ?>
                    <option value="<?php echo $item['kategoria_id']; ?>" <?php echo (isset($_POST['kategoria']) && $_POST['kategoria'] == $item['kategoria_id']) ? 'selected' : ''; ?>>
                        <?php echo $item['nev']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="submit" name="keres" value="Keresés" />
        </form>
    </div>
    <div class="row" style="display:flex">
        <?php
        if (isset($termekek)) {
            if (mysqli_num_rows($termekek) == '0') {
                echo '<div style="margin-top: 170px;">&nbsp;&nbsp;&nbsp;Nincs a megadott keresési feltételeknek megfelelő termék</div>';
            }
            while ($row = mysqli_fetch_assoc($termekek)) {
                $kepid = $row['kep_id'];
                $kepek = mysqli_query($con, "SELECT * FROM kepek WHERE kep_id =  '$kepid'");
                $kep_row = mysqli_fetch_assoc($kepek); ?>
                <div class="col-md-4 col-sm-4 col-xs-12 text-center">
                    <div class="panel panel-pricing" style="margin-top:200px">
                        <div class="panel-heading">
                            <i class="fa"><img src="../uploads/<?php echo $kep_row['file_name'] ?>"
                                    style="width: auto; height: 100px;" alt="" /></i>
                            <h3><?php echo $row['nev']; ?></h3>
                        </div>
                        <div class="panel-body text-center">
                            <p class="p-title">
                                <?php
                                if ($row['mennyiseg'] > 0) {
                                    echo "Elérhető mennyiség: &nbsp;" . $row['mennyiseg'] . " db";
                                } else {
                                    echo "Nincs raktáron";
                                }
                                ?>
                            </p>
                            <p class="p-title">Ár: <?php echo "&nbsp;" . $row['ar'] . " Ft/db"; ?></p>
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
                        <div class="panel-body text-center">
                            <form method="post" action="szerkesztes.php">
                                <?php $termek_id = $row['termek_id']; ?>
                                <input type="hidden" name="termek_id" value="<?php echo $termek_id; ?>">
                                <input type="submit" class="btn sub-btn" style="background-color: #0066ff" name="changeS"
                                    value="Szerkesztés">
                            </form>

                            <form method="post" action="delete_product.php">
                                <?php $termek_id = $row['termek_id']; ?>
                                <input type="hidden" name="termek_id" value="<?php echo $termek_id; ?>">
                                <input type="submit" class="btn sub-btn" style="background-color:red" name="delete"
                                    value="Törlés">
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>

</body>

</html>