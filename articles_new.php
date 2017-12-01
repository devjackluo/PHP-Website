<?php

ob_start();
$page_title = "Articles Create";
require "templates/header.php";
require "templates/functions.php";

$db = db_connect();
$article_title = mysqli_real_escape_string($db, $_POST['article_title']);
$author = mysqli_real_escape_string($db, $_POST['author']);
$date_posted = mysqli_real_escape_string($db, $_POST['date_posted']);
$article_text = mysqli_real_escape_string($db, $_POST['article_text']);

$submit = mysqli_real_escape_string($db, $_POST['submit']);

if (!empty($submit) && !empty($article_title) && !empty($author) && !empty($date_posted) && !empty($article_text)){
    //insert to db
    $sql = "INSERT into articles (article_id,title,author,article_text,date_posted, created_at, modified_at)
            VALUES (null, \"$article_title\", \"$author\", \"$article_text\" , \"$date_posted\", now(), now())";


    if(isset($_SESSION['username'])){
        $result = $db->query($sql);
        if ($result){

            $new_article_id = $db->insert_id;

            $sql = "select * from articles where article_id=$new_article_id";
            $result = $db->query($sql);

            list($article_send_id,
                $title_send,
                $author_send,
                $article_text_send,
                $date_posted_send,
                $created_date_send,
                $modified_date_send) = $result->fetch_row();

            $sql = "select * from newsletter where newsletter=1";
            $result = $db->query($sql);

            while (list($newsletter_id, $newsletter_name, $newsletter_email, $newsletter_option) = $result->fetch_row()){

                $message = <<<MESSAGE

Hello $newsletter_name, here is an new article!

Article Title: $title_send

Article Author: $author_send

Article Text: $article_text_send

Article Date Posted: $date_posted_send

MESSAGE;

                $to = $newsletter_email;
                $subject = "New article from zhaowenluo.com: $title_send";
                //$headers = "From: zhaowenluo.com\r\nBcc: ZhaowenL3072@bigfoot.spokane.edu\r\n";
                $headers = "From: zhaowenluo.com\r\n";

                $sent = mail($to, $subject, $message, $headers);


            }

            ob_clean();
            header("Location: /articles_show.php?id=$new_article_id");

        }
    }else{
        ob_clean();
        header("Location: /articles.php?msg=You need to login to create");
    }

}else if(!empty($submit)){

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

//<form action="" method="post">





$form = articles_form("/articles_new.php",$article_title, $author, $date_posted, $article_text, "Create Article");

if ($error != "") {
    echo "<div class='error'>$error</div>";
}

echo $form;


require "templates/footer.php";
ob_end_flush();
?>