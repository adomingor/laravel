<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof jQuery !== 'undefined') {
            jQuery('#id_categorias').select2({
                placeholder: "Busca o selecciona categorías",
                allowClear: true,
                width: '100%'
            });
        }
    });
</script>


<div class="space-y-6 px-1">
    <div>
        <x-input-label for="producto" :value="__('Producto')"/>
        <x-text-input id="producto" name="producto" type="text" class="mt-1 block w-full" :value="old('producto', $producto?->producto)" autocomplete="producto" placeholder="Producto"/>
        <x-input-error class="mt-2" :messages="$errors->get('producto')"/>
    </div>

    <div>
        <x-input-label for="descripcion" :value="__('Descripción')"/>
        <x-text-input id="descripcion" name="descripcion" type="text" class="mt-1 block w-full" :value="old('descripcion', $producto?->descripcion)" autocomplete="descripcion" placeholder="Descripción"/>
        <x-input-error class="mt-2" :messages="$errors->get('descripcion')"/>
    </div>

    <!-- Campo Activo tipo Switch/Checkbox -->
    <div>
        <x-input-label for="activo" :value="__('Estado Activo')"/>
        <div class="flex items-center mt-2">
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="hidden" name="activo" value="0">
                <input type="checkbox" id="activo" name="activo" value="1" 
                    class="sr-only peer" 
                    {{ old('activo', $producto?->activo ?? '1') == '1' ? 'checked' : '' }}>
                
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-700">Si / No</span>
            </label>
        </div>
        <x-input-error class="mt-2" :messages="$errors->get('activo')"/>
    </div>
    <!-- Campo Usuario (Solo Visual como Texto) -->
    <div>
        <x-input-label :value="__('Usuario Responsable')"/>            
        <!-- Texto estático en lugar de un input -->
        <div class="mt-2 p-2 block w-full text-sm text-gray-600 bg-gray-50 border border-gray-200 rounded-md shadow-sm cursor-not-allowed">
            {{ auth()->user()->name }}
        </div>            
        <!-- El ID real que se envía a la DB (Oculto) -->
        <input type="hidden" name="id_users" value="{{ auth()->id() }}">            
        <x-input-error class="mt-2" :messages="$errors->get('id_users')"/>
    </div>
    {{-- Los campos fecha_ins y fecha_upd normalmente no deberían estar en el form, ya que Eloquent los maneja solo con timestamps() --}}

    <div class="flex items-center gap-4">
        <x-primary-button>{{ __('Save')}}</x-primary-button>
    </div>
</div>

<!-- Selección de Categorías con select desplegado -->
{{-- <div>
    <x-input-label for="id_categorias" :value="__('Categorías')" />
    <select id="id_categorias" name="id_categorias[]" multiple 
        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
        @foreach($categorias as $categoria)
            <option value="{{ $categoria->id }}" 
                {{ (isset($productoCategorias) && in_array($categoria->id, $productoCategorias)) ? 'selected' : '' }}>
                {{ $categoria->categoria }}
            </option>
        @endforeach
    </select>
    <p class="text-xs text-gray-500 mt-1">Mantén presionado Ctrl (o Cmd) para seleccionar varias.</p>
    <x-input-error class="mt-2" :messages="$errors->get('id_categorias')" />
</div> --}}


<!-- Selección de Categorías con Checkboxes -->
@foreach($categorias as $categoria)
    <label class="relative flex items-start p-3 bg-white border border-gray-200 rounded-lg cursor-pointer hover:bg-indigo-50 hover:border-indigo-200 transition group shadow-sm">
        <div class="flex items-center h-5">
            <input type="checkbox" 
                name="id_categorias[]" 
                value="{{ $categoria->id }}"
                class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 focus:ring-offset-0 transition"
                
                @if(in_array($categoria->id, old('id_categorias', $producto->relationLoaded('categorias') ? $producto->categorias->pluck('id')->toArray() : []))) 
                    checked 
                @endif
            >
        </div>
        <div class="ml-3 text-sm leading-6">
            <span class="font-semibold text-gray-800 group-hover:text-indigo-700 transition">
                {{ $categoria->categoria }}
            </span>
        </div>
    </label>
@endforeach

<!-- Selección de Categorías con Select2 UN DOLOR DE HUEVO EN EL CODIGO-->
{{-- <div class="mt-4">
    <x-input-label for="id_categorias" :value="__('Categorías')" />
    
    <!-- Agregamos la clase 'select2' para identificarlo -->
    <select id="id_categorias" name="id_categorias[]" multiple="multiple" 
            class="select2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        @foreach($categorias as $categoria)
            <option value="{{ $categoria->id }}"
                @if(in_array($categoria->id, old('id_categorias', $producto->relationLoaded('categorias') ? $producto->categorias->pluck('id')->toArray() : []))) 
                    selected 
                @endif
            >
                {{ $categoria->categoria }}
            </option>
        @endforeach
    </select>
</div>

<script type="module">
    // Esperamos a que la página y los módulos de Vite carguen
    document.addEventListener('DOMContentLoaded', () => {
        if (window.jQuery) {
            $('.select2').select2({
                placeholder: "Escribe para buscar categorías...",
                allowClear: true,
                width: '100%'
            });
        } else {
            console.error("Vite aún no ha expuesto jQuery al objeto window.");
        }
    });
</script>

<style>
    /* Estética mínima para que no choque con Tailwind */
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #d1d5db !important;
        border-radius: 0.375rem !important;
        padding: 4px !important;
    }
    .select2-container .select2-search__field {
        margin-top: 7px !important;
    }
</style>
@foreach($categorias as $categoria)
    <option value="{{ $categoria->id }}"
        @if(in_array($categoria->id, old('id_categorias', $producto->categorias ? $producto->categorias->pluck('id')->toArray() : []))) 
            selected 
        @endif
    >
        {{ $categoria->categoria }}
    </option>
@endforeach --}}
