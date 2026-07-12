<?php

session_start();

/* ==========================
   SECURITY
========================== */

if(!isset($_SESSION['user_id'])){

    header("Location: ../buyer/login.php");
    exit();

}

if($_SESSION['role']!="admin"){

    header("Location: ../buyer/shop.php");
    exit();

}

/* ==========================
   PAGE SETTINGS
========================== */

$basePath = "../";

$pageTitle = "Categories | Brew Haven";

$adminCSS = true;

include("../config/database.php");

/* ==========================
   LOAD CATEGORIES
========================== */

$query = mysqli_query(

    $conn,

    "SELECT *
     FROM categories
     ORDER BY category_name ASC"

);

include("../includes/header.php");

?>

<div class="admin-wrapper">

<?php

$currentPage = "categories";

include(__DIR__ . "/includes/sidebar.php");

?>

<main class="content">

    <!-- PAGE HEADER -->

    <div class="page-header d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">

                Categories

            </h2>

            <p class="text-muted mb-0">

                Manage all product categories.

            </p>

        </div>

        <button
            class="btn btn-warning"
            data-bs-toggle="modal"
            data-bs-target="#addCategoryModal">

            <i class="bi bi-plus-circle"></i>

            Add Category

        </button>

    </div>

<?php if(isset($_SESSION['message'])){ ?>

<div class="alert alert-<?php echo $_SESSION['messageClass']; ?> alert-dismissible fade show mb-4">

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

<div class="card shadow-sm border-0">

<div class="card-body table-responsive">

<table class="table table-hover align-middle">

<thead>

<tr>

<th width="80">

ID

</th>

<th>

Category Name

</th>

<th width="180">

Action

</th>

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

            <?php echo htmlspecialchars($row['category_name']); ?>

        </strong>

    </td>

    <td>

        <!-- EDIT -->

        <button
            type="button"
            class="btn btn-sm btn-primary editCategoryBtn"

            data-bs-toggle="modal"
            data-bs-target="#editCategoryModal"

            data-id="<?php echo $row['id']; ?>"

            data-name="<?php echo htmlspecialchars($row['category_name']); ?>">

            <i class="bi bi-pencil-square"></i>

        </button>

        <!-- DELETE -->

        <a
            href="delete_category.php?id=<?php echo $row['id']; ?>"
            class="btn btn-sm btn-danger"
            onclick="return confirm('Delete this category?');">

            <i class="bi bi-trash"></i>

        </a>

    </td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>
<!-- ======================================
     ADD CATEGORY MODAL
====================================== -->

<div class="modal fade"
     id="addCategoryModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <form
                action="add_category.php"
                method="POST">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Add Category

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <label class="form-label">

                        Category Name

                    </label>

                    <input
                        type="text"
                        name="category_name"
                        class="form-control"
                        required>

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
                        class="btn btn-warning">

                        Save Category

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<!-- ======================================
     EDIT CATEGORY MODAL
====================================== -->

<div class="modal fade"
     id="editCategoryModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <form
                action="update_category.php"
                method="POST">

                <input
                    type="hidden"
                    name="id"
                    id="edit_category_id">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Edit Category

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <label class="form-label">

                        Category Name

                    </label>

                    <input
                        type="text"
                        name="category_name"
                        id="edit_category_name"
                        class="form-control"
                        required>

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

                        Update Category

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script>

document.querySelectorAll(".editCategoryBtn").forEach(button=>{

    button.addEventListener("click",function(){

        document.getElementById("edit_category_id").value =
        this.dataset.id;

        document.getElementById("edit_category_name").value =
        this.dataset.name;

    });

});

</script>

</main>

</div>

<?php include("../includes/footer.php"); ?>