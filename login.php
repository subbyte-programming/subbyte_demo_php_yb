<?php
require 'config.php';

if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    // Validation
    if (empty($email) || empty($password)) {
        $error = 'Email and password are required';
    } else {
        // Login user
        if (loginUser($email, $password)) {
            header('Location: dashboard.php');
            exit();
        } else {
            $error = 'Invalid email or password';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Subbyte Programming</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            background-color: #f8fafc;
            overflow-x: hidden;
        }
        
        /* Background Image Section */
        .background-section {
            flex: 1;
            background-image: url('https://images.unsplash.com/photo-1515879218367-8466d910aaa4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1169&q=80');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            color: white;
        }
        
        .background-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(86, 98, 210, 0.9) 0%, rgba(56, 142, 60, 0.9) 100%);
            z-index: 1;
        }
        
        .background-content {
            position: relative;
            z-index: 2;
            max-width: 600px;
            text-align: center;
            animation: fadeInUp 1s ease-out;
        }
        
        .logo-large {
            font-size: 80px;
            margin-bottom: 20px;
            color: white;
            animation: pulse 2s infinite;
        }
        
        .background-title {
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        
        .background-text {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 30px;
            opacity: 0.9;
        }
        
        .testimonials {
            margin-top: 40px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 25px;
            text-align: left;
        }
        
        .testimonial-item {
            margin-bottom: 20px;
        }
        
        .testimonial-text {
            font-style: italic;
            margin-bottom: 10px;
            font-size: 16px;
        }
        
        .testimonial-author {
            display: flex;
            align-items: center;
        }
        
        .author-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            color: #667eea;
            font-weight: bold;
        }
        
        .author-name {
            font-weight: 600;
        }
        
        /* Login Form Section */
        .form-section {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
            background-color: white;
            overflow-y: auto;
        }
        
        .form-container {
            max-width: 450px;
            width: 100%;
            animation: slideInRight 0.8s ease-out;
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .form-logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            margin-bottom: 20px;
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        
        .form-logo i {
            font-size: 32px;
            color: white;
        }
        
        .form-title {
            color: #1e293b;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .form-subtitle {
            color: #64748b;
            font-size: 16px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        label {
            display: block;
            margin-bottom: 10px;
            color: #475569;
            font-weight: 600;
            font-size: 15px;
        }
        
        .input-container {
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .input-icon {
            position: absolute;
            left: 16px;
            color: #667eea;
            font-size: 18px;
            z-index: 2;
        }
        
        input {
            width: 100%;
            padding: 16px 16px 16px 50px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s;
            background-color: white;
        }
        
        input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }
        
        .password-toggle {
            position: relative;
        }
        
        .toggle-btn {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            font-size: 18px;
            transition: color 0.3s;
            z-index: 2;
        }
        
        .toggle-btn:hover {
            color: #667eea;
        }
        
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
        }
        
        .remember-checkbox {
            width: 18px;
            height: 18px;
            margin-right: 8px;
            border-radius: 4px;
            border: 2px solid #cbd5e1;
            cursor: pointer;
            position: relative;
            transition: all 0.3s;
        }
        
        .remember-checkbox.checked {
            background-color: #667eea;
            border-color: #667eea;
        }
        
        .remember-checkbox.checked::after {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 10px;
        }
        
        .remember-text {
            font-size: 14px;
            color: #64748b;
            cursor: pointer;
        }
        
        .forgot-password {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: color 0.3s;
        }
        
        .forgot-password:hover {
            color: #5a6fd8;
            text-decoration: underline;
        }
        
        .btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 17px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
            position: relative;
            overflow: hidden;
        }
        
        .btn i {
            margin-right: 10px;
            font-size: 20px;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.3);
        }
        
        .btn:active {
            transform: translateY(-1px);
        }
        
        .btn::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.7s;
        }
        
        .btn:hover::after {
            left: 100%;
        }
        
        .social-login {
            margin-top: 30px;
            text-align: center;
        }
        
        .social-title {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 15px;
            position: relative;
        }
        
        .social-title::before, .social-title::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 30%;
            height: 1px;
            background-color: #e2e8f0;
        }
        
        .social-title::before {
            left: 0;
        }
        
        .social-title::after {
            right: 0;
        }
        
        .social-buttons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .social-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 14px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .social-btn i {
            margin-right: 10px;
            font-size: 18px;
        }
        
        .google-btn {
            background-color: #f8fafc;
            color: #1e293b;
            border: 2px solid #e2e8f0;
        }
        
        .google-btn:hover {
            background-color: #f1f5f9;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }
        
        .facebook-btn {
            background-color: #1877f2;
            color: white;
            border: 2px solid #1877f2;
        }
        
        .facebook-btn:hover {
            background-color: #166fe5;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(24, 119, 242, 0.2);
        }
        
        .links {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .link-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            padding: 14px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
            text-align: center;
        }
        
        .link-btn i {
            margin-right: 10px;
        }
        
        .home-btn {
            background-color: #f1f5f9;
            color: #1e293b;
        }
        
        .home-btn:hover {
            background-color: #e2e8f0;
            transform: translateY(-2px);
        }
        
        .register-btn {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            color: #667eea;
            border: 2px solid #667eea;
        }
        
        .register-btn:hover {
            background: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.1);
        }
        
        .message {
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 25px;
            animation: slideDown 0.5s ease-out;
        }
        
        .error {
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            color: #991b1b;
            border-left: 5px solid #ef4444;
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
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
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }
        
        /* Responsive Design */
        @media (max-width: 1024px) {
            body {
                flex-direction: column;
            }
            
            .background-section {
                min-height: 300px;
                padding: 30px 20px;
            }
            
            .background-title {
                font-size: 32px;
            }
            
            .form-section {
                padding: 30px 20px;
            }
        }
        
        @media (max-width: 768px) {
            .background-title {
                font-size: 28px;
            }
            
            .background-text {
                font-size: 16px;
            }
            
            .form-title {
                font-size: 28px;
            }
            
            .social-buttons {
                flex-direction: column;
            }
        }
        
        @media (max-width: 480px) {
            .background-section {
                min-height: 250px;
            }
            
            .background-title {
                font-size: 24px;
            }
            
            .form-title {
                font-size: 24px;
            }
            
            .btn, .link-btn, .social-btn {
                padding: 16px;
            }
        }
    </style>
</head>
<body>
    <!-- Left Side - Background Image with Content -->
    <div class="background-section">
        <div class="background-overlay"></div>
        <div class="background-content">
            <div class="logo-large">
                <i class="fas fa-code"></i>
            </div>
            <h1 class="background-title">Welcome Back to Subbyte Programming</h1>
            <p class="background-text">Continue your coding journey with access to thousands of tutorials, projects, and a supportive community of developers.</p>
            
            <div class="testimonials">
                <div class="testimonial-item">
                    <p class="testimonial-text">"Subbyte Programming transformed my coding skills. The tutorials are clear and the community is incredibly supportive!"</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">AS</div>
                        <div>
                            <div class="author-name">Samm</div>
                            <div style="font-size: 14px; opacity: 0.8;">Full Stack Developer</div>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-item">
                    <p class="testimonial-text">"I landed my first developer job thanks to the projects and certifications from Subbyte Programming. Highly recommended!"</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">MJ</div>
                        <div>
                            <div class="author-name">Maria Johnson</div>
                            <div style="font-size: 14px; opacity: 0.8;">Frontend Developer</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Right Side - Login Form -->
    <div class="form-section">
        <div class="form-container">
            <div class="form-header">
                <div class="form-logo">
                    <i class="fas fa-sign-in-alt"></i>
                </div>
                <h1 class="form-title">Welcome Back</h1>
                <p class="form-subtitle">Sign in to your account to continue</p>
            </div>
            
            <?php if ($error): ?>
                <div class="message error">
                    <strong>Error:</strong> <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="" id="loginForm">
                <div class="form-group">
                    <label>Email Address</label>
                    <div class="input-container">
                        <div class="input-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <input type="email" name="email" placeholder="Enter your email address" required>
                    </div>
                </div>
                
                <div class="form-group password-toggle">
                    <label>Password</label>
                    <div class="input-container">
                        <div class="input-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        <button type="button" class="toggle-btn" onclick="togglePassword('password')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                
                <div class="form-options">
                    <div class="remember-me" onclick="toggleRemember()">
                        <div class="remember-checkbox" id="rememberCheckbox"></div>
                        <span class="remember-text">Remember me</span>
                    </div>
                    <a href="forgot-password.php" class="forgot-password">Forgot Password?</a>
                </div>
                
                <button type="submit" class="btn">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </button>
            </form>
            
            <div class="social-login">
                <div class="social-title">Or sign in with</div>
                <div class="social-buttons">
                    <a href="#" class="social-btn google-btn">
                        <i class="fab fa-google"></i> Google
                    </a>
                    <a href="#" class="social-btn facebook-btn">
                        <i class="fab fa-facebook-f"></i> Facebook
                    </a>
                </div>
            </div>
            
            <div class="links">
                <a href="index.php" class="link-btn home-btn">
                    <i class="fas fa-home"></i> Back to Homepage
                </a>
                <a href="register.php" class="link-btn register-btn">
                    <i class="fas fa-user-plus"></i> Don't have an account? Sign Up
                </a>
            </div>
            
            <div style="text-align: center; margin-top: 30px; color: #94a3b8; font-size: 14px;">
                <p>By signing in, you agree to our <a href="#" style="color: #667eea; text-decoration: none;">terms and conditions</a></p>
            </div>
        </div>
    </div>
    
    <script>
        function togglePassword(fieldId) {
            const input = document.getElementById(fieldId);
            const icon = input.parentNode.querySelector('.toggle-btn i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
        
        function toggleRemember() {
            const checkbox = document.getElementById('rememberCheckbox');
            checkbox.classList.toggle('checked');
        }
        
        // Form validation with animation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.querySelector('input[name="email"]');
            const password = document.getElementById('password');
            
            // Email validation
            if (!email.value.includes('@') || !email.value.includes('.')) {
                e.preventDefault();
                email.style.borderColor = '#ef4444';
                email.focus();
                
                // Shake animation
                email.style.animation = 'none';
                setTimeout(() => {
                    email.style.animation = 'shake 0.5s';
                }, 10);
                
                return false;
            }
            
            // Password validation
            if (password.value.length < 1) {
                e.preventDefault();
                password.style.borderColor = '#ef4444';
                password.focus();
                
                // Shake animation
                password.style.animation = 'none';
                setTimeout(() => {
                    password.style.animation = 'shake 0.5s';
                }, 10);
                
                return false;
            }
        });
        
        // Add shake animation to CSS
        const style = document.createElement('style');
        style.textContent = `
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
                20%, 40%, 60%, 80% { transform: translateX(5px); }
            }
        `;
        document.head.appendChild(style);
        
        // Input focus effects
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.style.borderColor = '#667eea';
                this.style.boxShadow = '0 0 0 4px rgba(102, 126, 234, 0.1)';
            });
            
            input.addEventListener('blur', function() {
                this.style.boxShadow = 'none';
                
                // Reset error styling on valid input
                if (this.value.trim() !== '') {
                    this.style.borderColor = '#e2e8f0';
                }
            });
        });
        
        // Auto fill demo credentials for testing (remove in production)
        document.addEventListener('DOMContentLoaded', function() {
            // This is just for demo purposes - remove in production
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('demo') === 'true') {
                document.querySelector('input[name="email"]').value = 'demo@subbyte.com';
                document.getElementById('password').value = 'demo123';
            }
        });
    </script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</body>
</html>