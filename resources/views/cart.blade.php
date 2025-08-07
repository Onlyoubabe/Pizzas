<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Carrito de Compras - PizzaShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>
</head>
<body class="bg-amber-50 min-h-screen">
    @include('fragments.navbar')
    <div class="container mx-auto px-4 py-16">
        <h1 class="text-4xl md:text-5xl font-bold text-center mb-4 text-red-700" style="margin-top: 40px">Tu Carrito de Compras</h1>
        <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto">Revisa los productos que has seleccionado y procede al pago cuando estés listo.</p>
        
        <!-- Alerta de éxito -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded shadow-md fade-in" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        <!-- Alerta de error -->
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-8 rounded shadow-md fade-in" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif
        
        @if($cartItems->count() > 0)
            <div class="bg-white rounded-xl shadow-xl overflow-hidden p-6 mb-8">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-200">
                                <th class="py-3 px-4 text-left">Producto</th>
                                <th class="py-3 px-4 text-center">Precio</th>
                                <th class="py-3 px-4 text-center">Cantidad</th>
                                <th class="py-3 px-4 text-right">Total</th>
                                <th class="py-3 px-4 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center">
                                            @if($item->pizza->imagen)
                                                <img src="{{ asset('storage/' . $item->pizza->imagen) }}" alt="{{ $item->pizza->nombre }}" class="w-16 h-16 object-cover rounded-lg mr-4">
                                            @else
                                                <img src="https://via.placeholder.com/64?text=Pizza" alt="{{ $item->pizza->nombre }}" class="w-16 h-16 object-cover rounded-lg mr-4">
                                            @endif
                                            <div>
                                                <h3 class="font-semibold text-gray-800">{{ $item->pizza->nombre }}</h3>
                                                <p class="text-gray-500 text-sm">{{ Str::limit($item->pizza->descripcion, 50) }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-center">${{ number_format($item->pizza->precio, 2) }}</td>
                                    <td class="py-4 px-4">
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center justify-center">
                                            @csrf
                                            @method('PUT')
                                            <button type="button" onclick="decrementQuantity(this)" class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors">
                                                <i class="bi bi-dash"></i>
                                            </button>
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="mx-2 w-12 text-center border-gray-200 rounded-md focus:border-red-500 focus:ring focus:ring-red-200">
                                            <button type="button" onclick="incrementQuantity(this)" class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition-colors">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                            <button type="submit" class="ml-2 text-blue-500 hover:text-blue-700">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="py-4 px-4 text-right font-semibold">${{ number_format($item->pizza->precio * $item->quantity, 2) }}</td>
                                    <td class="py-4 px-4 text-center">
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 transition-colors">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="border-t-2 border-gray-200 bg-gray-50">
                                <td colspan="3" class="py-4 px-4 text-right font-bold">Total:</td>
                                <td class="py-4 px-4 text-right font-bold text-xl text-red-600">${{ number_format($total, 2) }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            
            <div class="flex justify-between">
                <a href="{{ route('menu') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 inline-flex items-center">
                    <i class="bi bi-arrow-left mr-2"></i> Seguir comprando
                </a>
                <a href="{{ route('checkout') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 inline-flex items-center">
                    Proceder al pago <i class="bi bi-arrow-right ml-2"></i>
                </a>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-lg p-8 text-center max-w-lg mx-auto">
                <i class="bi bi-cart-x text-6xl text-gray-300 mb-4"></i>
                <h2 class="text-2xl font-bold text-gray-700 mb-2">Tu carrito está vacío</h2>
                <p class="text-gray-500 mb-6">No hay productos en tu carrito. ¡Explora nuestro menú y elige tus pizzas favoritas!</p>
                <a href="{{ route('menu') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 inline-block">
                    Ver Menú de Pizzas
                </a>
            </div>
        @endif
    </div>
    
    @include('fragments.footer')
    
    <script>
        function decrementQuantity(button) {
            const input = button.parentNode.querySelector('input[name="quantity"]');
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
            }
        }
        
        function incrementQuantity(button) {
            const input = button.parentNode.querySelector('input[name="quantity"]');
            input.value = parseInt(input.value) + 1;
        }
    </script>
</body>
</html>