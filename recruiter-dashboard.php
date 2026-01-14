<?php
session_start();
include "dp.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'recruiter'){
    header("Location: login.php");
    exit();
}

$user_name = $_SESSION['name'] ?? 'Recruiter';
$user_email = $_SESSION['email'] ?? 'recruiter@email.com';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Recruiter Dashboard | KaamSathi</title>
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
  --accent-orange: #f97316;
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

.btn {
  padding: 12px 24px;
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
  box-shadow: 0 4px 12px rgba(37,99,235,0.3);
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
.stat-card.orange::before { background: var(--accent-orange); }

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

.stat-card.purple .stat-icon {
  background: #faf5ff;
  color: var(--accent-purple);
}

.stat-card.orange .stat-icon {
  background: #fff7ed;
  color: var(--accent-orange);
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

/* QUICK ACTIONS */
.quick-actions {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 15px;
  margin-bottom: 30px;
}

.action-card {
  background: white;
  padding: 20px;
  border-radius: 12px;
  box-shadow: var(--shadow);
  cursor: pointer;
  transition: 0.3s;
  display: flex;
  align-items: center;
  gap: 15px;
}

.action-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.action-icon {
  width: 50px;
  height: 50px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 22px;
  color: white;
}

.action-card:nth-child(1) .action-icon { background: linear-gradient(135deg, #667eea, #764ba2); }
.action-card:nth-child(2) .action-icon { background: linear-gradient(135deg, #f093fb, #f5576c); }
.action-card:nth-child(3) .action-icon { background: linear-gradient(135deg, #4facfe, #00f2fe); }
.action-card:nth-child(4) .action-icon { background: linear-gradient(135deg, #43e97b, #38f9d7); }

.action-details h4 {
  font-size: 15px;
  margin-bottom: 4px;
}

.action-details p {
  font-size: 12px;
  color: var(--text-secondary);
}

/* CONTENT GRID */
.content-grid {
  display: grid;
  grid-template-columns: 1.5fr 1fr;
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

/* JOB ITEM */
.job-item {
  padding: 16px;
  border: 1px solid var(--border);
  border-radius: 10px;
  margin-bottom: 12px;
  transition: 0.3s;
  cursor: pointer;
}

.job-item:hover {
  border-color: var(--accent-blue);
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.job-header {
  display: flex;
  justify-content: space-between;
  align-items: start;
  margin-bottom: 10px;
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

.job-status {
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 600;
}

.status-live {
  background: #f0fdf4;
  color: var(--accent-green);
}

.status-draft {
  background: #fef3c7;
  color: #d97706;
}

.job-meta {
  display: flex;
  gap: 15px;
  font-size: 13px;
  color: var(--text-secondary);
  margin-bottom: 10px;
}

.job-meta span {
  display: flex;
  align-items: center;
  gap: 5px;
}

.job-actions {
  display: flex;
  gap: 8px;
}

.icon-btn {
  padding: 6px 12px;
  border: 1px solid var(--border);
  background: white;
  border-radius: 6px;
  cursor: pointer;
  font-size: 12px;
  transition: 0.3s;
}

.icon-btn:hover {
  background: var(--accent-blue);
  color: white;
  border-color: var(--accent-blue);
}

/* APPLICANT ITEM */
.applicant-item {
  display: flex;
  gap: 12px;
  padding: 12px;
  border-bottom: 1px solid var(--border);
  cursor: pointer;
  transition: 0.3s;
}

.applicant-item:hover {
  background: var(--bg-primary);
}

.applicant-avatar {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  background: linear-gradient(135deg, #667eea, #764ba2);
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-weight: 600;
  flex-shrink: 0;
}

.applicant-details {
  flex: 1;
}

.applicant-name {
  font-size: 14px;
  font-weight: 600;
  margin-bottom: 4px;
}

.applicant-role {
  font-size: 13px;
  color: var(--text-secondary);
  margin-bottom: 6px;
}

.applicant-skills {
  display: flex;
  gap: 6px;
  flex-wrap: wrap;
}

.skill-tag {
  padding: 3px 8px;
  background: var(--bg-primary);
  border-radius: 4px;
  font-size: 11px;
  color: var(--text-secondary);
}

.applicant-actions {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.action-btn-sm {
  padding: 6px 12px;
  border: none;
  border-radius: 6px;
  font-size: 12px;
  cursor: pointer;
  transition: 0.3s;
}

.action-btn-sm.accept {
  background: var(--accent-green);
  color: white;
}

.action-btn-sm.reject {
  background: #fee;
  color: #ef4444;
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
  
  .stats-grid, .quick-act