<!-- Footer (Bootstrap 5 - Redesigned for Better Visual Appeal) -->
<footer class="site-footer">
    <div class="container">
        <div class="row gy-5">
            <!-- Brand Column -->
            <div class="col-lg-4 col-md-6">
                <?php
                $identity = $this->request->getAttribute('identity');
                $homeLink = $this->Url->build('/');
                if ($identity && $identity->role === 'admin') {
                    $homeLink = $this->Url->build(['controller' => 'Admins', 'action' => 'dashboard']);
                }
                ?>
                <a href="<?= $homeLink ?>" class="footer-brand">
                    <?= $this->Html->image('rentify_logo.png', ['alt' => 'Rentify Logo', 'class' => 'footer-logo']) ?>
                </a>

                <p class="footer-description">
                    Experience the freedom of the road with our premium fleet. Reliable, comfortable, and affordable.
                </p>

                <!-- Social Icons -->
                <div class="footer-social">
                    <a href="#" class="social-icon" aria-label="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="social-icon" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-icon" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="social-icon" aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>

            <!-- Company Links -->
            <div class="col-lg-2 col-md-6">
                <h6 class="footer-heading">Company</h6>
                <ul class="footer-links">
                    <li><a href="<?= $this->Url->build('/') ?>#about">About Us</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>

            <!-- Support Links -->
            <div class="col-lg-3 col-md-6">
                <h6 class="footer-heading">Support</h6>
                <ul class="footer-links">
                    <li><a href="#">Help Center</a></li>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">FAQs</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-3 col-md-6">
                <h6 class="footer-heading">Get in Touch</h6>
                <ul class="footer-contact">
                    <li>
                        <i class="fas fa-envelope"></i>
                        <span>support@rentify.com</span>
                    </li>
                    <li>
                        <i class="fas fa-phone"></i>
                        <span>+60 11-1234 5678</span>
                    </li>
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Kuala Lumpur, Malaysia</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p class="mb-0">&copy; <?= date('Y') ?> Rentify Inc. All rights reserved.</p>
            <div class="footer-bottom-links">
                <a href="#">Privacy</a>
                <a href="#">Terms</a>
                <a href="#">Cookies</a>
            </div>
        </div>
    </div>
</footer>