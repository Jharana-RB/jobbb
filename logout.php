<?php
session_start();

// Save role before destroying session
$role = $_SESSION['role'] ?? null;

// Destroy all session data
session_unset();
session_destroy();

// Redirect based on role
if ($role === 'employer') {
    header("Location: login.php"); // Employer goes to login page
} else {
    header("Location: home.php"); // Jobseeker or guest goes to home
}
exit();
?>
