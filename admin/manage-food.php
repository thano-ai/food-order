<?php include('partials/menu.php') ?>

<div class="main-content">
        <div class="wrapper">
               <h1>Manage Foods</h1>
               <br> <br>

               <!-- button to add admin -->
               <a href="<?php echo  SITEURL; ?>admin/add-food.php" class="btn-primary">Add Food</a>
               <br> <br> <br>

               <?php
                if(isset($_SESSION['add'])){
                  echo $_SESSION['add'] ;
                  unset($_SESSION['add']) ; //display just one time 
              }
              if(isset($_SESSION['delete'])){
                echo $_SESSION['delete'] ;
                unset($_SESSION['delete']) ; //display just one time 
            }
            if(isset($_SESSION['remove'])){
              echo $_SESSION['remove'] ;
              unset($_SESSION['remove']) ; //display just one time 
          }
            if(isset($_SESSION['Unauthorized'])){
            echo $_SESSION['Unauthorized'] ;
            unset($_SESSION['Unauthorized']) ; //display just one time 
        }
        if(isset($_SESSION['no-food-found'])){
          echo $_SESSION['no-food-found'] ;
          unset($_SESSION['no-food-found']) ; //display just one time 
      }

      if(isset($_SESSION['upload'])){
        echo $_SESSION['upload'] ;
        unset($_SESSION['upload']) ; //display just one time 
    }
    if(isset($_SESSION['failed-remove'])){
      echo $_SESSION['failed-remove'] ;
      unset($_SESSION['failed-remove']) ; //display just one time 
   }
   if(isset($_SESSION['update'])){
    echo $_SESSION['update'] ;
    unset($_SESSION['update']) ; //display just one time 
 }
               
               ?>

               <table class="tbl-full">
                  <tr>
                      <th>ID</th>
                      <th>Title</th>
                      <th>price</th>
                      <th>Image</th>
                      <th>Featured</th>
                      <th>Active</th>
                      <th>Actions</th>
                      
                  </tr>

                  <?php
                        // display from database
                        $sql = "SELECT * from tbl_food" ;
                        $res = mysqli_query($con,$sql) ;

                        if($res==true){
                          $count = mysqli_num_rows($res) ;
                          $sn=1;

                          if($count>0){
                            // we have data in db
                            while($rows = mysqli_fetch_assoc($res)){
                              // get the data 
                              $id = $rows['id'] ; 
                              $title = $rows['title'] ;
                              $price = $rows['price'] ;
                              $image_name = $rows['image_name'] ;
                              $featured = $rows['featured'] ;
                              $active = $rows['active'] ;

                              // display in the table 
                              ?>

                              <tr>
                                <td><?php echo $sn++?></td>
                                <td><?php echo $title?></td>
                                <td><?php echo $price?></td>

                                <td>
                                  <?php 
                                    //check the image name is avilable or not
                                    if($image_name!="")
                                    {
                                      // display the image 
                                      ?>
                                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?> " width=100px >
                                      <?php
                                    }
                                    else
                                    {
                                      // display the message
                                      echo "<div class='error'>Image Not Added</div>";
                                    }
                                  ?>
                                </td>

                                <td><?php echo $featured?></td>
                                <td><?php echo $active?></td>
                                <td>
                                    
                                    <a href="<?php echo  SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>" class="btn-secondary">Update Food</a> 
                                    <a href="<?php echo  SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Food</a> 
                                </td>
                              </tr>
                              <?php
                            }   

                          }
                          else{
                            //there is no data 
                            //display message 
                            ?>
                            <tr>
                              <td colspan="7"><div class="error">No Food Added Yet</div></td>
                            </tr>

                            <?php 
                          }
                        }
                      
                  ?>
               </table>

               
            </div>
        </div>


<?php include('partials/footer.php') ?>