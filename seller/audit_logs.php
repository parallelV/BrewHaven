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
$pageTitle = "Audit Logs | Brew Haven";
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
   LOAD LOGS
========================== */

$query = mysqli_query(

    $conn,

    "SELECT

        audit_logs.*,

        users.fullname

     FROM audit_logs

     INNER JOIN users

     ON audit_logs.user_id = users.id

     WHERE

        users.fullname LIKE '%$search%'

        OR

        audit_logs.activity LIKE '%$search%'

     ORDER BY audit_logs.log_time DESC"

);

include("../includes/header.php");

?>

<div class="admin-wrapper">

<?php

$currentPage = "audit";

include(__DIR__ . "/includes/sidebar.php");

?>

<main class="content">

<div class="page-header d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold">

            Audit Logs

        </h2>

        <p class="text-muted">

            View all administrator activities.

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
placeholder="Search activity...">

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

<th>User</th>

<th>Activity</th>

<th>Date & Time</th>

</tr>

</thead>

<tbody>
<?php if(mysqli_num_rows($query) > 0){ ?>

    <?php while($row = mysqli_fetch_assoc($query)){ ?>

    <tr>

        <td>

            <strong>

                <?php echo htmlspecialchars($row['fullname']); ?>

            </strong>

        </td>

        <td>

            <?php echo htmlspecialchars($row['activity']); ?>

        </td>

        <td>

            <?php echo date("M d, Y h:i A", strtotime($row['log_time'])); ?>

        </td>

    </tr>

    <?php } ?>

<?php } else { ?>

<tr>

    <td colspan="3" class="text-center text-muted">

        No audit logs found.

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