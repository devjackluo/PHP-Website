<?php
session_start();
$page_title = "Deleted";

require "templates/functions.php";

$db = db_connect();
$id = mysqli_real_escape_string($db, $_GET['id']);
$sql = "DELETE from blogs where blog_id=$id";

if (isset($_SESSION['username'])){
    $result = $db->query($sql);
    if ($result){
        header("Location: /blog_list.php?msg=Successfully Deleted");
    }else{
        header("Location: /blog_list.php?msg=Error Deleting");
    }
}else{
    header("Location: /blog_list.php?msg=You need to login to delete");
}



?>