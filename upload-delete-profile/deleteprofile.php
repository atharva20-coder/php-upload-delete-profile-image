<?php
session_start();
include_once 'dbh.php';
$sessionid = $_SESSION['id'];

//deleting file of any extension

$filename = "uploads/profile".$sessionid."*";
//find pathname matching a pattern
$fileinfo = glob($filename);         //Array ( [0] => uploads/profile1.jpg) 
$fileext = explode(".", $fileinfo[0]);    //spreding file name in two parts 1st=filename 2nd=fileextension
$fileactualext = $fileext[1];


$file = "uploads/profile".$sessionid.".".$fileactualext;

//deleting file

if (!unlink($file)) {
    echo "file can not be deleted";                                                     //unlink function deletes a file   
}else{
    echo "File deleted successfully";
    
}

//updating statusid to 0 in profileimg table inside database

$sql = "UPDATE profileimg SET status=1 WHERE userid='$sessionid';";   //deleting file of the current user only(who is logged in)
mysqli_query($conn, $sql);
header("Location: index.php?Success");