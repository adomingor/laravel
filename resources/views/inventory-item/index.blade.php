<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inventory Items') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">


                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Inventory Items') }}</h1>
                            <p class="mt-2 text-sm text-gray-700">A list of all the {{ __('Inventory Items') }}.</p>
                        </div>

                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <a type="button" href="{{ route('inventory-items.create') }}" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Nuevo ítem</a>
                        </div>
                    </div>



                    <div class="flow-root">
                        <div class="flex justify-center w-full px-2 py-6">
                            <form action="{{ route('inventory-items.index') }}" method="GET" class="w-1/2">
                                <div class="relative flex items-center flex-grow bg-white border border-gray-300 rounded-lg focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500 transition shadow-sm overflow-hidden">
                                    
                                    <div class="pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" 
                                        name="search" 
                                        value="{{ request('search') }}" 
                                        placeholder="Buscar por nombre o descripción..." 
                                        class="py-2.5 px-3 bg-transparent border-none focus:ring-0 text-sm text-gray-900 placeholder-gray-400 outline-none mr-2 w-full"
                                        
                                    >
                                    <button type="submit" 
                                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm transition shrink-0 shadow-md mr-2"
                                            >
                                        Buscar
                                    </button>

                                    @if(request('search'))
                                    <a href="{{ route('inventory-items.index') }}" 
                                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-600 hover:text-gray-800 rounded-md transition shrink-0 inline-flex items-center justify-center text-sm font-medium" 
                                    title="Limpiar búsqueda">
                                        Limpiar
                                    </a>
                                    @endif
                                </div>
                            </form>
                        </div>
                        <div class=" overflow-x-auto">
                            <div class="inline-block min-w-full py-2 align-middle">
                                <table class="w-full divide-y divide-gray-300">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">No</th>
                                        
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Name</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Description</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Quantity</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Price</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">User</th>

                                        <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500"></th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach ($inventoryItems as $inventoryItem)
                                        <tr class="even:bg-gray-50">
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">{{ ++$i }}</td>
                                            
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $inventoryItem->name }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $inventoryItem->description }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $inventoryItem->quantity }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $inventoryItem->price }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $inventoryItem->user->name }}</td>

                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                                <form action="{{ route('inventory-items.destroy', $inventoryItem->id) }}" method="POST">
                                                    <a href="{{ route('inventory-items.show', $inventoryItem->id) }}" class="text-gray-600 font-bold hover:text-gray-900 mr-2">{{ __('Show') }}</a>
                                                    <a href="{{ route('inventory-items.edit', $inventoryItem->id) }}" class="text-indigo-600 font-bold hover:text-indigo-900  mr-2">{{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="{{ route('inventory-items.destroy', $inventoryItem->id) }}" class="text-red-600 font-bold hover:text-red-900" onclick="event.preventDefault(); confirm('Are you sure to delete?') ? this.closest('form').submit() : false;">{{ __('Delete') }}</a>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                <div class="mt-4 px-4">
                                    {!! $inventoryItems->withQueryString()->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>