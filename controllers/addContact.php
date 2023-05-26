<?php
session_start();
include_once '../DB-CONFIG.php';
$link = mysqli_connect(DBHOST, UNAME, UPWD, DBNAME);
$subject = "";
$message = "";
$user = "";
$ID;


$subject = $_POST['subject'];
$message = $_POST['message'];
$user = $_POST['user'];
$ID = $_POST['ID'];



if (mysqli_connect_errno())
    die("Cannot connect to database." . mysqli_connect_errno());



$queryAdd = "INSERT INTO contacts (stadium_id, user,subject, msg)  VALUES ('$ID','$user','$subject', '$message' )";
$adding = mysqli_query($link, $queryAdd);

mysqli_close($link);
header('location: ../pages/pitches.php');
