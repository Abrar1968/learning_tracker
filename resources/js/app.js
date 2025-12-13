import './bootstrap';

import Alpine from 'alpinejs';
import { initAllCharts } from './charts';
import './sortable';
import './celebration';
import './toast';
import './dark-mode';
import './keyboard-shortcuts';

window.Alpine = Alpine;

Alpine.start();

// Initialize charts if chart data exists
if (window.chartData) {
    document.addEventListener('DOMContentLoaded', () => {
        initAllCharts(window.chartData);
    });
}
