<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="max-image-preview:large">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php
$_header_height = (int) get_theme_mod( 'header_height', 85 );
$_hero_enable   = (bool) get_theme_mod( 'header_hero_enable', false );
$_hero_image    = get_theme_mod( 'header_hero_image', '' );
$_hero_height   = (int) get_theme_mod( 'header_hero_height', 450 );
$_hero_title    = get_theme_mod( 'header_hero_title', '' );
$_hero_overlay  = get_theme_mod( 'header_hero_overlay', 'rgba(0,0,0,0.3)' );
?>
<header class="header_holder">
    <div class="header_inner clearfix">
        <div class="header_logo">
            <?php planandino_shop_get_logo(); ?>
        </div>
        
        <nav class="main_menu drop_down left">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_id' => 'menu-main-menu',
                'menu_class' => '',
                'container' => 'ul',
                'fallback_cb' => false,
                'walker' => new PlanAndino_Walker_Nav_Menu()
            ));
            ?>
        </nav>
        
        <div class="header_right_section">
            <div class="header_right_inner">
                <!-- Botón de búsqueda -->
                <a href="#" class="header_search_icon">
                    <i class="fa fa-search"></i>
                </a>
                
                <!-- Carrito -->
                <?php if (function_exists('WC')): ?>
                    <?php planandino_shop_cart_link(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

<?php if ( $_hero_enable && $_hero_image ) : ?>
<!-- Hero image full-width -->
<div class="planandino-hero" style="height:<?php echo esc_attr( $_hero_height ); ?>px; background-image:url('<?php echo esc_url( $_hero_image ); ?>'); background-size:cover; background-position:center; position:relative;">
    <div class="hero-overlay" style="position:absolute;inset:0;background:<?php echo esc_attr( $_hero_overlay ); ?>;"></div>
    <?php if ( $_hero_title ) : ?>
    <div class="hero-content" style="position:relative;z-index:1;display:flex;align-items:center;justify-content:center;height:100%;">
        <h2 class="hero-title" style="color:#fff;margin:0;text-align:center;"><?php echo esc_html( $_hero_title ); ?></h2>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>

<!-- Formulario de búsqueda oculto -->
<div class="search_form_overlay">
    <div class="search_form_container">
        <form role="search" method="get" class="search_form" action="<?php echo home_url('/'); ?>">
            <input type="text" name="s" placeholder="<?php _e('Buscar productos...', 'planandino-shop'); ?>" class="search_field">
            <input type="hidden" name="post_type" value="product">
            <button type="submit" class="search_submit">
                <i class="fa fa-search"></i>
            </button>
        </form>
        <a href="#" class="search_close">
            <i class="fa fa-times"></i>
        </a>
    </div>
</div>

<!-- Botón back to top (igual al Bridge) -->
<a id="back_to_top" href="#" style="display: none;">
    <span class="fa-stack">
        <i class="qode_icon_font_awesome fa fa-arrow-up"></i>
    </span>
</a>

<?php // Walker definido en functions.php ?>