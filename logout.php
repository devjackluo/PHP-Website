<?php

session_start();
session_destroy();
header("Location: /products.php");


/*

if(isset($_SESSION['username'])){
    $loggeduser = $_SESSION['username'];
    $logout_message = "<p class=\"center\">Goodbye, $loggeduser</p>";
    session_destroy();
}

$page_title = "Logout";
require "templates/header.php";
echo $logout_message;
require "templates/footer.php";

*/

?>
