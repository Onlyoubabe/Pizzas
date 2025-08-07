<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Menú - Pizzas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .pizza-card {
            animation: fadeIn 0.5s ease-out forwards;
            animation-delay: calc(var(--animation-order) * 0.1s);
            opacity: 0;
        }
        .pizza-card:hover {
            transform: translateY(-10px);
        }
    </style>
</head>
<body class="bg-amber-50 min-h-screen">
    @include('fragments.navbar')
    <div class="container mx-auto px-4 py-16">
        <h1 class="text-4xl md:text-5xl font-bold text-center mb-4 text-red-700" style="margin-top: 40px">Nuestras Deliciosas Pizzas</h1>
        <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto">Disfruta de nuestras increíbles pizzas hechas con ingredientes frescos y recetas tradicionales italianas adaptadas a tus gustos.</p>
        
        <!-- Alerta de éxito -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded shadow-md" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        <!-- Alerta de error -->
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-8 rounded shadow-md" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif
        
        <div x-data="{ 
            showModal: false, 
            currentPizza: null,
            quantity: 1,
            
            openModal(pizza) {
                this.currentPizza = pizza;
                this.quantity = 1;
                this.showModal = true;
                document.body.classList.add('overflow-hidden');
            },
            closeModal() {
                this.showModal = false;
                document.body.classList.remove('overflow-hidden');
            },
            incrementQuantity() {
                this.quantity++;
            },
            decrementQuantity() {
                if (this.quantity > 1) this.quantity--;
            }
        }">
            <!-- Grid de Pizzas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($pizzas as $index => $pizza)
                <div class="pizza-card bg-white rounded-xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl" style="--animation-order: {{ $index }}">
                    <div class="relative overflow-hidden h-56">
                        @if($pizza->imagen)
                            <img src="{{ asset('storage/' . $pizza->imagen) }}" alt="{{ $pizza->nombre }}" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110">
                        @else
                            <img src="https://via.placeholder.com/300x200?text=Pizza" alt="{{ $pizza->nombre }}" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110">
                        @endif
                        <div class="absolute top-0 right-0 bg-red-600 text-white px-3 py-1 font-bold rounded-bl-lg shadow-md">
                            ${{ number_format($pizza->precio, 2) }}
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $pizza->nombre }}</h2>
                        <p class="text-gray-600 mb-4 line-clamp-2">{{ $pizza->descripcion }}</p>
                        
                        <div class="flex space-x-3">
                            <button 
                                @click="openModal({
                                    id: {{ $pizza->id }},
                                    nombre: '{{ $pizza->nombre }}',
                                    descripcion: '{{ $pizza->descripcion }}',
                                    precio: {{ $pizza->precio }},
                                    imagen: '{{ $pizza->imagen ? asset('storage/' . $pizza->imagen) : 'https://via.placeholder.com/500x300?text=Pizza' }}'
                                })"
                                class="flex-1 bg-amber-500 hover:bg-amber-600 text-white font-bold py-2 px-4 rounded-lg transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:ring-opacity-50"
                            >
                                <i class="bi bi-eye mr-2"></i> Ver Detalles
                            </button>
                            <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="pizza_id" value="{{ $pizza->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50">
                                    <i class="bi bi-cart-plus mr-2"></i> Al Carrito
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <!-- Modal de Detalles -->
            <div 
                x-show="showModal" 
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90"
                class="fixed inset-0 z-50 flex items-center justify-center p-4"
                style="display: none;"
            >
                <div class="absolute inset-0 bg-black bg-opacity-50 backdrop-blur-sm" @click="closeModal"></div>
                
                <div class="relative bg-white rounded-2xl overflow-hidden max-w-3xl w-full max-h-[90vh] flex flex-col md:flex-row shadow-2xl">
                    <!-- Imagen -->
                    <div class="md:w-1/2 h-64 md:h-auto relative">
                        <img :src="currentPizza?.imagen" :alt="currentPizza?.nombre" class="w-full h-full object-cover">
                        <div class="absolute top-0 right-0 bg-red-600 text-white px-4 py-2 font-bold rounded-bl-xl shadow-lg text-xl">
                            $<span x-text="currentPizza?.precio.toFixed(2)"></span>
                        </div>
                    </div>
                    
                    <!-- Contenido -->
                    <div class="md:w-1/2 p-6 md:p-8 overflow-y-auto">
                        <button @click="closeModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 transition-colors">
                            <i class="bi bi-x-circle text-2xl"></i>
                        </button>
                        
                        <h2 class="text-3xl font-bold text-gray-800 mb-4" x-text="currentPizza?.nombre"></h2>
                        
                        <div class="mb-6">
                            <h3 class="text-xl font-semibold mb-2 text-gray-700">Descripción:</h3>
                            <p class="text-gray-600" x-text="currentPizza?.descripcion"></p>
                        </div>
                        
                        <div class="mb-6">
                            <h3 class="text-xl font-semibold mb-2 text-gray-700">Ingredientes:</h3>
                            <ul class="list-disc pl-5 text-gray-600">
                                <li>Masa fresca artesanal</li>
                                <li>Salsa de tomate natural</li>
                                <li>Queso mozzarella</li>
                                <li>Orégano y especias</li>
                                <li>Aceite de oliva virgen</li>
                            </ul>
                        </div>
                        
                        <form action="{{ route('cart.add') }}" method="POST" class="mb-6">
                            @csrf
                            <input type="hidden" name="pizza_id" :value="currentPizza?.id">
                            
                            <div class="flex items-center mb-4">
                                <span class="text-xl font-semibold text-gray-700 mr-4">Cantidad:</span>
                                <div class="flex items-center border rounded-lg overflow-hidden">
                                    <button 
                                        type="button" 
                                        @click="decrementQuantity" 
                                        class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xl"
                                    >
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <input 
                                        type="number" 
                                        name="quantity" 
                                        x-model="quantity" 
                                        min="1" 
                                        class="w-12 text-center py-1 border-none focus:ring-0"
                                        readonly
                                    >
                                    <button 
                                        type="button" 
                                        @click="incrementQuantity" 
                                        class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xl"
                                    >
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="flex space-x-3">
                                <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50">
                                    <i class="bi bi-cart-plus mr-2"></i> Añadir al Carrito
                                </button>
                                <button type="button" @click="closeModal" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-3 px-6 rounded-lg transition-all duration-300">
                                    Cancelar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('fragments.footer')
    <script>
        // Scroll Reveal para animaciones adicionales
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.pizza-card');
            
            // Agregar hover effect con sonido (simulado con clases)
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.classList.add('shadow-2xl');
                });
                
                card.addEventListener('mouseleave', function() {
                    this.classList.remove('shadow-2xl');
                });
            });
        });
    </script>
</body>
</html>