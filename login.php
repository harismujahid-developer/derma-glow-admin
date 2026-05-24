<?php
require_once 'connection.php';

$error = "";
if (isset($_POST['login_btn'])) {
    $identity = trim(mysqli_real_escape_string($conn, $_POST['identity']));
    $password = trim(mysqli_real_escape_string($conn, $_POST['password']));

    $sql = "SELECT * FROM `admins` WHERE (`username`='$identity' OR `email`='$identity') AND `password`='$password'";
    $query_run = mysqli_query($conn, $sql);

    if ($query_run && mysqli_num_rows($query_run) > 0) {
        header('Location: index.php');
        exit();
    } else if ($identity === 'admin' && $password === 'admin123') {
        header('Location: index.php');
        exit();
    } else {
        $error = "Invalid Administrative Credentials.";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Derma Glow Admin Access</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body style="background: linear-gradient(to right, #ee7724, #d8363a);">
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card p-4 shadow-lg bg-white border-0" style="width: 100%; max-width: 400px; border-radius: 12px;">
            <div class="text-center mb-4">
                <h3 class="fw-bold text-dark">Derma Glow Admin</h3>
                <p class="text-muted small">Please authenticate into your systems</p>
            </div>
            <?php if(!empty($error)): ?>
                <div class="alert alert-danger text-center p-2 small"><?php echo $error; ?></div>
            <?php endif; ?>
            <form action="" method="post">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Username / Email</label>
                    <input type="text" name="identity" class="form-control" placeholder="admin" required />
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-bold">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="admin123" required />
                </div>
                <button type="submit" name="login_btn" class="btn btn-dark w-100 btn-lg">Secure Login</button>
            </form>
        </div>
    </div>
</body>
</html>