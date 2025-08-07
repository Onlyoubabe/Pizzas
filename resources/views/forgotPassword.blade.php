<!-- resources/views/auth/forgotpassword.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PizzaPlace - Recuperar Contraseña</title>
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
                    @if (session('status'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('status') }}
                    </div>
                    @elseif ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <h2 class="text-3xl font-bold text-gray-900">
                        ¿Olvidaste tu contraseña?
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña
                    </p>
                </div>

                <form class="space-y-6" action="{{ url('/forgotPassword') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <input type="email" name="email" id="email" required placeholder="Correo electrónico">
                        <i class="bi bi-envelope"></i>
                    </div>

                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-300">
                        <i class="bi bi-send me-2"></i>
                        Enviar enlace de restablecimiento
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-gray-600">
                    ¿Recordaste tu contraseña?
                    <a href="{{ route('login') }}" class="font-medium text-red-600 hover:text-red-500">
                        Iniciar sesión
                    </a>
                </p>
            </div>

            <!-- Lado derecho - Imagen -->
            <div class="hidden md:block w-1/2 bg-red-600 p-12 slide-in-right">
                <div class="h-full flex flex-col justify-center items-center text-white">
                    <div class="float-pizza mb-8">
                        <span class="text-8xl">🔑</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Recupera el acceso</h3>
                    <p class="text-center text-red-100">
                        Te enviaremos instrucciones para restablecer tu contraseña y volver a disfrutar de tus pizzas favoritas.
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