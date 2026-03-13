        <div class="column2">
            <div class="column_inner">
                <aside class="sidebar">
                    <?php 
                    if (is_shop() || is_product_category() || is_product_tag() || is_product()) {
                        if (is_active_sidebar('shop-sidebar')) {
                            dynamic_sidebar('shop-sidebar');
                        }
                    } else {
                        if (is_active_sidebar('primary-sidebar')) {
                            dynamic_sidebar('primary-sidebar');
                        }
                    }
                    ?>
                </aside>
            </div>
        </div>
    </div>
</div>

<footer>
    <div class="footer_inner clearfix">
        <div class="footer_top_holder">
            <div class="footer_top">
                <div class="container">
                    <div class="container_inner">
                        <div class="footer_widgets_area">
                            <div class="footer_widget_columns">
                                <?php for ($i = 1; $i <= 4; $i++): ?>
                                    <div class="footer_column">
                                        <?php if (is_active_sidebar('footer-widget-' . $i)): ?>
                                            <?php dynamic_sidebar('footer-widget-' . $i); ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer_bottom_holder">
            <div class="footer_bottom">
                <div class="container">
                    <div class="container_inner">
                        <div class="footer_bottom_inner">
                            <div class="footer_copyright">
                                <?php
                                $custom_copy = get_theme_mod( 'footer_copyright_text', '' );
                                if ( $custom_copy ) {
                                    echo '<p class="footer-copyright-text">' . wp_kses_post( $custom_copy ) . '</p>';
                                } else {
                                    echo '<p class="footer-copyright-text">&copy; ' . esc_html( date('Y') ) . ' ' . esc_html( get_bloginfo('name') ) . '. ' . esc_html__( 'Todos los derechos reservados.', 'planandino-shop' ) . '</p>';
                                }
                                ?>
                            </div>
                            
                            <?php if (has_nav_menu('footer')): ?>
                                <div class="footer_menu">
                                    <?php
                                    wp_nav_menu(array(
                                        'theme_location' => 'footer',
                                        'menu_class' => 'footer_nav',
                                        'container' => 'nav',
                                        'depth' => 1,
                                        'fallback_cb' => false,
                                    ));
                                    ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

<script>
// Scroll to top funcionalidad igual al Bridge
jQuery(document).ready(function($) {
    var backToTop = $('#back_to_top');
    
    // Mostrar/ocultar botón según scroll
    $(window).scroll(function() {
        if ($(this).scrollTop() > 500) {
            backToTop.fadeIn();
        } else {
            backToTop.fadeOut();
        }
    });
    
    // Smooth scroll al hacer clic
    backToTop.click(function(e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: 0
        }, 800);
        return false;
    });
    
    // Toggle búsqueda
    $('.header_search_icon').click(function(e) {
        e.preventDefault();
        $('.search_form_overlay').fadeIn(300);
        $('.search_field').focus();
    });
    
    $('.search_close').click(function(e) {
        e.preventDefault();
        $('.search_form_overlay').fadeOut(300);
    });
    
    // Cerrar búsqueda con ESC
    $(document).keyup(function(e) {
        if (e.keyCode == 27) {
            $('.search_form_overlay').fadeOut(300);
        }
    });
    
    // Actualizar contador de carrito
    $(document.body).on('added_to_cart', function(event, fragments, cart_hash, $button) {
        var cartCount = $('.cart-count');
        var newCount = fragments['div.widget_shopping_cart_content'];
        if (newCount) {
            var matches = newCount.match(/(\d+)/);
            if (matches) {
                if (cartCount.length === 0) {
                    $('.cart-link').append('<span class="cart-count">' + matches[0] + '</span>');
                } else {
                    cartCount.text(matches[0]);
                }
            }
        }
    });
});
</script>

</body>
</html>