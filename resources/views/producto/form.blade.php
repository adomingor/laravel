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
