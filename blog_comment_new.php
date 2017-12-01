<?php
//ob_start();
include "templates/functions.php";

/*
$blog_id = $_POST['blog_id'];
$author = $_POST['author'];
$rating = $_POST['rating'];
$comment = $_POST['comment'];
$submit = $_POST['submit'];
$rating = (int)$rating;



$sql = "insert into comments (id, Author, comment, rating, created_at, blog_id) values (null, '$author', '$comment', $rating, now(), $blog_id)";
echo $sql . "<br/>";
$result = $db->query($sql);

//header("Location: /blog_show.php?id=$blog_id");
*/

$db = db_connect();

$blog_id = mysqli_real_escape_string($db, $_GET['blog_id']);
header("Location: /blog_show.php?id=$blog_id");

?>