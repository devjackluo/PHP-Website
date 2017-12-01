<?php

ob_start();
$page_title = "Products Edit";
require "templates/header.php";
require "templates/functions.php";


?>

<?php

$db = db_connect();
$id = mysqli_real_escape_string($db, $_GET['id']);
$submit = mysqli_real_escape_string($db, $_POST['submit']);

if (empty($submit)){
    $sql = "select * from products where id=$id";
    echo $sql . "<br/>";
    $result = $db->query($sql);

    list($id, $name,
        $description,
        $price,
        $cost,
        $qty_on_hand,
        $image, $thumb) = $result->fetch_row();
}else{

    $name = mysqli_real_escape_string($db, $_POST['name']);
    $description = mysqli_real_escape_string($db, $_POST['description']);
    $price = mysqli_real_escape_string($db, $_POST['price']);
    $cost = mysqli_real_escape_string($db, $_POST['cost']);
    $qty_on_hand = mysqli_real_escape_string($db, $_POST['qty_on_hand']);
    //$image = mysqli_real_escape_string($db, $_POST['rating']);

    /*
    $modified_date = date_create();
    $modified_date = $modified_date->format("Y-m-d H:i:s");
    echo "Mod Date: $modified_date";
    */

    if (!empty($_FILES['image']['name'])){

        $uploaded_file_name = $_FILES['image']['tmp_name'];
        move_uploaded_file($uploaded_file_name, "upload/" . $_FILES["image"]["name"]);
        $image_path = "upload/" . $_FILES['image']['name'];
        $file_type = $_FILES['image']['type'];

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

        $sql= "update products set name='$name', description='$description', price=$price, cost=$cost, qty_on_hand=$qty_on_hand, image='$image_path', thumb='$thumb_filename' where id=$id";

    }else{

        $sql= "update products set name='$name', description='$description', price=$price, cost=$cost, qty_on_hand=$qty_on_hand where id=$id";

    }

    if (isset($_SESSION['username'])){


        echo $sql . "<br/>";

        $result = $db->query($sql);
        //echo "Results: $result";

        if ($result){
            ob_clean();
            header("Location: /products_show.php?id=$id");
        }


    }else{
        ob_clean();
        header("Location: /products_show.php?id=$id&msg=You need to login to update");
    }


}

$form = product_form("/products_edit.php?id=$id",$name, $description, $price, $cost, $qty_on_hand, "Update Product");

echo $form;


?>


<?php

require "templates/footer.php";
ob_end_flush();
?>
