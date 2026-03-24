<form action="{{ url()->current() }}" method="GET" class="flex items-center gap-2">
    @php 
        // Usamos la variable $modelClass que pasaremos desde la vista
        $instance = new $modelClass;
        $valorModelo = $instance->getPerPage();
        $seleccionado = request('per_page', $valorModelo);
    @endphp
    
    <label class="text-sm font-medium text-gray-700 whitespace-nowrap">Mostrar:</label>
    
    <select name="per_page" onchange="this.form.submit()" 
        class="py-1 text-sm bg-transparent border-0 border-b-2 border-gray-300 focus:ring-0 focus:border-indigo-600 cursor-pointer">
        
        <option value="{{ $valorModelo }}" {{ ($seleccionado == $valorModelo && request('per_page') != 'all') ? 'selected' : '' }}>
            {{ $valorModelo }} (Predet)
        </option>

        @if($valorModelo != 5) <option value="5" {{ $seleccionado == 5 ? 'selected' : '' }}>5</option> @endif
        @if($valorModelo != 10) <option value="10" {{ $seleccionado == 10 ? 'selected' : '' }}>10</option> @endif
        @if($valorModelo != 50) <option value="50" {{ $seleccionado == 50 ? 'selected' : '' }}>50</option> @endif
        
        <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>Todos</option>
    </select>
</form>
