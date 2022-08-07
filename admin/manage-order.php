<?php include('partials/menu.php') ?>

<div class="main-content">
        <div class="wrapper">
               <h1>Manage Orders</h1>
              
               <br> <br> <br>
               <?php
                  if(isset($_SESSION['no-order-found'])){
                    echo $_SESSION['no-order-found'] ;
                    unset($_SESSION['no-order-found']) ; //display just one time 
                }
                if(isset($_SESSION['update'])){
                  echo $_SESSION['update'] ;
                  unset($_SESSION['update']) ; //display just one time 
               }
               ?>

               <table class="tbl-full">
                  <tr>
                      <th>ID</th>
                      <th>Food</th>
                      <th>Price</th>
                      <th>Quantity</th>
                      <th>Total</th>
                      <th>Order Date</th>
                      <th>Status</th>
                      <th>Customer Name</th>
                      <th>Contact</th>
                      <th>Email</th>
                      <th>Address</th>
                      <th>Actions</th>
                      
                  </tr>

                  <?php
                    // get the data from db
                    $sql = "SELECT * FROM tbl_order ORDER BY id DESC" ;
                    $res = mysqli_query($con,$sql) ;

                    $count = mysqli_num_rows($res) ;

                    $sn= 1;
                    if($count){
                      // we have order 
                      while($row = mysqli_fetch_assoc($res))
                      {
                        $id = $row['id'];
                        $food = $row['food'];
                        $price = $row['price'];
                        $qty = $row['qty'];
                        $total = $row['total'];
                        $order_date = $row['order_date'];
                        $status = $row['status'] ;
                        $customer_name = $row['customer_name'] ;
                        $customer_contact = $row['customer_contact'] ;
                        $customer_email = $row['customer_email'] ;
                        $customer_address = $row['customer_address'] ;

                        ?>
                          <tr>
                              <td><?php echo $sn++ ?></td>
                              <td><?php echo $food ?></td>
                              <td><?php echo $price ?></td>
                              <td><?php echo $qty ?></td>
                              <td><?php echo $total ?></td>

                              <td>
                                <?php
                                  if($status=="ordered")
                                  {
                                    echo "<lable style='color:blue'>$status</lable>";
                                  }
                                  elseif($status=="on delivery")
                                  {
                                    echo "<lable style='color:orange'>$status</lable>";
                                  }
                                  elseif($status=="delivered")
                                  {
                                    echo "<lable style='color:green'>$status</lable>";
                                  }
                                  elseif($status=="cancled")
                                  {
                                    echo "<lable style='color:red'>$status</lable>";
                                  }
                                
                                ?>
                              </td>

                              <td><?php echo $status ?></td>
                              <td><?php echo $customer_name ?></td>
                              <td><?php echo $customer_contact ?></td>
                              <td><?php echo $customer_email ?></td>
                              <td><?php echo $customer_address ?></td>
                              <td>
                                <a href="<?php echo  SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-secondary">Update Order</a> 
                                  
                              </td>
                          </tr>


                        <?php
                      }
                    }
                    else{
                      // we dont have order
                      ?>
                            <tr>
                              <td colspan="12"><div class="error">No Orders Added Yet</div></td>
                            </tr>

                            <?php 
                    }
                  ?>

                  

                  
               </table>

               
            </div>
        </div>


<?php include('partials/footer.php') ?>