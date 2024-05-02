<?php
include 'db_connection.php';

function getOptions($table, $column, $groupBy = false)
{
    global $conn;
    $sql = "SELECT $column FROM $table";
    if ($groupBy) {
        $sql .= " GROUP BY $column";
    }
    $result = $conn->query($sql);
    $options = "";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $options .= '<option value="' . $row[$column] . '">' . $row[$column] . '</option>';
        }
    } else {
        $options = "0 results";
    }

    return $options;
}

?>

<!DOCTYPE html>
<html dir="rtl">
<head>
    <style>
        select {
            width: 200px;
            height: 35px;
            margin: 20px;
        }
    </style>
    <!-- اضافه کردن کتابخانه jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- اضافه کردن کتابخانه Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

</head>
<body>

<form action="action.php" method="post" enctype="multipart/form-data">
    <select id="university-select" name="university-select">
        <?php echo getOptions('university', 'university_name'); ?>
    </select>

    <select id="reshte-select" name="reshte-select">
        <?php echo getOptions('reshte', 'reshte_name'); ?>
    </select>

    <select id="province-select" name="province-select">
        <?php echo getOptions('data', 'province', true); ?>
    </select>

    <select id="city-select" name="city-select">
        <?php echo getOptions('data', 'city', true); ?>
    </select>

    <select id="educational_period-select" name="educational_period-select">
        <?php echo getOptions('data', 'educational_period', true); ?>
    </select>

    <br><br>

    <label for="male">مرد</label>
    <input type="radio" id="male" name="gender" value="1">
    <label for="female">زن</label>
    <input type="radio" id="female" name="gender" value="0">

    <br><br>

    <label for="fullName">نام و نام خانوادگی</label>
    <input type="text" name="fullName">

    <label for="rank">رتبه</label>
    <input type="number" name="rank">

    <br><br>

    <label for="satisfaction">ویدئو رضایت</label>
    <input style="width: 80%" type="text" name="satisfaction">

    <br><br>

    <label for="inquiry">ویدئو استعلام</label>
    <input style="width: 80%" type="text" name="inquiry">

    <br><br>

    <label for="image">عکس:</label>
    <input type="file" id="image" name="image">

    <br><br>

    <input type="submit">
</form>
<!-- Other form elements -->

<script>
    $(document).ready(function () {
        $('#university-select').select2();
        $('#reshte-select').select2();
        $('#province-select').select2();
        $('#city-select').select2();
        $('#educational_period-select').select2();
    });
</script>

</body>
</html>

<?php
$conn->close();
?>


