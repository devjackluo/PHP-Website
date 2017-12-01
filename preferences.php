<?php
ob_start();
$page_title = "Preferences";
require "templates/header.php";
include "templates/functions.php";

$db = db_connect();

$message = mysqli_real_escape_string($db, $_GET["msg"]);

if (!empty($message)){
    echo "<p class='center error'>$message</p><br/>";
}

$name = mysqli_real_escape_string($db, $_POST['name']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$newsletter = mysqli_real_escape_string($db, $_POST['newsletter']);
$submit = mysqli_real_escape_string($db, $_POST['submit']);

if (empty($email) && !empty($submit)) {
    $error .= "Email is required<br/>";
}
if ($newsletter == "newsletter") {
    $checked = 'checked="checked"';
    $ob_in = 1;
}else{
    $ob_in = 0;
}


$form = <<<ENDOFFORM

<form action="/preferences.php" method="post">
  <div class="halfwidth">
   <label for="formGroupExampleInput">Name</label>
   <input type="text" class="form-control" name="name" id="name" value="$name">
   
   
   <label for="formGroupExampleInput2">Email</label>
   <input type="email" class="form-control" name="email" id="email" value="$email">
   
   <label>Checkboxes</label>
   <br/>
   <input type="checkbox" name="newsletter" id="newsletter" value="newsletter" $checked><label for="type">Subscribe to Newsletter</label> 
   
   <br/>
   <br/>
   <input type="submit" name="submit" id="submit" value="Submit">
  </div>
</form>

ENDOFFORM;

if ($error != "") {
    echo "<div class='error'>$error</div>";
}

if(!empty($submit) && !empty($email)){

    $sql = "INSERT into newsletter (id,name,email,newsletter)
            VALUES (null, '$name', '$email', $ob_in)";

    $result = $db->query($sql);

    if($result){

        ob_clean();
        header("Location: /preferences.php?msg=Thank you!");
    }

}

echo $form;

require "templates/footer.php";

ob_end_flush();
?>
