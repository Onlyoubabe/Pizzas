<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mis Pedidos - PizzaShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .order-card {
            animation: fadeIn 0.5s ease-out forwards;
            animation-delay: calc(var(--animation-order) * 0.1s);
            opacity: 0;
        }
    </style>
</head>
<body class="bg-amber-50 min-h-screen">
    @include('fragments.navbar')
    <div class="container mx-auto px-4 py-16">
        <h1 class="text-4xl md:text-5xl font-bold text-center mb-4 text-red-700" style="margin-top: 40px">Mis Pedidos</h1>
        <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto">Historial de todos tus pedidos realizados en nuestra pizzería.</p>
        
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded shadow-md" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        
        @if($orders->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($orders as $index => $order)
                    <div class="order-card bg-white rounded-xl shadow-lg overflow-hidden" style="--animation-order: {{ $index }}">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-xl font-bold text-gray-800">Pedido #{{ $order->id }}</h2>
                                <span class="px-3 py-1 rounded-full text-sm font-medium 
                                    @if($order->status == 'paid') bg-blue-100 text-blue-700
                                    @elseif($order->status == 'preparing') bg-amber-100 text-amber-700
                                    @elseif($order->status == 'delivering') bg-purple-100 text-purple-700
                                    @elseif($order->status == 'completed') bg-green-100 text-green-700
                                    @elseif($order->status == 'cancelled') bg-red-100 text-red-700
                                    @else bg-gray-100 text-gray-700
                                    @endif">
                                    @if($order->status == 'paid')
                                        Pagado
                                    @elseif($order->status == 'preparing')
                                        En preparación
                                    @elseif($order->status == 'delivering')
                                        En camino
                                    @elseif($order->status == 'completed')
                                        Entregado
                                    @elseif($order->status == 'cancelled')
                                        Cancelado
                                    @else
                                        {{ ucfirst($order->status) }}
                                    @endif
                                </span>
                            </div>
                            
                            <div class="flex justify-between text-sm text-gray-500 mb-4">
                                <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
                                <span class="font-medium">${{ number_format($order->total, 2) }}</span>
                            </div>
                            
                            <div class="border-t border-gray-100 pt-4">
                                <h3 class="font-medium text-gray-700 mb-2">Productos:</h3>
                                <ul class="space-y-2 mb-4">
                                    @foreach($order->items as $item)
                                        <li class="flex justify-between">
                                            <span>{{ $item->quantity }}x {{ $item->pizza->nombre }}</span>
                                            <span>${{ number_format($item->price * $item->quantity, 2) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                                

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-xl shadow-lg p-8 text-center max-w-lg mx-auto">
                <i class="bi bi-receipt text-6xl text-gray-300 mb-4"></i>
                <h2 class="text-2xl font-bold text-gray-700 mb-2">No tienes pedidos</h2>
                <p class="text-gray-500 mb-6">Aún no has realizado ningún pedido. ¡Explora nuestro menú y haz tu primer pedido!</p>
                <a href="{{ route('menu') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 inline-block">
                    Ver Menú de Pizzas
                </a>
            </div>
        @endif
    </div>
    
    @include('fragments.footer')
</body>
</html>