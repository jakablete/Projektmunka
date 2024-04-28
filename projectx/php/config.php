<?php
$host = "localhost";  
$user = "root";
$password = '';
$db_name = "projektmunka";  
  
$con = mysqli_connect($host, $user, $password, $db_name);  
if(mysqli_connect_error()) {  
    die("Nem sikerült csatlakozni az adatbázishoz: ". mysqli_connect_error());  
}
?>