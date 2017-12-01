<?php

$page_title = "About Us";
$samepage = "aboutus.php";
require "templates/header.php";


include "templates/functions.php";

$db = db_connect();
$message = mysqli_real_escape_string($db, $_GET["msg"]);

if (!empty($message)){
    echo "<p class='center error'>$message</p><br/>";
}



require "templates/form.php";
require "templates/footer.php";

?>
