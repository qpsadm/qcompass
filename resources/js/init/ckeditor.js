import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

export function initCKEditor() {
    const editors = document.querySelectorAll('.ckeditor');
    editors.forEach(el => {
        ClassicEditor.create(el, {
            language: 'ja'
        }).catch(error => console.error(error));
    });
}
