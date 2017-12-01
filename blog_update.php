<?php

ob_start();
$page_title = "Blogs Update";
require "templates/header.php";
require "templates/functions.php";

$db = db_connect();
$id = mysqli_real_escape_string($db, $_GET['id']);
$submit = mysqli_real_escape_string($db, $_POST['submit']);


if (empty($submit)) {
    $sql = "select * from blogs where blog_id=$id";
    $result = $db->query($sql);

    list($blog_id, $blog_title,
        $author,
        $blog_text,
        $date_posted,
        $created_date,
        $modified_date) = $result->fetch_row();

} else {

    $blog_title = mysqli_real_escape_string($db, $_POST['blog_title']);
    $author = mysqli_real_escape_string($db, $_POST['author']);
    $blog_text = mysqli_real_escape_string($db, $_POST['blog_text']);
    $date_posted = mysqli_real_escape_string($db, $_POST['date_posted']);

    if (!empty($blog_title) && !empty($author) && !empty($date_posted) && !empty($blog_text)) {

        $sql = "update blogs set title=\"$blog_title\", author=\"$author\", blog_text=\"$blog_text\", date_posted=\"$date_posted\", modified_at=now() where blog_id=$id";

        if(isset($_SESSION['username'])){
            $result = $db->query($sql);
            if ($result) {
                ob_clean();
                header("Location: /blog_show.php?id=$id&msg=Updated");
            }
        }else{
            ob_clean();
            header("Location: /blog_show.php?id=$id&msg=You need to login to update");
        }


    }else{

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

}

$form = blogs_form("/blog_update.php?id=$id",$blog_title, $author, $date_posted, $blog_text, "Update");

if ($error != "") {
    echo "<div class='error'>$error</div>";
}

echo $form;


require "templates/footer.php";
ob_end_flush();
?>