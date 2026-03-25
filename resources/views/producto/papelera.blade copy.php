<x-app-layout>

    <x-slot name="header"></x-slot>
    @include('components.mensajes.toastAlpine')


    <!-- Alpine root -->
    <div x-data="modalDelete()">

        <div class="max-w-4xl mx-auto p-4">

            <!-- Título -->
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-xl font-semibold text-gray-800">🗑️ Papelera de productos</h1>
                <x-botones.back-list :route="route('productos.index')" label="BackToList" />
            </div>

            <!-- Mensajes -->
            @if($productos->isEmpty())
                <div class="bg-gray-100 text-gray-600 p-4 rounded">
                    No hay productos en la papelera.
                </div>
            @endif

            <!-- Listado -->
            <div class="space-y-2">

                @foreach($productos as $producto)
                    <div class="flex justify-between items-center bg-white p-3 rounded shadow border">

                        <div>
                            <p class="text-sm font-medium text-gray-800">
                                {{ $producto->producto }}
                            </p>
                        </div>

                        <div class="flex gap-2 items-center">

                            <!-- Restaurar -->
                            <form method="POST" action="{{ route('productos.restore', $producto->id) }}">
                                @csrf
                                @method('PUT')
                                <button 
                                    class="px-3 py-1 text-xs bg-green-500 text-white rounded hover:bg-green-600">
                                    Restaurar
                                </button>
                            </form>

                            <!-- Eliminar -->
                            <button 
                                @click="openModal({{ $producto->id }}, @js($producto->producto))"
                                class="px-3 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700">
                                Eliminar
                            </button>

                        </div>
                    </div>
                @endforeach

            </div>
        </div>

        <!-- MODAL -->
        <div 
            x-show="open"
            x-transition
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
            style="display: none;"
        >
            <div class="bg-white w-80 p-5 rounded-lg shadow-lg">

                <h2 class="text-lg font-semibold text-gray-800 mb-2">
                    ⚠️ Confirmar eliminación
                </h2>

                <p class="text-sm text-gray-600 mb-4">
                    ¿Eliminar definitivamente 
                    <span class="font-semibold" x-text="nombre"></span>?<br>
                    Esta acción no se puede deshacer.
                </p>

                <div class="flex justify-end gap-2">

                    <button @click="close()" class="px-3 py-1 text-sm text-gray-600">
                        Cancelar
                    </button>

                    <form :action="'/productos/' + id + '/force'" method="POST">
                        @csrf
                        @method('DELETE')

                        <button class="px-3 py-1 text-sm bg-red-600 text-white rounded">
                            Eliminar
                        </button>
                    </form>

                </div>
            </div>
        </div>

    </div>

    <!-- Alpine script -->
    <script>
    function modalDelete() {
        return {
            open: false,
            id: null,
            nombre: '',

            openModal(id, nombre) {
                this.id = id;
                this.nombre = nombre;
                this.open = true;
            },

            close() {
                this.open = false;
            }
        }
    }
    </script>

</x-app-layout>