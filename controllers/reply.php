<?php
session_start();
include_once '../DB-CONFIG.php';
$link = mysqli_connect(DBHOST, UNAME, UPWD, DBNAME);

$ID ;
$reply = ' ';


$ID = $_POST['ID'];
$reply = $_POST['reply'];



if (mysqli_connect_errno())
    die("Cannot connect to database." . mysqli_connect_errno());



$queryAdd = "UPDATE contacts SET reply = '$reply' WHERE id  = '$ID' ";
$adding = mysqli_query($link, $queryAdd);

mysqli_close($link);
header('location: ../pages/pitch.php');
