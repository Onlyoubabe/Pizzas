<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Checkout - PizzaShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-amber-50 min-h-screen">
    @include('fragments.navbar')
    <div class="container mx-auto px-4 py-16">
        <h1 class="text-4xl md:text-5xl font-bold text-center mb-4 text-red-700" style="margin-top: 40px">Finaliza tu Pedido</h1>
        <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto">Completa tus datos de envío y procede al pago.</p>
        
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-8 rounded shadow-md" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Formulario de datos de envío -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-xl overflow-hidden p-6 mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Datos de entrega</h2>
                    
                    <form action="{{ route('payment.process') }}" method="POST" id="checkoutForm">
                        @csrf
                        <div class="mb-6">
                            <label for="address" class="block text-gray-700 font-medium mb-2">Dirección de entrega</label>
                            <input type="text" id="address" name="address" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring focus:ring-red-200 focus:border-red-500" placeholder="Calle, número, colonia, ciudad" required value="{{ auth()->user()->address ?? old('address') }}">
                            @error('address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-6">
                            <label for="phone" class="block text-gray-700 font-medium mb-2">Teléfono de contacto</label>
                            <input type="tel" id="phone" name="phone" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring focus:ring-red-200 focus:border-red-500" placeholder="Teléfono" required value="{{ auth()->user()->phone ?? old('phone') }}">
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-6">
                            <label for="notes" class="block text-gray-700 font-medium mb-2">Instrucciones adicionales (opcional)</label>
                            <textarea id="notes" name="notes" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring focus:ring-red-200 focus:border-red-500" placeholder="Instrucciones especiales para la entrega">{{ old('notes') }}</textarea>
                        </div>
                        
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Método de pago</h3>
                            
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                                <div class="flex items-center">
                                    <input type="radio" id="paypal" name="payment_method" value="paypal" class="h-5 w-5 text-blue-600" checked>
                                    <label for="paypal" class="ml-2 flex items-center">
                                        <span class="text-gray-700 font-medium mr-2">PayPal</span>
                                        <img src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_37x23.jpg" alt="PayPal" class="h-6">
                                    </label>
                                </div>
                                <p class="text-sm text-gray-500 mt-2 ml-7">Paga de forma segura con tu cuenta de PayPal o tarjeta de crédito/débito.</p>
                            </div>
                        </div>
                        
                        <div class="flex justify-between">
                            <a href="{{ route('cart.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 inline-flex items-center">
                                <i class="bi bi-arrow-left mr-2"></i> Volver al carrito
                            </a>
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 inline-flex items-center">
                                Proceder al pago <i class="bi bi-credit-card ml-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Resumen del pedido -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-xl overflow-hidden p-6 sticky top-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Resumen del pedido</h2>
                    
                    <div class="space-y-4 mb-6">
                        @foreach($cartItems as $item)
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <div class="flex items-center">
                                    @if($item->pizza->imagen)
                                    <img src="{{ asset('storage/' . $item->pizza->imagen) }}" alt="{{ $item->pizza->nombre }}" class="w-12 h-12 object-cover rounded-lg mr-3">
                                    @else
                                        <img src="https://via.placeholder.com/48?text=Pizza" alt="{{ $item->pizza->nombre }}" class="w-12 h-12 object-cover rounded-lg mr-3">
                                    @endif
                                    <div>
                                        <h4 class="font-medium text-gray-800">{{ $item->pizza->nombre }}</h4>
                                        <p class="text-gray-500 text-sm">{{ $item->quantity }} x ${{ number_format($item->pizza->precio, 2) }}</p>
                                    </div>
                                </div>
                                <span class="font-medium">${{ number_format($item->pizza->precio * $item->quantity, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4 pb-2">
                        <div class="flex justify-between items-center py-2">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium">${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-gray-600">Costo de envío</span>
                            <span class="font-medium">Gratis</span>
                        </div>
                    </div>
                    
                    <div class="border-t-2 border-gray-200 pt-4 mt-2">
                        <div class="flex justify-between items-center py-2">
                            <span class="font-bold text-lg">Total</span>
                            <span class="font-bold text-xl text-red-600">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @include('fragments.footer')
</body>
</html>