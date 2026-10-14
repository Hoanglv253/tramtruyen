document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.querySelector('.menu-toggle');
    const nav = document.querySelector('.main-nav');
    toggle?.addEventListener('click', () => {
        const open = toggle.getAttribute('aria-expanded') === 'true';
        toggle.setAttribute('aria-expanded', String(!open));
        nav?.classList.toggle('nav-open', !open);
    });

    const body = document.querySelector('[data-chapter-body]');
    if (!body) return;
    let size = Number(localStorage.getItem('tram-truyen-font-size')) || 19;
    const applySize = () => { body.style.fontSize = `${size}px`; };
    applySize();
    document.querySelector('[data-font="up"]')?.addEventListener('click', () => {
        size = Math.min(26, size + 1);
        localStorage.setItem('tram-truyen-font-size', String(size));
        applySize();
    });
    document.querySelector('[data-font="down"]')?.addEventListener('click', () => {
        size = Math.max(16, size - 1);
        localStorage.setItem('tram-truyen-font-size', String(size));
        applySize();
    });
    document.querySelector('[data-theme]')?.addEventListener('click', () => {
        document.body.classList.toggle('reading-dark');
        localStorage.setItem('tram-truyen-reading-dark', document.body.classList.contains('reading-dark') ? '1' : '0');
    });
    if (localStorage.getItem('tram-truyen-reading-dark') === '1') document.body.classList.add('reading-dark');
});
