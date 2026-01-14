<?php
// Include database connection
include 'db.php'; // make sure db.php has InfinityFree credentials

// Start session if not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Logout handling
if(isset($_GET['logout'])){
    session_destroy();
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>KaamSathi - Home</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
/* GLOBAL RESET */
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:Arial,sans-serif;background:#f4f4f4;transition:.3s}

/* HEADER */
header{background:#fff;color:#60a5fa;padding:12px 25px;position:sticky;top:0;z-index:1000;box-shadow:0 2px 5px rgba(0,0,0,0.1)}
.container{max-width:1300px;margin:auto;display:flex;justify-content:space-between;align-items:center}

/* LOGO */
.logo a{display:flex;align-items:center;color:#60a5fa;text-decoration:none;font-size:28px;font-weight:700}
.logo img{height:40px;margin-right:8px}

/* NAVIGATION */
nav ul{list-style:none;display:flex;align-items:center;gap:15px}
nav ul li{position:relative}
nav ul li a{display:block;padding:10px 18px;text-decoration:none;color:#60a5fa;font-weight:500;border-radius:5px;transition:.3s}
nav ul li a:hover{background:#2563eb;color:#fff}

/* Dropdown Menu */
.dropdown-menu{display:none;position:absolute;top:100%;left:0;background:#fff;min-width:220px;border-radius:5px;box-shadow:0 5px 12px rgba(0,0,0,0.15)}
.dropdown-menu li a{padding:10px 15px}
.dropdown:hover .dropdown-menu{display:block}

/* Buttons */
.btn{padding:10px 22px;border:none;border-radius:6px;font-weight:600;cursor:pointer}
.login-btn{background:#2563eb;color:#fff}
.login-btn:hover{background:#1e40af}
.signup-btn{background:#fff;color:#2563eb}
.signup-btn:hover{background:#e0f2fe}

/* Mobile Menu */
.hamburger{display:none;font-size:26px;color:#2563eb;cursor:pointer}

/* HERO */
.hero-section{background:linear-gradient(rgba(37,99,235,0.8),rgba(30,64,175,0.8)),url("https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1600&q=80");background-size:cover;background-position:center;color:#fff;text-align:center;padding:140px 20px}
.hero-content{max-width:700px;margin:auto}
.hero-content h1{font-size:3rem;margin-bottom:1rem}
.hero-content p{font-size:1.2rem;margin-bottom:2rem}
.hero-btn{background:#fff;color:#2563eb;padding:.9rem 2.2rem;border-radius:30px;text-decoration:none;font-weight:600}
.hero-btn:hover{background:#60a5fa;color:#fff}

/* ABOUT SECTION */
.about-section{padding:90px 20px;background:#f9fafb;text-align:center}
.section-title{font-size:2.2rem;color:#2563eb;margin-bottom:1rem}
.section-subtitle{max-width:700px;margin:auto auto 3rem;color:#4b5563}
.about-cards{display:flex;gap:2rem;justify-content:center;flex-wrap:wrap}
.about-card{width:300px;padding:2.5rem 1.5rem;background:#fff;border-radius:16px;border-top:5px solid #2563eb;box-shadow:0 8px 20px rgba(0,0,0,0.08)}
.about-card:hover{transform:translateY(-8px)}
.about-icon{font-size:3rem;color:#2563eb;margin-bottom:1rem}
.user-img{width:90px;height:90px;border-radius:50%;object-fit:cover;border:3px solid #60a5fa;margin-bottom:1rem}

/* FOOTER */
.social-icons{display:flex;flex-direction:column;gap:5px}
footer{background:#111827;color:#fff;padding:2rem}
.footer-container{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:2rem}
.footer-col h3{margin-bottom:1rem;color:#2563eb}
.footer-col a,.footer-col p{color:#d1d5db;text-decoration:none;margin-bottom:.5rem}
.footer-col a:hover,.footer-col p:hover{color:#2563eb}
.footer-credit{text-align:center;margin-top:2rem;font-size:.9rem;color:#9ca3af}

/* RESPONSIVE */
@media(max-width:992px){nav ul{position:fixed;top:0;left:-100%;width:260px;height:100%;flex-direction:column;padding-top:70px;background:#60a5fa}nav ul.show{left:0}.hamburger{display:block}.footer-container{grid-template-columns:repeat(2,1fr)}}
@media(max-width:768px){.hero-content h1{font-size:2rem}.footer-container{grid-template-columns:1fr;text-align:center}.footer-col{align-items:center}.social-icons{flex-direction:row;justify-content:center}}
</style>
</head>
<body>

<header>
<div class="container">
    <!-- Logo -->
    <div class="logo">
        <a href="index.php"><img src="assets/logo.png" alt="Logo"></a>
    </div>

    <!-- Navigation -->
    <nav>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="job.php">Jobs</a></li>
            <li><a href="faq.html">FAQ</a></li>
            <li><a href="ContactPage.html">Contact</a></li>
            <li class="dropdown">
                <a href="#">More <i class="fa-solid fa-chevron-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="privacy-policy.html">Privacy</a></li>
                    <li><a href="terms-of-use.html">Terms</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Login/Signup or Logout -->
    <div style="display:flex;gap:10px;">
        <?php if(!isset($_SESSION['role'])): ?>
            <button class="btn login-btn" onclick="window.location.href='login.php'">Login</button>
            <button class="btn signup-btn" onclick="window.location.href='signup.php'">Signup</button>
        <?php else: ?>
            <span style="color:#2563eb;font-weight:600;display:flex;align-items:center;">
                Hello, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?>!
            </span>
            <a href="?logout=true" class="btn signup-btn" style="background:#ff4d4d;color:#fff;">Logout</a>
        <?php endif; ?>
    </div>

    <!-- Hamburger for mobile -->
    <div class="hamburger"><i class="fa-solid fa-bars"></i></div>
</div>
</header>

<!-- HERO SECTION -->
<section class="hero-section">
<div class="hero-content">
    <h1>Discover Your Perfect Job Today</h1>
    <p>Unlock new job opportunities, connect with employers, and grow your career.</p>
    <a href="#" class="hero-btn">Get Started</a>
</div>
</section>

<!-- ABOUT SECTION -->
<section class="about-section">
<h2 class="section-title">About Us</h2>
<p class="section-subtitle">We are committed to helping professionals reach their goals by matching their skills with the right opportunities.</p>
<div class="about-cards">
    <div class="about-card">
        <i class="fas fa-bullseye about-icon"></i>
        <h3>Our Mission</h3>
        <p>To bridge the gap between job seekers and employers through innovative technology and personalized connections.</p>
    </div>
    <div class="about-card">
        <i class="fas fa-lightbulb about-icon"></i>
        <h3>Our Vision</h3>
        <p>To become the most trusted global platform where careers grow and companies find exceptional talent effortlessly.</p>
    </div>
    <div class="about-card">
        <i class="fas fa-handshake about-icon"></i>
        <h3>Our Values</h3>
        <p>We believe in integrity, transparency, and commitment to creating meaningful professional relationships.</p>
    </div>
</div>
</section>

<!-- SERVICES SECTION -->
<section class="about-section">
<h2 class="section-title">Our Services</h2>
<p class="section-subtitle">We offer guidance and resources to help you develop your skills, grow professionally, and land the right career.</p>
<div class="about-cards">
    <div class="about-card">
        <i class="fas fa-user-graduate about-icon"></i>
        <h3>Career Guidance</h3>
        <p>Hear success stories from users who achieved their career goals through our platform.</p>
    </div>
    <div class="about-card">
        <i class="fas fa-laptop-code about-icon"></i>
        <h3>Online Courses</h3>
        <p>Access quality online courses to improve your skills and knowledge.</p>
    </div>
    <div class="about-card">
        <i class="fas fa-briefcase about-icon"></i>
        <h3>Job Placement</h3>
        <p>Connect with top employers and get assistance in landing your dream job.</p>
    </div>
</div>
</section>

<!-- USERS SECTION FOR DEMO -->
<section class="about-section">
<h2 class="section-title">Registered Users</h2>
<?php
$result = mysqli_query($conn, "SELECT id, name, email, role FROM users");
if($result && mysqli_num_rows($result) > 0){
    echo "<ul>";
    while($row = mysqli_fetch_assoc($result)){
        echo "<li>" . htmlspecialchars($row['name']) . " (" . htmlspecialchars($row['role']) . ") - " . htmlspecialchars($row['email']) . "</li>";
    }
    echo "</ul>";
}else{
    echo "<p>No users found.</p>";
}
?>
</section>

<!-- FOOTER -->
<footer>
<div class="footer-container">
    <div class="footer-col">
        <h3><i class="fa-solid fa-briefcase"></i> KaamSathi</h3>
        <p>Empowering job seekers and employers to build a better future together.</p>
    </div>
    <div class="footer-col">
        <h3>Contact</h3>
        <p><i class="fa-solid fa-phone"></i> 061-550256</p>
        <p><i class="fa-solid fa-envelope"></i> kaamsathi@gmail.com</p>
    </div>
    <div class="footer-col">
        <h3>Follow Us</h3>
        <div class="social-icons">
            <a href="#"><i class="fa-brands fa-facebook"></i> Facebook</a>
            <a href="#"><i class="fa-brands fa-twitter"></i> Twitter</a>
            <a href="#"><i class="fa-brands fa-linkedin"></i> LinkedIn</a>
            <a href="#"><i class="fa-brands fa-instagram"></i> Instagram</a>
        </div>
    </div>
</div>
<div class="footer-credit">&copy; 2026 KaamSathi. All rights reserved.</div>
</footer>

<script>
const hamburger = document.querySelector(".hamburger");
const navLinks = document.querySelector(".nav-links");
hamburger.addEventListener("click", () => navLinks.classList.toggle("show"));
</script>
</body>
</html>
