<?php
/**
 * The shop sidebar containing the main shop widget area
 * 
 * @package PlanAndino_Shop
 */

if (!is_active_sidebar('shop-sidebar')) {
    return;
}
?>

<aside id="secondary" class="shop-sidebar widget-area">
    
    <!-- Filtros de búsqueda -->
    <div class="sidebar-section search-section">
        <h3 class="widget-title"><?php esc_html_e('Buscar Productos', 'planandino-shop'); ?></h3>
        <form role="search" method="get" class="woocommerce-product-search" action="<?php echo esc_url(home_url('/')); ?>">
            <input type="search" id="woocommerce-product-search-field" class="search-field" placeholder="<?php esc_attr_e('Buscar productos...', 'planandino-shop'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
            <input type="hidden" name="post_type" value="product" />
            <button type="submit" class="search-submit">
                <i class="fa fa-search"></i>
            </button>
        </form>
    </div>
    
    <?php
    // Mostrar widgets dinámicos
    dynamic_sidebar('shop-sidebar');
    
    // Si no hay widgets, mostrar algunos por defecto
    if (!dynamic_sidebar('shop-sidebar')) :
    ?>
    
    <!-- Filtro por categorías -->
    <div class="widget widget_product_categories">
        <h3 class="widget-title"><?php esc_html_e('Categorías', 'planandino-shop'); ?></h3>
        <?php
        $categories = get_terms(array(
            'taxonomy' => 'product_cat',
            'hide_empty' => true,
            'parent' => 0
        ));
        
        if (!empty($categories) && !is_wp_error($categories)) :
        ?>
        <ul class="product-categories">
            <?php foreach ($categories as $category) : ?>
                <li class="cat-item">
                    <a href="<?php echo esc_url(get_term_link($category)); ?>">
                        <?php echo esc_html($category->name); ?>
                        <span class="count">(<?php echo esc_html($category->count); ?>)</span>
                    </a>
                    
                    <?php
                    // Mostrar subcategorías
                    $subcategories = get_terms(array(
                        'taxonomy' => 'product_cat',
                        'hide_empty' => true,
                        'parent' => $category->term_id
                    ));
                    
                    if (!empty($subcategories)) :
                    ?>
                    <ul class="children">
                        <?php foreach ($subcategories as $subcategory) : ?>
                            <li class="cat-item">
                                <a href="<?php echo esc_url(get_term_link($subcategory)); ?>">
                                    <?php echo esc_html($subcategory->name); ?>
                                    <span class="count">(<?php echo esc_html($subcategory->count); ?>)</span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>
    
    <!-- Filtro por precio -->
    <div class="widget widget_price_filter">
        <h3 class="widget-title"><?php esc_html_e('Filtrar por precio', 'planandino-shop'); ?></h3>
        
        <?php
        global $wpdb;
        $min_price = (float) $wpdb->get_var( "SELECT MIN(meta_value+0) FROM {$wpdb->postmeta} WHERE meta_key = '_price' AND meta_value != ''" );
        $max_price = (float) $wpdb->get_var( "SELECT MAX(meta_value+0) FROM {$wpdb->postmeta} WHERE meta_key = '_price' AND meta_value != ''" );
        if ( ! $min_price ) $min_price = 0;
        if ( ! $max_price ) $max_price = 100000;
        $current_min = isset( $_GET['min_price'] ) ? (float) $_GET['min_price'] : $min_price;
        $current_max = isset( $_GET['max_price'] ) ? (float) $_GET['max_price'] : $max_price;
        ?>
        
        <form method="get" action="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">
            <div class="price-filter-wrapper">
                <div class="price-input">
                    <div class="field">
                        <span><?php esc_html_e('Min', 'planandino-shop'); ?></span>
                        <input type="number" class="input-min" name="min_price" value="<?php echo esc_attr($current_min); ?>" min="<?php echo esc_attr($min_price); ?>" max="<?php echo esc_attr($max_price); ?>">
                    </div>
                    <div class="separator">-</div>
                    <div class="field">
                        <span><?php esc_html_e('Max', 'planandino-shop'); ?></span>
                        <input type="number" class="input-max" name="max_price" value="<?php echo esc_attr($current_max); ?>" min="<?php echo esc_attr($min_price); ?>" max="<?php echo esc_attr($max_price); ?>">
                    </div>
                </div>
                <div class="slider">
                    <div class="progress"></div>
                </div>
                <div class="range-input">
                    <input type="range" class="range-min" min="<?php echo esc_attr($min_price); ?>" max="<?php echo esc_attr($max_price); ?>" value="<?php echo esc_attr($current_min); ?>">
                    <input type="range" class="range-max" min="<?php echo esc_attr($min_price); ?>" max="<?php echo esc_attr($max_price); ?>" value="<?php echo esc_attr($current_max); ?>">
                </div>
            </div>
            
            <button type="submit" class="price-filter-button">
                <?php esc_html_e('Filtrar', 'planandino-shop'); ?>
            </button>
            
            <?php wc_query_string_form_fields(null, array('min_price', 'max_price', 'paged'), '', true); ?>
        </form>
    </div>
    
    <!-- Tags de productos -->
    <div class="widget widget_product_tag_cloud">
        <h3 class="widget-title"><?php esc_html_e('Etiquetas de producto', 'planandino-shop'); ?></h3>
        <?php
        $tags = get_terms(array(
            'taxonomy' => 'product_tag',
            'hide_empty' => true,
            'number' => 20
        ));
        
        if (!empty($tags) && !is_wp_error($tags)) :
        ?>
        <div class="tagcloud">
            <?php foreach ($tags as $tag) : ?>
                <a href="<?php echo esc_url(get_term_link($tag)); ?>" class="tag-cloud-link" style="font-size: <?php echo rand(12, 18); ?>px;">
                    <?php echo esc_html($tag->name); ?>
                </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- Productos destacados -->
    <div class="widget widget_featured_products">
        <h3 class="widget-title"><?php esc_html_e('Productos Destacados', 'planandino-shop'); ?></h3>
        
        <?php
        $featured_products = wc_get_featured_product_ids();
        
        if (!empty($featured_products)) :
            $args = array(
                'post_type' => 'product',
                'post__in' => array_slice($featured_products, 0, 3),
                'orderby' => 'post__in'
            );
            
            $featured_query = new WP_Query($args);
            
            if ($featured_query->have_posts()) :
        ?>
        <ul class="featured-products-list">
            <?php while ($featured_query->have_posts()) : $featured_query->the_post(); ?>
                <?php global $product; ?>
                <li class="featured-product-item">
                    <a href="<?php echo esc_url(get_permalink()); ?>" class="featured-product-link">
                        <div class="featured-product-image">
                            <?php echo woocommerce_get_product_thumbnail('thumbnail'); ?>
                        </div>
                        <div class="featured-product-info">
                            <h4 class="featured-product-title"><?php echo get_the_title(); ?></h4>
                            <span class="featured-product-price"><?php echo $product->get_price_html(); ?></span>
                        </div>
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>
        <?php
            wp_reset_postdata();
            endif;
        endif;
        ?>
    </div>
    
    <?php endif; ?>
    
</aside>

<style>
/* Estilos específicos para sidebar-shop.php */
.shop-sidebar {
    background: white;
    border-radius: 8px;
    padding: 0;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
}

.shop-sidebar .widget {
    margin-bottom: 0;
    padding: 25px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.shop-sidebar .widget:last-child {
    border-bottom: none;
}

.shop-sidebar .widget-title {
    font-size: 18px;
    font-weight: 600;
    color: #333;
    margin: 0 0 20px 0;
    padding-bottom: 10px;
    border-bottom: 2px solid #e6ae48;
    position: relative;
}

.shop-sidebar .widget-title::before {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 30px;
    height: 2px;
    background: #e6ae48;
}

/* Búsqueda de productos */
.search-section .woocommerce-product-search {
    display: flex;
    border: 1px solid #ddd;
    border-radius: 5px;
    overflow: hidden;
}

.search-section .search-field {
    flex: 1;
    padding: 12px 15px;
    border: none;
    font-size: 14px;
}

.search-section .search-field:focus {
    outline: none;
}

.search-section .search-submit {
    background: #e6ae48;
    border: none;
    padding: 12px 15px;
    color: white;
    cursor: pointer;
    transition: background 0.3s ease;
}

.search-section .search-submit:hover {
    background: #d19b3e;
}

/* Categorías de productos */
.product-categories {
    list-style: none;
    margin: 0;
    padding: 0;
}

.product-categories .cat-item {
    margin-bottom: 12px;
}

.product-categories .cat-item:last-child {
    margin-bottom: 0;
}

.product-categories .cat-item a {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    color: #666;
    text-decoration: none;
    transition: color 0.3s ease;
    font-size: 14px;
}

.product-categories .cat-item a:hover {
    color: #e6ae48;
}

.product-categories .count {
    font-size: 12px;
    color: #999;
    font-weight: 500;
}

.product-categories .children {
    list-style: none;
    margin: 8px 0 0 15px;
    padding: 0;
}

.product-categories .children .cat-item a {
    font-size: 13px;
    padding: 6px 0;
}

/* Filtro de precio */
.price-filter-wrapper {
    margin-bottom: 20px;
}

.price-input {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
}

.price-input .field {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.price-input .field span {
    font-size: 12px;
    color: #666;
    margin-bottom: 5px;
}

.price-input .field input {
    width: 70px;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    text-align: center;
    font-size: 14px;
}

.price-input .separator {
    color: #666;
    font-weight: 500;
}

.slider {
    position: relative;
    height: 5px;
    background: #ddd;
    border-radius: 5px;
    margin-bottom: 10px;
}

.slider .progress {
    height: 5px;
    left: 25%;
    right: 25%;
    position: absolute;
    border-radius: 5px;
    background: #e6ae48;
}

.range-input {
    position: relative;
}

.range-input input {
    position: absolute;
    width: 100%;
    height: 5px;
    top: -5px;
    background: none;
    pointer-events: none;
    -webkit-appearance: none;
    -moz-appearance: none;
}

.range-input input::-webkit-slider-thumb {
    height: 20px;
    width: 20px;
    border-radius: 50%;
    background: #e6ae48;
    pointer-events: auto;
    -webkit-appearance: none;
    box-shadow: 0 0 6px rgba(0, 0, 0, 0.15);
}

.range-input input::-moz-range-thumb {
    height: 20px;
    width: 20px;
    border-radius: 50%;
    background: #e6ae48;
    pointer-events: auto;
    -moz-appearance: none;
    border: none;
}

.price-filter-button {
    width: 100%;
    background: #e6ae48;
    color: white;
    border: none;
    padding: 12px;
    border-radius: 5px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s ease;
}

.price-filter-button:hover {
    background: #d19b3e;
}

/* Tag cloud */
.tagcloud {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.tag-cloud-link {
    background: rgba(230, 174, 72, 0.1);
    color: #e6ae48;
    padding: 4px 12px;
    border-radius: 15px;
    text-decoration: none;
    font-size: 12px;
    font-weight: 500;
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.tag-cloud-link:hover {
    background: #e6ae48;
    color: white;
    border-color: #e6ae48;
}

/* Productos destacados */
.featured-products-list {
    list-style: none;
    margin: 0;
    padding: 0;
}

.featured-product-item {
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.featured-product-item:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.featured-product-link {
    display: flex;
    gap: 12px;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
}

.featured-product-link:hover {
    color: #e6ae48;
}

.featured-product-image {
    flex-shrink: 0;
    width: 60px;
    height: 60px;
    border-radius: 5px;
    overflow: hidden;
}

.featured-product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.featured-product-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.featured-product-title {
    font-size: 14px;
    font-weight: 500;
    margin: 0 0 5px 0;
    line-height: 1.3;
}

.featured-product-price {
    font-size: 13px;
    color: #e6ae48;
    font-weight: 600;
}

/* Responsive */
@media (max-width: 992px) {
    .shop-sidebar .widget {
        padding: 20px;
    }
}

@media (max-width: 768px) {
    .shop-sidebar {
        margin-bottom: 30px;
    }
    
    .shop-sidebar .widget {
        padding: 15px;
    }
    
    .price-input .field input {
        width: 60px;
        padding: 6px;
    }
}
</style>