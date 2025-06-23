import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import Chart from 'chart.js/auto';
window.Chart = Chart;

import Swal from 'sweetalert2';
import { initAppListeners } from './custom/app-listeners';
window.Swal = Swal;

console.log('App JS Loaded');

document.addEventListener('livewire:init', () => {
    initAppListeners();
});
