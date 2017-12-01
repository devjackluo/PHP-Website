<?php
ob_start();
$page_title = "Contact Us";
$samepage = "contactus.php";
require "templates/header.php";
include "templates/functions.php";

$db = db_connect();
$message = mysqli_real_escape_string($db, $_GET["msg"]);

if (!empty($message)){
    echo "<p class='center error'>$message</p><br/>";
}

/*
$name = $_POST["name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$question = $_POST["question"];
$contact = $_POST["contact"];
$selected_fruit = $_POST["fruits"];
$news = $_POST["news"];
$new = $_POST["new"];
$submit = $_POST["submit"];
*/

require "templates/form.php";
require "templates/footer.php";


ob_end_flush();
?>



