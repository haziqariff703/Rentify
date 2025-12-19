<!-- Footer (Bootstrap 5) -->
<footer class="bg-dark text-secondary py-5 border-top border-secondary position-relative z-1">
    <div class="container">
        <div class="row gy-4">
            <!-- Brand Column -->
            <div class="col-lg-3 col-md-6">
                <a href="<?= $this->Url->build('/') ?>" class="d-flex align-items-center gap-2 text-decoration-none text-white mb-3">
                    <i class="fas fa-car-side text-primary fs-4"></i>
                    <span class="fw-bold fs-4">RENTIFY</span>
                </a>
                <p class="small text-secondary mb-0">
                    Experience the freedom of the road with our premium fleet. Reliable, comfortable, and affordable.
                </p>
            </div>
            
            <!-- Company Links -->
            <div class="col-lg-3 col-md-6">
                <h6 class="text-white text-uppercase fw-bold mb-3 small">Company</h6>
                <ul class="list-unstyled small mb-0 d-flex flex-column gap-2">
                    <li><a href="<?= $this->Url->build('/') ?>#about" class="text-secondary text-decoration-none hover-white transition">About Us</a></li>
                    <li><a href="#" class="text-secondary text-decoration-none hover-white transition">Careers</a></li>
                    <li><a href="#" class="text-secondary text-decoration-none hover-white transition">Blog</a></li>
                </ul>
            </div>
            
            <!-- Support Links -->
            <div class="col-lg-3 col-md-6">
                <h6 class="text-white text-uppercase fw-bold mb-3 small">Support</h6>
                <ul class="list-unstyled small mb-0 d-flex flex-column gap-2">
                    <li><a href="#" class="text-secondary text-decoration-none hover-white transition">Help Center</a></li>
                    <li><a href="#" class="text-secondary text-decoration-none hover-white transition">Terms of Service</a></li>
                    <li><a href="#" class="text-secondary text-decoration-none hover-white transition">Privacy Policy</a></li>
                </ul>
            </div>
            
            <!-- Connect -->
            <div class="col-lg-3 col-md-6">
                <h6 class="text-white text-uppercase fw-bold mb-3 small">Connect</h6>
                <div class="d-flex gap-2 mb-3">
                    <a href="#" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>

        <div class="border-top border-secondary mt-5 pt-4 d-flex flex-column flex-md-row justify-content-between align-items-center small text-secondary">
            <p class="mb-2 mb-md-0">&copy; <?= date('Y') ?> Rentify Inc. All rights reserved.</p>
            <div class="d-flex gap-4">
                <a href="#" class="text-secondary text-decoration-none hover-white">Privacy</a>
                <a href="#" class="text-secondary text-decoration-none hover-white">Terms</a>
                <a href="#" class="text-secondary text-decoration-none hover-white">Cookies</a>
            </div>
        </div>
    </div>
</footer>

<style>
    .hover-white:hover { color: #fff !important; }
</style>