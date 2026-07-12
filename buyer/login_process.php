<?php

session_start();

include("../config/database.php");

if (!isset($_POST['login'])) {
    header("Location: login.php");
    exit();
}

$email = trim($_POST['email']);
$password = $_POST['password'];

if (empty($email) || empty($password)) {

    $_SESSION['message'] = "Please enter your email and password.";
    $_SESSION['messageClass'] = "danger";

    header("Location: login.php");
    exit();

}

$query = mysqli_query(
    $conn,
    "SELECT * FROM users WHERE email='$email' LIMIT 1"
);

if (mysqli_num_rows($query) == 0) {

    $_SESSION['message'] = "Invalid email or password.";
    $_SESSION['messageClass'] = "danger";

    header("Location: login.php");
    exit();

}

$user = mysqli_fetch_assoc($query);

if (!password_verify($password, $user['password'])) {

    $_SESSION['message'] = "Invalid email or password.";
    $_SESSION['messageClass'] = "danger";

    header("Location: login.php");
    exit();

}

/* ==========================
   CREATE SESSION
========================== */

$_SESSION['user_id'] = $user['id'];
$_SESSION['fullname'] = $user['fullname'];
$_SESSION['email'] = $user['email'];
$_SESSION['role'] = $user['role'];

/* ==========================
   REDIRECT
========================== */

if ($user['role'] == "admin") {

    header("Location: ../seller/dashboard.php");

} else {

    header("Location: shop.php");

}

exit();

?>