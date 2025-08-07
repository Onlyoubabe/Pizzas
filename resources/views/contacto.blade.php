<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PizzaPlace - Contacto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes floatImage {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }
        .float-animation {
            animation: floatImage 4s ease-in-out infinite;
        }
        .bg-pizza-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23FCD34D' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="bg-white">
    @include('fragments.navbar')
    <!-- Hero Section -->
    <div class="bg-pizza-pattern pt-24 pb-16">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center fade-in-up">
                <h1 class="text-5xl font-bold text-gray-800 mb-6">Contáctanos</h1>
                <p class="text-xl text-gray-600 mb-8">¿Tienes alguna pregunta o sugerencia? ¡Nos encantaría escucharte!</p>
            </div>
        </div>
    </div>
    
    <!-- Mensajes de alerta -->
    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mx-auto my-6 max-w-2xl" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif
    
    @if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mx-auto my-6 max-w-2xl" role="alert">
        <p>{{ session('error') }}</p>
    </div>
    @endif
    
    <!-- Contact Information Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto mb-16">
                <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="text-red-500 text-4xl mb-4">📞</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Teléfono</h3>
                    <p class="text-gray-600">
                        +34 123 456 789<br>
                        Lun-Dom: 11:00 - 23:00
                    </p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="text-red-500 text-4xl mb-4">📍</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Dirección</h3>
                    <p class="text-gray-600">
                        Calle Principal 123<br>
                        Madrid, España 28001
                    </p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="text-red-500 text-4xl mb-4">✉️</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Email</h3>
                    <p class="text-gray-600">
                        info@pizzaplace.com<br>
                        soporte@pizzaplace.com
                    </p>
                </div>
            </div>
            <!-- Contact Form -->
            <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Envíanos un mensaje</h2>
                
                @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <form action="{{ route('contacto.enviar') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="name" class="block text-gray-700 font-medium mb-2">Nombre</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-red-500 focus:ring focus:ring-red-200 transition duration-200">
                    </div>
                    <div>
                        <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-red-500 focus:ring focus:ring-red-200 transition duration-200">
                    </div>
                    <div>
                        <label for="subject" class="block text-gray-700 font-medium mb-2">Asunto</label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-red-500 focus:ring focus:ring-red-200 transition duration-200">
                    </div>
                    <div>
                        <label for="message" class="block text-gray-700 font-medium mb-2">Mensaje</label>
                        <textarea id="message" name="message" rows="5" required
                                  class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-red-500 focus:ring focus:ring-red-200 transition duration-200">{{ old('message') }}</textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit" 
                                class="bg-red-500 text-white font-bold py-3 px-8 rounded-full hover:bg-red-600 transition-colors duration-300">
                            Enviar Mensaje
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <section class="bg-gray-50 py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto">
                <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Encuéntranos</h2>
                <div class="aspect-w-16 aspect-h-9 rounded-xl overflow-hidden shadow-lg">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d242.72520704131077!2d-97.08409000156044!3d20.451533123043948!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85dbb30d02696cc9%3A0x27374234c95599c7!2sJarochos%20Pizza%20Guti%C3%A9rrez%20Zamora!5e0!3m2!1ses!2smx!4v1740298901780!5m2!1ses!2smx"
                        width="100%" 
                        height="450" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </section>
    <!-- Social Media Section -->
    <section class="py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Síguenos en redes sociales</h2>
            <div class="flex justify-center space-x-8">
                <a href="#" class="text-gray-600 hover:text-red-500 transition-colors duration-300">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </a>
                <a href="#" class="text-gray-600 hover:text-red-500 transition-colors duration-300">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                </a>
                <a href="#" class="text-gray-600 hover:text-red-500 transition-colors duration-300">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.897 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.897-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zm0 10.162c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/></svg>
                </a>
            </div>
        </div>
    </section>
    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-red-600 to-red-500">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-white mb-8">¿Tienes alguna consulta o sugerencia?</h2>
            <p class="text-white text-xl mb-8">Estamos aquí para ayudarte. ¡Contáctanos ahora!</p>
            <a href="#" class="inline-block bg-white text-red-600 font-bold py-3 px-8 rounded-full hover:bg-gray-100 transition-colors duration-300">
                Llamar Ahora
            </a>
        </div>
    </section>
    @include('fragments.footer')
    <script>
        function revealOnScroll() {
            const elements = document.querySelectorAll('.fade-in-up');
            elements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const windowHeight = window.innerHeight;
                
                if (elementTop < windowHeight - 100) {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }
            });
        }
        window.addEventListener('scroll', revealOnScroll);
        window.addEventListener('load', revealOnScroll);
    </script>
</body>
</html>