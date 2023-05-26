<?php
session_start();
include_once '../DB-CONFIG.php';
$link = mysqli_connect(DBHOST, UNAME, UPWD, DBNAME);
$choosen = "";
$choosen = $_POST['choosen'];

$user = "";
$ID = "";


$choosen = $_POST['choosen'];
$message = $_POST['message'];

$user = $_POST['user'];
$ID = $_POST['ID'];



if (mysqli_connect_errno())
    die("Cannot connect to database." . mysqli_connect_errno());



$queryAdd = "INSERT INTO reservation (user, stadium_id,renting_slot_id,msg)  VALUES ('$user','$ID','$choosen','$message')";
$adding = mysqli_query($link, $queryAdd);

mysqli_close($link);
header('location: ../pages/pitches.php');
