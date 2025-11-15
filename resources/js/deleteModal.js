export function initDeleteModal() {
    const modal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deleteForm');
    const cancelBtn = document.getElementById('cancelDelete');

    document.querySelectorAll('form[data-delete]').forEach(form => {
        const deleteBtn = form.querySelector('button[type="submit"]');
        deleteBtn.addEventListener('click', function (e) {
            e.preventDefault();
            const action = form.getAttribute('action');
            deleteForm.setAttribute('action', action);
            modal.classList.remove('hidden');
        });
    });

    cancelBtn?.addEventListener('click', function () {
        modal.classList.add('hidden');
    });
}
