<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestión de Pizzas - PizzaPlace Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scaleIn {
            from {
                transform: scale(0.95);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .pizza-card {
            animation: scaleIn 0.5s ease-out forwards;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .pizza-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .modal.fade .modal-dialog {
            transform: scale(0.95);
            opacity: 0;
            transition: all 0.3s ease-in-out;
        }

        .modal.show .modal-dialog {
            transform: scale(1);
            opacity: 1;
        }

        .btn-floating {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 1000;
        }

        .form-control:focus, .btn:focus {
            box-shadow: 0 0 0 0.25rem rgba(220, 38, 38, 0.25);
            border-color: rgba(220, 38, 38, 0.5);
        }

        .bg-pattern {
            background-image: radial-gradient(circle at 1px 1px, #f3f4f6 1px, transparent 0);
            background-size: 20px 20px;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('fragments.navbar')

    <div class="container mt-14 px-4 py-8">
        <div class="text-center mb-8 animate-fadeIn">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-red-600 to-red-400 bg-clip-text text-transparent">
                Gestión de Pizzas
            </h1>
            <p class="text-gray-600 mt-2">Administra tu menú de pizzas de manera fácil y eficiente</p>
        </div>

        <!-- Floating Add Button -->
        <button class="btn-floating bg-red-600 text-white rounded-full p-4 shadow-lg hover:bg-red-700 transition-colors duration-300"
                data-bs-toggle="modal" data-bs-target="#addPizzaModal">
            <i class="bi bi-plus-lg text-2xl"></i>
        </button>

        <!-- Pizza Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
            @foreach ($pizzas as $pizza)
                <div class="pizza-card bg-white rounded-xl overflow-hidden shadow-md">
                    @if ($pizza->imagen)
                        <div class="relative h-35 overflow-hidden">
                            <img src="{{ asset('storage/' . $pizza->imagen) }}" 
                                 class="w-full h-full object-cover transition-transform duration-300 hover:scale-110" 
                                 alt="{{ $pizza->nombre }}">
                        </div>
                    @endif
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">{{ $pizza->nombre }}</h3>
                        <p class="text-gray-600 mb-4 line-clamp-2">{{ $pizza->descripcion }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-red-600">${{ $pizza->precio }}</span>
                            <div class="space-x-2">
                                <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#viewPizzaModal{{ $pizza->id }}">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editPizzaModal{{ $pizza->id }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deletePizzaModal{{ $pizza->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal de edición para cada pizza -->
                <div class="modal fade" id="editPizzaModal{{ $pizza->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg rounded-lg">
                            <div class="modal-header border-0 bg-gradient-to-r from-red-600 to-red-400 text-white">
                                <h5 class="modal-title">Editar Pizza</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body p-4">
                                <form action="{{ route('pizzas.update', $pizza->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-4">
                                        <label class="form-label text-gray-700">Nombre</label>
                                        <input type="text" class="form-control" name="nombre" value="{{ $pizza->nombre }}" required>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label text-gray-700">Descripción</label>
                                        <textarea class="form-control" name="descripcion" rows="3" required>{{ $pizza->descripcion }}</textarea>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label text-gray-700">Precio</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" name="precio" value="{{ $pizza->precio }}" step="0.01" required>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label text-gray-700">Nueva Imagen</label>
                                        <input type="file" class="form-control" name="imagen">
                                        @if ($pizza->imagen)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $pizza->imagen) }}" class="rounded w-32 h-32 object-cover" alt="Vista previa">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="text-end">
                                        <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-success">Guardar Cambios</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal de eliminación para cada pizza -->
                <div class="modal fade" id="deletePizzaModal{{ $pizza->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg rounded-lg">
                            <div class="modal-header border-0 bg-gradient-to-r from-red-600 to-red-400 text-white">
                                <h5 class="modal-title">Confirmar Eliminación</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body p-4 text-center">
                                <i class="bi bi-exclamation-triangle text-warning display-4"></i>
                                <h4 class="mt-3">¿Estás seguro?</h4>
                                <p class="text-muted">¿Realmente deseas eliminar la pizza <strong>{{ $pizza->nombre }}</strong>? Esta acción no se puede deshacer.</p>
                            </div>
                            <div class="modal-footer border-0">
                                <form action="{{ route('pizzas.destroy', $pizza->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-danger ms-2">Sí, Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal de vista para cada pizza -->
                <div class="modal fade" id="viewPizzaModal{{ $pizza->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg rounded-lg">
                            <div class="modal-header border-0 bg-gradient-to-r from-red-600 to-red-400 text-white">
                                <h5 class="modal-title">{{ $pizza->nombre }}</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body p-0">
                                @if ($pizza->imagen)
                                    <img src="{{ asset('storage/' . $pizza->imagen) }}" 
                                         class="w-full h-64 object-cover" 
                                         alt="{{ $pizza->nombre }}">
                                @endif
                                <div class="p-4">
                                    <h4 class="font-semibold text-xl mb-2">Detalles</h4>
                                    <p class="text-gray-600 mb-3">{{ $pizza->descripcion }}</p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-2xl font-bold text-red-600">${{ $pizza->precio }}</span>
                                        <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Modal de agregar pizza (fuera del foreach) -->
        <div class="modal fade" id="addPizzaModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-lg">
                    <div class="modal-header border-0 bg-gradient-to-r from-red-600 to-red-400 text-white">
                        <h5 class="modal-title">Agregar Nueva Pizza</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form action="{{ route('pizzas.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="mb-4">
                                <label class="form-label text-gray-700">Nombre de la Pizza</label>
                                <input type="text" class="form-control" name="nombre" required>
                                <div class="invalid-feedback">
                                    Por favor ingresa un nombre para la pizza.
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-gray-700">Descripción</label>
                                <textarea class="form-control" name="descripcion" rows="3" required
                                    placeholder="Describe los ingredientes y características de la pizza"></textarea>
                                <div class="invalid-feedback">
                                    Por favor ingresa una descripción.
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-gray-700">Precio</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" name="precio" step="0.01" required
                                           min="0" placeholder="0.00">
                                    <div class="invalid-feedback">
                                        Por favor ingresa un precio válido.
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-gray-700">Imagen de la Pizza</label>
                                <input type="file" class="form-control" name="imagen" accept="image/*" required>
                                <div class="form-text text-gray-500">
                                    Sube una imagen atractiva de la pizza.
                                </div>
                            </div>
                            <div class="text-end pt-3">
                                <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">
                                    Cancelar
                                </button>
                                <button type="submit" class="btn bg-red-600 text-white hover:bg-red-700">
                                    Crear Pizza
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('fragments.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animación para las tarjetas al cargar
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.pizza-card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });

        // Toast notifications
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed bottom-4 right-4 p-4 rounded-lg shadow-lg ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            } text-white z-50 transform transition-all duration-300 translate-y-full`;
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.transform = 'translateY(0)';
            }, 100);

            setTimeout(() => {
                toast.style.transform = 'translateY(full)';
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 3000);
        }

        // Form validation
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!form.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                    showToast('Por favor, completa todos los campos requeridos', 'error');
                }
                form.classList.add('was-validated');
            });
        });

        document.querySelectorAll('input[type="file"]').forEach(input => {
                input.addEventListener('change', function(e) {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        const preview = document.createElement('img');
                        preview.className = 'mt-2 rounded w-full h-48 object-cover';
                        
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                        }
                        
                        // Remover preview anterior si existe
                        const container = this.parentElement;
                        const oldPreview = container.querySelector('img');
                        if (oldPreview) {
                            container.removeChild(oldPreview);
                        }
                        
                        container.appendChild(preview);
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            });

            // Reset form al cerrar el modal
            document.querySelectorAll('.modal').forEach(modal => {
                modal.addEventListener('hidden.bs.modal', function() {
                    const form = this.querySelector('form');
                    if (form) {
                        form.reset();
                        const preview = form.querySelector('img');
                        if (preview) {
                            preview.remove();
                        }
                        form.classList.remove('was-validated');
                    }
                });
            });
    </script>
</body>
</html>