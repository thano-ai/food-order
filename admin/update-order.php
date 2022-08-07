<?php include('partials/menu.php') ?>

<div class="main-content">
        <div class="wrapper">
               <h1>Update Orders</h1>
              
               <br> <br> <br>
               <?php
                 // check the id 
                 if(isset($_GET)){
                     //get the detaiels
                     $id = $_GET['id'] ; 

                     // creat sql
                $sql = "SELECT * FROM tbl_order WHERE id = $id";
                //execute sql
                $res = mysqli_query($con,$sql) ;
                if($res==true){
                    //check the data
                    $count = mysqli_num_rows($res) ;
                    if($count==1){
                        //get the details
                       $row = mysqli_fetch_array($res) ;
                       $food= $row['food'] ;
                       $price= $row['price'] ;
                       $qty= $row['qty'] ;
                       $status= $row['status'] ;
                       $customer_name= $row['customer_name'] ;
                       $customer_contact= $row['customer_contact'] ;
                       $customer_email= $row['customer_email'] ;
                       $customer_address= $row['customer_address'] ;



                    }
                    else{
                        $_SESSION['no-order-found'] = "<div class='error'>Order not found</div>" ;
                        // return to the manage cate
                        header("location:".SITEURL.'admin/manage-cate.php') ;
                    }
                }

                //execute sql
                $res = mysqli_query($con,$sql) ;


                 }
                 else{
                     //RETURN TO MANAGE order PAGE 
                header("location:".SITEURL.'admin/manage-order.php') ;
                 }
               ?>

               <form action="" method="POST">
                   <table class="tbl-30">
                       <tr>
                           <td>Food Name:</td>
                           <td><b><?php echo $food ;?></b></td>
                       </tr>

                       <tr>
                           <td>Price:</td>
                           <td><b>$<?php echo $price; ?></b></td>
                       </tr>


                       <tr>
                           <td>Quantity:</td>
                           <td> <input type="number" name="qty" value="<?php echo $qty; ?>"> </td>
                           
                       </tr>
                       <tr>
                           <td>Status:</td>
                           <td> 
                               <select name="status" >
                                   <option <?php if($status=="ordered"){echo "selected" ;} ?> value="ordered">orderd</option>
                                   <option <?php if($status=="on delivery"){echo "selected" ;} ?>  value="on delivery">on delivery</option>
                                   <option <?php if($status=="delivered"){echo "selected";} ?>  value="delivered">delivered</option>
                                   <option <?php if($status=="cancled"){echo "selected";} ?>  value="cancled">cancled</option>
                               </select>
                           </td>
                       </tr>

                       <tr>
                           <td>Customer Name:</td>
                           <td><input type="text" name="customer-name" value="<?php echo $customer_name; ?>"></td>
                       </tr>

                       <tr>
                           <td>Customer Contact:</td>
                           <td><input type="text" name="customer-contact" value="<?php echo $customer_contact; ?>"></td>
                       </tr>

                       <tr>
                           <td>Customer Email:</td>
                           <td><input type="text" name="customer-email" value="<?php echo $customer_email; ?>"></td>
                       </tr>

                       <tr>
                           <td>Customer Address:</td>
                           <td><textarea name="customer-address" cols="30" rows="5"><?php echo $customer_address; ?></textarea></td>
                       </tr>

                       <tr>
                           <td colspan="6"> 
                               <input type="hidden" name="id" value="<?php echo $id; ?>">
                               <input type="hidden" name="price" value="<?php echo $price; ?>">
                               <input type="submit" name="submit" value="Update Order"  class="btn-secondary">
                           </td>
                       </tr>


                   </table>
               </form>

               <?php
                // check the submit button 
                if(isset($_POST['submit'])){
                       $id= $_POST['id'] ;
                       $price= $_POST['price'] ;
                       $qty= $_POST['qty'] ;
                       $total= $price * $qty;
                       $status= $_POST['status'] ;
                       $customer_name= $_POST['customer-name'] ;
                       $customer_contact= $_POST['customer-contact'] ;
                       $customer_email= $_POST['customer-email'] ;
                       $customer_address= $_POST['customer-address'] ;

                        // create the query 
                        $sql2 = "UPDATE tbl_order SET
                        qty = $qty,
                        total = $total,
                        status ='$status',
                        customer_name = '$customer_name',
                        customer_contact = '$customer_contact',
                        customer_email = '$customer_email',
                        customer_address = '$customer_address'
                        WHERE id ='$id'
                        ";

                        //execute query
                        $res2 = mysqli_query($con ,$sql2);

                        // check the query
                        if($res2==true){
                            // data updated 
                            // creat session 
                            $_SESSION['update'] = "<div class='success'>Order Updated Successfully</div>" ;
                            //RETURN TO MANAGE order PAGE 
                            header("location:".SITEURL.'admin/manage-order.php') ;
                        }
                        else{
                            // failed 
                            // creat session 
                            $_SESSION['update'] = "<div class='error'>Failed To Update Order</div>" ;
                            //RETURN TO MANAGE order PAGE 
                            header("location:".SITEURL.'admin/manage-order.php') ;
                        }


                }
               ?>
    </div>
</div>


<?php include('partials/footer.php') ?>