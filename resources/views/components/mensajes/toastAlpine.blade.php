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
                deleted: { border: 'border-orange-700', barColor: 'bg-orange-700', iconColor: 'text-orange-700', icon: 'M14.74 9l-.34 12m-4.74 0L9.26 9m9.96-3.32a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0', anim: 'animate-deleted-combo' },
                inactive: { border: 'border-slate-400', barColor: 'bg-slate-400', iconColor: 'text-slate-500', icon: 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636', anim: 'animate-inactive-combo' },
                warning: { border: 'border-amber-500', barColor: 'bg-amber-500', iconColor: 'text-amber-500', icon: 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z', anim: 'animate-warning-combo' }                        
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
        @if(session('inactive')) message = '{{ session('inactive') }}'; type = 'inactive'; @endif
        @if(session('warning')) message = '{{ session('warning') }}'; type = 'warning'; @endif
        
        @if(session('toast_time')) duration = {{ session('toast_time') }}; @endif
        
        if(message) {
            show = true;
            setTimeout(() => show = false, duration);
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

    <div class="h-1 w-full bg-gray-100">
        <div x-show="show" :style="'--toast-duration:' + duration + 'ms'" :class="config.barColor" class="h-full animate-progress-bar"></div>
    </div>
</div>

<style>
    .animate-progress-bar { animation: progress-drain var(--toast-duration) linear forwards; }

    /* Combos de animación */
    .animate-success-combo { animation: custom-bounce 0.6s ease-in-out 2, custom-flip 1s ease-in-out 2; }
    .animate-error-combo { animation: custom-shake 0.25s ease-in-out 6; }
    .animate-info-combo { animation: custom-pulse 1s ease-in-out 2, custom-slide-up 0.4s ease-out 1; }
    .animate-deleted-combo { animation: custom-rotate 0.2s ease-in-out 5, custom-wiggle 0.3s ease-in-out 2; }
    .animate-inactive-combo { animation: custom-flicker-off 1.5s ease-in-out forwards; }
    .animate-warning-combo { animation: custom-wiggle 0.3s ease-in-out 4, custom-glow-amber 1s ease-in-out 2; }

    @keyframes progress-drain { from { width: 100%; } to { width: 0%; } }
    @keyframes custom-bounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
    @keyframes custom-shake { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-4px); } 75% { transform: translateX(4px); } }
    @keyframes custom-pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.2); opacity: 0.7; } }
    @keyframes custom-rotate { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    @keyframes custom-wiggle { 0%, 100% { transform: rotate(0deg); } 25% { transform: rotate(-8deg); } 75% { transform: rotate(8deg); } }
    @keyframes custom-slide-up { 0% { transform: translateY(10px); opacity: 0; } 100% { transform: translateY(0); opacity: 1; } }
    @keyframes custom-flip { 0% { transform: rotateY(0); } 50% { transform: rotateY(90deg); } 100% { transform: rotateY(0); } }
    
    @keyframes custom-glow-amber {
        0%, 100% { filter: drop-shadow(0 0 2px #f59e0b); }
        50% { filter: drop-shadow(0 0 10px #f59e0b); }
    }

    @keyframes custom-flicker-off {
        0%, 100% { opacity: 1; filter: grayscale(0%); transform: scale(1); }
        10%, 30%, 50% { opacity: 0.3; filter: grayscale(100%); transform: scale(0.95); }
        20%, 40%, 60% { opacity: 1; filter: grayscale(0%); transform: scale(1); }
        70% { opacity: 0.5; filter: grayscale(100%); transform: scale(0.9); }
        100% { opacity: 0.6; filter: grayscale(100%); }
    }
</style>
