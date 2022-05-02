<?php
session_start();
include("connection.php");
$username = $_POST["username"];
$password = $_POST["password"];
$password = hash("md5",$password);
$email = $_POST["email"];
$query = $mysqli->prepare("INSERT INTO users(username,password,email) VALUES(?,?,?)");
$query->bind_param("sss",$username,$password,$email);
$query->execute();
$_SESSION['username'] = $username;
$query = $mysqli->prepare("SELECT id FROM users WHERE username=?");
$query->bind_param("s",$username);
$query->execute();
$query->bind_result($id);
$query->fetch();
$_SESSION['id'] = $id;
header('Location: http://localhost/Site1/messenger.php');



?>
