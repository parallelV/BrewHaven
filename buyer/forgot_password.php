<?php
session_start();

$basePath = "../";

include("../config/database.php");
include("../includes/header.php");
include("../includes/navbar.php");
?>

<section class="auth-section">

    <div class="container">

        <div class="row auth-card shadow-lg">

            <!-- LEFT SIDE -->

            <div class="col-lg-5 login-image">

                <div class="overlay">

                    <h1>Brew Haven</h1>

                    <p>
                        Forgot your password?
                        We'll help you brew a new one.
                    </p>

                </div>

            </div>

            <!-- RIGHT SIDE -->

            <div class="col-lg-7 p-5">

                <h2 class="fw-bold mb-2">
                    Forgot Password
                </h2>

                <p class="text-muted mb-4">
                    Enter the email address linked to your account
                    and we'll send you a one-time code (OTP) to reset your password.
                </p>

                <?php
                if(isset($_SESSION['message'])){
                ?>

                <div class="alert alert-<?php echo $_SESSION['messageClass']; ?>">

                    <?php
                    echo $_SESSION['message'];

                    unset($_SESSION['message']);
                    unset($_SESSION['messageClass']);
                    ?>

                </div>

                <?php
                }
                ?>

                <form method="POST" action="forgot_password_process.php">

                    <div class="mb-3">

                        <label class="form-label">
                            Email Address
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            placeholder="example@email.com"
                            required>

                    </div>

                    <button
                        type="submit"
                        name="send_otp"
                        class="btn btn-warning w-100 py-3">

                        <i class="bi bi-envelope-check"></i>
                        Send OTP

                    </button>

                </form>

                <hr class="my-4">

                <div class="text-center">

                    <p class="mb-0">
                        Remembered your password?
                        <a href="login.php" class="fw-semibold">
                            Back to Login
                        </a>
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>

<?php
include("../includes/footer.php");
?>
