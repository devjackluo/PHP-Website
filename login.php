<?php

ob_start();
$page_title = "Login";
require "templates/header.php";
require "templates/functions.php";

$db = db_connect();
$submit = mysqli_real_escape_string($db, $_POST['submit']);
$name = mysqli_real_escape_string($db, $_POST['name']);
$password = mysqli_real_escape_string($db, $_POST['password']);


if(!empty($submit)){

    $sql = "select * from users where username='$name'";
    echo $sql;
    $result = $db->query($sql);
    print_r($result);

    if($result && $result->num_rows ){
        list($id, $username, $password_hash, $email) = $result->fetch_row();

        echo $name, $password;
        if(password_verify($password, $password_hash)){
            $_SESSION['username']= $name;
            $_SESSION['email']= $email;
            ob_clean();
            header("Location: /products.php");
        }else{
            $error_msg = "Wrong Password - Please try again.";
        }

    }else{
        $error_msg = "Unknown Credentials - Please try again.";
    }

}

if (!empty($error_msg)){
    echo "<br/><p class='center error'>$error_msg</p><br/>";
}


$login_form = <<<LOGIN
<form class="center" method="post" action ="/login.php">
    Username: <input type="text" name="name" value="$name"/><br/>
    <br/>
    Password: <input type="password" name="password" value=""/><br/>
    <br/>
    <input type="submit" name="submit" value="Login"/><br/>
</form>

LOGIN;

echo $login_form;


//miniCalendar($month, $year);

require "templates/footer.php";
ob_end_flush();
?>
