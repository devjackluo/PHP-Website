<?php

$page_title = "Blogs";
require "templates/header.php";
require "templates/functions.php";

$db = db_connect();
$message = mysqli_real_escape_string($db, $_GET["msg"]);

if (!empty($message)){
    echo "<p class='center error'>$message</p><br/>";
}

if(isset($_SESSION['username'])){
    echo "<p class='center'><a class='adjustF4' href='blog_new.php'>Write new blog</a></p>";
}

echo "<p class='center'><a class='adjustF4' href='blog_list.php'>Go to blog list</a></p>";
echo "<hr>";

echo "<p class='center adjustF'>Lastest Blog:</p><br/>";



$sql = "select * from blogs order by created_at DESC limit 1";
$result = $db->query($sql);

list($blog_id, $title,
    $author,
    $blog_text,
    $date_posted,
    $created_date,
    $modified_date) = $result->fetch_row();

echo "<p class='center adjustW'>";
echo "Title: $title <br/>";
echo "<br/>";
echo "Author: $author <br/>";
echo "<br/>";
echo "Blog: $blog_text <br/>";
echo "<br/>";
echo "Date Posted: $date_posted <br/>";
echo "<br/>";
echo "</p>";

require "templates/footer.php";

?>
