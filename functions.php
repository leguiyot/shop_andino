<?php
/**
 * Plan Andino Shop - Functions
 * 
 * @package PlanAndinoShop
 */

// Prevenir acceso directo
if (!defined('ABSPATH')) {
    exit;
}

// Customizer
$_customizer_file = get_template_directory() . '/inc/customizer.php';
if ( file_exists( $_customizer_file ) ) {
    require_once $_customizer_file;
}
unset( $_customizer_file );

/**
 * Configuración del tema
 */
function planandino_shop_setup() {
    // Soporte para WooCommerce
    add_theme_support('woocommerce');
    
    // Soporte para características del tema
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // Soporte para WooCommerce gallery
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    
    // Registrar menús
    register_nav_menus(array(
        'primary' => __('Menú Principal', 'planandino-shop'),
        'footer' => __('Menú Footer', 'planandino-shop'),
    ));
    
    // Tamaños de imagen para productos
    add_image_size('product-large', 800, 600, true);
    add_image_size('product-medium', 400, 300, true);
    add_image_size('product-thumb', 150, 150, true);
}
add_action('after_setup_theme', 'planandino_shop_setup');

/**
 * Cargar estilos y scripts
 */
function planandino_shop_scripts() {
    // CSS principal
    wp_enqueue_style('planandino-main-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // CSS modulares
    wp_enqueue_style('planandino-layout', get_template_directory_uri() . '/assets/css/layout.css', array(), '1.0.0');
    wp_enqueue_style('planandino-header', get_template_directory_uri() . '/assets/css/header.css', array(), '1.0.0');
    wp_enqueue_style('planandino-menu', get_template_directory_uri() . '/assets/css/menu.css', array(), '1.0.0');
    wp_enqueue_style('planandino-shop', get_template_directory_uri() . '/assets/css/shop.css', array(), '1.0.0');
    wp_enqueue_style('planandino-product', get_template_directory_uri() . '/assets/css/product.css', array(), '1.0.0');
    wp_enqueue_style('planandino-responsive', get_template_directory_uri() . '/assets/css/responsive.css', array(), '1.0.0');
    
    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css', array(), '6.0.0');
    
    // Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap', array(), '1.0.0');
    
    // Scripts
    wp_enqueue_script('jquery');
    wp_enqueue_script('planandino-main-js', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true);
    
    if (is_shop() || is_product_category() || is_product_tag()) {
        wp_enqueue_script('planandino-shop-js', get_template_directory_uri() . '/assets/js/shop.js', array('jquery'), '1.0.0', true);
    }
    
    // Localizar scripts
    wp_localize_script('planandino-main-js', 'planandino_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('planandino_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'planandino_shop_scripts');

/**
 * Registrar widgets
 */
function planandino_shop_widgets_init() {
    register_sidebar(array(
        'name' => __('Sidebar Principal', 'planandino-shop'),
        'id' => 'primary-sidebar',
        'description' => __('Sidebar principal para páginas y productos', 'planandino-shop'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h5>',
        'after_title' => '</h5>',
    ));
    
    register_sidebar(array(
        'name' => __('Sidebar Tienda', 'planandino-shop'),
        'id' => 'shop-sidebar',
        'description' => __('Sidebar específico para WooCommerce', 'planandino-shop'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h5>',
        'after_title' => '</h5>',
    ));
    
    // Widgets del footer
    for ($i = 1; $i <= 4; $i++) {
        register_sidebar(array(
            'name' => sprintf(__('Footer Widget %d', 'planandino-shop'), $i),
            'id' => 'footer-widget-' . $i,
            'description' => sprintf(__('Widget área %d del footer', 'planandino-shop'), $i),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h5>',
            'after_title' => '</h5>',
        ));
    }
}
add_action('widgets_init', 'planandino_shop_widgets_init');

/**
 * Personalizar WooCommerce
 */
function planandino_shop_woocommerce_setup() {
    // Numero de productos por fila
    add_filter('loop_shop_columns', function() {
        return 4; // 4 columnas en desktop
    });
    
    // Productos por página
    add_filter('loop_shop_per_page', function() {
        return 12;
    });
    
    // Remover wrappers por defecto de WooCommerce
    remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
    
    // Agregar nuestros wrappers
    add_action('woocommerce_before_main_content', 'planandino_shop_wrapper_start', 10);
    add_action('woocommerce_after_main_content', 'planandino_shop_wrapper_end', 10);
}
add_action('after_setup_theme', 'planandino_shop_woocommerce_setup');

function planandino_shop_wrapper_start() {
    echo '<div class="content"><div class="content_inner"><div class="column1"><div class="column_inner">';
}

function planandino_shop_wrapper_end() {
    echo '</div></div>';
}

/**
 * Agregar carrito al header
 */
function planandino_shop_cart_link() {
    if (function_exists('WC')) {
        $cart_count = WC()->cart->get_cart_contents_count();
        ?>
        <div class="header-cart">
            <a href="<?php echo wc_get_cart_url(); ?>" class="cart-link">
                <i class="fa fa-shopping-cart"></i>
                <?php if ($cart_count > 0): ?>
                    <span class="cart-count"><?php echo $cart_count; ?></span>
                <?php endif; ?>
            </a>
        </div>
        <?php
    }
}

/**
 * Personalizar breadcrumbs
 */
function planandino_shop_breadcrumb() {
    if (function_exists('woocommerce_breadcrumb')) {
        woocommerce_breadcrumb(array(
            'delimiter' => ' / ',
            'wrap_before' => '<nav class="breadcrumb-nav"><div class="container">',
            'wrap_after' => '</div></nav>',
            'before' => '<span>',
            'after' => '</span>',
            'home' => __('Inicio', 'planandino-shop'),
        ));
    }
}

/**
 * AJAX para agregar al carrito
 */
function planandino_shop_ajax_add_to_cart() {
    check_ajax_referer('planandino_nonce', 'nonce');
    
    $product_id = absint($_POST['product_id']);
    $quantity = absint($_POST['quantity']);
    
    if ($product_id && WC()->cart->add_to_cart($product_id, $quantity)) {
        wp_send_json_success(array(
            'message' => __('Producto agregado al carrito', 'planandino-shop'),
            'cart_count' => WC()->cart->get_cart_contents_count()
        ));
    } else {
        wp_send_json_error(array(
            'message' => __('Error al agregar producto', 'planandino-shop')
        ));
    }
}
add_action('wp_ajax_planandino_add_to_cart', 'planandino_shop_ajax_add_to_cart');
add_action('wp_ajax_nopriv_planandino_add_to_cart', 'planandino_shop_ajax_add_to_cart');

/**
 * Función helper para obtener el logo
 */
function planandino_shop_get_logo() {
    if (function_exists('the_custom_logo') && has_custom_logo()) {
        the_custom_logo();
    } else {
        echo '<a href="' . home_url('/') . '" class="site-title">' . get_bloginfo('name') . '</a>';
    }
}

/**
 * Función para generar clases CSS del body
 */
function planandino_shop_body_classes($classes) {
    if (is_shop() || is_product_category() || is_product_tag()) {
        $classes[] = 'woocommerce-shop';
    }
    
    if (is_product()) {
        $classes[] = 'single-product';
    }
    
    return $classes;
}
add_filter('body_class', 'planandino_shop_body_classes');

/**
 * Walker personalizado para el menú principal (estilo Bridge)
 */
class PlanAndino_Walker_Nav_Menu extends Walker_Nav_Menu {

    function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "\n$indent<ul class=\"second\">\n";
    }

    function end_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "$indent</ul>\n";
    }

    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $classes   = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        if ( in_array( 'current-menu-item', $classes ) ) {
            $classes[] = 'active';
            $classes[] = 'current_page_item';
        }
        $classes[] = 'narrow';

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $id = apply_filters( 'nav_menu_item_id', 'nav-menu-item-' . $item->ID, $item, $args );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names . '>';

        $attributes  = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target ) . '"'     : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn ) . '"'        : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url ) . '"'        : '';

        $style = ' style="line-height:85px"';

        $item_output  = isset( $args->before ) ? $args->before : '';
        $item_output .= '<a' . $attributes . $style . '>';
        $item_output .= '<i class="menu_icon blank fa sf-hidden"></i>';
        $item_output .= '<span>';
        $item_output .= isset( $args->link_before ) ? $args->link_before : '';
        $item_output .= apply_filters( 'the_title', $item->title, $item->ID );
        $item_output .= isset( $args->link_after ) ? $args->link_after : '';
        $item_output .= '</span>';
        $item_output .= '<span class="plus"></span>';
        $item_output .= '</a>';
        $item_output .= isset( $args->after ) ? $args->after : '';

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= "</li>\n";
    }
}