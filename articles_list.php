<?php

$page_title = "Articles List";
require "templates/header.php";
require "templates/functions.php";

$db = db_connect();
$message = mysqli_real_escape_string($db, $_GET["msg"]);

if (!empty($message)){
    echo "<p class='center error'>$message</p><br/>";
}


echo "<hr>";



$sql = "select * from articles";
$result = $db->query($sql);

if(isset($_SESSION['username'])){
    $thth = "<th></th><th></th><th></th>";
}

$table = <<<TABLE

<table border="1">
<tr>
<th>Title</th>
<th>Author</th>
<th>Published Date</th>
$thth
</tr>


TABLE;

echo $table;

while (list($article_id, $title,
    $author,
    $article_text,
    $date_posted,
    $created_date,
    $modified_date) = $result->fetch_row()){

    if(isset($_SESSION['username'])){
        $edde = "<td><a href='/articles_update.php?id=$article_id'>Edit</a></td>
<td><a href='/articles_delete.php?id=$article_id'>Delete</a></td>
<td><a href='/articles_email.php?id=$article_id'>Email</a></td>";
    }

    $row = <<<ROW

<tr>
<td><a href='/articles_show.php?id=$article_id'>$title</a></td>
<td>$author</td>
<td>$date_posted</td>
$edde
</tr>

ROW;

    echo $row;

}

echo "</table>";

echo "<br/>";

echo "<p class='center'><a href='articles.php'>Back to article</a></p>";


require "templates/footer.php";

?>
