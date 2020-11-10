<?php

if($_SERVER['REQUEST_METHOD'] == 'POST'){
   
    require '_dbconnect.php';
     $user_email = $_POST['signupEmail'];
     
     //echo '<br>';
     $pass = $_POST['signupPassword'];
     $cpass = $_POST['signupcPassword'];
     
     //Check whether this email exists
      $existSql = "SELECT * FROM `users` WHERE user_email = '$user_email'";
      //echo $existSql;
       $result = mysqli_query($conn,$existSql);
       //echo $result;


     $numRows = mysqli_num_rows($result);
    echo $numRows;
    if($numRows > 0){
        $showError = "Email already in use";
        echo $showError;
    }
    else{
        if($pass == $cpass){
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`user_email`, `user_pass`, `timestamp`) VALUES ('$user_email', '$hash', current_timestamp())";
            $result = mysqli_query($conn,$sql);
            if($result){
                //$showAlert = true;
               // echo " Done!";
                header("Location:/forum/index.php?signupsuccess=true");
              
            }
            else{
                $showError = "Query not executed";
                header("Location : /forum/index.php?signupsuccess=false&error=$showError");
            }

        }
        else{
            $showError = "Passwords do not match";
            header("Location : /forum/index.php?signupsuccess=false&error=$showError");
        }
    }
    //echo '<br>WTF is wrong with you';}
    //


}

?>