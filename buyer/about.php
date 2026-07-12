<?php

session_start();

$basePath = "../";

$pageTitle = "About Us | Brew Haven";

include("../config/database.php");
include("../includes/header.php");
include("../includes/navbar.php");

?>

<section class="container py-5">

<div class="row align-items-center">

<div class="col-lg-6">

<img

src="../assets/images/hero_logo.png"

class="img-fluid"

style="max-width:400px;">

</div>

<div class="col-lg-6">

<h1 class="fw-bold mb-4">

About Brew Haven

</h1>

<p>

Brew Haven is a modern café dedicated to serving
premium coffee, refreshing beverages,
and freshly baked pastries.

We believe every cup tells a story,
and every customer deserves a warm,
comfortable place to enjoy quality drinks
and food.

</p>

<p>

Our goal is to combine exceptional coffee,
excellent customer service,
and a relaxing atmosphere
into one unforgettable experience.

</p>

</div>

</div>
</div>

<!-- ==========================
     MISSION & VISION
========================== -->

<div class="row mt-5">

    <div class="col-md-6 mb-4">

        <div class="card shadow-sm border-0 h-100">

            <div class="card-body">

                <h3 class="fw-bold">

                    ☕ Our Mission

                </h3>

                <p class="mt-3">

                    To provide exceptional coffee,
                    handcrafted beverages,
                    and freshly baked pastries while
                    creating a warm and welcoming
                    environment for every customer.

                </p>

            </div>

        </div>

    </div>

    <div class="col-md-6 mb-4">

        <div class="card shadow-sm border-0 h-100">

            <div class="card-body">

                <h3 class="fw-bold">

                    🌍 Our Vision

                </h3>

                <p class="mt-3">

                    To become one of the most trusted
                    neighborhood cafés by delivering
                    quality products, outstanding service,
                    and memorable customer experiences.

                </p>

            </div>

        </div>

    </div>

</div>

<!-- ==========================
     WHY CHOOSE US
========================== -->

<div class="mt-5">

    <h2 class="fw-bold text-center mb-5">

        Why Choose Brew Haven?

    </h2>

    <div class="row text-center">

        <div class="col-md-4 mb-4">

            <i class="bi bi-cup-hot-fill fs-1 text-warning"></i>

            <h5 class="mt-3">

                Premium Coffee

            </h5>

            <p>

                Carefully selected beans brewed fresh
                every day.

            </p>

        </div>

        <div class="col-md-4 mb-4">

            <i class="bi bi-heart-fill fs-1 text-danger"></i>

            <h5 class="mt-3">

                Customer First

            </h5>

            <p>

                Every customer is treated with warmth,
                respect, and genuine hospitality.

            </p>

        </div>

        <div class="col-md-4 mb-4">

            <i class="bi bi-stars fs-1 text-primary"></i>

            <h5 class="mt-3">

                Quality Service

            </h5>

            <p>

                Delicious drinks and pastries prepared
                with consistency and care.

            </p>

        </div>

    </div>

</div>

<!-- ==========================
     OPENING HOURS
========================== -->

<div class="card shadow-sm border-0 mt-5">

    <div class="card-body text-center">

        <h3 class="fw-bold mb-4">

            Opening Hours

        </h3>

        <p>

            Monday - Friday

            <strong>

                8:00 AM – 9:00 PM

            </strong>

        </p>

        <p>

            Saturday - Sunday

            <strong>

                9:00 AM – 10:00 PM

            </strong>

        </p>

    </div>

</div>

</section>

<?php include("../includes/footer.php"); ?>