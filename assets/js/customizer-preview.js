/**
 * Plan Andino Shop — Customizer Live Preview (postMessage)
 * Aplica cambios en tiempo real sin recargar la página.
 */
( function( $ ) {
    'use strict';

    // ── Helper: aplicar estilos inline a selector ──
    function liveCSS( selector, prop, value ) {
        $( selector ).css( prop, value );
    }

    // ── Helper: añadir/reemplazar regla en el bloque <style> del customizer ──
    function updateVar( varName, value ) {
        var style = document.getElementById( 'planandino-customizer-css' );
        if ( ! style ) return;
        var re = new RegExp( varName + '\\s*:\\s*[^;]+;', 'g' );
        style.textContent = style.textContent.replace( re, varName + ': ' + value + ';' );
    }

    // ─────────────────────────────────────────────
    // CABECERA
    // ─────────────────────────────────────────────
    wp.customize( 'header_bg_color', function( value ) {
        value.bind( function( v ) {
            liveCSS( '.header_holder', 'background-color', v );
        } );
    } );
    wp.customize( 'header_height', function( value ) {
        value.bind( function( v ) {
            var px = parseInt( v, 10 ) + 'px';
            liveCSS( '.header_holder', 'height', px );
            liveCSS( '.side_menu_button', 'height', px );
            // line-height del menú
            $( '.main_menu > ul > li > a' ).css( 'line-height', px );
        } );
    } );

    // ─────────────────────────────────────────────
    // NAVEGACIÓN
    // ─────────────────────────────────────────────
    wp.customize( 'nav_link_color', function( value ) {
        value.bind( function( v ) {
            liveCSS( '.main_menu li a', 'color', v );
        } );
    } );
    wp.customize( 'nav_link_hover_color', function( value ) {
        value.bind( function( v ) {
            // Solo inyectamos una regla inline dinámica
            var id = 'cz-nav-hover';
            $( '#' + id ).remove();
            $( 'head' ).append(
                '<style id="' + id + '">' +
                '.main_menu > ul > li > a:hover,' +
                '.main_menu li.current-menu-item > a { color: ' + v + ' !important; }' +
                '</style>'
            );
        } );
    } );
    wp.customize( 'nav_font_size', function( value ) {
        value.bind( function( v ) {
            liveCSS( '.main_menu li a', 'font-size', parseInt( v, 10 ) + 'px' );
        } );
    } );

    // ─────────────────────────────────────────────
    // FOOTER
    // ─────────────────────────────────────────────
    wp.customize( 'footer_top_bg_color', function( value ) {
        value.bind( function( v ) {
            liveCSS( '.footer_top_holder, footer .footer_top', 'background-color', v );
        } );
    } );
    wp.customize( 'footer_bottom_bg_color', function( value ) {
        value.bind( function( v ) {
            liveCSS( '.footer_bottom_holder, footer .footer_bottom', 'background-color', v );
        } );
    } );
    wp.customize( 'footer_text_color', function( value ) {
        value.bind( function( v ) {
            liveCSS( 'footer, footer p, footer li, footer span', 'color', v );
        } );
    } );
    wp.customize( 'footer_link_color', function( value ) {
        value.bind( function( v ) {
            liveCSS( 'footer a', 'color', v );
        } );
    } );
    wp.customize( 'footer_copyright_text', function( value ) {
        value.bind( function( v ) {
            $( '.footer-copyright-text' ).html( v );
        } );
    } );

    // ─────────────────────────────────────────────
    // TIPOGRAFÍA
    // ─────────────────────────────────────────────
    wp.customize( 'body_font_family', function( value ) {
        value.bind( function( v ) {
            liveCSS( 'body', 'font-family', "'" + v + "', sans-serif" );
        } );
    } );
    wp.customize( 'body_font_size', function( value ) {
        value.bind( function( v ) {
            liveCSS( 'body', 'font-size', parseInt( v, 10 ) + 'px' );
        } );
    } );
    wp.customize( 'body_text_color', function( value ) {
        value.bind( function( v ) {
            liveCSS( 'body', 'color', v );
        } );
    } );
    wp.customize( 'headings_font_family', function( value ) {
        value.bind( function( v ) {
            liveCSS( 'h1, h2, h3, h4, h5, h6', 'font-family', "'" + v + "', sans-serif" );
        } );
    } );
    wp.customize( 'headings_color', function( value ) {
        value.bind( function( v ) {
            liveCSS( 'h1, h2, h3, h4, h5, h6', 'color', v );
        } );
    } );
    wp.customize( 'headings_font_weight', function( value ) {
        value.bind( function( v ) {
            liveCSS( 'h1, h2, h3, h4, h5, h6', 'font-weight', v );
        } );
    } );

    // ─────────────────────────────────────────────
    // COLORES GLOBALES
    // ─────────────────────────────────────────────
    wp.customize( 'color_primary', function( value ) {
        value.bind( function( v ) {
            updateVar( '--color-primary', v );
            liveCSS( 'a', 'color', v );
        } );
    } );
    wp.customize( 'color_primary_hover', function( value ) {
        value.bind( function( v ) {
            updateVar( '--color-primary-h', v );
        } );
    } );
    wp.customize( 'color_site_bg', function( value ) {
        value.bind( function( v ) {
            liveCSS( 'body', 'background-color', v );
        } );
    } );

    // ─────────────────────────────────────────────
    // BOTONES
    // ─────────────────────────────────────────────
    var btnSel = '.woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit, .btn, button.btn, a.btn';

    wp.customize( 'btn_bg_color', function( value ) {
        value.bind( function( v ) {
            liveCSS( btnSel, 'background-color', v );
        } );
    } );
    wp.customize( 'btn_text_color', function( value ) {
        value.bind( function( v ) {
            liveCSS( btnSel, 'color', v );
        } );
    } );
    wp.customize( 'btn_font_size', function( value ) {
        value.bind( function( v ) {
            liveCSS( btnSel, 'font-size', parseInt( v, 10 ) + 'px' );
        } );
    } );
    wp.customize( 'btn_padding_v', function( value ) {
        value.bind( function( v ) {
            var ph = wp.customize( 'btn_padding_h' )();
            liveCSS( btnSel, 'padding', parseInt( v, 10 ) + 'px ' + parseInt( ph, 10 ) + 'px' );
        } );
    } );
    wp.customize( 'btn_padding_h', function( value ) {
        value.bind( function( v ) {
            var pv = wp.customize( 'btn_padding_v' )();
            liveCSS( btnSel, 'padding', parseInt( pv, 10 ) + 'px ' + parseInt( v, 10 ) + 'px' );
        } );
    } );

    // ─────────────────────────────────────────────
    // WooCommerce
    // ─────────────────────────────────────────────
    wp.customize( 'shop_price_color', function( value ) {
        value.bind( function( v ) {
            liveCSS( '.woocommerce ul.products li.product .price', 'color', v );
        } );
    } );
    wp.customize( 'shop_sale_price_color', function( value ) {
        value.bind( function( v ) {
            liveCSS( '.woocommerce ul.products li.product .price ins', 'color', v );
        } );
    } );
    wp.customize( 'shop_badge_bg_color', function( value ) {
        value.bind( function( v ) {
            liveCSS( '.woocommerce span.onsale', 'background-color', v );
        } );
    } );

} )( jQuery );
