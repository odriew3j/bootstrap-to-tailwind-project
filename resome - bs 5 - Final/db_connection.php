<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "resome";

// ایجاد اتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// بررسی اتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>