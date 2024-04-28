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

$rendelesek = mysqli_query($con, "SELECT * FROM rendeles WHERE user_id = '$user_id' GROUP BY date ORDER BY date DESC"); // name, date, username
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin felület</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/adminrendelesek.css">
    <script>
        $(document).ready(function () {
            $(".btn-group .btn").click(function () {
                var inputValue = $(this).find("input").val();
                if (inputValue != '0') {
                    var target = $('table tr[data-status="' + inputValue + '"]');
                    $("table tbody tr").not(target).hide();
                    target.fadeIn();
                } else {
                    $("table tbody tr").fadeIn();
                }
            });

            var bs = $.fn.tooltip.Constructor.VERSION;
            var str = bs.split(".");
            if (str[0] == 4) {
                $(".label").each(function () {
                    var classStr = $(this).attr("class");
                    var newClassStr = classStr.replace(/label/g, "badge");
                    $(this).removeAttr("class").addClass(newClassStr);
                });
            }
        });
    </script>
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
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-6">
                    <h2><b>Rendeléseim</b></h2>
                </div>
            </div>
        </div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Rendelés dátuma</th>
                    <th>Megrendelő neve</th>
                    <th>Átvétel</th>
                    <th>Státusz</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($rendelesek)) {
                    while ($row = mysqli_fetch_assoc($rendelesek)) {
                        $user = mysqli_query($con, "SELECT * FROM users WHERE `id` = '$row[user_id]'");
                        $u_row = mysqli_fetch_assoc($user);
                        $datum = $row['date'];
                        $uid = $row['user_id'];
                        if ($row['aktiv'] == 3) { ?>
                            <tr data-status="1">
                                <td><?php echo $row['date']; ?></td>
                                <td><?php echo $u_row['lname'] . " " . $u_row['fname']; ?></td>
                                <td><?php if ($row['szallitas'] == 0) {
                                    echo "Bolti átvétel";
                                } else {
                                    echo "Kiszállítás";
                                } ?></td>
                                <td><span class="label label-success"><?php if($row['szallitas'] == 0) {
                                    echo 'Átvehető';
                                } else if($row['szallitas'] == 1) {
                                    echo 'Feladva a futárnak';
                                } ?></span></td>
                                <form action="./rendeleskezeles.php" method="post">
                                    <input type="hidden" name="date" value="<?php echo $datum; ?>">
                                    <input type="hidden" name="uid" value="<?php echo $uid; ?>">
                                </form>
                            </tr>
                            <?php
                        } else if ($row['aktiv'] == 2) { ?>
                                <tr data-status="2">
                                    <td><?php echo $row['date']; ?></td>
                                    <td><?php echo $u_row['lname'] . " " . $u_row['fname']; ?></td>
                                    <td><?php if ($row['szallitas'] == 0) {
                                        echo "Bolti átvétel";
                                    } else {
                                        echo "Kiszállítás";
                                    } ?></td>
                                    <td><span class="label label-warning">Feldolgozásra vár</span></td>
                                    <form action="./rendeleskezeles.php" method="post">
                                        <input type="hidden" name="date" value="<?php echo $datum; ?>">
                                        <input type="hidden" name="uid" value="<?php echo $uid; ?>">
                                    </form>
                                </tr>
                            <?php
                        } else if ($row['aktiv'] == 4) { ?>
                                    <tr data-status="3">
                                        <td><?php echo $row['date']; ?></td>
                                        <td><?php echo $u_row['lname'] . " " . $u_row['fname']; ?></td>
                                        <td><?php if ($row['szallitas'] == 0) {
                                            echo "Bolti átvétel";
                                        } else {
                                            echo "Kiszállítás";
                                        } ?></td>
                                        <td><span class="label label-danger">Törölt</span></td>
                                        <form action="./rendeleskezeles.php" method="post">
                                            <input type="hidden" name="date" value="<?php echo $datum; ?>">
                                            <input type="hidden" name="uid" value="<?php echo $uid; ?>">
                                        </form>
                                    </tr>
                            <?php
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>