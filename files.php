<?php

//phpinfo();

//$image = $_POST['image'];
$submit = $_POST['submit'];
//echo $_POST['image'];
print_r($_FILES['image']);


if(!empty($submit)){
    //take file and move from its temp directory to our directory
    $uploaded_file_name = $_FILES['image']['tmp_name'];
    move_uploaded_file($uploaded_file_name, "upload/" . $_FILES["image"]["name"]);
    $image_path = "upload/" . $_FILES['image']['name'];
    $file_type = $_FILES['image']['type'];

    // resize the image to a thumbnail
    if ($file_type == "image/png"){
        $src = imagecreatefrompng($image_path);
    }elseif ($file_type == "image/jpeg"){
        $src = imagecreatefromjpeg($image_path);
    }elseif ($file_type == "image/gif"){
        $src = imagecreatefromgif($image_path);
    }
    list($width, $height) = getimagesize($image_path);
    $new_width = 60;
    $new_height = ($height/$width) * $new_width;

    $tmp = imagecreatetruecolor($new_width, $new_height);
    imagecopyresampled($tmp, $src, 0,0,0,0,$new_width, $new_height, $width, $height);
    $thumb_filename = "images/thumbs/" . $_FILES['image']['name'];
    imagejpeg($tmp, $thumb_filename, 100);
    imagedestroy($src);
    imagedestroy($tmp);


}


$form = <<<FORM
<img = src="$thumb_filename"/><br/>
<img = src="$image_path"/>
<form action="/files.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="image" />
    <br/>
    <br/>
    <input type="submit" name="submit" value="Upload File"/>
</form>

FORM;

echo $form;



?>

