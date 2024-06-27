<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// offline
$servername = "localhost";
$username = "";
$password = "";
$dbname = "POST";

// online
// $servername = "localhost";
// $username = "securenavy_sntuser";
// $password = "S&3xf4KS&Hj;";
// $dbname = "securenavy_snt";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

?>