<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "dp.php";

$message = '';

if(isset($_POST['login'])){
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 1){
        $user = $result->fetch_assoc();
        if(password_verify($password, $user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            if($user['role'] === 'jobseeker'){
                header("Location: job.php");
            } else {
                header("Location: employer.php");
            }
            exit();
        } else {
            $message = "❌ Incorrect password!";
        }
    } else {
        $message = "❌ Email not registered!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    * {margin:0; padding:0; box-sizing:border-box;}
    body {
        font-family: 'Arial', sans-serif;
        background: linear-gradient(to right, #60a5fa, #2563eb);
        height: 100vh;
        display:flex;
        justify-content:center;
        align-items:center;
    }

    .login-box {
        background: #fff;
        padding: 40px 30px;
        border-radius: 12px;
        width: 400px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        text-align: center;
        animation: fadeInUp 0.7s ease;
    }

    .login-box h2 {
        color: #2563eb;
        margin-bottom: 25px;
    }

    .login-box input {
        width: 100%;
        padding: 12px 15px;
        margin: 10px 0;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 16px;
    }

    .login-box button {
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

    .login-box button:hover {
        background: #1e40af;
    }

    .signup-link {
        margin-top: 15px;
        font-size: 14px;
        color: #2563eb;
    }

    .signup-link a {
        color: #2563eb;
        text-decoration:none;
        font-weight:600;
    }

    .signup-link a:hover {
        text-decoration: underline;
    }

    .message {
        color:red;
        margin-bottom: 10px;
        font-weight:600;
    }

    .forgot-link {
        font-size: 0.9rem;
        color: #2563eb;
        text-decoration: none;
        transition: 0.3s;
    }

    .forgot-link:hover {
        text-decoration: underline;
        color: #1e40af;
    }

    @keyframes fadeInUp {
        from {opacity:0; transform:translateY(20px);}
        to {opacity:1; transform:translateY(0);}
    }

    @media(max-width:480px){
        .login-box {
            width: 90%;
            padding:30px 20px;
        }
    }
</style>
</head>
<body>

<div class="login-box">
    <h2>Login</h2>

    <?php if($message) echo "<div class='message'>$message</div>"; ?>


    <form action="login.php" method="POST">
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>

        <button name="login"><i class="fa-solid fa-right-to-bracket"></i> Login</button>
    </form>

    <div class="signup-link">
        Don't have an account? <a href="signup.php">Sign up here</a>
    </div>
</div>

</body>
</html>
