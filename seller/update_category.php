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
   REQUEST
========================== */

if ($_SERVER['REQUEST_METHOD'] != "POST") {
    header("Location: categories.php");
    exit();
}

/* ==========================
   GET DATA
========================== */

$id = (int)$_POST['id'];

$category_name = mysqli_real_escape_string(
    $conn,
    trim($_POST['category_name'])
);

/* ==========================
   VALIDATION
========================== */

if(empty($category_name)){

    $_SESSION['message'] = "Category name is required.";
    $_SESSION['messageClass'] = "danger";

    header("Location: categories.php");
    exit();

}

/* ==========================
   DUPLICATE CHECK
========================== */

$check = mysqli_query(
    $conn,
    "SELECT id
     FROM categories
     WHERE category_name='$category_name'
     AND id != '$id'"
);

if(mysqli_num_rows($check)>0){

    $_SESSION['message'] = "Category already exists.";
    $_SESSION['messageClass'] = "danger";

    header("Location: categories.php");
    exit();

}

/* ==========================
   UPDATE
========================== */

$sql = "UPDATE categories

SET category_name='$category_name'

WHERE id='$id'";

if(mysqli_query($conn,$sql)){

    $_SESSION['message'] = "Category updated successfully!";
    $_SESSION['messageClass'] = "success";

}else{

    $_SESSION['message'] = "Failed to update category.";
    $_SESSION['messageClass'] = "danger";

}

header("Location: categories.php");
exit();

?>