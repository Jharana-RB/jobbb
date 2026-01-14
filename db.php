<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "sql211.infinityfree.com";
$user = "if0_40902255";
$pass = "vcWEtqOYZ9J7";
$db   = "if0_40902255_kaamsathi";
$port = 3306;

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("❌ Connection failed: " . mysqli_connect_error());
}
// Optional: echo "✅ Connected successfully!";
?>

