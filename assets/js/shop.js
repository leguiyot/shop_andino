/**
 * Shop JavaScript functionality for Plan Andino Shop theme
 * Handles WooCommerce-specific features and shop interactions
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    // Initialize shop components
    initAddToCartButtons();
    initQuickView();
    initProductFilters();
    initCartUpdates();
    initWishlist();
    initProductTabs();
    initStockNotifications();
    initAjaxSearch();
    
    // Add to Cart Button Enhancements
    function initAddToCartButtons() {
        const addToCartButtons = document.querySelectorAll('.add_to_cart_button, .single_add_to_cart_button');
        
        addToCartButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                const originalText = button.textContent;
                
                // Add loading state
                button.classList.add('loading');
                button.disabled = true;
                button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Agregando...';
                
                // Listen for WooCommerce added_to_cart event
                document.body.addEventListener('added_to_cart', function(event) {
                    // Success state
                    button.classList.remove('loading');
                    button.classList.add('added');
                    button.innerHTML = '<i class="fa fa-check"></i> Agregado';
                    
                    // Update cart count in header
                    updateCartCount();
                    
                    // Show success notification
                    showNotification('Producto agregado al carrito', 'success');
                    
                    // Reset button after 3 seconds
                    setTimeout(() => {
                        button.classList.remove('added');
                        button.disabled = false;
                        button.textContent = originalText;
                    }, 3000);
                }, { once: true });
                
                // Handle errors
                setTimeout(() => {
                    if (button.classList.contains('loading')) {
                        button.classList.remove('loading');
                        button.disabled = false;
                        button.textContent = originalText;
                        showNotification('Error al agregar el producto', 'error');
                    }
                }, 10000); // 10 second timeout
            });
        });
    }
    
    // Quick View Modal for Products
    function initQuickView() {
        const quickViewButtons = document.querySelectorAll('.quick-view-button');
        
        quickViewButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const productId = this.dataset.productId;
                
                if (productId) {
                    openQuickViewModal(productId);
                }
            });
        });
    }
    
    function openQuickViewModal(productId) {
        // Create modal if it doesn't exist
        let modal = document.querySelector('.quick-view-modal');
        if (!modal) {
            modal = createQuickViewModal();
        }
        
        // Show loading state
        modal.classList.add('loading');
        modal.classList.add('active');
        document.body.classList.add('modal-open');
        
        // Load product data via AJAX
        fetch(`${wc_add_to_cart_params.wc_ajax_url}get_quick_view_product&product_id=${productId}`)
            .then(response => response.text())
            .then(html => {
                const modalContent = modal.querySelector('.modal-content');
                modalContent.innerHTML = html;
                modal.classList.remove('loading');
                
                // Initialize modal components
                initQuantityButtons();
                initProductGallery();
            })
            .catch(error => {
                console.error('Error loading quick view:', error);
                modal.classList.remove('loading');
                modal.classList.remove('active');
                document.body.classList.remove('modal-open');
                showNotification('Error al cargar el producto', 'error');
            });
    }
    
    function createQuickViewModal() {
        const modal = document.createElement('div');
        modal.className = 'quick-view-modal';
        modal.innerHTML = `
            <div class="modal-overlay"></div>
            <div class="modal-content">
                <button class="close-modal">&times;</button>
                <div class="loading-spinner">
                    <i class="fa fa-spinner fa-spin"></i>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        
        // Close modal events
        const closeButton = modal.querySelector('.close-modal');
        const overlay = modal.querySelector('.modal-overlay');
        
        closeButton.addEventListener('click', () => closeQuickViewModal());
        overlay.addEventListener('click', () => closeQuickViewModal());
        
        // Close on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.classList.contains('active')) {
                closeQuickViewModal();
            }
        });
        
        return modal;
    }
    
    function closeQuickViewModal() {
        const modal = document.querySelector('.quick-view-modal');
        modal?.classList.remove('active');
        document.body.classList.remove('modal-open');
    }
    
    // Product Filters (AJAX)
    function initProductFilters() {
        const filterForms = document.querySelectorAll('.widget_layered_nav form, .widget_price_filter form');
        
        filterForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(form);
                const params = new URLSearchParams(formData);
                const url = new URL(window.location);
                
                // Update URL parameters
                for (const [key, value] of params) {
                    url.searchParams.set(key, value);
                }
                
                // Load filtered products
                loadFilteredProducts(url.toString());
            });
        });
        
        // Handle filter checkboxes
        const filterCheckboxes = document.querySelectorAll('.woocommerce-widget-layered-nav-list input');
        filterCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const form = this.closest('form');
                if (form) {
                    form.dispatchEvent(new Event('submit'));
                }
            });
        });
    }
    
    function loadFilteredProducts(url) {
        const productsContainer = document.querySelector('.products');
        const sidebar = document.querySelector('.shop-sidebar');
        
        // Show loading state
        productsContainer?.classList.add('loading');
        
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            // Update products
            const newProducts = doc.querySelector('.products');
            if (newProducts && productsContainer) {
                productsContainer.innerHTML = newProducts.innerHTML;
            }
            
            // Update sidebar
            const newSidebar = doc.querySelector('.shop-sidebar');
            if (newSidebar && sidebar) {
                sidebar.innerHTML = newSidebar.innerHTML;
            }
            
            // Update URL without page reload
            window.history.pushState({}, '', url);
            
            // Re-initialize components
            initAddToCartButtons();
            initProductFilters();
            
            productsContainer?.classList.remove('loading');
        })
        .catch(error => {
            console.error('Error loading filtered products:', error);
            productsContainer?.classList.remove('loading');
            showNotification('Error al filtrar productos', 'error');
        });
    }
    
    // Cart Updates
    function initCartUpdates() {
        // Listen for cart updates
        document.body.addEventListener('added_to_cart', updateCartCount);
        document.body.addEventListener('removed_from_cart', updateCartCount);
        
        // Update cart on page load
        updateCartCount();
    }
    
    function updateCartCount() {
        if (typeof wc_add_to_cart_params === 'undefined') return;
        
        fetch(`${wc_add_to_cart_params.wc_ajax_url}get_cart_count`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            }
        })
        .then(response => response.json())
        .then(data => {
            const cartCounts = document.querySelectorAll('.cart-count');
            cartCounts.forEach(count => {
                count.textContent = data.count || '0';
                
                if (data.count > 0) {
                    count.classList.add('has-items');
                } else {
                    count.classList.remove('has-items');
                }
            });
        })
        .catch(error => {
            console.error('Error updating cart count:', error);
        });
    }
    
    // Wishlist Functionality
    function initWishlist() {
        const wishlistButtons = document.querySelectorAll('.add-to-wishlist');
        
        wishlistButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                const productId = this.dataset.productId;
                const isAdded = this.classList.contains('added');
                
                if (isAdded) {
                    removeFromWishlist(productId, this);
                } else {
                    addToWishlist(productId, this);
                }
            });
        });
    }
    
    function addToWishlist(productId, button) {
        button.classList.add('loading');
        
        // Store in localStorage for now (replace with server-side implementation)
        let wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
        
        if (!wishlist.includes(productId)) {
            wishlist.push(productId);
            localStorage.setItem('wishlist', JSON.stringify(wishlist));
            
            button.classList.remove('loading');
            button.classList.add('added');
            button.title = 'Remover de lista de deseos';
            
            showNotification('Producto agregado a lista de deseos', 'success');
        }
    }
    
    function removeFromWishlist(productId, button) {
        button.classList.add('loading');
        
        let wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
        wishlist = wishlist.filter(id => id !== productId);
        localStorage.setItem('wishlist', JSON.stringify(wishlist));
        
        button.classList.remove('loading');
        button.classList.remove('added');
        button.title = 'Agregar a lista de deseos';
        
        showNotification('Producto removido de lista de deseos', 'success');
    }
    
    // Product Tabs (for single product pages)
    function initProductTabs() {
        const tabLinks = document.querySelectorAll('.woocommerce-tabs ul.tabs li a');
        const tabPanels = document.querySelectorAll('.woocommerce-tabs .panel');
        
        tabLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                const targetPanel = document.querySelector(targetId);
                
                if (targetPanel) {
                    // Remove active class from all tabs and panels
                    tabLinks.forEach(l => l.parentElement.classList.remove('active'));
                    tabPanels.forEach(p => p.style.display = 'none');
                    
                    // Add active class to clicked tab and show panel
                    this.parentElement.classList.add('active');
                    targetPanel.style.display = 'block';
                }
            });
        });
    }
    
    // Stock Notifications
    function initStockNotifications() {
        const stockElements = document.querySelectorAll('.stock');
        
        stockElements.forEach(element => {
            const stockText = element.textContent.toLowerCase();
            
            if (stockText.includes('agotado') || stockText.includes('out of stock')) {
                element.classList.add('out-of-stock');
                
                // Disable add to cart button
                const addToCartBtn = element.closest('.product')?.querySelector('.add_to_cart_button');
                if (addToCartBtn) {
                    addToCartBtn.disabled = true;
                    addToCartBtn.textContent = 'Agotado';
                    addToCartBtn.classList.add('disabled');
                }
            } else if (stockText.includes('últimas unidades') || stockText.includes('low stock')) {
                element.classList.add('low-stock');
            }
        });
    }
    
    // AJAX Product Search
    function initAjaxSearch() {
        const searchForms = document.querySelectorAll('.search-form');
        
        searchForms.forEach(form => {
            const searchInput = form.querySelector('.search-field');
            let searchTimeout;
            
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    const query = this.value.trim();
                    
                    if (query.length >= 3) {
                        searchTimeout = setTimeout(() => {
                            performAjaxSearch(query, form);
                        }, 300);
                    } else {
                        hideSearchResults(form);
                    }
                });
                
                // Hide results when clicking outside
                document.addEventListener('click', function(e) {
                    if (!form.contains(e.target)) {
                        hideSearchResults(form);
                    }
                });
            }
        });
    }
    
    function performAjaxSearch(query, form) {
        const resultsContainer = getOrCreateSearchResults(form);
        resultsContainer.innerHTML = '<div class="search-loading"><i class="fa fa-spinner fa-spin"></i> Buscando...</div>';
        resultsContainer.style.display = 'block';
        
        fetch(`${window.location.origin}/?s=${encodeURIComponent(query)}&post_type=product&ajax=1`)
            .then(response => response.json())
            .then(data => {
                if (data.products && data.products.length > 0) {
                    let html = '<ul class="ajax-search-results">';
                    data.products.forEach(product => {
                        html += `
                            <li>
                                <a href="${product.url}">
                                    <img src="${product.image}" alt="${product.title}">
                                    <div class="product-details">
                                        <h4>${product.title}</h4>
                                        <span class="price">${product.price}</span>
                                    </div>
                                </a>
                            </li>
                        `;
                    });
                    html += '</ul>';
                    
                    if (data.total > data.products.length) {
                        html += `<div class="view-all"><a href="${window.location.origin}/?s=${encodeURIComponent(query)}&post_type=product">Ver todos los resultados (${data.total})</a></div>`;
                    }
                    
                    resultsContainer.innerHTML = html;
                } else {
                    resultsContainer.innerHTML = '<div class="no-results">No se encontraron productos.</div>';
                }
            })
            .catch(error => {
                console.error('Search error:', error);
                resultsContainer.innerHTML = '<div class="search-error">Error en la búsqueda.</div>';
            });
    }
    
    function getOrCreateSearchResults(form) {
        let results = form.querySelector('.search-results');
        if (!results) {
            results = document.createElement('div');
            results.className = 'search-results';
            form.appendChild(results);
        }
        return results;
    }
    
    function hideSearchResults(form) {
        const results = form.querySelector('.search-results');
        if (results) {
            results.style.display = 'none';
        }
    }
    
    // Notification System
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <span class="notification-message">${message}</span>
            <button class="notification-close">&times;</button>
        `;
        
        // Add to body
        document.body.appendChild(notification);
        
        // Show notification
        setTimeout(() => notification.classList.add('show'), 10);
        
        // Auto hide after 5 seconds
        setTimeout(() => {
            hideNotification(notification);
        }, 5000);
        
        // Close button
        const closeBtn = notification.querySelector('.notification-close');
        closeBtn.addEventListener('click', () => hideNotification(notification));
    }
    
    function hideNotification(notification) {
        notification.classList.remove('show');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }
    
    // Load wishlist states on page load
    function loadWishlistStates() {
        const wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
        const wishlistButtons = document.querySelectorAll('.add-to-wishlist');
        
        wishlistButtons.forEach(button => {
            const productId = button.dataset.productId;
            if (wishlist.includes(productId)) {
                button.classList.add('added');
                button.title = 'Remover de lista de deseos';
            }
        });
    }
    
    // Initialize wishlist states
    loadWishlistStates();
    
    // Handle browser back/forward buttons for AJAX filtering
    window.addEventListener('popstate', function(event) {
        if (document.querySelector('.shop-page')) {
            window.location.reload();
        }
    });
    
    // Infinite scroll for shop page (optional)
    function initInfiniteScroll() {
        const loadMoreBtn = document.querySelector('.load-more-products');
        
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                const nextPage = parseInt(this.dataset.page) + 1;
                const maxPages = parseInt(this.dataset.maxPages);
                
                if (nextPage <= maxPages) {
                    loadMoreProducts(nextPage, this);
                }
            });
        }
    }
    
    function loadMoreProducts(page, button) {
        const originalText = button.textContent;
        button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Cargando...';
        button.disabled = true;
        
        const url = new URL(window.location);
        url.searchParams.set('page', page);
        
        fetch(url.toString())
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newProducts = doc.querySelectorAll('.products li.product');
                const productsContainer = document.querySelector('.products');
                
                newProducts.forEach(product => {
                    productsContainer.appendChild(product);
                });
                
                button.dataset.page = page;
                
                if (page >= parseInt(button.dataset.maxPages)) {
                    button.style.display = 'none';
                } else {
                    button.textContent = originalText;
                    button.disabled = false;
                }
                
                // Re-initialize components for new products
                initAddToCartButtons();
                initWishlist();
                loadWishlistStates();
            })
            .catch(error => {
                console.error('Error loading more products:', error);
                button.textContent = originalText;
                button.disabled = false;
                showNotification('Error al cargar más productos', 'error');
            });
    }
    
    // Initialize infinite scroll
    initInfiniteScroll();
});