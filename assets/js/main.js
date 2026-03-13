/**
 * Main JavaScript file for Plan Andino Shop theme
 * Handles general functionality and interactions
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    // Initialize all components
    initMobileMenu();
    initSearchOverlay();
    initStickyHeader();
    initBackToTop();
    initProductGallery();
    initQuantityButtons();
    initTooltips();
    initSmoothScroll();
    
    // Mobile Menu Functionality
    function initMobileMenu() {
        const menuToggle = document.querySelector('.mobile-menu-toggle');
        const navigation = document.querySelector('.main-navigation');
        const overlay = document.querySelector('.mobile-menu-overlay');
        
        // Create mobile menu elements if they don't exist
        if (!menuToggle && window.innerWidth <= 768) {
            createMobileMenuElements();
        }
        
        // Toggle menu
        if (menuToggle) {
            menuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                toggleMobileMenu();
            });
        }
        
        // Close menu when clicking overlay
        if (overlay) {
            overlay.addEventListener('click', function() {
                closeMobileMenu();
            });
        }
        
        // Close menu on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeMobileMenu();
            }
        });
        
        // Close menu when clicking menu links
        const menuLinks = document.querySelectorAll('.main-navigation .menu a');
        menuLinks.forEach(link => {
            link.addEventListener('click', function() {
                closeMobileMenu();
            });
        });
    }
    
    function createMobileMenuElements() {
        // Create mobile menu toggle button
        const header = document.querySelector('.site-header .container');
        const menuToggle = document.createElement('button');
        menuToggle.className = 'mobile-menu-toggle';
        menuToggle.innerHTML = '<span></span><span></span><span></span>';
        menuToggle.setAttribute('aria-label', 'Toggle navigation menu');
        
        // Create overlay
        const overlay = document.createElement('div');
        overlay.className = 'mobile-menu-overlay';
        
        // Insert elements
        header.appendChild(menuToggle);
        document.body.appendChild(overlay);
        
        // Re-initialize with new elements
        initMobileMenu();
    }
    
    function toggleMobileMenu() {
        const menuToggle = document.querySelector('.mobile-menu-toggle');
        const navigation = document.querySelector('.main-navigation');
        const overlay = document.querySelector('.mobile-menu-overlay');
        
        if (navigation.classList.contains('active')) {
            closeMobileMenu();
        } else {
            openMobileMenu();
        }
    }
    
    function openMobileMenu() {
        const menuToggle = document.querySelector('.mobile-menu-toggle');
        const navigation = document.querySelector('.main-navigation');
        const overlay = document.querySelector('.mobile-menu-overlay');
        
        menuToggle?.classList.add('active');
        navigation?.classList.add('active');
        overlay?.classList.add('active');
        document.body.classList.add('mobile-menu-open');
    }
    
    function closeMobileMenu() {
        const menuToggle = document.querySelector('.mobile-menu-toggle');
        const navigation = document.querySelector('.main-navigation');
        const overlay = document.querySelector('.mobile-menu-overlay');
        
        menuToggle?.classList.remove('active');
        navigation?.classList.remove('active');
        overlay?.classList.remove('active');
        document.body.classList.remove('mobile-menu-open');
    }
    
    // Search Overlay Functionality
    function initSearchOverlay() {
        const searchIcon = document.querySelector('.search-icon');
        let searchOverlay = document.querySelector('.search-overlay');
        
        // Create search overlay if it doesn't exist
        if (!searchOverlay) {
            searchOverlay = createSearchOverlay();
        }
        
        if (searchIcon && searchOverlay) {
            searchIcon.addEventListener('click', function(e) {
                e.preventDefault();
                openSearchOverlay();
            });
        }
        
        // Close search overlay
        const closeSearchBtn = searchOverlay?.querySelector('.close-search');
        if (closeSearchBtn) {
            closeSearchBtn.addEventListener('click', function() {
                closeSearchOverlay();
            });
        }
        
        // Close on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && searchOverlay?.classList.contains('active')) {
                closeSearchOverlay();
            }
        });
        
        // Close when clicking outside
        searchOverlay?.addEventListener('click', function(e) {
            if (e.target === searchOverlay) {
                closeSearchOverlay();
            }
        });
    }
    
    function createSearchOverlay() {
        const overlay = document.createElement('div');
        overlay.className = 'search-overlay';
        overlay.innerHTML = `
            <div class="search-container">
                <button class="close-search">&times;</button>
                <form role="search" method="get" class="search-form" action="${window.location.origin}">
                    <input type="search" class="search-field" placeholder="Buscar productos..." value="" name="s" />
                    <input type="hidden" name="post_type" value="product" />
                    <button type="submit" class="search-submit">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
            </div>
        `;
        
        document.body.appendChild(overlay);
        return overlay;
    }
    
    function openSearchOverlay() {
        const searchOverlay = document.querySelector('.search-overlay');
        const searchField = searchOverlay?.querySelector('.search-field');
        
        searchOverlay?.classList.add('active');
        document.body.classList.add('search-overlay-open');
        
        // Focus on search input
        setTimeout(() => {
            searchField?.focus();
        }, 300);
    }
    
    function closeSearchOverlay() {
        const searchOverlay = document.querySelector('.search-overlay');
        
        searchOverlay?.classList.remove('active');
        document.body.classList.remove('search-overlay-open');
    }
    
    // Sticky Header Functionality
    function initStickyHeader() {
        const header = document.querySelector('.site-header');
        if (!header) return;
        
        let lastScrollTop = 0;
        let headerHeight = header.offsetHeight;
        
        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            // Add/remove sticky class
            if (scrollTop > headerHeight) {
                header.classList.add('sticky');
            } else {
                header.classList.remove('sticky');
            }
            
            // Hide/show header on scroll (optional)
            if (scrollTop > lastScrollTop && scrollTop > headerHeight) {
                header.classList.add('header-hidden');
            } else {
                header.classList.remove('header-hidden');
            }
            
            lastScrollTop = scrollTop;
        });
    }
    
    // Back to Top Button
    function initBackToTop() {
        // Create back to top button
        const backToTop = document.createElement('button');
        backToTop.className = 'back-to-top';
        backToTop.innerHTML = '<i class="fa fa-arrow-up"></i>';
        backToTop.setAttribute('aria-label', 'Back to top');
        
        document.body.appendChild(backToTop);
        
        // Show/hide based on scroll position
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        });
        
        // Scroll to top when clicked
        backToTop.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
    
    // Product Gallery (for single product pages)
    function initProductGallery() {
        const galleryThumbs = document.querySelectorAll('.flex-control-thumbs img');
        const mainImage = document.querySelector('.woocommerce-product-gallery__image img');
        
        galleryThumbs.forEach(thumb => {
            thumb.addEventListener('click', function() {
                const newSrc = this.getAttribute('data-large') || this.src;
                if (mainImage) {
                    mainImage.src = newSrc;
                    
                    // Remove active class from all thumbs
                    galleryThumbs.forEach(t => t.parentElement.classList.remove('active'));
                    // Add active class to clicked thumb
                    this.parentElement.classList.add('active');
                }
            });
        });
    }
    
    // Quantity Buttons for Product Pages
    function initQuantityButtons() {
        const quantityInputs = document.querySelectorAll('.quantity input[type="number"]');
        
        quantityInputs.forEach(input => {
            const wrapper = input.parentElement;
            
            // Create increase/decrease buttons if they don't exist
            if (!wrapper.querySelector('.qty-btn')) {
                const decreaseBtn = document.createElement('button');
                decreaseBtn.type = 'button';
                decreaseBtn.className = 'qty-btn qty-decrease';
                decreaseBtn.innerHTML = '-';
                
                const increaseBtn = document.createElement('button');
                increaseBtn.type = 'button';
                increaseBtn.className = 'qty-btn qty-increase';
                increaseBtn.innerHTML = '+';
                
                wrapper.insertBefore(decreaseBtn, input);
                wrapper.appendChild(increaseBtn);
                
                // Add event listeners
                decreaseBtn.addEventListener('click', function() {
                    let value = parseInt(input.value) || 1;
                    if (value > 1) {
                        input.value = value - 1;
                        input.dispatchEvent(new Event('change'));
                    }
                });
                
                increaseBtn.addEventListener('click', function() {
                    let value = parseInt(input.value) || 1;
                    input.value = value + 1;
                    input.dispatchEvent(new Event('change'));
                });
            }
        });
    }
    
    // Tooltips
    function initTooltips() {
        const tooltipElements = document.querySelectorAll('[data-tooltip]');
        
        tooltipElements.forEach(element => {
            element.addEventListener('mouseenter', function() {
                const tooltip = document.createElement('div');
                tooltip.className = 'tooltip';
                tooltip.textContent = this.getAttribute('data-tooltip');
                
                document.body.appendChild(tooltip);
                
                const rect = this.getBoundingClientRect();
                tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
                tooltip.style.top = rect.top - tooltip.offsetHeight - 10 + 'px';
                
                setTimeout(() => tooltip.classList.add('visible'), 10);
            });
            
            element.addEventListener('mouseleave', function() {
                const tooltip = document.querySelector('.tooltip');
                if (tooltip) {
                    tooltip.remove();
                }
            });
        });
    }
    
    // Smooth Scroll for Anchor Links
    function initSmoothScroll() {
        const anchorLinks = document.querySelectorAll('a[href^="#"]');
        
        anchorLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href === '#') return;
                
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    const headerHeight = document.querySelector('.site-header')?.offsetHeight || 0;
                    const targetPosition = target.offsetTop - headerHeight - 20;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }
    
    // Window resize handler
    window.addEventListener('resize', function() {
        // Close mobile menu if screen becomes larger
        if (window.innerWidth > 768) {
            closeMobileMenu();
        }
        
        // Recreate mobile menu elements if needed
        if (window.innerWidth <= 768 && !document.querySelector('.mobile-menu-toggle')) {
            createMobileMenuElements();
        }
    });
    
    // Add loading class when page starts loading
    window.addEventListener('beforeunload', function() {
        document.body.classList.add('loading');
    });
    
    // Remove loading class when page is fully loaded
    window.addEventListener('load', function() {
        document.body.classList.remove('loading');
        document.body.classList.add('loaded');
    });
    
    // Utility function for detecting touch devices
    function isTouchDevice() {
        return 'ontouchstart' in window || navigator.maxTouchPoints > 0 || navigator.msMaxTouchPoints > 0;
    }
    
    // Add touch class to body if touch device
    if (isTouchDevice()) {
        document.body.classList.add('touch-device');
    }
    
    // Performance: Add passive event listeners where possible
    const passiveEventOptions = { passive: true };
    
    // Throttle function for scroll events
    function throttle(func, wait) {
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
    
    // Apply throttling to scroll events
    const throttledScroll = throttle(function() {
        // Custom scroll events here
    }, 16); // ~60fps
    
    window.addEventListener('scroll', throttledScroll, passiveEventOptions);
});