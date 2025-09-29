class SillyGooseTheme {
    constructor() {
        this.isInitialized = false;
        this.bindMethods();
        this.init();
    }

    bindMethods() {
        this.handleMenuToggle = this.handleMenuToggle.bind(this);
        this.handleSmoothScroll = this.handleSmoothScroll.bind(this);
        this.handleKeyboardNavigation = this.handleKeyboardNavigation.bind(this);
        this.handleResize = this.debounce(this.handleResize.bind(this), 250);
    }

    init() {
        if (this.isInitialized) return;

        try {
            this.setupMobileMenu();
            this.setupSmoothScrolling();
            this.setupLazyLoading();
            this.setupIntersectionObserver();
            this.setupKeyboardNavigation();
            this.setupEventListeners();
            this.isInitialized = true;
        } catch (error) {
            console.error('Error initializing theme:', error);
        }
    }

    setupMobileMenu() {
        const toggle = document.querySelector('.menu-toggle');
        const nav = document.querySelector('.main-navigation');

        if (!toggle || !nav) return;

        toggle.setAttribute('aria-expanded', 'false');
        toggle.setAttribute('aria-controls', 'primary-menu');
        toggle.addEventListener('click', this.handleMenuToggle);

        document.addEventListener('click', (e) => {
            if (!toggle.contains(e.target) && !nav.contains(e.target)) this.closeMenu();
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && nav.classList.contains('toggled')) {
                this.closeMenu();
                toggle.focus();
            }
        });
    }

    handleMenuToggle(e) {
        e.preventDefault();
        const nav = document.querySelector('.main-navigation');
        nav.classList.contains('toggled') ? this.closeMenu() : this.openMenu();
    }

    openMenu() {
        const toggle = document.querySelector('.menu-toggle');
        const nav = document.querySelector('.main-navigation');

        nav.classList.add('toggled');
        toggle.setAttribute('aria-expanded', 'true');

        const firstMenuItem = nav.querySelector('a');
        if (firstMenuItem) setTimeout(() => firstMenuItem.focus(), 100);
    }

    closeMenu() {
        const toggle = document.querySelector('.menu-toggle');
        const nav = document.querySelector('.main-navigation');

        nav.classList.remove('toggled');
        toggle.setAttribute('aria-expanded', 'false');
    }

    setupSmoothScrolling() {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

        const anchorLinks = document.querySelectorAll('a[href^="#"]:not([href="#"])');
        anchorLinks.forEach(link => link.addEventListener('click', this.handleSmoothScroll));
    }

    handleSmoothScroll(e) {
        const href = e.currentTarget.getAttribute('href');
        const target = document.querySelector(href);

        if (!target) return;

        e.preventDefault();

        const header = document.querySelector('.site-header');
        const headerHeight = header ? header.offsetHeight : 0;
        const targetPosition = target.offsetTop - headerHeight - 20;

        window.scrollTo({top: targetPosition, behavior: 'smooth'});

        if (history.pushState) history.pushState(null, null, href);

        target.setAttribute('tabindex', '-1');
        target.focus();
    }

    setupLazyLoading() {
        if ('loading' in HTMLImageElement.prototype) {
            const images = document.querySelectorAll('img:not([loading])');
            images.forEach(img => {
                if (!img.hasAttribute('loading')) img.setAttribute('loading', 'lazy');
            });
            return;
        }

        const images = document.querySelectorAll('img[data-src]');
        if (images.length === 0) return;

        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.classList.add('lazy-loading');
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    img.onload = () => {
                        img.classList.remove('lazy-loading');
                        img.classList.add('lazy-loaded');
                    };
                    observer.unobserve(img);
                }
            });
        }, {rootMargin: '50px 0px', threshold: 0.01});

        images.forEach(img => imageObserver.observe(img));
    }

    setupIntersectionObserver() {
        const animatedElements = document.querySelectorAll('.fade-in, .slide-up, .card');
        if (animatedElements.length === 0) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('is-visible');
            });
        }, {rootMargin: '0px 0px -100px 0px', threshold: 0.1});

        animatedElements.forEach(el => observer.observe(el));
    }

    setupKeyboardNavigation() {
        document.addEventListener('keydown', this.handleKeyboardNavigation);
        document.addEventListener('mousedown', () => document.body.classList.add('using-mouse'));
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Tab') document.body.classList.remove('using-mouse');
        });
    }

    handleKeyboardNavigation(e) {
        if (e.target.closest('.main-navigation')) {
            const menuItems = Array.from(document.querySelectorAll('.main-navigation a'));
            const currentIndex = menuItems.indexOf(e.target);

            switch (e.key) {
                case 'ArrowDown':
                    e.preventDefault();
                    menuItems[(currentIndex + 1) % menuItems.length].focus();
                    break;
                case 'ArrowUp':
                    e.preventDefault();
                    menuItems[currentIndex === 0 ? menuItems.length - 1 : currentIndex - 1].focus();
                    break;
                case 'Home':
                    e.preventDefault();
                    menuItems[0].focus();
                    break;
                case 'End':
                    e.preventDefault();
                    menuItems[menuItems.length - 1].focus();
                    break;
            }
        }
    }

    setupEventListeners() {
        window.addEventListener('resize', this.handleResize);
        window.addEventListener('scroll', this.debounce(this.handleScroll.bind(this), 10));

        document.addEventListener('visibilitychange', () => {
            document.hidden ? this.pauseAnimations() : this.resumeAnimations();
        });
    }

    handleResize() {
        if (window.innerWidth > 768) this.closeMenu();
        this.updateLayoutCalculations();
    }

    handleScroll() {
        const header = document.querySelector('.site-header');
        if (header) {
            window.scrollY > 100 ? header.classList.add('scrolled') : header.classList.remove('scrolled');
        }
    }

    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }

    pauseAnimations() {
        document.body.classList.add('animations-paused');
    }

    resumeAnimations() {
        document.body.classList.remove('animations-paused');
    }

    updateLayoutCalculations() {
        const heroElements = document.querySelectorAll('.hero, .sg-hero-block');
        heroElements.forEach(hero => {
            if (hero.hasAttribute('data-min-height')) {
                const minHeight = hero.getAttribute('data-min-height');
                hero.style.minHeight = `${Math.max(window.innerHeight * 0.7, parseInt(minHeight))}px`;
            }
        });
    }

    scrollToElement(selector, offset = 0) {
        const element = document.querySelector(selector);
        if (!element) return;

        const header = document.querySelector('.site-header');
        const headerHeight = header ? header.offsetHeight : 0;
        const targetPosition = element.offsetTop - headerHeight - offset;

        window.scrollTo({top: targetPosition, behavior: 'smooth'});
    }

    toggleMenu() {
        const nav = document.querySelector('.main-navigation');
        nav.classList.contains('toggled') ? this.closeMenu() : this.openMenu();
    }
}

window.SillyGoose = {
    scrollTo: function(selector, offset = 0) {
        if (window.sillyGooseTheme) window.sillyGooseTheme.scrollToElement(selector, offset);
    },
    toggleMenu: function() {
        if (window.sillyGooseTheme) window.sillyGooseTheme.toggleMenu();
    }
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.sillyGooseTheme = new SillyGooseTheme();
    });
} else {
    window.sillyGooseTheme = new SillyGooseTheme();
}

if (typeof module !== 'undefined' && module.hot) module.hot.accept();