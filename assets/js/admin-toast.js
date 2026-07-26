/**
 * Admin panel toast notifications — replaces native alert() popups.
 * Matches the admin theme's own accent color (reads --primary CSS variable,
 * so it stays correct even if the theme customizer switches accent colors).
 *
 * Usage: adminToast('Message here', 'success' | 'error' | 'warning' | 'info');
 */
(function () {
    let container = null;

    function getContainer() {
        if (!container) {
            container = document.createElement('div');
            container.id = 'admin-toast-container';
            container.style.cssText = `
                position: fixed; top: 20px; right: 20px; z-index: 99999;
                display: flex; flex-direction: column; gap: 10px;
                max-width: 340px;
            `;
            document.body.appendChild(container);
        }
        return container;
    }

    const typeStyles = {
        success: { bg: '#e7f7ee', border: '#1a9c5b', icon: '✔', iconColor: '#1a9c5b' },
        error:   { bg: '#fdf1f1', border: '#db1215', icon: '✖', iconColor: '#db1215' },
        warning: { bg: '#fff8e6', border: '#b56a00', icon: '!', iconColor: '#b56a00' },
        info:    { bg: '#eef6ff', border: '#0d6efd', icon: 'i', iconColor: '#0d6efd' },
    };

    window.adminToast = function (message, type = 'info') {
        const style = typeStyles[type] || typeStyles.info;
        const el = document.createElement('div');
        el.style.cssText = `
            display: flex; align-items: flex-start; gap: 10px;
            background: #fff; border-left: 4px solid ${style.border};
            box-shadow: 0 8px 24px -8px rgba(0,0,0,.25);
            border-radius: 6px; padding: 14px 16px;
            font-family: inherit; font-size: 13.5px; color: #333;
            opacity: 0; transform: translateX(30px);
            transition: opacity .3s cubic-bezier(.16,1,.3,1), transform .3s cubic-bezier(.16,1,.3,1);
        `;
        el.innerHTML = `
            <span style="flex:none;width:22px;height:22px;border-radius:50%;background:${style.bg};color:${style.iconColor};display:flex;align-items:center;justify-content:center;font-weight:700;font-size:12px;">${style.icon}</span>
            <span style="flex:1;line-height:1.5;padding-top:2px;">${message}</span>
            <span style="cursor:pointer;color:#aaa;font-size:16px;line-height:1;padding:2px;" data-close>&times;</span>
        `;

        getContainer().appendChild(el);
        requestAnimationFrame(() => {
            el.style.opacity = '1';
            el.style.transform = 'translateX(0)';
        });

        function remove() {
            el.style.opacity = '0';
            el.style.transform = 'translateX(30px)';
            setTimeout(() => el.remove(), 300);
        }

        el.querySelector('[data-close]').addEventListener('click', remove);
        setTimeout(remove, 4000);
    };
})();