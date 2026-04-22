<?php
require 'config.php';
requireLogin();

$user = getCurrentUser();

// Learning path data (you can fetch from database)
$learningPath = [
    'html_css' => [
        'name' => 'HTML & CSS Fundamentals',
        'status' => 'completed',
        'progress' => 100,
        'icon' => 'fab fa-html5',
        'duration' => '2 weeks',
        'certificate' => 'HTML_CSS_001.pdf'
    ],
    'javascript' => [
        'name' => 'JavaScript Mastery',
        'status' => 'completed',
        'progress' => 100,
        'icon' => 'fab fa-js',
        'duration' => '3 weeks',
        'certificate' => 'JS_MASTERY_002.pdf'
    ],
    'php_basics' => [
        'name' => 'PHP & MySQL Basics',
        'status' => 'in_progress',
        'progress' => 65,
        'icon' => 'fab fa-php',
        'duration' => '4 weeks',
        'start_date' => '2026-01-10'
    ],
    'react' => [
        'name' => 'React & Modern Frontend',
        'status' => 'locked',
        'progress' => 0,
        'icon' => 'fab fa-react',
        'duration' => '4 weeks',
        'prerequisite' => 'JavaScript Mastery'
    ],
    'laravel' => [
        'name' => 'Laravel Framework',
        'status' => 'locked',
        'progress' => 0,
        'icon' => 'fab fa-laravel',
        'duration' => '5 weeks',
        'prerequisite' => 'PHP & MySQL Basics'
    ],
    'fullstack' => [
        'name' => 'Full Stack Project',
        'status' => 'locked',
        'progress' => 0,
        'icon' => 'fas fa-rocket',
        'duration' => '6 weeks',
        'prerequisite' => 'React & Laravel'
    ]
];

// Calculate overall progress
$completedModules = 0;
$totalModules = count($learningPath);
foreach($learningPath as $module) {
    if($module['status'] == 'completed') {
        $completedModules++;
    }
}
$overallProgress = ($completedModules / $totalModules) * 100;
$currentModule = 'PHP & MySQL Basics';
$currentProgress = 65;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Learning Path · Subbyte Programming</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg: #ffffff;
            --surface: #f9fafb;
            --surface-hover: #f2f4f8;
            --border: #e5e7eb;
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-soft: #dbeafe;
            --success: #10b981;
            --success-light: #d1fae5;
            --warning: #f59e0b;
            --warning-light: #fed7aa;
            --danger: #ef4444;
            --text-dark: #111827;
            --text-body: #374151;
            --text-muted: #6b7280;
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-md: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            --transition: all 0.2s ease;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text-body);
            line-height: 1.5;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* Navbar styles (same as dashboard) */
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

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary-soft) 0%, white 100%);
            border-radius: 24px;
            padding: 2rem;
            margin: 2rem 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .hero h1 span {
            color: var(--primary);
        }

        .overall-progress {
            max-width: 400px;
            margin: 1rem auto 0;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .progress-bar-big {
            height: 12px;
            background: var(--surface);
            border-radius: 20px;
            overflow: hidden;
        }

        .progress-fill-big {
            height: 100%;
            background: var(--primary);
            border-radius: 20px;
            transition: width 0.3s ease;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 1.5rem;
            text-align: center;
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .stat-icon {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        /* Timeline */
        .timeline {
            background: white;
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .timeline-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .timeline-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .timeline-title i {
            color: var(--primary);
            margin-right: 10px;
        }

        .filter-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .filter-btn {
            padding: 0.5rem 1rem;
            border: 1px solid var(--border);
            background: white;
            border-radius: 30px;
            cursor: pointer;
            font-size: 0.85rem;
            transition: var(--transition);
        }

        .filter-btn.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* Timeline Items */
        .timeline-items {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .timeline-item {
            display: flex;
            gap: 1.5rem;
            padding: 1.5rem;
            background: var(--surface);
            border-radius: 20px;
            transition: var(--transition);
            position: relative;
        }

        .timeline-item:hover {
            background: var(--surface-hover);
            transform: translateX(8px);
        }

        .timeline-icon {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            flex-shrink: 0;
            border: 2px solid var(--border);
        }

        .timeline-item.completed .timeline-icon {
            background: var(--success-light);
            border-color: var(--success);
            color: var(--success);
        }

        .timeline-item.in_progress .timeline-icon {
            background: var(--warning-light);
            border-color: var(--warning);
            color: var(--warning);
        }

        .timeline-item.locked .timeline-icon {
            background: var(--surface);
            border-color: var(--border);
            color: var(--text-muted);
        }

        .timeline-content {
            flex: 1;
        }

        .timeline-content h3 {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .timeline-meta {
            display: flex;
            gap: 1rem;
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .timeline-meta i {
            margin-right: 4px;
        }

        .module-progress {
            margin-top: 1rem;
        }

        .module-progress .progress-text {
            font-size: 0.8rem;
            margin-bottom: 0.3rem;
        }

        .module-progress .progress-bar {
            height: 6px;
            background: var(--border);
            border-radius: 10px;
            overflow: hidden;
        }

        .module-progress .progress-fill {
            height: 100%;
            background: var(--primary);
            border-radius: 10px;
            transition: width 0.3s ease;
        }

        .timeline-actions {
            display: flex;
            gap: 0.8rem;
            align-items: flex-start;
        }

        .btn-action {
            padding: 0.5rem 1.2rem;
            border-radius: 30px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-outline {
            border: 1px solid var(--border);
            background: white;
            color: var(--text-dark);
        }

        .btn-outline:hover {
            background: var(--surface-hover);
        }

        .btn-locked {
            background: var(--surface);
            color: var(--text-muted);
            cursor: not-allowed;
            opacity: 0.6;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 0.2rem 0.8rem;
            border-radius: 30px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .status-completed {
            background: var(--success-light);
            color: #065f46;
        }

        .status-progress {
            background: var(--warning-light);
            color: #92400e;
        }

        .status-locked {
            background: var(--surface);
            color: var(--text-muted);
        }

        /* Current Module Focus */
        .current-focus {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 24px;
            padding: 2rem;
            margin-bottom: 2rem;
            color: white;
        }

        .current-focus h3 {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
        }

        .current-focus .module-name {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .current-focus .progress-big {
            max-width: 500px;
        }

        /* Resources Section */
        .resources-section {
            margin-bottom: 2rem;
        }

        .resources-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .resource-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 1.5rem;
            transition: var(--transition);
        }

        .resource-card:hover {
            box-shadow: var(--shadow-md);
        }

        .resource-icon {
            width: 50px;
            height: 50px;
            background: var(--primary-soft);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .resource-card h4 {
            font-size: 1.1rem;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .resource-card p {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 1rem;
        }

        /* Tips Section */
        .tips-section {
            background: var(--surface);
            border-radius: 20px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-left: 4px solid var(--primary);
        }

        .tips-section h4 {
            font-size: 1.1rem;
            margin-bottom: 1rem;
            color: var(--text-dark);
        }

        .tips-list {
            list-style: none;
        }

        .tips-list li {
            margin-bottom: 0.8rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .tips-list i {
            color: var(--primary);
        }

        /* Footer */
        .footer {
            background: white;
            border-top: 1px solid var(--border);
            padding: 2rem;
            margin-top: 3rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        @media (max-width: 900px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .timeline-item {
                flex-direction: column;
            }
            .timeline-actions {
                justify-content: flex-start;
            }
            .container {
                padding: 0 1rem;
            }
            .navbar {
                padding: 0 1rem;
            }
            .nav-links {
                display: none;
            }
            .footer {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .timeline-item {
            animation: slideIn 0.3s ease forwards;
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <a href="#" class="logo">
            <div class="logo-icon"><i class="fas fa-code"></i></div>
            Subbyte<span style="color:var(--primary);">Programmer's</span>
        </a>

        <ul class="nav-links">
            <li><a href="./dashboard.php"><i class="fas fa-th-large"></i> Dashboard</a></li>
            <li><a href="./courses.php"><i class="fas fa-book-open"></i> Courses</a></li>
            <li><a href="./mypath.php" class="active"><i class="fas fa-route"></i> My Path</a></li>
            <li><a href="#"><i class="fas fa-certificate"></i> Certificates</a></li>
            <li><a href="#"><i class="fas fa-comments"></i> Community</a></li>
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
        <!-- Hero Section -->
        <div class="hero">
            <h1>Your <span>Learning Journey</span> 🎯</h1>
            <p>From beginner to professional — one step at a time</p>
            <div class="overall-progress">
                <div class="progress-label">
                    <span>Overall Progress</span>
                    <span><?php echo round($overallProgress); ?>%</span>
                </div>
                <div class="progress-bar-big">
                    <div class="progress-fill-big" style="width: <?php echo $overallProgress; ?>%"></div>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                <div class="stat-number"><?php echo $completedModules; ?></div>
                <div class="stat-label">Completed Modules</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-clock"></i></div>
                <div class="stat-number"><?php echo $totalModules - $completedModules; ?></div>
                <div class="stat-label">Remaining Modules</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-fire"></i></div>
                <div class="stat-number">15</div>
                <div class="stat-label">Day Streak 🔥</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-trophy"></i></div>
                <div class="stat-number">3</div>
                <div class="stat-label">Certificates Earned</div>
            </div>
        </div>

        <!-- Current Focus Module -->
        <div class="current-focus">
            <h3><i class="fas fa-bolt"></i> Currently Learning</h3>
            <div class="module-name"><?php echo $currentModule; ?></div>
            <div class="progress-big">
                <div class="progress-label">
                    <span>Module Progress</span>
                    <span><?php echo $currentProgress; ?>%</span>
                </div>
                <div class="progress-bar-big" style="background: rgba(255,255,255,0.2);">
                    <div class="progress-fill-big" style="width: <?php echo $currentProgress; ?>%; background: white;"></div>
                </div>
            </div>
        </div>

        <!-- Learning Timeline -->
        <div class="timeline">
            <div class="timeline-header">
                <div class="timeline-title">
                    <i class="fas fa-road"></i> Your Learning Path
                </div>
                <div class="filter-buttons">
                    <button class="filter-btn active" data-filter="all">All</button>
                    <button class="filter-btn" data-filter="completed">Completed ✅</button>
                    <button class="filter-btn" data-filter="in_progress">In Progress 🔄</button>
                    <button class="filter-btn" data-filter="locked">Locked 🔒</button>
                </div>
            </div>

            <div class="timeline-items">
                <?php foreach($learningPath as $key => $module): ?>
                <div class="timeline-item <?php echo $module['status']; ?>" data-status="<?php echo $module['status']; ?>">
                    <div class="timeline-icon">
                        <i class="<?php echo $module['icon']; ?>"></i>
                    </div>
                    <div class="timeline-content">
                        <h3><?php echo $module['name']; ?></h3>
                        <div class="timeline-meta">
                            <span><i class="far fa-clock"></i> <?php echo $module['duration']; ?></span>
                            <?php if(isset($module['prerequisite'])): ?>
                            <span><i class="fas fa-lock"></i> Prerequisite: <?php echo $module['prerequisite']; ?></span>
                            <?php endif; ?>
                            <?php if($module['status'] == 'in_progress' && isset($module['start_date'])): ?>
                            <span><i class="far fa-calendar-alt"></i> Started: <?php echo date('M d', strtotime($module['start_date'])); ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <?php if($module['status'] == 'in_progress'): ?>
                        <div class="module-progress">
                            <div class="progress-text"><?php echo $module['progress']; ?>% Complete</div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: <?php echo $module['progress']; ?>%"></div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div style="margin-top: 0.5rem;">
                            <?php if($module['status'] == 'completed'): ?>
                            <span class="status-badge status-completed">
                                <i class="fas fa-check-circle"></i> Completed
                            </span>
                            <?php elseif($module['status'] == 'in_progress'): ?>
                            <span class="status-badge status-progress">
                                <i class="fas fa-spinner fa-pulse"></i> In Progress
                            </span>
                            <?php else: ?>
                            <span class="status-badge status-locked">
                                <i class="fas fa-lock"></i> Locked
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="timeline-actions">
                        <?php if($module['status'] == 'completed'): ?>
                            <a href="#" class="btn-action btn-outline">
                                <i class="fas fa-redo"></i> Review
                            </a>
                            <?php if(isset($module['certificate'])): ?>
                            <a href="#" class="btn-action btn-outline">
                                <i class="fas fa-certificate"></i> Certificate
                            </a>
                            <?php endif; ?>
                        <?php elseif($module['status'] == 'in_progress'): ?>
                            <a href="#" class="btn-action btn-primary">
                                <i class="fas fa-play"></i> Continue Learning
                            </a>
                        <?php else: ?>
                            <a href="#" class="btn-action btn-locked">
                                <i class="fas fa-lock"></i> Complete Previous First
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Resources for Current Module -->
        <div class="resources-section">
            <div class="timeline-title" style="margin-bottom: 1rem;">
                <i class="fas fa-book-open"></i> Recommended Resources
            </div>
            <div class="resources-grid">
                <div class="resource-card">
                    <div class="resource-icon"><i class="fas fa-video"></i></div>
                    <h4>Video Tutorials</h4>
                    <p>15+ hours of HD video content with practical examples</p>
                    <a href="#" class="btn-action btn-outline" style="width: 100%; text-align: center;">Watch Now →</a>
                </div>
                <div class="resource-card">
                    <div class="resource-icon"><i class="fas fa-code"></i></div>
                    <h4>Practice Exercises</h4>
                    <p>50+ coding challenges to master your skills</p>
                    <a href="#" class="btn-action btn-outline" style="width: 100%; text-align: center;">Start Practice →</a>
                </div>
                <div class="resource-card">
                    <div class="resource-icon"><i class="fas fa-users"></i></div>
                    <h4>Live Support</h4>
                    <p>24/7 doubt solving with expert mentors</p>
                    <a href="#" class="btn-action btn-outline" style="width: 100%; text-align: center;">Ask a Doubt →</a>
                </div>
            </div>
        </div>

        <!-- Pro Tips -->
        <div class="tips-section">
            <h4><i class="fas fa-lightbulb"></i> Pro Tips for Success</h4>
            <ul class="tips-list">
                <li><i class="fas fa-check-circle"></i> Complete modules in order — prerequisites matter!</li>
                <li><i class="fas fa-check-circle"></i> Practice at least 30 minutes daily to build momentum</li>
                <li><i class="fas fa-check-circle"></i> Join our community discord for peer support</li>
                <li><i class="fas fa-check-circle"></i> Don't skip quizzes — they help retain information</li>
                <li><i class="fas fa-check-circle"></i> Build real projects after each module</li>
            </ul>
        </div>
    </main>

    <div class="footer">
        <p>&copy; 2026 Subbyte Programming. All rights reserved.</p>
        <div class="footer-links">
            <a href="#">Privacy</a>
            <a href="#">Terms</a>
            <a href="#">Support</a>
        </div>
    </div>

    <script>
        // Filter functionality
        const filterBtns = document.querySelectorAll('.filter-btn');
        const timelineItems = document.querySelectorAll('.timeline-item');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all buttons
                filterBtns.forEach(b => b.classList.remove('active'));
                // Add active class to clicked button
                this.classList.add('active');
                
                const filter = this.getAttribute('data-filter');
                
                timelineItems.forEach(item => {
                    if(filter === 'all' || item.getAttribute('data-status') === filter) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    </script>

</body>
</html>