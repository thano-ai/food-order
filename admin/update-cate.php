<?php include('partials/menu.php') ;?>

<div class="main-content">
        <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>

        <?php
            if(isset($_GET['id']))
            {
                $id = $_GET['id'] ; 
                // creat sql
                $sql = "SELECT * FROM tbl_category WHERE id = $id";

                //execute sql
                $res = mysqli_query($con,$sql) ;

                // check if the query executed or not
                if($res==true){
                    //check the data
                    $count = mysqli_num_rows($res) ;
                    if($count==1){
                        //get the details
                       $row = mysqli_fetch_array($res) ;
                       $title= $row['title'] ;
                       $current_image= $row['image_name'] ;
                       $featured= $row['featured'] ;
                       $active= $row['active'] ;


                    }
                    else{
                        $_SESSION['no-cate-found'] = "<div class='error'>category not found</div>" ;
                        // return to the manage cate
                        header("location:".SITEURL.'admin/manage-cate.php') ;
                    }
                }

            }
            else
            {
                //RETURN TO MANAGE category PAGE 
                header("location:".SITEURL.'admin/manage-cate.php') ;
            }
        
        
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
        <tr>
                    <td>Title: </td>
                    <td>
                    <input type="text" name="title" value="<?php echo $title?>">
                    </td>
               </tr>

               <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                            if($current_image!="")
                            {
                                // display the image
                                ?>
                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image ?>"  width="150px">
                                <?php
                            }
                            else 
                            {
                                // display message
                                echo "<div class='error'>Image Not Added</div>";
                            }
                        
                        ?>
                    </td>
               </tr>
               <tr>
                    <td>New Image:</td>
                    <td>
                    <input type="file" name="image" >
                    </td>
               </tr>

               <tr>
                    <td>Featured: </td>
                    <td>
                    <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes

                    <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No"> No
                    </td>
               </tr>

               <tr>
                    <td>Active: </td>
                    <td>
                    <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes"> Yes

                    <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No"> No
                    </td>
               </tr>

               <tr>
                       <td colspan="2">
                       <input type="hidden" name='current_image' value="<?php echo $current_image ;?>">
                       <input type="hidden" name="id" value="<?php echo $id ;?>">
                        <input id="submit" type="submit" name="submit" value="Update Category" class="btn-secondary">
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
    $title= $_POST['title'] ;
    $current_image= $_POST['current_image'] ;
    $featured= $_POST['featured'] ;
    $active= $_POST['active'] ;

    //update the new image if selected
    if(isset($_FILES['image']['name'])){
        //upload the image
        $image_name =$_FILES['image']['name'] ;

        // upload image only if selected 'avilable'
        if($image_name !="")
        {
            //upload new image 

            //auto rename the image
            //get the extention of the image
            $ext = end(explode('.',$image_name));

            //rename the image 
            $image_name ="food_category_".rand(000,999).'.'.$ext ;//e.g food_category_344.jpg 
            $source_path =$_FILES['image']['tmp_name'] ;

            $destination_path ="../images/category/".$image_name;

            //upload the image
            $upload = move_uploaded_file($source_path, $destination_path) ;

            //check wether the image is uploaded
              if($upload==false)
              {
                    $_SESSION['upload'] = "<div class='error'>Failed To upload the image</div>" ;
                    //RETURN TO MANAGE category PAGE 
                header("location:".SITEURL.'admin/manage-cate.php') ;
                //stop the process
                die();

              }
                // remove current image
                if($current_image !="")
                {
                                $path = "../images/category/".$current_image;
                        $remove = unlink($path) ;

                        // if failed to remove image
                    if($remove == false)
                    {
                                $_SESSION['failed-remove'] = "<div class='error'>Failed To Remove current image </div> ";
                        //RETURN TO MANAGE cate PAGE 
                        header("location:".SITEURL.'admin/manage-cate.php') ;  
                        // stop the process 
                        die();

                    }
            
                }
        }
            else{
                $image_name =$current_image ;
            }
    }
     else{
            
            $image_name =$current_image ;
        
        }

    // create the query 
    $sql2 = "UPDATE tbl_category SET
    title = '$title',
    image_name ='$image_name',
    featured = '$featured',
    active = '$active'
    WHERE id ='$id'
    ";

    //execute query
    $res = mysqli_query($con ,$sql2);

    // check the query
    if($res==true){
        // data updated 
        // creat session 
        $_SESSION['update'] = "<div class='success'>Category Updated Successfully</div>" ;
        //RETURN TO MANAGE cate PAGE 
        header("location:".SITEURL.'admin/manage-cate.php') ;
    }
    else{
        // failed 
        // creat session 
        $_SESSION['update'] = "<div class='error'>Failed To Update Category</div>" ;
        //RETURN TO MANAGE cate PAGE 
        header("location:".SITEURL.'admin/manage-cate.php') ;
    }

}
?>


<?php include('partials/footer.php'); ?>