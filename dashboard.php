<?php
require 'config.php';
requireLogin();

$user = getCurrentUser();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learning Hub · Subbyte Programming</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Using Inter for a clean, modern look -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ----- RESET & VARIABLES (Clean & Simple) ----- */
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg: #ffffff;           /* Clean white background */
            --surface: #f9fafb;      /* Very light gray for cards/sections */
            --surface-hover: #f2f4f8;
            --border: #e5e7eb;       /* Soft gray border */
            --primary: #2563eb;       /* Trustworthy blue */
            --primary-dark: #1d4ed8;
            --primary-soft: #dbeafe;  /* Light blue for backgrounds */
            --text-dark: #111827;     /* Near black for headings */
            --text-body: #374151;     /* Dark gray for body text */
            --text-muted: #6b7280;    /* Muted gray for secondary text */
            --green: #10b981;
            --orange: #f59e0b;
            --pink: #ec4899;
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-md: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --transition: all 0.2s ease;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text-body);
            line-height: 1.5;
        }

        /* ----- UTILITY CLASSES ----- */
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* ----- NAVBAR (Clean & Simple) ----- */
        .navbar {
            background: white;
            border-bottom: 1px solid var(--border);
            padding: 0 2rem;
            height: 70px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo-icon {
            width: 36px; height: 36px;
            background: var(--primary);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
            color: white;
        }

        .nav-links {
            display: flex;
            gap: 2px;
            list-style: none;
        }

        .nav-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 30px;
            transition: var(--transition);
        }

        .nav-links a:hover, .nav-links a.active {
            color: var(--primary);
            background: var(--primary-soft);
        }

        .nav-right {
            display: flex; align-items: center; gap: 1rem;
        }

        .avatar-btn {
            display: flex; align-items: center; gap: 8px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 30px;
            padding: 5px 15px 5px 5px;
            cursor: default;
            text-decoration: none;
            color: var(--text-dark);
        }

        .avatar {
            width: 34px; height: 34px;
            background: var(--primary);
            border-radius: 30px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
            color: white;
        }

        .logout-btn {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            padding: 0.5rem 1.2rem;
            border-radius: 30px;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 500;
            display: flex; align-items: center; gap: 6px;
            transition: var(--transition);
        }

        .logout-btn:hover {
            background: #fecaca;
        }

        /* ----- HERO (Welcome Banner) ----- */
        .hero {
            background: linear-gradient(145deg, var(--primary-soft), white);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 3rem 3rem;
            margin: 2rem 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 2rem;
        }

        .hero h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            line-height: 1.2;
        }

        .hero h1 span {
            color: var(--primary);
        }

        .hero p {
            color: var(--text-muted);
            font-size: 1.1rem;
            max-width: 500px;
            margin-bottom: 1.5rem;
        }

        .hero-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-primary, .btn-ghost {
            padding: 0.7rem 1.8rem;
            border-radius: 30px;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
            border: 1px solid transparent;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-ghost {
            background: white;
            border: 1px solid var(--border);
            color: var(--text-dark);
        }

        .btn-ghost:hover {
            background: var(--surface);
        }

        .hero-stats {
            display: flex;
            gap: 1.5rem;
        }

        .hero-stat {
            text-align: center;
        }

        .hero-stat .num {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
            line-height: 1.2;
        }

        .hero-stat .lbl {
            font-size: 0.8rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ----- STATS ROW (Saylani-style) ----- */
        .impact-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin: 2.5rem 0;
        }

        .impact-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 1.8rem 1rem;
            text-align: center;
            transition: var(--transition);
        }

        .impact-card:hover {
            background: var(--surface-hover);
            transform: translateY(-4px);
        }

        .impact-card .big {
            font-size: 2.8rem;
            font-weight: 700;
            color: var(--primary);
            line-height: 1;
            margin-bottom: 0.3rem;
        }

        .impact-card .lbl {
            font-size: 0.9rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .impact-icon {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        /* ----- SECTION HEADER ----- */
        .sec-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 2.5rem 0 1.5rem;
        }

        .sec-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .sec-title span {
            color: var(--primary);
        }

        .see-all {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* ----- COURSE CARDS (Clean Grid) ----- */
        .courses-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .course-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
            transition: var(--transition);
            box-shadow: var(--shadow);
        }

        .course-card:hover {
            box-shadow: var(--shadow-md);
        }

        .cc-content {
            padding: 1.5rem;
        }

        .cc-icon {
            width: 48px; height: 48px;
            background: var(--primary-soft);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .course-card h3 {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .cc-desc {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        .cc-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 1rem;
        }

        .cc-meta i {
            color: var(--primary);
            width: 16px;
        }

        .cc-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
        }

        .cc-rating {
            color: #f59e0b;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .cc-rating small {
            color: var(--text-muted);
            font-weight: 400;
            font-size: 0.7rem;
        }

        .cc-btn {
            background: var(--primary-soft);
            color: var(--primary);
            padding: 0.4rem 1.2rem;
            border-radius: 30px;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 600;
            transition: var(--transition);
        }

        .cc-btn:hover {
            background: var(--primary);
            color: white;
        }

        /* ----- BOTTOM ROW (Progress + Profile) ----- */
        .bottom-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .panel {
            background: white;
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 1.8rem;
            box-shadow: var(--shadow);
        }

        .panel-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .panel-title i {
            color: var(--primary);
        }

        /* Progress List */
        .progress-list {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }

        .progress-item {}

        .progress-top {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.3rem;
            font-size: 0.9rem;
        }

        .progress-top .name {
            color: var(--text-dark);
            font-weight: 500;
        }

        .progress-top .pct {
            color: var(--primary);
            font-weight: 600;
        }

        .progress-bar-wrap {
            height: 8px;
            background: var(--surface);
            border-radius: 20px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            background: var(--primary);
            border-radius: 20px;
            width: 0; /* Set inline */
        }

        /* Profile */
        .profile-row {
            display: flex;
            align-items: center;
            gap: 1.2rem;
            padding-bottom: 1.2rem;
            margin-bottom: 1.2rem;
            border-bottom: 1px solid var(--border);
        }

        .profile-avatar {
            width: 60px; height: 60px;
            background: var(--primary);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem;
            font-weight: 600;
            color: white;
        }

        .profile-info h4 {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .profile-info p {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .detail-item {
            background: var(--surface);
            border-radius: 14px;
            padding: 0.8rem 1rem;
        }

        .detail-item .label {
            font-size: 0.6rem;
            text-transform: uppercase;
            color: var(--text-muted);
            letter-spacing: 0.5px;
            margin-bottom: 0.2rem;
        }

        .detail-item .value {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .status-badge {
            display: inline-block;
            background: #d1fae5;
            color: #065f46;
            padding: 0.2rem 0.8rem;
            border-radius: 30px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        /* ----- LEARNING PATH (Simple Steps) ----- */
        .path-steps {
            background: white;
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 1.8rem;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            box-shadow: var(--shadow);
        }

        .path-step {
            flex: 1;
            min-width: 100px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            position: relative;
        }

        .step-circle {
            width: 44px; height: 44px;
            border-radius: 44px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
            margin-bottom: 0.8rem;
            background: var(--surface);
            border: 2px solid var(--border);
            color: var(--text-muted);
        }

        .path-step.done .step-circle {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        .path-step.current .step-circle {
            border-color: var(--primary);
            color: var(--primary);
            background: white;
        }

        .path-step h5 {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .path-step p {
            font-size: 0.7rem;
            color: var(--text-muted);
        }

        /* ----- FOOTER ----- */
        .footer {
            background: white;
            border-top: 1px solid var(--border);
            padding: 2rem;
            margin-top: 3rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer p {
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        .footer-links {
            display: flex;
            gap: 2rem;
        }

        .footer-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.85rem;
        }

        .footer-links a:hover {
            color: var(--primary);
        }

        /* ----- RESPONSIVE ----- */
        @media (max-width: 1100px) {
            .impact-stats { grid-template-columns: repeat(2, 1fr); }
            .courses-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 900px) {
            .hero { flex-direction: column; text-align: center; }
            .hero-actions { justify-content: center; }
            .bottom-row { grid-template-columns: 1fr; }
            .path-steps { flex-direction: column; align-items: flex-start; }
            .path-step { flex-direction: row; text-align: left; gap: 1rem; width: 100%; }
            .step-circle { margin-bottom: 0; }
        }

        @media (max-width: 700px) {
            .navbar { padding: 0 1rem; }
            .nav-links { display: none; }
            .container { padding: 0 1rem; }
            .hero { padding: 2rem 1.5rem; }
            .hero h1 { font-size: 2rem; }
            .impact-stats { grid-template-columns: 1fr; }
            .courses-grid { grid-template-columns: 1fr; }
            .footer { flex-direction: column; gap: 1rem; text-align: center; }
            .detail-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- Clean Navbar -->
    <nav class="navbar">
        <a href="image/pexels-hatice-baran-153179658-17756968.jpg" class="logo">
            <!-- <div class="logo-icon"><i class="fas fa-code"></i></div> -->
            Subbyte<span style="color:var(--primary);">Programmer's</span>
        </a>

        <ul class="nav-links">
            <li><a href="./dashboard.php" class="active"><i class="fas fa-th-large"></i> Dashboard</a></li>
            <li><a href="./courses.php"><i class="fas fa-book-open"></i> Courses</a></li>
            <li><a href="./mypath.php"><i class="fas fa-route"></i> My Path</a></li>
            <li><a href="./certificates.php"><i class="fas fa-certificate"></i> Certificates</a></li>
            <li><a href="./community.php"><i class="fas fa-comments"></i> Community</a></li>
        </ul>

        <div class="nav-right">
            <div class="avatar-btn">
                <div class="avatar"><?php echo strtoupper(substr($user['name'], 0, 1)); ?></div>
                <span><?php echo htmlspecialchars(explode(' ', $user['name'])[0]); ?></span>
            </div>
            <a href="logout.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </nav>

    <main class="container">
        <!-- Hero Section (Like Saylani's welcome) -->
        <div class="hero">
            <div>
                <h1>Building Your<br><span>Tech Future</span></h1>
                <p>Change your life. Build your career. Shape the future with Subbyte Programming.</p>
                <div class="hero-actions">
                    <a href="#" class="btn-primary"><i class="fas fa-play"></i> Resume Learning</a>
                    <a href="#" class="btn-ghost"><i class="fas fa-compass"></i> Explore Courses</a>
                </div>
            </div>
            <div class="hero-stats">
                <div class="hero-stat">
                    <div class="num">12</div>
                    <div class="lbl">Enrolled</div>
                </div>
                <div class="hero-stat">
                    <div class="num">8</div>
                    <div class="lbl">Certificates</div>
                </div>
                <div class="hero-stat">
                    <div class="num">156h</div>
                    <div class="lbl">Total Time</div>
                </div>
            </div>
        </div>

        <!-- Impact Stats (Saylani-style) -->
        <div class="impact-stats">
            <div class="impact-card">
                <div class="impact-icon"><i class="fas fa-video"></i></div>
                <div class="big">150+</div>
                <div class="lbl">Video Tutorials</div>
            </div>
            <div class="impact-card">
                <div class="impact-icon"><i class="fas fa-users"></i></div>
                <div class="big">5K+</div>
                <div class="lbl">Active Students</div>
            </div>
            <div class="impact-card">
                <div class="impact-icon"><i class="fas fa-certificate"></i></div>
                <div class="big">98%</div>
                <div class="lbl">Success Rate</div>
            </div>
            <div class="impact-card">
                <div class="impact-icon"><i class="fas fa-headset"></i></div>
                <div class="big">24/7</div>
                <div class="lbl">Expert Support</div>
            </div>
        </div>

        <!-- Featured Courses -->
        <div class="sec-head">
            <h2 class="sec-title">🔥 <span>Featured</span> Courses</h2>
            <a href="#" class="see-all">View All <i class="fas fa-arrow-right"></i></a>
        </div>

        <div class="courses-grid">
            <!-- Card 1 -->
            <div class="course-card">
                <div class="cc-content">
                    <div class="cc-icon"><i class="fas fa-code"></i></div>
                    <h3>Web Development Masterclass</h3>
                    <p class="cc-desc">Master HTML, CSS, JavaScript & React. Build professional websites with real-world projects.</p>
                    <div class="cc-meta">
                        <span><i class="far fa-clock"></i> 42 hours</span>
                        <span><i class="fas fa-signal"></i> Intermediate</span>
                    </div>
                    <div class="cc-footer">
                        <div class="cc-rating"><i class="fas fa-star"></i> 4.9 <small>(2.3k)</small></div>
                        <a href="./courses.php" class="cc-btn">Start</a>
                    </div>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="course-card">
                <div class="cc-content">
                    <div class="cc-icon"><i class="fab fa-python"></i></div>
                    <h3>Python Programming Pro</h3>
                    <p class="cc-desc">Learn Python for web dev, data science, automation & AI. From beginner to professional.</p>
                    <div class="cc-meta">
                        <span><i class="far fa-clock"></i> 38 hours</span>
                        <span><i class="fas fa-signal"></i> Beginner</span>
                    </div>
                    <div class="cc-footer">
                        <div class="cc-rating"><i class="fas fa-star"></i> 4.8 <small>(1.9k)</small></div>
                        <a href="./courses.php" class="cc-btn">Start</a>
                    </div>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="course-card">
                <div class="cc-content">
                    <div class="cc-icon"><i class="fas fa-database"></i></div>
                    <h3>Database Management</h3>
                    <p class="cc-desc">Master SQL, MongoDB & PostgreSQL. Professional database design for modern applications.</p>
                    <div class="cc-meta">
                        <span><i class="far fa-clock"></i> 28 hours</span>
                        <span><i class="fas fa-signal"></i> Advanced</span>
                    </div>
                    <div class="cc-footer">
                        <div class="cc-rating"><i class="fas fa-star"></i> 4.7 <small>(1.4k)</small></div>
                        <a href="./courses.php" class="cc-btn">Start</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Row: Progress & Profile -->
        <div class="bottom-row">
            <!-- Progress Panel -->
            <div class="panel">
                <div class="panel-title">
                    <i class="fas fa-chart-line"></i> Learning Progress
                </div>
                <div class="progress-list">
                    <div class="progress-item">
                        <div class="progress-top">
                            <span class="name">Web Development Masterclass</span>
                            <span class="pct">73%</span>
                        </div>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar-fill" style="width:73%"></div>
                        </div>
                    </div>
                    <div class="progress-item">
                        <div class="progress-top">
                            <span class="name">Python Programming Pro</span>
                            <span class="pct">45%</span>
                        </div>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar-fill" style="width:45%"></div>
                        </div>
                    </div>
                    <div class="progress-item">
                        <div class="progress-top">
                            <span class="name">Database Management</span>
                            <span class="pct">20%</span>
                        </div>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar-fill" style="width:20%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Panel -->
            <div class="panel">
                <div class="panel-title">
                    <i class="fas fa-user-circle"></i> Your Profile
                </div>
                <div class="profile-row">
                    <div class="profile-avatar"><?php echo strtoupper(substr($user['name'], 0, 1)); ?></div>
                    <div class="profile-info">
                        <h4><?php echo htmlspecialchars($user['name']); ?></h4>
                        <p><?php echo htmlspecialchars($user['email']); ?></p>
                    </div>
                </div>
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="label">User ID</div>
                        <div class="value">#<?php echo htmlspecialchars($user['id']); ?></div>
                    </div>
                    <div class="detail-item">
                        <div class="label">Member Since</div>
                        <div class="value"><?php echo date('M d, Y', strtotime($user['created_at'])); ?></div>
                    </div>
                    <div class="detail-item">
                        <div class="label">Status</div>
                        <div class="value"><span class="status-badge"><i class="fas fa-circle" style="font-size: 6px; vertical-align: middle; margin-right: 4px;"></i>Active</span></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Learning Path (Simple Steps) -->
        <div class="sec-head" style="margin-top: 2rem;">
            <h2 class="sec-title">🗺️ Your <span>Learning Path</span></h2>
        </div>
        <div class="path-steps">
            <div class="path-step done">
                <div class="step-circle"><i class="fas fa-check"></i></div>
                <div>
                    <h5>HTML & CSS</h5>
                    <p>Completed</p>
                </div>
            </div>
            <div class="path-step done">
                <div class="step-circle"><i class="fas fa-check"></i></div>
                <div>
                    <h5>JavaScript</h5>
                    <p>Completed</p>
                </div>
            </div>
            <div class="path-step current">
                <div class="step-circle"><i class="fas fa-bolt"></i></div>
                <div>
                    <h5>React & Next.js</h5>
                    <p>In Progress</p>
                </div>
            </div>
            <div class="path-step">
                <div class="step-circle"><i class="fas fa-lock"></i></div>
                <div>
                    <h5>Node.js & APIs</h5>
                    <p>Upcoming</p>
                </div>
            </div>
            <div class="path-step">
                <div class="step-circle"><i class="fas fa-trophy"></i></div>
                <div>
                    <h5>Full Stack Dev</h5>
                    <p>Goal</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2026 Subbyte Programming. All rights reserved.</p>
        <div class="footer-links">
            <a href="#">Privacy</a>
            <a href="#">Terms</a>
            <a href="#">Support</a>
        </div>
    </div>

</body>
</html>