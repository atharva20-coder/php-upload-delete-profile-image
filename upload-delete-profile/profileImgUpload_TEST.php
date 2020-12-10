<?php
session_start();
include_once 'dbh.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Uploading profile images</title>
    </head>
<!--THERE ARE 2 WAYS OF UPLOADING IMAGES TO DATABASE 1)UPLOADING FILES TO ROOT FOLDER OF WEBSITE OR 2)UPLOADING TO WEBSITE AS A BLOB ELEMENT-->
    <body>
        <!--NOW WE ARE ACTUALLY GOING TO TELL THE SYSTEM WHAT WE ACTUALLY WANT TO SEE WE ARE LOGGED IN OR WHEN LOGGED OUT-->
        <?php
        
        //in order to signup a person inside the database. In order to that we need to see what's going on inside the browser so before we start signing up people we should probably create the thing that tells us how the user looks like inside a browser. So you can see if we had a user inside the database or not and if we had a user it shows us what the user name was what the name of the person was and what the profile image looks like.
        
        //selecting user from the database bcoz we need to see if there is any kind of user from the database and if there is we want to show them inside the top of our website if there isn't any users then we want to show a message that says there are no users
        
        //first thing we are going to is to write a select statement
        
        $sql = "select * from user";
        $result = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($result) > 0){
            //splitting results
            while($row = mysqli_fetch_assoc($result)){
                //we need to check if we have uploaded any kind of profile images to this user yet because based on that we have to run another select statement that goes in and checks if we already uploaded a profile image
                
                $id = $row['id'];  //it gets the id of the user we just selected in the database line 21
                $sqlImg = "select * profileimg where userid='$id'";
                $resultImg = mysqli_query($conn, $sqlImg);
                
                while($rowImg = mysqli_fetch_assoc($resultImg)){
                    //showing data inside the browser
                    //showin data in div box
                    echo "<div>";
                    //checking what value status in database has
                    if($rowImg['status'] == 0){
                        //$rowImg = 0 then we already uploaded an image
                        echo "<img src 'uploads/profile".$uid.".jpg?'".mt_rand().">";
                    }else{
                        //if $rowImg is not 0 then not uploaded an image
                        echo "<img src 'uploads/default.jpg'>";
                    }
                    echo $row['username'];            //showing username with profie image
                    
                    echo "</div>";
                }
            }
        }else{
            echo "No user Yet!";
        }
        
        //this if statement checks we are  logged in or not
        if(isset($_SESSION['id'])){
            //we want to check that we logged in as ADMIN or as first person inside our database
            if($_SESSION['id'] == 1){
                echo "You are logged in as user #1";
            }
            //if we are logged in then only we are going to see image upload form
            
            echo "<h2>UPLOADING DATA TO ROOT FOLDER OF WEBSITE</h2>
        <form action= 'uploadprofile.php' method='post' enctype='multipart/form-data'>
            <input type='file' name='file'>
            <button type='submit' name='submit'>UPLOAD</button>
        </form>";
        
        }else{
            echo "You are not logged in";
            echo "
            <form action='signup.php' method='post'>
            First Name: <input type ='text' name = 'first' placeholder='Firstname'>
            Last Name: <input type ='text' name = 'last' placeholder='Lastname'>
            User Name: <input type ='text' name = 'uid' placeholder='Username'>
            Password: <input type ='password' name = 'pwd' placeholder='Password'>
            <button type='submit' name='submitSignup'>Signup</button>
            </form>
            ";
        }
        ?>
    
        <h2><p>Login as User</p></h2>
        <form action="login.php" method="post">
            <button type="submit" name="submitlogin">Login</button>
        </form>
        <h2><p>Logout as User</p></h2>
        <form action="logout.php" method="post">
            <button type="submit" name="submitlogout">Logout</button>
        </form>
    </body>
</html>