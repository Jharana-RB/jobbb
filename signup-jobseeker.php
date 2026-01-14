<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "dp.php";

$message = '';

if(isset($_POST['register'])){
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows > 0){
        $message = "❌ Email already registered!";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $role = "jobseeker";

        $stmt = $conn->prepare("INSERT INTO users(name,email,password,role) VALUES (?,?,?,?)");
        $stmt->bind_param("ssss", $name, $email, $hashedPassword, $role);

        if($stmt->execute()){
            header("Location: login.php");
            exit();
        } else {
            $message = "❌ Registration failed: " . $stmt->error;
        }
        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Jobseeker Signup</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    * {margin:0;padding:0;box-sizing:border-box;}
    body {
        font-family: 'Arial', sans-serif;
        background: linear-gradient(to right, #2563eb, #60a5fa);
        height: 100vh;
        display:flex;
        justify-content:center;
        align-items:center;
    }

    .signup-box {
        background: #fff;
        padding: 40px 30px;
        border-radius: 12px;
        width: 400px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        text-align: center;
        animation: fadeInUp 0.7s ease;
    }

    .signup-box h2 {
        color: #2563eb;
        margin-bottom: 25px;
    }

    .signup-box input {
        width: 100%;
        padding: 12px 15px;
        margin: 10px 0;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 16px;
    }

    .signup-box button {
        width: 100%;
        padding: 12px;
        background: #2563eb;
        color: #fff;
        border:none;
        border-radius: 8px;
        font-size: 18px;
        cursor:pointer;
        margin-top: 15px;
        transition: 0.3s;
    }

    .signup-box button:hover {
        background: #1e40af;
    }

    .signup-box .login-link {
        margin-top: 15px;
        font-size: 14px;
        color: #2563eb;
    }

    .signup-box .login-link a {
        color: #2563eb;
        text-decoration:none;
        font-weight:600;
    }

    .signup-box .login-link a:hover {
        text-decoration: underline;
    }

    .message {
        color:red;
        margin-bottom: 10px;
        font-weight:600;
    }

    @keyframes fadeInUp {
        from {opacity:0; transform:translateY(20px);}
        to {opacity:1; transform:translateY(0);}
    }

    @media(max-width:480px){
        .signup-box {
            width: 90%;
            padding:30px 20px;
        }
    }
</style>
</head>
<body>

<div class="signup-box">
    <h2>Jobseeker Signup</h2>

    <?php if($message) echo "<div class='message'>$message</div>"; ?>

    <form method="POST">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button name="register"><i class="fa-solid fa-user-plus"></i> Register</button>
    </form>

    <div class="login-link">
        Already have an account? <a href="login.php">Login here</a>
    </div>
</div>

</body>
</html>
