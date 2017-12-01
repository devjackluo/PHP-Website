<?php

ob_start();
$page_title = "Blogs Create";
require "templates/header.php";
require "templates/functions.php";

$db = db_connect();
$blog_title = mysqli_real_escape_string($db, $_POST['blog_title']);
$author = mysqli_real_escape_string($db, $_POST['author']);
$date_posted = mysqli_real_escape_string($db, $_POST['date_posted']);
$blog_text = mysqli_real_escape_string($db, $_POST['blog_text']);

$submit = mysqli_real_escape_string($db, $_POST['submit']);

if (!empty($submit) && !empty($blog_title) && !empty($author) && !empty($date_posted) && !empty($blog_text)){
    //insert to db
    $sql = "INSERT into blogs (blog_id,title,author,blog_text,date_posted, created_at, modified_at)
            VALUES (null, \"$blog_title\", \"$author\",\"$blog_text\" , \"$date_posted\", now(), now())";
    echo $sql;


    if (isset($_SESSION['username'])){
        $result = $db->query($sql);
        if ($result){
            $product_id = $db->insert_id;
            ob_clean();
            header("Location: /blog_show.php?id=$product_id");
        }
    }else{
        ob_clean();
        header("Location: /blog.php?msg=You need to login to create new blog");
    }

}else if(!empty($submit)){

    $error = "";
    if (empty($blog_title)) {
        $error .= "Blog Title is required<br/>";
    }

    if (empty($author)) {
        $error .= "Author is required<br/>";
    }

    if (empty($date_posted)) {
        $error .= "Date is required<br/>";
    }

    if (empty($blog_text)) {
        $error .= "Blog text is required<br/>";
    }
}

//<form action="" method="post">





$form = blogs_form("/blog_new.php",$blog_title, $author, $date_posted, $blog_text, "Create Blog");

if ($error != "") {
    echo "<div class='error'>$error</div>";
}

echo $form;


require "templates/footer.php";
ob_end_flush();
?>