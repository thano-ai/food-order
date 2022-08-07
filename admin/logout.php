<?php
//connect the constrants
include('../config/constants.php') ;

// finish thr session 
session_destroy() ; // user session

//and return login page
header("location:".SITEURL.'admin/login.php') ;

?>