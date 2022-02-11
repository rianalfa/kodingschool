require('./bootstrap');
require('@fortawesome/fontawesome-free/js/all.min.js');

import Alpine from 'alpinejs';
import swal from 'sweetalert2';
window.Swal = swal;

window.Alpine = Alpine;
window.$ = require( "jquery" );

Alpine.start();
