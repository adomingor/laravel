<x-app-layout>
    <x-slot name="header"></x-slot>
    <!-- @include('components.mensajes.toastAlpine') -->
    <x-mensajes.swal-toast />

    <div x-data="handlerDelete()">
        <div class="max-w-4xl mx-auto p-4">
            <div class="flex justify-between items-center mb-4">
                <!-- con windows + . se abre en vscode la paleta de emoticones -->
                <h1 class="text-xl font-semibold text-gray-800">🗑️ Papelera de productos</h1>
                <x-botones.back-list :route="route('productos.index')" label="BackToList" />
            </div>

            @if($productos->isEmpty())
                <div class="bg-gray-100 text-gray-600 p-4 rounded">
                    No hay productos en la papelera.
                </div>
            @endif

            <div class="space-y-2">
                @foreach($productos as $producto)
                    <div class="flex justify-between items-center bg-white p-3 rounded shadow border">
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $producto->producto }}</p>
                        </div>

                        <div class="flex gap-2 items-center">
                            <form method="POST" action="{{ route('productos.restore', $producto->id) }}">
                                @csrf
                                @method('PUT')
                                <button class="px-3 py-1 text-xs bg-green-500 text-white rounded hover:bg-green-600">
                                    Restaurar
                                </button>
                            </form>

                            <button 
                                @click="confirmDelete({{ $producto->id }}, @js($producto->producto))"
                                class="px-3 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700">
                                Eliminar
                            </button>

                            <form id="delete-form-{{ $producto->id }}" 
                                  action="{{ route('productos.forceDelete', $producto->id) }}" 
                                  method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
    function handlerDelete() {
        return {
            confirmDelete(id, nombre) {
                Swal.fire({
                    toast: true,                // <--- ESTO LO HACE TOAST
                    position: 'top',
                    title: '¿Confirmar eliminación?',
                    html: `¿Eliminar definitivamente <b>${nombre}</b>?<br>Esta acción no se puede deshacer.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: false,
                    timer: 4000, 
                    timerProgressBar: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Enviamos el formulario correspondiente
                        document.getElementById('delete-form-' + id).submit();
                    }
                });
            }
        }
    }
    </script>
</x-app-layout>