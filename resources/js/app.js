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


import ClassicEditor from '@ckeditor/ckeditor5-build-classic';


document.addEventListener('DOMContentLoaded', () => {
    const editors = document.querySelectorAll('.ckeditor');
    const tokenMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = tokenMeta ? tokenMeta.getAttribute('content') : '';

    editors.forEach(el => {
        ClassicEditor.create(el, {
            language: 'ja',//  ← これを入れるとボタンが消える場合があるので一旦外す
            ckfinder: {
                uploadUrl: '/ckeditor/upload?_token=' + csrfToken
            }
        }).catch(error => console.error('CKEditor error:', error));
    });
});
