<?php
require_once 'connection.php';
include 'header.php';

$sales_q = mysqli_query($conn, "SELECT SUM(total_amount) AS total FROM `orders` WHERE status='delivered'");
$sales_row = mysqli_fetch_assoc($sales_q);
$total_sales = $sales_row['total'] ?? 0;

$orders_cnt = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM `orders`"))['total'];
$cats_cnt = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM `categories`"))['total'];
$prods_cnt = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM `products`"))['total'];
$custs_cnt = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM `customers`"))['total'];
?>

<div class="row mb-4">
    <div class="col-12">
        <h1 class="fw-bold text-dark">Admin Metrics Dashboard</h1>
        <p class="text-muted">Real-time status overview of Derma Glow operations.</p>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card bg-success text-white border-0 shadow-sm p-3">
            <h6 class="text-uppercase small opacity-75">Delivered Revenue</h6>
            <h2 class="fw-bold m-0">PKR <?php echo number_format($total_sales, 2); ?></h2>
        </div>
    </div>
    <div class="col-md-2 col-sm-6">
        <div class="card bg-primary text-white border-0 shadow-sm p-3">
            <h6 class="text-uppercase small opacity-75">Orders</h6>
            <h2 class="fw-bold m-0"><?php echo $orders_cnt; ?></h2>
        </div>
    </div>
    <div class="col-md-2 col-sm-6">
        <div class="card bg-info text-white border-0 shadow-sm p-3">
            <h6 class="text-uppercase small opacity-75">Products</h6>
            <h2 class="fw-bold m-0"><?php echo $prods_cnt; ?></h2>
        </div>
    </div>
    <div class="col-md-2 col-sm-6">
        <div class="card bg-warning text-dark border-0 shadow-sm p-3">
            <h6 class="text-uppercase small opacity-75">Categories</h6>
            <h2 class="fw-bold m-0"><?php echo $cats_cnt; ?></h2>
        </div>
    </div>
    <div class="col-md-2 col-sm-6">
        <div class="card bg-dark text-white border-0 shadow-sm p-3">
            <h6 class="text-uppercase small opacity-75">Customers</h6>
            <h2 class="fw-bold m-0"><?php echo $custs_cnt; ?></h2>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm p-4 bg-white text-center">
            <h4 class="fw-bold"><i class="bi bi-check-all text-success me-2"></i>Database Node Connected</h4>
            <p class="text-muted mx-auto" style="max-width: 600px;">All dashboard metrics are updating live via active MySQL port channels. Select a module from the navbar above to run operations.</p>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>