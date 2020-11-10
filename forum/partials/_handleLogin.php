<?php
  //$showError = "false";
  if($_SERVER['REQUEST_METHOD']== 'POST'){
    require '_dbconnect.php';
    $email = $_POST['loginEmail'];
    $pass = $_POST['loginPass'];
   

    $sql= "SELECT * FROM `users` WHERE user_email ='$email'";
   
    $result = mysqli_query($conn,$sql);
    $numRows = mysqli_num_rows($result);
    //echo $numRows;
    if($numRows == 1){
        $row = mysqli_fetch_assoc($result);
        if(password_verify($pass,$row['user_pass'])){
            session_start();
            $_SESSION['loggedin']= true;
            $_SESSION['useremail'] = $email;
            $_SESSION['sno'] = $row['sno'];
            //echo "Logged in".$email;
            header("Location: /forum/index.php?loginsuccess=true");
            echo'<div class="alert alert-Success alert-dismissible fade show" role="alert">
            <strong>Holy guacamole!</strong> Logged in successfully.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>';
        }
        else{
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Holy guacamole!</strong> Wrong Password
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>';
        }
    }
    else{
      header("Location: /forum/index.php?loginsuccess=false");
    }
    
  }

?>