<?php
  session_start();
  include_once 'dbh.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <?php
        
        $sql = "SELECT * FROM user";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $id = $row['id'];
                $sqlImg = "SELECT * FROM profileimg WHERE userid='$id'";
                $resultImg = mysqli_query($conn, $sqlImg);
                while ($rowImg = mysqli_fetch_assoc($resultImg)){
                    echo "<div class= 'user-container'>";
                       if ($rowImg['status'] == 0){
                           
                           $filename = "uploads/profile".$id."*";
                           //find pathname matching a pattern
                           $fileinfo = glob($filename);         //Array ( [0] => uploads/profile1.jpg) 
                           $fileext = explode(".", $fileinfo[0]);    //spreding file name in two parts 1st=filename 2nd=fileextension
                           $fileactualext = $fileext[1];

                           
                            echo "<img src='uploads/profile".$id.".".$fileactualext."?".mt_rand()."'>";
                       }else {
                           echo "<img src='uploads/default.jpg'>";
                       }
                    echo "<p>".$row['username']."</p>";
                    echo "</div>";
                }
            }
        }else{
            echo "there are no use yet";
        }
        
        if(isset($_SESSION['id'])){
            if($_SESSION['id'] == 1){
                echo "You are logged in as user #1";
            }
               echo "<form action='uploadprofile.php' method='post' enctype='multipart/form-data'>
                    <input type='file' name='file'>
                    <button type='submit' name='submit'>UPLOAD</button>
                    </form>";
            
            //DELETING PROFILE IMAGE
            
               echo "<form action='deleteprofile.php' method='post'>
                    <button type='submit' name='submit'>Delete Profile image</button>
                    </form>";
        }else{
          echo "You are not looged in";
            echo "<form action = 'signup.php' method='post'>
            <input type='text' name='first' placeholder = 'FIRSTNAME'>
            <input type='text' name='last'  placeholder = 'LASTNAME'>
            <input type='text' name='uid' placeholder = 'USERNAME'>
            <input type='password' name='pwd' placeholder = 'PASSWORD'>
            <button type = 'submit' name='submitSignup'>Signup</button>
            </form>";
        }
        ?>
        <p>LOGIN</p>
        <form action="login.php" method="post">
            <button type="submit" name="submitlogin">LOGIN</button>    
        </form>
        <p>LOGOUT</p>
        <form action="logout.php" method="post">
            <button type="submit" name="submitlogout">LOGOUT</button>    
        </form>
    </body>
</html>