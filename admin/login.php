<?php 
//connect the constrants
include('../config/constants.php') ;
?>


<html>
   <head>
    <title>food order system</title>
    <link rel="stylesheet" href="../css/admin-style.css">

   </head>
   <body>
      <div class="login main-content" >
      <h1 class="text-center">Login</h1>
      <br><br>
      <?php

        if(isset($_SESSION['login'])){
            echo $_SESSION['login'] ;
            unset($_SESSION['login']) ; //display just one time 
        }
        if(isset($_SESSION['nologin-message'])){
            echo $_SESSION['nologin-message'] ;
            unset($_SESSION['nologin-message']) ; //display just one time 
        }
      
      ?>
      <br><br>

      <!-- login form starts -->
      <form action="" method="POST" class="text-center">
          Username: <br>
          <input type="text" name="username" palceholder="enter username"><br><br>

          Password: <br>
          <input type="password" name="password" palceholder="enter password"><br><br>

          <input id="submit" type="submit" name="submit" value="Login" class="btn-primary"><br><br>
      </form>
      <!-- login form ends -->


      <p class="text-center">created by <a href="#">Thana</a></p>
      
      </div>


   </body>
</html>


<?php

// check the login button
if(isset($_POST['submit'])){
    //process for login
    //1 get the data from login form
    $username = $_POST['username'] ;
    $password = md5($_POST['password']) ;

    //2 sql to check the username and password
    $sql="SELECT * FROM tbl_admin WHERE username ='$username' AND password ='$password'";

    //execute the query
    $res= mysqli_query($con,$sql) ;

    //4 count rows to check the user
    $count = mysqli_num_rows($res) ;

    if($count==1){
        // user available
        $_SESSION['login'] ="<div class='success'>Login Successfull</div>";
        $_SESSION['user'] = $username;
        //RETURN TO index.php PAGE 
        header("location:".SITEURL.'admin/') ;
    }
    else{
        // user not exist
        $_SESSION['login'] ="<div class='error text-center'>username or password did not match</div>";
        //RETURN TO login.php PAGE 
        header("location:".SITEURL.'admin/login.php') ;
    }
}



?>