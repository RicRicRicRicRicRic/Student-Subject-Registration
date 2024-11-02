<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="NewDesign.css">
    <title>Login</title>
</head>
<body>
<div class="CenterHeading">
<img src="CvsuLogo.png"
height="200" width="200">
<h1 id ="WebHeader">Cavite State University<br>
Student information System</h1>
</div>

<div class="CentertheForms">
<form id ="RegisterStudent"  method="POST">
    <label for="S_ID">Student ID:</label><br>
    <input type="number" id="S_ID" name="S_ID" required><br>
    <label for="Name">Name:</label><br>
    <input type="text" id="Name" name="Name" required><br>
    <label for="Section">Section:</label><br>
    <select id="Section" name="Section">
        <option value="BSCS2-1">BSCS2-1</option>
        <option value="BSCS2-2">BSCS2-2</option>
        <option value="BSCS2-3">BSCS2-3</option>
    </select><br>
    <label for="Gender">Gender:</label><br>
    <select id="Gender" name="Gender">
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
    </select><br>
    <label for="Age">Age:</label><br>
    <input type="number" id="Age" name="Age" required><br>
    <input type="submit" name="register_student" value="Register">
    <section><br></br>


<?php
if (isset($_POST['register_student'])) {
    $S_ID = $_POST['S_ID'];
    $Name = $_POST['Name'];
    $Section = $_POST['Section'];
    $Gender = $_POST['Gender'];
    $Age = $_POST['Age'];
    $AccessLevel = 'Student';

    $conn = new mysqli("localhost", "root", "", "schoolrecords");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO student (S_ID, Name, Section, Gender, Age, AccessLevel) VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssis", $S_ID, $Name, $Section, $Gender, $Age, $AccessLevel);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Student registered successfully.";
    } else {
        echo "Failed to register student.";
    }

    $stmt->close();
    $conn->close();
}
?>

</form>
</div>

<a href="Interface.php" class="buttonStudent">Go to Interface</a>

</body>
</html>

