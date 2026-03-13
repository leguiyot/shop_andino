<?php
/**
 * Plan Andino Shop - Customizer
 * Opciones de personalización en tiempo real (Apariencia > Personalizar)
 *
 * @package PlanAndinoShop
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Registrar todas las secciones y controles del Customizer
 */
function planandino_customizer_register( $wp_customize ) {

    // ─────────────────────────────────────────────
    // PANEL PRINCIPAL
    // ─────────────────────────────────────────────
    $wp_customize->add_panel( 'planandino_panel', array(
        'title'    => __( 'Plan Andino Shop', 'planandino-shop' ),
        'priority' => 30,
    ) );

    // ═════════════════════════════════════════════
    // SECCIÓN: CABECERA
    // ═════════════════════════════════════════════
    $wp_customize->add_section( 'planandino_header', array(
        'title'    => __( 'Cabecera', 'planandino-shop' ),
        'panel'    => 'planandino_panel',
        'priority' => 10,
    ) );

    // Color de fondo del header
    $wp_customize->add_setting( 'header_bg_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_bg_color', array(
        'label'   => __( 'Color de fondo del header', 'planandino-shop' ),
        'section' => 'planandino_header',
    ) ) );

    // Color del fondo header en sticky
    $wp_customize->add_setting( 'header_sticky_bg_color', array(
        'default'           => 'rgba(255,255,255,0.95)',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'header_sticky_bg_color', array(
        'label'       => __( 'Color de fondo sticky (incluye transparencia)', 'planandino-shop' ),
        'description' => __( 'Ej: rgba(255,255,255,0.95) o #ffffff', 'planandino-shop' ),
        'section'     => 'planandino_header',
        'type'        => 'text',
    ) );

    // Altura del header
    $wp_customize->add_setting( 'header_height', array(
        'default'           => '85',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'header_height', array(
        'label'       => __( 'Altura del header (px)', 'planandino-shop' ),
        'section'     => 'planandino_header',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 50, 'max' => 200, 'step' => 5 ),
    ) );

    // Activar imagen full-width en la cabecera (hero image)
    $wp_customize->add_setting( 'header_hero_enable', array(
        'default'           => false,
        'sanitize_callback' => 'planandino_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'header_hero_enable', array(
        'label'   => __( 'Activar imagen hero (full-width bajo el header)', 'planandino-shop' ),
        'section' => 'planandino_header',
        'type'    => 'checkbox',
    ) );

    // Imagen hero
    $wp_customize->add_setting( 'header_hero_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'header_hero_image', array(
        'label'           => __( 'Imagen hero', 'planandino-shop' ),
        'section'         => 'planandino_header',
        'active_callback' => function() { return (bool) get_theme_mod( 'header_hero_enable', false ); },
    ) ) );

    // Altura de la imagen hero
    $wp_customize->add_setting( 'header_hero_height', array(
        'default'           => '450',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'header_hero_height', array(
        'label'           => __( 'Altura del hero (px)', 'planandino-shop' ),
        'section'         => 'planandino_header',
        'type'            => 'number',
        'input_attrs'     => array( 'min' => 200, 'max' => 900, 'step' => 10 ),
        'active_callback' => function() { return (bool) get_theme_mod( 'header_hero_enable', false ); },
    ) );

    // Texto superpuesto en hero
    $wp_customize->add_setting( 'header_hero_title', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'header_hero_title', array(
        'label'           => __( 'Título del hero (opcional)', 'planandino-shop' ),
        'section'         => 'planandino_header',
        'type'            => 'text',
        'active_callback' => function() { return (bool) get_theme_mod( 'header_hero_enable', false ); },
    ) );

    // Overlay del hero
    $wp_customize->add_setting( 'header_hero_overlay', array(
        'default'           => 'rgba(0,0,0,0.3)',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'header_hero_overlay', array(
        'label'           => __( 'Color overlay hero (rgba)', 'planandino-shop' ),
        'description'     => __( 'Ej: rgba(0,0,0,0.3) para oscurecer', 'planandino-shop' ),
        'section'         => 'planandino_header',
        'type'            => 'text',
        'active_callback' => function() { return (bool) get_theme_mod( 'header_hero_enable', false ); },
    ) );

    // ═════════════════════════════════════════════
    // SECCIÓN: NAVEGACIÓN / MENÚ
    // ═════════════════════════════════════════════
    $wp_customize->add_section( 'planandino_nav', array(
        'title'    => __( 'Navegación y Menú', 'planandino-shop' ),
        'panel'    => 'planandino_panel',
        'priority' => 20,
    ) );

    // Color de links del menú
    $wp_customize->add_setting( 'nav_link_color', array(
        'default'           => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'nav_link_color', array(
        'label'   => __( 'Color de los enlaces del menú', 'planandino-shop' ),
        'section' => 'planandino_nav',
    ) ) );

    // Color hover de links del menú
    $wp_customize->add_setting( 'nav_link_hover_color', array(
        'default'           => '#e6ae48',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'nav_link_hover_color', array(
        'label'   => __( 'Color hover de los enlaces del menú', 'planandino-shop' ),
        'section' => 'planandino_nav',
    ) ) );

    // Tamaño de fuente del menú
    $wp_customize->add_setting( 'nav_font_size', array(
        'default'           => '14',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'nav_font_size', array(
        'label'       => __( 'Tamaño de fuente del menú (px)', 'planandino-shop' ),
        'section'     => 'planandino_nav',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 10, 'max' => 24, 'step' => 1 ),
    ) );

    // ═════════════════════════════════════════════
    // SECCIÓN: PIE DE PÁGINA
    // ═════════════════════════════════════════════
    $wp_customize->add_section( 'planandino_footer', array(
        'title'    => __( 'Pie de Página', 'planandino-shop' ),
        'panel'    => 'planandino_panel',
        'priority' => 30,
    ) );

    // Color de fondo del footer superior
    $wp_customize->add_setting( 'footer_top_bg_color', array(
        'default'           => '#222222',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_top_bg_color', array(
        'label'   => __( 'Color de fondo — área de widgets', 'planandino-shop' ),
        'section' => 'planandino_footer',
    ) ) );

    // Color de fondo del footer inferior
    $wp_customize->add_setting( 'footer_bottom_bg_color', array(
        'default'           => '#111111',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_bottom_bg_color', array(
        'label'   => __( 'Color de fondo — barra inferior (copyright)', 'planandino-shop' ),
        'section' => 'planandino_footer',
    ) ) );

    // Color del texto del footer
    $wp_customize->add_setting( 'footer_text_color', array(
        'default'           => '#aaaaaa',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_text_color', array(
        'label'   => __( 'Color de texto del footer', 'planandino-shop' ),
        'section' => 'planandino_footer',
    ) ) );

    // Color de los links del footer
    $wp_customize->add_setting( 'footer_link_color', array(
        'default'           => '#e6ae48',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_link_color', array(
        'label'   => __( 'Color de enlaces del footer', 'planandino-shop' ),
        'section' => 'planandino_footer',
    ) ) );

    // Texto de copyright
    $wp_customize->add_setting( 'footer_copyright_text', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'footer_copyright_text', array(
        'label'       => __( 'Texto de copyright personalizado', 'planandino-shop' ),
        'description' => __( 'Dejar vacío para usar el nombre del sitio automáticamente.', 'planandino-shop' ),
        'section'     => 'planandino_footer',
        'type'        => 'textarea',
    ) );

    // ═════════════════════════════════════════════
    // SECCIÓN: TIPOGRAFÍA
    // ═════════════════════════════════════════════
    $wp_customize->add_section( 'planandino_typography', array(
        'title'    => __( 'Tipografía', 'planandino-shop' ),
        'panel'    => 'planandino_panel',
        'priority' => 40,
    ) );

    $google_fonts = planandino_get_google_fonts_list();

    // Fuente del cuerpo
    $wp_customize->add_setting( 'body_font_family', array(
        'default'           => 'Open Sans',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'body_font_family', array(
        'label'   => __( 'Fuente principal del cuerpo', 'planandino-shop' ),
        'section' => 'planandino_typography',
        'type'    => 'select',
        'choices' => $google_fonts,
    ) );

    // Tamaño base de fuente
    $wp_customize->add_setting( 'body_font_size', array(
        'default'           => '16',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'body_font_size', array(
        'label'       => __( 'Tamaño base del texto (px)', 'planandino-shop' ),
        'section'     => 'planandino_typography',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 12, 'max' => 24, 'step' => 1 ),
    ) );

    // Color del texto del body
    $wp_customize->add_setting( 'body_text_color', array(
        'default'           => '#444444',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'body_text_color', array(
        'label'   => __( 'Color del texto general', 'planandino-shop' ),
        'section' => 'planandino_typography',
    ) ) );

    // Fuente de los títulos (H1-H6)
    $wp_customize->add_setting( 'headings_font_family', array(
        'default'           => 'Open Sans',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'headings_font_family', array(
        'label'   => __( 'Fuente de los títulos (H1–H6)', 'planandino-shop' ),
        'section' => 'planandino_typography',
        'type'    => 'select',
        'choices' => $google_fonts,
    ) );

    // Color de los títulos
    $wp_customize->add_setting( 'headings_color', array(
        'default'           => '#222222',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'headings_color', array(
        'label'   => __( 'Color de los títulos', 'planandino-shop' ),
        'section' => 'planandino_typography',
    ) ) );

    // Peso de los títulos
    $wp_customize->add_setting( 'headings_font_weight', array(
        'default'           => '600',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'headings_font_weight', array(
        'label'   => __( 'Peso de la fuente de títulos', 'planandino-shop' ),
        'section' => 'planandino_typography',
        'type'    => 'select',
        'choices' => array(
            '300' => __( 'Light (300)', 'planandino-shop' ),
            '400' => __( 'Normal (400)', 'planandino-shop' ),
            '600' => __( 'Semi-bold (600)', 'planandino-shop' ),
            '700' => __( 'Bold (700)', 'planandino-shop' ),
            '800' => __( 'Extra-bold (800)', 'planandino-shop' ),
        ),
    ) );

    // ═════════════════════════════════════════════
    // SECCIÓN: COLORES GLOBALES
    // ═════════════════════════════════════════════
    $wp_customize->add_section( 'planandino_colors', array(
        'title'    => __( 'Colores Globales', 'planandino-shop' ),
        'panel'    => 'planandino_panel',
        'priority' => 50,
    ) );

    // Color primario (acento)
    $wp_customize->add_setting( 'color_primary', array(
        'default'           => '#e6ae48',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'color_primary', array(
        'label'       => __( 'Color primario (acento)', 'planandino-shop' ),
        'description' => __( 'Usado en precios, hover, badges y resaltados.', 'planandino-shop' ),
        'section'     => 'planandino_colors',
    ) ) );

    // Color primario hover
    $wp_customize->add_setting( 'color_primary_hover', array(
        'default'           => '#d19b3e',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'color_primary_hover', array(
        'label'   => __( 'Color primario — hover/oscuro', 'planandino-shop' ),
        'section' => 'planandino_colors',
    ) ) );

    // Color de fondo del sitio
    $wp_customize->add_setting( 'color_site_bg', array(
        'default'           => '#f7f7f7',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'color_site_bg', array(
        'label'   => __( 'Color de fondo del sitio', 'planandino-shop' ),
        'section' => 'planandino_colors',
    ) ) );

    // Color de los bordes / separadores
    $wp_customize->add_setting( 'color_border', array(
        'default'           => '#e0e0e0',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'color_border', array(
        'label'   => __( 'Color de bordes y separadores', 'planandino-shop' ),
        'section' => 'planandino_colors',
    ) ) );

    // ═════════════════════════════════════════════
    // SECCIÓN: BOTONES
    // ═════════════════════════════════════════════
    $wp_customize->add_section( 'planandino_buttons', array(
        'title'    => __( 'Botones', 'planandino-shop' ),
        'panel'    => 'planandino_panel',
        'priority' => 60,
    ) );

    // Estilo de botón primario
    $wp_customize->add_setting( 'btn_style', array(
        'default'           => 'filled',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'btn_style', array(
        'label'   => __( 'Estilo de botón', 'planandino-shop' ),
        'section' => 'planandino_buttons',
        'type'    => 'select',
        'choices' => array(
            'filled'   => __( 'Relleno (filled)', 'planandino-shop' ),
            'outline'  => __( 'Contorno (outline)', 'planandino-shop' ),
            'flat'     => __( 'Plano sin borde', 'planandino-shop' ),
            'pill'     => __( 'Redondeado (pill)', 'planandino-shop' ),
            'square'   => __( 'Cuadrado / Sharp', 'planandino-shop' ),
        ),
    ) );

    // Color de fondo del botón primario
    $wp_customize->add_setting( 'btn_bg_color', array(
        'default'           => '#e6ae48',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'btn_bg_color', array(
        'label'   => __( 'Color de fondo del botón', 'planandino-shop' ),
        'section' => 'planandino_buttons',
    ) ) );

    // Color de texto del botón
    $wp_customize->add_setting( 'btn_text_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'btn_text_color', array(
        'label'   => __( 'Color de texto del botón', 'planandino-shop' ),
        'section' => 'planandino_buttons',
    ) ) );

    // Color de fondo hover del botón
    $wp_customize->add_setting( 'btn_hover_bg_color', array(
        'default'           => '#d19b3e',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'btn_hover_bg_color', array(
        'label'   => __( 'Color de fondo del botón al pasar el mouse', 'planandino-shop' ),
        'section' => 'planandino_buttons',
    ) ) );

    // Color de texto hover del botón
    $wp_customize->add_setting( 'btn_hover_text_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'btn_hover_text_color', array(
        'label'   => __( 'Color de texto del botón al pasar el mouse', 'planandino-shop' ),
        'section' => 'planandino_buttons',
    ) ) );

    // Tamaño de fuente del botón
    $wp_customize->add_setting( 'btn_font_size', array(
        'default'           => '14',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'btn_font_size', array(
        'label'       => __( 'Tamaño de fuente del botón (px)', 'planandino-shop' ),
        'section'     => 'planandino_buttons',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 10, 'max' => 24, 'step' => 1 ),
    ) );

    // Padding del botón
    $wp_customize->add_setting( 'btn_padding_v', array(
        'default'           => '12',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'btn_padding_v', array(
        'label'       => __( 'Padding vertical del botón (px)', 'planandino-shop' ),
        'section'     => 'planandino_buttons',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 4, 'max' => 40, 'step' => 1 ),
    ) );

    $wp_customize->add_setting( 'btn_padding_h', array(
        'default'           => '25',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'btn_padding_h', array(
        'label'       => __( 'Padding horizontal del botón (px)', 'planandino-shop' ),
        'section'     => 'planandino_buttons',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 8, 'max' => 80, 'step' => 1 ),
    ) );

    // ═════════════════════════════════════════════
    // SECCIÓN: WooCommerce / Tienda
    // ═════════════════════════════════════════════
    $wp_customize->add_section( 'planandino_woo', array(
        'title'    => __( 'Tienda (WooCommerce)', 'planandino-shop' ),
        'panel'    => 'planandino_panel',
        'priority' => 70,
    ) );

    // Columnas de productos
    $wp_customize->add_setting( 'shop_columns', array(
        'default'           => '4',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'shop_columns', array(
        'label'       => __( 'Columnas de productos en la tienda', 'planandino-shop' ),
        'section'     => 'planandino_woo',
        'type'        => 'select',
        'choices'     => array( '2' => '2', '3' => '3', '4' => '4', '5' => '5' ),
    ) );

    // Productos por página
    $wp_customize->add_setting( 'shop_per_page', array(
        'default'           => '12',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'shop_per_page', array(
        'label'       => __( 'Productos por página', 'planandino-shop' ),
        'section'     => 'planandino_woo',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 4, 'max' => 60, 'step' => 4 ),
    ) );

    // Color precio normal
    $wp_customize->add_setting( 'shop_price_color', array(
        'default'           => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'shop_price_color', array(
        'label'   => __( 'Color del precio', 'planandino-shop' ),
        'section' => 'planandino_woo',
    ) ) );

    // Color precio en oferta
    $wp_customize->add_setting( 'shop_sale_price_color', array(
        'default'           => '#e6ae48',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'shop_sale_price_color', array(
        'label'   => __( 'Color del precio en oferta', 'planandino-shop' ),
        'section' => 'planandino_woo',
    ) ) );

    // Color del badge de oferta
    $wp_customize->add_setting( 'shop_badge_bg_color', array(
        'default'           => '#e6ae48',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'shop_badge_bg_color', array(
        'label'   => __( 'Color del badge "Oferta"', 'planandino-shop' ),
        'section' => 'planandino_woo',
    ) ) );
}
add_action( 'customize_register', 'planandino_customizer_register' );


// ─────────────────────────────────────────────
// HELPERS
// ─────────────────────────────────────────────

/**
 * Sanitize checkbox
 */
function planandino_sanitize_checkbox( $checked ) {
    return ( isset( $checked ) && $checked ) ? true : false;
}

/**
 * Lista de fuentes populares de Google Fonts
 */
function planandino_get_google_fonts_list() {
    return array(
        'Open Sans'       => 'Open Sans',
        'Roboto'          => 'Roboto',
        'Lato'            => 'Lato',
        'Montserrat'      => 'Montserrat',
        'Raleway'         => 'Raleway',
        'Poppins'         => 'Poppins',
        'Nunito'          => 'Nunito',
        'Playfair Display'=> 'Playfair Display',
        'Merriweather'    => 'Merriweather',
        'Oswald'          => 'Oswald',
        'Source Sans Pro' => 'Source Sans Pro',
        'Ubuntu'          => 'Ubuntu',
        'Inter'           => 'Inter',
        'Noto Sans'       => 'Noto Sans',
        'Libre Baskerville'=> 'Libre Baskerville',
    );
}


// ─────────────────────────────────────────────
// CSS DINÁMICO generado desde el Customizer
// ─────────────────────────────────────────────

/**
 * Genera y vuelca en <head> el CSS personalizado del Customizer
 */
function planandino_customizer_css() {
    // ── Valores del Customizer (con defaults) ──
    $header_bg          = get_theme_mod( 'header_bg_color',         '#ffffff' );
    $header_sticky_bg   = get_theme_mod( 'header_sticky_bg_color',  'rgba(255,255,255,0.95)' );
    $header_height      = (int) get_theme_mod( 'header_height',     85 );

    $nav_color          = get_theme_mod( 'nav_link_color',          '#333333' );
    $nav_hover          = get_theme_mod( 'nav_link_hover_color',    '#e6ae48' );
    $nav_font_size      = (int) get_theme_mod( 'nav_font_size',     14 );

    $footer_top_bg      = get_theme_mod( 'footer_top_bg_color',     '#222222' );
    $footer_bottom_bg   = get_theme_mod( 'footer_bottom_bg_color',  '#111111' );
    $footer_text        = get_theme_mod( 'footer_text_color',       '#aaaaaa' );
    $footer_link        = get_theme_mod( 'footer_link_color',       '#e6ae48' );

    $body_font          = get_theme_mod( 'body_font_family',        'Open Sans' );
    $body_size          = (int) get_theme_mod( 'body_font_size',    16 );
    $body_color         = get_theme_mod( 'body_text_color',         '#444444' );
    $h_font             = get_theme_mod( 'headings_font_family',    'Open Sans' );
    $h_color            = get_theme_mod( 'headings_color',          '#222222' );
    $h_weight           = get_theme_mod( 'headings_font_weight',    '600' );

    $color_primary      = get_theme_mod( 'color_primary',           '#e6ae48' );
    $color_primary_h    = get_theme_mod( 'color_primary_hover',     '#d19b3e' );
    $color_site_bg      = get_theme_mod( 'color_site_bg',           '#f7f7f7' );
    $color_border       = get_theme_mod( 'color_border',            '#e0e0e0' );

    $btn_style          = get_theme_mod( 'btn_style',               'filled' );
    $btn_bg             = get_theme_mod( 'btn_bg_color',            '#e6ae48' );
    $btn_text           = get_theme_mod( 'btn_text_color',          '#ffffff' );
    $btn_hover_bg       = get_theme_mod( 'btn_hover_bg_color',      '#d19b3e' );
    $btn_hover_text     = get_theme_mod( 'btn_hover_text_color',    '#ffffff' );
    $btn_font_size      = (int) get_theme_mod( 'btn_font_size',     14 );
    $btn_pv             = (int) get_theme_mod( 'btn_padding_v',     12 );
    $btn_ph             = (int) get_theme_mod( 'btn_padding_h',     25 );

    $shop_price         = get_theme_mod( 'shop_price_color',        '#333333' );
    $shop_sale_price    = get_theme_mod( 'shop_sale_price_color',   '#e6ae48' );
    $shop_badge_bg      = get_theme_mod( 'shop_badge_bg_color',     '#e6ae48' );

    // ── Hero ──
    $hero_enable        = (bool) get_theme_mod( 'header_hero_enable', false );
    $hero_height        = (int) get_theme_mod( 'header_hero_height', 450 );
    $hero_overlay       = get_theme_mod( 'header_hero_overlay', 'rgba(0,0,0,0.3)' );

    // ── Calcular border-radius según estilo de botón ──
    $btn_radius = '4px';
    $btn_border = 'none';
    switch ( $btn_style ) {
        case 'outline':
            $btn_bg      = 'transparent';
            $btn_text    = $color_primary;
            $btn_border  = '2px solid ' . $color_primary;
            $btn_hover_bg   = $color_primary;
            $btn_hover_text = '#ffffff';
            $btn_radius  = '4px';
            break;
        case 'pill':
            $btn_radius = '50px';
            break;
        case 'square':
            $btn_radius = '0';
            break;
        case 'flat':
            $btn_border = 'none';
            $btn_radius = '4px';
            break;
    }

    // ── Cargar Google Fonts si no son la fuente por defecto ──
    $fonts_to_load = array_unique( array( $body_font, $h_font ) );
    foreach ( $fonts_to_load as $font ) {
        if ( $font !== 'inherit' && $font !== 'system-ui' ) {
            $font_url = 'https://fonts.googleapis.com/css2?family=' . urlencode( $font ) . ':wght@300;400;600;700&display=swap';
            echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
            echo '<link href="' . esc_url( $font_url ) . '" rel="stylesheet">' . "\n";
        }
    }

    // ── Output CSS ──
    ?>
    <style id="planandino-customizer-css">
        /* ── Variables CSS globales ── */
        :root {
            --color-primary:      <?php echo esc_attr( $color_primary ); ?>;
            --color-primary-h:    <?php echo esc_attr( $color_primary_h ); ?>;
            --color-site-bg:      <?php echo esc_attr( $color_site_bg ); ?>;
            --color-border:       <?php echo esc_attr( $color_border ); ?>;
            --body-font:          '<?php echo esc_attr( $body_font ); ?>', sans-serif;
            --heading-font:       '<?php echo esc_attr( $h_font ); ?>', sans-serif;
        }

        /* ── Cuerpo ── */
        body {
            font-family: '<?php echo esc_attr( $body_font ); ?>', sans-serif;
            font-size: <?php echo $body_size; ?>px;
            color: <?php echo esc_attr( $body_color ); ?>;
            background-color: <?php echo esc_attr( $color_site_bg ); ?>;
        }

        /* ── Títulos ── */
        h1, h2, h3, h4, h5, h6,
        .product_title, .entry-title, .page-title, .woocommerce-loop-product__title {
            font-family: '<?php echo esc_attr( $h_font ); ?>', sans-serif;
            color: <?php echo esc_attr( $h_color ); ?>;
            font-weight: <?php echo esc_attr( $h_weight ); ?>;
        }

        /* ── Header ── */
        .header_holder {
            background-color: <?php echo esc_attr( $header_bg ); ?>;
            height: <?php echo $header_height; ?>px;
        }
        .header_holder.sticky,
        .header_holder.fixed {
            background-color: <?php echo esc_attr( $header_sticky_bg ); ?>;
        }
        .side_menu_button { height: <?php echo $header_height; ?>px; }

        /* ── Navegación ── */
        .main_menu > ul > li > a,
        .main_menu li a {
            color: <?php echo esc_attr( $nav_color ); ?> !important;
            font-size: <?php echo $nav_font_size; ?>px;
            line-height: <?php echo $header_height; ?>px;
        }
        .main_menu > ul > li > a:hover,
        .main_menu li.active > a,
        .main_menu li.current_page_item > a,
        .main_menu li.current-menu-item > a {
            color: <?php echo esc_attr( $nav_hover ); ?> !important;
        }

        /* ── Footer ── */
        .footer_top_holder,
        footer .footer_top { background-color: <?php echo esc_attr( $footer_top_bg ); ?>; }
        .footer_bottom_holder,
        footer .footer_bottom { background-color: <?php echo esc_attr( $footer_bottom_bg ); ?>; }
        footer, footer p, footer li, footer span { color: <?php echo esc_attr( $footer_text ); ?>; }
        footer a { color: <?php echo esc_attr( $footer_link ); ?>; }
        footer a:hover { color: <?php echo esc_attr( $color_primary ); ?>; }
        footer .widget-title, footer h5 { color: #ffffff; border-bottom-color: <?php echo esc_attr( $color_primary ); ?>; }

        /* ── Color primario global ── */
        a { color: <?php echo esc_attr( $color_primary ); ?>; }
        a:hover { color: <?php echo esc_attr( $color_primary_h ); ?>; }
        ::selection { background: <?php echo esc_attr( $color_primary ); ?>; color: #fff; }
        hr, .separator { border-color: <?php echo esc_attr( $color_border ); ?>; }

        /* ── Botones ── */
        .woocommerce a.button,
        .woocommerce button.button,
        .woocommerce input.button,
        .woocommerce #respond input#submit,
        .woocommerce .single_add_to_cart_button,
        .btn, button.btn, a.btn, input.btn,
        .price-filter-button {
            background-color: <?php echo esc_attr( $btn_bg ); ?> !important;
            color: <?php echo esc_attr( $btn_text ); ?> !important;
            border: <?php echo esc_attr( $btn_border ); ?> !important;
            border-radius: <?php echo esc_attr( $btn_radius ); ?> !important;
            font-size: <?php echo $btn_font_size; ?>px !important;
            padding: <?php echo $btn_pv; ?>px <?php echo $btn_ph; ?>px !important;
            transition: background-color .25s ease, color .25s ease, border-color .25s ease;
        }
        .woocommerce a.button:hover,
        .woocommerce button.button:hover,
        .woocommerce input.button:hover,
        .woocommerce #respond input#submit:hover,
        .woocommerce .single_add_to_cart_button:hover,
        .btn:hover, button.btn:hover, a.btn:hover, input.btn:hover,
        .price-filter-button:hover {
            background-color: <?php echo esc_attr( $btn_hover_bg ); ?> !important;
            color: <?php echo esc_attr( $btn_hover_text ); ?> !important;
        }

        /* ── Precios WooCommerce ── */
        .woocommerce ul.products li.product .price,
        .woocommerce div.product p.price { color: <?php echo esc_attr( $shop_price ); ?>; }
        .woocommerce ul.products li.product .price ins,
        .woocommerce div.product p.price ins { color: <?php echo esc_attr( $shop_sale_price ); ?>; }
        .woocommerce span.onsale, .onsale { background-color: <?php echo esc_attr( $shop_badge_bg ); ?>; }

        /* ── Color primario en otros elementos ── */
        .widget-title::before, .widget-title:after,
        .main_menu li.active > a::after { background-color: <?php echo esc_attr( $color_primary ); ?>; }
        .star-rating span::before { color: <?php echo esc_attr( $color_primary ); ?>; }
        .woocommerce nav.woocommerce-pagination ul li a:hover,
        .woocommerce nav.woocommerce-pagination ul li span.current {
            background: <?php echo esc_attr( $color_primary ); ?>;
            border-color: <?php echo esc_attr( $color_primary ); ?>;
        }
        input[type="checkbox"]:checked,
        input[type="radio"]:checked { accent-color: <?php echo esc_attr( $color_primary ); ?>; }

        <?php if ( $hero_enable ) : ?>
        /* ── Hero image ── */
        .planandino-hero {
            height: <?php echo $hero_height; ?>px;
        }
        .planandino-hero .hero-overlay {
            background: <?php echo esc_attr( $hero_overlay ); ?>;
        }
        <?php endif; ?>
    </style>
    <?php
}
add_action( 'wp_head', 'planandino_customizer_css', 99 );


// ─────────────────────────────────────────────
// postMessage JS para preview en tiempo real
// ─────────────────────────────────────────────
function planandino_customizer_preview_js() {
    wp_enqueue_script(
        'planandino-customizer-preview',
        get_template_directory_uri() . '/assets/js/customizer-preview.js',
        array( 'customize-preview', 'jquery' ),
        '1.0.0',
        true
    );
}
add_action( 'customize_preview_init', 'planandino_customizer_preview_js' );
