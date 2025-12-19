<!-- Footer -->
<footer class="bg-gray-900 text-gray-300 py-12 border-t border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="col-span-1 md:col-span-1">
                <a href="<?= $this->Url->build('/') ?>" class="flex items-center gap-2 text-2xl font-bold text-white mb-4">
                    <i class="fas fa-car-side text-blue-500"></i>
                    <span>RENTIFY</span>
                </a>
                <p class="text-sm text-gray-400 leading-relaxed">
                    Experience the freedom of the road with our premium fleet. Reliable, comfortable, and affordable.
                </p>
            </div>
            <div>
                <h3 class="text-white font-semibold mb-4 tracking-wide uppercase text-sm">Company</h3>
                <ul class="space-y-3 text-sm">
                    <li><a href="<?= $this->Url->build('/') ?>#about" class="hover:text-blue-400 transition-colors">About Us</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition-colors">Careers</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition-colors">Blog</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-white font-semibold mb-4 tracking-wide uppercase text-sm">Support</h3>
                <ul class="space-y-3 text-sm">
                    <li><a href="#" class="hover:text-blue-400 transition-colors">Help Center</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition-colors">Terms of Service</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition-colors">Privacy Policy</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-white font-semibold mb-4 tracking-wide uppercase text-sm">Connect</h3>
                <div class="flex space-x-4 mb-4">
                    <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all duration-300"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all duration-300"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all duration-300"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">
            <p>&copy; <?= date('Y') ?> Rentify Inc. All rights reserved.</p>
            <div class="mt-4 md:mt-0 flex space-x-6">
                <a href="#" class="hover:text-white transition-colors">Privacy</a>
                <a href="#" class="hover:text-white transition-colors">Terms</a>
                <a href="#" class="hover:text-white transition-colors">Cookies</a>
            </div>
        </div>
    </div>
</footer>
