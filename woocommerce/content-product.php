<?php
/**
 * The template for displaying product content within loops
 * 
 * @package PlanAndino_Shop
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

// Ensure visibility
if (empty($product) || !$product->is_visible()) {
    return;
}

// Store loop count we're currently on
if (empty($woocommerce_loop['loop'])) {
    $woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if (empty($woocommerce_loop['columns'])) {
    $woocommerce_loop['columns'] = apply_filters('loop_shop_columns', 4);
}

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if (0 === ($woocommerce_loop['loop'] - 1) % $woocommerce_loop['columns'] || 1 === $woocommerce_loop['columns']) {
    $classes[] = 'first';
}
if (0 === $woocommerce_loop['loop'] % $woocommerce_loop['columns']) {
    $classes[] = 'last';
}

?>
<li <?php wc_product_class($classes, $product); ?>>
    
    <div class="product-inner">
        
        <?php
        /**
         * Hook: woocommerce_before_shop_loop_item
         */
        do_action('woocommerce_before_shop_loop_item');
        ?>
        
        <div class="product-image">
            <?php
            /**
             * Hook: woocommerce_before_shop_loop_item_title
             */
            do_action('woocommerce_before_shop_loop_item_title');
            ?>
            
            <?php if ($product->is_on_sale()) : ?>
                <span class="onsale"><?php esc_html_e('¡Oferta!', 'planandino-shop'); ?></span>
            <?php endif; ?>
            
            <a href="<?php echo esc_url(get_permalink()); ?>" class="product-link">
                <?php
                echo woocommerce_get_product_thumbnail();
                ?>
                
                <!-- Imagen hover (segunda imagen de la galería) -->
                <?php
                $attachment_ids = $product->get_gallery_image_ids();
                if (!empty($attachment_ids)) {
                    echo wp_get_attachment_image($attachment_ids[0], 'woocommerce_thumbnail', false, array(
                        'class' => 'hover-image',
                        'alt' => get_the_title()
                    ));
                }
                ?>
            </a>
            
            <!-- Botones de acción rápida -->
            <div class="product-actions">
                <?php if (!$product->is_type('external')) : ?>
                    <button class="quick-view-button" data-product-id="<?php echo esc_attr($product->get_id()); ?>" title="<?php esc_attr_e('Vista rápida', 'planandino-shop'); ?>">
                        <i class="fa fa-eye"></i>
                    </button>
                <?php endif; ?>
                
                <button class="add-to-wishlist" data-product-id="<?php echo esc_attr($product->get_id()); ?>" title="<?php esc_attr_e('Agregar a lista de deseos', 'planandino-shop'); ?>">
                    <i class="fa fa-heart-o"></i>
                    <i class="fa fa-heart"></i>
                </button>
            </div>
            
        </div>
        
        <div class="product-info">
            
            <div class="product-categories">
                <?php 
                $categories = get_the_terms($product->get_id(), 'product_cat');
                if ($categories && !is_wp_error($categories)) {
                    $category = array_shift($categories);
                    echo '<a href="' . esc_url(get_term_link($category)) . '">' . esc_html($category->name) . '</a>';
                }
                ?>
            </div>
            
            <?php
            /**
             * Hook: woocommerce_shop_loop_item_title
             */
            do_action('woocommerce_shop_loop_item_title');
            ?>
            
            <h2 class="woocommerce-loop-product__title">
                <a href="<?php echo esc_url(get_permalink()); ?>">
                    <?php echo get_the_title(); ?>
                </a>
            </h2>
            
            <?php
            /**
             * Hook: woocommerce_after_shop_loop_item_title
             */
            do_action('woocommerce_after_shop_loop_item_title');
            ?>
            
            <div class="price-and-rating">
                <div class="price-wrapper">
                    <?php echo wc_price($product->get_price()); ?>
                </div>
                
                <?php if (wc_review_ratings_enabled()) : ?>
                    <div class="rating-wrapper">
                        <?php echo woocommerce_get_rating_html($product->get_average_rating()); ?>
                        <span class="review-count">
                            (<?php echo esc_html($product->get_review_count()); ?>)
                        </span>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="product-buttons">
                <?php
                /**
                 * Hook: woocommerce_after_shop_loop_item
                 */
                do_action('woocommerce_after_shop_loop_item');
                ?>
            </div>
            
        </div>
        
    </div>
    
</li>

<style>
/* Estilos específicos para content-product.php */
.products .product {
    position: relative;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
}

.products .product:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.product-inner {
    position: relative;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.product-image {
    position: relative;
    overflow: hidden;
    background: #f8f9fa;
    flex-shrink: 0;
}

.product-image img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-image .hover-image {
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product:hover .product-image .hover-image {
    opacity: 1;
}

.product:hover .product-image img:not(.hover-image) {
    transform: scale(1.05);
}

/* Sale badge */
.product-image .onsale {
    position: absolute;
    top: 10px;
    left: 10px;
    background: #e6ae48;
    color: white;
    padding: 5px 10px;
    border-radius: 15px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    z-index: 5;
}

/* Product actions */
.product-actions {
    position: absolute;
    top: 10px;
    right: 10px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    opacity: 0;
    transform: translateX(10px);
    transition: all 0.3s ease;
    z-index: 10;
}

.product:hover .product-actions {
    opacity: 1;
    transform: translateX(0);
}

.product-actions button {
    width: 40px;
    height: 40px;
    border: none;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.9);
    color: #666;
    font-size: 16px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.product-actions button:hover {
    background: #e6ae48;
    color: white;
    transform: scale(1.1);
}

.add-to-wishlist .fa-heart {
    display: none;
}

.add-to-wishlist.added .fa-heart-o {
    display: none;
}

.add-to-wishlist.added .fa-heart {
    display: block;
}

.add-to-wishlist.added {
    background: #e6ae48;
    color: white;
}

/* Product info */
.product-info {
    padding: 20px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.product-categories {
    margin-bottom: 10px;
}

.product-categories a {
    color: #999;
    text-decoration: none;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: color 0.3s ease;
}

.product-categories a:hover {
    color: #e6ae48;
}

.woocommerce-loop-product__title {
    margin: 0 0 15px 0;
    font-size: 16px;
    font-weight: 600;
    line-height: 1.4;
    flex-grow: 1;
}

.woocommerce-loop-product__title a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.woocommerce-loop-product__title a:hover {
    color: #e6ae48;
}

/* Price and rating */
.price-and-rating {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.price-wrapper .price {
    font-size: 18px;
    font-weight: 600;
    color: #333;
}

.price-wrapper .price del {
    color: #999;
    font-weight: 400;
    margin-right: 8px;
    font-size: 14px;
}

.price-wrapper .price ins {
    color: #e6ae48;
    text-decoration: none;
}

.rating-wrapper {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
}

.star-rating {
    color: #ffc107;
    font-size: 14px;
}

.review-count {
    color: #999;
}

/* Product buttons */
.product-buttons {
    margin-top: auto;
}

.product-buttons .button,
.product-buttons .add_to_cart_button {
    width: 100%;
    background: #333;
    color: white;
    border: none;
    padding: 12px;
    border-radius: 5px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    text-decoration: none;
    text-align: center;
    display: inline-block;
    transition: all 0.3s ease;
    font-size: 13px;
}

.product-buttons .button:hover,
.product-buttons .add_to_cart_button:hover {
    background: #e6ae48;
    transform: translateY(-2px);
}

.product-buttons .add_to_cart_button.loading {
    opacity: 0.7;
    pointer-events: none;
}

.product-buttons .add_to_cart_button.added {
    background: #28a745;
}

.product-buttons .add_to_cart_button.added:hover {
    background: #218838;
}

/* Out of stock styling */
.product.outofstock {
    opacity: 0.7;
}

.product.outofstock .product-image::after {
    content: 'Agotado';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.product.outofstock .add_to_cart_button {
    background: #6c757d;
    cursor: not-allowed;
}

.product.outofstock .add_to_cart_button:hover {
    background: #6c757d;
    transform: none;
}

/* Responsive */
@media (max-width: 768px) {
    .product-image img {
        height: 200px;
    }
    
    .product-info {
        padding: 15px;
    }
    
    .woocommerce-loop-product__title {
        font-size: 14px;
    }
    
    .price-wrapper .price {
        font-size: 16px;
    }
    
    .product-buttons .button,
    .product-buttons .add_to_cart_button {
        padding: 10px;
        font-size: 12px;
    }
}

@media (max-width: 480px) {
    .price-and-rating {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
    
    .product-actions button {
        width: 35px;
        height: 35px;
        font-size: 14px;
    }
}
</style>