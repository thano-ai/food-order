<?php include('partials/menu.php'); ?>

<div class="main-content">
        <div class="wrapper">
               <h1>Add Admin</h1>
               <br>  <br>

               <?php
               if(isset($_SESSION['add'])){
                  echo $_SESSION['add'] ;
                  unset($_SESSION['add']) ; //display just one time 
               }
               ?>
               <br><br>
                <!-- add admin form starts -->

               <form action="" method="POST">

               <table class="tbl-30"> 
                   <tr>
                       <td>Full Name</td>
                       <td><input type="text" name="full_name" placeholder="enter the admin name"></td>
                       
                   </tr>
                   <tr>
                       <td>Username</td>
                       <td><input type="text" name="username" placeholder="enter the username"></td>
                       
                   </tr>
                   <tr>
                       <td>Password</td>
                       <td><input type="password" name="password" placeholder="enter the password"></td>
                       
                   </tr>
                   <tr>
                       <td colspan="2">
                        <input id="submit" type="submit" name="submit" value="Add Admin" class="btn-secondary">
                       </td>
                   </tr>
               </table>
               </form>
                <!-- add admin form ends -->
        </div>
</div>




<?php

//process the data from form to the database

// check the submit button 
if(isset($_POST['submit']))
{
    // button clicked 
    // get the data 
    $full_name = $_POST['full_name'] ;
    $username = $_POST['username'] ;
    $password = md5($_POST['password']); //password encreption bt md5 ;

    // save tha data in the database by sql query
    $sql = "INSERT INTO tbl_admin SET
    full_name = '$full_name',
    username = '$username',
    password = '$password' 
    ";

    // executing query and saving the data in database
    $res = mysqli_query($con ,$sql) or die(mysqli_error());

    //check the data is inserted or not and display message 
    if($res==true){
        // data inserted 
        // creat session value for display the message
        $_SESSION['add'] = "<div class='success'>Admin Added Successfully</div>" ;
        //RETURN TO MANAGE ADMIN PAGE 
        header("location:".SITEURL.'admin/manage-admin.php') ;
    }
    else{
        // failed 
        // creat session value for display the message
        $_SESSION['add'] = "<div class='error'>Failed To Add Admin</div>" ;
        //RETURN TO MANAGE ADMIN PAGE 
        header("location:".SITEURL.'admin/add-admin.php') ;
    }

}

?>
<?php include('partials/footer.php'); ?>