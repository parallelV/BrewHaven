<?php

session_start();

/* ==========================
   SECURITY
========================== */

if (!isset($_SESSION['user_id'])) {
    header("Location: ../buyer/login.php");
    exit();
}

if ($_SESSION['role'] != "admin") {
    header("Location: ../buyer/shop.php");
    exit();
}

/* ==========================
   PAGE SETTINGS
========================== */

$basePath = "../";
$pageTitle = "Orders | Brew Haven";
$adminCSS = true;

include("../config/database.php");

/* ==========================
   SEARCH
========================== */

$search = "";

if(isset($_GET['search'])){
    $search = mysqli_real_escape_string(
        $conn,
        trim($_GET['search'])
    );
}

/* ==========================
   LOAD ORDERS
========================== */

$query = mysqli_query(

    $conn,

    "SELECT

    orders.*,

    users.fullname

    FROM orders

    INNER JOIN users

    ON orders.user_id = users.id

    WHERE

    users.fullname LIKE '%$search%'

    ORDER BY orders.order_date DESC"

);

include("../includes/header.php");

?>

<div class="admin-wrapper">

<?php

$currentPage = "orders";
include(__DIR__ . "/includes/sidebar.php");

?>

<main class="content">

<div class="page-header d-flex justify-content-between align-items-center mb-4">

<div>

<h2 class="fw-bold">

Orders

</h2>

<p class="text-muted mb-0">

Manage all customer orders.

</p>

</div>

</div>

<div class="card shadow-sm border-0 mb-4">

<div class="card-body">

<form method="GET">

<div class="row">

<div class="col-lg-5">

<input

type="text"

name="search"

value="<?php echo htmlspecialchars($search); ?>"

class="form-control"

placeholder="Search customer...">

</div>

<div class="col-lg-2">

<button
class="btn btn-warning w-100">

Search

</button>

</div>

</div>

</form>

</div>

</div>

<div class="card shadow-sm border-0">

<div class="card-body table-responsive">

<table class="table table-hover align-middle">

<thead>

<tr>

<th>Order #</th>

<th>Customer</th>

<th>Payment</th>

<th>Total</th>

<th>Status</th>

<th>Date</th>

<th width="170">

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

        <?php echo htmlspecialchars($row['fullname']); ?>

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

        <?php echo date("M d, Y h:i A", strtotime($row['order_date'])); ?>

    </td>

    <td>

        <button
            type="button"
            class="btn btn-sm btn-primary editStatusBtn"

            data-bs-toggle="modal"
            data-bs-target="#statusModal"

            data-id="<?php echo $row['id']; ?>"

            data-status="<?php echo htmlspecialchars($row['status']); ?>">

            <i class="bi bi-pencil-square"></i>

            Update

        </button>

    </td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>
<!-- ======================================
     UPDATE ORDER STATUS MODAL
====================================== -->

<div class="modal fade"
     id="statusModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <form
                action="update_order.php"
                method="POST">

                <input
                    type="hidden"
                    name="order_id"
                    id="order_id">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Update Order Status

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <label class="form-label">

                        Order Status

                    </label>

                    <select
                        name="status"
                        id="order_status"
                        class="form-select">

                        <option value="Pending">

                            Pending

                        </option>

                        <option value="Preparing">

                            Preparing

                        </option>

                        <option value="Completed">

                            Completed

                        </option>

                        <option value="Cancelled">

                            Cancelled

                        </option>

                    </select>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        Update Status

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script>

document.querySelectorAll(".editStatusBtn").forEach(button=>{

    button.addEventListener("click",function(){

        document.getElementById("order_id").value =
        this.dataset.id;

        document.getElementById("order_status").value =
        this.dataset.status;

    });

});

</script>

</main>

</div>

<?php include("../includes/footer.php"); ?>