<?php
session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="NewDesign.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subjects Enrolled by Student</title>
</head>
<body>

<div class="CenterHeading">
    <img src="CvsuLogo.png" height="200" width="200">
    <h1 id="WebHeader">Cavite State University<br>Student information System</h1>
</div>

<div class="StudentCenter">
    <form id="SubjectForm" action="StudentTable.php" method="POST">
        <h2>Subjects Enrolled by Student</h2>

        <h3>Student ID: <?php echo isset($_SESSION['studentID']) ? $_SESSION['studentID'] : ''; ?></span></h3>
        <h3>Student Name: <?php echo isset($_SESSION['studentName']) ? $_SESSION['studentName'] : ''; ?></span></h3>

<?php
if(isset($_SESSION['studentID']) && isset($_SESSION['studentName'])) {

} else {
    echo "Session variables not set.";
}
?>
        
        <table id="SubjectTable">
            <tr>
                <th>Subject ID</th>
                <th>Subject Name</th>
            </tr>

            <?php
            
            if(isset($_SESSION['studentID']) && isset($_SESSION['studentName'])) {
                $studentID = $_SESSION['studentID'];
                $studentName = $_SESSION['studentName'];
                $conn = new mysqli("localhost", "root", "", "schoolrecords");
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $sql = "SELECT subjects.Sub_Id, subjects.`Subject Name`
                        FROM EnrolledStudents
                        INNER JOIN subjects ON EnrolledStudents.Sub_Id = subjects.Sub_Id
                        WHERE EnrolledStudents.S_ID = $studentID";
                $result = $conn->query($sql);

                if ($result !== false && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['Sub_Id'] . "</td>";
                        echo "<td>" . $row['Subject Name'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>Not Enrolled.</td></tr>";
                }

                $conn->close();
            } else {
                echo "Session variables not set.";
            }
            ?>
        </table>
    </form>
</div>

<a href="Interface.php" class="buttonStudent">Go to Interface</a>

</body>
</html>
