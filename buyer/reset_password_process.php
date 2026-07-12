<?php

session_start();

include("../config/database.php");

if (!isset($_SESSION['reset_email']) || !isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
    header("Location: forgot_password.php");
    exit();
}

if (!isset($_POST['reset_password'])) {
    header("Location: reset_password.php");
    exit();
}

$email = mysqli_real_escape_string($conn, $_SESSION['reset_email']);
$password = $_POST['password'];
$confirmPassword = $_POST['confirm_password'];

if (empty($password) || empty($confirmPassword)) {

    $_SESSION['message'] = "Please fill in both password fields.";
    $_SESSION['messageClass'] = "danger";

    header("Location: reset_password.php");
    exit();

}

if ($password !== $confirmPassword) {

    $_SESSION['message'] = "Passwords do not match.";
    $_SESSION['messageClass'] = "danger";

    header("Location: reset_password.php");
    exit();

}

if (strlen($password) < 8) {

    $_SESSION['message'] = "Password must be at least 8 characters.";
    $_SESSION['messageClass'] = "danger";

    header("Location: reset_password.php");
    exit();

}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "UPDATE users SET password='$hashedPassword' WHERE email='$email'";

if (!mysqli_query($conn, $sql)) {

    $_SESSION['message'] = "Something went wrong. Please try again.";
    $_SESSION['messageClass'] = "danger";

    header("Location: reset_password.php");
    exit();

}

unset($_SESSION['reset_email']);
unset($_SESSION['otp_verified']);

$_SESSION['message'] = "Your password has been reset successfully. Please log in.";
$_SESSION['messageClass'] = "success";

header("Location: login.php");
exit();

?>
