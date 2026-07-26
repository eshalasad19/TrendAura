/**
 * TrendAura customer-site toast notifications.
 * Shared across all pages (included once via footer.php) so the HTML/CSS/JS
 * isn't duplicated per-page anymore.
 *
 * Usage from PHP: echo "<script>showToast('Message', 'success');</script>";
 *
 * Optional per-page redirect after the toast closes — set these BEFORE this
 * script loads if a page wants one (most pages don't need to set anything):
 *   <script>window.TOAST_REDIRECT_SUCCESS = 'view-cart.php';</script>
 *   <script>window.TOAST_REDIRECT_ERROR = 'login.php';</script>
 */
(function () {
    let container = null;

    function getContainer() {
        if (!container) {
            container = document.getElementById('toast-container');
        }
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            container.style.cssText = `
                position: fixed; top: 24px; right: 24px; z-index: 99999;
                display: flex; flex-direction: column; gap: 12px;
                max-width: calc(100vw - 40px); width: 340px;
            `;
            document.body.appendChild(container);
        }
        return container;
    }

    const typeStyles = {
        success: { accent: '#000000', icon: '&#10003;' },
        error:   { accent: '#db1215', icon: '&#10005;' },
    };

    window.showToast = function (message, type = 'success') {
        const style = typeStyles[type] || typeStyles.success;
        const el = document.createElement('div');
        el.style.cssText = `
            position: relative; overflow: hidden;
            display: flex; align-items: center; gap: 12px;
            background: #ffffff; border-radius: 8px;
            box-shadow: 0 16px 40px -12px rgba(0,0,0,.25);
            padding: 16px 18px; font-family: 'Albert Sans', Arial, sans-serif;
            opacity: 0; transform: translateY(-16px) scale(.97);
            transition: opacity .35s cubic-bezier(.16,1,.3,1), transform .35s cubic-bezier(.16,1,.3,1);
        `;
        el.innerHTML = `
            <span style="flex:none;width:28px;height:28px;border-radius:50%;background:${style.accent};color:#fff;display:flex;align-items:center;justify-content:center;font-size:13px;">${style.icon}</span>
            <span style="flex:1;font-size:14px;color:#111;line-height:1.5;">${message}</span>
            <span style="cursor:pointer;color:#bbb;font-size:18px;line-height:1;padding:2px;" data-close>&times;</span>
            <span data-bar style="position:absolute;left:0;bottom:0;height:3px;background:${style.accent};width:100%;transform-origin:left;"></span>
        `;

        getContainer().appendChild(el);
        requestAnimationFrame(() => {
            el.style.opacity = '1';
            el.style.transform = 'translateY(0) scale(1)';
        });

        const bar = el.querySelector('[data-bar]');
        bar.style.transition = 'transform 3s linear';
        requestAnimationFrame(() => { bar.style.transform = 'scaleX(0)'; });

        function close() {
            el.style.opacity = '0';
            el.style.transform = 'translateY(-16px) scale(.97)';
            setTimeout(() => {
                el.remove();
                const redirect = type === 'success' ? window.TOAST_REDIRECT_SUCCESS : window.TOAST_REDIRECT_ERROR;
                if (redirect) window.location.href = redirect;
            }, 350);
        }

        el.querySelector('[data-close]').addEventListener('click', close);
        setTimeout(close, 3000);
    };

    /**
     * Custom confirm modal — replaces native confirm().
     * Usage: showConfirm('Are you sure?', function() { // runs if user confirms
     * });
     */
    window.showConfirm = function (message, onConfirm) {
        const overlay = document.createElement('div');
        overlay.style.cssText = `
            position: fixed; inset: 0; background: rgba(0,0,0,.55); z-index: 999999;
            display: flex; align-items: center; justify-content: center;
            opacity: 0; transition: opacity .25s;
        `;
        overlay.innerHTML = `
            <div style="background:#fff;border-radius:12px;padding:28px 30px;max-width:340px;width:90%;text-align:center;transform:scale(.95);transition:transform .25s;">
                <p style="font-size:15px;color:#111;margin:0 0 22px;line-height:1.5;">${message}</p>
                <div style="display:flex;gap:10px;justify-content:center;">
                    <button data-cancel style="flex:1;padding:11px;border-radius:6px;border:1px solid #ddd;background:#fff;font-weight:600;font-size:13px;cursor:pointer;">Cancel</button>
                    <button data-confirm style="flex:1;padding:11px;border-radius:6px;border:none;background:#db1215;color:#fff;font-weight:600;font-size:13px;cursor:pointer;">Confirm</button>
                </div>
            </div>
        `;
        document.body.appendChild(overlay);
        requestAnimationFrame(() => {
            overlay.style.opacity = '1';
            overlay.querySelector('div').style.transform = 'scale(1)';
        });

        function remove() {
            overlay.style.opacity = '0';
            setTimeout(() => overlay.remove(), 250);
        }

        overlay.querySelector('[data-cancel]').addEventListener('click', remove);
        overlay.addEventListener('click', (e) => { if (e.target === overlay) remove(); });
        overlay.querySelector('[data-confirm]').addEventListener('click', () => {
            remove();
            onConfirm();
        });
    };
})();