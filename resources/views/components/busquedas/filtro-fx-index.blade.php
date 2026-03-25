<form action="{{ url()->current() }}" method="GET" class="{{ $formClass ?? 'w-1/3' }}" id="searchForm">
    @if(request('per_page'))
        <input type="hidden" name="per_page" value="{{ request('per_page') }}">
    @endif

    <div class="relative flex items-center flex-grow bg-white border border-gray-300 rounded-lg focus-within:border-blue-400 focus-within:shadow-md transition-all duration-200 overflow-hidden">
        
        <div class="pl-3 flex items-center pointer-events-none">
            <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>

        <input type="text" 
            id="searchInput"
            name="search" 
            value="{{ request('search') }}" 
            placeholder="Escriba las palabras a buscar..." 
            class="py-2.5 px-3 bg-transparent border-none focus:ring-0 focus:outline-none text-sm text-gray-900 placeholder-gray-400 w-full"
            autocomplete="off"
        >

        <!-- Botón: Las clases base comunes se mantienen, las de color cambian vía JS -->
        <button type="submit" 
                id="searchButton"
                class="px-6 py-2 text-white font-medium rounded-lg text-sm transition-colors duration-300 shrink-0 shadow-sm mr-1.5 focus:outline-none border-none outline-none"
        >
            Buscar
        </button>

        @if(request('search'))
            <a href="{{ url()->current() . (request('per_page') ? '?per_page='.request('per_page') : '') }}" 
               class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-500 hover:text-gray-700 rounded-md transition-colors shrink-0 inline-flex items-center justify-center text-sm font-medium mr-1.5 focus:outline-none" 
               title="Limpiar búsqueda">
                Limpiar
            </a>
        @endif
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('searchInput');
        const button = document.getElementById('searchButton');

        // Definimos los grupos de clases para cada estado
        const clasesNaranja = ['bg-orange-400', 'hover:bg-orange-500']; // color del boton, color cuando se pasa el mouse por arriba
        const clasesGris = ['bg-gray-300', 'hover:bg-gray-500'];

        const updateButtonClass = () => {
            if (input.value.trim().length > 0) {
                // Cambiar a Naranja
                button.classList.remove(...clasesGris);
                button.classList.add(...clasesNaranja);
            } else {
                // Cambiar a Gris
                button.classList.remove(...clasesNaranja);
                button.classList.add(...clasesGris);
            }
        };

        // Ejecución inicial y en cada evento de escritura
        updateButtonClass();
        input.addEventListener('input', updateButtonClass);
    });
</script>
