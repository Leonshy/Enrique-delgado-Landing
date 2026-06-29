import './bootstrap';
import Alpine from 'alpinejs';
window.Alpine = Alpine;

/* ── Navbar: transparent → scrolled ── */
function initNavbar() {
    const nav      = document.getElementById('navbar');
    const logoColor = document.getElementById('logo-color');
    const logoWhite = document.getElementById('logo-white');
    if (!nav) return;

    function update() {
        const scrolled = window.scrollY > 80;
        nav.classList.toggle('scrolled', scrolled);
        nav.classList.toggle('transparent', !scrolled);
        if (logoColor) logoColor.style.display = scrolled ? 'block' : 'none';
        if (logoWhite) logoWhite.style.display = scrolled ? 'none' : 'block';
        // El estilo del botón se maneja en CSS con #navbar.scrolled .nav-cta-btn
    }
    update();
    window.addEventListener('scroll', update, { passive: true });
}

/* ── Mobile menu ── */
function initMobileMenu() {
    const toggle = document.getElementById('nav-hamburger');
    const menu   = document.getElementById('nav-mobile');
    if (!toggle || !menu) return;
    toggle.addEventListener('click', () => menu.classList.toggle('open'));
    menu.querySelectorAll('a').forEach(a => a.addEventListener('click', () => menu.classList.remove('open')));
}

/* ── Scroll Reveal ── */
function initReveal() {
    const els = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale');
    if (!els.length) return;
    const obs = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); }
        });
    }, { threshold: 0.12 });
    els.forEach(el => obs.observe(el));
}

/* ── Animated Counters ── */
function initCounters() {
    const counters = document.querySelectorAll('[data-counter]');
    if (!counters.length) return;
    const obs = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (!e.isIntersecting) return;
            const el = e.target;
            const target   = parseInt(el.dataset.counter, 10);
            const suffix   = el.dataset.suffix || '';
            const duration = 2000;
            const start    = performance.now();
            function tick(now) {
                const p = Math.min((now - start) / duration, 1);
                const v = 1 - Math.pow(1 - p, 3);
                el.textContent = Math.floor(v * target) + suffix;
                if (p < 1) requestAnimationFrame(tick);
            }
            requestAnimationFrame(tick);
            obs.unobserve(el);
        });
    }, { threshold: 0.5 });
    counters.forEach(c => obs.observe(c));
}

/* ── Testimonial Slider ── */
function initTestimonialSlider() {
    const items = document.querySelectorAll('.testimonial-item');
    const dots  = document.querySelectorAll('.quote-dot');
    if (!items.length) return;
    let current = 0;

    function show(i) {
        items.forEach((el, idx) => {
            el.style.display  = idx === i ? 'block' : 'none';
            el.style.opacity  = idx === i ? '1'     : '0';
        });
        dots.forEach((d, idx) => d.classList.toggle('active', idx === i));
        current = i;
    }
    dots.forEach((d, i) => d.addEventListener('click', () => show(i)));
    show(0);
    setInterval(() => show((current + 1) % items.length), 5500);
}

/* ── FAQ Accordion ── */
function initFaq() {
    document.querySelectorAll('.faq-question').forEach(btn => {
        btn.addEventListener('click', () => {
            const item   = btn.closest('.faq-item');
            const answer = item.querySelector('.faq-answer');
            const isOpen = item.classList.contains('open');
            document.querySelectorAll('.faq-item').forEach(fi => {
                fi.classList.remove('open');
                fi.querySelector('.faq-answer').classList.remove('open');
            });
            if (!isOpen) {
                item.classList.add('open');
                answer.classList.add('open');
            }
        });
    });
}

/* ── Back to Top ── */
function initBackToTop() {
    const btn = document.getElementById('back-to-top');
    if (!btn) return;
    window.addEventListener('scroll', () => btn.classList.toggle('visible', window.scrollY > 500), { passive: true });
    btn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
}

/* ── Flash Messages ── */
function initFlash() {
    document.querySelectorAll('.flash-message').forEach(el => {
        setTimeout(() => {
            el.style.transition = 'opacity 0.5s, transform 0.5s';
            el.style.opacity    = '0';
            el.style.transform  = 'translateX(20px)';
            setTimeout(() => el.remove(), 500);
        }, 5000);
    });
}

/* ── Smooth Scroll with header offset ── */
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const id = a.getAttribute('href').slice(1);
            if (!id) return;
            const target = document.getElementById(id);
            if (!target) return;
            e.preventDefault();
            const top = target.getBoundingClientRect().top + window.scrollY - 80;
            window.scrollTo({ top, behavior: 'smooth' });
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initNavbar();
    initMobileMenu();
    initReveal();
    initCounters();
    initTestimonialSlider();
    initFaq();
    initBackToTop();
    initFlash();
    initSmoothScroll();
});

Alpine.start();
