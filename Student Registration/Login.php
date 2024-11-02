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


<div class="LoginForm">
<form id ="NameAndID"action="Login.php" method="POST">
<h1>Login Form</h1>
    <div>
        <label for="ID">ID:</label><br>
        <input type="text" id="ID" name="ID">
    </div>
    <div>
        <label for="Name">Name:</label><br>
        <input type="text" id="Name" name="Name">
    </div>
    <br>
    <input type="submit" value="Login">

    <section><br></br>


<?php
session_start();
if (isset($_POST['ID']) && isset($_POST['Name'])) 
{
    $ID = $_POST['ID']; 
    $Name = $_POST['Name'];
    $conn = new mysqli("localhost","root","",'schoolrecords');

    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT AccessLevel FROM student WHERE S_ID ='$ID' AND Name='$Name' 
            UNION
            SELECT AccessLevel FROM professor WHERE P_ID = $ID AND Name='$Name'";
    $result = $conn->query($sql);


    if ($result === false) {
        echo "Error with query: " . $conn->error;
    } else {
            $row = $result->fetch_assoc();
            $Accesslvl = $row['AccessLevel'];
    }

    if($Accesslvl == "Student"){
         if ($result->num_rows > 0){
        $_SESSION['studentID'] = $ID;
        $_SESSION['studentName'] = $Name;
        
        ob_start(); 
        include 'studentinformation.php';
        include 'studenttable.php';
        include 'interface.php';
        ob_end_clean(); 
        
        header("Location: interface.php");
        exit();}
    }
    else if($Accesslvl == "Admin"){
        if ($result->num_rows > 0){
            $_SESSION['ProfID'] = $ID;
            $_SESSION['ProfName'] = $Name;
            
            include 'AdminPage.php';
            header("Location: Adminpage.php");
            exit();}
    }
    else 
    {
        echo "Invalid Student Id or Student Name";
    }
}
?>

</form>
</div>

</body>
</html>
