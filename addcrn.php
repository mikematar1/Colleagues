<?php
session_start();
include("connection.php");
$username = $_SESSION['username'];
$crn = $_POST['crn'];
$semester = $_POST['semester'];

$query = $mysqli->prepare("SELECT COUNT(*) FROM courses WHERE crn = ?");
$query->bind_param("i",$crn);
$query->execute();
$query->bind_result($rs);
$query->fetch();
if($rs==0){ //crn doesnt exist
    
    $query1 = $mysqli1->prepare("INSERT INTO courses(crn,semester) VALUES(?,?)");
    $query1->bind_param("is",$crn,$semester);
    $query1->execute();
}

$id = $_SESSION['id'];




$query = $mysqli2->prepare("INSERT INTO enrolled(student_id,crn) VALUES(?,?)");
$query->bind_param("ii",$id,$crn);
$query->execute();
header('Location: http://localhost/Site1/messenger.php');
?>