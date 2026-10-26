(() => {
    const focusableSelector = 'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])';

    const initializeFieldLabels = () => {
        let sequence = 0;

        document.querySelectorAll('label:not([for])').forEach((label) => {
            const nestedControl = label.querySelector('input, select, textarea');
            const siblingControl = label.parentElement?.querySelector(':scope > input, :scope > select, :scope > textarea');
            const control = nestedControl || siblingControl;

            if (!control || control.type === 'hidden') {
                return;
            }

            if (!control.id) {
                sequence += 1;
                control.id = `sigap-field-${sequence}`;
            }

            if (!nestedControl) {
                label.htmlFor = control.id;
            }
        });
    };

    const initializeTableRegions = () => {
        document.querySelectorAll('main table').forEach((table, index) => {
            table.querySelectorAll('thead th').forEach((heading) => heading.setAttribute('scope', 'col'));

            if (table.parentElement?.classList.contains('sigap-table-scroll')) {
                return;
            }

            const wrapper = document.createElement('div');
            const nearbyHeading = table.closest('section, article, div')?.querySelector('h2, h3');
            const label = nearbyHeading?.textContent?.trim() || `Tabel data ${index + 1}`;

            wrapper.className = 'sigap-table-scroll';
            wrapper.setAttribute('role', 'region');
            wrapper.setAttribute('aria-label', label);
            wrapper.tabIndex = 0;

            table.parentNode.insertBefore(wrapper, table);
            wrapper.appendChild(table);
        });
    };

    const isVisible = (element) => window.getComputedStyle(element).display !== 'none';

    const initializeDialogs = () => {
        document.querySelectorAll('[x-show][class*="fixed"][class*="inset-0"]').forEach((overlay, index) => {
            const panel = overlay.querySelector(':scope > div, :scope > section');
            const heading = panel?.querySelector('h2, h3');

            if (!panel || !heading || panel.id === 'document-preview-dialog') {
                return;
            }

            const headingId = heading.id || `sigap-dialog-title-${index + 1}`;
            heading.id = headingId;
            panel.setAttribute('role', 'dialog');
            panel.setAttribute('aria-modal', 'true');
            panel.setAttribute('aria-labelledby', headingId);
            panel.classList.add('sigap-dialog-panel');

            const closeButton = panel.querySelector('button:has(svg)');
            if (closeButton && !closeButton.getAttribute('aria-label')) {
                closeButton.setAttribute('aria-label', 'Tutup dialog');
            }

            let wasVisible = isVisible(overlay);
            let returnFocus = null;

            const synchronizeFocus = () => {
                const visible = isVisible(overlay);

                if (visible && !wasVisible) {
                    returnFocus = document.activeElement;
                    requestAnimationFrame(() => panel.querySelector(focusableSelector)?.focus());
                }

                if (!visible && wasVisible) {
                    returnFocus?.focus?.();
                }

                wasVisible = visible;
            };

            new MutationObserver(synchronizeFocus).observe(overlay, { attributes: true, attributeFilter: ['style', 'class'] });

            overlay.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && isVisible(overlay)) {
                    event.preventDefault();
                    closeButton?.click();
                    return;
                }

                if (event.key !== 'Tab') {
                    return;
                }

                const focusable = [...panel.querySelectorAll(focusableSelector)].filter((element) => !element.disabled);
                if (!focusable.length) {
                    return;
                }

                const first = focusable[0];
                const last = focusable[focusable.length - 1];
                if (event.shiftKey && document.activeElement === first) {
                    event.preventDefault();
                    last.focus();
                } else if (!event.shiftKey && document.activeElement === last) {
                    event.preventDefault();
                    first.focus();
                }
            });
        });
    };

    const initializeTabs = () => {
        document.querySelectorAll('[role="tablist"]').forEach((tabList) => {
            const tabs = [...tabList.querySelectorAll('[role="tab"]')];

            tabs.forEach((tab, index) => {
                tab.tabIndex = tab.getAttribute('aria-selected') === 'true' ? 0 : -1;
                tab.addEventListener('click', () => {
                    tabs.forEach((item) => { item.tabIndex = item === tab ? 0 : -1; });
                });
                tab.addEventListener('keydown', (event) => {
                    let targetIndex = null;
                    if (event.key === 'ArrowRight') targetIndex = (index + 1) % tabs.length;
                    if (event.key === 'ArrowLeft') targetIndex = (index - 1 + tabs.length) % tabs.length;
                    if (event.key === 'Home') targetIndex = 0;
                    if (event.key === 'End') targetIndex = tabs.length - 1;
                    if (targetIndex === null) return;
                    event.preventDefault();
                    tabs[targetIndex].focus();
                    tabs[targetIndex].click();
                });
            });
        });
    };

    const initializeIconButtons = () => {
        document.querySelectorAll('button').forEach((button) => {
            const hasText = button.textContent.trim().length > 0;
            const title = button.getAttribute('title');

            if (!hasText && title && !button.getAttribute('aria-label')) {
                button.setAttribute('aria-label', title);
            }
        });
    };

    document.addEventListener('DOMContentLoaded', () => {
        initializeFieldLabels();
        initializeTableRegions();
        initializeDialogs();
        initializeTabs();
        initializeIconButtons();
    });
})();
