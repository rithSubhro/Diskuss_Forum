<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Welcome to DisKuss</title>
    <style>
    #ques {
        min-height: 433px;
    }
    </style>
</head>

<body>
    <?php include 'partials/_dbconnect.php';?>
    <?php include 'partials/_header.php';?>
    <?php
      $id=$_GET['threadid'];
      $sql = "SELECT * FROM `threads` WHERE thread_id=$id";
      $result = mysqli_query($conn,$sql);
      $noResult=true;
      while($row = mysqli_fetch_assoc($result)){
        $noResult = false;
        $thread_id = $row['thread_id'];
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $thread_user_id= $row['thread_user_id'];

        //Query the users table to find out the name of Original poster
        $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
        $result2 =  mysqli_query($conn,$sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $posted_by = $row2['user_email'];

      }
    ?>

    <?php
         $showAlert= false;
         $method = $_SERVER['REQUEST_METHOD'];
         if($method == 'POST'){
             //Insert thread into comment db
             $comment = $_POST['comment'];
             $comment = str_replace("<","&lt;", $comment);
             $comment = str_replace(">","&gt;", $comment);
             $sno = $_POST['sno'];
             $sql = "INSERT INTO `comments` ( `comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$id', '$sno', current_timestamp())";
             $result = mysqli_query($conn,$sql);
             $showAlert=true;

           }
         if($showAlert){
             echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                     <strong>Success!</strong> Your comment has been added.
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                     </button>
                 </div>';
         }
    ?>


    <!--Category container starts here-->
    <div class="container my-3">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $title; ?></h1>
            <p class="lead"><?php echo $desc; ?></p>
            <hr class="my-4">
            <p>This is a peer to peer forum for sharing knowledge with each otherNo Spam / Advertising / Self-promote in
                the forums/Do not post copyright-infringing material./not post “offensive” posts, links or
                images./Remain respectful of other members at all times.</p>
            Posted by <a class="btn btn-success btn-lg" href="#" role="button"> <?php echo $posted_by;?></a>
        </div>
    </div>


    <?php
    
    if(isset($_SESSION['loggedin']) == true ){
        echo '    <div class="container">
        <h1>Post A Comment</h1>
        <form action="'. $_SERVER['REQUEST_URI'].'" method="POST">

            <div class="form-group">
                <label for="exampleFormControlTextarea1">Type your Comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
            </div>
            <button type="submit" class="btn btn-success">Post Comment</button>
        </form>
    </div>';
    }
    else{
        echo '
        <div class="container lead">Type your Comment.You are not logged in.Log in to post comments and questions.</div>';
        
    }


    ?>


    <div class="container" id="ques">
        <h1 class="py-3">Discussions</h1>
        <?php

          $id=$_GET['threadid'];
          $sql = "SELECT * FROM `comments` WHERE thread_id=$id";
          $result = mysqli_query($conn,$sql);
          while($row = mysqli_fetch_assoc($result)){
            $thread_id = $row['comment_id'];
            $content = $row['comment_content'];
            $comment_time = $row['comment_time'];
            $thread_user_id = $row['comment_by'];

            $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
            $result2 =  mysqli_query($conn,$sql2);
            $row2 = mysqli_fetch_assoc($result2);


            echo '<div class="media my-3">
                <img src="./images/user_default.png" width="34px" class="mr-3" alt="...">
                <div class="media-body">
                  <p class="font-weight-bold my-0">'.$row2['user_email'].' at '.$comment_time.' </p>
                  '.$content.'
                </div>
            </div>';
         }

         if($noResult){
            echo'<div class="jumbotron jumbotron-fluid">
            <div class="container">
              <h1 class="display-4">No Comments Found</h1>
              <p class="lead">Be the first person to Comment.</p>
            </div>
          </div>';
        }
        ?>
    </div>


    <?php include 'partials/_footer.php';?>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
</body>

</html>