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

document.addEventListener('DOMContentLoaded', async () => {
    const editors = document.querySelectorAll('.ckeditor');
    const tokenMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = tokenMeta ? tokenMeta.getAttribute('content') : '';

    const module = await import('./ckeditor');
    const ClassicEditor = module.default || module;

    editors.forEach(el => {
        ClassicEditor.create(el, {
            ckfinder: {
                uploadUrl: '/ckeditor/upload?_token=' + csrfToken
            }
        }).catch(error => console.error('CKEditor error:', error));
    });
});
