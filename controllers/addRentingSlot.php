<?php
session_start();
include_once '../DB-CONFIG.php';
$link = mysqli_connect(DBHOST, UNAME, UPWD, DBNAME);
$date = "";
$start = "";
$end = "";
$user = "";
$ID;


$date = $_POST['date'];
$start = $_POST['start'];
$end = $_POST['end'];
$user = $_POST['user'];
$ID = $_POST['ID'];



if (mysqli_connect_errno())
    die("Cannot connect to database." . mysqli_connect_errno());



$queryAdd = "INSERT INTO renting_slot (day, start_time,end_time, stadium_id)  VALUES ('$date','$start','$end', '$ID' )";
$adding = mysqli_query($link, $queryAdd);

mysqli_close($link);
header('location: ../pages/pitch.php');
