<!-- Navigation -->
<nav class="bg-white/90 backdrop-blur-md fixed w-full z-50 border-b border-gray-100 transition-all duration-300" id="navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            <div class="flex-shrink-0 flex items-center">
                <a href="<?= $this->Url->build('/') ?>" class="flex items-center gap-2 text-2xl font-bold text-gray-900 tracking-tight hover:opacity-80 transition-opacity">
                    <i class="fas fa-car-side text-blue-600"></i>
                    <span>RENTIFY</span>
                </a>
            </div>
            
            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">Fleet</a>
                <a href="<?= $this->Url->build('/') ?>#about" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">About Us</a>
                <a href="<?= $this->Url->build(['controller' => 'Bookings', 'action' => 'index']) ?>" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">Bookings</a>
                
                <?php 
                $identity = $this->request->getAttribute('identity');
                if ($identity): 
                ?>
                    <div class="relative group">
                        <button class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 font-medium focus:outline-none">
                            <i class="fas fa-user-circle text-xl"></i>
                            <span>My Account</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transform translate-y-2 group-hover:translate-y-0 transition-all duration-200">
                            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'view', $identity->getIdentifier()]) ?>" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 rounded-t-xl transition-colors">
                                <i class="fas fa-id-card mr-2"></i> Profile
                            </a>
                            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>" class="block px-4 py-3 text-sm text-red-600 hover:bg-red-50 rounded-b-xl transition-colors">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="flex items-center space-x-4">
                        <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']) ?>" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">Login</a>
                        <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'add']) ?>" class="px-5 py-2.5 bg-blue-600 text-white font-medium rounded-full shadow-lg hover:bg-blue-700 hover:shadow-blue-500/30 transform hover:-translate-y-0.5 transition-all duration-200">
                            Get Started
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center">
                <button id="mobile-menu-btn" class="text-gray-600 hover:text-gray-900 focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 absolute w-full left-0 top-20 shadow-lg">
        <div class="px-4 pt-2 pb-6 space-y-2">
            <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="block px-3 py-3 rounded-lg text-base font-medium text-gray-700 hover:bg-gray-50 hover:text-blue-600">Fleet</a>
            <a href="<?= $this->Url->build('/') ?>#about" class="block px-3 py-3 rounded-lg text-base font-medium text-gray-700 hover:bg-gray-50 hover:text-blue-600">About Us</a>
            <a href="<?= $this->Url->build(['controller' => 'Bookings', 'action' => 'index']) ?>" class="block px-3 py-3 rounded-lg text-base font-medium text-gray-700 hover:bg-gray-50 hover:text-blue-600">Bookings</a>
            <?php if ($identity): ?>
                <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'view', $identity->getIdentifier()]) ?>" class="block px-3 py-3 rounded-lg text-base font-medium text-gray-700 hover:bg-gray-50 hover:text-blue-600">Profile</a>
                <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>" class="block px-3 py-3 rounded-lg text-base font-medium text-red-600 hover:bg-red-50">Logout</a>
            <?php else: ?>
                <div class="pt-4 border-t border-gray-100 grid grid-cols-2 gap-4">
                    <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']) ?>" class="flex justify-center items-center px-4 py-2 border border-gray-300 rounded-lg text-base font-medium text-gray-700 hover:bg-gray-50">Login</a>
                    <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'add']) ?>" class="flex justify-center items-center px-4 py-2 bg-blue-600 rounded-lg text-base font-medium text-white hover:bg-blue-700">Sign Up</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>

<script>
    // Mobile menu toggle
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');

    if (btn && menu) {
        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    }
</script>
