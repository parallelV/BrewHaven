<?php
$basePath = "";
include("includes/header.php");
include("includes/navbar.php");
?>

<!-- HERO SECTION -->

<section class="hero">

    <div class="container">

        <div class="row align-items-center">

            <div class="col-lg-6">

                <span class="badge bg-warning text-dark mb-3">
                    Premium Coffee Experience
                </span>

                <h1>
                    Brew Happiness
                    <br>
                    One Cup at a Time.
                </h1>

                <p class="mt-4">

                    Experience handcrafted coffee, refreshing beverages,
                    freshly baked pastries, and delicious cakes made
                    with passion every day.

                </p>

                <a href="buyer/shop.php" class="btn btn-warning btn-lg mt-3">

                    Order Now

                </a>

                <a href="buyer/about.php" class="btn btn-outline-dark btn-lg mt-3 ms-2">

                    Learn More

                </a>

            </div>

            <div class="col-lg-6 text-center">

               <img
                src="assets/images/hero-main.png"
                alt="Brew Haven"
                class="hero-image img-fluid">

            </div>
            </div>

    </div>

</section>

<!-- FEATURED -->

<section class="featured">

    <div class="container">

        <div class="text-center mb-5">

            <h2>Our Best Sellers</h2>

            <p>Customer favorites you'll surely love.</p>

        </div>

        <div class="row">

            <div class="col-md-4">

                <div class="product-card">

                    <img src="assets/images/products/latte.jpg">

                    <h4>Caffè Latte</h4>

                    <p>Rich espresso blended with creamy steamed milk.</p>

                    <h5>₱175</h5>

                </div>

            </div>

            <div class="col-md-4">

                <div class="product-card">

                    <img src="assets/images/products/coldbrew.jpg">

                    <h4>Cold Brew</h4>

                    <p>Smooth, refreshing and naturally sweet.</p>

                    <h5>₱235</h5>

                </div>

            </div>

            <div class="col-md-4">

                <div class="product-card">

                    <img src="assets/images/products/cheesecake.jpg">

                    <h4>Blueberry Cheesecake</h4>

                    <p>Our signature creamy cheesecake.</p>

                    <h5>₱210</h5>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- CATEGORIES -->

<section class="categories">

    <div class="container">

        <div class="text-center">

            <h2>Browse Categories</h2>

        </div>

        <div class="row mt-5">

            <div class="col">

                <div class="category-box">

                    ☕

                    <h5>Hot Coffee</h5>

                </div>

            </div>

            <div class="col">

                <div class="category-box">

                    🧊

                    <h5>Iced Coffee</h5>

                </div>

            </div>

            <div class="col">

                <div class="category-box">

                    🍹

                    <h5>Refreshers</h5>

                </div>

            </div>

            <div class="col">

                <div class="category-box">

                    🥐

                    <h5>Pastries</h5>

                </div>

            </div>

            <div class="col">

                <div class="category-box">

                    🍰

                    <h5>Cakes</h5>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- ABOUT -->

<section class="about-home">

    <div class="container">

        <div class="row align-items-center">

            <div class="col-lg-6">

                <img src="assets/images/cafe.jpg"
                     class="img-fluid rounded shadow">

            </div>

            <div class="col-lg-6">

                <h2>Why Brew Haven?</h2>

                <p>

                    Brew Haven serves premium handcrafted beverages,
                    artisan pastries, and delicious cakes in a warm
                    and relaxing environment.

                </p>

                <ul>

                    <li>✔ Premium Coffee Beans</li>

                    <li>✔ Freshly Baked Daily</li>

                    <li>✔ Friendly Staff</li>

                    <li>✔ Cozy Café Experience</li>

                </ul>

            </div>

        </div>

    </div>

</section>

<?php
include("includes/footer.php");
?>