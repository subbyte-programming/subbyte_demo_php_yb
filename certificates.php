<?php
require 'config.php';
requireLogin();

$user = getCurrentUser();

// Fetch certificates from database (example data - replace with actual DB query)
$certificates = [
    [
        'id' => 1,
        'course_name' => 'Web Development Masterclass',
        'course_code' => 'WD-2024-001',
        'issue_date' => '2025-12-15',
        'expiry_date' => null,
        'grade' => 'A+',
        'score' => '98%',
        'credits' => 6,
        'instructor' => 'Prof. Sarah Khan',
        'image' => 'web_dev_cert.png',
        'skills' => ['HTML5', 'CSS3', 'JavaScript', 'React', 'Node.js'],
        'status' => 'verified'
    ],
    [
        'id' => 2,
        'course_name' => 'Python Programming Pro',
        'course_code' => 'PY-2024-002',
        'issue_date' => '2026-01-20',
        'expiry_date' => null,
        'grade' => 'A',
        'score' => '92%',
        'credits' => 5,
        'instructor' => 'Dr. Ahmed Raza',
        'image' => 'python_cert.png',
        'skills' => ['Python', 'OOP', 'Data Structures', 'File Handling'],
        'status' => 'verified'
    ],
    [
        'id' => 3,
        'course_name' => 'Database Management Systems',
        'course_code' => 'DB-2024-003',
        'issue_date' => '2026-02-10',
        'expiry_date' => null,
        'grade' => 'A-',
        'score' => '87%',
        'credits' => 4,
        'instructor' => 'Ms. Fatima Zaidi',
        'image' => 'db_cert.png',
        'skills' => ['SQL', 'MongoDB', 'Database Design', 'Normalization'],
        'status' => 'verified'
    ]
];

// Calculate statistics
$totalCertificates = count($certificates);
$totalCredits = array_sum(array_column($certificates, 'credits'));
$averageScore = round(array_sum(array_column($certificates, 'score')) / $totalCertificates, 1);

// Remove % sign for calculation
$averageScoreNum = round(array_sum(array_map(function($cert) {
    return (float)str_replace('%', '', $cert['score']);
}, $certificates)) / $totalCertificates, 1);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Certificates · Subbyte Programming</title>
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
            --gold: #f59e0b;
            --gold-light: #fed7aa;
            --text-dark: #111827;
            --text-body: #374151;
            --text-muted: #6b7280;
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-md: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 20px 25px -5px rgb(0 0 0 / 0.1);
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

        /* Navbar styles */
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
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 24px;
            padding: 3rem 2rem;
            margin: 2rem 0;
            color: white;
            text-align: center;
        }

        .hero h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .hero p {
            font-size: 1.1rem;
            opacity: 0.95;
        }

        .hero-stats {
            display: flex;
            justify-content: center;
            gap: 3rem;
            margin-top: 2rem;
        }

        .hero-stat {
            text-align: center;
        }

        .hero-stat .number {
            font-size: 2rem;
            font-weight: 700;
        }

        .hero-stat .label {
            font-size: 0.85rem;
            opacity: 0.9;
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

        /* Certificate Grid */
        .certificates-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 2rem 0 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .certificates-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .certificates-title i {
            color: var(--primary);
            margin-right: 10px;
        }

        .download-all {
            background: var(--primary);
            color: white;
            padding: 0.7rem 1.5rem;
            border-radius: 30px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
        }

        .download-all:hover {
            background: var(--primary-dark);
        }

        .certificates-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        /* Certificate Card */
        .certificate-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
            transition: var(--transition);
            position: relative;
        }

        .certificate-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }

        .certificate-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: var(--success-light);
            color: #065f46;
            padding: 0.3rem 0.8rem;
            border-radius: 30px;
            font-size: 0.7rem;
            font-weight: 600;
            z-index: 1;
        }

        .certificate-preview {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            padding: 2rem;
            text-align: center;
            border-bottom: 1px solid var(--border);
            position: relative;
            overflow: hidden;
        }

        .certificate-icon {
            font-size: 4rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .certificate-preview h3 {
            font-size: 1.3rem;
            color: var(--text-dark);
            margin-bottom: 0.3rem;
        }

        .certificate-code {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-family: monospace;
        }

        .certificate-details {
            padding: 1.5rem;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--border);
        }

        .detail-label {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .detail-value {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .skills-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin: 1rem 0;
        }

        .skill-tag {
            background: var(--primary-soft);
            color: var(--primary);
            padding: 0.2rem 0.6rem;
            border-radius: 15px;
            font-size: 0.7rem;
            font-weight: 500;
        }

        .certificate-actions {
            display: flex;
            gap: 0.8rem;
            margin-top: 1rem;
        }

        .btn-view, .btn-download, .btn-share {
            flex: 1;
            padding: 0.6rem;
            border-radius: 12px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            text-align: center;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-view {
            background: var(--primary);
            color: white;
        }

        .btn-view:hover {
            background: var(--primary-dark);
        }

        .btn-download {
            background: var(--surface);
            color: var(--text-dark);
            border: 1px solid var(--border);
        }

        .btn-download:hover {
            background: var(--surface-hover);
        }

        .btn-share {
            background: var(--surface);
            color: var(--text-dark);
            border: 1px solid var(--border);
        }

        .btn-share:hover {
            background: var(--surface-hover);
        }

        /* Achievement Section */
        .achievements-section {
            margin: 3rem 0;
        }

        .achievements-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 1rem;
        }

        .achievement-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 1.5rem;
            text-align: center;
            transition: var(--transition);
        }

        .achievement-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .achievement-icon {
            font-size: 2.5rem;
            color: var(--gold);
            margin-bottom: 1rem;
        }

        .achievement-card h4 {
            font-size: 1rem;
            color: var(--text-dark);
            margin-bottom: 0.3rem;
        }

        .achievement-card p {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        /* Share Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            border-radius: 24px;
            padding: 2rem;
            max-width: 500px;
            width: 90%;
            position: relative;
        }

        .modal-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-muted);
        }

        .social-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .social-btn {
            flex: 1;
            padding: 0.8rem;
            border-radius: 12px;
            text-decoration: none;
            text-align: center;
            color: white;
            font-weight: 500;
        }

        .facebook { background: #1877f2; }
        .twitter { background: #1da1f2; }
        .linkedin { background: #0077b5; }

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
        @media (max-width: 900px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .hero-stats {
                flex-direction: column;
                gap: 1rem;
            }
            .certificates-grid {
                grid-template-columns: 1fr;
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

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .certificate-card {
            animation: fadeInUp 0.4s ease forwards;
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
            <li><a href="./mypath.php"><i class="fas fa-route"></i> My Path</a></li>
            <li><a href="./certificate.php" class="active"><i class="fas fa-certificate"></i> Certificates</a></li>
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
            <h1>🏆 Your Achievements</h1>
            <p>Proud moments of your learning journey at Subbyte Programming</p>
            <div class="hero-stats">
                <div class="hero-stat">
                    <div class="number"><?php echo $totalCertificates; ?></div>
                    <div class="label">Certificates Earned</div>
                </div>
                <div class="hero-stat">
                    <div class="number"><?php echo $totalCredits; ?></div>
                    <div class="label">Total Credits</div>
                </div>
                <div class="hero-stat">
                    <div class="number"><?php echo $averageScoreNum; ?>%</div>
                    <div class="label">Average Score</div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-star"></i></div>
                <div class="stat-number">A+</div>
                <div class="stat-label">Highest Grade</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-clock"></i></div>
                <div class="stat-number">156</div>
                <div class="stat-label">Learning Hours</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-trophy"></i></div>
                <div class="stat-number">Top 5%</div>
                <div class="stat-label">Global Rank</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-shield-alt"></i></div>
                <div class="stat-number">Blockchain</div>
                <div class="stat-label">Verified</div>
            </div>
        </div>

        <!-- Certificates Section -->
        <div class="certificates-header">
            <div class="certificates-title">
                <i class="fas fa-certificate"></i> My Certificates
            </div>
            <a href="#" class="download-all" id="downloadAllBtn">
                <i class="fas fa-download"></i> Download All
            </a>
        </div>

        <div class="certificates-grid">
            <?php foreach($certificates as $cert): ?>
            <div class="certificate-card" data-id="<?php echo $cert['id']; ?>">
                <div class="certificate-badge">
                    <i class="fas fa-check-circle"></i> Verified
                </div>
                <div class="certificate-preview">
                    <div class="certificate-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3><?php echo htmlspecialchars($cert['course_name']); ?></h3>
                    <div class="certificate-code"><?php echo $cert['course_code']; ?></div>
                </div>
                <div class="certificate-details">
                    <div class="detail-row">
                        <span class="detail-label">Issue Date</span>
                        <span class="detail-value"><?php echo date('F d, Y', strtotime($cert['issue_date'])); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Grade</span>
                        <span class="detail-value"><?php echo $cert['grade']; ?> (<?php echo $cert['score']; ?>)</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Credits</span>
                        <span class="detail-value"><?php echo $cert['credits']; ?> Credit Hours</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Instructor</span>
                        <span class="detail-value"><?php echo $cert['instructor']; ?></span>
                    </div>
                    
                    <div class="skills-list">
                        <?php foreach($cert['skills'] as $skill): ?>
                        <span class="skill-tag"><?php echo $skill; ?></span>
                        <?php endforeach; ?>
                    </div>

                    <div class="certificate-actions">
                        <a href="#" class="btn-view view-certificate" data-id="<?php echo $cert['id']; ?>">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="#" class="btn-download download-certificate" data-id="<?php echo $cert['id']; ?>">
                            <i class="fas fa-download"></i> PDF
                        </a>
                        <a href="#" class="btn-share share-certificate" data-id="<?php echo $cert['id']; ?>">
                            <i class="fas fa-share-alt"></i> Share
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Achievements Section -->
        <div class="achievements-section">
            <div class="certificates-title" style="margin-bottom: 1rem;">
                <i class="fas fa-medal"></i> Special Achievements
            </div>
            <div class="achievements-grid">
                <div class="achievement-card">
                    <div class="achievement-icon"><i class="fas fa-rocket"></i></div>
                    <h4>Early Bird 🚀</h4>
                    <p>Completed first course within 30 days</p>
                </div>
                <div class="achievement-card">
                    <div class="achievement-icon"><i class="fas fa-fire"></i></div>
                    <h4>30 Day Streak 🔥</h4>
                    <p>Learned continuously for 30 days</p>
                </div>
                <div class="achievement-card">
                    <div class="achievement-icon"><i class="fas fa-brain"></i></div>
                    <h4>Perfect Score 🎯</h4>
                    <p>Got 100% in final assessment</p>
                </div>
                <div class="achievement-card">
                    <div class="achievement-icon"><i class="fas fa-hand-sparkles"></i></div>
                    <h4>Community Hero 🌟</h4>
                    <p>Helped 50+ students in forums</p>
                </div>
            </div>
        </div>

        <!-- Verification Note -->
        <div style="background: var(--primary-soft); border-radius: 16px; padding: 1rem; text-align: center; margin-top: 1rem;">
            <i class="fas fa-shield-alt" style="color: var(--primary); margin-right: 8px;"></i>
            All certificates are blockchain-verified and can be shared on LinkedIn, CV, or portfolio.
        </div>
    </main>

    <!-- Share Modal -->
    <div id="shareModal" class="modal">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <h3 style="margin-bottom: 1rem;">Share Your Achievement 🎉</h3>
            <p style="margin-bottom: 1rem;">Share your certificate with your network!</p>
            <div class="social-buttons">
                <a href="#" class="social-btn facebook" id="shareFacebook">
                    <i class="fab fa-facebook"></i> Facebook
                </a>
                <a href="#" class="social-btn twitter" id="shareTwitter">
                    <i class="fab fa-twitter"></i> Twitter
                </a>
                <a href="#" class="social-btn linkedin" id="shareLinkedin">
                    <i class="fab fa-linkedin"></i> LinkedIn
                </a>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2026 Subbyte Programming. All rights reserved.</p>
        <div class="footer-links">
            <a href="#">Privacy</a>
            <a href="#">Terms</a>
            <a href="#">Support</a>
        </div>
    </div>

    <script>
        // Modal functionality
        const modal = document.getElementById('shareModal');
        const closeBtn = document.querySelector('.modal-close');
        let currentCertificateId = null;

        // Share functionality
        document.querySelectorAll('.share-certificate').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                currentCertificateId = btn.getAttribute('data-id');
                modal.style.display = 'flex';
            });
        });

        closeBtn.onclick = () => {
            modal.style.display = 'none';
        };

        window.onclick = (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        };

        // Share buttons
        document.getElementById('shareFacebook').onclick = (e) => {
            e.preventDefault();
            window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href), '_blank');
        };

        document.getElementById('shareTwitter').onclick = (e) => {
            e.preventDefault();
            window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent('I just earned a certificate from Subbyte Programming! 🎉'), '_blank');
        };

        document.getElementById('shareLinkedin').onclick = (e) => {
            e.preventDefault();
            window.open('https://www.linkedin.com/sharing/share-offsite/?url=' + encodeURIComponent(window.location.href), '_blank');
        };

        // View certificate (preview)
        document.querySelectorAll('.view-certificate').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                alert('Certificate preview will open in new window.\n\nIn production, this would show the full certificate PDF/image.');
            });
        });

        // Download certificate
        document.querySelectorAll('.download-certificate').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                alert('Download started!\n\nIn production, this would download the PDF certificate.');
            });
        });

        // Download all
        document.getElementById('downloadAllBtn').addEventListener('click', (e) => {
            e.preventDefault();
            alert('Preparing ZIP file with all certificates...\n\nIn production, this would download all certificates as a ZIP.');
        });
    </script>

</body>
</html>