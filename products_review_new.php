<?php
//ob_start();
session_start();
include "templates/functions.php";

$db = db_connect();
$product_id = mysqli_real_escape_string($db, $_POST['product_id']);
$author = mysqli_real_escape_string($db, $_POST['author']);
$rating = mysqli_real_escape_string($db, $_POST['rating']);
$review = mysqli_real_escape_string($db, $_POST['review']);
$submit = mysqli_real_escape_string($db, $_POST['submit']);


$sql = "insert into reviews (id, Author, review, rating, create_at, product_id) values (null, '$author', '$review', $rating, now(), $product_id)";
//echo $sql . "<br/>";

if(empty($rating) || empty($author) || empty($review)){

    header("Location: /products_show.php?id=$product_id&msg=You must complete all fields");

}else{

    if (isset($_SESSION['username'])){
        $result = $db->query($sql);
        header("Location: /products_show.php?id=$product_id");
    }else{
        header("Location: /products_show.php?id=$product_id&msg=You need to login to review");
    }

}


?>