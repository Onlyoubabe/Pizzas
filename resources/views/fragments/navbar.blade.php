<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza Place - Navbar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .nav-link {
            position: relative;
            padding: 0.5rem 1rem;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: #DC2626;
            transition: all 0.3s ease-in-out;
            transform: translateX(-50%);
        }

        .nav-link:hover::after {
            width: 100%;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .mobile-menu {
            animation: slideDown 0.3s ease-in-out;
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }

        .logo:hover {
            animation: bounce 0.5s infinite;
        }

        .order-button {
            transition: all 0.3s ease;
            background: linear-gradient(45deg, #DC2626, #EF4444);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.2);
        }

        .order-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.3);
        }
        
        .role-badge {
            font-size: 0.7rem;
            padding: 0.1rem 0.4rem;
            border-radius: 9999px;
            vertical-align: middle;
        }
        
        .role-admin {
            background-color: #FEE2E2;
            color: #DC2626;
            border: 1px solid #FECACA;
            font-weight: bold;
        }
        
        .role-empleado {
            background-color: #E0F2FE;
            color: #0369A1;
            border: 1px solid #BAE6FD;
            font-weight: bold;
        }
        
        .role-usuario {
            background-color: #F3F4F6;
            color: #6B7280;
            border: 1px solid #E5E7EB;
            font-weight: normal;
        }
    </style>
</head>
<body>
    <nav class="bg-white shadow-lg fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo con ruta condicional -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ auth()->check() ? route('pizzas.index') : route('mainp') }}" class="logo flex items-center space-x-2">
                        <span class="text-3xl">🍕</span>
                        <span class="text-2xl font-bold bg-gradient-to-r from-red-600 to-red-400 bg-clip-text text-transparent">
                            PizzaPlace
                        </span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    @auth
                        <!-- Opciones para admin o empleado -->
                        @if(auth()->user()->isAdmin() || auth()->user()->isEmpleado())
                            <a href="{{ route('menu') }}" 
                               class="nav-link text-gray-700 hover:text-red-600 transition-colors duration-300">
                                Menú
                            </a>
                            <a href="{{ route('pizzas.index') }}" 
                               class="nav-link text-gray-700 hover:text-red-600 transition-colors duration-300">
                                Inicio
                            </a>
                            <a href="{{ route('cart.index') }}" 
                               class="nav-link text-gray-700 hover:text-red-600 transition-colors duration-300 flex items-center">
                                <span>Carrito</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </a>
                            <a href="{{ route('admin.orders.index') }}" 
                               class="nav-link text-gray-700 hover:text-red-600 transition-colors duration-300">
                                Órdenes
                            </a>
                        @else
                            <!-- Opciones para usuario regular -->
                            <a href="{{ route('menu') }}" 
                               class="nav-link text-gray-700 hover:text-red-600 transition-colors duration-300">
                                Menú
                            </a>
                            <a href="{{ route('nosotros') }}" 
                               class="nav-link text-gray-700 hover:text-red-600 transition-colors duration-300">
                                Nosotros
                            </a>
                            <a href="{{ route('contacto') }}" 
                               class="nav-link text-gray-700 hover:text-red-600 transition-colors duration-300">
                                Contacto
                            </a>
                            <a href="{{ route('cart.index') }}" 
                               class="nav-link text-gray-700 hover:text-red-600 transition-colors duration-300 flex items-center">
                                <span>Carrito</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </a>
                            <a href="{{ route('orders.index') }}" 
                               class="nav-link text-gray-700 hover:text-red-600 transition-colors duration-300">
                                Mis Pedidos
                            </a>
                        @endif

                        <div class="flex items-center space-x-4">
                            <div class="text-gray-700 flex items-center">
                                @if(auth()->user()->isAdmin())
                                    <span class="role-badge role-admin">Admin</span>
                                @elseif(auth()->user()->isEmpleado())
                                    <span class="role-badge role-empleado">Empleado</span>
                                @else
                                    <span class="role-badge role-usuario">Usuario</span>
                                @endif
                            </div>
                            <form action="{{ route('logout') }}" method="GET" class="inline">
                                @csrf
                                <button type="submit" class="nav-link text-gray-700 hover:text-red-600 transition-colors duration-300">
                                    Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    @else
                        <!-- Opciones para visitantes -->
                        <a href="{{ route('mainp') }}" 
                           class="nav-link text-gray-700 hover:text-red-600 transition-colors duration-300">
                            Inicio
                        </a>
                        <a href="{{ route('nosotros') }}" 
                           class="nav-link text-gray-700 hover:text-red-600 transition-colors duration-300">
                            Nosotros
                        </a>
                        <a href="{{ route('contacto') }}" 
                           class="nav-link text-gray-700 hover:text-red-600 transition-colors duration-300">
                            Contacto
                        </a>
                        <a href="{{ route('login') }}" 
                           class="nav-link text-gray-700 hover:text-red-600 transition-colors duration-300">
                            Iniciar Sesión
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-gray-700 hover:text-red-600 focus:outline-none">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden mobile-menu bg-white shadow-lg px-2 py-3">
            @auth
                <!-- Mostrar solo rol en el menú móvil -->
                <div class="px-4 py-2 text-sm text-gray-700 border-b border-gray-100 mb-2">
                    <div class="flex items-center">
                        @if(auth()->user()->isAdmin())
                            <span class="role-badge role-admin">Admin</span>
                        @elseif(auth()->user()->isEmpleado())
                            <span class="role-badge role-empleado">Empleado</span>
                        @else
                            <span class="role-badge role-usuario">Usuario</span>
                        @endif
                    </div>
                </div>
            
                @if(auth()->user()->isAdmin() || auth()->user()->isEmpleado())
                    <a href="{{ route('menu') }}" class="block px-4 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-md">
                        Menú
                    </a>
                    <a href="{{ route('pizzas.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-md">
                        Inicio
                    </a>
                    <a href="{{ route('cart.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-md flex items-center">
                        <span>Carrito</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-md">
                        Órdenes
                    </a>
                @else
                    <a href="{{ route('menu') }}" class="block px-4 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-md">
                        Menú
                    </a>
                    <a href="{{ route('nosotros') }}" class="block px-4 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-md">
                        Nosotros
                    </a>
                    <a href="{{ route('contacto') }}" class="block px-4 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-md">
                        Contacto
                    </a>
                    <a href="{{ route('cart.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-md flex items-center">
                        <span>Carrito</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </a>
                    <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-md">
                        Mis Pedidos
                    </a>
                @endif
                <form action="{{ route('logout') }}" method="GET" class="block">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-md">
                        Cerrar Sesión
                    </button>
                </form>
            @else
                <a href="{{ route('mainp') }}" class="block px-4 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-md">
                    Inicio
                </a>
                <a href="{{ route('nosotros') }}" class="block px-4 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-md">
                    Nosotros
                </a>
                <a href="{{ route('contacto') }}" class="block px-4 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-md">
                    Contacto
                </a>
                <a href="{{ route('login') }}" class="block px-4 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-md">
                    Iniciar Sesión
                </a>
            @endauth
        </div>
    </nav>
    <script>
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Cerrar menú móvil al hacer click fuera
        document.addEventListener('click', (e) => {
            if (!mobileMenu.contains(e.target) && !mobileMenuButton.contains(e.target)) {
                mobileMenu.classList.add('hidden');
            }
        });

        // Efecto de scroll
        let lastScroll = 0;
        const navbar = document.querySelector('nav');

        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;
            
            if (currentScroll <= 0) {
                navbar.style.transform = 'translateY(0)';
                return;
            }
            
            if (currentScroll > lastScroll && !mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.add('hidden');
            }
            
            if (currentScroll > lastScroll && currentScroll > 100) {
                navbar.style.transform = 'translateY(-100%)';
            } else {
                navbar.style.transform = 'translateY(0)';
            }
            
            lastScroll = currentScroll;
        });
    </script>
</body>
</html>