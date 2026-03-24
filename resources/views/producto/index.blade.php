<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Productos') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Productos') }}</h1>
                            <p class="mt-2 text-sm text-gray-700">Listado de {{ __('Productos') }}.</p>
                        </div>

                    </div>
                    <div class="flow-root">
                        <div class="mt-8 overflow-x-auto">
                            <div class="inline-block min-w-full align-middle">
                                <div class="flex items-center justify-between w-full gap-4 mb-6">
                                    <!-- Lado Izquierdo: Selector de registros -->
                                    <div class="flex-shrink-0">
                                        @include('components.vistas.selector-per-page', [
                                            'modelClass' => \App\Models\ProductoCategoriaView::class
                                        ])
                                    </div>

                                    <!-- Centro: Buscador -->
                                    <div class="flex-grow flex justify-center">
                                        @include('components.vistas.busqueda-filtro-fx-index', [
                                            'formClass' => 'w-full max-w-xl' 
                                        ])
                                    </div>

                                    <!-- Lado Derecho: Espacio equilibrador o Botón "Add" -->
                                    <div class="flex-shrink-0">
                                        {{-- Aquí puedes mover tu botón "Add New" si quieres que todo esté en la misma línea --}}
                                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                                            <a type="button" href="{{ route('productos.create') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                            <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                            </svg>
                                                {{ __('Add new') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>                    
                                <table class="w-full divide-y divide-gray-300">
                                    <thead>
                                    <div class="flex">
                                    <tr>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">No</th>
                                        
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Producto</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Descripción</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Categorías</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Usuario</th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500"></th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach ($productos as $producto)
                                        <tr class="even:bg-gray-50">
                                            {{-- esto es si uso paginador en el controlador--}}
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">{{ ++$i }}</td>

                                            {{-- si no uso el paginador es con {{ $loop->iteration }} --}}
                                            {{-- <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">{{ $loop->iteration }}</td> --}}
                                            
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $producto->producto }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $producto->descripcion }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{!! $producto->categorias_br !!}</td> {{-- para que reconozca los tags html --}}
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $producto->usuario?->name ?? 'N/A' }}</td> {{-- accedemos a la funcion usuario del modelo de la vista que se utiliza en el controlador --}}

                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                                <form action="{{ route('productos.destroy', $producto->id) }}" method="POST">
                                                    <a href="{{ route('productos.show', $producto->id) }}" class="text-gray-600 font-bold hover:text-gray-900 mr-2">{{ __('Show') }}</a>
                                                    <a href="{{ route('productos.edit', $producto->id) }}" class="text-indigo-600 font-bold hover:text-indigo-900  mr-2">{{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="{{ route('productos.destroy', $producto->id) }}" class="text-red-600 font-bold hover:text-red-900" onclick="event.preventDefault(); confirm('Confirme la eliminación') ? this.closest('form').submit() : false;">{{ __('Delete') }}</a>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-4 px-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 border-t border-gray-100 pt-4">                                    
                                    <!-- 1. EL SELECTOR (Ala Izquierda) -->
                                    <div class="flex items-center text-sm">
                                        @include('components.vistas.selector-per-page', ['modelClass' => \App\Models\ProductoCategoriaView::class])
                                    </div>

                                    <!-- 2. EL PAGINADOR (A la Derecha) -->
                                    <div class="flex-shrink-0">
                                        {!! $productos->withQueryString()->links() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Es el @if(session('success') @endif --}}
    {{-- @include('components.vistas.msjToast-session-success') --}}
    @include('components.vistas.msjToastAlpine')
</x-app-layout>