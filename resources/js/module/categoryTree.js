export function initCategoryTree() {
    document.querySelectorAll('.toggle-children').forEach(button => {
        button.addEventListener('click', function () {
            const container = this.closest('li').querySelector('.children-container');
            if (container) {
                container.classList.toggle('hidden');
                this.textContent = container.classList.contains('hidden') ? '▶' : '▼';
            }
        });
    });
}
