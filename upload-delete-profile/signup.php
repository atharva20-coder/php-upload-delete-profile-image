<?php

include_once 'dbh.php';

//after we click sign up button inside our index page we need to grab the data that we passed on the main page(profileImgUpload) 

        $first = $_POST['first'];
        $last = $_POST['last'];
        $uid = $_POST['uid'];
        $pwd = $_POST['pwd'];
//inserting data inside user table
$sql = "insert into user (first, last, username, password) values ('$first', '$last', '$uid', '$pwd')";
mysqli_query($conn, $sql);
//once did this we signed up the user

$sql = "select * from user where username='$uid' and first= '$first'";
$result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
    //inside the condition of this if statement we ant to check if we have any results from select statement in line 16    
    //inside the if statement we now need to get the data from this user we just inserted into database
    
    while($row = mysqli_fetch_assoc($result)){
        //now we are basically getting all the data from the user we just inserted into the database
        //inside while loop we need just one piece of information from this user we need to get his ID inside this column
        
        $userid = $row['id'];
        //now when we got the ID we can actually go out and insert a new row inside a profile image table
        $sql = "insert into profileimg (userid, status) values ('$userid', 1)";
        //now the reason why I am writing 1 here bcoz inside the main page (profileImgUpload) line 38 once we loop out the user inside our website we are checking if he has a status inside his profile image set to 0 or 1 if its zero the we looping out the profile image he uploaded if its one then we are basically saying he dosen't have the profile image yet 
        mysqli_query($conn, $sql);
        
        header('Location: index.php');
    }
   }else{
    echo "you have an error";
}
