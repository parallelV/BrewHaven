<?php

session_start();

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit();

}

if ($_SESSION['role'] != "buyer") {

    header("Location: ../seller/dashboard.php");
    exit();

}

$basePath = "../";

include("../config/database.php");
include("../includes/header.php");
include("../includes/navbar.php");

// Get all available products
$search = "";
$category = "";

if(isset($_GET['search'])){
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}

if(isset($_GET['category'])){
    $category = mysqli_real_escape_string($conn, $_GET['category']);
}

$query = "SELECT products.*, categories.category_name
FROM products
INNER JOIN categories
ON products.category_id = categories.id
WHERE products.status='Available'";

if($search != ""){
    $query .= " AND (
        products.product_name LIKE '%$search%'
        OR products.description LIKE '%$search%'
    )";
}

if($category != ""){
    $query .= " AND categories.category_name='$category'";
}

$query .= " ORDER BY products.id ASC";

$products = mysqli_query($conn, $query);

?>

<!-- SHOP HERO -->

<section class="shop-banner">

    <div class="container text-center">

        <h1>Our Menu</h1>

        <p>
            Discover handcrafted coffee, refreshing beverages,
            pastries and desserts made fresh every day.
        </p>

    </div>

</section>
<?php if(isset($_SESSION['message'])){ ?>

<div class="container mt-4">

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

</div>

<?php } ?>
<!-- SEARCH -->

<section class="container mt-5">

    <form method="GET">

        <div class="row justify-content-center">

            <div class="col-lg-8">

                <div class="input-group">

                    <input
                        type="text"
                        name="search"
                        value="<?php echo htmlspecialchars($search); ?>"
                        class="form-control form-control-lg"
                        placeholder="Search your favorite drink...">

                    <button class="btn btn-warning" type="submit">

                        <i class="bi bi-search"></i>

                        Search

                    </button>

                </div>

            </div>

        </div>

    </form>

</section>

<!-- CATEGORY BUTTONS -->
<section class="container mt-4">

    <div class="text-center">

        <a href="shop.php?search=<?php echo urlencode($search); ?>"
           class="btn btn-category <?php echo ($category=="") ? "active" : ""; ?>">
           All
        </a>

       <a href="shop.php?category=Hot Coffee&search=<?php echo urlencode($search); ?>"
        class="btn btn-category <?php echo ($category=="Hot Coffee") ? "active" : ""; ?>">
        Hot Coffee
        </a>

        <a href="shop.php?category=Iced Coffee&search=<?php echo urlencode($search); ?>"
           class="btn btn-category <?php echo ($category=="Iced Coffee") ? "active" : ""; ?>">
        Iced Coffee
        </a>
        
        <a href="shop.php?category=Refreshers&search=<?php echo urlencode($search); ?>"
           class="btn btn-category <?php echo ($category=="Refreshers") ? "active" : ""; ?>">
            Refreshers
        </a>
        
        <a href="shop.php?category=<?php echo urlencode('Bread & Pastries'); ?>&search=<?php echo urlencode($search); ?>"
        class="btn btn-category <?php echo ($category=="Bread & Pastries") ? "active" : ""; ?>">
            Bread & Pastries
        </a>

      <a href="shop.php?category=<?php echo urlencode('Cakes & Desserts'); ?>&search=<?php echo urlencode($search); ?>"
         class="btn btn-category <?php echo ($category=="Cakes & Desserts") ? "active" : ""; ?>">
      Cakes & Desserts
      </a>

    </div>

</section>

<!-- PRODUCTS -->

<section class="container py-5">

    <div class="row g-4 justify-content-center">

        <!-- Product -->

      <?php while($row = mysqli_fetch_assoc($products)) { ?>

<div class="col-xl-3 col-lg-4 col-md-6">

    <div class="shop-card">

            <span class="badge-category">

                <?php echo htmlspecialchars($row['category_name']); ?>

            </span>

        <img
            src="../assets/images/products/<?php echo htmlspecialchars($row['image']); ?>"
            alt="<?php echo htmlspecialchars($row['product_name']); ?>">

        <div class="p-4">

            <small class="text-muted">

                <?php echo htmlspecialchars($row['category_name']); ?>

            </small>

            <h4 class="mt-2">

                <?php echo htmlspecialchars($row['product_name']); ?>

            </h4>

            <p>

                <?php echo htmlspecialchars($row['description']); ?>

            </p>

            <h5>

                ₱<?php echo number_format($row['price'],2); ?>

            </h5>

            <p class="stock-text">

                In Stock : <?php echo (int)$row['stock']; ?>

            </p>
        <form
    action="add_to_cart.php"
    method="POST">

    <input
        type="hidden"
        name="product_id"
        value="<?php echo $row['id']; ?>">

    <div class="quantity-box">

        <input
            type="number"
            name="quantity"
            value="1"
            min="1"
            max="<?php echo $row['stock']; ?>"
            class="form-control text-center">

    </div>

    <button
        type="submit"
        class="btn btn-warning w-100 mt-3">

        <i class="bi bi-cart-plus"></i>

        Add to Cart

    </button>

</form>

        </div>

    </div>

</div>

    <?php } ?>

</div>

</section>

<?php
include("../includes/footer.php");
?>