@props(['route', 'label'])

<a href="{{ $route }}" 
   {{ $attributes->merge(['class' => 'group inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-md transition-all duration-200']) }}>
    
    <svg class="w-5 h-5 mr-1.5 transform group-hover:-translate-x-1 transition-transform duration-200" 
        fill="none" 
        stroke="currentColor" 
        viewBox="0 0 24 24">
        <path stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M11 15l-3-3m0 0l3-3m-3 3h8M3 6h5M3 12h1M3 18h5m3-12h10M11 18h10">
        </path>
    </svg>

    <span>{{ __($label) }}</span>
</a>
