<?php
session_start(); 
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="AdminNewDesign.css">
    <title>Admin</title>
</head>
<body>

<div class="CenterHeading">
    <img src="CvsuLogo.png" height="150" width="150">
    <h2 id="WebHeader">Cavite State University<br> Admin Information System</h2>
</div>

<h3 id="GreetUser">Admin ID: <?php echo isset($_SESSION['ProfID']) ? $_SESSION['ProfID'] : ''; ?></h3>
<h3 id="GreetUser">Welcome! Professor: <?php echo isset($_SESSION['ProfName']) ? $_SESSION['ProfName'] : ''; ?></h3>


<?php
if (isset($_SESSION['ProfID']) && isset($_SESSION['ProfName'])) 
{
    $conn = new mysqli("localhost", "root", "", "schoolrecords");

    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    }

    $ProfID = $_SESSION['ProfID'];
    $SqlSubject = "SELECT Subject FROM professor WHERE P_ID ='$ProfID'";
    $result = $conn->query($SqlSubject);

    if ($result->num_rows > 0) 
    {
        $row = $result->fetch_assoc();
        $SubjectOfProf = $row['Subject'];
        echo '<h3 id="GreetUser">Of the ' . $SubjectOfProf . ' Department</h3>';
    } 
    else 
    {
        echo "No subject found for the professor.";
    }

    $conn->close();
} 
else 
{
    echo "Session variables not set.";
}
?>


<div class = "CenterTable">
<form id="Form" action="AdminPage.php" method="POST">
<h1 id="TalbeText">Students Enrolled in your Subject</h1>
<?php
if (isset($_SESSION['ProfID']) && isset($_SESSION['ProfName'])) {
    $conn = new mysqli("localhost", "root", "", "schoolrecords");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $profID = $_SESSION['ProfID'];

    $sql = "SELECT student.S_ID, student.Name, student.Section, student.Gender, student.Age 
            FROM student
            INNER JOIN enrolledstudents ON student.S_ID = enrolledstudents.S_ID
            INNER JOIN professor ON enrolledstudents.Sub_Id = professor.SubjectID
            WHERE professor.P_ID = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $profID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table id='SubjectTable'>";
        echo "<tr><th>Student ID</th><th>Name</th><th>Section</th><th>Gender</th><th>Age</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['S_ID'] . "</td>";
            echo "<td>" . $row['Name'] . "</td>";
            echo "<td>" . $row['Section'] . "</td>";
            echo "<td>" . $row['Gender'] . "</td>";
            echo "<td>" . $row['Age'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No students found.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Session variables not set.";
}
?>
</form>

<form id="Form" action="AdminPage.php" method="POST">
<h1 id="TableText">Remove Student from Subject</h1>
<select name="studentID">
    <?php
    if (isset($_SESSION['ProfID'])) {
        $conn = new mysqli("localhost", "root", "", "schoolrecords");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $profID = $_SESSION['ProfID'];

        $sql = "SELECT student.S_ID, student.Name 
                FROM student
                INNER JOIN enrolledstudents ON student.S_ID = enrolledstudents.S_ID
                INNER JOIN professor ON enrolledstudents.Sub_Id = professor.SubjectID
                WHERE professor.P_ID = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $profID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['S_ID'] . "'>" . $row['Name'] . "</option>";
            }
        } else {
            echo "<option>No students found</option>";
        }

        $stmt->close();
    }
    ?>
</select>
<br><br>
<input type="submit" name="remove_student" value="Remove Student">
</form>

<?php
if (isset($_POST['remove_student'])) {
    $studentID = $_POST['studentID'];

    $conn = new mysqli("localhost", "root", "", "schoolrecords");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM enrolledstudents WHERE S_ID = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $studentID);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: Adminpage.php");
        exit();
    } else {
        echo "Failed to remove student.";
    }

    $stmt->close();
    $conn->close();
}
?>

</from>
</div>

<div class="CentertheButtons">
<a href="Login.php"  id="buttonInterface1" >Go to back to login</a>
</div>


</body>
</html>
