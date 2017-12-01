<?php

ob_start();
$page_title = "Products New";
require "templates/header.php";
require "templates/functions.php";


?>

<?php

$db = db_connect();
$name = mysqli_real_escape_string($db, $_POST['name']);
$description = mysqli_real_escape_string($db, $_POST['description']);
$price = mysqli_real_escape_string($db, $_POST['price']);
$cost = mysqli_real_escape_string($db, $_POST['cost']);
$qty_on_hand = mysqli_real_escape_string($db, $_POST['qty_on_hand']);
//$image = mysqli_real_escape_string($db, $_POST['image']);

//error check
//valid data
$submit = mysqli_real_escape_string($db, $_POST['submit']);
if (!empty($submit)){


    print_r($_FILES['image']);

    if (isset($_SESSION['username'])){

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


        $sql = "INSERT into products (id,name,description,price,cost,qty_on_hand, image, thumb)
            VALUES (null, '$name', '$description',$price , $cost, $qty_on_hand, '$image_path', '$thumb_filename')";

        echo $sql;
        $result = $db->query($sql);



        if ($result){
            $product_id = $db->insert_id;
            ob_clean();
            header("Location: /products_show.php?id=$product_id");
        }




    }else{
        ob_clean();
        header("Location: /products.php?msg=You need to login to create");
    }


}


$form = product_form("/products_new.php",$name, $description, $price, $cost, $qty_on_hand, "Create Product");

echo $form;


?>



<?php

require "templates/footer.php";
ob_end_flush();
?>



