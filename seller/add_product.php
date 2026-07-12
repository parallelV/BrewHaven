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

$category_id = (int) $_POST['category_id'];

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

$price = (float) $_POST['price'];

$stock = (int) $_POST['stock'];

$status = mysqli_real_escape_string(
    $conn,
    trim($_POST['status'])
);

/* ==========================
   EMPTY VALIDATION
========================== */

if (

    empty($category_id) ||

    empty($product_name) ||

    empty($price) ||

    empty($stock)

) {

    $_SESSION['message'] = "Please complete all required fields.";

    $_SESSION['messageClass'] = "danger";

    header("Location: products.php");
    exit();

}

/* ==========================
   DUPLICATE PRODUCT
========================== */

$duplicate = mysqli_query(

    $conn,

    "SELECT id
     FROM products
     WHERE product_name='$product_name'"

);

if (mysqli_num_rows($duplicate) > 0) {

    $_SESSION['message'] = "Product already exists.";

    $_SESSION['messageClass'] = "danger";

    header("Location: products.php");
    exit();

}

/* ==========================
   IMAGE
========================== */

if (!isset($_FILES['image']) || $_FILES['image']['error'] != 0) {

    $_SESSION['message'] = "Please choose a product image.";

    $_SESSION['messageClass'] = "danger";

    header("Location: products.php");
    exit();

}

$image = $_FILES['image'];

$imageTmp = $image['tmp_name'];

$imageName = time() . "_" .
preg_replace(
    '/[^A-Za-z0-9._-]/',
    '_',
    basename($image['name'])
);

$imageExtension = strtolower(
    pathinfo(
        $imageName,
        PATHINFO_EXTENSION
    )
);

$allowed = ['jpg', 'jpeg', 'png'];

if (!in_array($imageExtension, $allowed)) {

    $_SESSION['message'] = "Only JPG, JPEG and PNG files are allowed.";

    $_SESSION['messageClass'] = "danger";

    header("Location: products.php");
    exit();

}

$destination = "../assets/images/products/" . $imageName;
/* ==========================
   UPLOAD IMAGE
========================== */

if (!move_uploaded_file($imageTmp, $destination)) {

    $_SESSION['message'] = "Failed to upload product image.";

    $_SESSION['messageClass'] = "danger";

    header("Location: products.php");
    exit();

}

/* ==========================
   INSERT PRODUCT
========================== */

$sql = "INSERT INTO products
(
    category_id,
    product_type,
    product_name,
    description,
    size,
    price,
    stock,
    image,
    status
)

VALUES
(
    $category_id,
    '$product_type',
    '$product_name',
    '$description',
    '$size',
    $price,
    $stock,
    '$imageName',
    '$status'
)";

$result = mysqli_query($conn, $sql);

/* ==========================
   INSERT RESULT
========================== */
if($result){

    $activity = "Added Product: " . $product_name;

    mysqli_query(
        $conn,
        "INSERT INTO audit_logs(user_id,activity)
         VALUES('".$_SESSION['user_id']."','$activity')"
    );

    $_SESSION['message']="Product added successfully!";

    $_SESSION['messageClass'] = "success";

} else {

    /* Delete uploaded image if SQL fails */

    if (file_exists($destination)) {

        unlink($destination);

    }

    $_SESSION['message'] = "Failed to add product.";

    $_SESSION['messageClass'] = "danger";

}

header("Location: products.php");
exit();

?>