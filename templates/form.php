<!--<script>tinymce.init({ selector:'textarea' });</script>-->

<?php

$name = mysqli_real_escape_string($db, $_POST["name"]);
$email = mysqli_real_escape_string($db, $_POST["email"]);
$phone = mysqli_real_escape_string($db, $_POST["phone"]);
$question = mysqli_real_escape_string($db, $_POST["question"]);
$contact = mysqli_real_escape_string($db, $_POST["contact"]);
$selected_fruit = mysqli_real_escape_string($db, $_POST["fruits"]);
$news = mysqli_real_escape_string($db, $_POST["news"]);
$new = mysqli_real_escape_string($db, $_POST["new"]);
$submit = mysqli_real_escape_string($db, $_POST["submit"]);

$error = "";
if (empty($name) && !empty($submit)) {
    $error .= "Name is required<br/>";
}

if (empty($email) && !empty($submit)) {
    $error .= "Email is required<br/>";
}


if ($contact == "email") {
    $checked_phone = '';
    $checked_email = 'checked="checked"';
} elseif ($contact == 'phone') {
    $checked_phone = 'checked="checked"';
    $checked_email = '';
}


if ($news == "news") {
    $checked_news = 'checked="checked"';
}
if ($new == "new") {
    $checked_new = 'checked="checked"';
}


$food_array = [
    " ",
    "Banana",
    "Orange",
    "Apple",
    "Pear",
    "Strawberry",
    "Raspberry",
    "Blueberry"
];

$select_box = CreateSelectBox("fruits", $food_array, $selected_fruit);


$form = <<<ENDOFFORM

<form action="$samepage" method="post">
   <div class="halfwidth">
   <label for="formGroupExampleInput">Name</label>
   <input type="text" class="form-control" name="name" id="name" value="$name">
   
   
   <label for="formGroupExampleInput2">Email</label>
   <input type="email" class="form-control" name="email" id="email" value="$email">
   
   
   <label for="formGroupExampleInput2">Phone</label>
   <input type="text" class="form-control" name="phone" id="phone" value="$phone">
   
   
   <label for="formGroupExampleInput2">Question Text Area</label>
   <textarea class="form-control" name="question" id="question">$question</textarea>
   <br/>
   
   <label for="formGroupExampleInput2">Preferred Contact Type</label>
   <br/>
   <input type="radio" class="form-check-input" name="contact" value="email" $checked_email><label for="type">Email</label>
   <input type="radio" class="form-check-input" name="contact" value="phone" $checked_phone><label for="type">Phone</label> 
   <br/>
   <br/>   
      
   <label>Favorite Fruit: </label>
   $select_box
   <br/>
   <br/>
   
   <label>Checkboxes</label>
   <br/>
   <input type="checkbox" name="news" id="news" value="news" $checked_news><label for="type">Subscribe to Newsletter</label> 
   <br/>
   <input type="checkbox" name="new" id="new" value="new" $checked_new><label for="type">Notify me when new products are added</label> 
   
   <br/>
   <br/>
   <input type="submit" name="submit" id="submit" value="Submit">
   </div>
    
</form>

ENDOFFORM;

if ($error != "") {
    echo "<div class='error'>$error</div>";
}


if(!empty($submit) && !empty($name) && !empty($email)){

    if(!empty($news)){
        $opnews = "\nThey subcribed to our newsletter";
    }

    if(!empty($new)){
        $opnew = "\nThey wanted us to notify them of new products";
    }

    $message = <<<MESSAGE

$name contacted me.

Their email: $email

Their phone: $phone

Their question: $question

Their prefered contact type: $contact

Their favorite fruit: $selected_fruit
$opnews
$opnew

MESSAGE;


    $to = "ZhaowenL3072@bigfoot.spokane.edu";
    $subject = "$name Contacted Us";
    $headers = "From: zhaowenluo.com\r\nBcc: dave.jones@scc.spokane.edu\r\n";
    //$headers = "From: zhaowenluo.com\r\n";
    $senttome = mail($to, $subject, $message, $headers);


    $thankyoumessage = <<<TMESSAGE

Thank you $name for contacting 'Jack'.

We'll get back to you as soon as possible.

About:

$question

TMESSAGE;


    $sentthankyou = mail($email, "Thank you for contacting us", $thankyoumessage, "From: zhaowenluo.com\r\n");

    ob_clean();
    header("Location: /$samepage?msg=Your Message Was Sent");

}


echo $form;


?>



