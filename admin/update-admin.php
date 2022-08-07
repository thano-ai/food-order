<?php include('partials/menu.php') ?>

<div class="main-content">
        <div class="wrapper">
               <h1>Update Admin</h1>
               <br><br>

                <?php

                 // get the id of the selected admin
                 $id = $_GET['id'] ;

                 // creat sql
                 $sql = "SELECT * FROM tbl_admin WHERE id = $id";

                 //execute sql
                 $res = mysqli_query($con,$sql) ;

                 // check if the query executed or not
                 if($res==true){
                     //check the data
                     $count = mysqli_num_rows($res) ;
                     if($count==1){
                         //get the details
                        //  echo "Admin Available" ; 
                        $row = mysqli_fetch_array($res) ;
                        $full_name= $row['full_name'] ;
                        $username= $row['username'] ;


                     }
                     else{
                        $_SESSION['no-admin-found'] = "<div class='error'>admin not found</div>" ;
                         // return to the manage admin
                         header("location:".SITEURL.'admin/manage-admin.php') ;
                     }
                 }
                
                ?>

               <form action="" method="POST">
                   <table class="tbl-30">
                       <tr>
                       <td>Full Name</td>
                       <td><input type="text" name="full_name" value="<?php echo $full_name ;?>"></td>
                       </tr>

                       <tr>
                       <td>username</td>
                       <td><input type="text" name="username" value="<?php echo $username ;?>"></td>
                       </tr>

                       <tr>
                       <td colspan="2">
                           <input type="hidden" name="id" value="<?php echo $id ;?>">
                        <input id="submit" type="submit" name="submit" value="Update Admin" class="btn-secondary">
                       </td>
                   </tr>
                   </table>


               </form>

    </div>
</div>

<?php


// check the submit button 
if(isset($_POST['submit'])){
    //get the values from the form to update
    $id= $_POST['id'] ;
    $full_name= $_POST['full_name'] ;
    $username= $_POST['username'] ;

    // create the query 
    $sql2 = "UPDATE tbl_admin SET
    full_name = '$full_name',
    username = '$username'
    WHERE id ='$id'
    ";

    //execute query
    $res = mysqli_query($con ,$sql2);

    // check the query
    if($res==true){
        // data updated 
        // creat session 
        $_SESSION['update'] = "<div class='success'>Admin Updated Successfully</div>" ;
        //RETURN TO MANAGE ADMIN PAGE 
        header("location:".SITEURL.'admin/manage-admin.php') ;
    }
    else{
        // failed 
        // creat session 
        $_SESSION['update'] = "<div class='error'>Failed To Update Admin</div>" ;
        //RETURN TO MANAGE ADMIN PAGE 
        header("location:".SITEURL.'admin/add-admin.php') ;
    }

}

?>

<?php include('partials/footer.php') ?>