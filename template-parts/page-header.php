<?php
/**
 * Template part for displaying page headers
 * 
 * @package PlanAndino_Shop
 */

$show_breadcrumb = get_theme_mod('show_breadcrumb', true);
?>

<div class="page-header">
    <div class="container">
        
        <div class="page-header-content">
            
            <?php if (is_shop() || is_product_category() || is_product_tag()) : ?>
                <!-- Shop/Category Header -->
                <h1 class="page-title">
                    <?php 
                    if (is_shop()) {
                        echo esc_html_e('Nuestra Tienda', 'planandino-shop');
                    } elseif (is_product_category()) {
                        single_cat_title();
                    } elseif (is_product_tag()) {
                        single_tag_title();
                    }
                    ?>
                </h1>
                
                <?php if (is_product_category() || is_product_tag()) : ?>
                    <div class="page-description">
                        <?php echo term_description(); ?>
                    </div>
                <?php endif; ?>
                
            <?php elseif (is_single() && is_product()) : ?>
                <!-- Single Product Header -->
                <div class="product-breadcrumb">
                    <?php if ($show_breadcrumb && function_exists('woocommerce_breadcrumb')) : ?>
                        <?php woocommerce_breadcrumb(); ?>
                    <?php endif; ?>
                </div>
                
            <?php elseif (is_search()) : ?>
                <!-- Search Results Header -->
                <h1 class="page-title">
                    <?php
                    printf(
                        esc_html__('Resultados de búsqueda para: %s', 'planandino-shop'),
                        '<span class="search-query">' . get_search_query() . '</span>'
                    );
                    ?>
                </h1>
                
                <div class="search-results-count">
                    <?php
                    global $wp_query;
                    if ($wp_query->found_posts) {
                        printf(
                            _n(
                                'Se encontró %d resultado',
                                'Se encontraron %d resultados',
                                $wp_query->found_posts,
                                'planandino-shop'
                            ),
                            $wp_query->found_posts
                        );
                    } else {
                        esc_html_e('No se encontraron resultados', 'planandino-shop');
                    }
                    ?>
                </div>
                
            <?php elseif (is_page()) : ?>
                <!-- Regular Page Header -->
                <h1 class="page-title"><?php the_title(); ?></h1>
                
                <?php if (has_excerpt()) : ?>
                    <div class="page-description">
                        <?php the_excerpt(); ?>
                    </div>
                <?php endif; ?>
                
            <?php elseif (is_home() && !is_front_page()) : ?>
                <!-- Blog Page Header -->
                <h1 class="page-title">
                    <?php echo esc_html(get_the_title(get_option('page_for_posts'))); ?>
                </h1>
                
            <?php elseif (is_archive()) : ?>
                <!-- Archive Header -->
                <div class="archive-header">
                    <?php the_archive_title('<h1 class="page-title">', '</h1>'); ?>
                    <?php the_archive_description('<div class="archive-description">', '</div>'); ?>
                </div>
                
            <?php else : ?>
                <!-- Default Header -->
                <h1 class="page-title">
                    <?php 
                    if (is_home()) {
                        esc_html_e('Blog', 'planandino-shop');
                    } else {
                        the_title();
                    }
                    ?>
                </h1>
            <?php endif; ?>
            
        </div>
        
        <?php if ($show_breadcrumb && !is_single()) : ?>
            <div class="breadcrumb-wrapper">
                <?php planandino_shop_breadcrumb(); ?>
            </div>
        <?php endif; ?>
        
    </div>
</div>

<?php
/**
 * Custom breadcrumb function
 */
function planandino_shop_breadcrumb() {
    if (is_front_page()) {
        return;
    }
    
    $separator = ' <span class="separator">/</span> ';
    $home_title = esc_html__('Inicio', 'planandino-shop');
    
    echo '<nav class="breadcrumb-navigation" aria-label="' . esc_attr__('Breadcrumb', 'planandino-shop') . '">';
    echo '<ol class="breadcrumb">';
    
    // Home link
    echo '<li class="breadcrumb-item"><a href="' . esc_url(home_url('/')) . '">' . $home_title . '</a></li>';
    
    if (is_shop()) {
        echo '<li class="breadcrumb-item active">' . esc_html__('Tienda', 'planandino-shop') . '</li>';
        
    } elseif (is_product_category()) {
        echo '<li class="breadcrumb-item"><a href="' . esc_url(wc_get_page_permalink('shop')) . '">' . esc_html__('Tienda', 'planandino-shop') . '</a></li>';
        
        $current_cat = get_queried_object();
        $ancestors = get_ancestors($current_cat->term_id, 'product_cat');
        $ancestors = array_reverse($ancestors);
        
        foreach ($ancestors as $ancestor) {
            $ancestor_cat = get_term($ancestor, 'product_cat');
            echo '<li class="breadcrumb-item"><a href="' . esc_url(get_term_link($ancestor_cat)) . '">' . esc_html($ancestor_cat->name) . '</a></li>';
        }
        
        echo '<li class="breadcrumb-item active">' . esc_html($current_cat->name) . '</li>';
        
    } elseif (is_product()) {
        echo '<li class="breadcrumb-item"><a href="' . esc_url(wc_get_page_permalink('shop')) . '">' . esc_html__('Tienda', 'planandino-shop') . '</a></li>';
        
        $product_cats = get_the_terms(get_the_ID(), 'product_cat');
        if ($product_cats && !is_wp_error($product_cats)) {
            $main_cat = array_shift($product_cats);
            $ancestors = get_ancestors($main_cat->term_id, 'product_cat');
            $ancestors = array_reverse($ancestors);
            
            foreach ($ancestors as $ancestor) {
                $ancestor_cat = get_term($ancestor, 'product_cat');
                echo '<li class="breadcrumb-item"><a href="' . esc_url(get_term_link($ancestor_cat)) . '">' . esc_html($ancestor_cat->name) . '</a></li>';
            }
            
            echo '<li class="breadcrumb-item"><a href="' . esc_url(get_term_link($main_cat)) . '">' . esc_html($main_cat->name) . '</a></li>';
        }
        
        echo '<li class="breadcrumb-item active">' . get_the_title() . '</li>';
        
    } elseif (is_page()) {
        $ancestors = get_post_ancestors(get_the_ID());
        $ancestors = array_reverse($ancestors);
        
        foreach ($ancestors as $ancestor) {
            echo '<li class="breadcrumb-item"><a href="' . esc_url(get_permalink($ancestor)) . '">' . get_the_title($ancestor) . '</a></li>';
        }
        
        echo '<li class="breadcrumb-item active">' . get_the_title() . '</li>';
        
    } elseif (is_single()) {
        $categories = get_the_category();
        if ($categories) {
            $main_cat = $categories[0];
            echo '<li class="breadcrumb-item"><a href="' . esc_url(get_category_link($main_cat)) . '">' . esc_html($main_cat->name) . '</a></li>';
        }
        
        echo '<li class="breadcrumb-item active">' . get_the_title() . '</li>';
        
    } elseif (is_search()) {
        echo '<li class="breadcrumb-item active">' . esc_html__('Búsqueda', 'planandino-shop') . '</li>';
        
    } elseif (is_category()) {
        $current_cat = get_queried_object();
        echo '<li class="breadcrumb-item active">' . esc_html($current_cat->name) . '</li>';
        
    } elseif (is_tag()) {
        $current_tag = get_queried_object();
        echo '<li class="breadcrumb-item active">' . esc_html($current_tag->name) . '</li>';
        
    } elseif (is_archive()) {
        echo '<li class="breadcrumb-item active">' . get_the_archive_title() . '</li>';
    }
    
    echo '</ol>';
    echo '</nav>';
}
?>

<style>
/* Estilos específicos para page-header.php */
.page-header {
    background: linear-gradient(135deg, rgba(230, 174, 72, 0.1) 0%, rgba(230, 174, 72, 0.05) 100%);
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    padding: 40px 0 30px;
    margin-bottom: 40px;
}

.page-header-content {
    text-align: center;
    margin-bottom: 20px;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #333;
    margin: 0 0 15px 0;
    line-height: 1.2;
}

.page-description {
    font-size: 1.1rem;
    color: #666;
    line-height: 1.6;
    max-width: 600px;
    margin: 0 auto;
}

.search-query {
    color: #e6ae48;
    font-weight: 600;
}

.search-results-count {
    color: #999;
    font-size: 14px;
    margin-top: 10px;
}

.archive-description {
    margin-top: 15px;
}

.archive-description p {
    margin-bottom: 15px;
    color: #666;
    font-size: 1.1rem;
    line-height: 1.6;
}

/* Breadcrumb styles */
.breadcrumb-wrapper {
    display: flex;
    justify-content: center;
}

.breadcrumb-navigation {
    background: rgba(255, 255, 255, 0.8);
    padding: 12px 20px;
    border-radius: 25px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.breadcrumb {
    display: flex;
    align-items: center;
    list-style: none;
    margin: 0;
    padding: 0;
    font-size: 14px;
}

.breadcrumb-item {
    display: flex;
    align-items: center;
}

.breadcrumb-item:not(:last-child)::after {
    content: '/';
    margin: 0 8px;
    color: #ccc;
}

.breadcrumb-item a {
    color: #666;
    text-decoration: none;
    transition: color 0.3s ease;
}

.breadcrumb-item a:hover {
    color: #e6ae48;
}

.breadcrumb-item.active {
    color: #333;
    font-weight: 500;
}

/* Product breadcrumb específico */
.product-breadcrumb {
    margin-bottom: 20px;
}

.product-breadcrumb .woocommerce-breadcrumb {
    background: rgba(255, 255, 255, 0.9);
    padding: 10px 20px;
    border-radius: 20px;
    font-size: 13px;
    color: #666;
    text-align: center;
    backdrop-filter: blur(5px);
}

.product-breadcrumb .woocommerce-breadcrumb a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.product-breadcrumb .woocommerce-breadcrumb a:hover {
    color: #e6ae48;
}

/* Responsive */
@media (max-width: 768px) {
    .page-header {
        padding: 30px 0 25px;
        margin-bottom: 30px;
    }
    
    .page-title {
        font-size: 2rem;
    }
    
    .page-description {
        font-size: 1rem;
        padding: 0 15px;
    }
    
    .breadcrumb-navigation {
        padding: 10px 15px;
        margin: 0 15px;
    }
    
    .breadcrumb {
        font-size: 13px;
        flex-wrap: wrap;
        justify-content: center;
        gap: 4px;
    }
    
    .breadcrumb-item:not(:last-child)::after {
        margin: 0 6px;
    }
}

@media (max-width: 480px) {
    .page-header {
        padding: 25px 0 20px;
        margin-bottom: 25px;
    }
    
    .page-title {
        font-size: 1.6rem;
        line-height: 1.3;
    }
    
    .page-description {
        font-size: 0.95rem;
    }
    
    .breadcrumb {
        font-size: 12px;
    }
    
    .product-breadcrumb .woocommerce-breadcrumb {
        padding: 8px 15px;
        font-size: 12px;
        margin: 0 10px;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .page-header {
        background: linear-gradient(135deg, rgba(230, 174, 72, 0.15) 0%, rgba(230, 174, 72, 0.08) 100%);
    }
    
    .breadcrumb-navigation {
        background: rgba(0, 0, 0, 0.6);
        border-color: rgba(255, 255, 255, 0.1);
    }
}

/* Print styles */
@media print {
    .page-header {
        background: none;
        border-bottom: 1px solid #ccc;
        padding: 20px 0 10px;
        margin-bottom: 20px;
    }
    
    .breadcrumb-navigation {
        display: none;
    }
}
</style>