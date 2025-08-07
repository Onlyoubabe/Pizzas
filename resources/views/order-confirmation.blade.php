<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pedido Confirmado - PizzaShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-amber-50 min-h-screen">
    @include('fragments.navbar')
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-xl overflow-hidden p-8 mb-8 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 text-green-600 rounded-full mb-6">
                <i class="bi bi-check-lg text-4xl"></i>
            </div>
            
            <h1 class="text-3xl md:text-4xl font-bold mb-4 text-gray-800">¡Pedido Confirmado!</h1>
            <p class="text-gray-600 mb-6">Tu pedido #{{ $order->id }} ha sido recibido y está siendo procesado.</p>
            
            <div class="bg-gray-50 p-6 rounded-lg mb-8">
                <div class="flex justify-between mb-2">
                    <span class="font-medium text-gray-600">Estado:</span>
                    <span class="font-bold text-green-600">
                        @if($order->status == 'paid')
                            Pagado
                        @elseif($order->status == 'preparing')
                            En preparación
                        @elseif($order->status == 'delivering')
                            En camino
                        @elseif($order->status == 'completed')
                            Entregado
                        @else
                            {{ ucfirst($order->status) }}
                        @endif
                    </span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="font-medium text-gray-600">Fecha:</span>
                    <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="font-medium text-gray-600">Total:</span>
                    <span class="font-bold">${{ number_format($order->total, 2) }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="font-medium text-gray-600">Dirección:</span>
                    <span>{{ $order->address }}</span>
                </div>
                @if($order->payment_id)
                <div class="flex justify-between">
                    <span class="font-medium text-gray-600">ID Pago:</span>
                    <span>{{ $order->payment_id }}</span>
                </div>
                @endif
            </div>
            
            <h2 class="text-xl font-bold text-gray-800 mb-4">Detalle del pedido</h2>
            <div class="border rounded-lg overflow-hidden mb-8">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3 px-4 text-left text-gray-600">Producto</th>
                            <th class="py-3 px-4 text-center text-gray-600">Precio</th>
                            <th class="py-3 px-4 text-center text-gray-600">Cantidad</th>
                            <th class="py-3 px-4 text-right text-gray-600">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr class="border-t">
                                <td class="py-3 px-4">{{ $item->pizza->nombre }}</td>
                                <td class="py-3 px-4 text-center">${{ number_format($item->price, 2) }}</td>
                                <td class="py-3 px-4 text-center">{{ $item->quantity }}</td>
                                <td class="py-3 px-4 text-right">${{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr class="border-t">
                            <td colspan="3" class="py-3 px-4 text-right font-bold">Total:</td>
                            <td class="py-3 px-4 text-right font-bold">${{ number_format($order->total, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="flex flex-col md:flex-row justify-center space-y-4 md:space-y-0 md:space-x-4">
                <a href="{{ route('menu') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300">
                    Volver al Menú
                </a>
                @auth
                <a href="{{ route('orders.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300">
                    Ver Mis Pedidos
                </a>
                @endauth
            </div>
        </div>
    </div>
    
    @include('fragments.footer')
</body>
</html>