<?php
session_start();
include "dp.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}
$user_name = $_SESSION['name'] ?? 'Admin User';
$user_email = $_SESSION['email'] ?? 'admin@kaamsathi.com';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard | KaamSathi</title>
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
  --accent-red: #ef4444;
  --accent-yellow: #f59e0b;
  --border: #e5e7eb;
  --shadow: 0 1px 3px rgba(0,0,0,0.1);
  --shadow-lg: 0 10px 30px rgba(0,0,0,0.1);
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
  transition: 0.3s;
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

.user-profile {
  margin-top: auto;
  padding-top: 20px;
  border-top: 1px solid var(--border);
  display: flex;
  align-items: center;
  gap: 12px;
}

.user-avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: linear-gradient(135deg, #667eea, #764ba2);
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-weight: 600;
}

.user-info h4 {
  font-size: 14px;
  margin-bottom: 2px;
}

.user-info p {
  font-size: 12px;
  color: var(--text-secondary);
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

.top-actions {
  display: flex;
  gap: 10px;
}

.btn {
  padding: 10px 20px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
  transition: 0.3s;
  display: flex;
  align-items: center;
  gap: 8px;
}

.btn-primary {
  background: var(--accent-blue);
  color: white;
}

.btn-primary:hover {
  background: #1e40af;
  transform: translateY(-2px);
}

.btn-outline {
  background: white;
  border: 1px solid var(--border);
  color: var(--text-primary);
}

.btn-outline:hover {
  border-color: var(--accent-blue);
  color: var(--accent-blue);
}

/* STATS GRID */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
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
.stat-card.yellow::before { background: var(--accent-yellow); }
.stat-card.red::before { background: var(--accent-red); }

.stat-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
}

.stat-icon {
  width: 48px;
  height: 48px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
}

.stat-card.blue .stat-icon {
  background: #eff6ff;
  color: var(--accent-blue);
}

.stat-card.green .stat-icon {
  background: #f0fdf4;
  color: var(--accent-green);
}

.stat-card.yellow .stat-icon {
  background: #fffbeb;
  color: var(--accent-yellow);
}

.stat-card.red .stat-icon {
  background: #fef2f2;
  color: var(--accent-red);
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

.stat-change {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  font-size: 13px;
  margin-top: 10px;
  padding: 4px 8px;
  border-radius: 6px;
}

.stat-change.up {
  background: #f0fdf4;
  color: var(--accent-green);
}

.stat-change.down {
  background: #fef2f2;
  color: var(--accent-red);
}

/* CONTENT GRID */
.content-grid {
  display: grid;
  grid-template-columns: 2fr 1fr;
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
}

.card-action:hover {
  text-decoration: underline;
}

/* TABLE */
.table-container {
  overflow-x: auto;
}

table {
  width: 100%;
  border-collapse: collapse;
}

thead {
  background: var(--bg-primary);
}

th {
  text-align: left;
  padding: 12px;
  font-weight: 600;
  font-size: 13px;
  color: var(--text-secondary);
  text-transform: uppercase;
}

td {
  padding: 12px;
  border-bottom: 1px solid var(--border);
}

tr:hover {
  background: var(--bg-primary);
}

.status-badge {
  display: inline-block;
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 600;
}

.status-active {
  background: #f0fdf4;
  color: var(--accent-green);
}

.status-pending {
  background: #fffbeb;
  color: var(--accent-yellow);
}

.status-inactive {
  background: #f3f4f6;
  color: var(--text-secondary);
}

.action-btns {
  display: flex;
  gap: 8px;
}

.icon-btn {
  width: 32px;
  height: 32px;
  border: none;
  background: var(--bg-primary);
  border-radius: 6px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--text-secondary);
  transition: 0.3s;
}

.icon-btn:hover {
  background: var(--accent-blue);
  color: white;
}

/* ACTIVITY */
.activity-item {
  display: flex;
  gap: 12px;
  padding: 12px 0;
  border-bottom: 1px solid var(--border);
}

.activity-item:last-child {
  border-bottom: none;
}

.activity-icon {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  font-size: 14px;
}

.activity-icon.blue {
  background: #eff6ff;
  color: var(--accent-blue);
}

.activity-icon.green {
  background: #f0fdf4;
  color: var(--accent-green);
}

.activity-icon.yellow {
  background: #fffbeb;
  color: var(--accent-yellow);
}

.activity-details h4 {
  font-size: 14px;
  margin-bottom: 4px;
}

.activity-details p {
  font-size: 12px;
  color: var(--text-secondary);
}

.activity-time {
  font-size: 11px;
  color: var(--text-secondary);
  margin-top: 4px;
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
    <a href="admin-dashboard.php" class="nav-item active">
      <i class="fas fa-home"></i>
      <span>Dashboard</span>
    </a>
    <a href="#" class="nav-item">
      <i class="fas fa-users"></i>
      <span>Users</span>
    </a>
    <a href="#" class="nav-item">
      <i class="fas fa-briefcase"></i>
      <span>Jobs</span>
    </a>
    <a href="#" class="nav-item">
      <i class="fas fa-building"></i>
      <span>Companies</span>
    </a>
    <a href="#" class="nav-item">
      <i class="fas fa-file-alt"></i>
      <span>Applications</span>
    </a>
    <a href="#" class="nav-item">
      <i class="fas fa-chart-line"></i>
      <span>Analytics</span>
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
    <div class="user-avatar"><?php echo strtoupper(substr($user_name, 0, 2)); ?></div>
    <div class="user-info">
      <h4><?php echo htmlspecialchars($user_name); ?></h4>
      <p><?php echo htmlspecialchars($user_email); ?></p>
    </div>
  </div>
</aside>

<!-- MAIN CONTENT -->
<main class="main-content">
  <!-- TOP BAR -->
  <div class="top-bar">
    <div class="welcome">
      <h1>Welcome back, <?php echo htmlspecialchars($user_name); ?></h1>
      <p>Here's what's happening with KaamSathi today</p>
    </div>
    <div class="top-actions">
      <button class="btn btn-outline">
        <i class="fas fa-download"></i>
        Export
      </button>
      <button class="btn btn-primary">
        <i class="fas fa-plus"></i>
        Add New
      </button>
    </div>
  </div>

  <!-- STATS GRID -->
  <div class="stats-grid">
    <div class="stat-card blue">
      <div class="stat-header">
        <div class="stat-icon">
          <i class="fas fa-users"></i>
        </div>
      </div>
      <div class="stat-value">2,847</div>
      <div class="stat-label">Total Users</div>
      <div class="stat-change up">
        <i class="fas fa-arrow-up"></i>
        <span>12% from last month</span>
      </div>
    </div>

    <div class="stat-card green">
      <div class="stat-header">
        <div class="stat-icon">
          <i class="fas fa-briefcase"></i>
        </div>
      </div>
      <div class="stat-value">342</div>
      <div class="stat-label">Active Jobs</div>
      <div class="stat-change up">
        <i class="fas fa-arrow-up"></i>
        <span>8% from last month</span>
      </div>
    </div>

    <div class="stat-card yellow">
      <div class="stat-header">
        <div class="stat-icon">
          <i class="fas fa-file-alt"></i>
        </div>
      </div>
      <div class="stat-value">1,583</div>
      <div class="stat-label">Applications</div>
      <div class="stat-change up">
        <i class="fas fa-arrow-up"></i>
        <span>24% from last month</span>
      </div>
    </div>

    <div class="stat-card red">
      <div class="stat-header">
        <div class="stat-icon">
          <i class="fas fa-building"></i>
        </div>
      </div>
      <div class="stat-value">156</div>
      <div class="stat-label">Companies</div>
      <div class="stat-change down">
        <i class="fas fa-arrow-down"></i>
        <span>3% from last month</span>
      </div>
    </div>
  </div>

  <!-- CONTENT GRID -->
  <div class="content-grid">
    <!-- RECENT USERS -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Recent Users</h3>
        <span class="card-action">View All</span>
      </div>
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Rajesh Kumar</td>
              <td>rajesh@email.com</td>
              <td>Job Seeker</td>
              <td><span class="status-badge status-active">Active</span></td>
              <td>
                <div class="action-btns">
                  <button class="icon-btn"><i class="fas fa-eye"></i></button>
                  <button class="icon-btn"><i class="fas fa-edit"></i></button>
                  <button class="icon-btn"><i class="fas fa-trash"></i></button>
                </div>
              </td>
            </tr>
            <tr>
              <td>Priya Sharma</td>
              <td>priya@email.com</td>
              <td>Recruiter</td>
              <td><span class="status-badge status-active">Active</span></td>
              <td>
                <div class="action-btns">
                  <button class="icon-btn"><i class="fas fa-eye"></i></button>
                  <button class="icon-btn"><i class="fas fa-edit"></i></button>
                  <button class="icon-btn"><i class="fas fa-trash"></i></button>
                </div>
              </td>
            </tr>
            <tr>
              <td>Amit Thapa</td>
              <td>amit@email.com</td>
              <td>Job Seeker</td>
              <td><span class="status-badge status-pending">Pending</span></td>
              <td>
                <div class="action-btns">
                  <button class="icon-btn"><i class="fas fa-eye"></i></button>
                  <button class="icon-btn"><i class="fas fa-edit"></i></button>
                  <button class="icon-btn"><i class="fas fa-trash"></i></button>
                </div>
              </td>
            </tr>
            <tr>
              <td>Sita Rai</td>
              <td>sita@email.com</td>
              <td>Recruiter</td>
              <td><span class="status-badge status-active">Active</span></td>
              <td>
                <div class="action-btns">
                  <button class="icon-btn"><i class="fas fa-eye"></i></button>
                  <button class="icon-btn"><i class="fas fa-edit"></i></button>
                  <button class="icon-btn"><i class="fas fa-trash"></i></button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- RECENT ACTIVITY -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Recent Activity</h3>
        <span class="card-action">View All</span>
      </div>
      <div class="activity-list">
        <div class="activity-item">
          <div class="activity-icon blue">
            <i class="fas fa-user-plus"></i>
          </div>
          <div class="activity-details">
            <h4>New User Registered</h4>
            <p>Rajesh Kumar joined as Job Seeker</p>
            <div class="activity-time">2 hours ago</div>
          </div>
        </div>
        <div class="activity-item">
          <div class="activity-icon green">
            <i class="fas fa-briefcase"></i>
          </div>
          <div class="activity-details">
            <h4>New Job Posted</h4>
            <p>Software Engineer at Tech Solutions</p>
            <div class="activity-time">4 hours ago</div>
          </div>
        </div>
        <div class="activity-item">
          <div class="activity-icon yellow">
            <i class="fas fa-file-alt"></i>
          </div>
          <div class="activity-details">
            <h4>Application Submitted</h4>
            <p>Priya applied for Marketing Manager</p>
            <div class="activity-time">6 hours ago</div>
          </div>
        </div>
        <div class="activity-item">
          <div class="activity-icon blue">
            <i class="fas fa-building"></i>
          </div>
          <div class="activity-details">
            <h4>Company Verified</h4>
            <p>Himalayan Enterprises approved</p>
            <div class="activity-time">8 hours ago</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

</body>
</html>