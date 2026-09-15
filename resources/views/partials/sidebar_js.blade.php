<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.getElementById('sidebar');
        const openBtn = document.getElementById('sidebar-open');
        const closeBtn = document.getElementById('sidebar-close');
        const mainContent = document.getElementById('mainContent');

        /* 画面幅の直前状態を保持（PC↔SP切り替え検知用） */
        let wasSmallScreen = window.innerWidth < 1280;

        /* ==========================================
         * 1. サイドバー＆ボタン＆Main切り替え制御
         * ========================================== */
        if (sidebar && openBtn && closeBtn) {

            const updateLayout = () => {
                const isSmallScreen = window.innerWidth < 1280;

                if (!isSmallScreen) {
                    // １．フルサイズ（1280px以上）
                    // サイドバーを表示 / Mainにマージンを付与 / ボタンはすべて非表示
                    sidebar.classList.remove('-translate-x-full');
                    sidebar.classList.add('translate-x-0');

                    if (mainContent) {
                        mainContent.classList.remove('ml-0');
                        mainContent.classList.add('ml-64');
                    }

                    closeBtn.classList.add('hidden');
                    openBtn.classList.add('hidden');
                } else {
                    // ２．画面幅が1280px未満（Mainは左端寄せ）
                    if (mainContent) {
                        mainContent.classList.remove('ml-64');
                        mainContent.classList.add('ml-0');
                    }

                    // PCサイズから1280px未満に縮んだ「瞬間」に自動でサイドバーを閉じる
                    if (!wasSmallScreen) {
                        sidebar.classList.add('-translate-x-full');
                        sidebar.classList.remove('translate-x-0');
                    }

                    // 現在のサイドバー表示状態を確認
                    const isSidebarOpen = sidebar.classList.contains('translate-x-0') &&
                        !sidebar.classList.contains('-translate-x-full');

                    if (isSidebarOpen) {
                        // サイドバー表示中：閉じるボタンを表示
                        closeBtn.classList.remove('hidden');
                        openBtn.classList.add('hidden');
                    } else {
                        // サイドバー非表示中：再表示ボタンを表示
                        sidebar.classList.add('-translate-x-full');
                        sidebar.classList.remove('translate-x-0');

                        openBtn.classList.remove('hidden');
                        closeBtn.classList.add('hidden');
                    }
                }

                // 現在の画面状態を保存
                wasSmallScreen = isSmallScreen;
            };

            // 初期化判定を実行
            updateLayout();

            // 閉じるボタンクリックイベント
            closeBtn.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
                updateLayout();
            });

            // 再表示（開く）ボタンクリックイベント
            openBtn.addEventListener('click', () => {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                updateLayout();
            });

            // ウィンドウリサイズ時追従
            window.addEventListener('resize', updateLayout);
        }

        /* ==========================================
         * 2. アコーディオン制御 (状態復元付き)
         * ========================================== */
        const accordions = document.querySelectorAll('.accordion');
        const STORAGE_KEY = 'sidebar_open_index';
        const savedIndex = localStorage.getItem(STORAGE_KEY);

        // 前回開いていた項目を復元
        if (savedIndex !== null && accordions[savedIndex]) {
            const savedAcc = accordions[savedIndex];
            const content = savedAcc.querySelector('.accordion-content');
            const icon = savedAcc.querySelector('.accordion-icon');

            if (content) content.classList.remove('hidden');
            if (icon) icon.classList.add('rotate-180');
        }

        // 各アコーディオンへのイベントバインド
        accordions.forEach((acc, index) => {
            const btn = acc.querySelector('.accordion-btn');
            const content = acc.querySelector('.accordion-content');
            const icon = acc.querySelector('.accordion-icon');

            if (!btn || !content) return; // 安全策：要素不足時は処理スキップ

            btn.addEventListener('click', () => {
                // 他の開いているアコーディオンを閉じる
                accordions.forEach((otherAcc, otherIndex) => {
                    if (otherIndex !== index) {
                        const otherContent = otherAcc.querySelector(
                            '.accordion-content');
                        const otherIcon = otherAcc.querySelector('.accordion-icon');
                        if (otherContent) otherContent.classList.add('hidden');
                        if (otherIcon) otherIcon.classList.remove('rotate-180');
                    }
                });

                // トグル実行
                content.classList.toggle('hidden');
                if (icon) icon.classList.toggle('rotate-180');

                // 開閉状態を localStorage に保存
                if (!content.classList.contains('hidden')) {
                    localStorage.setItem(STORAGE_KEY, index);
                } else {
                    localStorage.removeItem(STORAGE_KEY);
                }
            });
        });
    });
</script>
