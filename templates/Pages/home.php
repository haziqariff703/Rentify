<?php
/**
 * Rentify Home Page - Tailwind CSS Version
 */
$this->setLayout('home');
$this->assign('title', 'Welcome to Rentify');
?>

<!-- Hero Section -->
<section class="relative h-[85vh] flex items-center justify-center overflow-hidden">
    <!-- Background Image with Overlay -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" alt="Hero Background" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/60"></div>
    </div>

    <div class="relative z-10 text-center px-4 max-w-4xl mx-auto">
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white mb-6 tracking-tight leading-tight animate-[fadeInUp_0.8s_ease-out]">
            Drive Your <span class="text-blue-500">Dreams</span> Today
        </h1>
        <p class="text-lg md:text-xl text-gray-200 mb-10 max-w-2xl mx-auto leading-relaxed animate-[fadeInUp_0.8s_ease-out_0.2s_both]">
            Experience the thrill of the open road with our premium fleet of vehicles. Unmatched comfort, style, and performance await.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center animate-[fadeInUp_0.8s_ease-out_0.4s_both]">
            <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="px-8 py-4 bg-blue-600 text-white text-lg font-semibold rounded-full shadow-lg hover:bg-blue-700 hover:shadow-blue-500/50 transform hover:-translate-y-1 transition-all duration-300">
                Browse Fleet
            </a>
            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'add']) ?>" class="px-8 py-4 bg-transparent border-2 border-white text-white text-lg font-semibold rounded-full hover:bg-white hover:text-gray-900 shadow-lg transform hover:-translate-y-1 transition-all duration-300">
                Join Now
            </a>
        </div>
    </div>
</section>

<!-- About Us Section -->
<section id="about" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="relative group animate-[fadeInUp_0.8s_ease-out_0.2s_both]">
                <div class="absolute inset-0 bg-blue-600 rounded-3xl transform rotate-3 opacity-20 group-hover:rotate-6 transition-transform duration-500"></div>
                <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="About Rentify" class="relative rounded-3xl shadow-2xl object-cover w-full h-[500px]">
            </div>
            
            <div class="animate-[fadeInUp_0.8s_ease-out_0.4s_both]">
                <div class="inline-block px-4 py-2 bg-blue-50 text-blue-600 font-semibold rounded-full text-sm mb-6">About Us</div>
                <h2 class="text-4xl font-bold text-gray-900 mb-6 leading-tight">We Are More Than Just A Car Rental Company</h2>
                <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                    At Rentify, we believe that the journey is just as important as the destination. We provide top-quality vehicles to ensure your travel is safe, comfortable, and stylish. Whether it's a business trip or a weekend getaway, we have the perfect ride for you.
                </p>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-green-600"></i>
                        </div>
                        <span class="font-medium text-gray-800">Best Price Guarantee</span>
                    </div>
                    <div class="flex items-center space-x-3">
                         <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-headset text-green-600"></i>
                        </div>
                        <span class="font-medium text-gray-800">24/7 Support</span>
                    </div>
                    <div class="flex items-center space-x-3">
                         <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-star text-green-600"></i>
                        </div>
                        <span class="font-medium text-gray-800">Premium Models</span>
                    </div>
                    <div class="flex items-center space-x-3">
                         <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar-check text-green-600"></i>
                        </div>
                        <span class="font-medium text-gray-800">Easy Booking</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Fleet Preview -->
<section class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16 animate-[fadeInUp_0.8s_ease-out]">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Our Featured Fleet</h2>
            <p class="text-xl text-gray-600">Choose from our wide range of premium vehicles tailored to your needs.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Card 1 -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 animate-[fadeInUp_0.8s_ease-out_0.2s_both]">
                <div class="relative h-64">
                    <img src="https://images.unsplash.com/photo-1552519507-da3b142c6e3d?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover" alt="Sports Car">
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide text-gray-800">Sports</div>
                </div>
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Chevrolet Camaro</h3>
                    <p class="text-gray-500 text-sm mb-6 flex items-center gap-4">
                        <span><i class="fas fa-cogs mr-1"></i> Auto</span>
                        <span><i class="fas fa-user mr-1"></i> 2 Seats</span>
                        <span><i class="fas fa-tachometer-alt mr-1"></i> Fast</span>
                    </p>
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-3xl font-bold text-blue-600">$120</span>
                            <span class="text-gray-400 text-sm">/ day</span>
                        </div>
                        <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="px-4 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-blue-600 hover:text-white transition-colors">
                            Details
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Card 2 -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 animate-[fadeInUp_0.8s_ease-out_0.3s_both]">
                <div class="relative h-64">
                    <img src="https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover" alt="Luxury Sedan">
                     <div class="absolute top-4 right-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide text-gray-800">Luxury</div>
                </div>
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">BMW 5 Series</h3>
                    <p class="text-gray-500 text-sm mb-6 flex items-center gap-4">
                        <span><i class="fas fa-cogs mr-1"></i> Auto</span>
                        <span><i class="fas fa-user mr-1"></i> 5 Seats</span>
                        <span><i class="fas fa-gas-pump mr-1"></i> Diesel</span>
                    </p>
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-3xl font-bold text-blue-600">$150</span>
                            <span class="text-gray-400 text-sm">/ day</span>
                        </div>
                        <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="px-4 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-blue-600 hover:text-white transition-colors">
                            Details
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Card 3 -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 animate-[fadeInUp_0.8s_ease-out_0.4s_both]">
                <div class="relative h-64">
                    <img src="https://images.unsplash.com/photo-1503376763036-066120622c74?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover" alt="SUV">
                     <div class="absolute top-4 right-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide text-gray-800">SUV</div>
                </div>
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Audi Q7</h3>
                    <p class="text-gray-500 text-sm mb-6 flex items-center gap-4">
                        <span><i class="fas fa-cogs mr-1"></i> Auto</span>
                        <span><i class="fas fa-user mr-1"></i> 7 Seats</span>
                        <span><i class="fas fa-mountain mr-1"></i> AWD</span>
                    </p>
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-3xl font-bold text-blue-600">$180</span>
                            <span class="text-gray-400 text-sm">/ day</span>
                        </div>
                        <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="px-4 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-blue-600 hover:text-white transition-colors">
                            Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-16 animate-[fadeInUp_0.8s_ease-out_0.5s_both]">
            <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="inline-flex items-center justify-center px-8 py-4 bg-blue-600 text-white font-semibold rounded-full shadow-lg hover:bg-blue-700 transition-all duration-300">
                View All Cars <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="py-24 bg-white relative overflow-hidden">
     <!-- Decorative Blob -->
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-blue-50 rounded-full blur-3xl opacity-50"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 bg-purple-50 rounded-full blur-3xl opacity-50"></div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-16 animate-[fadeInUp_0.8s_ease-out]">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">How It Works</h2>
            <p class="text-xl text-gray-600">Rent your dream car in 3 simple steps</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 text-center">
            <div class="group p-8 rounded-3xl bg-gray-50 hover:bg-white hover:shadow-xl transition-all duration-300 animate-[fadeInUp_0.8s_ease-out_0.2s_both]">
                <div class="w-20 h-20 mx-auto bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-900 mb-3">1. Choose Date</h4>
                <p class="text-gray-600 leading-relaxed">Select your preferred pickup and return dates to check real-time availability.</p>
            </div>
            
            <div class="group p-8 rounded-3xl bg-gray-50 hover:bg-white hover:shadow-xl transition-all duration-300 animate-[fadeInUp_0.8s_ease-out_0.3s_both]">
                <div class="w-20 h-20 mx-auto bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-car"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-900 mb-3">2. Select Car</h4>
                <p class="text-gray-600 leading-relaxed">Browse our diverse fleet and choose the car that perfectly fits your journey.</p>
            </div>
            
            <div class="group p-8 rounded-3xl bg-gray-50 hover:bg-white hover:shadow-xl transition-all duration-300 animate-[fadeInUp_0.8s_ease-out_0.4s_both]">
                <div class="w-20 h-20 mx-auto bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-key"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-900 mb-3">3. Book & Go</h4>
                <p class="text-gray-600 leading-relaxed">Complete your secure booking and pick up your car. It's that simple!</p>
            </div>
        </div>
    </div>
</section>

<!-- Call To Action -->
<section class="py-24 bg-blue-600 relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10"></div>
    <div class="max-w-4xl mx-auto px-4 text-center relative z-10 animate-[fadeInUp_0.8s_ease-out]">
        <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">Ready to Start Your Journey?</h2>
        <p class="text-xl text-blue-100 mb-10 leading-relaxed">Join thousands of satisfied customers who trust Rentify for their travel needs. Sign up today and get exclusive offers.</p>
        <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'add']) ?>" class="inline-block px-10 py-4 bg-white text-blue-600 text-lg font-bold rounded-full shadow-2xl hover:bg-gray-100 transform hover:-translate-y-1 transition-all duration-300">
            Create Free Account
        </a>
    </div>
</section>

<style>
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translate3d(0, 40px, 0);
    }
    to {
        opacity: 1;
        transform: translate3d(0, 0, 0);
    }
}
</style>
