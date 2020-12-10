<?php

session_start();
include_once 'dbh.php';
$id = $_SESSION['id'];

if(isset($_POST['submit'])){
    //submit is the name of button
    //getting information of file that is being uploaded
    $file = $_FILES['file'];              //name of input is file or name of file uploaded will be file  
    
    
   // print_r($file);   -->  //Array ( [name] => Atharva josaa 2020.pdf [type] => application/pdf [tmp_name] => C:\xampp\tmp\php8010.tmp [error] => 0 [size] => 1496142 )
    
    
    //extracting all the iformation from files such as name, kind(format) of file and source of file
    
    
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];
    
    //selecting file types which we are going to allow user to upload
    
    $fileExt = explode('.', $fileName);   //seperating names by punctuation and getting 2 diff name 1) before punc 2) after punc
    $fileActualExt = strtolower(end($fileExt));    //Now we have the extension of the file we just uploaded
    //Next thing we want to do is allow the user to upload files with certain extension only,
    
    $allowed = array('jpg', 'jpeg', 'png' ,'pdf');
    //now check if the file is actually allowed to get uploaded inside the website if it has proper extensions
    
    if(in_array($fileActualExt, $allowed)){
        //this if statement checks the extension of the uploaded file
        //if the $fileActualExt exist inside the array $allowed then this code will run
        if($fileError === 0){
          if($fileSize < 100000000){
              //500000kb = 500 mb
              //uploading files with proper name, we are going to give each file a uniqe id so that no file overwrite with the existing 
              
              $fileNameNew = "profile".$id.".".$fileActualExt;    //adding extension to uploaded file with uniqe id
              //it creates unique id based on the microseconds that were in right now in current time format so that we just didn't get a random number we actually get a time format in microseconds which becomes unique number that dosen't get replaced at one point so we don't actually get a chance of this random number being same as something we've already uploaded.
              
              //giving file storage location inside root folder
              
              $fileDestination = 'uploads/'.$fileNameNew;
              
              //here we have to create a function that will move the file from temprory location that we save in variable $fileTmpName into the actual location that we wanted to become uploaded to which we have just above line of code
              
              move_uploaded_file($fileTmpName,  $fileDestination); 
              
              //inside the paenthesis we have to tell where is the temp location of file and where is the new location is
              
              $sql = "UPDATE profileimg SET status=0 WHERE userid='$id';";
              $result = mysqli_query($conn, $sql);
              
              header("Location: index.php?upload-success");
              
          }else{
              echo "your is too big";
          }
        }else{
          echo "Unexpected error";     
        }
        
        
    }else{
        echo "You can upload file of this extension!";
    }
}
