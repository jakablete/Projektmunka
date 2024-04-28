<?php
include ('../session.php');
access("ADMIN");

include ('../php/config.php');

$rendelesek = mysqli_query($con, "SELECT * FROM rendeles GROUP BY user_id, date ORDER BY date DESC"); // name, date, username
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
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-6">
                    <h2><b>Rendelések</b></h2>
                </div>
                <div class="col-sm-6">
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-info active">
                            <input type="radio" name="status" value="0" checked="checked">Összes
                        </label>
                        <label class="btn btn-success">
                            <input type="radio" name="status" value="1"> Feldolgozott
                        </label>
                        <label class="btn btn-warning">
                            <input type="radio" name="status" value="2"> Feldolgozásra vár
                        </label>
                        <label class="btn btn-danger">
                            <input type="radio" name="status" value="3"> Törölt
                        </label>
                    </div>
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
                    <th>Megtekintés</th>
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
                                <td><span class="label label-success">Feldolgozva</span></td>
                                <form action="./rendeleskezeles.php" method="post">
                                    <input type="hidden" name="date" value="<?php echo $datum; ?>">
                                    <input type="hidden" name="uid" value="<?php echo $uid; ?>">
                                    <td><button type="submit" class="btn btn-sm manage">Megtekintés</button></td>
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
                                        <td><button type="submit" class="btn btn-sm manage">Megtekintés</button></td>
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
                                            <td><button type="submit" class="btn btn-sm manage">Megtekintés</button></td>
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