export function initSidebar() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const closeBtn = document.getElementById('sidebar-close');
    const openBtn = document.getElementById('sidebar-open');

    closeBtn?.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        mainContent.classList.replace('ml-64', 'ml-0');
        openBtn.classList.remove('hidden');
    });

    openBtn?.addEventListener('click', () => {
        sidebar.classList.remove('-translate-x-full');
        mainContent.classList.replace('ml-0', 'ml-64');
        openBtn.classList.add('hidden');
    });
}
