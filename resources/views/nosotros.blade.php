<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PizzaPlace - Nosotros</title>
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

        .scroll-smooth {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="bg-white">
    @include('fragments.navbar')

    <!-- Hero Section -->
    <div class="bg-pizza-pattern pt-24 pb-16">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center fade-in-up">
                <h1 class="text-5xl font-bold text-gray-800 mb-6">Nuestra Historia</h1>
                <p class="text-xl text-gray-600 mb-8">Desde 1995, horneando felicidad en cada pizza</p>
                <div class="relative">
                    <img src="../img/cook.jpg" alt="Nuestro chef principal" class="rounded-2xl shadow-xl mx-auto float-animation">
                </div>
            </div>
        </div>
    </div>

    <!-- Nuestra Historia Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto">
                <div class="bg-white rounded-xl shadow-lg p-8 mb-12 transform hover:scale-105 transition-transform duration-300">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6">Nuestra Pasión por la Pizza</h2>
                    <p class="text-gray-600 mb-4">
                        Todo comenzó en una pequeña cocina familiar, donde nuestro fundador, Antonio Rossi, 
                        aprendió los secretos de la auténtica pizza italiana de su nonna. Con recetas 
                        transmitidas por generaciones y un amor incondicional por la gastronomía italiana, 
                        PizzaPlace nació para compartir ese legado con nuestra comunidad.
                    </p>
                    <p class="text-gray-600">
                        Hoy, 28 años después, seguimos fieles a esas tradiciones, combinando ingredientes 
                        frescos de la más alta calidad con técnicas artesanales y un toque de innovación 
                        moderna.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Valores Section -->
    <section class="bg-red-50 py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Nuestros Valores</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="text-red-500 text-4xl mb-4">🌟</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Calidad Premium</h3>
                    <p class="text-gray-600">
                        Seleccionamos cuidadosamente cada ingrediente para garantizar el mejor sabor en cada bocado.
                    </p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="text-red-500 text-4xl mb-4">👨‍👩‍👦</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Tradición Familiar</h3>
                    <p class="text-gray-600">
                        Mantenemos vivas las recetas tradicionales que han deleitado a generaciones.
                    </p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="text-red-500 text-4xl mb-4">💝</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Servicio con Amor</h3>
                    <p class="text-gray-600">
                        Cada cliente es parte de nuestra familia y merece una experiencia excepcional.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Proceso Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Nuestro Proceso</h2>
            <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12">
                <div class="relative">
                    <div class="aspect-w-16 aspect-h-9">
                        <img src="../img/masa.jpg" alt="Preparación de masa" 
                             class="rounded-xl shadow-lg object-cover w-full h-full">
                    </div>
                    <div class="absolute -bottom-4 -right-4 bg-red-500 text-white text-xl font-bold w-16 h-16 rounded-full flex items-center justify-center">
                        01
                    </div>
                </div>
                <div class="flex items-center">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Masa Fresca Diaria</h3>
                        <p class="text-gray-600">
                            Cada mañana, nuestros maestros pizzeros preparan la masa desde cero, 
                            dejándola fermentar durante 24 horas para lograr el sabor y la textura perfectos.
                        </p>
                    </div>
                </div>

                <div class="flex items-center md:order-3">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Ingredientes Selectos</h3>
                        <p class="text-gray-600">
                            Trabajamos con productores locales y proveedores italianos para garantizar 
                            los ingredientes más frescos y auténticos en cada pizza.
                        </p>
                    </div>
                </div>
                <div class="relative md:order-4">
                    <div class="aspect-w-16 aspect-h-9">
                        <img src="../img/ing1.jpg" alt="Ingredientes frescos" 
                             class="rounded-xl shadow-lg object-cover w-full h-full">
                    </div>
                    <div class="absolute -bottom-4 -right-4 bg-red-500 text-white text-xl font-bold w-16 h-16 rounded-full flex items-center justify-center">
                        02
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Equipo Section -->
    <section class="bg-gray-50 py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Nuestro Equipo</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <div class="bg-white rounded-xl overflow-hidden shadow-lg transform hover:scale-105 transition-transform duration-300">
                    <img src="../img/chefol.jpg" alt="Chef Principal" class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Antonio Rossi</h3>
                        <p class="text-gray-600 mb-4">Chef Principal</p>
                        <p class="text-sm text-gray-500">
                            Con más de 30 años de experiencia en la cocina italiana.
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-xl overflow-hidden shadow-lg transform hover:scale-105 transition-transform duration-300">
                    <img src="../img/men2.jpg" alt="Chef de Pasta" class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">María González</h3>
                        <p class="text-gray-600 mb-4">Chef de Pasta</p>
                        <p class="text-sm text-gray-500">
                            Especialista en pasta fresca y salsas tradicionales.
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-xl overflow-hidden shadow-lg transform hover:scale-105 transition-transform duration-300">
                    <img src="../img/man3.jpg" alt="Pizzero Principal" class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Lucas Martínez</h3>
                        <p class="text-gray-600 mb-4">Pizzero Principal</p>
                        <p class="text-sm text-gray-500">
                            Maestro en el arte de la pizza napolitana.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-red-600 to-red-500">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-white mb-8">¿Listo para probar la mejor pizza de la ciudad?</h2>
            <a href="#" class="inline-block bg-white text-red-600 font-bold py-3 px-8 rounded-full hover:bg-gray-100 transition-colors duration-300">
                Ordena Ahora
            </a>
        </div>
    </section>

    @include('fragments.footer')

    <script>
        // Animaciones al hacer scroll
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