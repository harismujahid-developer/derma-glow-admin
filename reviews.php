<?php
require_once 'connection.php';
include 'header.php';

if (isset($_GET['del'])) {
    $id = intval($_GET['del']);
    mysqli_query($conn, "DELETE FROM `reviews` WHERE id=$id");
    echo "<script>window.location.href='reviews.php';</script>";
    exit();
}
?>

<div class="card p-3 border-0 shadow-sm bg-white">
    <h5 class="fw-bold mb-3">Product Reviews Moderation Board</h5>
    <table class="table align-middle small">
        <thead>
            <tr><th>User</th><th>Target Product</th><th>Review Narrative</th><th>Action</th></tr>
        </thead>
        <tbody>
            <?php
            $res = mysqli_query($conn, "SELECT * FROM `reviews` ORDER BY id DESC");
            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    echo "<tr>
                        <td class='fw-bold text-secondary'>{$row['customer_name']}</td>
                        <td><span class='badge bg-info text-white'>{$row['product_name']}</span></td>
                        <td class='text-muted'>\"{$row['comment']}\"</td>
                        <td>
                            <a href='reviews.php?del={$row['id']}' class='btn btn-sm btn-outline-danger' onclick='return confirm(\"Permanently drop this feedback link?\");'><i class='bi bi-trash3'></i> Purge Review</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='text-center text-muted py-3'>No customer feedback logged yet.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>