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
$pageTitle = "Customers | Brew Haven";
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
   LOAD CUSTOMERS
========================== */

$query = mysqli_query(
    $conn,
    "SELECT *

    FROM users

    WHERE role='buyer'

    AND
    (
        fullname LIKE '%$search%'

        OR

        email LIKE '%$search%'
    )

    ORDER BY fullname ASC"
);

include("../includes/header.php");

?>

<div class="admin-wrapper">

<?php

$currentPage = "customers";

include(__DIR__ . "/includes/sidebar.php");

?>

<main class="content">

<div class="page-header d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold">

            Customers

        </h2>

        <p class="text-muted mb-0">

            View all registered customers.

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

<th>ID</th>

<th>Full Name</th>

<th>Email</th>

<th>Contact</th>

<th>Status</th>

<th>Registered</th>

</tr>

</thead>

<tbody>
<?php while($row = mysqli_fetch_assoc($query)) { ?>

<tr>

    <td>

        <?php echo $row['id']; ?>

    </td>

    <td>

        <strong>

            <?php echo htmlspecialchars($row['fullname']); ?>

        </strong>

    </td>

    <td>

        <?php echo htmlspecialchars($row['email']); ?>

    </td>

    <td>

        <?php echo htmlspecialchars($row['contact']); ?>

    </td>

    <td>

        <?php if($row['status']=="Active"){ ?>

            <span class="badge bg-success">

                Active

            </span>

        <?php } else { ?>

            <span class="badge bg-danger">

                Inactive

            </span>

        <?php } ?>

    </td>

    <td>

        <?php echo date("M d, Y", strtotime($row['created_at'])); ?>

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