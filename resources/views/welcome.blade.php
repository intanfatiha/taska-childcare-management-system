<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('assets/Taska-Hikmah-login.jpg') }}" type="image/png">
    <title>LITTLECARE: TASKA HIKMAH - Premium Childcare Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'fade-in': 'fadeIn 0.8s ease-in forwards',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 font-sans">


    <!-- Navigation Header -->
<nav class="shadow-lg sticky top-0 z-50" style="background-color: white;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo Section -->
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('assets/ppuk_logo.png') }}" alt="PPUK Logo" class="w-10 h-10 rounded-full">
                    <div>
                        <h1 class="text-lg font-bold text-gray-800">LITTLECARE</h1>
                        <p class="text-xs text-gray-600">TASKA HIKMAH</p>
                    </div>
                </div>
                
                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="#home" class="text-gray-700 hover:text-indigo-600 transition">Home</a>
                    <a href="#about" class="text-gray-700 hover:text-indigo-600 transition">About</a>
                    <a href="#services" class="text-gray-700 hover:text-indigo-600 transition">Services</a>
                    <a href="#contact" class="text-gray-700 hover:text-indigo-600 transition">Contact</a>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center space-x-3">
                    <a href="/login" class="text-indigo-600 hover:text-indigo-800 font-medium transition-colors duration-300">Login</a>
                    <a href="{{ url('/registration') }}" class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-4 py-2 rounded-lg font-medium hover:from-indigo-600 hover:to-purple-700 transform hover:scale-105 transition-all duration-300">Register Child</a>
                </div>
            </div>
        </div>

        
    </nav>

    <!-- Hero Section -->
    <section id="home" class="bg-gradient-to-br from-indigo-500 via-purple-600 to-purple-700 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml;utf8,<svg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"><g fill=\"none\" fill-rule=\"evenodd\"><g fill=\"white\" fill-opacity=\"0.3\"><circle cx=\"30\" cy=\"30\" r=\"4\"/></g></g></svg>');"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Hero Content -->
                <div class="text-white opacity-0 animate-fade-in">
                    <h1 class="text-4xl lg:text-6xl font-bold mb-6 leading-tight">
                        Nurturing Little Hearts & Minds
                    </h1>
                    <p class="text-xl mb-8 text-white opacity-90 leading-relaxed">
                        Welcome to TASKA HIKMAH - Where every child's journey begins with love, care, and endless possibilities. 
                        Our comprehensive childcare management system ensures your little ones receive the best care possible.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ url('/registration') }}" class="bg-white text-indigo-600 px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 hover:shadow-lg text-center">
                            <i class="fas fa-baby mr-2"></i>Register Your Child
                        </a>
                        <a href="/login" class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-indigo-600 transition-all duration-300 text-center">
                            <i class="fas fa-sign-in-alt mr-2"></i>Parent Login
                        </a>
                    </div>
                </div>

                <!-- Hero Image -->
                <div class="relative opacity-0 animate-fade-in">
                    <div class="bg-white rounded-2xl shadow-2xl p-8 transform rotate-3 hover:rotate-0 transition-transform duration-500">
                        <img src="{{ asset('assets/care.jpg') }}" alt="Happy Children" class="w-full h-64 object-cover rounded-xl">
                        <div class="absolute -top-4 -right-4 bg-yellow-400 text-yellow-800 px-4 py-2 rounded-full font-bold transform -rotate-12">
                            Premium Care ⭐
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Floating Elements -->
        <div class="absolute top-20 left-10 text-white opacity-20">
            <i class="fas fa-star text-4xl"></i>
        </div>
        <div class="absolute bottom-20 right-10 text-white opacity-20">
            <i class="fas fa-heart text-6xl"></i>
        </div>
    </section>

    <!-- Features Section -->
<section id="services" class="py-20 bg-white relative" style="background-image: url('{{ asset('assets/grid1.png') }}'); background-size: cover; background-position: center;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Why Choose TASKA HIKMAH?</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    We provide a comprehensive childcare experience with modern technology and loving care
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="transition-all duration-300 ease-in-out hover:-translate-y-2 hover:shadow-2xl bg-gradient-to-br from-blue-50 to-blue-100 p-8 rounded-2xl">
                    <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Safe & Secure</h3>
                    <p class="text-gray-600">
                        Your child's safety is our top priority with 24/7 monitoring, secure facilities, and trained staff.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="transition-all duration-300 ease-in-out hover:-translate-y-2 hover:shadow-2xl bg-gradient-to-br from-green-50 to-green-100 p-8 rounded-2xl">
                    <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-graduation-cap text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Educational Excellence</h3>
                    <p class="text-gray-600">
                        Structured learning programs designed to develop cognitive, social, and emotional skills.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="transition-all duration-300 ease-in-out hover:-translate-y-2 hover:shadow-2xl bg-gradient-to-br from-purple-50 to-purple-100 p-8 rounded-2xl">
                    <div class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-mobile-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Digital Management</h3>
                    <p class="text-gray-600">
                        Modern parent portal for payments, progress tracking, and real-time communication.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="transition-all duration-300 ease-in-out hover:-translate-y-2 hover:shadow-2xl bg-gradient-to-br from-orange-50 to-orange-100 p-8 rounded-2xl">
                    <div class="w-16 h-16 bg-orange-500 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-utensils text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Nutritious Meals</h3>
                    <p class="text-gray-600">
                        Healthy, balanced meals prepared fresh daily to support your child's growth and development.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="transition-all duration-300 ease-in-out hover:-translate-y-2 hover:shadow-2xl bg-gradient-to-br from-pink-50 to-pink-100 p-8 rounded-2xl">
                    <div class="w-16 h-16 bg-pink-500 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-heart text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Loving Care</h3>
                    <p class="text-gray-600">
                        Experienced, caring staff who treat every child with love, patience, and individual attention.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="transition-all duration-300 ease-in-out hover:-translate-y-2 hover:shadow-2xl bg-gradient-to-br from-teal-50 to-teal-100 p-8 rounded-2xl">
                    <div class="w-16 h-16 bg-teal-500 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-clock text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Flexible Hours</h3>
                    <p class="text-gray-600">
                        Extended hours and flexible scheduling to accommodate working parents' needs.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl font-bold text-gray-800 mb-6">About TASKA HIKMAH</h2>
                    <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                        For over a decade, TASKA HIKMAH has been a trusted name in early childhood education and care. 
                        We believe that every child deserves a nurturing environment where they can grow, learn, and thrive.
                    </p>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        Our experienced team of educators and caregivers are passionate about providing the highest 
                        quality care while fostering creativity, independence, and social skills in every child.
                    </p>
                    
                    <div class="grid grid-cols-2 gap-6">
                        <div class="text-center bg-white p-4 rounded-lg shadow">
                            <div class="text-3xl font-bold text-indigo-600">10+</div>
                            <div class="text-gray-600">Years Experience</div>
                        </div>
                        <div class="text-center bg-white p-4 rounded-lg shadow">
                            <div class="text-3xl font-bold text-indigo-600">200+</div>
                            <div class="text-gray-600">Happy Families</div>
                        </div>
                        <div class="text-center bg-white p-4 rounded-lg shadow">
                            <div class="text-3xl font-bold text-indigo-600">15+</div>
                            <div class="text-gray-600">Qualified Staff</div>
                        </div>
                        <div class="text-center bg-white p-4 rounded-lg shadow">
                            <div class="text-3xl font-bold text-indigo-600">100%</div>
                            <div class="text-gray-600">Parent Satisfaction</div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="bg-indigo-600 rounded-2xl p-8 text-white">
                        <h3 class="text-2xl font-bold mb-4">Our Mission</h3>
                        <p class="text-lg opacity-90 mb-6">
                            To provide exceptional early childhood education and care in a safe, nurturing environment 
                            that promotes each child's social, emotional, physical, and cognitive development.
                        </p>
                        <ul class="space-y-3">
                            <li class="flex items-center">
                                <i class="fas fa-check-circle mr-3"></i>
                                Individual attention for every child
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle mr-3"></i>
                                Age-appropriate learning activities
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle mr-3"></i>
                                Strong parent-teacher communication
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-br from-indigo-500 via-purple-600 to-purple-700 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml;utf8,<svg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"><g fill=\"none\" fill-rule=\"evenodd\"><g fill=\"white\" fill-opacity=\"0.3\"><circle cx=\"30\" cy=\"30\" r=\"4\"/></g></g></svg>');"></div>
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8 relative z-10">
            <h2 class="text-4xl font-bold text-white mb-6">Ready to Join Our Family?</h2>
            <p class="text-xl text-white opacity-90 mb-8">
                Give your child the best start in life with our caring and professional childcare services.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ url('/registration') }}" class="bg-white text-indigo-600 px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                    <i class="fas fa-baby mr-2"></i>Register Your Child Today
                </a>
                <a href="#contact" class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-indigo-600 transition-all duration-300">
                    <i class="fas fa-phone mr-2"></i>Contact Us
                </a>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-white" style="background-image: url('{{ asset('assets/grid1.png') }}'); background-size: cover; background-position: center;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" >
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Get in Touch</h2>
                <p class="text-xl text-gray-600">We'd love to hear from you and answer any questions</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-6xl mx-auto">
                <!-- Location -->
                <div class="text-center bg-gradient-to-br from-blue-50 to-blue-100 p-8 rounded-2xl hover:shadow-lg transition-all duration-300">
                    <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-map-marker-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Location</h3>
                    <p class="text-gray-600">Pusat Perkembangan Awal Kanak-Kanak UTHM<br>86400 Parit Raja, Johor</p>
                </div>

                <!-- Phone -->
                <div class="text-center bg-gradient-to-br from-green-50 to-green-100 p-8 rounded-2xl hover:shadow-lg transition-all duration-300">
                    <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-phone text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Phone</h3>
                    <p class="text-gray-600">07-453 3404</p>
                    <a href="tel:07-453 3404" class="inline-block mt-2 text-green-600 hover:text-green-800 font-medium">Call Now</a>
                </div>

                <!-- Email -->
                <div class="text-center bg-gradient-to-br from-purple-50 to-purple-100 p-8 rounded-2xl hover:shadow-lg transition-all duration-300">
                    <div class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-envelope text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Email</h3>
                    <p class="text-gray-600">ppak@uthm.edu.my</p>
                    <a href="mailto:info@taskahikmah.com" class="inline-block mt-2 text-purple-600 hover:text-purple-800 font-medium">Send Email</a>
                </div>

                <!-- Operating Hours -->
                <div class="text-center bg-gradient-to-br from-orange-50 to-orange-100 p-8 rounded-2xl hover:shadow-lg transition-all duration-300">
                    <div class="w-16 h-16 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-clock text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Operating Hours</h3>
                    <p class="text-gray-600">Mon-Fri: 7:30 AM - 5:30 PM<br>Sat: Closed<br>Sun: Closed</p>
                </div>
            </div>

            <!-- Additional Contact Methods -->
            <div class="mt-16 text-center">
                <h3 class="text-2xl font-bold text-gray-800 mb-8">Connect With Us</h3>
                <div class="flex justify-center space-x-6">
                    <a href="https://wa.me/60312345678" class="bg-green-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-600 transition-all duration-300 transform hover:scale-105">
                        <i class="fab fa-whatsapp mr-2"></i>WhatsApp
                    </a>
                    <a href="https://www.facebook.com/groups/514830091977571/?locale=ms_MY" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-all duration-300 transform hover:scale-105">
                        <i class="fab fa-facebook-f mr-2"></i>Facebook
                    </a>
                    <a href="https://www.instagram.com/taskahikmah" class="bg-pink-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-pink-600 transition-all duration-300 transform hover:scale-105">
                        <i class="fab fa-instagram mr-2"></i>Instagram
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <img src="{{ asset('assets/ppuk_logo.png') }}" alt="PPUK Logo" class="w-10 h-10 rounded-full">
                        <div>
                            <h3 class="text-xl font-bold">LITTLECARE: TASKA HIKMAH</h3>
                            <p class="text-gray-400 text-sm">Premium Childcare Management</p>
                        </div>
                    </div>
                    <p class="text-gray-400 mb-4">
                        Providing exceptional early childhood education and care with love, safety, and excellence since 2010.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center hover:bg-indigo-700 transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center hover:bg-indigo-700 transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center hover:bg-indigo-700 transition">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#home" class="text-gray-400 hover:text-white transition">Home</a></li>
                        <li><a href="#about" class="text-gray-400 hover:text-white transition">About Us</a></li>
                        <li><a href="#services" class="text-gray-400 hover:text-white transition">Services</a></li>
                        <li><a href="/login" class="text-gray-400 hover:text-white transition">Parent Login</a></li>
                        <li><a href="{{ url('/registration') }}" class="text-gray-400 hover:text-white transition">Registration</a></li>
                      
                        <li><a href="{{ url('register') }}" class="text-gray-400 hover:text-white transition">Registration User </a></li>

                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact Info</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><i class="fas fa-map-marker-alt mr-2"></i>Pusat Perkembangan Awal Kanak-Kanak UTHM
                        86400 Parit Raja, Johor</li>
                        <li><i class="fas fa-phone mr-2"></i>07-453 3404</li>
                        <li><i class="fas fa-envelope mr-2"></i>ppak@uthm.edu.my</li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-400">
                    &copy; 2024 LITTLECARE: TASKA HIKMAH. All rights reserved. 
                    Made with <i class="fas fa-heart text-red-500"></i> for children's future.
                </p>
            </div>
        </div>
    </footer>

    <!-- Smooth Scrolling Script -->
    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add scroll effect to navbar
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 100) {
                nav.classList.add('shadow-lg');
            } else {
                nav.classList.remove('shadow-lg');
            }
        });

        // Add fade-in animation for elements when they come into view
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in');
                }
            });
        }, observerOptions);

        document.querySelectorAll('[class*="hover:-translate-y"]').forEach(card => {
            observer.observe(card);
        });
    </script>
</body>
</html>