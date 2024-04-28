<?php
include ('../session.php');
access("ADMIN");

include ('../php/config.php');

$datum = $_POST['date'];
$uid = $_POST['uid'];
$rendeles = mysqli_query($con, "SELECT * FROM rendeles WHERE `date` = '$datum' AND `user_id` = '$uid'");
$cimar = mysqli_query($con, "SELECT iranyitoszam, utca, hazszam, phone, szallitas, ar, aktiv FROM rendeles WHERE `date` = '$datum' AND `user_id` = '$uid' GROUP BY date");
$ca_r = mysqli_fetch_assoc($cimar);

// print_r($ca_r);
// die;


if (isset($_POST['del'])) {
    $torol = mysqli_query($con, "UPDATE rendeles SET aktiv = 4 WHERE date = '$_POST[date]' AND user_id = '$_POST[uid]'");
    header("location: ./rendelesek.php");
}
if (isset($_POST["approve"])) {
    $approve = mysqli_query($con, "UPDATE rendeles SET aktiv = 3 WHERE date = '$datum' AND user_id = '$uid'");
    header("location: ./rendelesek.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin felület</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/adminrendelesek.css">
</head>

<body>
    <header>
        <nav class="nav" id="navbar">
            <ul class="nav__list" id="navlinkitems">
                <li class="nav__item" style=" position:relative; right: 1200px">
                    <a href="./rendelesek.php" class="nav__link" id="back">Vissza</a>
            </ul>

        </nav>
    </header>
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-6">
                    <h2><b>Rendelések</b></h2>
                </div>
                <form method="post">
                    <div class="col-sm-6">
                        <div class="btn-group" data-toggle="buttons">
                            <?php if ($ca_r['aktiv'] == 2) {
                                ?>
                                <input type="hidden" name="date" value="<?php echo $datum; ?>">
                                <input type="hidden" name="uid" value="<?php echo $uid; ?>">
                                <input class="btn btn-success" type="submit" name="approve" value="Elfogad">
                                <input class="btn btn-danger" type="submit" name="del" value="Töröl">
                                <?php
                            } ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Termék</th>
                    <th>Méret</th>
                    <th>Kategória</th>
                    <th>Mennyiség</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($rendeles)) {
                    while ($row = mysqli_fetch_assoc($rendeles)) {
                        $termek = mysqli_query($con, "SELECT `t`.`nev`, `t`.`szelesseg`, `t`.`profil`, `t`.`atmero`, `t`.`mennyiseg`, `k`.`nev` AS kategoria
                        FROM `termekek` AS `t`
                        INNER JOIN `kategoria` AS `k`
                        ON `t`.`kategoria_id` = `k`.`kategoria_id`
                        WHERE `termek_id` = '$row[termek_id]'");
                        $t_row = mysqli_fetch_assoc($termek);
                        ?>
                        <tr>
                            <td><?php echo $t_row['nev']; ?></td>
                            <td><?php echo $t_row['szelesseg'] . " / " . $t_row['profil'] . " / " . $t_row['atmero']; ?></td>
                            <td><?php echo $t_row['kategoria']; ?></td>
                            <td><?php echo $row['darab'] . " db"; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td style="text-align: left;" colspan="4">Szállítási cím:
                            <?php echo $ca_r['iranyitoszam'] . ", " . $ca_r['utca'] . " " . $ca_r['hazszam'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: left;" colspan="4">Telefonszám: <?php echo $ca_r['phone'] ?></td>
                    </tr>
                    <tr>
                        <td style="text-align: left;" colspan="4">Átvétel módja: <?php if ($ca_r['szallitas'] == 0) {
                            echo 'Bolti átvétel';
                        } else if ($ca_r['szallitas'] == 1) {
                            echo 'Kiszállítás';
                        } ?></td>
                    </tr>
                    <tr>
                        <td style="text-align: left;" colspan="4">Végösszeg: <?php echo $ca_r['ar'] . " Ft" ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>