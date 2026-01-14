<?php
session_start();
include "dp.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'jobseeker'){
    header("Location: login.php");
    exit();
}

$user_name = $_SESSION['name'] ?? 'Job Seeker';
$user_email = $_SESSION['email'] ?? 'jobseeker@email.com';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Job Seeker Dashboard | KaamSathi</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
* {margin:0;padding:0;box-sizing:border-box;}

:root {
  --bg-primary: #f9fafb;
  --bg-secondary: #ffffff;
  --text-primary: #1f2937;
  --text-secondary: #6b7280;
  --accent-blue: #2563eb;
  --accent-green: #10b981;
  --accent-purple: #8b5cf6;
  --accent-yellow: #f59e0b;
  --border: #e5e7eb;
  --shadow: 0 1px 3px rgba(0,0,0,0.1);
}

body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background: var(--bg-primary);
  color: var(--text-primary);
  display: flex;
  min-height: 100vh;
}

/* SIDEBAR */
.sidebar {
  width: 260px;
  background: var(--bg-secondary);
  border-right: 1px solid var(--border);
  padding: 20px;
  position: fixed;
  height: 100vh;
  overflow-y: auto;
}

.logo {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 30px;
  padding: 10px;
}

.logo i {
  font-size: 32px;
  color: var(--accent-blue);
}

.logo h2 {
  color: var(--accent-blue);
  font-size: 24px;
}

.nav-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 15px;
  margin-bottom: 5px;
  border-radius: 8px;
  color: var(--text-secondary);
  cursor: pointer;
  transition: 0.3s;
  text-decoration: none;
}

.nav-item:hover, .nav-item.active {
  background: #eff6ff;
  color: var(--accent-blue);
}

.nav-item i {
  width: 20px;
  text-align: center;
}

.nav-item .badge {
  margin-left: auto;
  background: var(--accent-blue);
  color: white;
  padding: 2px 8px;
  border-radius: 10px;
  font-size: 11px;
}

.user-profile {
  margin-top: auto;
  padding-top: 20px;
  border-top: 1px solid var(--border);
}

.profile-card {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px;
  background: var(--bg-primary);
  border-radius: 10px;
}

.user-avatar {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  background: linear-gradient(135deg, #667eea, #764ba2);
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-weight: 600;
  font-size: 18px;
}

.user-info h4 {
  font-size: 14px;
  margin-bottom: 2px;
}

.user-info p {
  font-size: 12px;
  color: var(--text-secondary);
}

.profile-progress {
  margin-top: 12px;
  padding: 12px;
  background: #fef3c7;
  border-radius: 8px;
  border-left: 3px solid var(--accent-yellow);
}

.profile-progress p {
  font-size: 12px;
  color: #92400e;
  margin-bottom: 8px;
}

.progress-bar {
  height: 8px;
  background: #fde68a;
  border-radius: 4px;
  overflow: hidden;
}

.progress-fill {
  height: 100%;
  background: var(--accent-yellow);
  width: 65%;
  transition: 0.3s;
}

/* MAIN CONTENT */
.main-content {
  margin-left: 260px;
  flex: 1;
  padding: 30px;
}

.top-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 30px;
}

.welcome h1 {
  font-size: 28px;
  margin-bottom: 5px;
}

.welcome p {
  color: var(--text-secondary);
}

.search-bar {
  display: flex;
  gap: 10px;
  background: white;
  padding: 8px;
  border-radius: 10px;
  box-shadow: var(--shadow);
  max-width: 500px;
}

.search-bar input {
  flex: 1;
  border: none;
  outline: none;
  padding: 8px 12px;
  font-size: 14px;
}

.search-bar button {
  padding: 10px 20px;
  border: none;
  background: var(--accent-blue);
  color: white;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 600;
  transition: 0.3s;
}

.search-bar button:hover {
  background: #1e40af;
}

/* STATS GRID */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 20px;
  margin-bottom: 30px;
}

.stat-card {
  background: white;
  padding: 24px;
  border-radius: 12px;
  box-shadow: var(--shadow);
  position: relative;
  overflow: hidden;
}

.stat-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 4px;
  height: 100%;
}

.stat-card.blue::before { background: var(--accent-blue); }
.stat-card.green::before { background: var(--accent-green); }
.stat-card.purple::before { background: var(--accent-purple); }
.stat-card.yellow::before { background: var(--accent-yellow); }

.stat-icon {
  width: 48px;
  height: 48px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  margin-bottom: 12px;
}

.stat-card.blue .stat-icon {
  background: #eff6ff;
  color: var(--accent-blue);
}

.stat-card.green .stat-icon {
  background: #f0fdf4;
  color: var(--accent-green);
}

.stat-card.purple .stat-icon {
  background: #faf5ff;
  color: var(--accent-purple);
}

.stat-card.yellow .stat-icon {
  background: #fffbeb;
  color: var(--accent-yellow);
}

.stat-value {
  font-size: 32px;
  font-weight: 700;
  margin-bottom: 5px;
}

.stat-label {
  color: var(--text-secondary);
  font-size: 14px;
}

/* CONTENT GRID */
.content-grid {
  display: grid;
  grid-template-columns: 1.8fr 1fr;
  gap: 20px;
  margin-bottom: 20px;
}

.card {
  background: white;
  border-radius: 12px;
  box-shadow: var(--shadow);
  padding: 24px;
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.card-title {
  font-size: 18px;
  font-weight: 600;
}

.card-action {
  color: var(--accent-blue);
  font-size: 14px;
  cursor: pointer;
  transition: 0.3s;
}

.card-action:hover {
  text-decoration: underline;
}

/* JOB CARD */
.job-card {
  padding: 20px;
  border: 1px solid var(--border);
  border-radius: 10px;
  margin-bottom: 15px;
  transition: 0.3s;
  cursor: pointer;
}

.job-card:hover {
  border-color: var(--accent-blue);
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  transform: translateY(-2px);
}

.job-header {
  display: flex;
  justify-content: space-between;
  align-items: start;
  margin-bottom: 12px;
}

.job-logo {
  width: 48px;
  height: 48px;
  border-radius: 10px;
  background: linear-gradient(135deg, #667eea, #764ba2);
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-weight: 600;
  font-size: 18px;
}

.job-info {
  flex: 1;
  margin-left: 12px;
}

.job-title {
  font-size: 16px;
  font-weight: 600;
  margin-bottom: 4px;
}

.job-company {
  font-size: 14px;
  color: var(--text-secondary);
}

.job-badge {
  padding: 4px 10px;
  background: #f0fdf4;
  color: var(--accent-green);
  border-radius: 20px;
  font-size: 11px;
  font-weight: 600;
}

.job-meta {
  display: flex;
  flex-wrap: wrap;
  gap: 15px;
  font-size: 13px;
  color: var(--text-secondary);
  margin-bottom: 12px;
}

.job-meta span {
  display: flex;
  align-items: center;
  gap: 5px;
}

.job-tags {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
  margin-bottom: 12px;
}

.tag {
  padding: 4px 10px;
  background: var(--bg-primary);
  border-radius: 6px;
  font-size: 12px;
  color: var(--text-secondary);
}

.job-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.apply-btn {
  padding: 8px 20px;
  background: var(--accent-blue);
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 600;
  font-size: 13px;
  transition: 0.3s;
}

.apply-btn:hover {
  background: #1e40af;
  transform: translateY(-2px);
}

/* APPLICATION STATUS */
.application-item {
  padding: 16px;
  border-left: 4px solid var(--accent-blue);
  background: var(--bg-primary);
  border-radius: 8px;
  margin-bottom: 12px;
}

.app-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}

.app-title {
  font-size: 15px;
  font-weight: 600;
  margin-bottom: 4px;
}

.app-company {
  font-size: 13px;
  color: var(--text-secondary);
}

.status-badge {
  padding: 5px 12px;
  border-radius: 20px;
  font-size: 11px;
  font-weight: 600;
}

.status-pending {
  background: #fffbeb;
  color: #d97706;
}

.status-reviewed {
  background: #eff6ff;
  color: var(--accent-blue);
}

.status-shortlisted {
  background: #f0fdf4;
  color: var(--accent-green);
}

.app-date {
  font-size: 12px;
  color: var(--text-secondary);
  margin-top: 8px;
}

/* RECOMMENDED */
.rec-item {
  display: flex;
  gap: 12px;
  padding: 12px;
  border: 1px solid var(--border);
  border-radius: 8px;
  margin-bottom: 10px;
  transition: 0.3s;
  cursor: pointer;
}

.rec-item:hover {
  border-color: var(--accent-blue);
}

.rec-icon {
  width: 40px;
  height: 40px;
  border-radius: 8px;
  background: linear-gradient(135deg, #f093fb, #f5576c);
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  flex-shrink: 0;
}

.rec-details h4 {
  font-size: 14px;
  margin-bottom: 4px;
}

.rec-details p {
  font-size: 12px;
  color: var(--text-secondary);
}

/* RESPONSIVE */
@media (max-width: 1200px) {
  .content-grid {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 768px) {
  .sidebar {
    transform: translateX(-100%);
  }
  
  .main-content {
    margin-left: 0;
    padding: 20px;
  }
  
  .stats-grid {
    grid-template-columns: 1fr;
  }
  
  .top-bar {
    flex-direction: column;
    align-items: flex-start;
    gap: 15px;
  }
  
  .search-bar {
    width: 100%;
    max-width: 100%;
  }
}
</style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
  <div class="logo">
    <i class="fas fa-briefcase"></i>
    <h2>KaamSathi</h2>
  </div>
  
  <nav>
    <a href="jobseeker-dashboard.php" class="nav-item active">
      <i class="fas fa-home"></i>
      <span>Dashboard</span>
    </a>
    <a href="job.php" class="nav-item">
      <i class="fas fa-search"></i>
      <span>Find Jobs</span>
    </a>
    <a href="#" class="nav-item">
      <i class="fas fa-file-alt"></i>
      <span>My Applications</span>
      <span class="badge">5</span>
    </a>
    <a href="#" class="nav-item">
      <i class="fas fa-bookmark"></i>
      <span>Saved Jobs</span>
    </a>
    <a href="#" class="nav-item">
      <i class="fas fa-bell"></i>
      <span>Notifications</span>
      <span class="badge">3</span>
    </a>
    <a href="#" class="nav-item">
      <i class="fas fa-user"></i>
      <span>My Profile</span>
    </a>
    <a href="#" class="nav-item">
      <i class="fas fa-file"></i>
      <span>Resume Builder</span>
    </a>
    <a href="#" class="nav-item">
      <i class="fas fa-cog"></i>
      <span>Settings</span>
    </a>
    <a href="logout.php" class="nav-item">
      <i class="fas fa-sign-out-alt"></i>
      <span>Logout</span>
    </a>
  </nav>
  
  <div class="user-profile">
    <div class="profile-card">
      <div class="user-avatar"><?php echo strtoupper(substr($user_name, 0, 2)); ?></div>
      <div class="user-info">
        <h4><?php echo htmlspecialchars($user_name); ?></h4>
        <p><?php echo htmlspecialchars($user_email); ?></p>
      </div>
    </div>
    <div class="profile-progress">
      <p><strong>Profile Completion: 65%</strong></p>
      <div class="progress-bar">
        <div class="progress-fill"></div>
      </div>
    </div>
  </div>
</aside>

<!-- MAIN CONTENT -->
<main class="main-content">
  <!-- TOP BAR -->
  <div class="top-bar">
    <div class="welcome">
      <h1>Welcome back, <?php echo htmlspecialchars($user_name); ?>! 🎯</h1>
      <p>Find your dream job today</p>
    </div>
    <div class="search-bar">
      <input type="text" placeholder="Search jobs, companies, or keywords...">
      <button><i class="fas fa-search"></i></button>
    </div>
  </div>

  <!-- STATS GRID -->
  <div class="stats-grid">
    <div class="stat-card blue">
      <div class="stat-icon">
        <i class="fas fa-file-alt"></i>
      </div>
      <div class="stat-value">5</div>
      <div class="stat-label">Applications Sent</div>
    </div>

    <div class="stat-card green">
      <div class="stat-icon">
        <i class="fas fa-eye"></i>
      </div>
      <div class="stat-value">124</div>
      <div class="stat-label">Profile Views</div>
    </div>

    <div class="stat-card purple">
      <div class="stat-icon">
        <i class="fas fa-bookmark"></i>
      </div>
      <div class="stat-value">8</div>
      <div class="stat-label">Saved Jobs</div>
    </div>

    <div class="stat-card yellow">
      <div class="stat-icon">
        <i class="fas fa-calendar-check"></i>
      </div>
      <div class="stat-value">2</div>
      <div class="stat-label">Interviews</div>
    </div>
  </div>

  <!-- CONTENT GRID -->
  <div class="content-grid">
    <!-- RECOMMENDED JOBS -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Recommended Jobs</h3>
        <span class="card-action">View All</span>
      </div>

      <div class="job-card">
        <div class="job-header">
          <div style="display: flex; align-items: start;">
            <div class="job-logo">TS</div>
            <div class="job-info">
              <div class="job-title">Senior Software Engineer</div>
              <div class="job-company">Tech Solutions Pvt. Ltd.</div>
            </div>
          </div>
          <div class="job-badge">New</div>
        </div>
        <div class="job-meta">
          <span><i class="fas fa-map-marker-alt"></i> Kathmandu</span>
          <span><i class="fas fa-briefcase"></i> Full-time</span>
          <span><i class="fas fa-money-bill"></i> NPR 80K - 120K</span>
        </div>
        <div class="job-tags">
          <span class="tag">React</span>
          <span class="tag">Node.js</span>
          <span class="tag">MongoDB</span>
          <span class="tag">AWS</span>
        </div>
        <div class="job-footer">
          <span style="font-size: 12px; color: var(--text-secondary);">
            <i class="fas fa-clock"></i> Posted 2 days ago
          </span>
          <button class="apply-btn">Apply Now</button>
        </div>
      </div>

      <div class="job-card">
        <div class="job-header">
          <div style="display: flex; align-items: start;">
            <div class="job-logo">DM</div>
            <div class="job-info">
              <div class="job-title">Marketing Manager</div>
              <div class="job-company">Digital Marketing Agency</div>
            </div>
          </div>
          <div class="job-badge">Hot</div>
        </div>
        <div class="job-meta">
          <span><i class="fas fa-map-marker-alt"></i> Pokhara</span>
          <span><i class="fas fa-briefcase"></i> Full-time</span>
          <span><i class="fas fa-money-bill"></i> NPR 60K - 90K</span>
        </div>
        <div class="job-tags">
          <span class="tag">SEO</span>
          <span class="tag">Content Marketing</span>
          <span class="tag">Analytics</span>
        </div>
        <div class="job-footer">
          <span style="font-size: 12px; color: var(--text-secondary);">
            <i class="fas fa-clock"></i> Posted 4 days ago
          </span>
          <button class="apply-btn">Apply Now</button>
        </div>
      </div>

      <div class="job-card">
        <div class="job-header">
          <div style="display: flex; align-items: start;">
            <div class="job-logo">CS</div>
            <div class="job-info">
              <div class="job-title">UI/UX Designer</div>
              <div class="job-company">Creative Studio</div>
            </div>
          </div>
        </div>
        <div class="job-meta">
          <span><i class="fas fa-map-marker-alt"></i> Remote</span>
          <span><i class="fas fa-briefcase"></i> Contract</span>
          <span><i class="fas fa-money-bill"></i> NPR 70K - 100K</span>
        </div>
        <div class="job-tags">
          <span class="tag">Figma</span>
          <span class="tag">Adobe XD</span>
          <span class="tag">User Research</span>
        </div>
        <div class="job-footer">
          <span style="font-size: 12px; color: var(--text-secondary);">
            <i class="fas fa-clock"></i> Posted 1 week ago
          </span>
          <button class="apply-btn">Apply Now</button>
        </div>
      </div>
    </div>

    <!-- RIGHT SIDEBAR -->
    <div>
      <!-- APPLICATION STATUS -->
      <div class="card" style="margin-bottom: 20px;">
        <div class="card-header">
          <h3 class="card-title">Application Status</h3>
          <span class="card-action">View All</span>
        </div>
        
        <div class="application-item">
          <div class="app-header">
            <div>
              <div class="app-title">Full Stack Developer</div>
              <div class="app-company">Tech Innovations</div>
            </div>
            <span class="status-badge status-shortlisted">Shortlisted</span>
          </div>
          <div class="app-date">Applied 5 days ago</div>
        </div>

        <div class="application-item" style="border-left-color: var(--accent-yellow);">
          <div class="app-header">
            <div>
              <div class="app-title">Product Designer</div>
              <div class="app-company">Design Studio</div>
            </div>
            <span class="status-badge status-reviewed">Reviewed</span>
          </div>
          <div class="app-date">Applied 1 week ago</div>
        </div>

        <div class="application-item" style="border-left-color: var(--accent-purple);">
          <div class="app-header">
            <div>
              <div class="app-title">Data Analyst</div>
              <div class="app-company">Analytics Corp</div>
            </div>
            <span class="status-badge status-pending">Pending</span>
          </div>
          <div class="app-date">Applied 2 weeks ago</div>
        </div>
      </div>

      <!-- QUICK ACTIONS -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Quick Actions</h3>
        </div>
        
        <div class="rec-item">
          <div class="rec-icon">
            <i class="fas fa-file"></i>
          </div>
          <div class="rec-details">
            <h4>Update Resume</h4>
            <p>Keep your profile fresh</p>
          </div>
        </div>

        <div class="rec-item">
          <div class="rec-icon" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
            <i class="fas fa-user-check"></i>
          </div>
          <div class="rec-details">
            <h4>Complete Profile</h4>
            <p>Boost your visibility</p>
          </div>
        </div>

        <div class="rec-item">
          <div class="rec-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
            <i class="fas fa-bell"></i>
          </div>
          <div class="rec-details">
            <h4>Job Alerts</h4>
            <p>Set up notifications</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

</body>
</html>