<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ isset($message) ? 'Detalle de Pedido' : 'Gestión de Pedidos' }} - Panel Administrativo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    @include('fragments.navbar')
    
    <div class="container mx-auto px-4 py-16">
        
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded shadow-md" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-8 rounded shadow-md" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif
        
        @if(isset($message))
            <!-- Vista de detalle de pedido -->
            <div class="mb-6 flex justify-between items-center">
                <a href="{{ route('pedidos.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors">
                    <i class="bi bi-arrow-left mr-2"></i> Volver a gestión de pedidos
                </a>
                
                <div class="flex gap-3">
                    @if(in_array($message->status, ['completado', 'cancelado']))
                        <form action="{{ route('pedidos.destroy', $message) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este pedido? Esta acción no se puede deshacer.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                                <i class="bi bi-trash mr-2"></i> Eliminar Pedido
                            </button>
                        </form>
                    @endif
                    
                    @if($message->status != 'cancelado')
                        <form action="{{ route('pedidos.update-status', $message) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg p-2.5 mr-2">
                                <option value="pendiente" {{ $message->status == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="en_proceso" {{ $message->status == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                                <option value="completado" {{ $message->status == 'completado' ? 'selected' : '' }}>Completado</option>
                                <option value="cancelado" {{ $message->status == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                                <i class="bi bi-check-circle mr-2"></i> Actualizar Estado
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            
            <h1 class="text-3xl md:text-4xl font-bold mb-4 text-red-700">Pedido #{{ $message->id }} - Cliente: {{ $message->user->name }}</h1>
            
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Información del Pedido -->
                <div class="md:col-span-1">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="relative h-48">
                            @if($message->pizza->imagen)
                                <img src="{{ asset('storage/' . $message->pizza->imagen) }}" alt="{{ $message->pizza->nombre }}" class="w-full h-full object-cover">
                            @else
                                <img src="https://via.placeholder.com/300x200?text=Pizza" alt="{{ $message->pizza->nombre }}" class="w-full h-full object-cover">
                            @endif
                            <div class="absolute top-0 right-0 bg-red-600 text-white px-3 py-1 m-2 font-bold rounded-lg shadow-md">
                                ${{ number_format($message->pizza->precio, 2) }}
                            </div>
                        </div>
                        
                        <div class="p-5">
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $message->pizza->nombre }}</h2>
                            <p class="text-gray-600 mb-4">{{ $message->pizza->descripcion }}</p>
                            
                            <div class="space-y-3 mb-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Estado:</span>
                                    <span 
                                        class="px-3 py-1 rounded-full text-xs font-medium
                                        {{ $message->status == 'pendiente' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $message->status == 'en_proceso' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $message->status == 'completado' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $message->status == 'cancelado' ? 'bg-red-100 text-red-800' : '' }}
                                        "
                                    >
                                        {{ ucfirst(str_replace('_', ' ', $message->status)) }}
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Fecha:</span>
                                    <span class="text-gray-800">{{ $message->created_at->format('d/m/Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Hora:</span>
                                    <span class="text-gray-800">{{ $message->created_at->format('H:i') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Usuario:</span>
                                    <span class="text-gray-800">{{ $message->user->name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Email:</span>
                                    <span class="text-gray-800">{{ $message->user->email }}</span>
                                </div>
                            </div>
                            
                            <!-- Dirección del cliente (si existe) -->
                            @if($message->user->address)
                            <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                                <h3 class="font-bold text-gray-700 mb-2"><i class="bi bi-geo-alt mr-2"></i>Dirección de entrega</h3>
                                <p class="text-gray-600">{{ $message->user->address }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Historial de Conversación - Estilo WhatsApp -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden h-full">
                        <!-- Cabecera del chat -->
                        <div class="bg-blue-600 text-white p-4 flex items-center">
                            <div class="mr-3">
                                <i class="bi bi-headset text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold">Conversación con cliente</h3>
                                <p class="text-xs text-blue-100">
                                    Pedido #{{ $message->id }} - {{ ucfirst(str_replace('_', ' ', $message->status)) }}
                                </p>
                            </div>
                        </div>
                        
                        <!-- Contenedor del chat -->
                        <div class="chat-container p-4" style="height: 500px; overflow-y: auto;">
                            <div class="flex justify-center mb-6">
                                <div class="bg-white px-3 py-1 rounded-full text-xs text-gray-600 shadow">
                                    {{ $message->created_at->format('d/m/Y') }}
                                </div>
                            </div>
                            
                            @php
                                // Procesamos el mensaje completo para extraer cada parte de la conversación
                                $fullMessage = $message->message;
                                $conversation = [];
                                
                                // Separar el mensaje en líneas
                                $messageLines = preg_split('/\r\n|\r|\n/', $fullMessage);
                                
                                $currentSender = null;
                                $currentContent = '';
                                $messageIndex = 0;
                                
                                foreach ($messageLines as $line) {
                                    $line = trim($line);
                                    if (empty($line)) continue;
                                    
                                    // Buscar patrones como "Tú:", "Pizzería:" o "Sistema:"
                                    if (preg_match('/^(Tú|Pizzería|Admin|Sistema):\s*(.*)/i', $line, $matches)) {
                                        // Si ya teníamos un mensaje acumulado, lo guardamos primero
                                        if (!empty($currentContent) && $currentSender !== null) {
                                            $conversation[] = [
                                                'sender' => $currentSender,
                                                'content' => trim($currentContent),
                                                'time' => $message->created_at->addMinutes($messageIndex * 2)
                                            ];
                                            $messageIndex++;
                                            $currentContent = '';
                                        }
                                        
                                        $currentSender = strtolower($matches[1]);
                                        $currentContent = $matches[2];
                                    } else {
                                        // Si no es un nuevo remitente, añadimos al contenido actual
                                        if ($currentSender !== null) {
                                            $currentContent .= " " . $line;
                                        } else {
                                            // Si no tenemos remitente, asumimos que es de la pizzería
                                            $currentSender = 'pizzería';
                                            $currentContent = $line;
                                        }
                                    }
                                }
                                
                                // No olvidar el último mensaje
                                if (!empty($currentContent) && $currentSender !== null) {
                                    $conversation[] = [
                                        'sender' => $currentSender,
                                        'content' => trim($currentContent),
                                        'time' => $message->created_at->addMinutes($messageIndex * 2)
                                    ];
                                }
                                
                                // Si no hay conversación, crear un mensaje inicial automático
                                if (empty($conversation)) {
                                    $conversation[] = [
                                        'sender' => 'sistema',
                                        'content' => 'Pedido iniciado: ' . $message->pizza->nombre,
                                        'time' => $message->created_at
                                    ];
                                }
                            @endphp
                            
                            @foreach($conversation as $index => $msg)
                                @php
                                    $isUser = $msg['sender'] === 'tú';
                                    $isAdmin = in_array($msg['sender'], ['pizzería', 'admin']);
                                    $isSystem = $msg['sender'] === 'sistema';
                                    $messageTime = $msg['time'];
                                    
                                    // Mostrar separador de fecha si cambia
                                    $messageDate = $messageTime->format('d/m/Y');
                                    $showDateSeparator = $index > 0 && $messageDate !== $conversation[$index-1]['time']->format('d/m/Y');
                                @endphp
                                
                                @if($showDateSeparator)
                                    <div class="flex justify-center my-6">
                                        <div class="bg-white px-3 py-1 rounded-full text-xs text-gray-600 shadow">
                                            {{ $messageDate }}
                                        </div>
                                    </div>
                                @endif
                                
                                @if($isSystem)
                                    <div class="flex justify-center my-4">
                                        <div class="bg-gray-200 px-4 py-2 rounded-lg text-xs text-gray-600 max-w-[90%] text-center">
                                            {{ $msg['content'] }}
                                        </div>
                                    </div>
                                @else
                                    <div 
                                        class="chat-message mb-4 flex {{ $isUser ? 'justify-end' : 'justify-start' }}"
                                    >
                                        <div 
                                            class="max-w-[80%] p-3 rounded-lg shadow-sm 
                                            {{ $isUser ? 'bg-green-50 border border-green-100' : 'bg-blue-50 border border-blue-100' }}"
                                        >
                                            <div class="font-medium {{ $isUser ? 'text-green-700' : 'text-blue-700' }} text-sm mb-1">
                                                {{ $isUser ? 'Cliente' : 'Admin/Pizzería' }}
                                            </div>
                                            
                                            <p class="whitespace-pre-line text-gray-800">{{ $msg['content'] }}</p>
                                            
                                            <div class="flex justify-end items-center gap-1 mt-1">
                                                <span class="text-gray-500 text-xs">{{ $messageTime->format('H:i') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        
                        <!-- Campo de mensaje (activo para admin) -->
                        @if($message->status != 'cancelado' && $message->status != 'completado')
                        <form action="{{ route('pedidos.admin-message', $message) }}" method="POST" class="bg-gray-100 p-3 flex items-center border-t">
                            @csrf
                            <input type="text" name="admin_message" placeholder="Escribe un mensaje al cliente..." 
                                class="flex-1 bg-white rounded-full py-2 px-4 text-gray-700 border focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <button type="submit" class="ml-2 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full transition-colors">
                                <i class="bi bi-send"></i>
                            </button>
                        </form>
                        @else
                        <div class="bg-gray-100 p-3 flex items-center border-t">
                            <div class="flex-1 bg-white rounded-full py-2 px-4 text-gray-400 border">
                                Conversación finalizada
                            </div>
                            <button disabled class="ml-2 bg-blue-500 text-white p-2 rounded-full opacity-50">
                                <i class="bi bi-send"></i>
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <!-- Vista de listado de pedidos admin -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl md:text-4xl font-bold text-blue-700">Gestión de Pedidos</h1>
                
                <div class="flex gap-4">
                    <form action="{{ route('pedidos.index') }}" method="GET" class="flex">
                        <select name="status" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-l-lg p-2.5">
                            <option value="">Todos los estados</option>
                            <option value="pendiente" {{ request('status') === 'pendiente' ? 'selected' : '' }}>Pendientes</option>
                            <option value="en_proceso" {{ request('status') === 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                            <option value="completado" {{ request('status') === 'completado' ? 'selected' : '' }}>Completados</option>
                            <option value="cancelado" {{ request('status') === 'cancelado' ? 'selected' : '' }}>Cancelados</option>
                        </select>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-r-lg transition-colors">
                            Filtrar
                        </button>
                    </form>
                    
                    <form action="{{ route('pedidos.index') }}" method="GET" class="flex">
                        <input type="text" name="search" placeholder="Buscar por #ID o cliente" value="{{ request('search') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-l-lg p-2.5">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-r-lg transition-colors">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            @if(isset($messages) && count($messages) > 0)
                <div class="overflow-x-auto bg-white rounded-xl shadow-lg">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 uppercase text-sm">
                                <th class="py-3 px-4 text-left">#ID</th>
                                <th class="py-3 px-4 text-left">Cliente</th>
                                <th class="py-3 px-4 text-left">Producto</th>
                                <th class="py-3 px-4 text-left">Fecha</th>
                                <th class="py-3 px-4 text-center">Estado</th>
                                <th class="py-3 px-4 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($messages as $msg)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-2 px-4 text-sm">#{{ $msg->id }}</td>
                                    <td class="py-2 px-4">
                                        <div class="font-medium text-gray-800">{{ $msg->user->name }}</div>
                                        <div class="text-gray-500 text-xs">{{ $msg->user->email }}</div>
                                    </td>
                                    <td class="py-2 px-4">
                                        <div class="font-medium text-gray-800">{{ $msg->pizza->nombre }}</div>
                                        <div class="text-gray-500 text-xs">${{ number_format($msg->pizza->precio, 2) }}</div>
                                    </td>
                                    <td class="py-2 px-4">
                                        <div class="text-gray-800">{{ $msg->created_at->format('d/m/Y') }}</div>
                                        <div class="text-gray-500 text-xs">{{ $msg->created_at->format('H:i') }}</div>
                                    </td>
                                    <td class="py-2 px-4 text-center">
                                        <span 
                                            class="px-3 py-1 rounded-full text-xs font-medium
                                            {{ $msg->status == 'pendiente' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $msg->status == 'en_proceso' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $msg->status == 'completado' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $msg->status == 'cancelado' ? 'bg-red-100 text-red-800' : '' }}
                                            "
                                        >
                                            {{ ucfirst(str_replace('_', ' ', $msg->status)) }}
                                        </span>
                                    </td>
                                    <td class="py-2 px-4">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('pedidos.show', $msg) }}" class="bg-blue-600 hover:bg-blue-700 text-white py-1 px-3 rounded text-sm transition-colors">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            
                                            @if(!in_array($msg->status, ['completado', 'cancelado']))
                                                <form action="{{ route('pedidos.update-status', $msg) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="completado">
                                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white py-1 px-3 rounded text-sm transition-colors">
                                                        <i class="bi bi-check-circle"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            @if(in_array($msg->status, ['completado', 'cancelado']))
                                                <form action="{{ route('pedidos.destroy', $msg) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este pedido?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white py-1 px-3 rounded text-sm transition-colors">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-6">
                    {{ $messages->appends(request()->query())->links() }}
                </div>
                
                <!-- Resumen de estadísticas -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-8">
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-gray-500 text-sm">Pedidos Pendientes</p>
                                <h3 class="text-2xl font-bold text-yellow-600">{{ $stats['pendientes'] ?? 0 }}</h3>
                            </div>
                            <div class="h-12 w-12 rounded-full bg-yellow-100 flex items-center justify-center">
                                <i class="bi bi-hourglass text-yellow-600 text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-gray-500 text-sm">En Proceso</p>
                                <h3 class="text-2xl font-bold text-blue-600">{{ $stats['en_proceso'] ?? 0 }}</h3>
                            </div>
                            <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                                <i class="bi bi-gear text-blue-600 text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-gray-500 text-sm">Completados</p>
                                <h3 class="text-2xl font-bold text-green-600">{{ $stats['completados'] ?? 0 }}</h3>
                            </div>
                            <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center">
                                <i class="bi bi-check-circle text-green-600 text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-gray-500 text-sm">Cancelados</p>
                                <h3 class="text-2xl font-bold text-red-600">{{ $stats['cancelados'] ?? 0 }}</h3>
                            </div>
                            <div class="h-12 w-12 rounded-full bg-red-100 flex items-center justify-center">
                                <i class="bi bi-x-circle text-red-600 text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-xl shadow-lg p-8 text-center">
                    <i class="bi bi-inbox text-5xl text-gray-400 mb-4 block"></i>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">No hay pedidos que coincidan con los filtros</h3>
                    <p class="text-gray-600 mb-6">Intenta cambiar los criterios de búsqueda o revisa más tarde.</p>
                    <a href="{{ route('pedidos.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition-colors">
                        <i class="bi bi-arrow-repeat mr-2"></i> Ver Todos los Pedidos
                    </a>
                </div>
            @endif
        @endif
    </div>
    
    @include('fragments.footer')

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Scroll al final de la conversación cuando se carga la página
        const chatContainer = document.querySelector('.chat-container');
        if (chatContainer) {
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
        
        // Confirmar eliminación de pedido
        const deleteForms = document.querySelectorAll('form[action*="destroy"]');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const confirmed = confirm('¿Estás seguro de eliminar este pedido? Esta acción no se puede deshacer.');
                if (!confirmed) {
                    e.preventDefault();
                }
            });
        });
    });
    </script>
</body>
</html>