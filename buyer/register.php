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

            <div class="col-lg-5 auth-image">

                <div class="overlay">

                    <h1>Brew Haven</h1>

                    <p>
                        Crafted with passion.
                        Served with excellence.
                    </p>

                </div>

            </div>

            <!-- RIGHT SIDE -->

            <div class="col-lg-7 p-5">

                <h2 class="fw-bold mb-2">
                    Create Account
                </h2>

                <p class="text-muted mb-4">
                    Join Brew Haven and enjoy handcrafted coffee,
                    refreshing beverages, pastries, and desserts.
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

                <form method="POST" action="register_process.php">

                    <!-- Full Name -->

                    <div class="mb-3">

                        <label class="form-label">

                            Full Name

                        </label>

                        <input
                            type="text"
                            name="fullname"
                            class="form-control"
                            placeholder="Enter your full name"
                            required>

                    </div>

                    <!-- Email -->

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

                    <!-- Contact -->

                    <div class="mb-3">

                        <label class="form-label">

                            Contact Number

                        </label>

                        <input
                            type="text"
                            name="contact"
                            class="form-control"
                            placeholder="09XXXXXXXXX"
                            maxlength="11"
                            required>

                    </div>

                    <!-- Address -->

                    <div class="mb-3">

                        <label class="form-label">

                            Complete Address

                        </label>

                        <textarea
                            name="address"
                            class="form-control"
                            rows="3"
                            placeholder="Enter your complete address"
                            required></textarea>

                    </div>

                    <!-- Passwords -->

                    <div class="row">

                        <div class="col-md-6">

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

                        </div>

                        <div class="col-md-6">

                            <div class="mb-3">

                                <label class="form-label">

                                    Confirm Password

                                </label>

                                <input
                                    type="password"
                                    name="confirm_password"
                                    class="form-control"
                                    required>

                            </div>

                        </div>

                    </div>

                                        <!-- Terms -->

                    <div class="form-check mb-4">

                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="terms"
                            required>

                        <label class="form-check-label" for="terms">

                            I agree to the Terms & Conditions and Privacy Policy.

                        </label>

                    </div>

                    <!-- Register Button -->

                    <button
                        type="submit"
                        name="register"
                        class="btn btn-warning w-100 py-3">

                        <i class="bi bi-person-plus-fill"></i>

                        Create Account

                    </button>

                </form>

                <hr class="my-4">

                <div class="text-center">

                    <p class="mb-0">

                        Already have an account?

                        <a href="login.php"
                           class="fw-semibold">

                            Login Here

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