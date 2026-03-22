<div class="space-y-6">
    
    <div>
        <x-input-label for="producto" :value="__('Producto')"/>
        <x-text-input id="producto" name="producto" type="text" class="mt-1 block w-full" :value="old('producto', $producto?->producto)" autocomplete="producto" placeholder="Producto"/>
        <x-input-error class="mt-2" :messages="$errors->get('producto')"/>
    </div>
    <div>
        <x-input-label for="descripcion" :value="__('Descripcion')"/>
        <x-text-input id="descripcion" name="descripcion" type="text" class="mt-1 block w-full" :value="old('descripcion', $producto?->descripcion)" autocomplete="descripcion" placeholder="Descripcion"/>
        <x-input-error class="mt-2" :messages="$errors->get('descripcion')"/>
    </div>
    <div>
        <x-input-label for="activo" :value="__('Activo')"/>
        <x-text-input id="activo" name="activo" type="text" class="mt-1 block w-full" :value="old('activo', $producto?->activo)" autocomplete="activo" placeholder="Activo"/>
        <x-input-error class="mt-2" :messages="$errors->get('activo')"/>
    </div>
    <div>
        <x-input-label for="id_users" :value="__('Id Users')"/>
        <x-text-input id="id_users" name="id_users" type="text" class="mt-1 block w-full" :value="old('id_users', $producto?->id_users)" autocomplete="id_users" placeholder="Id Users"/>
        <x-input-error class="mt-2" :messages="$errors->get('id_users')"/>
    </div>
    <div>
        <x-input-label for="fecha_ins" :value="__('Fecha Ins')"/>
        <x-text-input id="fecha_ins" name="fecha_ins" type="text" class="mt-1 block w-full" :value="old('fecha_ins', $producto?->fecha_ins)" autocomplete="fecha_ins" placeholder="Fecha Ins"/>
        <x-input-error class="mt-2" :messages="$errors->get('fecha_ins')"/>
    </div>
    <div>
        <x-input-label for="fecha_upd" :value="__('Fecha Upd')"/>
        <x-text-input id="fecha_upd" name="fecha_upd" type="text" class="mt-1 block w-full" :value="old('fecha_upd', $producto?->fecha_upd)" autocomplete="fecha_upd" placeholder="Fecha Upd"/>
        <x-input-error class="mt-2" :messages="$errors->get('fecha_upd')"/>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>