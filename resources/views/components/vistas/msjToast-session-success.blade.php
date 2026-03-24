<!-- Toast Animado con Alpine.js -->
@if (session('success'))
    <div x-data="{ show: false }"
         x-init="setTimeout(() => show = true, 100); setTimeout(() => show = false, 4000)"
         x-show="show"
         {{-- Animación de entrada con Rebote (Bounce) --}}
         x-transition:enter="transform ease-out duration-500 transition"
         x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-10 scale-95"
         x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0 scale-100"
         {{-- Animación de salida suave --}}
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-90"
         class="fixed top-5 right-5 z-50 max-w-sm w-full bg-white shadow-2xl rounded-xl border-l-4 border-green-500 pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden"
         style="display: none;">
        
        <div class="p-4 bg-white">
            <div class="flex items-center">
                {{-- Icono Animado: Escala al aparecer --}}
                <div class="flex-shrink-0 animate-bounce">
                    <div class="bg-green-100 rounded-full p-1">
                        <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <div class="ml-3 w-0 flex-1">
                    <p class="text-sm font-bold text-gray-900">¡Éxito!</p>
                    <p class="text-xs text-gray-500">{{ session('success') }}</p>
                </div>

                <div class="ml-4 flex-shrink-0 flex">
                    <button @click="show = false" class="inline-flex text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        {{-- Barra de progreso animada en la parte inferior --}}
        <div class="absolute bottom-0 left-0 h-1 bg-green-500 animate-[progress_4s_linear]"></div>
    </div>

    <style>
        @keyframes progress {
            from { width: 100%; }
            to { width: 0%; }
        }
    </style>
@endif
