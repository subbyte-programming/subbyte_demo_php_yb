<?php
require 'config.php';
requireLogin();

$user = getCurrentUser();

// Load courses from JSON file with error handling
$coursesJson = @file_get_contents('courses.json');
if ($coursesJson === false) {
    $courses = []; // No courses file, show empty list
} else {
    $courses = json_decode($coursesJson, true) ?? [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Courses · Subbyte Programming</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ----- Same styles as your original dashboard ----- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --bg: #ffffff;
            --surface: #f9fafb;
            --surface-hover: #f2f4f8;
            --border: #e5e7eb;
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-soft: #dbeafe;
            --text-dark: #111827;
            --text-body: #374151;
            --text-muted: #6b7280;
            --green: #10b981;
            --orange: #f59e0b;
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
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        /* Navbar */
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
        .nav-links a:hover,
        .nav-links a.active {
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
        /* Page header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 2.5rem 0 1.5rem;
        }
        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-dark);
        }
        .page-title span {
            color: var(--primary);
        }
        .search-bar {
            display: flex;
            align-items: center;
            background: white;
            border: 1px solid var(--border);
            border-radius: 40px;
            padding: 0.3rem 0.3rem 0.3rem 1.2rem;
            box-shadow: var(--shadow);
        }
        .search-bar i {
            color: var(--text-muted);
        }
        .search-bar input {
            border: none;
            padding: 0.5rem 0.8rem;
            font-size: 0.9rem;
            min-width: 250px;
            outline: none;
            background: transparent;
        }
        .search-bar button {
            background: var(--primary);
            border: none;
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 40px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
        }
        .search-bar button:hover {
            background: var(--primary-dark);
        }
        /* Category filters */
        .filters {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 2rem;
        }
        .filter-chip {
            background: white;
            border: 1px solid var(--border);
            border-radius: 30px;
            padding: 0.5rem 1.2rem;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-body);
            cursor: pointer;
            transition: var(--transition);
        }
        .filter-chip:hover,
        .filter-chip.active {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }
        /* Course grid */
        .courses-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 3rem;
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
        /* Started badge & enrollment info */
        .started-badge {
            background: #10b981;
            color: white;
            padding: 0.2rem 0.8rem;
            border-radius: 30px;
            font-size: 0.7rem;
            font-weight: 600;
            margin-right: 0.5rem;
        }
        .enrolled-count {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 0.5rem;
        }
        .enrolled-count i {
            color: var(--primary);
            margin-right: 0.2rem;
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
        /* Responsive */
        @media (max-width: 1100px) {
            .courses-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 900px) {
            .page-header { flex-direction: column; align-items: start; gap: 1rem; }
            .search-bar { width: 100%; }
            .search-bar input { flex: 1; }
        }
        @media (max-width: 700px) {
            .navbar { padding: 0 1rem; }
            .nav-links { display: none; }
            .container { padding: 0 1rem; }
            .courses-grid { grid-template-columns: 1fr; }
            .footer { flex-direction: column; gap: 1rem; text-align: center; }
        }
    </style>
</head>
<body>

    <!-- Navbar (fixed link) -->
    <nav class="navbar">
        <a href="dashboard.php" class="logo">
            <div class="logo-icon"><i class="fas fa-code"></i></div>
            Subbyte<span style="color:var(--primary);">.</span>dev
        </a>

        <ul class="nav-links">
            <li><a href="dashboard.php"><i class="fas fa-th-large"></i> Dashboard</a></li>
            <li><a href="courses.php" class="active"><i class="fas fa-book-open"></i> Courses</a></li>  <!-- FIXED: href="courses.php" -->
            <li><a href="./mypath.php"><i class="fas fa-route"></i> My Path</a></li>
            <li><a href="certificates.php"><i class="fas fa-certificate"></i> Certificates</a></li>
            <li><a href="community.php"><i class="fas fa-comments"></i> Community</a></li>
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
        <!-- Page Header with Search -->
        <div class="page-header">
            <h1 class="page-title">📚 <span>All Courses</span></h1>
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search courses..." id="searchInput">
                <button id="searchBtn">Search</button>
            </div>
        </div>

        <!-- Category Filters (static for demo) -->
        <div class="filters">
            <span class="filter-chip active">All</span>
            <span class="filter-chip">Web Development</span>
            <span class="filter-chip">Data Science</span>
            <span class="filter-chip">Design</span>
            <span class="filter-chip">DevOps</span>
            <span class="filter-chip">AI & ML</span>
        </div>

        <!-- Courses Grid -->
        <div class="courses-grid">
            <?php if (empty($courses)): ?>
                <p style="grid-column: 1/-1; text-align: center; color: var(--text-muted);">No courses available at the moment.</p>
            <?php else: ?>
                <?php foreach ($courses as $course): ?>
                <div class="course-card">
                    <div class="cc-content">
                        <div class="cc-icon"><i class="fab <?php echo htmlspecialchars($course['icon']); ?>"></i></div>
                        <h3><?php echo htmlspecialchars($course['title']); ?></h3>
                        <p class="cc-desc"><?php echo htmlspecialchars($course['description']); ?></p>
                        <div class="cc-meta">
                            <span><i class="far fa-clock"></i> <?php echo $course['hours']; ?> hours</span>
                            <span><i class="fas fa-signal"></i> <?php echo $course['level']; ?></span>
                        </div>
                        <div class="cc-footer">
                            <div class="cc-rating">
                                <i class="fas fa-star"></i> <?php echo $course['rating']; ?> 
                                <small>(<?php echo number_format($course['reviews']); ?>)</small>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <?php if ($course['enrolled_count'] >= 10): ?>
                                    <span class="started-badge">🚀 Started</span>
                                <?php endif; ?>
                                <a href="course.php?slug=<?php echo urlencode($course['slug']); ?>" class="cc-btn">View</a>
                            </div>
                        </div>
                        <div class="enrolled-count">
                            <i class="fas fa-users"></i> <?php echo $course['enrolled_count']; ?> enrolled
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
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

    <!-- Simple search functionality -->
    <script>
        document.getElementById('searchBtn').addEventListener('click', function() {
            const query = document.getElementById('searchInput').value.toLowerCase();
            const cards = document.querySelectorAll('.course-card');
            cards.forEach(card => {
                const title = card.querySelector('h3').innerText.toLowerCase();
                if (title.includes(query)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Filter chips (simple UI only)
        document.querySelectorAll('.filter-chip').forEach(chip => {
            chip.addEventListener('click', function() {
                document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>