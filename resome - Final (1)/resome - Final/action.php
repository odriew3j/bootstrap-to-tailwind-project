<?php
include 'db_connection.php';

if (!file_exists('uploads')) {
    mkdir('uploads', 0777, true);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    date_default_timezone_set('Asia/Tehran');
    $image = $_FILES['image'];
    $imageName = 'image'; // نام ثابت فایل
    $randomNumber = rand(0, 999); // یک عدد تصادفی بین 0 تا 999
    $imageExt = pathinfo($image['name'], PATHINFO_EXTENSION); // پسوند فایل
    $dateTime = date('Y-m-d-H-i-s'); // تاریخ و زمان فعلی تا به لحظه
    $imageNameNew = $imageName . '-' . $randomNumber . '-' . $dateTime . '.' . $imageExt; // ایجاد نام جدید برای فایل

    $imageTmpName = $_FILES['image']['tmp_name'];
    $imageSize = $_FILES['image']['size'];
    $imageError = $_FILES['image']['error'];

    $allowed = array('jpg', 'jpeg', 'png', 'pdf');

    if (in_array($imageExt, $allowed)) {
        if ($imageError === 0) {
            if ($imageSize < 1000000) { // 1MB
                $imageDestination = 'uploads/'.$imageNameNew;
                move_uploaded_file($imageTmpName, $imageDestination);
                // ذخیره $imageDestination در پایگاه داده
            } else {
                echo "فایل شما خیلی بزرگ است!";
            }
        } else {
            echo "خطایی در آپلود فایل رخ داده است!";
        }
    } else {
        echo "شما نمی‌توانید فایل‌های این نوع را آپلود کنید!";
    }

    $fullName = $_POST['fullName'];
    $rank = $_POST['rank'];
    $satisfaction = $_POST['satisfaction'];
    $inquiry = $_POST['inquiry'];
    $university = $_POST['university-select'];
    $field = $_POST['reshte-select'];
    $province = $_POST['province-select'];
    $city = $_POST['city-select'];
    $period = $_POST['educational_period-select'];
    $gender = $_POST['gender'];

    $sql = "INSERT INTO person (fullName, rank, satisfaction, inquiry, university, field, province, city, period, gender, image) VALUES ('$fullName', '$rank', '$satisfaction', '$inquiry', '$university', '$field', '$province', '$city', '$period', '$gender', '$imageDestination')";

    if ($conn->query($sql) === TRUE) {
        echo "اطلاعات با موفقیت در پایگاه داده ذخیره شد.";
        sleep(4); // تاخیر 4 ثانیه
        header("Location: addResume.php"); // هدایت کاربر به صفحه addResume.php
        exit();
    } else {
        echo "خطا در ذخیره اطلاعات: " . $conn->error;
    }
}
?>

