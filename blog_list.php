<?php

$page_title = "Blogs List";
require "templates/header.php";
require "templates/functions.php";

$db = db_connect();
$message = mysqli_real_escape_string($db, $_GET["msg"]);

if (!empty($message)){
    echo "<p class='center error'>$message</p><br/>";
}


echo "<hr>";

$sql = "select * from blogs";
$result = $db->query($sql);

if(isset($_SESSION['username'])){
    $thth = "<th></th><th></th>";
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

while (list($blog_id, $title,
    $author,
    $blog_text,
    $date_posted,
    $created_date,
    $modified_date) = $result->fetch_row()){

    if(isset($_SESSION['username'])){
        $edde = "<td><a href='/blog_update.php?id=$blog_id'>Edit</a></td><td><a href='/blog_delete.php?id=$blog_id'>Delete</a></td>";
    }

    $row = <<<ROW

<tr>
<td><a href='/blog_show.php?id=$blog_id'>$title</a></td>
<td>$author</td>
<td>$date_posted</td>
$edde
</tr>

ROW;

    echo $row;

}

echo "</table>";

echo "<br/>";

echo "<p class='center'><a href='blog.php'>Back to Blog</a></p>";


require "templates/footer.php";

?>
