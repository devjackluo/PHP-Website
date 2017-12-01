<?php
ob_start();
$page_title = "Blogs Show";
require "templates/header.php";
require "templates/functions.php";

$db = db_connect();
$message = mysqli_real_escape_string($db, $_GET["msg"]);

if (!empty($message)){
    echo "<p class='center error'>$message</p><br/>";
}


$id = mysqli_real_escape_string($db, $_GET['id']);

$sql = "select AVG(rating) from comments where blog_id=$id";
$result = $db->query($sql);
$avg_rating = $result->fetch_row()[0];


echo "<p class='center adjustF'>Average Rating: $avg_rating</p>";

$avg_stars = "";

for($x=0; $x < round($avg_rating); $x++ ){
    $avg_stars .= "<img class='setSize2' src='images/Star.PNG'/>";
}

echo "<p class='center adjustF3'>$avg_stars</p>";
echo "<br/>";

$sql = "select * from blogs where blog_id=$id";
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

echo "<hr>";
echo "<h2 class='center'>Comments</h2>";
echo "<hr>";
echo "</p>";


$sql = "select * from comments where blog_id=$id";
//echo $sql . "<br/>";
$result = $db->query($sql);

while (list($review_id, $author,
    $comments,
    $rating,
    $created_at,
    $blog_id) = $result->fetch_row()){

$stars = "";

for($x=0; $x < $rating; $x++ ){
    $stars .= "<img class='setSize' src='images/Star.PNG'/>";
}

echo "<div class='center'>
    <p>Rating: $stars </p><br/>
    <p>$author says: $comments</p>";

    $time = strtotime($created_at);

    if (! function_exists('humanTiming')) {
        function humanTiming ($time)
        {

            $time = time() - $time; // to get the time since that moment
            $time = ($time<1)? 1 : $time;
            $tokens = array (
                31536000 => 'year',
                2592000 => 'month',
                604800 => 'week',
                86400 => 'day',
                3600 => 'hour',
                60 => 'minute',
                1 => 'second'
            );

            foreach ($tokens as $unit => $text) {
                if ($time < $unit) continue;
                $numberOfUnits = floor($time / $unit);
                return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
            }

        }
    }

    echo humanTiming($time).' ago';

echo "</div>
<hr>";


}

$blog_id = mysqli_real_escape_string($db, $_POST['blog_id']);
$author = mysqli_real_escape_string($db, $_POST['author']);
$rating = mysqli_real_escape_string($db, $_POST['rating']);
$comment = mysqli_real_escape_string($db, $_POST['comment']);
$submit = mysqli_real_escape_string($db, $_POST['submit']);


if (!empty($submit) && !empty($author) && !empty($comment) && !empty($rating) && $rating < 6 && $rating > 0){

    $db = db_connect();
    $sql = "insert into comments (id, Author, comment, rating, created_at, blog_id) values (null, \"$author\", \"$comment\", $rating, now(), $blog_id)";

    if(isset($_SESSION['username'])){
        $result = $db->query($sql);

        if ($result){
            ob_clean();
            header("Location: /blog_comment_new.php?blog_id=$blog_id");
        }
    }else{

        header("Location: /blog_show.php?id=$id&msg=You need to login to comment");
    }


}else if(!empty($submit)){

    $error = "";
    if (empty($author)) {
        $error .= "Author is required<br/>";
    }

    if (empty($comment)) {
        $error .= "Comment is required<br/>";
    }

    if (empty($rating) || $rating > 5 || $rating < 0) {
        $error .= "Rating is invalid. 1 - 5 <br/>";
    }

}


if ($error != "") {
    echo "<div class='error'>$error</div>";
}




$rating_array = [
    " ",
    1,
    2,
    3,
    4,
    5
];

$select_box = CreateSelectBox("rating", $rating_array, $selected_rating);


$comment_form = <<<COMMENT

<div class="center">
    <h2 class='center'>Write a comment</h2>
    <p>
    <form action="blog_show.php?id=$id" method="post">
        <input type="hidden" name="blog_id" value="$id" />
        <label for='author'>Author</label>
        <input type="text" name="author" value="$author" /><br/>
        <label for="comment">Comment:</label>
        <textarea name="comment" id="comment">$comment</textarea><br/>
        <label for="rating">Rating:</label>
        $select_box
        <br/>
        <input type="submit" name="submit" value="Post Comment"/>
    </form>
    </p>
</div>
<hr>

COMMENT;

if(isset($_SESSION['username'])){
    echo $comment_form;
}




echo "</p>";
echo "<p class='center'>";
echo "<a href='/blog_list.php'>Back to Blogs List</a><br/>";
echo "<a href='/blog.php'>Back to Blogs</a><br/>";

if(isset($_SESSION['username'])){
    echo "<a href='/blog_update.php?id=$id'>Edit this Blog</a></p>";
}

require "templates/footer.php";
ob_end_flush()
?>
