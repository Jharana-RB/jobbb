<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

$conn = new mysqli("localhost","root","","kaamsathi_db");
if ($conn->connect_error) {
  die("Database connection failed");
}

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
  $user = $result->fetch_assoc();

  if (password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];

    if ($user['role'] === 'jobseeker') {
      header("Location: job.php");
    } else {
      header("Location: employer.php");
    }
    exit();
  } else {
    echo "❌ Wrong password";
  }
} else {
  echo "❌ User not found";
}
