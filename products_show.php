<?php

$page_title = "Products show";
require "templates/header.php";
require "templates/functions.php";

$db = db_connect();
$message = mysqli_real_escape_string($db, $_GET["msg"]);

if (!empty($message)){
    echo "<p class='center error'>$message</p><br/>";
}

?>


<?php

$id = mysqli_real_escape_string($db, $_GET['id']);


$sql = "select AVG(rating) from reviews where product_id=$id";
$result = $db->query($sql);
$avg_rating = $result->fetch_row()[0];


echo "<p class='center adjustF'>Average Rating: $avg_rating</p>";

$avg_stars = "";

for($x=0; $x < round($avg_rating); $x++ ){
    $avg_stars .= "<img class='setSize2' src='images/Star.PNG'/>";
}

echo "<p class='center adjustF3'>$avg_stars</p>";
echo "<br/>";


$sql = "select * from products where id=$id";
//echo $sql . "<br/>";
$result = $db->query($sql);

list($id, $name,
    $description,
    $price,
    $cost,
    $qty_on_hand,
    $image, $thumb) = $result->fetch_row();
echo "<p class='center'>";
echo "Name of Product:--- " . $name . "<br/>";
echo  "Description of Product:--- " . $description . "<br/>";
echo  "Price of Product:--- $" . $price . "<br/>";
echo  "Cost of Product:--- $" . $cost . "<br/>";
echo  "Qty on Hands:--- " . $qty_on_hand . "<br/>";
echo "<img = src=\"$image\"/><br/>";
echo "<hr>";
echo "<h2 class='center'>Reviews</h2>";
echo "<hr>";
echo "</p>";

$sql = "select * from reviews where product_id=$id";
//echo $sql . "<br/>";
$result = $db->query($sql);

while (list($review_id, $author,
    $review,
    $rating,
    $created_at,
    $product_id) = $result->fetch_row()){

    $stars = "";

    for($x=0; $x < $rating; $x++ ){
        $stars .= "<img class='setSize' src='images/Star.PNG'/>";
    }

    echo "<div class='center'>
    <p>Rating: $stars </p><br/>
    <p>$author says: $review</p>";

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

$rating_array = [
    " ",
    1,
    2,
    3,
    4,
    5
];

$select_box = CreateSelectBox("rating", $rating_array, $selected_rating);

$review_form = <<<REVIEW

<div class="center">
    <p>
       <form action="products_review_new.php" method="post">
        <input type="hidden" name="product_id" value="$id" />
        <label for='author'>Author</label>
        <input type="text" name="author" value="" /><br/>
        <label for="review">Review:</label>
        <textarea name="review"></textarea><br/>
        <label for="rating">Rating:</label>
        $select_box
        <br/>
        <input type="submit" name="submit" value="Post Review"/>
       </form>
    </p>
</div>

REVIEW;

if(isset($_SESSION['username'])){
    echo $review_form;
}


echo "<p class='center'>";
echo "<a href='/products.php'>Back to Index</a><br/>";

if(isset($_SESSION['username'])){
    echo "<a href='/products_edit.php?id=$id'>Edit</a></p>";
}

require "templates/footer.php";

?>


