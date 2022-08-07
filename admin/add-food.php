<?php include('partials/menu.php'); ?>

<div class="main-content">
        <div class="wrapper">
               <h1>Add Food</h1>
               <br><br>

                <?php
                    if(isset($_SESSION['upload'])){
                        echo $_SESSION['upload'] ;
                        unset($_SESSION['upload']) ; //display just one time 
                    }
                
                ?>

               <form action="" method="POST" enctype="multipart/form-data">
                <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                    <input type="text" name="title" placeholder="food title">
                    </td>
               </tr>

               <tr>
                    <td>Description: </td>
                    <td>
                    <textarea name="description" id="" cols="30" rows="5" placeholder="desciption of the table"></textarea>
                    </td>
               </tr>

               <tr>
                    <td>Price: </td>
                    <td>
                    <input type="number" name="price" >
                    </td>
               </tr>

               <tr>
                    <td>Image:</td>
                    <td>
                    <input type="file" name="image" >
                    </td>
               </tr>

               <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category" >

                            <?php 
                                // get the data from db
                                //1.create query to get only active cate
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes' ";

                                $res = mysqli_query($con,$sql) ;
                                //check if we have any cate
                                $count = mysqli_num_rows($res) ;
                                if($count>0){
                                    // we have cate
                                    while($row = mysqli_fetch_assoc($res)){
                                        $id = $row['id'] ;
                                        $title = $row['title'] ;
                                        ?>
                                            <option value="<?php echo $id;  ?>"><?php echo $title; ?></option>
                                        <?php
                                    }
                                }

                                else{
                                    // we dont have cate
                                    ?>
                                    <option value="0">No Category Found</option>
                                    <?php
                                }

                            ?>
                        </select>
                    </td>
               </tr>

               

               <tr>
                    <td>Featured: </td>
                    <td>
                    <input type="radio" name="featured" value="Yes"> Yes
                    <input type="radio" name="featured" value="No"> No
                    </td>
               </tr>

               <tr>
                    <td>Active: </td>
                    <td>
                    <input type="radio" name="active" value="Yes"> Yes
                    <input type="radio" name="active" value="No"> No
                    </td>
               </tr>
               <tr>
                       <td colspan="2">
                        <input id="submit" type="submit" name="submit" value="Add Food" class="btn-secondary">
                       </td>
                   </tr>
                
                </table>

               </form>
        </div>

</div>
<?php
    if(isset($_POST['submit'])){
        // button clicked 
        // get the data 
        $title = $_POST['title'] ;
        $description = $_POST['description'] ;
        $price = $_POST['price'] ;
        $category = $_POST['category'] ;

        //check if the radio button is selected or not
        if(isset($_POST['featured'])){
            //get the value
            $featured = $_POST['featured'] ;
        }
        else{
            // set the defaoult value
            $featured="No" ;

        }

        if(isset($_POST['active'])){
            //get the value
            $active = $_POST['active'] ;
        }
        else{
            // set the defaoult value
            $active="No" ;

        }   

        // check wether the image is selected or not 
        if(isset($_FILES['image']['name'])){
            //upload the image
            $image_name =$_FILES['image']['name'] ;
    
            // upload image only if selected 
            if($image_name !="")
            {
                //auto rename the image
                //get the extention of the image
                $ext = end(explode('.',$image_name));
    
                //rename the image 
                $image_name ="food_name_".rand(000,999).'.'.$ext ;//e.g food_category_344.jpg 

                $source_path =$_FILES['image']['tmp_name'] ;
    
                $destination_path ="../images/food/".$image_name;
    
                $upload = move_uploaded_file($source_path, $destination_path) ;
    
                //check wether the image is uploaded
                if($upload==false){
                    $_SESSION['upload'] = "<div class='error'>Failed To upload the image</div>" ;
                    //RETURN TO add food PAGE 
                header("location:".SITEURL.'admin/add-food.php') ;
                //stop the process
                die();
    
                }
            }
        }
    
        else{
            //not upload the image and set the value as blank
            $image_name ="" ;
           
        }

        //create the query 
    $sql2 = "INSERT INTO tbl_food SET
    title = '$title',
    description = '$description',
    price = $price,
    image_name = '$image_name',
    category_id = $category,
    featured = '$featured',
    active = '$active'
    ";
    // executing query and saving the data in database
    $res2 = mysqli_query($con ,$sql2);

    //check the data is inserted or not and display message 
    if($res2==true){
        // data inserted 
        // creat session value for display the message
        $_SESSION['add'] = "<div class='success'>Food Added Successfully</div>" ;
        //RETURN TO MANAGE food PAGE 
        header("location:".SITEURL.'admin/manage-food.php') ;
    }
    else{
        // failed 
        // creat session value for display the message
        $_SESSION['add'] = "<div class='error'>Failed To Add Food</div>" ;
        //RETURN TO MANAGE category PAGE 
        header("location:".SITEURL.'admin/manage-food.php') ;
    }

    }
    


?>


<?php include('partials/footer.php'); ?>