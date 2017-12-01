<?php

include "templates/functions.php";

$db = db_connect();
$id = mysqli_real_escape_string($db, $_GET['id']);
$sql = "select * from recipes where id=$id";
$result = $db->query($sql);


list($id, $name,
    $description,
    $ingredients,
    $instructions,
    $prep_time,
    $rating, $created_date,
    $modified_date) = $result->fetch_row();

$sql = "select * from users where newsletter=1";
$result = $db->query($sql);

while (list($user_id, $username, $password, $email, $newsletter) = $result->fetch_row()){

    $message = <<<MESSAGE

Hello $username, here is an new recipe!

Recipe: $name

Description: $description

Ingredients: $ingredients


MESSAGE;

    $to = $email;
    $subject = "Recipe from zhaowenluo.com: $name";
    //$headers = "From: zhaowenluo.com\r\nBcc: ZhaowenL3072@bigfoot.spokane.edu\r\n";
    $headers = "From: zhaowenluo.com\r\n";

    //$sent = mail($to, $subject, $message, $headers);
    echo "Maul was sent: $to, $subject, $message<br/>";

}

//header("Location: /products.php?msg=Email sent");

?>