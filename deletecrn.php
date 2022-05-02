<?php
session_start();
include("connection.php");
$query = $mysqli->prepare("DELETE FROM enrolled WHERE crn=? AND student_id=?");
$query->bind_param("ii",$_SESSION['crn'],$_SESSION['id']);
$query->execute();
header('Location: http://localhost/Site1/messenger.php');
?>