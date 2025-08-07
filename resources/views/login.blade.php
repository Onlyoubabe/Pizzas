<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PizzaPlace - Iniciar Sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        @keyframes slideInFromRight {
            0% {
                transform: translateX(100%);
                opacity: 0;
            }
            100% {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideInFromLeft {
            0% {
                transform: translateX(-100%);
                opacity: 0;
            }
            100% {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes floatPizza {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }

        .slide-in-right {
            animation: slideInFromRight 0.8s ease-out forwards;
        }

        .slide-in-left {
            animation: slideInFromLeft 0.8s ease-out forwards;
        }

        .float-pizza {
            animation: floatPizza 6s ease-in-out infinite;
        }

        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-group input {
            width: 100%;
            padding: 0.75rem 1rem;
            padding-left: 2.5rem;
            border: 2px solid transparent;
            border-radius: 0.5rem;
            outline: none;
            background-color: #f3f4f6;
            transition: all 0.3s ease;
        }

        .input-group input:focus {
            border-color: #DC2626;
            background-color: white;
            box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.1);
        }

        .input-group i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6B7280;
            transition: color 0.3s ease;
        }

        .input-group input:focus + i {
            color: #DC2626;
        }

        .social-btn {
            transition: all 0.3s ease;
        }

        .social-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .bg-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23DC2626' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="bg-pattern">
    @include('fragments.navbar')

    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl w-full space-y-8 flex bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Lado izquierdo - Formulario -->
            <div class="w-full md:w-1/2 p-8 slide-in-left">
                <div class="text-center mb-8">
                    @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <h2 class="text-3xl font-bold text-gray-900">
                        ¡Bienvenido de nuevo!
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Inicia sesión para acceder a ofertas exclusivas
                    </p>
                </div>

                <form class="space-y-6" action="{{ route('inicia-sesion') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <input type="email" name="email" required placeholder="Correo electrónico">
                        <i class="bi bi-envelope"></i>
                    </div>

                    <div class="input-group">
                        <input type="password" name="password" required placeholder="Contraseña">
                        <i class="bi bi-lock"></i>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input type="checkbox" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded" name="remember">
                            <label class="ml-2 block text-sm text-gray-900">
                                Recordarme
                            </label>
                        </div>

                        <a href="{{route ('forgotpassword')}}" class="text-sm font-medium text-red-600 hover:text-red-500">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>

                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-300">
                        Iniciar Sesión
                    </button>
                </form>

                <!-- Separador entre opciones -->
                <div class="my-6 flex items-center">
                    <div class="flex-grow border-t border-gray-300"></div>
                    <span class="px-4 text-gray-500 text-sm">O continúa con</span>
                    <div class="flex-grow border-t border-gray-300"></div>
                </div>

                <!-- Botón de inicio de sesión con Google -->
                <div class="mb-4">
                    <a href="{{ route('auth.google') }}" class="w-full flex justify-center items-center py-3 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-300 social-btn">
                        <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                            <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"></path>
                            <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"></path>
                            <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"></path>
                            <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"></path>
                        </svg>
                        Iniciar sesión con Google
                    </a>
                </div>

                <p class="mt-4 text-center text-sm text-gray-600">
                    ¿No tienes una cuenta?
                    <a href="{{ route('register') }}" class="font-medium text-red-600 hover:text-red-500">
                        Regístrate aquí
                    </a>
                </p>
            </div>

            <!-- Lado derecho - Imagen -->
            <div class="hidden md:block w-1/2 bg-red-600 p-12 slide-in-right">
                <div class="h-full flex flex-col justify-center items-center text-white">
                    <div class="float-pizza mb-8">
                        <span class="text-8xl">🍕</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">¡Únete a nuestra familia!</h3>
                    <p class="text-center text-red-100">
                        Disfruta de descuentos exclusivos, acumula puntos y recibe ofertas especiales.
                    </p>
                </div>
            </div>
        </div>
    </div>

    @include('fragments.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
</body>
</html>