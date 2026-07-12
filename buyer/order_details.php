<?php

session_start();

/* ==========================
   LOGIN REQUIRED
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

$pageTitle = "Order Details | Brew Haven";

include("../config/database.php");

/* ==========================
   VALIDATE ORDER
========================== */

if (!isset($_GET['id'])) {

    header("Location: my_orders.php");
    exit();

}

$user_id = $_SESSION['user_id'];

$order_id = (int)$_GET['id'];

/* ==========================
   LOAD ORDER
========================== */

$orderQuery = mysqli_query(

    $conn,

    "SELECT *

     FROM orders

     WHERE

     id='$order_id'

     AND

     user_id='$user_id'

     LIMIT 1"

);

if(mysqli_num_rows($orderQuery)==0){

    header("Location: my_orders.php");
    exit();

}

$order = mysqli_fetch_assoc($orderQuery);

/* ==========================
   LOAD ORDER ITEMS
========================== */

$items = mysqli_query(

    $conn,

    "SELECT

    order_items.*,

    products.product_name,

    products.image

    FROM order_items

    INNER JOIN products

    ON order_items.product_id = products.id

    WHERE order_items.order_id='$order_id'"

);

include("../includes/header.php");
include("../includes/navbar.php");

?>

<section class="container py-5">

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h2 class="fw-bold">

Order #<?php echo $order['id']; ?>

</h2>

<p class="text-muted">

Order placed on

<?php echo date("M d, Y h:i A", strtotime($order['order_date'])); ?>

</p>

</div>

<span class="badge bg-warning">

<?php echo $order['status']; ?>

</span>

</div>

<div class="card shadow-sm border-0">

<div class="card-body">

<h4 class="mb-4">

Items Ordered

</h4>
<?php while($item = mysqli_fetch_assoc($items)){ ?>

<div class="d-flex align-items-center mb-4">

    <img

        src="../assets/images/products/<?php echo htmlspecialchars($item['image']); ?>"

        class="rounded me-3"

        style="

        width:80px;

        height:80px;

        object-fit:cover;

        ">

    <div class="flex-grow-1">

        <h5 class="mb-1">

            <?php echo htmlspecialchars($item['product_name']); ?>

        </h5>

        <small class="text-muted">

            Quantity :

            <?php echo $item['quantity']; ?>

        </small>

    </div>

    <div class="text-end">

        <strong>

            ₱<?php echo number_format($item['subtotal'],2); ?>

        </strong>

    </div>

</div>

<hr>

<?php } ?>

<div class="row mt-4">

    <div class="col-md-6">

        <h5>

            Payment Method

        </h5>

        <p>

            <?php echo htmlspecialchars($order['payment_method']); ?>

        </p>

    </div>

    <div class="col-md-6 text-end">

        <h5>

            Grand Total

        </h5>

        <h3 class="fw-bold text-success">

            ₱<?php echo number_format($order['total_amount'],2); ?>

        </h3>

    </div>

</div>

<div class="mt-4">

    <a

        href="my_orders.php"

        class="btn btn-warning">

        <i class="bi bi-arrow-left"></i>

        Back to My Orders

    </a>

</div>

</div>

</div>

</section>

<?php include("../includes/footer.php"); ?>