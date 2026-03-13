<?php
/**
 * The template for displaying single products
 * 
 * @package PlanAndino_Shop
 */

get_header(); ?>

<div class="container">
    
    <?php wc_print_notices(); ?>
    
    <?php while (have_posts()) : the_post(); ?>
    
        <article id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>
            
            <?php
            /**
             * Hook: woocommerce_before_single_product
             */
            do_action('woocommerce_before_single_product');
            
            if (post_password_required()) {
                echo get_the_password_form();
                return;
            }
            ?>
            
            <div class="single-product-wrapper">
                
                <nav class="woocommerce-breadcrumb">
                    <?php woocommerce_breadcrumb(); ?>
                </nav>
                
                <div class="product-main">
                    
                    <div class="product-images">
                        <?php
                        /**
                         * Hook: woocommerce_before_single_product_summary
                         */
                        do_action('woocommerce_before_single_product_summary');
                        ?>
                    </div>
                    
                    <div class="product-summary">
                        <?php
                        /**
                         * Hook: woocommerce_single_product_summary
                         */
                        do_action('woocommerce_single_product_summary');
                        ?>
                    </div>
                    
                </div>
                
                <?php
                /**
                 * Hook: woocommerce_after_single_product_summary
                 */
                do_action('woocommerce_after_single_product_summary');
                ?>
                
            </div>
            
        </article>
    
    <?php endwhile; ?>
    
</div>

<style>
/* Estilos específicos para single-product.php */
.single-product-wrapper {
    margin: 40px 0;
}

.woocommerce-breadcrumb {
    background: rgba(0, 0, 0, 0.02);
    padding: 15px 20px;
    border-radius: 5px;
    margin-bottom: 30px;
    font-size: 14px;
    color: #666;
}

.woocommerce-breadcrumb a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.woocommerce-breadcrumb a:hover {
    color: #e6ae48;
}

.product-main {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    margin-bottom: 50px;
}

.product-images {
    position: relative;
}

.product-summary {
    padding-left: 20px;
}

/* Product images */
.woocommerce-product-gallery {
    position: relative;
    margin-bottom: 0;
}

.woocommerce-product-gallery__wrapper {
    position: relative;
}

.woocommerce-product-gallery img {
    width: 100%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.woocommerce-product-gallery img:hover {
    transform: scale(1.02);
}

/* Gallery thumbnails */
.flex-control-thumbs {
    display: flex;
    gap: 10px;
    margin-top: 15px;
    list-style: none;
    margin-left: 0;
    padding-left: 0;
}

.flex-control-thumbs li {
    width: 80px;
    height: 80px;
    overflow: hidden;
    border-radius: 5px;
    cursor: pointer;
    transition: opacity 0.3s ease;
}

.flex-control-thumbs li:hover {
    opacity: 0.7;
}

.flex-control-thumbs li.flex-active-slide {
    opacity: 1;
    box-shadow: 0 0 0 2px #e6ae48;
}

.flex-control-thumbs img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 5px;
}

/* Product title */
.product_title {
    font-size: 2rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 15px;
    line-height: 1.3;
}

/* Product price */
.price {
    font-size: 1.5rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 20px;
}

.price del {
    color: #999;
    font-weight: 400;
    margin-right: 10px;
    text-decoration: line-through;
}

.price ins {
    color: #e6ae48;
    text-decoration: none;
    font-weight: 600;
}

/* Product description */
.woocommerce-product-details__short-description {
    color: #666;
    line-height: 1.6;
    margin-bottom: 25px;
}

.woocommerce-product-details__short-description p {
    margin-bottom: 15px;
}

/* Product form */
form.cart {
    margin-bottom: 30px;
}

.cart {
    display: flex;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
}

/* Stock status */
.stock {
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 15px;
}

.in-stock {
    color: #28a745;
}

.out-of-stock {
    color: #dc3545;
}

/* Sale badge */
.onsale {
    position: absolute;
    top: 15px;
    right: 15px;
    background: #e6ae48;
    color: white;
    padding: 8px 15px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    z-index: 10;
}

/* Product meta */
.product_meta {
    border-top: 1px solid rgba(0, 0, 0, 0.1);
    padding-top: 25px;
    margin-top: 30px;
    color: #666;
    font-size: 14px;
}

.product_meta > span {
    display: block;
    margin-bottom: 8px;
}

.product_meta a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.product_meta a:hover {
    color: #e6ae48;
}

/* Product tabs */
.woocommerce-tabs {
    margin-top: 50px;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
    padding-top: 50px;
}

.woocommerce-tabs ul.tabs {
    display: flex;
    gap: 0;
    list-style: none;
    margin: 0 0 30px 0;
    padding: 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.woocommerce-tabs ul.tabs li {
    margin: 0;
    padding: 0;
}

.woocommerce-tabs ul.tabs li a {
    display: block;
    padding: 15px 25px;
    color: #666;
    text-decoration: none;
    border-bottom: 2px solid transparent;
    transition: all 0.3s ease;
    font-weight: 500;
}

.woocommerce-tabs ul.tabs li.active a,
.woocommerce-tabs ul.tabs li a:hover {
    color: #e6ae48;
    border-bottom-color: #e6ae48;
}

.woocommerce-tabs .panel {
    padding: 0;
    color: #666;
    line-height: 1.6;
}

.woocommerce-tabs .panel h2 {
    color: #333;
    font-size: 1.5rem;
    margin-bottom: 20px;
}

.woocommerce-tabs .panel p {
    margin-bottom: 15px;
}

/* Related products */
.related.products {
    margin-top: 60px;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
    padding-top: 60px;
}

.related.products h2 {
    font-size: 1.8rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 30px;
    text-align: center;
}

.related.products ul.products {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
}

/* Reviews */
#reviews {
    margin-top: 20px;
}

#reviews h2 {
    color: #333;
    font-size: 1.5rem;
    margin-bottom: 25px;
}

/* Star rating */
.star-rating {
    color: #ffc107;
    font-size: 14px;
}

/* Responsive */
@media (max-width: 1024px) {
    .product-main {
        gap: 40px;
    }
    
    .product-summary {
        padding-left: 15px;
    }
    
    .related.products ul.products {
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
    }
}

@media (max-width: 768px) {
    .product-main {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .product-summary {
        padding-left: 0;
    }
    
    .product_title {
        font-size: 1.6rem;
    }
    
    .price {
        font-size: 1.3rem;
    }
    
    .cart {
        flex-direction: column;
        align-items: stretch;
        gap: 15px;
    }
    
    .woocommerce-tabs ul.tabs {
        flex-wrap: wrap;
    }
    
    .woocommerce-tabs ul.tabs li a {
        padding: 12px 20px;
        font-size: 14px;
    }
    
    .related.products ul.products {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    
    .woocommerce-breadcrumb {
        padding: 12px 15px;
        font-size: 13px;
    }
}

@media (max-width: 480px) {
    .flex-control-thumbs {
        gap: 8px;
    }
    
    .flex-control-thumbs li {
        width: 60px;
        height: 60px;
    }
    
    .product_title {
        font-size: 1.4rem;
    }
    
    .price {
        font-size: 1.2rem;
    }
    
    .related.products ul.products {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .related.products h2 {
        font-size: 1.5rem;
    }
}
</style>

<?php get_footer(); ?>