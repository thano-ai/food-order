<?php include('partials/menu.php'); ?>

<div class="main-content">
        <div class="wrapper">
               <h1>Add Category</h1>
               <br>  <br>
               <?php
                    if(isset($_SESSION['add'])){
                        echo $_SESSION['add'] ;
                        unset($_SESSION['add']) ; //display just one time 
                    }

                    if(isset($_SESSION['upload'])){
                        echo $_SESSION['upload'] ;
                        unset($_SESSION['upload']) ; //display just one time 
                    }
               ?>
               <br><br>

               <!-- add category form starts -->
               <form action="" method="POST" enctype="multipart/form-data">
               <table class="tbl-30">
               <tr>
                    <td>Title: </td>
                    <td>
                    <input type="text" name="title" placeholder="category title">
                    </td>
               </tr>

               <tr>
                    <td>Image:</td>
                    <td>
                    <input type="file" name="image" >
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
                        <input id="submit" type="submit" name="submit" value="Add Category" class="btn-secondary">
                       </td>
                   </tr>


               </table>
               </form>
                <!-- add category form ends -->
        </div>
</div>

<?php
if(isset($_POST['submit'])){
    // button clicked 
    // get the data 
    $title = $_POST['title'] ;

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
    // print_r($_FILES['image']);
    // die() ;// breack the code

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
            $image_name ="food_category_".rand(000,999).'.'.$ext ;//e.g food_category_344.jpg 
            $source_path =$_FILES['image']['tmp_name'] ;

            $destination_path ="../images/category/".$image_name;

            $upload = move_uploaded_file($source_path, $destination_path) ;

            //check wether the image is uploaded
            if($upload==false){
                $_SESSION['upload'] = "<div class='error'>Failed To upload the image</div>" ;
                //RETURN TO add category PAGE 
            header("location:".SITEURL.'admin/add-cate.php') ;
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
    $sql = "INSERT INTO tbl_category SET
    title = '$title',
    image_name = '$image_name',
    featured = '$featured',
    active = '$active'
    ";
    // executing query and saving the data in database
    $res = mysqli_query($con ,$sql);

    //check the data is inserted or not and display message 
    if($res==true){
        // data inserted 
        // creat session value for display the message
        $_SESSION['add'] = "<div class='success'>Category Added Successfully</div>" ;
        //RETURN TO MANAGE category PAGE 
        header("location:".SITEURL.'admin/manage-cate.php') ;
    }
    else{
        // failed 
        // creat session value for display the message
        $_SESSION['add'] = "<div class='error'>Failed To Add Category</div>" ;
        //RETURN TO MANAGE category PAGE 
        header("location:".SITEURL.'admin/manage-cate.php') ;
    }

 

}




?>

<?php include('partials/footer.php'); ?>

