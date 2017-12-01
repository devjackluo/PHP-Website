
<link rel="stylesheet" href="../css/mystyle.css">

<?php
/*

//http://dev.zhaowenluo.com/user_input.php?first_name=Jack&last_name=Luo&age=21&weight=130&height=65

$first_name = $_GET['first_name'];
$last_name = $_GET['last_name'];
$age = $_GET['age'];
$weight = $_GET['weight'];
$height = $_GET['height'];
echo $first_name . " " . $last_name . "<br/>Age: " . $age . " Weight: " . $weight . " Height: " . $height;

$bmi = (703 * $weight) / ($height * $height);
echo "<br/>Your BMI is $bmi";

*/

/*

http://dev.zhaowenluo.com/user_input.php?number1=10&number2=2&operator=%5E

$num1 = $_GET["number1"];
$num2 = $_GET["number2"];
$operator = $_GET["operator"];

$result = "\$result = $num1 $operator $num2;";
echo $result . "<br/>";
eval($result);

// + = %2B
// * = *
// - = -
// / = %2F

echo "Sum of $num1 and $num2 = $result" // . ($num1 + $num2);

*/

function CreateSelectBox($select_name, $items, $selected){

    $select_box = "<select name='$select_name'>";

    $count = 0;
    for ($count = 0; $count < count($items); $count++ ){
        $select_box .= "<option ";
        if ($items[$count] == $selected){
            $select_box .= "selected ='selected'";
        }
        $select_box .= '>' . $items[$count] . '</option>';
    }

    $select_box .= '</select>';

    return $select_box;
}

$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$color = $_POST["color"];
$question = $_POST["question"];
$gender = $_POST["gender"];
$selected_fruit = $_POST["fruits"];
$submit = $_POST["submit"];

$error = "";
if(empty($first_name) && ! empty($submit)){
    $error .= "First Name is required<br/>";
}

if(empty($last_name) && ! empty($submit)){
    $error .= "Last Name is required<br/>";
}


if($gender == "male"){
    $checked_female = '';
    $checked_male = 'checked="checked"';
}elseif($gender == 'female'){
    $checked_female = 'checked="checked"';
    $checked_male = '';
}

echo "First Name: $first_name<br/>";
echo "Last Name: $last_name<br/>";
echo "Color: $color<br/>";
echo "Question: $question<br/>";
echo "Gender: $gender<br/>";
echo "Fruit: $selected_fruit<br/>";
echo "Check Submit: $submit<br/>";

$food_array=[
    "Banana",
    "Orange",
    "Apple",
    "Pear",
    "Strawberry",
    "Raspberry",
    "Blueberry"
];

$select_box = CreateSelectBox( "fruits", $food_array, $selected_fruit);

$form = <<<ENDOFFORM

<form action="/stuff/user_input.php" method="post">
    <label for="first_name">First Name:</label>
    <input type="text" name="first_name" id="first_name" value="$first_name">
    <br/>
    <label for="last_name">Last Name:</label>
    <input type="text" name="last_name" id="last_name" value="$last_name">
    <br/>
    <input type="color" name="color" id="color" value="$color">
    <br/>
    <textarea name="question" id="question">$question</textarea>
    <br/>
    <input type="radio" name="gender" value="male" $checked_male/><label for="gender">Male</label>
    <input type="radio" name="gender" value="female" $checked_female/><label for="gender">Female</label>
    <br/>
    $select_box
    <br/>
    <input type="submit" name="submit" id="submit" value="Submit">
</form>

ENDOFFORM;

if ($error != ""){
    echo "<div class='error'>$error</div>";
}
echo $form

?>



