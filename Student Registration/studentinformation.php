<?php
session_start(); 
?>
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
<form id="StudentInformation" action="studentinformation.php" method="POST">
    <?php
    if (isset($_SESSION['studentID'])) {
        $studentID = $_SESSION['studentID'];
        $conn = new mysqli("localhost", "root", "", "schoolrecords");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT S_ID, Name, Section, Gender, Age FROM student WHERE S_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $studentID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo '<label for="S_ID">Student ID:</label><br>';
            echo '<input type="text" id="S_ID" name="S_ID" value="' . $row['S_ID'] . '" readonly><br>';
            echo '<label for="Name">Name:</label><br>';
            echo '<input type="text" id="Name" name="Name" value="' . $row['Name'] . '" readonly><br>';
            echo '<label for="Section">Section:</label><br>';
            echo '<input type="text" id="Section" name="Section" value="' . $row['Section'] . '" readonly><br>';
            echo '<label for="Gender">Gender:</label><br>';
            echo '<input type="text" id="Gender" name="Gender" value="' . $row['Gender'] . '" readonly><br>';
            echo '<label for="Age">Age:</label><br>';
            echo '<input type="text" id="Age" name="Age" value="' . $row['Age'] . '" readonly><br>';
        } else {
            echo "No student found.";
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</form>
</div>

<a href="Interface.php" class="buttonStudent">Go to Interface</a>

</body>