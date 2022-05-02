<?php
session_start();
include("connection.php");
$msg = $_POST['msg'];
$id = $_SESSION['id'];
$crn = $_SESSION['crn'];
$query = $mysqli->prepare("INSERT INTO messages(student_id,crn,msg,datentime) VALUES(?,?,?,?)");
$query->bind_param("iiss",$id,$crn,$msg,date("Y-m-d H:i:s"));
$query->execute();
header('Location: http://localhost/Site1/messenger.php');
 ?>