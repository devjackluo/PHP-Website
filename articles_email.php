<?php

include "templates/functions.php";

$db = db_connect();
$id = mysqli_real_escape_string($db, $_GET['id']);
$sql = "select * from articles where article_id=$id";
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

while (list($newsletter_id, $newsletter_name, $newsletter_email, $newsletter_option) = $result->fetch_row()) {

    $message = <<<MESSAGE

Hello $newsletter_name, have you read this article?

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
    //echo "Maul was sent: $to, $subject, $message<br/>";

}


header("Location: /articles_list.php?msg=Emails sent");

?>