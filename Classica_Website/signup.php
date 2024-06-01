<?php
include 'config.php';

if (isset($_POST['register'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $profile = "default.jpg";

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO user (firstname, lastname, username, email, password, profile) VALUES (?, ?, ?, ?, ?, ?)");
    
    if ($stmt === false) {
        // Output the error message
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    // Bind parameters
    $stmt->bind_param("ssssss", $firstname, $lastname, $username, $email, $password, $profile);

    // Execute the statement
    if ($stmt->execute()) {
        header('Location: signup.php?status=success&msg=Successfully Registered');
    } else {
        header('Location: signup.php?status=error&msg=Registration Failed');
    }
    
    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classica - Registration Form</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/lr.css">
    <link rel="stylesheet" href="css/common.css">
    <script src="bootstrap/js/jquery.min.js"></script>
</head>
<body>
<?php include 'form_header.php'; ?>

                <div class="panel-body">
                    <?php if (isset($_GET['status'])): ?>
                        <div class="alert <?php echo $_GET['status'] == 'success' ? 'alert-success' : 'alert-danger'; ?>">
                            <?php echo htmlspecialchars($_GET['msg']); ?>
                        </div>
                    <?php endif; ?>
                    <form method="post" action="">
                        <div class="form-group">
                            <label for="firstname" class="text">First Name:</label>
                            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter your First Name" required>
                        </div>
                        <div class="form-group">
                            <label for="lastname" class="text">Last Name:</label>
                            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter your Last Name" required>
                        </div>
                        <div class="form-group">
                            <label for="username" class="text">User Name:</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter your User Name" required>
                        </div>
                        <div class="form-group">
                            <label for="email" class="text">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your Email" required>
                        </div>
                        <div class="form-group">
                            <label for="password" class="text">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your Password" minlength="6" required>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="terms" required>
                            <label class="form-check-label" for="terms">I agree to the <a href="termsNcondition.php" target="_blank">Terms and Conditions</a> and privacy policy</label>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Sign up" class="btn btn-primary" id="register" name="register">
                        </div>
                            <label><a href="login.php" id="account">Already have an account</a></label>
                    </form>
                </div>
            
<script src="bootstrap/js/bootstrap.min.js"></script>
<footer>
    <div class="container text-center">
            <p>&copy; 2024 Classica Apparel. All Rights Reserved.</p>
        </div></footer>
</body>
</html>
