/**
 * Code Block Enhancements: Syntax Highlighting with Shiki and Copy to Clipboard
 */
(function() {
    document.addEventListener('DOMContentLoaded', async () => {
        const codeBlocks = document.querySelectorAll('pre code');
        if (codeBlocks.length === 0) return;

        // Function to wait for shiki to be loaded
        const waitForShiki = () => {
            return new Promise((resolve) => {
                const check = () => {
                    if (window.shiki && window.shiki.codeToHtml) {
                        resolve(window.shiki);
                    } else {
                        setTimeout(check, 100);
                    }
                };
                check();
            });
        };

        const shikiObj = await waitForShiki();
        const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
        // Map common DaisyUI themes to Shiki themes
        const shikiTheme = (currentTheme === 'dark' || currentTheme === 'dracula' || currentTheme === 'black' || currentTheme === 'luxury' || currentTheme === 'night') ? 'github-dark' : 'github-light';

        for (const block of codeBlocks) {
            const pre = block.parentElement;

            // Container for relative positioning
            pre.classList.add('relative', 'group', 'mt-6', 'mb-6');

            // Detect Language
            let lang = 'text';
            const classes = Array.from(block.classList);
            const langClass = classes.find(c => c.startsWith('language-'));
            if (langClass) {
                lang = langClass.replace('language-', '');
            }

            // Apply Shiki Highlighting
            try {
                const code = block.innerText;
                const highlighted = await shikiObj.codeToHtml(code, {
                    lang: lang,
                    theme: shikiTheme
                });

                // Create a temporary container to parse the HTML
                const temp = document.createElement('div');
                temp.innerHTML = highlighted;
                const newPre = temp.querySelector('pre');

                if (newPre) {
                    // Transfer the highlighted content back
                    block.innerHTML = newPre.querySelector('code').innerHTML;
                }
            } catch (e) {
                console.error('Shiki highlighting failed:', e);
            }

            // Create Header Bar
            const header = document.createElement('div');
            header.className = 'absolute right-4 top-4 flex items-center gap-3 z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-200';

            // Language Label
            const langLabel = document.createElement('span');
            langLabel.className = 'text-[10px] font-bold tracking-widest opacity-40 uppercase';
            langLabel.innerText = lang;

            // Copy Button
            const copyBtn = document.createElement('button');
            copyBtn.className = 'btn btn-xs btn-ghost btn-square opacity-50 hover:opacity-100 hover:bg-base-content/10';
            copyBtn.innerHTML = '<i data-feather="copy" class="w-3 h-3"></i>';
            copyBtn.title = 'Copy Code';

            copyBtn.addEventListener('click', () => {
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
