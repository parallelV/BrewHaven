<?php

session_start();

include("../config/database.php");
include("../config/mailer.php");

if (!isset($_POST['send_otp'])) {
    header("Location: forgot_password.php");
    exit();
}

$email = trim($_POST['email']);

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {

    $_SESSION['message'] = "Please enter a valid email address.";
    $_SESSION['messageClass'] = "danger";

    header("Location: forgot_password.php");
    exit();

}

$email = mysqli_real_escape_string($conn, $email);

/* ==========================
   CHECK IF EMAIL EXISTS
========================== */

$check = mysqli_query(
    $conn,
    "SELECT id, fullname FROM users WHERE email='$email' LIMIT 1"
);

if (mysqli_num_rows($check) == 0) {

    $_SESSION['message'] = "No account found with that email address.";
    $_SESSION['messageClass'] = "danger";

    header("Location: forgot_password.php");
    exit();

}

$user = mysqli_fetch_assoc($check);

/* ==========================
   GENERATE OTP
========================== */

$otp = str_pad(random_int(0, 999999), 6, "0", STR_PAD_LEFT);
$expiresAt = date("Y-m-d H:i:s", strtotime("+10 minutes"));

/* ==========================
   INVALIDATE OLD OTPs FOR THIS EMAIL
========================== */

mysqli_query(
    $conn,
    "UPDATE password_resets SET is_used = 1 WHERE email = '$email' AND is_used = 0"
);

/* ==========================
   SAVE NEW OTP
========================== */

$sql = "INSERT INTO password_resets (email, otp, expires_at)
        VALUES ('$email', '$otp', '$expiresAt')";

if (!mysqli_query($conn, $sql)) {

    $_SESSION['message'] = "Something went wrong. Please try again.";
    $_SESSION['messageClass'] = "danger";

    header("Location: forgot_password.php");
    exit();

}

/* ==========================
   SEND OTP EMAIL
========================== */

try {

    $mail = getMailer();

    $mail->addAddress($email, $user['fullname']);

    $mail->Subject = "Your Brew Haven Password Reset Code";

    $mail->Body = "

    <h2>Password Reset Request ☕</h2>

    <p>Hi <strong>{$user['fullname']}</strong>,</p>

    <p>
    We received a request to reset your Brew Haven account password.
    Use the one-time code below to continue:
    </p>

    <h1 style='letter-spacing:6px;'>$otp</h1>

    <p>
    This code will expire in <strong>10 minutes</strong>.
    If you did not request a password reset, you can safely ignore this email.
    </p>

    <br>

    <p>
    Thank you,
    <br>
    <strong>Brew Haven Team</strong>
    </p>

    ";

    $mail->send();

} catch (Exception $e) {

    $_SESSION['message'] = "We couldn't send the OTP email. Please try again later.";
    $_SESSION['messageClass'] = "danger";

    header("Location: forgot_password.php");
    exit();

}

$_SESSION['reset_email'] = $email;
$_SESSION['otp_verified'] = false;

$_SESSION['message'] = "An OTP has been sent to your email address.";
$_SESSION['messageClass'] = "success";

header("Location: verify_otp.php");
exit();

?>
