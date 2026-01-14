<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "dp.php";

$message = '';
$role = 'jobseeker'; // default

if(isset($_POST['register'])){
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'jobseeker';

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows > 0){
        $message = "❌ Email already registered!";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

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
<title>Signup</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    * {margin:0;padding:0;box-sizing:border-box;}
    body {
        font-family: 'Arial', sans-serif;
        background: linear-gradient(to right, #60a5fa, #2563eb);
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
        margin-bottom: 20px;
    }

    .role-select {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }

    .role-select button {
        flex:1;
        padding: 10px 0;
        border: none;
        cursor: pointer;
        font-size: 16px;
        font-weight: 600;
        transition: 0.3s;
        border-radius: 8px 8px 0 0;
        background: #e0f2fe;
        color: #2563eb;
        margin:0 5px;
    }

    .role-select button.active {
        background: #2563eb;
        color: #fff;
    }

    .signup-box input {
        width: 100%;
        padding: 12px 15px;
        margin: 10px 0;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 16px;
    }

    .signup-box button.submit-btn {
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

    .signup-box button.submit-btn:hover {
        background: #1e40af;
    }

    .login-link {
        margin-top: 15px;
        font-size: 14px;
        color: #2563eb;
    }

    .login-link a {
        color: #2563eb;
        text-decoration:none;
        font-weight:600;
    }

    .login-link a:hover {
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
        .role-select button {font-size:14px;}
    }
</style>
</head>
<body>

<div class="signup-box">
    <h2>Signup</h2>

    <?php if($message) echo "<div class='message'>$message</div>"; ?>

    <div class="role-select">
        <button type="button" class="active" id="jobseeker-btn">Jobseeker</button>
        <button type="button" id="employer-btn">Employer</button>
    </div>

    <form method="POST" id="signup-form">
        <input type="hidden" name="role" id="role" value="jobseeker">
        <input type="text" name="name" placeholder="Full Name / Company Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button class="submit-btn" name="register"><i class="fa-solid fa-user-plus"></i> Register</button>
    </form>

    <div class="login-link">
        Already have an account? <a href="login.php">Login here</a>
    </div>
</div>

<script>
    const jobBtn = document.getElementById('jobseeker-btn');
    const empBtn = document.getElementById('employer-btn');
    const roleInput = document.getElementById('role');

    jobBtn.addEventListener('click', () => {
        roleInput.value = 'jobseeker';
        jobBtn.classList.add('active');
        empBtn.classList.remove('active');
    });

    empBtn.addEventListener('click', () => {
        roleInput.value = 'employer';
        empBtn.classList.add('active');
        jobBtn.classList.remove('active');
    });
</script>

</body>
</html>
