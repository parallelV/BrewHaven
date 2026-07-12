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

$category_name = mysqli_real_escape_string(
    $conn,
    trim($_POST['category_name'])
);

/* ==========================
   VALIDATION
========================== */

if (empty($category_name)) {

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
     WHERE category_name='$category_name'"
);

if (mysqli_num_rows($check) > 0) {

    $_SESSION['message'] = "Category already exists.";
    $_SESSION['messageClass'] = "danger";

    header("Location: categories.php");
    exit();
}

/* ==========================
   INSERT CATEGORY
========================== */

$sql = "INSERT INTO categories(category_name)

VALUES('$category_name')";

if (mysqli_query($conn, $sql)) {

    /* ==========================
       AUDIT LOG
    ========================== */

    $activity = "Added Category: " . $category_name;

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

    $_SESSION['message'] = "Category added successfully!";
    $_SESSION['messageClass'] = "success";

} else {

    $_SESSION['message'] = "Failed to add category.";
    $_SESSION['messageClass'] = "danger";

}

header("Location: categories.php");
exit();

?>