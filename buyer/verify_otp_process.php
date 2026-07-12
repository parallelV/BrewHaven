<?php

session_start();

include("../config/database.php");

if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot_password.php");
    exit();
}

if (!isset($_POST['verify_otp'])) {
    header("Location: verify_otp.php");
    exit();
}

$email = mysqli_real_escape_string($conn, $_SESSION['reset_email']);
$otp = trim($_POST['otp']);

if (empty($otp)) {

    $_SESSION['message'] = "Please enter the OTP sent to your email.";
    $_SESSION['messageClass'] = "danger";

    header("Location: verify_otp.php");
    exit();

}

$otp = mysqli_real_escape_string($conn, $otp);

$query = mysqli_query(
    $conn,
    "SELECT * FROM password_resets
     WHERE email='$email'
     AND is_used = 0
     ORDER BY id DESC
     LIMIT 1"
);

if (mysqli_num_rows($query) == 0) {

    $_SESSION['message'] = "No pending OTP found. Please request a new one.";
    $_SESSION['messageClass'] = "danger";

    header("Location: forgot_password.php");
    exit();

}

$reset = mysqli_fetch_assoc($query);

if (strtotime($reset['expires_at']) < time()) {

    $_SESSION['message'] = "This OTP has expired. Please request a new one.";
    $_SESSION['messageClass'] = "danger";

    header("Location: forgot_password.php");
    exit();

}

if ($otp !== $reset['otp']) {

    $_SESSION['message'] = "Incorrect OTP. Please try again.";
    $_SESSION['messageClass'] = "danger";

    header("Location: verify_otp.php");
    exit();

}

mysqli_query(
    $conn,
    "UPDATE password_resets SET is_used = 1 WHERE id = {$reset['id']}"
);

$_SESSION['otp_verified'] = true;

$_SESSION['message'] = "Code verified! Please set your new password.";
$_SESSION['messageClass'] = "success";

header("Location: reset_password.php");
exit();

?>
