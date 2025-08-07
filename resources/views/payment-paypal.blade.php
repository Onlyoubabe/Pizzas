<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Procesando Pago - PizzaShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- PayPal JS SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id=test&currency=USD"></script>
</head>
<body class="bg-amber-50 min-h-screen">
    @include('fragments.navbar')
    <div class="container mx-auto px-4 py-16">
        <h1 class="text-4xl md:text-5xl font-bold text-center mb-4 text-red-700" style="margin-top: 40px">Procesando tu pago</h1>
        <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto">Por favor completa el proceso de pago con PayPal.</p>
        
        <div class="max-w-md mx-auto bg-white rounded-xl shadow-xl overflow-hidden p-6 mb-8">
            <div class="text-center mb-6">
                <img src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_111x69.jpg" alt="PayPal" class="h-14 mx-auto mb-4">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Total a pagar: ${{ number_format($paypalParams['total'], 2) }}</h2>
                <p class="text-gray-500">Orden #{{ $paypalParams['order_id'] }}</p>
            </div>
            
            <!-- PayPal Button Container -->
            <div id="paypal-button-container" class="mb-6"></div>
            
            <div class="text-center">
                <a href="{{ $paypalParams['cancel_url'] }}" class="text-gray-500 hover:text-gray-700 transition-colors">
                    <i class="bi bi-arrow-left mr-1"></i> Cancelar y volver al carrito
                </a>
            </div>
        </div>
    </div>
    
    @include('fragments.footer')
    
    <script>
        // Renderizar botones de PayPal
        paypal.Buttons({
            // Configurar la transacción
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '{{ $paypalParams['total'] }}'
                        },
                        description: 'Pedido en PizzaShop #{{ $paypalParams['order_id'] }}'
                    }]
                });
            },
            
            // Finalizar la transacción
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    // Mostrar mensaje de éxito
                    document.querySelector('#paypal-button-container').innerHTML = `
                        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4 text-center">
                            <i class="bi bi-check-circle text-3xl mb-2"></i>
                            <h3 class="font-bold text-lg">¡Pago completado!</h3>
                            <p>Gracias por tu compra, ${details.payer.name.given_name}.</p>
                        </div>
                        <div class="text-center">
                            <p class="text-gray-500 mb-4">Estamos procesando tu pedido...</p>
                            <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-red-700 mx-auto"></div>
                        </div>
                    `;
                    
                    // Redirigir a la página de éxito después de 3 segundos
                    setTimeout(function() {
                        window.location.href = '{{ $paypalParams['return_url'] }}?paymentId=' + details.id;
                    }, 3000);
                });
            },
            
            // Estilo de los botones
            style: {
                color: 'blue',
                shape: 'pill',
                label: 'pay',
                height: 50
            }
        }).render('#paypal-button-container');
    </script>
</body>
</html>