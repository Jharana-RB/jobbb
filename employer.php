<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'employer'){
  header("Location: login.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Employer Dashboard | Job Portal</title>

<style>
/* ===== Global ===== */
*{margin:0;padding:0;box-sizing:border-box;font-family: 'Segoe UI', Tahoma, sans-serif;}
body{background:linear-gradient(to right,#e3f2fd,#fce4ec);}

/* ===== Header ===== */
header{background:linear-gradient(to right,#1976d2,#512da8);color:white;padding:18px 40px;font-size:22px;letter-spacing:1px;}

/* ===== Layout ===== */
.container{display:flex; min-height:100vh;}

/* ===== Sidebar ===== */
.sidebar{width:240px;background:#1c1f26;color:white;padding:25px;}
.sidebar h2{text-align:center;margin-bottom:30px;font-size:20px;}
.sidebar ul{list-style:none;}
.sidebar ul li{padding:14px;margin-bottom:12px;background:#2a2f3a;border-radius:8px;cursor:pointer;transition:0.3s;text-align:center;}
.sidebar ul li:hover{background:#1976d2;transform:translateX(5px);}

/* ===== Main ===== */
.main{flex:1;padding:40px;}

/* ===== Card ===== */
.card{background:white;padding:25px;border-radius:12px;box-shadow:0 10px 25px rgba(0,0,0,0.15);animation:fadeIn 0.5s ease-in;}

/* ===== Hide Sections ===== */
.section{display:none;}

/* ===== Form ===== */
.card h2{margin-bottom:20px;color:#1976d2;}
label{font-weight:600;margin-top:12px;display:block;}
input, textarea{width:100%;padding:12px;margin-top:6px;border-radius:8px;border:1px solid #ccc;transition:0.3s;}
input:focus, textarea:focus{outline:none;border-color:#1976d2;box-shadow:0 0 6px rgba(25,118,210,0.4);}
button{margin-top:18px;padding:12px;width:100%;border:none;border-radius:8px;background:linear-gradient(to right,#1976d2,#512da8);color:white;font-size:16px;cursor:pointer;transition:0.3s;}
button:hover{transform:scale(1.03);}

/* ===== Job Card ===== */
.job{background:#f5f7fa;padding:15px;border-radius:10px;margin-bottom:15px;border-left:5px solid #1976d2;}
.job h3{color:#512da8;margin-bottom:5px;}
.job p{color:#555;}
.job .requirements{background:#e3f2fd;padding:8px;margin-top:8px;border-radius:5px;display:none;}
.job button.apply-job{background:#28a745;color:white;margin-top:8px;}

/* ===== Footer ===== */
footer{background:#1c1f26;color:white;text-align:center;padding:12px;}

/* ===== Animation ===== */
@keyframes fadeIn{from{opacity:0; transform:translateY(10px);} to{opacity:1; transform:translateY(0);}}
</style>
</head>
<body>

<header>Employer Dashboard – Job Portal</header>

<div class="container">

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Employer Panel</h2>
        <ul>
            <li onclick="showSection('postJob')">📢 Post Job</li>
            <li onclick="showSection('myJobs')">📋 My Jobs</li>
            <li onclick="showSection('requests')">📨 Requests</li>
            <li onclick="logout()">🚪 Logout</li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main">

        <!-- Post Job -->
        <div id="postJob" class="card section">
            <h2>Post a New Job</h2>
            <form id="jobForm">
                <label>Job Title</label>
                <input type="text" id="title" required>

                <label>Location</label>
                <input type="text" id="location" required>

                <label>Salary</label>
                <input type="text" id="salary" required>

                <label>Job Requirements</label>
                <textarea id="requirements" rows="3" required placeholder="List skills, qualifications, etc."></textarea>

                <label>Job Description</label>
                <textarea id="description" rows="4" required></textarea>

                <button type="submit">Post Job</button>
            </form>
        </div>

        <!-- My Jobs -->
        <div id="myJobs" class="card section">
            <h2>My Posted Jobs</h2>
            <div id="jobList"><p>No jobs posted yet.</p></div>
        </div>

        <!-- Requests -->
        <div id="requests" class="card section">
            <h2>Job Applications</h2>
            <div id="requestsList"><p>No requests yet.</p></div>
        </div>

    </div>
</div>

<footer>&copy; 2026 KaamSathi | Employer Dashboard</footer>

<script>
const postJob = document.getElementById("postJob");
const myJobs = document.getElementById("myJobs");
const requests = document.getElementById("requests");
const jobForm = document.getElementById("jobForm");
const jobList = document.getElementById("jobList");
const requestsList = document.getElementById("requestsList");

// Show sections
function showSection(section){
    postJob.style.display = "none";
    myJobs.style.display = "none";
    requests.style.display = "none";
    document.getElementById(section).style.display = "block";
}
showSection("postJob");

// Load jobs & requests
let jobs = JSON.parse(localStorage.getItem("jobs")) || [];
let jobRequests = JSON.parse(localStorage.getItem("jobRequests")) || [];
renderJobs();
renderRequests();

// Post job
jobForm.addEventListener("submit", function(e){
    e.preventDefault();

    const job = {
        title: document.getElementById("title").value,
        location: document.getElementById("location").value,
        salary: document.getElementById("salary").value,
        description: document.getElementById("description").value,
        requirements: document.getElementById("requirements").value
    };

    jobs.push(job);
    localStorage.setItem("jobs", JSON.stringify(jobs));

    jobForm.reset();
    renderJobs();
    showSection("myJobs");
});

// Render jobs
function renderJobs(){
    jobList.innerHTML = "";
    if(jobs.length === 0){
        jobList.innerHTML = "<p>No jobs posted yet.</p>";
        return;
    }
    jobs.forEach((job, index) => {
        jobList.innerHTML += `
            <div class="job">
                <h3>${job.title}</h3>
                <p><b>📍 Location:</b> ${job.location}</p>
                <p><b>💰 Salary:</b> ${job.salary}</p>
                <p>${job.description}</p>
                <p><b>Requirements:</b> ${job.requirements}</p>
                <button onclick="deleteJob(${index})"
                        style="background:#e53935;color:white;margin-top:10px;">
                    ❌ Delete Job
                </button>
            </div>
        `;
    });
}

// Delete job
function deleteJob(index){
    if(confirm("Delete this job?")){
        jobs.splice(index, 1);
        localStorage.setItem("jobs", JSON.stringify(jobs));
        renderJobs();
    }
}

// Render requests
function renderRequests(){
    requestsList.innerHTML = "";
    if(jobRequests.length === 0){
        requestsList.innerHTML = "<p>No requests yet.</p>";
        return;
    }
    jobRequests.forEach((req, idx) => {
        requestsList.innerHTML += `
            <div class="job">
                <h3>${req.jobTitle}</h3>
                <p><b>Applicant:</b> ${req.userName}</p>
                <p><b>Email:</b> ${req.userEmail}</p>
                <p><b>Message:</b> ${req.message}</p>
            </div>
        `;
    });
}

function logout(){
    // Optionally clear session storage if needed
    // sessionStorage.clear();
    window.location.href = "home.php";
}

</script>

</body>
</html>
