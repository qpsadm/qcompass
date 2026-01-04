<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const openBtn = document.getElementById('sidebar-open');
        const closeBtn = document.getElementById('sidebar-close');

        // サイドバー開閉
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                openBtn.classList.remove('hidden');
            });
        }

        if (openBtn) {
            openBtn.addEventListener('click', () => {
                sidebar.classList.remove('-translate-x-full');
                openBtn.classList.add('hidden');
            });
        }

        // アコーディオン
        const accordions = document.querySelectorAll('.accordion');
        const STORAGE_KEY = "sidebar_open_index";

        // ページ読み込み時に前回開いたアコーディオンを復元
        const savedIndex = localStorage.getItem(STORAGE_KEY);
        if (savedIndex !== null) {
            accordions.forEach((acc, index) => {
                const content = acc.querySelector('.accordion-content');
                if (index == savedIndex) {
                    content.classList.remove('hidden');
                } else {
                    content.classList.add('hidden');
                }
            });
        }

        // クリック時の展開/格納
        accordions.forEach((acc, index) => {
            const btn = acc.querySelector('.accordion-btn');
            const content = acc.querySelector('.accordion-content');

            if (btn) {
                btn.addEventListener('click', () => {
                    accordions.forEach((otherAcc, otherIndex) => {
                        const otherContent = otherAcc.querySelector('.accordion-content');
                        if (otherIndex !== index) otherContent.classList.add('hidden');
                    });

                    if (content) content.classList.toggle('hidden');

                    if (!content.classList.contains('hidden')) {
                        localStorage.setItem(STORAGE_KEY, index);
                    } else {
                        localStorage.removeItem(STORAGE_KEY);
                    }
                });
            }
        });
    });
</script>
