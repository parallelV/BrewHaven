<?php
session_start();

$basePath = "../";

include("../config/database.php");
include("../includes/header.php");
include("../includes/navbar.php");

if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot_password.php");
    exit();
}
?>

<section class="auth-section">

    <div class="container">

        <div class="row auth-card shadow-lg">

            <div class="col-lg-5 login-image">

                <div class="overlay">

                    <h1>Brew Haven</h1>

                    <p>
                        Check your inbox.
                        Your code is on its way.
                    </p>

                </div>

            </div>

            <div class="col-lg-7 p-5">

                <h2 class="fw-bold mb-2">
                    Enter OTP
                </h2>

                <p class="text-muted mb-4">
                    We sent a 6-digit code to
                    <strong><?php echo htmlspecialchars($_SESSION['reset_email']); ?></strong>.
                    Enter it below to continue. The code expires in 10 minutes.
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

                <form method="POST" action="verify_otp_process.php">

                    <div class="mb-3">

                        <label class="form-label">
                            One-Time Code
                        </label>

                        <input
                            type="text"
                            name="otp"
                            class="form-control"
                            placeholder="6-digit code"
                            maxlength="6"
                            inputmode="numeric"
                            pattern="[0-9]{6}"
                            required>

                    </div>

                    <button
                        type="submit"
                        name="verify_otp"
                        class="btn btn-warning w-100 py-3">

                        <i class="bi bi-shield-check"></i>
                        Verify Code

                    </button>

                </form>

                <hr class="my-4">

                <div class="text-center">

                    <p class="mb-0">
                        Didn't get a code?
                        <a href="forgot_password.php" class="fw-semibold">
                            Resend OTP
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
