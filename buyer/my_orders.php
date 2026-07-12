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

$pageTitle = "My Orders | Brew Haven";

include("../config/database.php");

/* ==========================
   LOAD ORDERS
========================== */

$user_id = $_SESSION['user_id'];

$query = mysqli_query(

    $conn,

    "SELECT *

     FROM orders

     WHERE user_id='$user_id'

     ORDER BY order_date DESC"

);

include("../includes/header.php");
include("../includes/navbar.php");

?>

<section class="container py-5">

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h2 class="fw-bold">

My Orders

</h2>

<p class="text-muted">

View your order history.

</p>

</div>

</div>

<?php if(isset($_SESSION['message'])){ ?>

<div class="alert alert-<?php echo $_SESSION['messageClass']; ?> alert-dismissible fade show">

<?php

echo $_SESSION['message'];

unset($_SESSION['message']);
unset($_SESSION['messageClass']);

?>

<button
type="button"
class="btn-close"
data-bs-dismiss="alert">

</button>

</div>

<?php } ?>

<div class="card shadow-sm border-0">

<div class="card-body table-responsive">

<table class="table align-middle">

<thead>

<tr>

<th>

Order #

</th>

<th>

Order Date

</th>

<th>

Payment

</th>

<th>

Total

</th>

<th>

Status

</th>

<th>

Action

</th>

</tr>

</thead>

<tbody>
<?php while($row = mysqli_fetch_assoc($query)) { ?>

<tr>

    <td>

        <strong>

            #<?php echo $row['id']; ?>

        </strong>

    </td>

    <td>

        <?php echo date("M d, Y h:i A", strtotime($row['order_date'])); ?>

    </td>

    <td>

        <?php echo htmlspecialchars($row['payment_method']); ?>

    </td>

    <td>

        ₱<?php echo number_format($row['total_amount'],2); ?>

    </td>

    <td>

        <?php

        switch($row['status']){

            case "Pending":
                $badge = "warning";
                break;

            case "Preparing":
                $badge = "primary";
                break;

            case "Completed":
                $badge = "success";
                break;

            case "Cancelled":
                $badge = "danger";
                break;

            default:
                $badge = "secondary";

        }

        ?>

        <span class="badge bg-<?php echo $badge; ?>">

            <?php echo htmlspecialchars($row['status']); ?>

        </span>

    </td>

    <td>

        <a
            href="order_details.php?id=<?php echo $row['id']; ?>"
            class="btn btn-sm btn-outline-primary">

            <i class="bi bi-eye"></i>

            View

        </a>

    </td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</section>

<?php include("../includes/footer.php"); ?>