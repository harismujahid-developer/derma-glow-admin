<?php
$server = "localhost:3307";
$username = "root";
$password = "";
$dbname = "derma_glow_db";

$conn = new mysqli($server, $username, $password, $dbname);

if (!$conn) {
    die("Connection is not Successful: " . mysqli_connect_error());
}
?>