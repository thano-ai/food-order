<?php
//  echo "Delete";

//connect to the constants page 
include('../config/constants.php') ;

// check the passing values
if(isset($_GET['id']) AND isset($_GET['image_name']))
{
    // get and delete
    $id = $_GET['id'] ;
    $image_name = $_GET['image_name'] ;

    //remove image file if its avilable
    if($image_name !="")
    {
        // avilable so remove it
        $path = "../images/food/".$image_name;
        $remove = unlink($path) ;

        // if failed to remove image
        if($remove == false)
        {
            $_SESSION['remove'] = "<div class='error'>Failed To Remove Image</div> ";
            //RETURN TO MANAGE cate PAGE 
            header("location:".SITEURL.'admin/manage-food.php') ;  
            // stop the process 
            die();
        }

    }
    

    // delete data from the db
            $sql = "DELETE FROM tbl_food WHERE id = $id";
        //execute the query 
        $res = mysqli_query($con,$sql) ;

        // check wether the data is deleted or not
        if($res===true){
           // create session to display message
           $_SESSION['delete'] = "<div class='success'>Food deleted successfully</div>";
           //RETURN TO MANAGE food PAGE 
           header("location:".SITEURL.'admin/manage-food.php') ;
        }
        else{
           
           $_SESSION['delete'] = "<div class='error'>Food not deleted</div> ";
           //RETURN TO MANAGE food PAGE 
           header("location:".SITEURL.'admin/manage-food.php') ;
            
        }

    // return to manage cate page
}
else 
{
    $_SESSION['Unauthorized'] = "<div class='error'>Unauthorized Access</div> ";
    // return to manage food page
    header("location:".SITEURL.'admin/manage-food.php') ;
}






?>