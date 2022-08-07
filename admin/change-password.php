<?php include('partials/menu.php') ?>

<div class="main-content">
        <div class="wrapper">
               <h1>Change Password</h1>
               <br><br>

               <?php
               if(isset($_GET['id'])){
                   $id = $_GET['id'] ;
               }
               
               
               ?>

               <form action=""  method="POST">
                   <table class="tbl-30">
                       <tr>
                           <td>Current password</td>
                           <td>
                               <input type="password" name="current_pass" placeholder="enter current password">
                           </td>
                       </tr>

                       <tr>
                           <td>New password</td>
                           <td>
                               <input type="password" name="new_pass" placeholder="enter new password">
                           </td>
                       </tr>

                       <tr>
                           <td>Confirm password</td>
                           <td>
                               <input type="password" name="confirm_pass" placeholder="confirm the password">
                           </td>
                       </tr>

                       <td colspan="2">
                       <input type="hidden" name="id" value="<?php echo $id ;?>">
                        <input id="submit" type="submit" name="submit" value="Change Password" class="btn-secondary">
                       </td>
                   </tr>

                   </table>
               </form>

    </div>
</div>

<?php
if(isset($_POST['submit'])){
    // get the data from the form
    $id= $_POST['id'] ;
    $current_pass= md5($_POST['current_pass']) ;
    $new_pass= md5($_POST['new_pass']) ;
    $confirm_pass=md5($_POST['confirm_pass']) ;

    //create sql query
    $sql ="SELECT * FROM tbl_admin WHERE id=$id AND password='$current_pass'" ;

    //execute query
    $res = mysqli_query($con ,$sql);

    // check the query
    if($res==true){
        //check the data
        $count = mysqli_num_rows($res) ;

        if($count==1){
            // confirm password
            if($new_pass==$confirm_pass){
            //update the pass
            $sql2 = "UPDATE tbl_admin SET password = '$new_pass' WHERE id = $id" ;

             //execute sql
             $res2 = mysqli_query($con,$sql) ;

             // check the query
              if($res2==true){
                $_SESSION['change'] = "<div class='success'>password changes successfully</div>" ;
                // return to the manage admin
                header("location:".SITEURL.'admin/manage-admin.php') ;

              }
              else{
                $_SESSION['change'] = "<div class='error'>failed to change password</div>" ;
                // return to the manage admin
                header("location:".SITEURL.'admin/manage-admin.php') ;
              }
        }
            else{
                $_SESSION['noMatch'] = "<div class='error'>password not match</div>" ;
                // return to the manage admin
                header("location:".SITEURL.'admin/manage-admin.php') ;
            //return to manage admin
        }
            
        
        }

        else{
            $_SESSION['noUser'] = "<div class='error'>user not found. </div>" ;
            // return to the manage admin
            header("location:".SITEURL.'admin/manage-admin.php') ;
        }
    }
}



?>

<?php include('partials/footer.php') ?>