<?php

session_start();

$basePath = "../";

$pageTitle = "Contact Us | Brew Haven";

include("../config/database.php");
include("../includes/header.php");
include("../includes/navbar.php");

?>

<section class="container py-5">

<div class="text-center mb-5">

<h1 class="fw-bold">

Contact Brew Haven

</h1>

<p class="text-muted">

We'd love to hear from you.

</p>

</div>

<div class="row">

<div class="col-lg-5">

<div class="card shadow-sm border-0 h-100">

<div class="card-body">

<h3 class="fw-bold mb-4">

Contact Information

</h3>

<p>

<i class="bi bi-geo-alt-fill text-danger"></i>

123 Brew Haven Street

Makati City, Philippines

</p>

<p>

<i class="bi bi-telephone-fill text-success"></i>

+63 912 345 6789

</p>

<p>

<i class="bi bi-envelope-fill text-primary"></i>

brewhaven@email.com

</p>

<p>

<i class="bi bi-clock-fill text-warning"></i>

Monday - Friday

8:00 AM - 9:00 PM

</p>

<p>

Saturday - Sunday

9:00 AM - 10:00 PM

</p>

</div>

</div>

</div>

<div class="col-lg-7">

<div class="card shadow-sm border-0">

<div class="card-body">

<h3 class="fw-bold mb-4">

Send us a Message

</h3>

<form>

<div class="mb-3">

<label>

Full Name

</label>

<input

type="text"

class="form-control"

placeholder="Enter your name">

</div>

<div class="mb-3">

<label>

Email

</label>

<input

type="email"

class="form-control"

placeholder="Enter your email">

</div>

<div class="mb-3">

<label>

Message

</label>

<textarea

rows="6"

class="form-control"

placeholder="Write your message..."></textarea>

</div>

<button

type="button"

class="btn btn-warning">

Send Message

</button>

</form>

</div>

</div>

</div>
</div>

<!-- ==========================
     LOCATION
========================== -->

<div class="card shadow-sm border-0 mt-5">

    <div class="card-body text-center">

        <h3 class="fw-bold mb-4">

            Visit Our Café

        </h3>

        <p class="text-muted mb-4">

            We're always happy to welcome you for a fresh cup of coffee
            and delicious pastries.

        </p>

        <div class="ratio ratio-16x9">

            <iframe
                src="https://maps.google.com/maps?q=Makati%20City&t=&z=13&ie=UTF8&iwloc=&output=embed"
                style="border:0;"
                allowfullscreen
                loading="lazy">

            </iframe>

        </div>

    </div>

</div>

</section>

<?php include("../includes/footer.php"); ?>