<?php
session_start();
$crn = $_POST['newcrn'];
$_SESSION['crn']=$crn;
header('Location: http://localhost/Site1/messenger.php');
?>