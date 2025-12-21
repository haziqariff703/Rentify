<!-- Footer (Bootstrap 5 - Styled to match Sidebar Theme) -->
<footer class="site-footer">
    <div class="container">
        <div class="row gy-4">
            <!-- Brand Column -->
            <div class="col-lg-3 col-md-6">
                <?php
                $identity = $this->request->getAttribute('identity');
                $homeLink = $this->Url->build('/');
                if ($identity && $identity->role === 'admin') {
                    $homeLink = $this->Url->build(['controller' => 'Admins', 'action' => 'dashboard']);
                }
                ?>
                <a href="<?= $homeLink ?>" class="footer-brand">
                    <i class="fas fa-car-side"></i>
                    <span>RENTIFY</span>
                </a>
                <p class="small mb-0" style="color: #94a3b8; line-height: 1.7;">
                    Experience the freedom of the road with our premium fleet. Reliable, comfortable, and affordable.
                </p>
            </div>

            <!-- Company Links -->
            <div class="col-lg-3 col-md-6">
                <h6 class="footer-heading">Company</h6>
                <ul class="footer-links">
                    <li><a href="<?= $this->Url->build('/') ?>#about">About Us</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Blog</a></li>
                </ul>
            </div>

            <!-- Support Links -->
            <div class="col-lg-3 col-md-6">
                <h6 class="footer-heading">Support</h6>
                <ul class="footer-links">
                    <li><a href="#">Help Center</a></li>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>

            <!-- Connect -->
            <div class="col-lg-3 col-md-6">
                <h6 class="footer-heading">Connect</h6>
                <div class="d-flex gap-2 mb-3">
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p class="mb-0 small">&copy; <?= date('Y') ?> Rentify Inc. All rights reserved.</p>
            <div class="d-flex gap-4">
                <a href="#">Privacy</a>
                <a href="#">Terms</a>
                <a href="#">Cookies</a>
            </div>
        </div>
    </div>
</footer>