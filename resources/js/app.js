import './bootstrap';
import './init/alpine';
import { initUI } from './init/ui';

import { initAgendaPreview } from './module/previewWindow';
import { initSidebar } from './module/sidebar';

document.addEventListener('DOMContentLoaded', () => {
    initUI();
    initAgendaPreview();
    initSidebar();
});
