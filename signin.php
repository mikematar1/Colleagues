<?php
session_start();
include("connection.php");
$username = $_POST['username'];
$password = $_POST['password'];
$password = hash("md5",$password);
$query = $mysqli->prepare("SELECT COUNT(*) FROM users WHERE username=? AND password=?");
$query->bind_param("ss",$username,$password);
$query->execute();
$query->bind_result($result);
$query->fetch();
if($result ==0){
    // user not found
    header('Location: http://localhost/Site1/signin.html');
}else{
    $_SESSION['username'] = $username;
    $query1 = $mysqli1->prepare("SELECT id FROM users WHERE username=?");
    $query1->bind_param("s",$username);
    $query1->execute();
    $query1->bind_result($id);
    $query1->fetch();
    $_SESSION['id']=$id;
    $query2 = $mysqli2->query("SELECT crn FROM enrolled WHERE student_id=$id LIMIT 1");
    $_SESSION['crn']=$query2->fetch_object()->crn;

    header('Location: http://localhost/Site1/messenger.php');
}
?>