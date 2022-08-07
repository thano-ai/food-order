<?php

//connect to the constants page 
include('../config/constants.php') ;

// get the id of the admin
 $id = $_GET['id'] ;
 // create the sql query 
 $sql = "DELETE FROM tbl_admin WHERE id = $id";
 //execute the query 
 $res = mysqli_query($con,$sql) ;
 // check if the query executed or not
 if($res===true){
     // admin deleted 
    //  echo "Admin deleted successfuly " ;
    // create session to display message
    $_SESSION['delete'] = "<div class='success'>Admin deleted successfully</div>";
    //RETURN TO MANAGE ADMIN PAGE 
    header("location:".SITEURL.'admin/manage-admin.php') ;
 }
 else{
     // admin not deleted
    //  echo "Admin not deleted " ; 
    $_SESSION['delete'] = "<div class='error'>Admin not deleted</div> ";
    //RETURN TO MANAGE ADMIN PAGE 
    header("location:".SITEURL.'admin/manage-admin.php') ;
     
 }



// return to the manage-admin page 



?>