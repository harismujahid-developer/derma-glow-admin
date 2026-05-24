<?php
require_once 'connection.php';
include 'header.php';

if (isset($_POST['update_status'])) {
    $o_id = intval($_POST['order_id']);
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);
    mysqli_query($conn, "UPDATE `orders` SET `status`='$new_status' WHERE id=$o_id");
}
?>

<div class="card p-3 border-0 shadow-sm bg-white">
    <h5 class="fw-bold mb-3">Order Management Queue</h5>
    <table class="table align-middle text-center small">
        <thead>
            <tr><th>Order ID</th><th>Customer Name</th><th>Date</th><th>Amount</th><th>Status Badge</th><th>Change Status</th></tr>
        </thead>
        <tbody>
            <?php
            $res = mysqli_query($conn, "SELECT * FROM `orders` ORDER BY id DESC");
            while ($row = mysqli_fetch_assoc($res)) {
                echo "<tr>
                    <td>#{$row['id']}</td>
                    <td class='fw-bold'>{$row['customer_name']}</td>
                    <td>{$row['order_date']}</td>
                    <td class='text-success fw-bold'>PKR {$row['total_amount']}</td>
                    <td><span class='badge bg-secondary'>{$row['status']}</span></td>
                    <td>
                        <form action='' method='post' class='d-flex justify-content-center gap-1'>
                            <input type='hidden' name='order_id' value='{$row['id']}' />
                            <select name='status' class='form-select form-select-sm' style='width:120px;'>
                                <option value='pending'>Pending</option>
                                <option value='processing'>Processing</option>
                                <option value='shipped'>Shipped</option>
                                <option value='delivered'>Delivered</option>
                            </select>
                            <button type='submit' name='update_status' class='btn btn-dark btn-sm p-1'><i class='bi bi-check'></i></button>
                        </form>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>