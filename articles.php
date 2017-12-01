<?php

$page_title = "Articles";
require "templates/header.php";
require "templates/functions.php";

$db = db_connect();
$message = mysqli_real_escape_string($db, $_GET["msg"]);

if (!empty($message)){
    echo "<p class='center error'>$message</p><br/>";
}

if(isset($_SESSION['username'])){
    echo "<p class='center'><a class='adjustF2' href='articles_new.php'>Write new article</a></p>";
}

echo "<p class='center'><a class='adjustF2' href='articles_list.php'>Go to article list</a></p>";
echo "<hr>";

echo "<p class='center adjustF'>Lastest Article:</p><br/>";


$sql = "select * from articles order by created_at DESC limit 1";
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
echo "</p>";

require "templates/footer.php";

?>
