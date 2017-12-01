<?php

session_start();


?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>
        <?
        if ($page_title == "")
            echo "Jack's Site";
        else
            echo "Jack: $page_title";
        ?>
    </title>
    <link rel="stylesheet" href="bootstrap/Content/bootstrap.min.css">
    <link rel="stylesheet" href="css/mystyle.css">
    <!--<script src="//cloud.tinymce.com/stable/tinymce.min.js"></script>-->


</head>
<body>

<header>

    <?php require "nav.php" ?>

</header>


<main>



    <?php
    /*

    if(isset($_SESSION['username'])){
        $loggeduser = $_SESSION['username'];
        echo "<p class=\"center\">Welcome, $loggeduser</p>";
    }
    */

    ?>



    <section>
        <h1 class="betterlook1">This is the <?php echo $page_title ?></h1>
    </section>

    <article>
        <p class="betterlook" style="text-align: center">
            I'm a robot.
        </p>
    </article>

</main>