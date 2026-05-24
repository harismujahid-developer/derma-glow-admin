<?php
require_once 'connection.php';
include 'header.php';

$feedback_msg = "";

if (isset($_POST['save_prod'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);
    $cat_id = mysqli_real_escape_string($conn, $_POST['cat_id']);

    $img_file = $_FILES['p_img']['name'];
    $img_tmp = $_FILES['p_img']['tmp_name'];
    $target_folder = "uploads/" . time() . "_" . basename($img_file);

    if (move_uploaded_file($img_tmp, $target_folder)) {
        $q = "INSERT INTO `products` (`name`, `description`, `price`, `image`, `stock_quantity`, `category_id`) 
              VALUES ('$name', '$desc', '$price', '$target_folder', '$stock', '$cat_id')";
        if (mysqli_query($conn, $q)) {
            $feedback_msg = "<div class='alert alert-success p-2 small'>Product Added!</div>";
        }
    } else {
        $feedback_msg = "<div class='alert alert-danger p-2 small'>Image file upload failed. Check the uploads/ directory.</div>";
    }
}

if (isset($_GET['del'])) {
    $id = intval($_GET['del']);
    mysqli_query($conn, "DELETE FROM `products` WHERE id=$id");
    echo "<script>window.location.href='products.php';</script>";
    exit();
}
?>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card p-3 border-0 shadow-sm bg-white">
            <h5 class="fw-bold mb-3">Add Skincare Product</h5>
            <?php echo $feedback_msg; ?>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-2"><label class="form-label small fw-bold">Name</label><input type="text" name="name" class="form-control form-control-sm" required /></div>
                <div class="mb-2">
                    <label class="form-label small fw-bold">Category</label>
                    <select name="cat_id" class="form-select form-select-sm" required>
                        <?php
                        $cats = mysqli_query($conn, "SELECT * FROM `categories`");
                        while($c = mysqli_fetch_assoc($cats)) echo "<option value='{$c['id']}'>{$c['name']}</option>";
                        ?>
                    </select>
                </div>
                <div class="mb-2"><label class="form-label small fw-bold">Price (PKR)</label><input type="number" step="0.01" name="price" class="form-control form-control-sm" required /></div>
                <div class="mb-2"><label class="form-label small fw-bold">Stock Quantity</label><input type="number" name="stock" class="form-control form-control-sm" required /></div>
                <div class="mb-2"><label class="form-label small fw-bold">Image</label><input type="file" name="p_img" class="form-control form-control-sm" required /></div>
                <div class="mb-3"><label class="form-label small fw-bold">Description</label><textarea name="description" class="form-control form-control-sm" rows="2"></textarea></div>
                <button type="submit" name="save_prod" class="btn btn-info text-white btn-sm w-100 fw-bold">Publish Item</button>
            </form>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card p-3 border-0 shadow-sm bg-white">
            <h5 class="fw-bold mb-3">Product Stock Matrix</h5>
            <table class="table table-hover align-middle small">
                <thead>
                    <tr><th>Image</th><th>Product</th><th>Price</th><th>Stock Status</th><th>Action</th></tr>
                </thead>
                <tbody>
                    <?php
                    $prods = mysqli_query($conn, "SELECT * FROM `products` ORDER BY id DESC");
                    while ($p = mysqli_fetch_assoc($prods)) {
                        $stock_num = $p['stock_quantity'];
                        $badge = ($stock_num <= 5) ? "<span class='badge bg-danger'>Low Stock: $stock_num left</span>" : "<span class='badge bg-success'>In Stock: $stock_num</span>";
                        echo "<tr>
                            <td><img src='{$p['image']}' width='40' height='40' class='rounded border' style='object-fit:cover;' /></td>
                            <td class='fw-bold'>{$p['name']}</td>
                            <td>PKR {$p['price']}</td>
                            <td>$badge</td>
                            <td><a href='products.php?del={$p['id']}' class='btn btn-link link-danger p-0' onclick='return confirm(\"Permanently delete this product?\");'><i class='bi bi-x-circle-fill fs-5'></i></a></td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>