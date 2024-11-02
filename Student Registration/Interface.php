<?php
session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="NewDesign.css">
    <title>Subjects</title>
</head>
<body>

<div class="CenterHeading">
<img src="CvsuLogo.png"
height="200" width="200">
<h1 id ="WebHeader">Cavite State University<br>
Student information System</h1>
</div>


<div class="CentertheForms">
<form id ="InterfaceRegistration"action="Interface.php" method="POST">
<h1>Register Student to Subject</h1>
<h3>Student ID: <?php echo isset($_SESSION['studentID']) ? $_SESSION['studentID'] : ''; ?></span></h3>
<h3>Student Name: <?php echo isset($_SESSION['studentName']) ? $_SESSION['studentName'] : ''; ?></span></h3>


    <label for="subject">Select Subject:</label><br>
    <select id="subject" name="subjectID[]">
        <option value="1">Mathematics</option>
        <option value="2">Science</option>
        <option value="3">English</option>
        <option value="4">History</option>
        <option value="5">Physics</option>
    </select><br><br>

    <input type="submit" name="register" value="Register">
    </select><br><br>

<?php
if(isset($_SESSION['studentID']) && isset($_SESSION['studentName'])) {
   

} else {
    echo "Session variables not set.";
}
?>

<?php
function generateEID($connection)
{
    try
    {
        $getMaxId = "SELECT MAX(E_ID) AS maxId FROM EnrolledStudents";
        $result = $connection->query($getMaxId);
        $maxIdRow = $result->fetch_assoc();
        $maxId = $maxIdRow['maxId'];
        if ($maxId == null)
        {
            $maxId = 1;
        }
        else
        {
            $maxId += 1;
        }
        return $maxId;
    } 
    finally 
    {

    }
}

if(isset($_POST['register'])) {
    $studentID = $_SESSION['studentID'];
    $subjectID = $_POST['subjectID'][0]; 
    $subId = null;

    if($subjectID == 1) 
    {
        $subId = 50;
    } 
    elseif($subjectID == 2) 
    {
        $subId = 51;
    } 
    elseif($subjectID == 3) 
    {
        $subId = 52; 
    } 
    elseif($subjectID == 4) 
    {
        $subId = 53; 
    } 
    elseif($subjectID == 5) 
    {
        $subId = 54; 
    }
    
    $conn = new mysqli('localhost', 'root', '', 'schoolrecords');

    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    } 
    else 
    {
        $checkSql = "SELECT * FROM EnrolledStudents WHERE S_ID = '$studentID' AND Sub_Id = '$subId'";
        $checkResult = $conn->query($checkSql);
        
        if ($checkResult->num_rows > 0)
        {
            echo "Student is already enrolled in this subject.";
        } 
        else
        {
            $E_ID = generateEID($conn);
            $sql = "INSERT INTO EnrolledStudents (E_ID, Sub_Id, S_ID) VALUES ('$E_ID', '$subId', '$studentID')";
        
            if ($conn->query($sql) === TRUE) {
                echo "Registration successful!";
            } else {
                echo "Error:Registration unsuccessful! ";
            }
        }
    }
    $conn->close();
}
?>
</form>

<form id ="InterfaceSubjects"action="Interface.php" method="POST">
<h1>Subjects</h1>
<table id ="InterfaceTable">
    <tr>
        <th>Subject ID</th>
        <th>Subject Name</th>
    </tr>

<?php
    $conn = new mysqli('localhost', 'root', '', 'schoolrecords');

    if ($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT Sub_Id, `Subject Name` FROM subjects";
    $result = $conn->query($sql);

    if ($result !== false && $result->num_rows > 0) 
    {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['Sub_Id'] . "</td>";
            echo "<td>" . $row['Subject Name'] . "</td>";
            echo "</tr>";
        }
    } 
    else
    {
        echo "<tr><td colspan='2'>0 results</td></tr>";
    }
    $conn->close();
?>

</table>
</form>
</div>

</select><br><br>

<div class="CentertheButtons">
<a href="StudentTable.php"  id="buttonInterface1"> Go to StudentTable</a>
<a href="Login.php"  id="buttonInterface2" >Go to back to login</a>
<a href="studentinformation.php"  id="buttonInterface3"> Go to Student Information</a>
</div>

</body>
</html>

