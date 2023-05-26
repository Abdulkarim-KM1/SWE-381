<?php
session_start();
include_once '../DB-CONFIG.php';
$link = mysqli_connect(DBHOST, UNAME, UPWD, DBNAME);
$name = "";
$location = "";
$descreption = "";
$user = "";
$ID ;


$name = $_POST['name'];
$location = $_POST['location'];
$descreption = $_POST['descreption'];
$user = $_POST['user'];
$ID = $_POST['ID'];



if (mysqli_connect_errno())
    die("Cannot connect to database." . mysqli_connect_errno());



$queryAdd = "UPDATE stadium SET name = '$name' , descreption = '$descreption' , location = '$location' , username = '$user'  WHERE id  = '$ID' ";
$adding = mysqli_query($link, $queryAdd);

mysqli_close($link);
header('location: ../pages/pitch.php');
