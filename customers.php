<?php
require_once 'connection.php';
include 'header.php';
?>

<div class="card p-3 border-0 shadow-sm bg-white">
    <h5 class="fw-bold mb-3">Customer Directory Metrics</h5>
    <table class="table table-striped align-middle small">
        <thead>
            <tr><th>Customer ID</th><th>Full Name</th><th>Email Context</th><th>Contact Number</th><th>City Location</th></tr>
        </thead>
        <tbody>
            <?php
            $res = mysqli_query($conn, "SELECT * FROM `customers` ORDER BY name ASC");
            while ($row = mysqli_fetch_assoc($res)) {
                echo "<tr>
                    <td>#{$row['id']}</td>
                    <td class='fw-bold'>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['phone']}</td>
                    <td><span class='badge bg-light text-dark border'>{$row['city']}</span></td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>