<?php

// ================== ส่วน PHP Backend ==================

$conn = new mysqli("localhost", "root", "", "formdb");

$conn->set_charset("utf8");

if ($conn->connect_error) {

    die("เชื่อมต่อฐานข้อมูลไม่สำเร็จ");

}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname   = $_POST['fullname'];

    $gender     = $_POST['gender'];

    $education  = $_POST['education'];

    $experience = $_POST['experience'];

    $hobbies = "";

    if (isset($_POST['hobbies'])) {

        $hobbies = implode(",", $_POST['hobbies']);

    }

    $sql = "INSERT INTO user_data 

            (fullname, gender, hobbies, education, experience)

            VALUES ('$fullname', '$gender', '$hobbies', '$education', '$experience')";



    if ($conn->query($sql) === TRUE) {

        $message = "บันทึกข้อมูลเรียบร้อยแล้ว";

    } else {

        $message = "เกิดข้อผิดพลาดในการบันทึกข้อมูล";

    }

}

?>

<!DOCTYPE html>

<html lang="th">

<head>

<meta charset="UTF-8">

<title>ระบบบันทึกข้อมูลผู้ใช้</title>

<!-- ================== CSS ================== -->

<style>

body {

    font-family: Arial;

    background: #f0f0f0;

}

.container {

    width: 500px;

    margin: 30px auto;

    background: white;

    padding: 20px;

    border-radius: 10px;

}

label {

    font-weight: bold;

}

input, select {

    width: 100%;

    padding: 8px;

    margin: 5px 0 15px;

}

button {

    background: #2196F3;

    color: white;

    border: none;

    padding: 10px;

    width: 100%;

    border-radius: 5px;

}

.success {

    color: green;

    text-align: center;

    margin-bottom: 10px;

}

</style>

<!-- ================== JavaScript ================== -->

<script>

function validateForm() {

    let name = document.getElementById("fullname").value;

    if (name === "") {

        alert("กรุณากรอกชื่อ-นามสกุล");

        return false;

    }

    return true;

}

</script>

</head>

<body>

<div class="container">

<h2>แบบฟอร์มบันทึกข้อมูล</h2>

<?php if ($message != "") { ?>

    <div class="success"><?php echo $message; ?></div>

<?php } ?>

<form method="post" onsubmit="return validateForm()">

<!-- Text -->

<label>ชื่อ-นามสกุล</label>

<input type="text" name="fullname" id="fullname">

<!-- Radio -->

<label>เพศ</label><br>

<input type="radio" name="gender" value="ชาย"> ชาย

<input type="radio" name="gender" value="หญิง"> หญิง

<input type="radio" name="gender" value="อื่นๆ"> อื่นๆ

<br><br>

<!-- Checkbox -->

<label>งานอดิเรก</label><br>

<input type="checkbox" name="hobbies[]" value="อ่านหนังสือ"> อ่านหนังสือ

<input type="checkbox" name="hobbies[]" value="เขียนโปรแกรม"> เขียนโปรแกรม

<input type="checkbox" name="hobbies[]" value="เล่นเกม"> เล่นเกม

<br><br>

<!-- List -->

<label>ระดับการศึกษา</label>

<select name="education">

    <option value="ปวส.">ปวส.</option>

    <option value="ปริญญาตรี">ปริญญาตรี</option>

    <option value="ปริญญาโท">ปริญญาโท</option>

</select>

<!-- Scroll -->

<label>ประสบการณ์เขียนโปรแกรม (ปี)</label>

<input type="range" name="experience" min="0" max="20" value="0"

       oninput="exp.value=this.value">

<span id="exp">0</span> ปี

<br><br>

<button type="submit">บันทึกข้อมูล</button>

</form>

</div>

</body>

</html>

