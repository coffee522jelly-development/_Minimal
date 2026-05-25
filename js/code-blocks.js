/**
 * Code Block Enhancements: Syntax Highlighting with Shiki and Copy to Clipboard
 */
(function() {
    document.addEventListener('DOMContentLoaded', async () => {
        const codeBlocks = document.querySelectorAll('pre code');
        if (codeBlocks.length === 0) return;

        const waitForShiki = () => {
            return new Promise((resolve, reject) => {
                let attempts = 0;
                const check = () => {
                    if (window.shiki && window.shiki.codeToHtml) {
                        resolve(window.shiki);
                    } else if (attempts > 50) {
                        reject('Shiki timeout');
                    } else {
                        attempts++;
                        setTimeout(check, 100);
                    }
                };
                check();
            });
        };

        let shikiObj;
        try {
            shikiObj = await waitForShiki();
        } catch (e) {
            console.warn('Shiki not loaded, falling back to basic styling');
        }

        const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
        const darkThemes = ['dark', 'dracula', 'black', 'luxury', 'night', 'coffee', 'sunset', 'dim'];
        const isDark = darkThemes.includes(currentTheme);
        const shikiTheme = isDark ? 'github-dark' : 'github-light';

        for (const block of codeBlocks) {
            const pre = block.parentElement;
            pre.classList.add('relative', 'group', 'overflow-visible');

            let lang = 'text';
            const classes = Array.from(block.classList);
            const langClass = classes.find(c => c.startsWith('language-'));
            if (langClass) {
                lang = langClass.replace('language-', '');
            } else if (pre.classList.contains('wp-block-code')) {
                const preLangClass = Array.from(pre.classList).find(c => c.startsWith('language-'));
                if (preLangClass) lang = preLangClass.replace('language-', '');
            }

            if (shikiObj) {
                try {
                    const code = block.innerText.trim();
                    const highlighted = await shikiObj.codeToHtml(code, {
                        lang: lang,
                        theme: shikiTheme
                    });

                    const temp = document.createElement('div');
                    temp.innerHTML = highlighted;
                    const newPre = temp.querySelector('pre');

                    if (newPre) {
                        const newCode = newPre.querySelector('code');
                        block.innerHTML = newCode.innerHTML;
                        // Do NOT override background or color here anymore,
                        // as we handle it via dynamic CSS in header.php
                    }
                } catch (e) {
                    console.error('Shiki highlighting failed for block:', e);
                }
            }

            const header = document.createElement('div');
            header.className = 'absolute right-2 top-2 flex items-center gap-3 z-20 opacity-0 group-hover:opacity-100 transition-opacity duration-200';

            const langLabel = document.createElement('span');
            langLabel.className = 'text-[10px] font-bold tracking-widest opacity-40 uppercase pointer-events-none';
            langLabel.innerText = lang;

            const copyBtn = document.createElement('button');
            copyBtn.className = 'btn btn-xs btn-ghost btn-square hover:bg-base-content/10';
            copyBtn.innerHTML = '<i data-feather="copy" class="w-3 h-3"></i>';
            copyBtn.title = 'Copy Code';

            copyBtn.addEventListener('click', (e) => {
                e.preventDefault();
                const text = block.innerText;
                navigator.clipboard.writeText(text).then(() => {
                    const originalHTML = copyBtn.innerHTML;
                    copyBtn.innerHTML = '<i data-feather="check" class="w-3 h-3 text-success"></i>';
                    if (window.feather) feather.replace();
                    setTimeout(() => {
                        copyBtn.innerHTML = originalHTML;
                        if (window.feather) feather.replace();
                    }, 2000);
                });
            });

            header.appendChild(langLabel);
            header.appendChild(copyBtn);
            pre.appendChild(header);
        }

        if (window.feather) feather.replace();
    });
})();
