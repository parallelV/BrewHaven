<?php

if (!isset($basePath)) {
    $basePath = "";
}

$isLoggedIn = isset($_SESSION['user_id']);

$isBuyer = $isLoggedIn &&
           isset($_SESSION['role']) &&
           $_SESSION['role'] == "buyer";

$isAdmin = $isLoggedIn &&
           isset($_SESSION['role']) &&
           $_SESSION['role'] == "admin";

?>

<nav class="navbar navbar-expand-lg navbar-dark">

<div class="container">

<!-- BRAND -->

<a
class="navbar-brand d-flex align-items-center"
href="<?= $basePath ?>index.php">

<img

src="<?= $basePath ?>assets/images/hero_logo.png"

class="navbar-logo"

alt="Brew Haven">

<span class="brand-title">

Brew Haven

</span>

</a>

<button

class="navbar-toggler"

type="button"

data-bs-toggle="collapse"

data-bs-target="#navbar">

<span class="navbar-toggler-icon"></span>

</button>

<div
class="collapse navbar-collapse"
id="navbar">

<ul class="navbar-nav ms-auto align-items-center">

<li class="nav-item">

<a
class="nav-link"
href="<?= $basePath ?>index.php">

Home

</a>

</li>

<li class="nav-item">

<a
class="nav-link"
href="<?= $basePath ?>buyer/shop.php">

Shop

</a>

</li>
<!-- GUEST ONLY -->

<?php if(!$isLoggedIn){ ?>

<li class="nav-item">

    <a
        class="nav-link"
        href="<?= $basePath ?>buyer/about.php">

        About

    </a>

</li>

<li class="nav-item">

    <a
        class="nav-link"
        href="<?= $basePath ?>buyer/contact.php">

        Contact

    </a>

</li>

<li class="nav-item">

    <a
        class="nav-link"
        href="<?= $basePath ?>buyer/login.php">

        Login

    </a>

</li>

<li class="nav-item ms-2">

    <a
        class="btn btn-warning"
        href="<?= $basePath ?>buyer/register.php">

        Register

    </a>

</li>

<?php } ?>

<!-- BUYER ONLY -->

<?php if($isBuyer){ ?>

<li class="nav-item">

    <a
        class="nav-link"
        href="<?= $basePath ?>buyer/cart.php">

        <i class="bi bi-cart3"></i>

        Cart

    </a>

</li>

<li class="nav-item">

    <a
        class="nav-link"
        href="<?= $basePath ?>buyer/my_orders.php">

        My Orders

    </a>

</li>

<li class="nav-item dropdown ms-2">

    <a

        class="nav-link dropdown-toggle"

        href="#"

        id="accountDropdown"

        role="button"

        data-bs-toggle="dropdown"

        aria-expanded="false">

        <i class="bi bi-person-circle"></i>

        <?php echo htmlspecialchars($_SESSION['fullname']); ?>

    </a>

    <ul class="dropdown-menu dropdown-menu-end">

        <li>

            <a
                class="dropdown-item"
                href="<?= $basePath ?>buyer/profile.php">

                <i class="bi bi-person"></i>

                My Profile

            </a>

        </li>

        <li>

            <hr class="dropdown-divider">

        </li>

        <li>

            <a
                class="dropdown-item text-danger"
                href="<?= $basePath ?>buyer/logout.php">

                <i class="bi bi-box-arrow-right"></i>

                Logout

            </a>

        </li>

    </ul>

</li>

<?php } ?>

</ul>

</div>

</div>

</nav>