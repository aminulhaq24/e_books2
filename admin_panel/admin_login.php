<?php
session_start();

include('includes/nav.php');
include('includes/connection.php');

// If already logged in
if(isset($_SESSION['admin_logged_in'])){
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">

            <div class="card shadow">
                <div class="card-header text-center">
                    <h4>Admin / Dealer Login</h4>
                </div>

                <div class="card-body">

                    <form action="admin_login_process.php" method="POST">
                        <div class="mb-3">
                            <label>Email:</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Password:</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <button class="btn btn-primary w-100">Login</button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>

<?php
include('includes/footer');

?>