<?php

session_start();

/* ==========================
   BUYER ONLY
========================== */

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit();

}

if ($_SESSION['role'] != "buyer") {

    header("Location: ../seller/dashboard.php");
    exit();

}

/* ==========================
   PAGE SETTINGS
========================== */

$basePath = "../";

$pageTitle = "My Profile | Brew Haven";

include("../config/database.php");

/* ==========================
   LOAD USER
========================== */

$user_id = $_SESSION['user_id'];

$query = mysqli_query(

    $conn,

    "SELECT *

     FROM users

     WHERE id='$user_id'

     LIMIT 1"

);

$user = mysqli_fetch_assoc($query);

include("../includes/header.php");
include("../includes/navbar.php");

?>

<section class="container py-5">

<div class="row justify-content-center">

<div class="col-lg-8">

<div class="card shadow-sm border-0">

<div class="card-body">

<h2 class="fw-bold mb-4">

My Profile

</h2>

<?php if(isset($_SESSION['message'])){ ?>

<div class="alert alert-<?php echo $_SESSION['messageClass']; ?> alert-dismissible fade show">

<?php

echo $_SESSION['message'];

unset($_SESSION['message']);
unset($_SESSION['messageClass']);

?>

<button
class="btn-close"
data-bs-dismiss="alert">

</button>

</div>

<?php } ?>

<form
action="update_profile.php"
method="POST">

<div class="mb-3">

<label>

Full Name

</label>

<input
class="form-control"
value="<?php echo htmlspecialchars($user['fullname']); ?>"
readonly>

</div>

<div class="mb-3">

<label>

Email

</label>

<input
class="form-control"
value="<?php echo htmlspecialchars($user['email']); ?>"
readonly>

</div>

<div class="mb-3">

<label>

Contact

</label>

<input
type="text"
name="contact"
class="form-control"
value="<?php echo htmlspecialchars($user['contact']); ?>">

</div>

<div class="mb-3">

<label>

Address

</label>

<textarea
name="address"
rows="4"
class="form-control"><?php echo htmlspecialchars($user['address']); ?></textarea>

</div>
</div>

<div class="d-flex justify-content-end">

    <button
        type="submit"
        class="btn btn-warning">

        <i class="bi bi-check-circle"></i>

        Update Profile

    </button>

</div>

</form>

</div>

</div>

</div>

</div>

</section>

<?php include("../includes/footer.php"); ?>
