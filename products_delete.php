<?php

session_start();
$page_title = "Deleted";

require "templates/functions.php";

$db = db_connect();
$id = mysqli_real_escape_string($db, $_GET['id']);
$sql = "DELETE from products where id=$id";

if (isset($_SESSION['username'])){
    $result = $db->query($sql);
    if ($result){
        header("Location: /products.php?msg=Product ID: $id Successfully Deleted");
    }else{
        header("Location: /products.php?msg=Error Deleting Product ID: $id");
    }
}else{
    header("Location: /products.php?msg=You need to login to delete ID: $id");
}





// To reset auto increment
// ALTER TABLE recipes AUTO_INCREMENT = 7;


?>
