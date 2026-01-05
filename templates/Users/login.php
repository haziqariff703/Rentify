<?php

/**
 * Combined Login/Register Page - Double Slider Design
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<div class="auth-slider-page">
    <div class="auth-container" id="container">
        <!-- Register Form -->
        <div class="form-container register-container">
            <?= $this->Form->create($user ?? null, [
                'url' => ['controller' => 'Users', 'action' => 'add'],
                'class' => 'auth-form'
            ]) ?>
            <h1>Create Account</h1>
            <p class="form-subtitle">Join Rentify and start your journey</p>

            <div class="form-group">
                <i class="fas fa-user"></i>
                <?= $this->Form->control('name', [
                    'label' => false,
                    'placeholder' => 'Full Name',
                    'class' => 'form-input',
                    'required' => true
                ]) ?>
            </div>

            <div class="form-group">
                <i class="fas fa-id-card"></i>
                <?= $this->Form->control('ic_number', [
                    'label' => false,
                    'placeholder' => 'IC Number',
                    'class' => 'form-input',
                    'required' => true
                ]) ?>
            </div>

            <div class="form-group">
                <i class="fas fa-envelope"></i>
                <?= $this->Form->control('email', [
                    'label' => false,
                    'placeholder' => 'Email Address',
                    'class' => 'form-input',
                    'type' => 'email',
                    'required' => true
                ]) ?>
            </div>

            <div class="form-group">
                <i class="fas fa-phone"></i>
                <?= $this->Form->control('phone', [
                    'label' => false,
                    'placeholder' => 'Phone Number',
                    'class' => 'form-input'
                ]) ?>
            </div>

            <div class="form-group password-group">
                <i class="fas fa-lock"></i>
                <?= $this->Form->control('password', [
                    'label' => false,
                    'placeholder' => 'Password',
                    'class' => 'form-input password-input',
                    'type' => 'password',
                    'required' => true,
                    'id' => 'register-password'
                ]) ?>
                <i class="fas fa-eye password-toggle" data-target="register-password"></i>
            </div>

            <button type="submit" class="auth-btn">Register</button>

            <div class="social-container">
                <span>or sign up with</span>
                <div class="social-icons">
                    <a href="#" class="social"><i class="fab fa-google"></i></a>
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                </div>
            </div>
            <?= $this->Form->end() ?>
        </div>

        <!-- Login Form -->
        <div class="form-container login-container">
            <?= $this->Form->create(null, [
                'url' => ['controller' => 'Users', 'action' => 'login'],
                'class' => 'auth-form'
            ]) ?>
            <h1>Welcome Back</h1>
            <p class="form-subtitle">Login to your Rentify account</p>

            <div class="form-group">
                <i class="fas fa-envelope"></i>
                <?= $this->Form->control('email', [
                    'label' => false,
                    'placeholder' => 'Email Address',
                    'class' => 'form-input',
                    'type' => 'email',
                    'required' => true
                ]) ?>
            </div>

            <div class="form-group password-group">
                <i class="fas fa-lock"></i>
                <?= $this->Form->control('password', [
                    'label' => false,
                    'placeholder' => 'Password',
                    'class' => 'form-input password-input',
                    'type' => 'password',
                    'required' => true,
                    'id' => 'login-password'
                ]) ?>
                <i class="fas fa-eye password-toggle" data-target="login-password"></i>
            </div>

            <div class="form-options">
                <label class="remember-me">
                    <input type="checkbox" name="remember">
                    <span>Remember me</span>
                </label>
                <a href="#" class="forgot-link">Forgot Password?</a>
            </div>

            <button type="submit" class="auth-btn">Login</button>

            <div class="social-container">
                <span>or login with</span>
                <div class="social-icons">
                    <a href="#" class="social"><i class="fab fa-google"></i></a>
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                </div>
            </div>
            <?= $this->Form->end() ?>
        </div>

        <!-- Overlay Container -->
        <div class="overlay-container">
            <div class="overlay">
                <!-- Left Overlay Panel (shows when on Register) -->
                <div class="overlay-panel overlay-left">
                    <div class="overlay-content">
                        <i class="fas fa-car-side overlay-icon"></i>
                        <h2>Welcome Back!</h2>
                        <p>Already have an account? Login to access your dashboard and continue your journey with us.
                        </p>
                        <button class="ghost-btn" id="login">Login</button>
                    </div>
                </div>

                <!-- Right Overlay Panel (shows when on Login) -->
                <div class="overlay-panel overlay-right">
                    <div class="overlay-content">
                        <i class="fas fa-road overlay-icon"></i>
                        <h2>Start Your Journey</h2>
                        <p>Don't have an account yet? Join us and experience premium car rentals like never before.</p>
                        <button class="ghost-btn" id="register">Register</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Auth Slider Page Styles - Fullscreen */
    .auth-slider-page {
        min-height: calc(100vh - 160px);
        height: auto;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        margin: 0;
        position: relative;
    }

    .auth-container {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 25px 80px rgba(0, 0, 0, 0.4);
        position: relative;
        overflow: hidden;
        width: 90%;
        max-width: 900px;
        height: 85vh;
        max-height: 650px;
    }

    /* Form Containers */
    .form-container {
        position: absolute;
        top: 0;
        height: 100%;
        transition: all 0.6s ease-in-out;
        overflow-y: auto;
    }

    .login-container {
        left: 0;
        width: 50%;
        z-index: 2;
    }

    .auth-container.right-panel-active .login-container {
        transform: translateX(100%);
        opacity: 0;
        z-index: 1;
    }

    .register-container {
        left: 0;
        width: 50%;
        opacity: 0;
        z-index: 1;
    }

    .auth-container.right-panel-active .register-container {
        transform: translateX(100%);
        opacity: 1;
        z-index: 5;
        animation: show 0.6s;
    }

    @keyframes show {

        0%,
        49.99% {
            opacity: 0;
            z-index: 1;
        }

        50%,
        100% {
            opacity: 1;
            z-index: 5;
        }
    }

    /* Auth Form Styling */
    .auth-form {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        padding: 40px 45px;
        min-height: 100%;
        text-align: center;
    }

    .register-container .auth-form {
        padding: 30px 40px 40px;
    }

    .auth-form h1 {
        font-size: 26px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 6px;
    }

    .form-subtitle {
        color: #64748b;
        font-size: 13px;
        margin-bottom: 20px;
    }

    /* Form Groups with Proper Spacing */
    .form-group {
        position: relative;
        width: 100%;
        margin-bottom: 16px;
    }

    .register-container .form-group {
        margin-bottom: 14px;
    }

    .form-group i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
        z-index: 1;
    }

    .form-input,
    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group input[type="password"],
    .form-group input[type="tel"] {
        width: 100%;
        padding: 13px 13px 13px 40px;
        background: #f1f5f9;
        border: 2px solid transparent;
        border-radius: 10px;
        font-size: 13px;
        color: #1e293b;
        transition: all 0.3s ease;
    }

    .form-input:focus,
    .form-group input:focus {
        background: #fff;
        border-color: #3b82f6;
        outline: none;
        box-shadow: 0 0 0 4px rgba(244, 245, 247, 0.1);
    }

    .form-input::placeholder {
        color: #94a3b8;
    }

    /* Form Options (Remember me & Forgot) */
    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        margin-bottom: 20px;
        font-size: 13px;
    }

    .remember-me {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #64748b;
        cursor: pointer;
    }

    .remember-me input {
        accent-color: #3b82f6;
    }

    .forgot-link {
        color: #3b82f6;
        text-decoration: none;
        font-weight: 500;
    }

    .forgot-link:hover {
        text-decoration: underline;
    }

    /* Auth Button */
    .auth-btn {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 10px;
    }

    .auth-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
    }

    /* Social Container */
    .social-container {
        margin-top: 25px;
        text-align: center;
    }

    .register-container .social-container {
        margin-top: 15px;
    }

    .social-container span {
        color: #94a3b8;
        font-size: 13px;
    }

    .social-icons {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 12px;
    }

    .social {
        width: 42px;
        height: 42px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .social:hover {
        border-color: #3b82f6;
        color: #3b82f6;
        transform: translateY(-3px);
    }

    /* Overlay Container */
    .overlay-container {
        position: absolute;
        top: 0;
        left: 50%;
        width: 50%;
        height: 100%;
        overflow: hidden;
        transition: transform 0.6s ease-in-out;
        z-index: 100;
    }

    .auth-container.right-panel-active .overlay-container {
        transform: translateX(-100%);
    }

    /* Overlay */
    .overlay {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        color: #fff;
        position: relative;
        left: -100%;
        height: 100%;
        width: 200%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
    }

    .auth-container.right-panel-active .overlay {
        transform: translateX(50%);
    }

    /* Overlay Panels */
    .overlay-panel {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 40px;
        text-align: center;
        top: 0;
        height: 100%;
        width: 50%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
    }

    .overlay-left {
        transform: translateX(-20%);
    }

    .auth-container.right-panel-active .overlay-left {
        transform: translateX(0);
    }

    .overlay-right {
        right: 0;
        transform: translateX(0);
    }

    .auth-container.right-panel-active .overlay-right {
        transform: translateX(20%);
    }

    .overlay-content {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .overlay-icon {
        font-size: 48px;
        margin-bottom: 20px;
        opacity: 0.9;
    }

    .overlay-panel h2 {
        font-size: 26px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .overlay-panel p {
        font-size: 14px;
        line-height: 1.7;
        opacity: 0.9;
        margin-bottom: 25px;
        max-width: 280px;
    }

    /* Ghost Button */
    .ghost-btn {
        background: transparent;
        border: 2px solid #fff;
        color: #fff;
        padding: 12px 45px;
        border-radius: 25px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .ghost-btn:hover {
        background: #fff;
        color: #3b82f6;
        transform: scale(1.05);
    }

    /* Hide CakePHP default labels */
    .auth-form .input {
        margin-bottom: 0;
    }

    .auth-form label.form-label {
        display: none;
    }

    /* Scrollbar Styling for Register Form */
    .register-container::-webkit-scrollbar {
        width: 6px;
    }

    .register-container::-webkit-scrollbar-track {
        background: transparent;
    }

    .register-container::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }

    .register-container::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .auth-container {
            min-height: auto;
        }

        .form-container {
            position: relative;
            width: 100%;
            height: auto;
        }

        .login-container {
            display: block;
        }

        .register-container {
            display: none;
        }

        .auth-container.right-panel-active .login-container {
            display: none;
            transform: none;
            opacity: 1;
        }

        .auth-container.right-panel-active .register-container {
            display: block;
            transform: none;
        }

        .overlay-container {
            position: relative;
            left: 0;
            width: 100%;
            height: auto;
            padding: 30px 20px;
        }

        .overlay {
            position: relative;
            left: 0;
            width: 100%;
            border-radius: 0 0 20px 20px;
        }

        .overlay-panel {
            position: relative;
            width: 100%;
            padding: 20px;
        }

        .overlay-left,
        .overlay-right {
            transform: none;
        }

        .auth-container.right-panel-active .overlay-container,
        .auth-container.right-panel-active .overlay {
            transform: none;
        }

        .auth-form {
            padding: 30px 25px;
        }
    }

    /* Password Toggle */
    .password-group {
        position: relative !important;
        width: 100% !important;
        display: block !important;
    }

    .password-toggle {
        position: absolute !important;
        right: 15px !important;
        left: auto !important;
        top: 50% !important;
        transform: translateY(-50%) !important;
        color: #94a3b8 !important;
        font-size: 14px !important;
        cursor: pointer !important;
        z-index: 10 !important;
        transition: color 0.3s ease !important;
    }

    .password-toggle:hover {
        color: #3b82f6 !important;
    }

    .password-input {
        padding-right: 45px !important;
    }
</style>

<script src="<?= $this->Url->assetUrl('js/views/Users/auth.js') ?>?v=<?= time() ?>"></script>
<script>
    // Password visibility toggle
    document.querySelectorAll('.password-toggle').forEach(function(toggle) {
        toggle.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);

            if (input.type === 'password') {
                input.type = 'text';
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');
            }
        });
    });
</script>