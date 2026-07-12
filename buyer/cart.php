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

$pageTitle = "My Cart | Brew Haven";

include("../config/database.php");

/* ==========================
   LOAD CART
========================== */

$user_id = $_SESSION['user_id'];

$query = "

SELECT

cart.*,

products.product_name,

products.price,

products.image,

products.stock

FROM cart

INNER JOIN products

ON cart.product_id = products.id

WHERE cart.user_id='$user_id'

ORDER BY cart.id DESC

";

$cartItems = mysqli_query($conn, $query);

include("../includes/header.php");
include("../includes/navbar.php");

?>

<section class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">

                My Cart

            </h2>

            <p class="text-muted">

                Review your selected items before checkout.

            </p>

        </div>

    </div>

    <div class="card shadow-sm border-0">

        <div class="card-body table-responsive">

            <table class="table align-middle">

                <thead>

                    <tr>

                        <th width="90">

                            Image

                        </th>

                        <th>

                            Product

                        </th>

                        <th>

                            Price

                        </th>

                        <th>

                            Quantity

                        </th>

                        <th>

                            Subtotal

                        </th>

                        <th width="120">

                            Action

                        </th>

                    </tr>

                </thead>

                <tbody>

                <?php

$total = 0;

while($row = mysqli_fetch_assoc($cartItems)){

    $subtotal = $row['price'] * $row['quantity'];

    $total += $subtotal;

?>

<tr>

    <td>

        <img
            src="../assets/images/products/<?php echo htmlspecialchars($row['image']); ?>"
            alt="<?php echo htmlspecialchars($row['product_name']); ?>"
            class="rounded"
            style="width:70px;height:70px;object-fit:cover;">

    </td>

    <td>

        <strong>

            <?php echo htmlspecialchars($row['product_name']); ?>

        </strong>

    </td>

    <td>

        ₱<?php echo number_format($row['price'],2); ?>

    </td>

    <td>

        <form
            action="update_cart.php"
            method="POST"
            class="d-flex align-items-center">

            <input
                type="hidden"
                name="cart_id"
                value="<?php echo $row['id']; ?>">

            <input
                type="number"
                name="quantity"
                value="<?php echo $row['quantity']; ?>"
                min="1"
                max="<?php echo $row['stock']; ?>"
                class="form-control me-2"
                style="width:90px;">

            <button
                class="btn btn-sm btn-warning">

                Update

            </button>

        </form>

    </td>

    <td>

        ₱<?php echo number_format($subtotal,2); ?>

    </td>

    <td>

        <a
            href="remove_cart.php?id=<?php echo $row['id']; ?>"
            class="btn btn-sm btn-danger"
            onclick="return confirm('Remove this item from cart?');">

            <i class="bi bi-trash"></i>

        </a>

    </td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>
<!-- ==========================
     CART TOTAL
========================== -->

<div class="card shadow-sm border-0 mt-4">

    <div class="card-body">

        <?php if($total > 0){ ?>

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h4 class="mb-0">

                        Total

                    </h4>

                </div>

                <div>

                    <h3 class="fw-bold text-success">

                        ₱<?php echo number_format($total,2); ?>

                    </h3>

                </div>

            </div>

            <div class="text-end mt-4">

                <a
                    href="checkout.php"
                    class="btn btn-warning btn-lg">

                    <i class="bi bi-credit-card"></i>

                    Proceed to Checkout

                </a>

            </div>

        <?php } else { ?>

            <div class="text-center py-5">

                <i class="bi bi-cart-x"
                   style="font-size:60px;color:#999;"></i>

                <h4 class="mt-3">

                    Your cart is empty.

                </h4>

                <p class="text-muted">

                    Add some delicious coffee or desserts first.

                </p>

                <a
                    href="shop.php"
                    class="btn btn-warning">

                    Continue Shopping

                </a>

            </div>

        <?php } ?>

    </div>

</div>

</section>

<?php include("../includes/footer.php"); ?>