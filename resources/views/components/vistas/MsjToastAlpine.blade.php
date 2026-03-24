<div x-data="{ 
        duration: 6000,
        show: false, 
        message: '', 
        type: '',
        get config() {
        const types = {
            success: { border: 'border-green-500', barColor: 'bg-green-500', iconColor: 'text-green-600', icon: 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z', anim: 'animate-success-combo' },
            error: { border: 'border-red-600', barColor: 'bg-red-600', iconColor: 'text-red-600', icon: 'M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z', anim: 'animate-error-combo' },
            info: { border: 'border-blue-500', barColor: 'bg-blue-500', iconColor: 'text-blue-600', icon: 'M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12v-.008z', anim: 'animate-info-combo' },
            deleted: { border: 'border-orange-700', barColor: 'bg-orange-700', iconColor: 'text-orange-700', icon: 'M6 7.5h12M9.75 7.5v9m4.5-9v9M4.5 7.5h15m-13.5 0l.75 12a2.25 2.25 0 002.244 2.1h6.012a2.25 2.25 0 002.244-2.1l.75-12M9 7.5V5.25A1.5 1.5 0 0110.5 3.75h3A1.5 1.5 0 0115 5.25V7.5', anim: 'animate-deleted-combo' }
        };
            return types[this.type] || types.info;
        }
    }"
    x-init="
        @if(session('success')) message = '{{ session('success') }}'; type = 'success'; @endif
        @if(session('error')) message = '{{ session('error') }}'; type = 'error'; @endif
        @if(session('status')) message = '{{ session('status') }}'; type = 'info'; @endif
        @if(session('info')) message = '{{ session('info') }}'; type = 'info'; @endif
        @if(session('eliminated')) message = '{{ session('eliminated') }}'; type = 'deleted'; @endif
        @if(session('toast_time')) duration = {{ session('toast_time') }}; @endif
        
        if(message) {
            show = true;
            setTimeout(() => show = false, duration); {{-- recibe el tiempo desde el controlador --}}
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
        {{-- <div x-show="show" :class="config.barColor" class="h-full animate-progress-bar"></div> --}}
        <div 
    x-show="show" 
    :style="'--toast-duration:' + duration + 'ms'" 
    :class="config.barColor" 
    class="h-full animate-progress-bar">
</div>
    </div>
</div>

<style>
    /* Barra de progreso: acorde al timeout que dura el mensaje */
    .animate-progress-bar { animation: progress-drain var(--toast-duration) linear forwards; }

    /* Animaciones de iconos: 3 segundos (Se detienen 2s antes del final) */
    .animate-custom-bounce { animation: custom-bounce 0.7s ease-in-out 4; } /* 0.7s  =  duracion de la animacion y 4 = cantidad de repeticiones*/
    .animate-custom-shake { animation: custom-shake 0.2s ease-in-out 5; } 
    .animate-custom-pulse { animation: custom-pulse 1s ease-in-out 2; }
    .animate-custom-rotate { animation: custom-rotate 0.8s ease-in-out 2; }
    .animate-custom-pop { animation: custom-pop 0.4s ease-out 1; }
    .animate-custom-wiggle { animation: custom-wiggle 0.4s ease-in-out 3; }
    .animate-custom-slide-up { animation: custom-slide-up 0.4s ease-out 1; }
    .animate-custom-heartbeat { animation: custom-heartbeat 0.8s ease-in-out 2; }
    .animate-custom-flip { animation: custom-flip 0.6s ease-in-out 1; }
    .animate-custom-glow { animation: custom-glow 1s ease-in-out 2; }
    /* SUCCESS: rebote + glow */
    .animate-success-combo { animation: custom-bounce 0.6s ease-in-out 2, custom-flip 1s ease-in-out 2; }
    /* ERROR: shake fuerte */
    .animate-error-combo { animation: custom-shake 0.25s ease-in-out 6; }
    /* INFO: pulse + aparición suave */
    .animate-info-combo { animation: custom-pulse 1s ease-in-out 2, custom-slide-up 0.4s ease-out 1; }
    /* DELETED: shake + leve fade */
    .animate-deleted-combo { animation: custom-rotate 0.2s ease-in-out 5, custom-wiggle 0.3s ease-in-out 2; }    

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

    @keyframes custom-rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    @keyframes custom-pop {
        0% { transform: scale(0.5); opacity: 0; }
        70% { transform: scale(1.2); opacity: 1; }
        100% { transform: scale(1); }
    }

    @keyframes custom-wiggle {
        0%, 100% { transform: rotate(0deg); }
        25% { transform: rotate(-5deg); }
        75% { transform: rotate(5deg); }
    }

    @keyframes custom-slide-up {
        0% { transform: translateY(10px); opacity: 0; }
        100% { transform: translateY(0); opacity: 1; }
    }

    @keyframes custom-heartbeat {
        0%, 100% { transform: scale(1); }
        25% { transform: scale(1.2); }
        40% { transform: scale(0.95); }
        60% { transform: scale(1.1); }
    }

    @keyframes custom-flip {
        0% { transform: rotateY(0); }
        50% { transform: rotateY(90deg); }
        100% { transform: rotateY(0); }
    }

    @keyframes custom-glow {
        0%, 100% { 
            filter: drop-shadow(0 0 0px currentColor);
        }
        50% { 
            filter: drop-shadow(0 0 6px currentColor)
                    drop-shadow(0 0 12px currentColor);
        }
    }    

    @keyframes custom-glow-green {
        0%, 100% { 
            filter: drop-shadow(0 0 0px #22c55e);
        }
        50% { 
            filter: drop-shadow(0 0 8px #22c55e)
                    drop-shadow(0 0 16px #22c55e);
        }
    }

    .animate-custom-glow-green {
        animation: custom-glow-green 1s ease-in-out 2;
    }


</style>
