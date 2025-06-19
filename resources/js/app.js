import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import Chart from 'chart.js/auto';
window.Chart = Chart;

import Swal from 'sweetalert2';
window.Swal = Swal;

console.log('App JS Loaded');

import { initListUser } from './custom/list-user';
document.addEventListener('livewire:init', () => {
    console.log('✅ livewire:init event fired'); // <--
    initListUser();
});
