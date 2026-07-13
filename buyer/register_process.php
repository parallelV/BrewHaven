<?php

session_start();

include("../config/database.php");
include("../config/mailer.php");

if (!isset($_POST['register'])) {
    header("Location: register.php");
    exit();
}

/* ==========================
   GET FORM DATA
========================== */

$fullname = trim($_POST['fullname']);
$email = trim($_POST['email']);
$contact = trim($_POST['contact']);
$address = trim($_POST['address']);
$password = $_POST['password'];
$confirmPassword = $_POST['confirm_password'];

/* ==========================
   BASIC VALIDATION
========================== */

if (
    empty($fullname) ||
    empty($email) ||
    empty($contact) ||
    empty($address) ||
    empty($password) ||
    empty($confirmPassword)
) {

    $_SESSION['message'] = "Please complete all required fields.";
    $_SESSION['messageClass'] = "danger";

    header("Location: register.php");
    exit();

}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    $_SESSION['message'] = "Invalid email address.";
    $_SESSION['messageClass'] = "danger";

    header("Location: register.php");
    exit();

}

if ($password != $confirmPassword) {

    $_SESSION['message'] = "Passwords do not match.";
    $_SESSION['messageClass'] = "danger";

    header("Location: register.php");
    exit();

}

if (strlen($password) < 8) {

    $_SESSION['message'] = "Password must be at least 8 characters.";
    $_SESSION['messageClass'] = "danger";

    header("Location: register.php");
    exit();

}

/* ==========================
   CHECK DUPLICATE EMAIL
========================== */

$check = mysqli_query(
    $conn,
    "SELECT id FROM users WHERE email='$email'"
);

if (mysqli_num_rows($check) > 0) {

    $_SESSION['message'] = "Email already exists.";
    $_SESSION['messageClass'] = "danger";

    header("Location: register.php");
    exit();

}

/* ==========================
   HASH PASSWORD
========================== */

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

/* ==========================
   SAVE USER
========================== */

$sql = "INSERT INTO users
(fullname,email,password,address,contact,role,status)

VALUES

(
'$fullname',
'$email',
'$hashedPassword',
'$address',
'$contact',
'buyer',
'Active'
)";

if (!mysqli_query($conn, $sql)) {

    $_SESSION['message'] = "Registration failed.";
    $_SESSION['messageClass'] = "danger";

    header("Location: register.php");
    exit();

}

/* ==========================
   SEND EMAIL
========================== */

try {
    $mail = getMailer();
    $mail->addAddress($email, $fullname);
    $mail->isHTML(true);
    $mail->Subject = "Welcome to Brew Haven";
    $mail->Body = "
        <h2>Welcome to Brew Haven ☕</h2>

        <p>Hi <strong>{$fullname}</strong>,</p>
        <p>
            Thank you for creating your Brew Haven account.
            Your registration was successful.
        </p>
        <p>
            You may now
            <a href='https://br3whaven.infinityfreeapp.com/buyer/login.php'>Log in</a>
            and enjoy ordering handcrafted coffee, pastries, and desserts.
        </p>
        <br>
        <p>
            Thank you,<br>
            <strong>Brew Haven Team</strong>
        </p>
    ";
    $mail->AltBody = "Welcome to Brew Haven!

Hi {$fullname},

Thank you for creating your Brew Haven account.
Your registration was successful.

Log in here:
https://br3whaven.infinityfreeapp.com/buyer/login.php

Enjoy ordering handcrafted coffee, pastries, and desserts.

Thank you,
Brew Haven Team";

    $mail->send();

} catch (Exception $e) {
    error_log("PHPMailer Error: " . $mail->ErrorInfo);
    $_SESSION['message'] = "Your account was created successfully, but we couldn't send the welcome email.";
}

/* ==========================
   SUCCESS
========================== */

$_SESSION['message'] = "Registration successful! Please check your email. Also check your spam folder.";

$_SESSION['messageClass'] = "success";

header("Location: register.php");
exit();

?>
