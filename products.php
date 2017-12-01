<?php

//$_SESSION["username"] = "Dave Jones";

$page_title = "Products";
require "templates/header.php";
require  "templates/functions.php";

$db = db_connect();
$message = mysqli_real_escape_string($db, $_GET["msg"]);

if (!empty($message)){
    echo "<p class='center error'>$message</p><br/>";
}

if(isset($_SESSION['username'])){
    echo "<p class='center'><a href='products_new.php'>Create New Product</a></p>";
}



//$sql = "select name from recipes";
//$result = $db->query($sql);

//echo $sql . "<br/>";
//$resulttwo = $result->fetch_row()[0];
//echo $resulttwo;
//print_r($result->fetch_row()[0]);

$sql = "select count(id) from products";
$result = $db->query($sql);
$num_records = $result->fetch_row()[0];


$per_page = 5;
$page = mysqli_real_escape_string($db, $_GET['page']);
if (empty($page)){
    $page = 1;
}
$skip = $page * $per_page - $per_page;

$sql = "select * from products LIMIT $skip, $per_page";
$result = $db->query($sql);

//echo "<br/>";

$last_page = $num_records/$per_page + 1;
$nextpage = $page + 1;
$prevpage = $page - 1;
if ($prevpage == 0){
    $previous_link = "Previous";
}else{
    $previous_link = "<a href='/products.php?page=$prevpage'>Previous</a>";
}


if ($nextpage >= $last_page){
    $next_link = "Next";
}else{
    $next_link = "<a href='/products.php?page=$nextpage'>Next</a>";
}

if(isset($_SESSION['username'])){
    $thth = "<th></th><th></th>";
}

$table = <<<TABLE
<p class='center'>
$previous_link
$next_link
</p>
<table border="1">
<tr>
<th>image</th>
<th>name</th>
<th>description</th>
<th>price</th>
<th>cost</th>
<th>qty on hand</th>
$thth
</tr>


TABLE;

echo $table;

while (list($id, $name,
    $description,
    $price,
    $cost,
    $qty_on_hand,
    $image, $thumb) = $result->fetch_row()){

    if(isset($_SESSION['username'])){
        $edde = "<td><a href='/products_edit.php?id=$id'>Edit</a></td>
<td><a href='/products_delete.php?id=$id'>Delete</a></td>";
    }

    //<td><a href='/products_email.php?id=$id'>Email</a></td>

    $row = <<<ROW

<tr>

<td><img = src="$thumb"/><br/></td>
<td><a href='/products_show.php?id=$id'>$name</a></td>
<td>$description</td>
<td>$$price</td>
<td>$$cost</td>
<td>$qty_on_hand</td>

$edde
</tr>

ROW;

    echo $row;

}

echo "</table>";



/*
//adding/////////////////////////////////////*


$name = $_POST['name'];
$description = $_POST['description'];
$ingredients = $_POST['ingredients'];
$instructions = $_POST['instructions'];
$prep_time = $_POST['prep_time'];
$rating = $_POST['rating'];
$prep_time_int = (int)$prep_time;
$rating_int = (int)$rating;

//error check
//valid data
$submit = $_POST['submit'];
if (!empty($submit)){
    //insert to db
    $sql = "INSERT into recipes (id,name,description,ingredients,instructions,prep_time,rating, created_date, modified_date)
            VALUES (null, '$name', '$description','$ingredients' , '$instructions', $prep_time_int, $rating_int, now(), now())";
    echo $sql . "<br/>";
    $db = db_connect();
    $result = $db->query($sql);
    echo "Results: $result";
}


$form = <<<FORM

<form class="halfwidth" action="/products.php" method="post">
    <label for="name">Product Name:</label>
    <input type="text" name="name" value="$name"><br/>
    <label for="description">Description:</label>
    <textarea name="description">$description</textarea><br/>
    <label for="ingredients">Ingredients:</label>
    <textarea name="ingredients">$ingredients</textarea><br/>
    <label for="instructions">Instructions:</label>
    <textarea name="instructions">$instructions</textarea><br/>
    <label for="prep_time">Prep Time:</label>
    <input type="text" name="prep_time" value="$prep_time"><br/>
    <label for="rating">Rating:</label>
    <input type="text" name="rating" value="$rating"><br/>

    
    <input type="submit" name="submit" value="Create Product">
</form>

FORM;

echo $form;


*/



require "templates/footer.php";

?>

