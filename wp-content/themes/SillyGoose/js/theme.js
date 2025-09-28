/**
 * Silly Goose Theme JavaScript
 * Optimized for performance and user experience
 */

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
            console.log('🦆 Silly Goose theme initialized successfully');
        } catch (error) {
            console.error('Error initializing Silly Goose theme:', error);
        }
    }
    
    /**
     * Mobile menu functionality
     */
    setupMobileMenu() {
        const toggle = document.querySelector('.menu-toggle');
        const nav = document.querySelector('.main-navigation');
        
        if (!toggle || !nav) return;
        
        // Set initial ARIA attributes
        toggle.setAttribute('aria-expanded', 'false');
        toggle.setAttribute('aria-controls', 'primary-menu');
        
        // Add event listener
        toggle.addEventListener('click', this.handleMenuToggle);
        
        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!toggle.contains(e.target) && !nav.contains(e.target)) {
                this.closeMenu();
            }
        });
        
        // Close menu on escape key
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
        const isOpen = nav.classList.contains('toggled');
        
        if (isOpen) {
            this.closeMenu();
        } else {
            this.openMenu();
        }
    }
    
    openMenu() {
        const toggle = document.querySelector('.menu-toggle');
        const nav = document.querySelector('.main-navigation');
        
        nav.classList.add('toggled');
        toggle.setAttribute('aria-expanded', 'true');
        
        // Focus first menu item
        const firstMenuItem = nav.querySelector('a');
        if (firstMenuItem) {
            setTimeout(() => firstMenuItem.focus(), 100);
        }
    }
    
    closeMenu() {
        const toggle = document.querySelector('.menu-toggle');
        const nav = document.querySelector('.main-navigation');
        
        nav.classList.remove('toggled');
        toggle.setAttribute('aria-expanded', 'false');
    }
    
    /**
     * Smooth scrolling for anchor links
     */
    setupSmoothScrolling() {
        // Only add smooth scrolling if user hasn't set reduced motion preference
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            return;
        }
        
        const anchorLinks = document.querySelectorAll('a[href^="#"]:not([href="#"])');
        anchorLinks.forEach(link => {
            link.addEventListener('click', this.handleSmoothScroll);
        });
    }
    
    handleSmoothScroll(e) {
        const href = e.currentTarget.getAttribute('href');
        const target = document.querySelector(href);
        
        if (!target) return;
        
        e.preventDefault();
        
        // Calculate offset for fixed header
        const header = document.querySelector('.site-header');
        const headerHeight = header ? header.offsetHeight : 0;
        const targetPosition = target.offsetTop - headerHeight - 20;
        
        window.scrollTo({
            top: targetPosition,
            behavior: 'smooth'
        });
        
        // Update URL without triggering scroll
        if (history.pushState) {
            history.pushState(null, null, href);
        }
        
        // Focus target for accessibility
        target.setAttribute('tabindex', '-1');
        target.focus();
    }
    
    /**
     * Lazy loading for images (fallback for older browsers)
     */
    setupLazyLoading() {
        // Check if browser supports native lazy loading
        if ('loading' in HTMLImageElement.prototype) {
            // Add loading="lazy" to images that don't have it
            const images = document.querySelectorAll('img:not([loading])');
            images.forEach(img => {
                if (!img.hasAttribute('loading')) {
                    img.setAttribute('loading', 'lazy');
                }
            });
            return;
        }
        
        // Fallback for older browsers
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
        }, {
            rootMargin: '50px 0px',
            threshold: 0.01
        });
        
        images.forEach(img => imageObserver.observe(img));
    }
    
    /**
     * Intersection Observer for animations and effects
     */
    setupIntersectionObserver() {
        const animatedElements = document.querySelectorAll('.fade-in, .slide-up, .card');
        if (animatedElements.length === 0) return;
        
        const observerOptions = {
            rootMargin: '0px 0px -100px 0px',
            threshold: 0.1
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                }
            });
        }, observerOptions);
        
        animatedElements.forEach(el => observer.observe(el));
    }
    
    /**
     * Keyboard navigation improvements
     */
    setupKeyboardNavigation() {
        document.addEventListener('keydown', this.handleKeyboardNavigation);
        
        // Add focus-visible polyfill behavior
        document.addEventListener('mousedown', () => {
            document.body.classList.add('using-mouse');
        });
        
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Tab') {
                document.body.classList.remove('using-mouse');
            }
        });
    }
    
    handleKeyboardNavigation(e) {
        // Enhanced keyboard navigation for menus
        if (e.target.closest('.main-navigation')) {
            const menuItems = Array.from(document.querySelectorAll('.main-navigation a'));
            const currentIndex = menuItems.indexOf(e.target);
            
            switch (e.key) {
                case 'ArrowDown':
                    e.preventDefault();
                    const nextIndex = (currentIndex + 1) % menuItems.length;
                    menuItems[nextIndex].focus();
                    break;
                    
                case 'ArrowUp':
                    e.preventDefault();
                    const prevIndex = currentIndex === 0 ? menuItems.length - 1 : currentIndex - 1;
                    menuItems[prevIndex].focus();
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
    
    /**
     * Event listeners for window events
     */
    setupEventListeners() {
        window.addEventListener('resize', this.handleResize);
        window.addEventListener('scroll', this.debounce(this.handleScroll.bind(this), 10));
        
        // Handle page visibility changes
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                // Pause any animations or heavy processing
                this.pauseAnimations();
            } else {
                // Resume animations
                this.resumeAnimations();
            }
        });
    }
    
    handleResize() {
        // Close mobile menu on resize to desktop
        if (window.innerWidth > 768) {
            this.closeMenu();
        }
        
        // Recalculate any layout-dependent features
        this.updateLayoutCalculations();
    }
    
    handleScroll() {
        // Add scroll-based effects here
        const header = document.querySelector('.site-header');
        if (header) {
            if (window.scrollY > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        }
    }
    
    /**
     * Performance utilities
     */
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
    
    /**
     * Animation control
     */
    pauseAnimations() {
        document.body.classList.add('animations-paused');
    }
    
    resumeAnimations() {
        document.body.classList.remove('animations-paused');
    }
    
    /**
     * Layout calculations
     */
    updateLayoutCalculations() {
        // Update any elements that depend on window size
        const heroElements = document.querySelectorAll('.hero, .sg-hero-block');
        heroElements.forEach(hero => {
            // Recalculate hero height if needed
            if (hero.hasAttribute('data-min-height')) {
                const minHeight = hero.getAttribute('data-min-height');
                hero.style.minHeight = `${Math.max(window.innerHeight * 0.7, parseInt(minHeight))}px`;
            }
        });
    }
    
    /**
     * Public API methods
     */
    openMenu() {
        this.openMenu();
    }
    
    closeMenu() {
        this.closeMenu();
    }
    
    toggleMenu() {
        const nav = document.querySelector('.main-navigation');
        if (nav.classList.contains('toggled')) {
            this.closeMenu();
        } else {
            this.openMenu();
        }
    }
    
    /**
     * Utility methods for external use
     */
    scrollToElement(selector, offset = 0) {
        const element = document.querySelector(selector);
        if (!element) return;
        
        const header = document.querySelector('.site-header');
        const headerHeight = header ? header.offsetHeight : 0;
        const targetPosition = element.offsetTop - headerHeight - offset;
        
        window.scrollTo({
            top: targetPosition,
            behavior: 'smooth'
        });
    }
    
    /**
     * Form enhancements
     */
    setupFormEnhancements() {
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            // Add loading states to submit buttons
            form.addEventListener('submit', (e) => {
                const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
                if (submitBtn) {
                    submitBtn.classList.add('loading');
                    submitBtn.disabled = true;
                }
            });
            
            // Enhance form validation
            const inputs = form.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                input.addEventListener('blur', () => {
                    if (input.value.trim() !== '') {
                        input.classList.add('has-content');
                    } else {
                        input.classList.remove('has-content');
                    }
                });
            });
        });
    }
}

/**
 * Global utility functions
 */
window.SillyGoose = {
    scrollTo: function(selector, offset = 0) {
        if (window.sillyGooseTheme) {
            window.sillyGooseTheme.scrollToElement(selector, offset);
        }
    },
    
    toggleMenu: function() {
        if (window.sillyGooseTheme) {
            window.sillyGooseTheme.toggleMenu();
        }
    }
};

/**
 * Initialize theme when DOM is ready
 */
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.sillyGooseTheme = new SillyGooseTheme();
    });
} else {
    // DOM is already ready
    window.sillyGooseTheme = new SillyGooseTheme();
}

/**
 * Handle theme updates/hot reloading in development
 */
if (typeof module !== 'undefined' && module.hot) {
    module.hot.accept();
}