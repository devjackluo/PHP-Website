<?php

ob_start();
include "templates/functions.php";

$db = db_connect();

$username = mysqli_real_escape_string($db, $_POST['username']);
$password = mysqli_real_escape_string($db, $_POST['password']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$submit = mysqli_real_escape_string($db, $_POST['submit']);

$encrypted_password = password_hash($password, PASSWORD_DEFAULT);

$registration_error = '';
if($submit && !empty($username) && !empty($password) && !empty($email) ) {

    //check that this is a unique user
    $sql = "select * from users where username='$username'";
    //echo $sql;
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $registration_error .= "Username already in use, try again";
    } else {
        // insert user
        $sql = "insert into users (id, username, password, email) values (null, '$username', '$encrypted_password', '$email')";
        $result = $db->query($sql);
        if (!$result){
            $registration_error .= "Email is already in use.";
        }else{
            ob_clean();
            header("Location: /");
        }

    }
    //create user
    //redirect if ok
}elseif ($submit){

    if(empty($username)){
        $registration_error .= "Must supply username<br/>";
    }
    if(empty($password)){
        $registration_error .= "Must supply password<br/>";
    }
    if(empty($email)){
        $registration_error .= "Must supply email<br/>";
    }

}

$form = <<<ENDOFFORM

<p>$registration_error</p>
<form action="/register.php" method="post">
   <div class="halfwidth">
        <label for="username">Username: </label>
        <input type="text" name="username" id="username" value="$username">
        <br/>     
        <label for="password">Password: </label>
        <input type="password" name="password" id="password" value="">
        <br/>   
        <label for="email">Email: </label>
        <input type="email" name="email" id="email" value="$email">
        <br/>    
        <input type="submit" name="submit" id="submit" value="Register">
   </div>
</form>

ENDOFFORM;

echo $form;


ob_end_flush();
?>