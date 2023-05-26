<?php
session_start();
include_once '../DB-CONFIG.php';
$link = mysqli_connect(DBHOST, UNAME, UPWD, DBNAME);
$uploadfile = "";

$user = "";
$ID;



$user = $_POST['user'];
$ID = $_POST['ID'];



if (mysqli_connect_errno())
    die("Cannot connect to database." . mysqli_connect_errno());


$filename = $_FILES["uploadfile"]["name"];
$tempname = $_FILES["uploadfile"]["tmp_name"];
$folder = "./image/" . $filename;


// Get all the submitted data from the form
$sql = "INSERT INTO photos (filename,stadium_id) VALUES ('$filename','$ID')";

// Execute query
mysqli_query($link, $sql);

move_uploaded_file($tempname, $folder);
// $queryAdd = "INSERT INTO renting_slot (day, start_time,end_time, stadium_id)  VALUES ('$date','$start','$end', '$ID' )";
// $adding = mysqli_query($link, $queryAdd);

mysqli_close($link);
header('location: ../pages/pitch.php');
