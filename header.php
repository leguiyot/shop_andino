<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="max-image-preview:large">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div class="side_menu_button" style="height:85px"></div>

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