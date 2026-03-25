import './bootstrap';

import Alpine from 'alpinejs';

import './bootstrap';

// PARA USAR CON SELECT2
import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;

import select2 from 'select2';
select2(); // Inicializa el plugin en jQuery

// Importar el CSS de Select2 (opcional aquí o en app.css)
import 'select2/dist/css/select2.min.css';
// PARA USAR CON SELECT2


import Swal from 'sweetalert2';
window.Swal = Swal;

window.Alpine = Alpine;

Alpine.start();


