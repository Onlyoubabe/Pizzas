<!-- resources/views/home.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PizzaPlace - Las Mejores Pizzas Artesanales</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

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

        @keyframes scaleIn {
            from {
                transform: scale(0.9);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .scale-in {
            animation: scaleIn 0.5s ease-out forwards;
        }

        .floating {
            animation: float 6s ease-in-out infinite;
        }

        .pizza-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .pizza-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .scroll-reveal {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }

        .scroll-reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .bg-pattern {
            background-image: radial-gradient(circle at 1px 1px, #f3f4f6 1px, transparent 0);
            background-size: 20px 20px;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('fragments.navbar')

    <!-- Hero Section -->
    <section class="pt-24 pb-12 bg-pattern">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div class="fade-in-up">
                    <h1 class="text-4xl md:text-6xl font-bold mb-4 bg-gradient-to-r from-red-600 to-red-400 bg-clip-text text-transparent">
                        Descubre el Verdadero Sabor de Italia
                    </h1>
                    <p class="text-gray-600 text-lg mb-8">
                        Pizzas artesanales horneadas en horno de leña, con ingredientes frescos y recetas tradicionales.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#menu" class="bg-red-600 text-white px-8 py-3 rounded-full font-medium hover:bg-red-700 transition-colors duration-300">
                            Ver Menú
                        </a>
                        <a href="{{ route('login') }}" class="border-2 border-red-600 text-red-600 px-8 py-3 rounded-full font-medium hover:bg-red-50 transition-colors duration-300">
                            ¡Pide Ahora!
                        </a>
                    </div>
                </div>
                <div class="floating">
                    <img src="../img/pizza.jpg" alt="Pizza" class="rounded-lg shadow-2xl">
                </div>
            </div>
        </div>
    </section>

    <!-- Características -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12 scale-in">¿Por qué elegir PizzaPlace?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="scroll-reveal p-6 text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-fire text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Horno de Leña</h3>
                    <p class="text-gray-600">Cocción tradicional que realza el sabor de cada ingrediente.</p>
                </div>
                <div class="scroll-reveal p-6 text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-award text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Ingredientes Premium</h3>
                    <p class="text-gray-600">Seleccionamos los mejores ingredientes frescos y de temporada.</p>
                </div>
                <div class="scroll-reveal p-6 text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-clock-history text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Entrega Rápida</h3>
                    <p class="text-gray-600">Tu pizza caliente en menos de 30 minutos o es gratis.</p>
                </div>
            </div>
        </div>
    </section>

<!-- Menú Destacado -->
<section id="menu" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center mb-12 scale-in">Nuestras Pizzas Más Populares</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($pizzas as $pizza)
            <div class="pizza-card bg-white rounded-lg overflow-hidden shadow-lg">
                <img src="{{ $pizza->imagen ? asset('storage/' . $pizza->imagen) : '../img/pizza2.jpg' }}" alt="{{ $pizza->nombre }}" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-2">{{ $pizza->nombre }}</h3>
                    <p class="text-gray-600 mb-4">{{ $pizza->descripcion }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-2xl font-bold text-red-600">${{ number_format($pizza->precio, 2) }}</span>
                        <button class="bg-red-600 text-white px-4 py-2 rounded-full hover:bg-red-700 transition-colors duration-300">
                            <a href="{{ route('login') }}">Ordenar</a>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


    @include('fragments.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script>
        // Animación de elementos al hacer scroll
        const scrollRevealElements = document.querySelectorAll('.scroll-reveal');

        const revealOnScroll = () => {
            scrollRevealElements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const windowHeight = window.innerHeight;

                if (elementTop < windowHeight * 0.85) {
                    element.classList.add('visible');
                }
            });
        };

        window.addEventListener('scroll', revealOnScroll);
        window.addEventListener('load', revealOnScroll);
    </script>
</body>
</html>