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

                        Fresh coffee.
                        Fresh beginnings.

                    </p>

                </div>

            </div>

            <!-- RIGHT SIDE -->

            <div class="col-lg-7 p-5">

                <h2 class="fw-bold mb-2">

                    Welcome Back

                </h2>

                <p class="text-muted mb-4">

                    Login to continue your Brew Haven experience.

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

                <form method="POST" action="login_process.php">

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

                    <div class="mb-3">

                        <label class="form-label">

                            Password

                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            required>

                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <div class="form-check">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="remember">

                            <label
                                class="form-check-label"
                                for="remember">

                                Remember Me

                            </label>

                        </div>

                        <a href="forgot_password.php" class="small">

                            Forgot Password?

                        </a>

                    </div>

                   <button
                        type="submit"
                        name="login"
                        class="btn btn-warning w-100 py-3">

                        <i class="bi bi-box-arrow-in-right"></i>

                        Login

                        </button>
                                    </form>

                <hr class="my-4">

                <div class="text-center">

                    <p class="mb-0">

                        Don't have an account?

                        <a href="register.php" class="fw-semibold">

                            Create One

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