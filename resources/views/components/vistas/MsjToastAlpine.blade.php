<div x-data="{ 
        show: false, 
        message: '', 
        type: '',
        get config() {
            const types = {
                success: { border: 'border-green-500', barColor: 'bg-green-500', iconColor: 'text-green-600', icon: 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z', anim: 'animate-custom-bounce' },
                error: { border: 'border-red-600', barColor: 'bg-red-600', iconColor: 'text-red-600', icon: 'M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z', anim: 'animate-custom-shake' },
                info: { border: 'border-blue-500', barColor: 'bg-blue-500', iconColor: 'text-blue-600', icon: 'M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12v-.008z', anim: 'animate-custom-pulse' }
            };
            return types[this.type] || types.info;
        }
    }"
    x-init="
        @if(session('success')) message = '{{ session('success') }}'; type = 'success'; @endif
        @if(session('error')) message = '{{ session('error') }}'; type = 'error'; @endif
        @if(session('status')) message = '{{ session('status') }}'; type = 'info'; @endif
        @if(session('info')) message = '{{ session('info') }}'; type = 'info'; @endif
        
        if(message) {
            show = true;
            setTimeout(() => show = false, 5000); {{-- Desaparece a los 5 segundos --}}
        }
    "
    x-show="show"
    x-transition:enter="transition ease-out duration-500"
    x-transition:enter-start="opacity-0 scale-90 translate-x-10"
    x-transition:enter-end="opacity-100 scale-100 translate-x-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-90"
    :class="config.border"
    class="fixed top-5 right-5 z-50 flex flex-col w-full max-w-xs bg-white rounded-lg shadow-2xl border-l-8 pointer-events-auto overflow-hidden"
    style="display: none;"
>
    <div class="flex items-center p-4">
        <!-- Icono con animación de 3 segundos -->
        <div :class="show ? config.anim : ''" class="flex-shrink-0">
            <svg class="w-8 h-8" :class="config.iconColor" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" :d="config.icon" />
            </svg>
        </div>

        <div class="ml-3">
            <p class="text-xs text-gray-600 font-medium" x-text="message"></p>
        </div>

        <button @click="show = false" class="ml-auto text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    <!-- Barra de progreso de 5 segundos -->
    <div class="h-1 w-full bg-gray-100">
        <div x-show="show" :class="config.barColor" class="h-full animate-progress-bar"></div>
    </div>
</div>

<style>
    /* Barra de progreso: 5 segundos acorde a la linea 22 del timeout que dura el mensaje */
    .animate-progress-bar {
        animation: progress-drain 5s linear forwards;
    }

    /* Animaciones de iconos: 3 segundos (Se detienen 2s antes del final) */
    .animate-custom-bounce { animation: custom-bounce 0.7s ease-in-out 4; } /* 0.7s  =  duracion de la animacion y 4 = cantidad de repeticiones*/
    .animate-custom-shake { animation: custom-shake 0.2s ease-in-out 5; } 
    .animate-custom-pulse { animation: custom-pulse 1s ease-in-out 2; }

    @keyframes progress-drain {
        from { width: 100%; }
        to { width: 0%; }
    }

    @keyframes custom-bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    @keyframes custom-shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-4px); }
        75% { transform: translateX(4px); }
    }

    @keyframes custom-pulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.2); opacity: 0.7; }
    }
</style>
