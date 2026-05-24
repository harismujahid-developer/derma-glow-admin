<?php
require_once 'connection.php';
include 'header.php';

$feedback_msg = "";

if (isset($_POST['save_cat'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);

    if (!empty($name)) {
        $q = "INSERT INTO `categories` (`name`, `description`) VALUES ('$name', '$desc')";
        if (mysqli_query($conn, $q)) {
            $feedback_msg = "<div class='alert alert-success p-2 small'>Category stored!</div>";
        }
    }
}

if (isset($_GET['del'])) {
    $id = intval($_GET['del']);
    if (mysqli_query($conn, "DELETE FROM `categories` WHERE id=$id")) {
        echo "<script>window.location.href='categories.php';</script>";
        exit();
    }
}
?>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card p-3 border-0 shadow-sm bg-white">
            <h5 class="fw-bold mb-3">Add Skin Category</h5>
            <?php echo $feedback_msg; ?>
            <form action="" method="post">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Category Name</label>
                    <input type="text" name="name" class="form-control form-control-sm" required placeholder="e.g., Toners" />
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Description</label>
                    <textarea name="description" class="form-control form-control-sm" rows="3"></textarea>
                </div>
                <button type="submit" name="save_cat" class="btn btn-dark btn-sm w-100">Add Category</button>
            </form>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card p-3 border-0 shadow-sm bg-white">
            <h5 class="fw-bold mb-3">Existing Categories</h5>
            <table class="table align-middle">
                <thead>
                    <tr><th>ID</th><th>Name</th><th>Description</th><th>Action</th></tr>
                </thead>
                <tbody>
                    <?php
                    $res = mysqli_query($conn, "SELECT * FROM `categories` ORDER BY id DESC");
                    while ($r = mysqli_fetch_assoc($res)) {
                        echo "<tr>
                            <td>{$r['id']}</td>
                            <td class='fw-bold'>{$r['name']}</td>
                            <td>{$r['description']}</td>
                            <td>
                                <a href='categories.php?del={$r['id']}' class='btn btn-outline-danger btn-sm' onclick='return confirm(\"Delete category completely?\");'><i class='bi bi-trash'></i></a>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>