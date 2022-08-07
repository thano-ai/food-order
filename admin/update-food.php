<?php include('partials/menu.php') ;?>

<div class="main-content">
        <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <?php
            if(isset($_GET['id']))
            {
                $id = $_GET['id'] ; 
                // create sql
                $sql2 = "SELECT * FROM tbl_food WHERE id = $id";

                //execute sql
                $res2 = mysqli_query($con,$sql2) ;

                // check if the query executed or not
                if($res2==true){
                    //check the data
                    $count = mysqli_num_rows($res2) ;
                    if($count==1){
                        //get the details
                       $row2 = mysqli_fetch_array($res2) ;
                       $title= $row2['title'] ;
                       $description= $row2['description'] ;
                       $price= $row2['price'] ;
                       $current_image= $row2['image_name'] ;
                       $current_cate = $row2['category_id'] ;
                       $featured= $row2['featured'] ;
                       $active= $row2['active'] ;


                    }
                    else{
                        $_SESSION['no-food-found'] = "<div class='error'>food not found</div>" ;
                        // return to the manage cate
                        header("location:".SITEURL.'admin/manage-food.php') ;
                    }
                }

            }
            else
            {
                //RETURN TO MANAGE food PAGE 
                header("location:".SITEURL.'admin/manage-food.php') ;
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
                    <td>Description: </td>
                    <td>
                    <textarea name="description"  cols="30" rows="5"><?php echo $description?></textarea>
                    </td>
               </tr>

               <tr>
                    <td>Price: </td>
                    <td>
                    <input type="number" name="price" value="<?php echo $price?>">
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
                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image ?>"  width="150px">
                                <?php
                            }
                            else 
                            {
                                // display message image not there
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
                    <td>Category: </td>
                    <td>
                   <select name="category">
                   <?php
                    $sql ="SELECT * FROM tbl_category WHERE active ='Yes'" ;
                    $res = mysqli_query($con , $sql) ;
                    $count = mysqli_num_rows($res) ;
                    
                    if($count > 0){
                        // cate is avilable 
                        while($row = mysqli_fetch_assoc($res))
                        {
                            $cate_title = $row['title'] ;
                            $cate_id = $row['id'] ;

                            ?>
                            <option <?php if($current_cate == $cate_id){echo "selected" ;} ?> value="<?php echo $cate_id;  ?>"><?php echo $cate_title; ?></option>
                          <?php
                        } 
                    }
                    else{
                        // cate is not avilable
                        echo "<option value='0'>Category Not Avilable</option>" ;
                    }
                   
                   ?>
                   
                   </select>
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
                        <input id="submit" type="submit" name="submit" value="Update Food" class="btn-secondary">
                       </td>
                   </tr>
        
        
       
        
        </table>
        </form>

    </div>
</div>

<?php
    if(isset($_POST['submit'])){
            //get the values from the form to update
        $id= $_POST['id'] ;
        $title= $_POST['title'] ;
        $description= $_POST['description'] ;
        $price= $_POST['price'] ;
        $current_image= $_POST['current_image'] ;
        $category= $_POST['category'] ;
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
                    $image_name ="food_name_".rand(000,999).'.'.$ext ;//e.g food_category_344.jpg 
                    $source_path =$_FILES['image']['tmp_name'] ;

                    $destination_path ="../images/food/".$image_name;

                    //upload the image
                    $upload = move_uploaded_file($source_path, $destination_path) ;

                    //check wether the image is uploaded
                    if($upload==false)
                    {
                            $_SESSION['upload'] = "<div class='error'>Failed To upload the image</div>" ;
                            //RETURN TO MANAGE category PAGE 
                        header("location:".SITEURL.'admin/manage-food.php') ;
                        //stop the process
                        die();

                    }

                    // remove current image
                    if($current_image !="")
                    {
                                    $path = "../images/food/".$current_image;
                            $remove = unlink($path) ;

                            // if failed to remove image
                        if($remove == false)
                        {
                                    $_SESSION['failed-remove'] = "<div class='error'>Failed To Remove current image </div> ";
                            //RETURN TO MANAGE cate PAGE 
                            header("location:".SITEURL.'admin/manage-food.php') ;  
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
    $sql3 = "UPDATE tbl_food SET
    title = '$title',
    description = '$description',
    price = $price ,
    image_name ='$image_name',
    category_id = '$category',
    featured = '$featured',
    active = '$active'
    WHERE id ='$id'
    ";

    //execute query
    $res3 = mysqli_query($con ,$sql3);

    // check the query
    if($res3==true){
        // data updated 
        // creat session 
        $_SESSION['update'] = "<div class='success'>Food Updated Successfully</div>" ;
        //RETURN TO MANAGE ADMIN PAGE 
        header("location:".SITEURL.'admin/manage-food.php') ;
    }
    else{
        // failed 
        // creat session 
        $_SESSION['update'] = "<div class='error'>Failed To Update Food</div>" ;
        //RETURN TO MANAGE ADMIN PAGE 
        header("location:".SITEURL.'admin/add-Food.php') ;
    }


    }



?>


<?php include('partials/footer.php'); ?>