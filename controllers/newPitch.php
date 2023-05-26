<?php
session_start();
include_once '../DB-CONFIG.php';
$link = mysqli_connect(DBHOST, UNAME, UPWD, DBNAME);
$name = "";
$location = "";
$descreption = "";
$user = "";


$name = $_POST['name'];
$location = $_POST['location'];
$descreption = $_POST['descreption'];
$user = $_POST['user'];



if (mysqli_connect_errno())
    die("Cannot connect to database." . mysqli_connect_errno());



$queryAdd = "INSERT INTO stadium (name, location,descreption, username)  VALUES ('$name','$location','$descreption', '$user' )";
$adding = mysqli_query($link, $queryAdd);

mysqli_close($link);
header('location: ../pages/pitch.php');
