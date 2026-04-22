<?php require 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subbyte Solution | Best Programming Hub</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            overflow-x: hidden;
            position: relative;
        }
        
        /* Animated Background */
        body::before {
            content: '';
            position: fixed;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.05) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: bgMove 20s linear infinite;
            pointer-events: none;
        }
        
        @keyframes bgMove {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }
        
        /* Floating Orbs */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.3;
            animation: float 15s infinite ease-in-out;
            z-index: 0;
        }
        
        .orb-1 {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, #667eea, #764ba2);
            top: -200px;
            left: -200px;
        }
        
        .orb-2 {
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, #f093fb, #f5576c);
            bottom: -250px;
            right: -250px;
            animation-delay: -5s;
        }
        
        .orb-3 {
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, #4facfe, #00f2fe);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: -10s;
        }
        
        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -30px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }
        
        /* Main Container */
        .main-container {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            backdrop-filter: blur(2px);
        }
        
        /* Left Section - Hero */
        .hero-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px 40px;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .hero-content {
            max-width: 600px;
            text-align: center;
            animation: fadeInUp 1s ease-out;
        }
        
        .brand-icon {
            font-size: 100px;
            margin-bottom: 30px;
            background: linear-gradient(135deg, #667eea, #764ba2, #f093fb);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: pulse 2s infinite;
        }
        
        .brand-name {
            font-size: 56px;
            font-weight: 900;
            margin-bottom: 15px;
            background: linear-gradient(135deg, #fff, #667eea, #f093fb);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            letter-spacing: -1px;
        }
        
        .brand-tagline {
            font-size: 20px;
            color: rgba(255,255,255,0.9);
            margin-bottom: 30px;
        }
        
        .contact-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 25px;
            margin-top: 40px;
            border: 1px solid rgba(255,255,255,0.2);
            transition: all 0.3s;
        }
        
        .contact-card:hover {
            transform: translateY(-5px);
            background: rgba(255,255,255,0.15);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }
        
        .contact-title {
            font-size: 18px;
            margin-bottom: 15px;
            color: #f093fb;
        }
        
        .contact-number {
            font-size: 32px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        .contact-number i {
            background: #10b981;
            padding: 12px;
            border-radius: 50%;
            font-size: 20px;
        }
        
        .contact-number a {
            color: white;
            text-decoration: none;
            transition: 0.3s;
        }
        
        .contact-number a:hover {
            color: #f093fb;
            transform: scale(1.05);
        }
        
        .availability {
            margin-top: 15px;
            font-size: 14px;
            color: #10b981;
        }
        
        /* Stats Grid */
        .stats-grid {
            display: flex;
            gap: 40px;
            margin-top: 50px;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .stat-box {
            text-align: center;
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(10px);
            padding: 20px 30px;
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.1);
            transition: 0.3s;
        }
        
        .stat-box:hover {
            transform: translateY(-5px);
            background: rgba(255,255,255,0.1);
            border-color: #667eea;
        }
        
        .stat-number {
            font-size: 48px;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea, #f093fb);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .stat-label {
            font-size: 14px;
            margin-top: 10px;
            color: rgba(255,255,255,0.7);
        }
        
        /* Right Section - Form/Content */
        .form-section {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 60px 40px;
        }
        
        .glass-card {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            border-radius: 40px;
            padding: 50px 40px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 25px 50px rgba(0,0,0,0.3);
            animation: slideInRight 0.8s ease-out;
            border: 1px solid rgba(255,255,255,0.3);
        }
        
        .card-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .card-logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 36px;
            color: white;
            animation: rotate 10s infinite linear;
        }
        
        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .card-title {
            font-size: 32px;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 10px;
        }
        
        .card-subtitle {
            color: #64748b;
            font-size: 16px;
        }
        
        /* Message Styles */
        .message {
            padding: 20px;
            border-radius: 20px;
            margin-bottom: 30px;
            animation: slideDown 0.5s ease-out;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .success {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
            border-left: 5px solid #10b981;
        }
        
        .error {
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            color: #991b1b;
            border-left: 5px solid #ef4444;
        }
        
        .info {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #1e40af;
            border-left: 5px solid #3b82f6;
        }
        
        /* Welcome Message */
        .welcome-card {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 30px;
            color: white;
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .welcome-icon {
            font-size: 48px;
        }
        
        .welcome-text strong {
            font-size: 20px;
            display: block;
            margin-bottom: 5px;
        }
        
        /* Buttons */
        .btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 18px 30px;
            border-radius: 50px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s;
            width: 100%;
            border: none;
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 10px 20px rgba(102,126,234,0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(102,126,234,0.5);
        }
        
        .btn-secondary {
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
        }
        
        .btn-secondary:hover {
            background: #667eea;
            color: white;
            transform: translateY(-3px);
        }
        
        .btn-outline {
            background: transparent;
            color: #667eea;
            border: 2px solid #667eea;
        }
        
        .btn-outline:hover {
            background: #667eea;
            color: white;
        }
        
        /* Buttons Container */
        .buttons-group {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 30px;
        }
        
        /* Features Grid */
        .features {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 30px;
        }
        
        .feature {
            background: #f8fafc;
            border-radius: 15px;
            padding: 15px;
            text-align: center;
            transition: 0.3s;
            cursor: pointer;
        }
        
        .feature:hover {
            transform: translateY(-5px);
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }
        
        .feature:hover .feature-icon {
            color: white;
        }
        
        .feature-icon {
            font-size: 28px;
            color: #667eea;
            margin-bottom: 10px;
        }
        
        .feature-text {
            font-weight: 600;
            font-size: 14px;
        }
        
        /* Footer */
        .footer {
            margin-top: 40px;
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid #e2e8f0;
            font-size: 14px;
            color: #94a3b8;
        }
        
        .footer-links {
            margin-top: 15px;
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        
        .footer-links a {
            color: #667eea;
            text-decoration: none;
            transition: 0.3s;
        }
        
        .footer-links a:hover {
            color: #764ba2;
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .main-container {
                flex-direction: column;
            }
            
            .hero-section {
                padding: 40px 20px;
            }
            
            .brand-name {
                font-size: 42px;
            }
            
            .contact-number {
                font-size: 24px;
            }
            
            .glass-card {
                margin: 20px;
                padding: 40px 30px;
            }
        }
        
        @media (max-width: 768px) {
            .brand-name {
                font-size: 32px;
            }
            
            .stats-grid {
                gap: 20px;
            }
            
            .stat-box {
                padding: 15px 20px;
            }
            
            .features {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Floating Orbs -->
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
    
    <div class="main-container">
        <!-- Left Side - Hero Section -->
        <div class="hero-section">
            <div class="hero-content">
                <div class="brand-icon">
                    <i class="fas fa-laptop-code"></i>
                </div>
                <h1 class="brand-name">Subbyte Solution</h1>
                <p class="brand-tagline">Transform Your Ideas into Reality with Code</p>
                
                <!-- Contact Card -->
                <div class="contact-card">
                    <div class="contact-title">
                        <i class="fas fa-headset"></i> 24/7 Support & Consultation
                    </div>
                    <div class="contact-number">
                        <i class="fab fa-whatsapp"></i>
                        <a href="tel:03190306199">0319 0306199</a>
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="availability">
                        <i class="fas fa-check-circle"></i> Available on WhatsApp, Call & SMS
                    </div>
                </div>
                
                <!-- Stats -->
                <div class="stats-grid">
                    <div class="stat-box">
                        <div class="stat-number"><?php echo count(getUsers()); ?>+</div>
                        <div class="stat-label">Happy Students</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Projects Completed</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-number">4.9★</div>
                        <div class="stat-label">Rating</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Side - Form Section -->
        <div class="form-section">
            <div class="glass-card">
                <div class="card-header">
                    <div class="card-logo">
                        <i class="fas fa-code"></i>
                    </div>
                    <h2 class="card-title">Subbyte Solution</h2>
                    <p class="card-subtitle">Your Coding Journey Starts Here</p>
                </div>
                
                <?php if (isLoggedIn()): ?>
                    <!-- Logged In User -->
                    <div class="welcome-card">
                        <div class="welcome-icon">
                            <i class="fas fa-user-astronaut"></i>
                        </div>
                        <div class="welcome-text">
                            <strong>Welcome back, <?php echo $_SESSION['user_name']; ?>!</strong>
                            Ready to code something amazing today?
                        </div>
                    </div>
                    
                    <div class="buttons-group">
                        <a href="dashboard.php" class="btn btn-primary">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                        <a href="logout.php" class="btn btn-outline">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                    
                    <div class="features">
                        <div class="feature">
                            <div class="feature-icon"><i class="fas fa-book"></i></div>
                            <div class="feature-text">Continue Learning</div>
                        </div>
                        <div class="feature">
                            <div class="feature-icon"><i class="fas fa-project-diagram"></i></div>
                            <div class="feature-text">My Projects</div>
                        </div>
                        <div class="feature">
                            <div class="feature-icon"><i class="fas fa-trophy"></i></div>
                            <div class="feature-text">Achievements</div>
                        </div>
                        <div class="feature">
                            <div class="feature-icon"><i class="fas fa-certificate"></i></div>
                            <div class="feature-text">Certificates</div>
                        </div>
                    </div>
                    
                <?php else: ?>
                    <!-- Not Logged In -->
                    <?php
                    if (isset($_GET['success']) && $_GET['success'] == '1') {
                        echo '<div class="message success">
                                <i class="fas fa-check-circle" style="font-size: 24px;"></i>
                                <div><strong>Registration Successful!</strong><br>Your account has been created. Login now!</div>
                              </div>';
                    }
                    
                    if (isset($_GET['logout']) && $_GET['logout'] == '1') {
                        echo '<div class="message info">
                                <i class="fas fa-waveform"></i>
                                <div><strong>Logged Out!</strong><br>See you soon, keep coding!</div>
                              </div>';
                    }
                    ?>
                    
                    <div class="buttons-group">
                        <a href="register.php" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i> Create Account
                        </a>
                        <a href="login.php" class="btn btn-secondary">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </div>
                    
                    <div class="features">
                        <div class="feature">
                            <div class="feature-icon"><i class="fas fa-graduation-cap"></i></div>
                            <div class="feature-text">Learn Coding</div>
                        </div>
                        <div class="feature">
                            <div class="feature-icon"><i class="fas fa-users"></i></div>
                            <div class="feature-text">Community</div>
                        </div>
                        <div class="feature">
                            <div class="feature-icon"><i class="fas fa-briefcase"></i></div>
                            <div class="feature-text">Job Ready</div>
                        </div>
                        <div class="feature">
                            <div class="feature-icon"><i class="fas fa-headset"></i></div>
                            <div class="feature-text">24/7 Support</div>
                        </div>
                    </div>
                    
                    <div style="margin-top: 30px; padding: 20px; background: linear-gradient(135deg, #667eea10, #764ba210); border-radius: 20px; text-align: center;">
                        <i class="fas fa-phone-alt" style="color: #667eea; margin-right: 10px;"></i>
                        <strong>Need Help?</strong> Call us: <a href="tel:03190306199" style="color: #667eea; text-decoration: none;">0319 0306199</a>
                    </div>
                    
                <?php endif; ?>
                
                <div class="footer">
                    <p>© <?php echo date('Y'); ?> Subbyte Solution. All rights reserved.</p>
                    <div class="footer-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-github"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Animate counters on load
        document.addEventListener('DOMContentLoaded', function() {
            const counters = document.querySelectorAll('.stat-number');
            counters.forEach(counter => {
                const text = counter.textContent;
                const number = parseInt(text);
                if (!isNaN(number)) {
                    animateNumber(counter, number);
                }
            });
        });
        
        function animateNumber(element, target) {
            let current = 0;
            const increment = target / 50;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    element.textContent = target + (element.textContent.includes('+') ? '+' : '');
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(current) + (element.textContent.includes('+') ? '+' : '');
                }
            }, 20);
        }
        
        // Add hover sound effect (just for fun)
        const buttons = document.querySelectorAll('.btn, .feature');
        buttons.forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(0.98)';
            });
            btn.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>