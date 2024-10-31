<?php
require_once "../model/class_model.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new class_model();
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $status = "Active";
    $role = "Administrator"; 

    
    $get_admin = $conn->login($username, $password, $status, $role);
    
    if ($get_admin['count'] > 0) {
        session_start();

        // Secure the session by regenerating the session ID
        session_regenerate_id(true);

        // Store user data in session
        $_SESSION['user_id'] = $get_admin['user_id'];
        $_SESSION['username'] = $username;  // Optionally store username
        $_SESSION['role'] = $role;  // Store role if needed

        // Output success
        echo 1;
    } else {
        // Output failure (login failed)
        echo 0;
    }
}
?>
