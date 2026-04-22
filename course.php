<?php
require 'config.php';
requireLogin();

$user = getCurrentUser();  // must return array with 'id' key
$slug = $_GET['slug'] ?? '';

if (empty($slug)) {
    die("Invalid course");
}

/* =========================
   LOAD COURSES SAFELY
========================= */
$courses = [];

if (file_exists('courses.json')) {
    $coursesJson = file_get_contents('courses.json');
    $decoded = json_decode($coursesJson, true);

    if (is_array($decoded)) {
        $courses = $decoded;
    }
}

if (empty($courses)) {
    die("No courses available");
}

/* =========================
   FIND COURSE BY SLUG
========================= */
$course = null;
$courseIndex = null;

foreach ($courses as $index => $c) {
    if (isset($c['slug']) && $c['slug'] === $slug) {
        $course = $c;
        $courseIndex = $index;
        break;
    }
}

if (!$course) {
    die("Course not found");
}

/* =========================
   LOAD ENROLLMENTS SAFELY
========================= */
$enrollments = [];

if (file_exists('enrollments.json')) {
    $decoded = json_decode(file_get_contents('enrollments.json'), true);

    if (is_array($decoded)) {
        $enrollments = $decoded;
    }
}

/* =========================
   CHECK IF USER ENROLLED
========================= */
$userEnrolled = false;

foreach ($enrollments as $e) {
    if (
        isset($e['user_id'], $e['course_id']) &&
        $e['user_id'] == $user['id'] &&
        $e['course_id'] == $course['id']
    ) {
        $userEnrolled = true;
        break;
    }
}

/* =========================
   HANDLE ENROLLMENT
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enroll'])) {

    if (!$userEnrolled && $course['enrolled_count'] < 10) {

        // Add enrollment
        $enrollments[] = [
            'user_id'     => $user['id'],
            'course_id'   => $course['id'],
            'enrolled_at' => date('Y-m-d H:i:s')
        ];

        file_put_contents(
            'enrollments.json',
            json_encode($enrollments, JSON_PRETTY_PRINT),
            LOCK_EX
        );

        // Increase course count
        $course['enrolled_count']++;
        $courses[$courseIndex]['enrolled_count'] = $course['enrolled_count'];

        file_put_contents(
            'courses.json',
            json_encode($courses, JSON_PRETTY_PRINT),
            LOCK_EX
        );

        header("Location: course.php?slug=" . urlencode($slug));
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($course['title']); ?> · Subbyte</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Copy the same base styles from courses.php (or include a shared file) */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --bg: #ffffff;
            --surface: #f9fafb;
            --border: #e5e7eb;
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-soft: #dbeafe;
            --text-dark: #111827;
            --text-body: #374151;
            --text-muted: #6b7280;
            --green: #10b981;
            --orange: #f59e0b;
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
        /* Navbar (copy from courses.php) */
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
        /* Course detail specific */
        .course-detail {
            max-width: 900px;
            margin: 2rem auto;
            background: white;
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: var(--shadow-md);
        }
        .course-header {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .course-icon-large {
            width: 80px; height: 80px;
            background: var(--primary-soft);
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            font-size: 2.5rem;
            color: var(--primary);
        }
        .course-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--text-dark);
        }
        .meta-row {
            display: flex;
            gap: 2rem;
            margin: 1.5rem 0;
            padding: 1rem 0;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }
        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-muted);
        }
        .meta-item i {
            color: var(--primary);
            width: 20px;
        }
        .enrollment-status {
            background: var(--surface);
            border-radius: 16px;
            padding: 2rem;
            margin: 2rem 0;
            text-align: center;
        }
        .enroll-progress {
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }
        .progress-bar {
            background: #e0e7ff;
            height: 10px;
            border-radius: 10px;
            margin: 1rem 0;
            overflow: hidden;
        }
        .progress-fill {
            background: var(--primary);
            height: 100%;
            width: <?php echo min(100, ($course['enrolled_count'] / 10) * 100); ?>%;
            border-radius: 10px;
        }
        .status-badge {
            display: inline-block;
            padding: 0.3rem 1.2rem;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.9rem;
        }
        .status-started { background: #10b981; color: white; }
        .status-full { background: #f59e0b; color: white; }
        .status-open { background: var(--primary-soft); color: var(--primary); }
        .enroll-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.8rem 2.5rem;
            border-radius: 40px;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 1rem;
        }
        .enroll-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        .enroll-btn:hover:not(:disabled) {
            background: var(--primary-dark);
        }
        .back-link {
            display: inline-block;
            margin-bottom: 1rem;
            color: var(--primary);
            text-decoration: none;
        }
        .back-link i {
            margin-right: 0.5rem;
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
    </style>
</head>
<body>

    <!-- Navbar (same as courses.php) -->
    <nav class="navbar">
        <a href="dashboard.php" class="logo">
            <div class="logo-icon"><i class="fas fa-code"></i></div>
            Subbyte<span style="color:var(--primary);">.</span>dev
        </a>

        <ul class="nav-links">
            <li><a href="dashboard.php"><i class="fas fa-th-large"></i> Dashboard</a></li>
            <li><a href="courses.php" class="active"><i class="fas fa-book-open"></i> Courses</a></li>
            <li><a href="path.php"><i class="fas fa-route"></i> My Path</a></li>
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
        <a href="courses.php" class="back-link"><i class="fas fa-arrow-left"></i> Back to Courses</a>

        <div class="course-detail">
            <div class="course-header">
                <div class="course-icon-large">
                    <i class="fab <?php echo htmlspecialchars($course['icon']); ?>"></i>
                </div>
                <h1 class="course-title"><?php echo htmlspecialchars($course['title']); ?></h1>
            </div>

            <p style="font-size: 1.1rem; line-height: 1.6;"><?php echo nl2br(htmlspecialchars($course['description'])); ?></p>

            <div class="meta-row">
                <span class="meta-item"><i class="far fa-clock"></i> <?php echo $course['hours']; ?> hours</span>
                <span class="meta-item"><i class="fas fa-signal"></i> <?php echo $course['level']; ?></span>
                <span class="meta-item"><i class="fas fa-star" style="color: #f59e0b;"></i> <?php echo $course['rating']; ?> (<?php echo number_format($course['reviews']); ?> reviews)</span>
            </div>

            <div class="enrollment-status">
                <div class="enroll-progress">
                    <strong><?php echo $course['enrolled_count']; ?> / 10</strong> students enrolled
                </div>
                <div class="progress-bar">
                    <div class="progress-fill"></div>
                </div>

                <?php
                if ($userEnrolled) {
                    echo '<p style="color: var(--green); font-weight: 600; margin-top: 1rem;">✅ You are enrolled in this course.</p>';
                } elseif ($course['enrolled_count'] >= 10) {
                    echo '<span class="status-badge status-started" style="margin: 1rem 0;">Course Started</span>';
                    echo '<p style="color: var(--orange); margin-top: 1rem;">Enrollments are closed because the course has started.</p>';
                } else {
                    $seatsLeft = 10 - $course['enrolled_count'];
                    echo '<span class="status-badge status-open">' . $seatsLeft . ' seat' . ($seatsLeft > 1 ? 's' : '') . ' left</span>';
                    echo '<form method="post" style="margin-top: 1.5rem;">';
                    echo '<button type="submit" name="enroll" class="enroll-btn">Enroll Now</button>';
                    echo '</form>';
                }
                ?>
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