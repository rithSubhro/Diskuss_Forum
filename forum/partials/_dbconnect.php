<?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $database = "diskuss";

  $conn = mysqli_connect($servername,$username,$password,$database);
  if(!$conn){
    die("Error-->".mysqli_connect_error($conn));
}
  //$result = ($conn,$sql);
  //if($conn){
      //echo "Connection established";
  //}
  //else{
     // echo "Error in connection";
  ///}

?>