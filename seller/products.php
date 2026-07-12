<?php

session_start();

/* ==========================
   LOGIN PROTECTION
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
$pageTitle = "Products | Brew Haven";
$adminCSS = true;

include("../config/database.php");

/* ==========================
   LOAD PRODUCTS
========================== */

$search = "";

if(isset($_GET['search'])){

    $search = mysqli_real_escape_string(
        $conn,
        trim($_GET['search'])
    );

}

$query = "

SELECT

products.*,

categories.category_name

FROM products

INNER JOIN categories

ON products.category_id = categories.id

WHERE

products.product_name LIKE '%$search%'

OR

categories.category_name LIKE '%$search%'

ORDER BY products.product_name ASC

";

$products = mysqli_query($conn, $query);

include("../includes/header.php");

?>

<div class="admin-wrapper">

<?php

$currentPage = "products";
include(__DIR__ . "/includes/sidebar.php");

?>

<main class="content">

   <!-- PAGE HEADER -->

<div class="page-header d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold">

            Products

        </h2>

        <p class="text-muted mb-0">

            Manage all café products available in Brew Haven.

        </p>

    </div>

    <button
        class="btn btn-warning"
        data-bs-toggle="modal"
        data-bs-target="#addProductModal">

        <i class="bi bi-plus-circle"></i>

        Add Product

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
        type="button"
        class="btn-close"
        data-bs-dismiss="alert">
    </button>

</div>

<?php } ?>

    <!-- SEARCH -->

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
                            placeholder="Search Product...">

                    </div>

                    <div class="col-lg-2">

                        <button
                            class="btn btn-warning w-100"
                            type="submit">

                            <i class="bi bi-search"></i>

                            Search

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- PRODUCTS TABLE -->

    <div class="card shadow-sm border-0">

        <div class="card-body table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>

                        <th width="90">

                            Image

                        </th>

                        <th>

                            Product

                        </th>

                        <th>

                            Category

                        </th>

                        <th>

                            Price

                        </th>

                        <th>

                            Stock

                        </th>

                        <th>

                            Status

                        </th>

                        <th width="170">

                            Action

                        </th>

                    </tr>

                </thead>

                <tbody>

                <?php while($row = mysqli_fetch_assoc($products)) { ?>

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

        <br>

        <small class="text-muted">

            <?php echo htmlspecialchars($row['description']); ?>

        </small>

    </td>

    <td>

        <span class="badge bg-secondary">

            <?php echo htmlspecialchars($row['category_name']); ?>

        </span>

    </td>

    <td>

        ₱<?php echo number_format($row['price'],2); ?>

    </td>

    <td>

        <?php echo (int)$row['stock']; ?>

    </td>

    <td>

        <?php if($row['status']=="Available"){ ?>

            <span class="badge bg-success">

                Available

            </span>

        <?php }else{ ?>

            <span class="badge bg-danger">

                Unavailable

            </span>

        <?php } ?>

    </td>

    <td>
<button
    type="button"
    class="btn btn-sm btn-primary editProductBtn"

    data-bs-toggle="modal"
    data-bs-target="#editProductModal"

    data-id="<?php echo $row['id']; ?>"

    data-category="<?php echo $row['category_id']; ?>"

    data-type="<?php echo htmlspecialchars($row['product_type']); ?>"

    data-name="<?php echo htmlspecialchars($row['product_name']); ?>"

    data-description="<?php echo htmlspecialchars($row['description']); ?>"

    data-size="<?php echo htmlspecialchars($row['size']); ?>"

    data-price="<?php echo $row['price']; ?>"

    data-stock="<?php echo $row['stock']; ?>"

    data-status="<?php echo htmlspecialchars($row['status']); ?>">

    <i class="bi bi-pencil-square"></i>

</button>

        <a
            href="delete_product.php?id=<?php echo $row['id']; ?>"
            class="btn btn-sm btn-danger"
            onclick="return confirm('Delete this product?');">

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
     ADD PRODUCT MODAL
========================== -->

<div class="modal fade"
     id="addProductModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form
                action="add_product.php"
                method="POST"
                enctype="multipart/form-data">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Add New Product

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="row">

                        <!-- CATEGORY -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Category

                            </label>

                            <select
                                name="category_id"
                                class="form-select"
                                required>

                                <option value="">

                                    Select Category

                                </option>

                                <?php

                                $categoryQuery = mysqli_query(
                                    $conn,
                                    "SELECT * FROM categories ORDER BY category_name ASC"
                                );

                                while($category = mysqli_fetch_assoc($categoryQuery)){

                                ?>

                                <option value="<?php echo $category['id']; ?>">

                                    <?php echo $category['category_name']; ?>

                                </option>

                                <?php } ?>

                            </select>

                        </div>

                        <!-- TYPE -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Product Type

                            </label>

                            <select
                                name="product_type"
                                class="form-select">

                                <option value="Drink">Drink</option>

                                <option value="Food">Food</option>

                            </select>

                        </div>

                        <!-- NAME -->

                        <div class="col-md-12 mb-3">

                            <label class="form-label">

                                Product Name

                            </label>

                            <input
                                type="text"
                                name="product_name"
                                class="form-control"
                                required>

                        </div>

                        <!-- DESCRIPTION -->

                        <div class="col-md-12 mb-3">

                            <label class="form-label">

                                Description

                            </label>

                            <textarea
                                name="description"
                                rows="3"
                                class="form-control"></textarea>

                        </div>

                        <!-- SIZE -->

                        <div class="col-md-4 mb-3">

                            <label class="form-label">

                                Size

                            </label>

                            <select
                                name="size"
                                class="form-select">

                                <option>Regular</option>
                                <option>Medium</option>
                                <option>Large</option>

                            </select>

                        </div>

                        <!-- PRICE -->

                        <div class="col-md-4 mb-3">

                            <label class="form-label">

                                Price

                            </label>

                            <input
                                type="number"
                                step="0.01"
                                name="price"
                                class="form-control"
                                required>

                        </div>

                        <!-- STOCK -->

                        <div class="col-md-4 mb-3">

                            <label class="form-label">

                                Stock

                            </label>

                            <input
                                type="number"
                                name="stock"
                                class="form-control"
                                required>

                        </div>

                        <!-- STATUS -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Status

                            </label>

                            <select
                                name="status"
                                class="form-select">

                                <option value="Available">

                                    Available

                                </option>

                                <option value="Unavailable">

                                    Unavailable

                                </option>

                            </select>

                        </div>

                        <!-- IMAGE -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Product Image

                            </label>

                            <input
                                type="file"
                                name="image"
                                class="form-control"
                                accept=".jpg,.jpeg,.png"
                                required>

                        </div>

                    </div>

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

                        Save Product

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<!-- ==========================
     EDIT PRODUCT MODAL
========================== -->

<div class="modal fade"
     id="editProductModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form
                action="update_product.php"
                method="POST"
                enctype="multipart/form-data">

                <input
                    type="hidden"
                    name="id"
                    id="edit_id">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Edit Product

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="row">

                        <!-- CATEGORY -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Category

                            </label>

                            <select
                                name="category_id"
                                id="edit_category"
                                class="form-select"
                                required>

                                <?php

                                $categoryList = mysqli_query(
                                    $conn,
                                    "SELECT * FROM categories ORDER BY category_name ASC"
                                );

                                while($cat = mysqli_fetch_assoc($categoryList)){

                                ?>

                                <option value="<?php echo $cat['id']; ?>">

                                    <?php echo $cat['category_name']; ?>

                                </option>

                                <?php } ?>

                            </select>

                        </div>

                        <!-- TYPE -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Product Type

                            </label>

                            <select
                                name="product_type"
                                id="edit_type"
                                class="form-select">

                                <option value="Drink">Drink</option>
                                <option value="Food">Food</option>

                            </select>

                        </div>

                        <!-- NAME -->

                        <div class="col-md-12 mb-3">

                            <label class="form-label">

                                Product Name

                            </label>

                            <input
                                type="text"
                                name="product_name"
                                id="edit_name"
                                class="form-control"
                                required>

                        </div>

                        <!-- DESCRIPTION -->

                        <div class="col-md-12 mb-3">

                            <label class="form-label">

                                Description

                            </label>

                            <textarea
                                name="description"
                                id="edit_description"
                                rows="3"
                                class="form-control"></textarea>

                        </div>

                        <!-- SIZE -->

                        <div class="col-md-4 mb-3">

                            <label class="form-label">

                                Size

                            </label>

                            <select
                                name="size"
                                id="edit_size"
                                class="form-select">

                                <option>Regular</option>
                                <option>Medium</option>
                                <option>Large</option>

                            </select>

                        </div>

                        <!-- PRICE -->

                        <div class="col-md-4 mb-3">

                            <label class="form-label">

                                Price

                            </label>

                            <input
                                type="number"
                                step="0.01"
                                name="price"
                                id="edit_price"
                                class="form-control"
                                required>

                        </div>

                        <!-- STOCK -->

                        <div class="col-md-4 mb-3">

                            <label class="form-label">

                                Stock

                            </label>

                            <input
                                type="number"
                                name="stock"
                                id="edit_stock"
                                class="form-control"
                                required>

                        </div>

                        <!-- STATUS -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Status

                            </label>

                            <select
                                name="status"
                                id="edit_status"
                                class="form-select">

                                <option value="Available">Available</option>
                                <option value="Unavailable">Unavailable</option>

                            </select>

                        </div>

                        <!-- IMAGE -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Replace Image (Optional)

                            </label>

                            <input
                                type="file"
                                name="image"
                                class="form-control"
                                accept=".jpg,.jpeg,.png">

                        </div>

                    </div>

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

                        Update Product

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

</main>

</div>

<script>

const editButtons = document.querySelectorAll(".editProductBtn");

editButtons.forEach(button => {

    button.addEventListener("click", function(){

        document.getElementById("edit_id").value =
        this.dataset.id;

        document.getElementById("edit_category").value =
        this.dataset.category;

        document.getElementById("edit_type").value =
        this.dataset.type;

        document.getElementById("edit_name").value =
        this.dataset.name;

        document.getElementById("edit_description").value =
        this.dataset.description;

        document.getElementById("edit_size").value =
        this.dataset.size;

        document.getElementById("edit_price").value =
        this.dataset.price;

        document.getElementById("edit_stock").value =
        this.dataset.stock;

        document.getElementById("edit_status").value =
        this.dataset.status;

    });

});

</script>



<?php include("../includes/footer.php"); ?>