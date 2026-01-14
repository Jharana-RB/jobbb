<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Jobs | KaamSathi</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
 /*GLOBAL LAYOUT & RESET*/
html, body {
    height: 100%;
}

body {
    display: flex;
    flex-direction: column;
    font-family: 'Arial', sans-serif;
    background: #f4f4f4;
    transition: 0.3s;
}

.main-content {
    flex: 1; /* Pushes footer to bottom */
}

/* Reset default spacing */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}


/* HEADER & NAVIGATION BAR*/
header {
    background: white;
    color: #60a5fa;
    padding: 12px 25px;
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

header .container {
    max-width: 1300px;
    margin: auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Logo */
.logo a {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: #60a5fa;
    font-size: 28px;
    font-weight: 700;
}

.logo img {
    height: 40px;
    margin-right: 8px;
}

/* Navigation Menu */
nav ul {
    list-style: none;
    display: flex;
    align-items: center;
    gap: 15px;
}

nav ul li {
    position: relative;
}

nav ul li a {
    text-decoration: none;
    color: #60a5fa;
    padding: 10px 18px;
    font-weight: 500;
    border-radius: 5px;
    transition: 0.3s;
}

nav ul li a:hover {
    background: #2563eb;
    color: #fff;
}

/* Dropdown Menu */
.dropdown-menu {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    background: white;
    min-width: 220px;
    border-radius: 5px;
    overflow: hidden;
    box-shadow: 0 5px 12px rgba(0,0,0,0.15);
}

.dropdown:hover .dropdown-menu {
    display: block;
}

.dropdown-menu li a {
    padding: 10px 15px;
}

/* Buttons */
.btn {
    padding: 10px 22px;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
}

.login-btn {
    background: #2563eb;
    color: #fff;
}

.login-btn:hover {
    background: #1e40af;
}

.signup-btn {
    background: #fff;
    color: #2563eb;
}

.signup-btn:hover {
    background: #e0f2fe;
}

/* Hamburger Menu */
.hamburger {
    display: none;
    font-size: 26px;
    cursor: pointer;
    color: #2563eb;
}


/* RESPONSIVE NAVIGATION (MOBILE)*/
@media (max-width: 992px) {

    nav ul {
        position: fixed;
        top: 0;
        left: -100%;
        width: 260px;
        height: 100%;
        flex-direction: column;
        padding-top: 70px;
        background: #60a5fa;
        transition: 0.3s;
    }

    nav ul.show {
        left: 0;
    }

    nav ul li a {
        padding: 15px 20px;
    }

    .dropdown-menu {
        position: static;
        display: none;
    }

    .dropdown.active .dropdown-menu {
        display: block;
    }

    .hamburger {
        display: block;
    }

    .login-btn,
    .signup-btn {
        width: 90%;
        margin: 5px 20px;
    }
}


/*JOB LISTING SECTION*/
.container {
    max-width: 1000px;
    margin: 50px auto;
    padding: 0 20px;
}

h2 {
    text-align: center;
    font-size: 2.2rem;
    color: #2563eb;
    margin-bottom: 40px;
    position: relative;
}

h2::after {
    content: '';
    width: 60px;
    height: 4px;
    background: #60a5fa;
    display: block;
    margin: 8px auto 0;
    border-radius: 2px;
}

/* Job Card */
.job-card {
    background: #fff;
    padding: 25px 20px;
    margin-bottom: 20px;
    border-left: 6px solid #2563eb;
    border-radius: 12px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.08);
    transition: 0.3s ease;
}

.job-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 25px rgba(0,0,0,0.12);
}

.job-card h3 {
    color: #1e40af;
    font-size: 1.5rem;
    margin-bottom: 10px;
}

.job-card p {
    margin: 6px 0;
    line-height: 1.6;
}

.job-card b {
    color: #2563eb;
}


/* REQUIREMENTS TOGGLE */
.show-req-btn {
    margin-top: 15px;
    padding: 10px 16px;
    background: #2563eb;
    color: white;
    border-radius: 20px;
    border: none;
    cursor: pointer;
    transition: 0.3s;
}

.show-req-btn:hover {
    background: #60a5fa;
}

.requirements {
    max-height: 0;
    overflow: hidden;
    background: #e3f2fd;
    margin: 10px 0;
    padding: 0 12px;
    border-radius: 8px;
    transition: 0.4s ease;
}

.requirements.open {
    max-height: 500px;
    padding: 12px;
}


/* APPLY BUTTON*/
.apply-btn {
    margin-top: 10px;
    padding: 10px 20px;
    background: #28a745;
    color: #fff;
    border-radius: 30px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: 0.3s;
    box-shadow: 0 5px 15px rgba(40,167,69,0.25);
}

.apply-btn:hover {
    background: #5cd65c;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(40,167,69,0.35);
}

/* FOOTER*/
.social-icons {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

footer {
    background: #111827;
    color: #fff;
    padding: 2rem;
}

.footer-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2rem;
}

.footer-col h3 {
    margin-bottom: 1rem;
    color: #2563eb;
}

.footer-col a,
.footer-col p {
    color: #d1d5db;
    text-decoration: none;
    margin-bottom: 0.5rem;
}

.footer-col a:hover,
.footer-col p:hover {
    color: #2563eb;
}

.footer-credit {
    text-align: center;
    margin-top: 2rem;
    font-size: 0.9rem;
    color: #9ca3af;
}

</style>
</head>
<body>

<header>
  <div class="container">
    <div class="logo">
      <a href="home.php"><img src="assets/logo.png" alt="Logo"></a>
    </div>
    <nav>
      <ul class="nav-links">
        <li><a href="home.php">Home</a></li>
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

    <!-- Replace your old buttons with this PHP code -->
    <div style="display:flex; gap:10px;">
      <?php if(!isset($_SESSION['role'])): ?>
          <button class="btn login-btn" onclick="window.location.href='login.php'">Login</button>
          <button class="btn signup-btn" onclick="window.location.href='signup.php'">Signup</button>
      <?php else: ?>
          <span style="color:#2563eb; font-weight:600; display:flex; align-items:center;">
            Hello, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?>!
          </span>
          <button class="btn login-btn" onclick="window.location.href='logout.php'">Logout</button>
      <?php endif; ?>
    </div>

    <div class="hamburger"><i class="fa-solid fa-bars"></i></div>
  </div>
</header>
 

<main class="main-content">
  <div class="container">
    <h2>Available Jobs</h2>
    <div id="jobContainer"></div>
  </div>
</main>


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
// Hamburger toggle
const hamburger = document.querySelector(".hamburger");
const navLinks = document.querySelector(".nav-links");
hamburger.addEventListener("click", () => navLinks.classList.toggle("show"));

// Load jobs from localStorage
const jobContainer = document.getElementById("jobContainer");
const jobs = JSON.parse(localStorage.getItem("jobs")) || [];
const jobRequests = JSON.parse(localStorage.getItem("jobRequests")) || [];

if(jobs.length === 0){
  jobContainer.innerHTML = "<p style='text-align:center; color:#6b7280;'>No jobs available at the moment.</p>";
}

jobs.forEach(job => {
  const card = document.createElement('div');
  card.className = 'job-card';
  card.innerHTML = `
    <h3>${job.title}</h3>
    <p><b>📍 Location:</b> ${job.location}</p>
    <p><b>💰 Salary:</b> ${job.salary}</p>
    <p>${job.description}</p>
    <button class="show-req-btn">Show Requirements ▼</button>
    <div class="requirements">${job.requirements || "No specific requirements."}</div>
    <button class="apply-btn">Apply</button>
  `;
  jobContainer.appendChild(card);

  // Toggle requirements
  const reqBtn = card.querySelector('.show-req-btn');
  const reqDiv = card.querySelector('.requirements');
  reqBtn.addEventListener('click', () => {
    reqDiv.classList.toggle('open');
    reqBtn.textContent = reqDiv.classList.contains('open') ? "Hide Requirements ▲" : "Show Requirements ▼";
  });

  // Apply button
  const applyBtn = card.querySelector('.apply-btn');
  applyBtn.addEventListener('click', () => {
    const role = '<?php echo $_SESSION["role"] ?? ""; ?>';
    if(role !== "jobseeker"){
        alert("Please login as a Job Seeker to apply!");
        window.location.href = "login.php";
        return;
    }
    const userName = prompt("Enter your name:");
    const userEmail = prompt("Enter your email:");
    const message = prompt("Any message?") || "";
    if(userName && userEmail){
        jobRequests.push({
            jobTitle: job.title,
            userName: userName,
            userEmail: userEmail,
            message: message
        });
        localStorage.setItem("jobRequests", JSON.stringify(jobRequests));
        alert("Applied successfully!");
    } else {
        alert("Name and Email are required!");
    }
  });
});
</script>
</body>
</html>