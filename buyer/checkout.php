<?php

session_start();

/* ==========================
   LOGIN REQUIRED
========================== */

if(!isset($_SESSION['user_id'])){

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

$basePath="../";

$pageTitle="Checkout | Brew Haven";

include("../config/database.php");

/* ==========================
   CUSTOMER
========================== */

$user_id=$_SESSION['user_id'];

$user=mysqli_query(

$conn,

"SELECT *

FROM users

WHERE id='$user_id'

LIMIT 1"

);

$customer=mysqli_fetch_assoc($user);

/* ==========================
   CART
========================== */

$cart=mysqli_query(

$conn,

"SELECT

cart.*,

products.product_name,

products.price,

products.image

FROM cart

INNER JOIN products

ON cart.product_id=products.id

WHERE cart.user_id='$user_id'

"

);

include("../includes/header.php");
include("../includes/navbar.php");

?>

<section class="container py-5">

<div class="row">

<div class="col-lg-8">

<div class="card shadow-sm border-0 mb-4">

<div class="card-body">

<h3 class="mb-4">

Customer Information

</h3>

<div class="row">

<div class="col-md-6 mb-3">

<label>

Full Name

</label>

<input

class="form-control"

value="<?php echo htmlspecialchars($customer['fullname']); ?>"

readonly>

</div>

<div class="col-md-6 mb-3">

<label>

Contact

</label>

<input

class="form-control"

value="<?php echo htmlspecialchars($customer['contact']); ?>"

readonly>

</div>

<div class="col-md-12">

<label>

Address

</label>

<textarea

class="form-control"

rows="3"

readonly><?php echo htmlspecialchars($customer['address']); ?></textarea>

</div>

</div>

</div>

</div>
</div>

<!-- ==========================
     ORDER SUMMARY
========================== -->

<div class="col-lg-4">

<form
    action="place_order.php"
    method="POST">

<div class="card shadow-sm border-0">

<div class="card-body">

<h3 class="mb-4">

Order Summary

</h3>

<?php

$total = 0;

while($row = mysqli_fetch_assoc($cart)){

$subtotal = $row['price'] * $row['quantity'];

$total += $subtotal;

?>

<div class="d-flex align-items-center mb-3">

<img

src="../assets/images/products/<?php echo htmlspecialchars($row['image']); ?>"

style="

width:60px;

height:60px;

object-fit:cover;

border-radius:10px;

"

class="me-3">

<div class="flex-grow-1">

<strong>

<?php echo htmlspecialchars($row['product_name']); ?>

</strong>

<br>

<small>

Qty:

<?php echo $row['quantity']; ?>

</small>

</div>

<div>

₱<?php echo number_format($subtotal,2); ?>

</div>

</div>

<hr>

<?php } ?>

<div class="d-flex justify-content-between">

<strong>

Total

</strong>

<strong>

₱<?php echo number_format($total,2); ?>

</strong>

</div>

<input
type="hidden"
name="total_amount"
value="<?php echo $total; ?>">

<hr>

<label class="mb-2">

Payment Method

</label>

<select
name="payment_method"
class="form-select mb-4">

<option value="Cash on Pickup">

Cash on Pickup

</option>

<option value="GCash">

GCash

</option>

</select>

<button
class="btn btn-warning w-100">

<i class="bi bi-bag-check"></i>

Place Order

</button>

</div>

</div>

</form>

</div>
</div>

</section>

<?php include("../includes/footer.php"); ?>