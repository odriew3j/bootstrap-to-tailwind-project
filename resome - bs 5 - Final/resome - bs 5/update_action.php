<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $fullName = $_POST['fullName'];
    $gender = $_POST['gender'];
    $rank = $_POST['rank'];
    $satisfaction = $_POST['satisfaction'];
    $inquiry = $_POST['inquiry'];
    $university = $_POST['university-select'];
    $field = $_POST['reshte-select'];
    $province = $_POST['province-select'];
    $city = $_POST['city-select'];
    $period = $_POST['educational_period-select'];
    $quota = $_POST['quota'];

    // کوئری به روز رسانی
    $sql = "UPDATE person SET 
                  fullName='$fullName', gender='$gender', rank='$rank', satisfaction='$satisfaction', inquiry='$inquiry',
                  university='$university', field='$field', province='$province', city='$city', period='$period', quota='$quota' WHERE id=$id";

    // اجرای کوئری و بررسی نتیجه
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>
