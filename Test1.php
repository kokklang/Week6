<?php

// ================== PHP : เชื่อมต่อ MySQL ==================

$host = "localhost";

$user = "root";

$pass = "";

$dbname = "studentdb";

$conn = new mysqli($host, $user, $pass);

$conn->set_charset("utf8");

if ($conn->connect_error) {

    die("เชื่อมต่อ MySQL ไม่สำเร็จ");

}

// ================== สร้างฐานข้อมูล ==================

$conn->query("CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4");

$conn->select_db($dbname);

// ================== สร้างตาราง ==================

$conn->query("

CREATE TABLE IF NOT EXISTS students (

    id INT AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(100),

    age INT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

)

");

// ================== บันทึกข้อมูล ==================

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];

    $age  = $_POST['age'];

    $conn->query("INSERT INTO students (name, age) VALUES ('$name', '$age')");

}

// ================== ดึงข้อมูล ==================

$result = $conn->query("SELECT * FROM students");

// ================== ตัวแปรทั่วไป ==================

$title = "ตารางนักเรียน";

$date  = date("d/m/Y");

?>

<!DOCTYPE html>

<html lang="th">

<head>

<meta charset="UTF-8">

<title><?php echo $title; ?></title>

<!-- ================== CSS ================== -->

<style>

body {

    font-family: Arial, sans-serif;

    background-color: #fdfefe;

    text-align: center;

    padding-top: 30px;

    color: #2c3e50;

}

h2 {

    color: #1f618d;

}

form {

    margin-bottom: 20px;

}

input {

    padding: 8px;

    margin: 5px;

}

button {

    padding: 8px 15px;

    background-color: #2980b9;

    color: white;

    border: none;

    border-radius: 5px;

}

table {

    margin: 0 auto;

    border-collapse: collapse;

    width: 60%;

}

th, td {

    border: 1px solid #2980b9;

    padding: 10px;

    text-align: center;

}

th {

    background-color: #2980b9;

    color: white;

}

tr:nth-child(even) {

    background-color: #d6eaf8;

}

tr:hover {

    background-color: #aed6f1;

    cursor: pointer;

}

footer {

    margin-top: 25px;

    color: #7f8c8d;

}

</style>

<!-- ================== JavaScript ================== -->

<script>

function showStudentInfo(name, age) {

    alert("นักเรียน: " + name + "\nอายุ: " + age + " ปี");

}

</script>

</head>

<body>

<h2><?php echo $title; ?></h2>

<!-- ================== ฟอร์มเพิ่มข้อมูล ================== -->

<form method="post">

    <input type="text" name="name" placeholder="ชื่อนักเรียน" required>

    <input type="number" name="age" placeholder="อายุ" required>

    <button type="submit">บันทึกข้อมูล</button>

</form>

<!-- ================== ตารางข้อมูล ================== -->

<table>

<tr>

    <th>ลำดับ</th>

    <th>ชื่อ</th>

    <th>อายุ</th>

</tr>

<?php

$no = 1;

while ($row = $result->fetch_assoc()):

?>

<tr onclick="showStudentInfo('<?php echo $row['name']; ?>','<?php echo $row['age']; ?>')">

    <td><?php echo $no++; ?></td>

    <td><?php echo $row['name']; ?></td>

    <td><?php echo $row['age']; ?></td>

</tr>

<?php endwhile; ?>

</table>

<footer>📅 วันที่: <?php echo $date; ?></footer>

</body>

</html>

