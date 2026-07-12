<?php
session_start();

$basePath = "../";

include("../config/database.php");
include("../includes/header.php");
include("../includes/navbar.php");

if (!isset($_SESSION['reset_email']) || !isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
    header("Location: forgot_password.php");
    exit();
}
?>

<section class="auth-section">

    <div class="container">

        <div class="row auth-card shadow-lg">

            <!-- LEFT SIDE -->

            <div class="col-lg-5 login-image">

                <div class="overlay">

                    <h1>Brew Haven</h1>

                    <p>
                        Almost there.
                        Brew a fresh password.
                    </p>

                </div>

            </div>

            <div class="col-lg-7 p-5">

                <h2 class="fw-bold mb-2">
                    Reset Password
                </h2>

                <p class="text-muted mb-4">
                    Create a new password for
                    <strong><?php echo htmlspecialchars($_SESSION['reset_email']); ?></strong>.
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

                <form method="POST" action="reset_password_process.php">

                    <div class="mb-3">

                        <label class="form-label">
                            New Password
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            minlength="8"
                            required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Confirm New Password
                        </label>

                        <input
                            type="password"
                            name="confirm_password"
                            class="form-control"
                            minlength="8"
                            required>

                    </div>

                    <button
                        type="submit"
                        name="reset_password"
                        class="btn btn-warning w-100 py-3">

                        <i class="bi bi-key"></i>
                        Reset Password

                    </button>

                </form>

            </div>

        </div>

    </div>

</section>

<?php
include("../includes/footer.php");
?>
