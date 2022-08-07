<?php
// check wether user is loged in or not access control
if(!isset($_SESSION['user'])) // if user seeion is not set
{
    //user is not loged in
    $_SESSION['nologin-message'] ="<div class='error text-center'>please login to access admin panel</div>";
    //RETURN TO login.php PAGE 
    header("location:".SITEURL.'admin/login.php') ;

}

?>