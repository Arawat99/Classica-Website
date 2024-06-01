<?php
session_start();
include 'config.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare statement for admin query
    $admin_stmt = $conn->prepare("SELECT * FROM admindb WHERE username = ?");
    $admin_stmt->bind_param("s", $username);
    $admin_stmt->execute();
    $admin_result = $admin_stmt->get_result();
    
    if ($admin_result && $admin_result->num_rows > 0) {
        $admin = $admin_result->fetch_assoc();
        if ($password === $admin['password']) {
            $_SESSION['admin_id'] = $admin['id'];
            header("Location: admin.php");
            exit();
        } else {
            header("Location: login.php?status=error&msg=Admin password incorrect");
            exit();
        }
    }
    
    // Prepare statement for user query
    $user_stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $user_stmt->bind_param("s", $username);
    $user_stmt->execute();
    $user_result = $user_stmt->get_result();
    
    if ($user_result && $user_result->num_rows > 0) {
        $user = $user_result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: products.php");
            exit();
        } else {
            header("Location: login.php?status=error&msg=User password incorrect");
            exit();
        }
    }

    header("Location: login.php?status=error&msg=Username or Password Incorrect");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classica - Login Form</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/lr.css">
    <link rel="stylesheet" href="css/common.css">
    <script src="bootstrap/js/jquery.min.js"></script>
</head>
<body class="login_body">
    <?php include 'form_header.php'; ?>
<div class="panel-body">
    <?php if (isset($_GET['status'])): ?>
        <div class="alert <?php echo $_GET['status'] == 'success' ? 'alert-success' : 'alert-danger'; ?>">
            <?php echo htmlspecialchars($_GET['msg']); ?>
        </div>
    <?php endif; ?>
    <form method="post" action="">
        <div class="form-group input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="glyphicon glyphicon-user"></i></span>
            </div>
            <img src="uploaded_img/username_icon.png" alt="username logo" class="icon">
            <input type="text" class="form-control" name="username" placeholder="Username" required>
        </div>
        <div class="form-group input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="glyphicon glyphicon-lock"></i></span>
            </div>
            <img src="uploaded_img/password_icon.png" alt="password logo" class="icon">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
        </div>
        <div class="form-group">
            <button type="submit" name="login" class="btn btn-primary btn-block" id="register">Login</button>
        </div>
        <div class="form-group text-center">
            <a href="signup.php">Click here to Sign up</a>
        </div>
    </form>
</div>

<footer>
    <div class="container text-center">
            <p>&copy; 2024 Classica Apparel. All Rights Reserved.</p>
        </div></footer>

<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
