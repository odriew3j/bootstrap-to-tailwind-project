<?php
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


include 'db_connection.php';

$fullName = ""; // اضافه کردن این خط

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $stmt = $conn->prepare("SELECT * FROM person WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo json_encode($row);
        } else {
            echo json_encode(array('error' => 'کاربر وجود ندارد'));
        }
    } else {
        echo "هیچ id ارسال نشده است";
    }
    exit();
}


?>

<!doctype html>
<html dir="rtl" lang="fa-IR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <!--  -->
    <link href="css/fonts.css" rel="stylesheet">
    <link href="css/output.css" rel="stylesheet">
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body class="overflow-x-hidden">
<form action="update_action.php" method="post" enctype="multipart/form-data">

    <header class="px-4 md:px-0 md:max-w-2xl lg:max-w-4xl xl:max-w-6xl 2xl:max-w-7xl mx-auto">
        <nav class="bg-sky-800 border-2 drop-shadow-sm p-8 my-12 w-full grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-5 rounded-2xl relative gap-4">
            <!-- Title -->
            <div class="text-xl font-bold text-white col-span-full font-family-sahel">
                بروزرسانی رزومه
            </div>

            <!-- Resume ID -->
            <div class="flex gap-3 col-span-full">
                <div class="">
                    <label class="text-white text-opacity-80 text-sm flex items-center">شناسه رزومه</label>
                    <input type="text" class="flex min-h-[37.2px] rounded-xl bg-white px-2 text-sm" id="id" name="id"
                           placeholder="شناسه رزومه را وارد کنید">
                </div>
                <div class="flex items-end">
                    <button id="ajax" type="button"
                            class="btn bg-amber-500 text-white hover:opacity-75 hover:bg-amber-500 rounded-xl flex-none px-8 h-[37.2px]">
                        جستجو
                    </button>
                </div>
            </div>

            <!--            <input type="text" id="id" name="id">-->
            <!--            <button id="ajax" type="button">دریافت اطلاعات</button>-->

            <!-- Full Name -->
            <div class="flex flex-col gap-1">
                <label class="text-white text-opacity-80 text-sm flex items-center">نام و نام خانوادگی</label>
                <input type="text" class="flex min-h-[37.2px] rounded-xl bg-white px-2 text-sm" name="fullName"
                       placeholder="ورود نام و نام خانوادگی">
            </div>

            <!-- Rank -->
            <div class="flex flex-col gap-1">
                <label class="text-white text-opacity-80 text-sm flex items-center">رتبه</label>
                <input type="text" class="flex min-h-[37.2px] rounded-xl bg-white px-2 text-sm" name="rank"
                       placeholder="رتبه دانشجو">
            </div>

            <!-- University -->
            <div class="flex flex-col gap-1">
                <label class="text-white text-opacity-80 text-sm flex items-center">دانشگاه</label>
                <input type="text" class="flex min-h-[37.2px] rounded-xl bg-white px-2 text-sm" name="university-select"
                       placeholder="نام دانشگاه را وارد نمایید">
            </div>

            <!-- Study Field -->
            <div class="flex flex-col gap-1">
                <label class="text-white text-opacity-80 text-sm flex items-center">رشته</label>
                <select class="select2 text-sm" name="reshte-select" id="studyField-select">
                    <?php echo getOptions('reshte', 'reshte_name'); ?>
                </select>
            </div>

            <!-- Province -->
            <div class="flex flex-col gap-1">
                <label class="text-white text-opacity-80 text-sm flex items-center">استان</label>
                <select class="select2 text-sm" name="province-select" id="province-select">
                    <?php echo getOptions('data', 'province', true); ?>
                </select>
            </div>

            <!-- City -->
            <div class="flex flex-col gap-1">
                <label class="text-white text-opacity-80 text-sm flex items-center">شهر</label>
                <select class="select2 text-sm" name="city-select" id="city-select">
                    <?php echo getOptions('data', 'city', true); ?>
                </select>
            </div>

            <!-- Study Period -->
            <div class="flex flex-col gap-1">
                <label class="text-white text-opacity-80 text-sm flex items-center">دوره</label>
                <select class="select2 text-sm" name="educational_period-select" id="educational_period-select">
                    <?php echo getOptions('data', 'educational_period', true); ?>
                </select>
            </div>

            <!-- Gender -->
            <div class="flex flex-col gap-1">
                <label class="text-white text-opacity-80 text-sm flex items-center">جنسیت</label>
                <div class="flex gap-3 h-full items-center bg-white rounded-xl w-full">
                    <div class="flex flex-1 rounded-xl">
                        <input type="radio" name="gender" id="male" hidden value="1"/>
                        <label for="male"
                               class="radio text-center self-center py-2 px-4 rounded-xl cursor-pointer w-full text-sm hover:opacity-75">مرد</label>
                    </div>
                    <div class="flex flex-1 rounded-xl">
                        <input type="radio" name="gender" id="female" hidden value="0"/>
                        <label for="female"
                               class="radio text-center self-center py-2 px-4 rounded-xl cursor-pointer w-full text-sm hover:opacity-75">زن</label>
                    </div>
                </div>
            </div>

            <!-- Satisfaction -->
            <div class="flex flex-col gap-1">
                <label class="text-white text-opacity-80 text-sm flex items-center">ویدیو رضایت</label>
                <input type="text" class="flex min-h-[37.2px] rounded-xl bg-white px-2 text-sm" name="satisfaction"
                       placeholder="لینک ویدیو رضایت">
            </div>

            <!-- Inquiry -->
            <div class="flex flex-col gap-1">
                <label class="text-white text-opacity-80 text-sm flex items-center">ویدیو استعلام</label>
                <input type="text" class="flex min-h-[37.2px] rounded-xl bg-white px-2 text-sm" name="inquiry"
                       placeholder="لینک ویدیو رضایت">
            </div>

            <!-- quota -->
            <div class="flex flex-col gap-1 col-span-full">
                <label class="text-white text-opacity-80 text-sm flex items-center">سهمیه</label>
                <div class="flex gap-3 h-full items-center bg-white rounded-xl w-full">
                    <div class="flex flex-1 rounded-xl">
                        <input type="radio" name="quota" id="quota-1" value="1" hidden/>
                        <label for="quota-1"
                               class="radio text-center self-center py-2 px-4 rounded-xl cursor-pointer w-full text-sm hover:opacity-75">منطقه
                            1</label>
                    </div>
                    <div class="flex flex-1 rounded-xl">
                        <input type="radio" name="quota" id="quota-2" value="2" hidden/>
                        <label for="quota-2"
                               class="radio text-center self-center py-2 px-4 rounded-xl cursor-pointer w-full text-sm hover:opacity-75">منطقه
                            2</label>
                    </div>
                    <div class="flex flex-1 rounded-xl">
                        <input type="radio" name="quota" id="quota-3" value="3" hidden/>
                        <label for="quota-3"
                               class="radio text-center self-center py-2 px-4 rounded-xl cursor-pointer w-full text-sm hover:opacity-75">منطقه
                            3</label>
                    </div>
                    <div class="flex flex-1 rounded-xl">
                        <input type="radio" name="quota" id="quota-5" value="5" hidden/>
                        <label for="quota-5"
                               class="radio text-center self-center py-2 px-4 rounded-xl cursor-pointer w-full text-sm hover:opacity-75">5%</label>
                    </div>
                    <div class="flex flex-1 rounded-xl">
                        <input type="radio" name="quota" id="quota-25" value="25" hidden/>
                        <label for="quota-25"
                               class="radio text-center self-center py-2 px-4 rounded-xl cursor-pointer w-full text-sm hover:opacity-75">25%</label>
                    </div>
                </div>
            </div>


            <!-- Photo -->
            <!--            <div class="flex flex-col gap-1 col-span-full">-->
            <!--                <label class="text-white text-opacity-80 text-sm flex items-center">عکس دانشجو</label>-->
            <!--                <div class="container mx-auto h-full flex flex-col justify-center items-start">-->
            <!--                    <div class="flex justify-start w-full lg:w-1/2 2xl:w-2/5 lg:pe-[10px]">-->
            <!---->
            <!--                        <div class="border bg-white border-gray-300 rounded-r-xl flex items-center flex-1">-->
            <!--                            <span id="multi-upload-text" class="p-2"></span>-->
            <!--                            <button id="multi-upload-delete" class="hidden" onclick="removeMultiUpload()">-->
            <!--                                <svg xmlns="http://www.w3.org/2000/svg" class="fill-current text-red-700 w-3 h-3"-->
            <!--                                     viewBox="0 0 320 512">-->
            <!--                                    <path-->
            <!--                                            d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z" />-->
            <!--                                </svg>-->
            <!--                            </button>-->
            <!--                        </div>-->
            <!---->
            <!--                        <div id="multi-upload-button"-->
            <!--                             class="font-family-sahel w-min sm:w-auto inline-flex items-center px-4 py-2 bg-amber-500 border border-bg-amber-500 rounded-l-xl cursor-pointer text-sm text-white tracking-widest hover:opacity-75 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">-->
            <!--                            جهت آپلود عکس کلیک کنید-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                    <input type="file" id="multi-upload-input" class="hidden" name="image" />-->
            <!--                    <div id="images-container" class="mt-4"></div>-->
            <!--                </div>-->
            <!--            </div>-->

            <!-- Submit -->
            <div class="flex justify-end col-span-full mt-4">
                <button type="submit"
                        class="btn bg-amber-500 text-white hover:opacity-75 hover:bg-amber-500 rounded-xl flex-none px-8 w-32"
                        id="">
                    ثبت اطلاعات
                </button>
            </div>

        </form>

        <form action="delete_action.php" method="post" class="col-span-full">
            <input type="hidden" name="hidden_id">
            <div class="flex justify-end col-span-full">
                <button type="submit"
                        class="btn bg-red-500 text-white hover:opacity-75 hover:bg-red-500 rounded-xl flex-none px-8 w-32">
                    حذف رکورد
                </button>
            </div>
        </form>

</nav>
</header>
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- App Js -->
<!-- <script src="js/app.js"></script> -->
<script>
    window.onload = function () {
        var element = document.getElementById("successMessage");
        if (!element.classList.contains("hidden")) {
            setTimeout(function () {
                element.classList.add("hidden");
            }, 3000); // 3000 milliseconds = 3 seconds
        }
    };
    $(document).ready(function () {
        $('#university-select').select2({
            placeholder: "دانشگاه محل تحصیل",
        });
        $('#studyField-select').select2({
            placeholder: "رشته دانشجو",
        });
        $('#province-select').select2({
            placeholder: "استان محل تحصیل",
        });
        $('#city-select').select2({
            placeholder: "شهر محل تحصیل",
        });
        $('#educational_period-select').select2({
            placeholder: "نوع دوره تحصیلی",
        });
    });

    // //all ids and some classes are importent for this script
    //
    // multiUploadButton = document.getElementById("multi-upload-button");
    // multiUploadInput = document.getElementById("multi-upload-input");
    // imagesContainer = document.getElementById("images-container");
    // multiUploadDisplayText = document.getElementById("multi-upload-text");
    // multiUploadDeleteButton = document.getElementById("multi-upload-delete");
    //
    // multiUploadButton.onclick = function () {
    //     multiUploadInput.click(); // this will trigger the click event
    // };
    //
    // multiUploadInput.addEventListener('change', function (event) {
    //
    //     if (multiUploadInput.files) {
    //         let files = multiUploadInput.files;
    //
    //         // show the text for the upload button text filed
    //         multiUploadDisplayText.innerHTML = files.length + ' فایل انتخاب شده';
    //
    //         // removes styles from the images wrapper container in case the user readd new images
    //         imagesContainer.innerHTML = '';
    //         imagesContainer.classList.remove("w-full", "grid", "grid-cols-1", "sm:grid-cols-2", "md:grid-cols-3", "lg:grid-cols-4", "gap-4");
    //
    //         // add styles to the images wrapper container
    //         imagesContainer.classList.add("w-full", "grid", "grid-cols-1", "sm:grid-cols-2", "md:grid-cols-3", "lg:grid-cols-4", "gap-4");
    //
    //         // the delete button to delete all files
    //         multiUploadDeleteButton.classList.add("z-100", "p-2", "my-auto");
    //         multiUploadDeleteButton.classList.remove("hidden");
    //
    //         Object.keys(files).forEach(function (key) {
    //
    //             let file = files[key];
    //
    //             // the FileReader object is needed to display the image
    //             let reader = new FileReader();
    //             reader.readAsDataURL(file);
    //             reader.onload = function () {
    //
    //                 // for each file we create a div to contain the image
    //                 let imageDiv = document.createElement('div');
    //                 imageDiv.classList.add("h-64", "mb-3", "w-full", "p-3", "rounded-lg", "bg-cover", "bg-center");
    //                 imageDiv.style.backgroundImage = 'url(' + reader.result + ')';
    //                 imagesContainer.appendChild(imageDiv);
    //             }
    //         })
    //     }
    // })
    //
    // function removeMultiUpload() {
    //     imagesContainer.innerHTML = '';
    //     imagesContainer.classList.remove("w-full", "grid", "grid-cols-1", "sm:grid-cols-2", "md:grid-cols-3", "lg:grid-cols-4", "gap-4");
    //     multiUploadInput.value = '';
    //     multiUploadDisplayText.innerHTML = '';
    //     multiUploadDeleteButton.classList.add("hidden");
    //     multiUploadDeleteButton.classList.remove("z-100", "p-2", "my-auto");
    // }

    $(document).ready(function () {
        $("#ajax").on('click', function (event) {
            event.preventDefault();
            var id = $("#id").val();
            $.ajax({
                url: window.location.pathname,
                type: 'post',
                data: {id: id},
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.error) {
                        alert(data.error);
                    } else {
                        $("input[name='fullName']").val(data.fullName);
                        $("input[name='id']").val(data.id);
                        $("input[name='hidden_id']").val(data.id);
                        $("input[name='rank']").val(data.rank);
                        $("input[name='university-select']").val(data.university);
                        $("input[name='satisfaction']").val(data.satisfaction);
                        $("input[name='inquiry']").val(data.inquiry);
                        $("input[name='gender'][value='" + data.gender + "']").prop('checked', true);
                        $("input[name='quota'][value='" + data.quota + "']").prop('checked', true);
                        $("#reshte-select").val(data.field).trigger('change');
                        $("#province-select").val(data.province).trigger('change');
                        $("#city-select").val(data.city).trigger('change');
                        $("#educational_period-select").val(data.period).trigger('change');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });
    });

</script>
</body>

</html>

<?php
$conn->close();
?>
