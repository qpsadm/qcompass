<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.getElementById('sidebar');
        const openBtn = document.getElementById('sidebar-open');
        const closeBtn = document.getElementById('sidebar-close');

        /* =========
           SP トグル
           ========= */
        if (openBtn && closeBtn && sidebar) {
            // 初期：SPでは開くボタン表示
            if (window.innerWidth < 1024) {
                openBtn.classList.remove('hidden');
            }

            closeBtn.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                openBtn.classList.remove('hidden');
            });

            openBtn.addEventListener('click', () => {
                sidebar.classList.remove('-translate-x-full');
                openBtn.classList.add('hidden');
            });
        }

        /* =========
           アコーディオン
           ========= */
        const accordions = document.querySelectorAll('.accordion');
        const STORAGE_KEY = 'sidebar_open_index';

        // 復元
        const savedIndex = localStorage.getItem(STORAGE_KEY);
        if (savedIndex !== null) {
            accordions.forEach((acc, index) => {
                const content = acc.querySelector('.accordion-content');
                const icon = acc.querySelector('.accordion-icon');

                if (index == savedIndex) {
                    content.classList.remove('hidden');
                    icon.classList.add('rotate-180');
                }
            });
        }

        // クリック
        accordions.forEach((acc, index) => {
            const btn = acc.querySelector('.accordion-btn');
            const content = acc.querySelector('.accordion-content');
            const icon = acc.querySelector('.accordion-icon');

            btn.addEventListener('click', () => {
                accordions.forEach((otherAcc, otherIndex) => {
                    const otherContent = otherAcc.querySelector('.accordion-content');
                    const otherIcon = otherAcc.querySelector('.accordion-icon');

                    if (otherIndex !== index) {
                        otherContent.classList.add('hidden');
                        otherIcon.classList.remove('rotate-180');
                    }
                });

                content.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');

                if (!content.classList.contains('hidden')) {
                    localStorage.setItem(STORAGE_KEY, index);
                } else {
                    localStorage.removeItem(STORAGE_KEY);
                }
            });
        });
    });
</script>
