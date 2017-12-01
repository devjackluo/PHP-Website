<?php

$page_title = "Articles Show";
require "templates/header.php";
require "templates/functions.php";

$db = db_connect();
$message = mysqli_real_escape_string($db, $_GET["msg"]);

if (!empty($message)){
    echo "<p class='center error'>$message</p><br/>";
}


$id = mysqli_real_escape_string($db, $_GET['id']);
$sql = "select * from articles where article_id=$id";
$result = $db->query($sql);

list($article_id, $title,
    $author,
    $article_text,
    $date_posted,
    $created_date,
    $modified_date) = $result->fetch_row();

echo "<p class='center adjustW'>";
echo "Title: $title <br/>";
echo "<br/>";
echo "Author: $author <br/>";
echo "<br/>";
echo "Article: $article_text <br/>";
echo "<br/>";
echo "Date Posted: $date_posted <br/>";
echo "<br/>";
echo "<hr></p>";

echo "<p class='center'>";
echo "<a href='/articles_list.php'>Back to Articles List</a><br/>";
echo "<a href='/articles.php'>Back to Articles</a><br/>";

if(isset($_SESSION['username'])){
    echo "<a href='/articles_update.php?id=$id'>Edit this Article</a></p>";
}

require "templates/footer.php";

?>
