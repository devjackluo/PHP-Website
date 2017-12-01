<?php

ob_start();
$page_title = "Articles Update";
require "templates/header.php";
require "templates/functions.php";

$db = db_connect();
$id = mysqli_real_escape_string($db, $_GET['id']);
$submit = mysqli_real_escape_string($db, $_POST['submit']);


    if (empty($submit)) {
        $sql = "select * from articles where article_id=$id";
        $result = $db->query($sql);

        list($article_id, $article_title,
            $author,
            $article_text,
            $date_posted,
            $created_date,
            $modified_date) = $result->fetch_row();

    } else {

            $article_title = mysqli_real_escape_string($db, $_POST['article_title']);
            $author = mysqli_real_escape_string($db, $_POST['author']);
            $article_text = mysqli_real_escape_string($db, $_POST['article_text']);
            $date_posted = mysqli_real_escape_string($db, $_POST['date_posted']);

        if (!empty($article_title) && !empty($author) && !empty($date_posted) && !empty($article_text)) {

            $sql = "update articles set title=\"$article_title\", author=\"$author\", article_text=\"$article_text\", date_posted=\"$date_posted\", modified_at=now() where article_id=$id";

            if (isset($_SESSION['username'])){
                $result = $db->query($sql);
                if ($result) {
                    ob_clean();
                    header("Location: /articles_show.php?id=$id&msg=Updated");
                }
            }else{
                ob_clean();
                header("Location: /articles_show.php?id=$id&msg=You need to login to update");
            }


        }else{

            $error = "";
            if (empty($article_title)) {
                $error .= "Article Title is required<br/>";
            }

            if (empty($author)) {
                $error .= "Author is required<br/>";
            }

            if (empty($date_posted)) {
                $error .= "Date is required<br/>";
            }

            if (empty($article_text)) {
                $error .= "Article text is required<br/>";
            }
        }

    }

$form = articles_form("/articles_update.php?id=$id",$article_title, $author, $date_posted, $article_text, "Update");

if ($error != "") {
    echo "<div class='error'>$error</div>";
}

echo $form;


require "templates/footer.php";
ob_end_flush();
?>