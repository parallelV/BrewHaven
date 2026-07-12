<?php

$host = "sql208.infinityfree.com";
$username = "if0_42361214";
$password = "WxxNU1NBhgb9zj";
$database = "if0_42361214_brewhaven_db";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

?>