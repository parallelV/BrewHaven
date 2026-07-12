<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../buyer/login.php");
    exit();
}

if ($_SESSION['role'] != "admin") {
    header("Location: ../buyer/shop.php");
    exit();
}

$basePath = "../";
include("../config/database.php");

$productResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM products");
$productData = mysqli_fetch_assoc($productResult);
$productCount = $productData['total'];

$userResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role='buyer'");
$userData = mysqli_fetch_assoc($userResult);
$userCount = $userData['total'];

$orderResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders");
$orderData = mysqli_fetch_assoc($orderResult);
$orderCount = $orderData['total'];

$salesResult = mysqli_query($conn, "SELECT SUM(total_amount) AS total FROM orders");
$salesData = mysqli_fetch_assoc($salesResult);
$totalSales = $salesData['total'];

if ($totalSales == NULL) {
    $totalSales = 0;
}

$weeklyRevenue = array();

for ($i = 6; $i >= 0; $i--) {
    $dateKey = date('Y-m-d', strtotime("-$i days"));
    $dayLabel = date('D', strtotime($dateKey));
    $weeklyRevenue[$dateKey] = array("label" => $dayLabel, "total" => 0);
}

$weeklyResult = mysqli_query($conn, "SELECT DATE(order_date) AS day, SUM(total_amount) AS total
    FROM orders
    WHERE order_date >= (CURDATE() - INTERVAL 6 DAY)
    GROUP BY DATE(order_date)");

while ($row = mysqli_fetch_assoc($weeklyResult)) {
    if (isset($weeklyRevenue[$row['day']])) {
        $weeklyRevenue[$row['day']]['total'] = (float) $row['total'];
    }
}

$revenueLabels = array_column($weeklyRevenue, 'label');
$revenueValues = array_column($weeklyRevenue, 'total');

$topSellingResult = mysqli_query($conn, "SELECT products.product_name, SUM(order_items.quantity) AS total_sold
    FROM order_items
    INNER JOIN products ON order_items.product_id = products.id
    GROUP BY order_items.product_id
    ORDER BY total_sold DESC
    LIMIT 5");

$topItemLabels = array();
$topItemValues = array();

while ($row = mysqli_fetch_assoc($topSellingResult)) {
    $topItemLabels[] = $row['product_name'];
    $topItemValues[] = (int) $row['total_sold'];
}

$pageTitle = "Admin Dashboard | Brew Haven";
$adminCSS = true;
include("../includes/header.php");
?>

<div class="admin-wrapper">
    <?php
    $currentPage = "dashboard";
    include(__DIR__ . "/includes/sidebar.php");
    ?>

    <main class="content">
        <div class="page-header">
            <h2>Dashboard</h2>
            <p>Welcome back, <strong><?php echo $_SESSION['fullname']; ?></strong></p>
        </div>

        <div class="dashboard-cards">
            <div class="dashboard-card">
                <h3>Products</h3>
                <h1><?php echo $productCount; ?></h1>
            </div>
            <div class="dashboard-card">
                <h3>Users</h3>
                <h1><?php echo $userCount; ?></h1>
            </div>
            <div class="dashboard-card">
                <h3>Orders</h3>
                <h1><?php echo $orderCount; ?></h1>
            </div>
            <div class="dashboard-card">
                <h3>Sales</h3>
                <h1>₱<?php echo number_format($totalSales, 2); ?></h1>
            </div>
        </div>

        <div class="analytics-grid">
            <div class="chart-card">
                <h3>Weekly Revenue</h3>
                <div class="chart-box">
                    <canvas id="weeklyRevenueChart"></canvas>
                </div>
            </div>
            <div class="chart-card chart-card-side">
                <h3>Top Selling Items</h3>
                <div class="chart-box chart-box-small">
                    <canvas id="topItemsChart"></canvas>
                </div>
                <ul class="chart-legend" id="topItemsLegend"></ul>
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
const revenueLabels = <?php echo json_encode($revenueLabels); ?>;
const revenueValues = <?php echo json_encode($revenueValues); ?>;
const topItemLabels = <?php echo json_encode($topItemLabels); ?>;
const topItemValues = <?php echo json_encode($topItemValues); ?>;
const topItemColors = ["#4E342E", "#D4A373", "#8D6E63", "#C9A66B", "#A1887F"];

new Chart(document.getElementById('weeklyRevenueChart'), {
    type: 'bar',
    data: {
        labels: revenueLabels,
        datasets: [{
            label: 'Revenue (₱)',
            data: revenueValues,
            backgroundColor: '#4E342E',
            borderRadius: 8,
            maxBarThickness: 48
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: '#f0f0f0' } },
            x: { grid: { display: false } }
        }
    }
});

if (topItemLabels.length > 0) {
    new Chart(document.getElementById('topItemsChart'), {
        type: 'doughnut',
        data: {
            labels: topItemLabels,
            datasets: [{
                data: topItemValues,
                backgroundColor: topItemColors,
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: { legend: { display: false } }
        }
    });

    const legend = document.getElementById('topItemsLegend');
    topItemLabels.forEach((label, i) => {
        const li = document.createElement('li');
        li.innerHTML = `
            <span class="legend-dot" style="background:${topItemColors[i % topItemColors.length]}"></span>
            <span class="legend-name">${label}</span>
            <span class="legend-value">${topItemValues[i]}</span>
        `;
        legend.appendChild(li);
    });
} else {
    document.getElementById('topItemsLegend').innerHTML = '<li class="text-muted">No sales yet.</li>';
}
</script>

<?php include("../includes/footer.php"); ?>