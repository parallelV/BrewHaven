<?php

session_start();

if(!isset($_SESSION['user_id'])){

    header("Location: ../buyer/login.php");
    exit();

}

if($_SESSION['role']!="admin"){

    header("Location: ../buyer/shop.php");
    exit();

}

$basePath="../";

$pageTitle="Reports | Brew Haven";

$adminCSS=true;

include("../config/database.php");

/* ==========================
   SUMMARY
========================== */

$totalSales=mysqli_fetch_assoc(

mysqli_query(

$conn,

"SELECT

IFNULL(SUM(total_amount),0)

AS total

FROM orders"

)

);

$totalOrders=mysqli_fetch_assoc(

mysqli_query(

$conn,

"SELECT COUNT(*) AS total

FROM orders"

)

);

$totalCustomers=mysqli_fetch_assoc(

mysqli_query(

$conn,

"SELECT COUNT(*) AS total

FROM users

WHERE role='buyer'"

)

);

$totalProducts=mysqli_fetch_assoc(

mysqli_query(

$conn,

"SELECT COUNT(*) AS total

FROM products"

)

);

include("../includes/header.php");

?>

<div class="admin-wrapper">

<?php

$currentPage="reports";

include(__DIR__."/includes/sidebar.php");

?>

<main class="content">

<div class="page-header mb-4">

<h2 class="fw-bold">

Reports

</h2>

<p class="text-muted">

Business Overview

</p>

</div>

<div class="dashboard-cards">

<div class="dashboard-card">

<h3>

Total Sales

</h3>

<h1>

₱<?php echo number_format($totalSales['total'],2); ?>

</h1>

</div>

<div class="dashboard-card">

<h3>

Orders

</h3>

<h1>

<?php echo $totalOrders['total']; ?>

</h1>

</div>

<div class="dashboard-card">

<h3>

Customers

</h3>

<h1>

<?php echo $totalCustomers['total']; ?>

</h1>

</div>

<div class="dashboard-card">

<h3>

Products

</h3>

<h1>

<?php echo $totalProducts['total']; ?>

</h1>

</div>

</div>
<!-- ==========================
     BEST SELLING PRODUCTS
========================== -->

<?php

$bestSelling = mysqli_query(

    $conn,

    "SELECT

        products.product_name,

        SUM(order_items.quantity) AS total_sold

     FROM order_items

     INNER JOIN products

     ON order_items.product_id = products.id

     GROUP BY order_items.product_id

     ORDER BY total_sold DESC

     LIMIT 5"

);

?>

<div class="card shadow-sm border-0 mt-4">

    <div class="card-body">

        <h4 class="fw-bold mb-4">

            🏆 Best Selling Products

        </h4>

        <table class="table table-hover align-middle">

            <thead>

                <tr>

                    <th>Product</th>

                    <th class="text-end">

                        Total Sold

                    </th>

                </tr>

            </thead>

            <tbody>

            <?php if(mysqli_num_rows($bestSelling) > 0){ ?>

                <?php while($row = mysqli_fetch_assoc($bestSelling)){ ?>

                <tr>

                    <td>

                        <?php echo htmlspecialchars($row['product_name']); ?>

                    </td>

                    <td class="text-end">

                        <span class="badge bg-success">

                            <?php echo $row['total_sold']; ?>

                        </span>

                    </td>

                </tr>

                <?php } ?>

            <?php } else { ?>

                <tr>

                    <td colspan="2" class="text-center text-muted">

                        No sales yet.

                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>
<!-- ==========================
     LATEST ORDERS
========================== -->

<?php

$latestOrders = mysqli_query(

    $conn,

    "SELECT

        orders.*,

        users.fullname

     FROM orders

     INNER JOIN users

     ON orders.user_id = users.id

     ORDER BY orders.order_date DESC

     LIMIT 5"

);

?>

<div class="card shadow-sm border-0 mt-4">

    <div class="card-body">

        <h4 class="fw-bold mb-4">

            📋 Latest Orders

        </h4>

        <table class="table table-hover align-middle">

            <thead>

                <tr>

                    <th>Order #</th>

                    <th>Customer</th>

                    <th>Total</th>

                    <th>Status</th>

                    <th>Date</th>

                </tr>

            </thead>

            <tbody>

            <?php if(mysqli_num_rows($latestOrders) > 0){ ?>

                <?php while($row = mysqli_fetch_assoc($latestOrders)){ ?>

                <tr>

                    <td>

                        #<?php echo $row['id']; ?>

                    </td>

                    <td>

                        <?php echo htmlspecialchars($row['fullname']); ?>

                    </td>

                    <td>

                        ₱<?php echo number_format($row['total_amount'],2); ?>

                    </td>

                    <td>

                        <?php

                        switch($row['status']){

                            case "Pending":
                                $badge="warning";
                                break;

                            case "Preparing":
                                $badge="primary";
                                break;

                            case "Completed":
                                $badge="success";
                                break;

                            case "Cancelled":
                                $badge="danger";
                                break;

                            default:
                                $badge="secondary";

                        }

                        ?>

                        <span class="badge bg-<?php echo $badge; ?>">

                            <?php echo htmlspecialchars($row['status']); ?>

                        </span>

                    </td>

                    <td>

                        <?php echo date("M d, Y h:i A", strtotime($row['order_date'])); ?>

                    </td>

                </tr>

                <?php } ?>

            <?php } else { ?>

                <tr>

                    <td colspan="5" class="text-center text-muted">

                        No orders available.

                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>

</main>

</div>

<?php include("../includes/footer.php"); ?>