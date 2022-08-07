<?php include('partials/menu.php') ?>

        <!-- main content section starts -->
        <div class="main-content">
        <div class="wrapper">
               <h1>Manage Admin</h1>
               <br> 

               <!-- display message  -->
               <?php
               if(isset($_SESSION['add'])){
                  echo $_SESSION['add'] ;
                  unset($_SESSION['add']) ; //display just one time 
               }
               if(isset($_SESSION['delete'])){
                  echo $_SESSION['delete'] ;
                  unset($_SESSION['delete']) ; //display just one time 
               }
               if(isset($_SESSION['update'])){
                  echo $_SESSION['update'] ;
                  unset($_SESSION['update']) ; //display just one time 
               }
               if(isset($_SESSION['noUser'])){
                  echo $_SESSION['noUser'] ;
                  unset($_SESSION['noUser']) ; //display just one time 
               }
               if(isset($_SESSION['change'])){
                  echo $_SESSION['change'] ;
                  unset($_SESSION['change']) ; //display just one time 
               }
               if(isset($_SESSION['noMatch'])){
                  echo $_SESSION['noMatch'] ;
                  unset($_SESSION['noMatch']) ; //display just one time 
               }

               if(isset($_SESSION['no-admin-found'])){
                  echo $_SESSION['no-admin-found'] ;
                  unset($_SESSION['no-admin-found']) ; //display just one time 
               }


               ?>
               <br><br>

               <!-- button to add admin -->
               <a href="<?php echo  SITEURL; ?>admin/add-admin.php" class="btn-primary">Add Admin</a>
               <br> <br> <br>

               <table class="tbl-full">
                  <tr>
                      <th>ID</th>
                      <th>Full Name</th>
                      <th>Username</th>
                      <th>Actions</th>
                      
                  </tr>

                  <?php
                  // display from database
                  $sql = "SELECT * from tbl_admin" ;
                  $res = mysqli_query($con,$sql) ;

                  // check the query 
                  if($res==true){
                     // count the rows in db 
                     $count = mysqli_num_rows($res) ;
                     $sn=1;

                     //check the data in db 
                     if($count>0){
                        // we have data in db
                        while($rows = mysqli_fetch_array($res)){
                           // get the data 
                           $id = $rows['id'] ; 
                           $full_name = $rows['full_name'] ;
                           $username = $rows['username'] ;
                           
                           // display in the table 
                           ?>

                                 <tr>
                                    <td><?php echo $sn++?></td>
                                    <td><?php echo $full_name?></td>
                                    <td><?php echo $username?></td>
                                    <td>
                                       <a href="<?php echo  SITEURL; ?>admin/change-password.php?id=<?php echo $id; ?>" class="btn-primary">change password</a>
                                       <a href="<?php echo  SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a> 
                                       <a href="<?php echo  SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a> 
                                    </td>
                                 </tr>


                           <?php
                        }
                     }
                     else{
                        // we dont have data in db
                     }
                  }
                  
                  
                  ?>
               </table>

               
            </div>
        </div>
        <!-- main content section ends -->

<?php include('partials/footer.php') ?>