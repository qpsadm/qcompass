import './bootstrap';
import Alpine from 'alpinejs';
import { initSidebar } from './sidebar';
import { initCategoryTree } from './categoryTree';
import { initDeleteModal } from './deleteModal';

window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    initSidebar();
    initCategoryTree();
    initDeleteModal();
});
