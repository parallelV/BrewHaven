<?php

session_start();

/* ==========================
   SECURITY
========================== */

if (!isset($_SESSION['user_id'])) {

    header("Location: ../buyer/login.php");
    exit();

}

if ($_SESSION['role'] != "admin") {

    header("Location: ../buyer/shop.php");
    exit();

}

/* ==========================
   DATABASE
========================== */

include("../config/database.php");

/* ==========================
   REQUEST VALIDATION
========================== */

if ($_SERVER['REQUEST_METHOD'] != "POST") {

    header("Location: products.php");
    exit();

}

/* ==========================
   GET FORM DATA
========================== */

$id = (int)$_POST['id'];

$category_id = (int)$_POST['category_id'];

$product_type = mysqli_real_escape_string(
    $conn,
    trim($_POST['product_type'])
);

$product_name = mysqli_real_escape_string(
    $conn,
    trim($_POST['product_name'])
);

$description = mysqli_real_escape_string(
    $conn,
    trim($_POST['description'])
);

$size = mysqli_real_escape_string(
    $conn,
    trim($_POST['size'])
);

$price = (float)$_POST['price'];

$stock = (int)$_POST['stock'];

$status = mysqli_real_escape_string(
    $conn,
    trim($_POST['status'])
);

/* ==========================
   VALIDATION
========================== */

if(

    empty($id) ||

    empty($category_id) ||

    empty($product_name) ||

    empty($price)

){

    $_SESSION['message'] = "Please complete all required fields.";

    $_SESSION['messageClass'] = "danger";

    header("Location: products.php");

    exit();

}

/* ==========================
   GET CURRENT IMAGE
========================== */

$current = mysqli_query(

    $conn,

    "SELECT image
     FROM products
     WHERE id='$id'
     LIMIT 1"

);

$product = mysqli_fetch_assoc($current);

$currentImage = $product['image'];
/* ==========================
   IMAGE UPDATE
========================== */

$imageName = $currentImage;

if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){

    $newImage = $_FILES['image'];

    $newImageName = time() . "_" .
    preg_replace(
        '/[^A-Za-z0-9._-]/',
        '_',
        basename($newImage['name'])
    );

    $extension = strtolower(
        pathinfo(
            $newImageName,
            PATHINFO_EXTENSION
        )
    );

    $allowed = ['jpg','jpeg','png'];

    if(!in_array($extension, $allowed)){

        $_SESSION['message'] = "Only JPG, JPEG and PNG images are allowed.";

        $_SESSION['messageClass'] = "danger";

        header("Location: products.php");
        exit();

    }

    $destination = "../assets/images/products/" . $newImageName;

    if(move_uploaded_file($newImage['tmp_name'], $destination)){

        if(
            !empty($currentImage) &&
            file_exists("../assets/images/products/" . $currentImage)
        ){
            unlink("../assets/images/products/" . $currentImage);
        }

        $imageName = $newImageName;

    }

}

/* ==========================
   UPDATE PRODUCT
========================== */

$sql = "UPDATE products SET

category_id = '$category_id',

product_type = '$product_type',

product_name = '$product_name',

description = '$description',

size = '$size',

price = '$price',

stock = '$stock',

image = '$imageName',

status = '$status'

WHERE id = '$id'";

if(mysqli_query($conn, $sql)){

    /* ==========================
       AUDIT LOG
    ========================== */

    $activity = "Updated Product: " . $product_name;

    mysqli_query(

        $conn,

        "INSERT INTO audit_logs
        (
            user_id,
            activity
        )

        VALUES
        (
            '".$_SESSION['user_id']."',
            '$activity'
        )"

    );

    $_SESSION['message'] = "Product updated successfully!";

    $_SESSION['messageClass'] = "success";

}else{

    $_SESSION['message'] = "Failed to update product.";

    $_SESSION['messageClass'] = "danger";

}

header("Location: products.php");
exit();

?>