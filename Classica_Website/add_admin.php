<?php
include 'config.php';

// Admin credentials
$admin_username = 'Admin'; 
$admin_password = 'admin123'; 
// Hash the admin password
$hashed_password = password_hash($admin_password, PASSWORD_BCRYPT);

// Insert the admin into the database
$sql = "INSERT INTO admindb (username, password) VALUES ('$admin_username', '$hashed_password')";
if (mysqli_query($conn, $sql)) {
    echo "Admin added successfully.";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
