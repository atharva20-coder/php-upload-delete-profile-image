<?php

session_start();



if(isset($_POST['submitlogin'])){
    $_SESSION['id'] = 1; 
//we just want the first id from the databse. WE ARE NOT GETTING ANYYHING FROM THE DATABASE WE ARE JUST SAYING THAT WE WANT TO LOGIN WITH "id = 1" 
    header('Location: index.php');    
}