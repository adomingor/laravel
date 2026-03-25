@if(session('success') || session('error') || session('status') || session('info') || session('erased') || session('inactive') || session('warning'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Configuración base del Toast
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: {{ session('toast_time', 3000) }}, // Usa el tiempo de la sesión o 3000 por defecto
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // Definición de variables desde la sesión
        let message = '';
        let icon = 'info'; // Icono por defecto de SweetAlert

        @if(session('success')) 
            message = "{{ session('success') }}"; icon = 'success'; 
        @elseif(session('error')) 
            message = "{{ session('error') }}"; icon = 'error'; 
        @elseif(session('status') || session('info')) 
            message = "{{ session('status') ?? session('info') }}"; icon = 'info'; 
        @elseif(session('warning')) 
            message = "{{ session('warning') }}"; icon = 'warning'; 
        @elseif(session('erased')) 
            message = "{{ session('erased') }}"; icon = 'error'; // Usamos error (rojo) para borrados
        @elseif(session('inactive')) 
            message = "{{ session('inactive') }}"; icon = 'question'; // Icono azul/gris para inactivos
        @endif

        // Lanzar el Toast
        if (message) {
            Toast.fire({
                icon: icon,
                title: message
            });
        }
    });
</script>
@endif