<?php
/**
 * The template for displaying product archives (shop page)
 * 
 * @package PlanAndino_Shop
 */

get_header(); ?>

<div class="container">
    <main class="shop-page">
        
        <?php if (have_posts()) : ?>
        
            <div class="shop-content">
                
                <?php
                /**
                 * Hook: woocommerce_before_shop_loop
                 */
                do_action('woocommerce_before_shop_loop');
                ?>
                
                <div class="shop-toolbar">
                    <div class="results-count">
                        <?php woocommerce_result_count(); ?>
                    </div>
                    <div class="shop-ordering">
                        <?php woocommerce_catalog_ordering(); ?>
                    </div>
                </div>
                
                <?php woocommerce_product_loop_start(); ?>
                
                <?php while (have_posts()) : the_post(); ?>
                    <?php
                    /**
                     * Hook: woocommerce_shop_loop
                     */
                    do_action('woocommerce_shop_loop');
                    
                    wc_get_template_part('content', 'product');
                    ?>
                <?php endwhile; ?>
                
                <?php woocommerce_product_loop_end(); ?>
                
                <?php
                /**
                 * Hook: woocommerce_after_shop_loop
                 */
                do_action('woocommerce_after_shop_loop');
                ?>
                
                <?php woocommerce_pagination(); ?>
                
            </div>
            
        <?php else : ?>
            
            <div class="no-products-found">
                <h2><?php esc_html_e('No se encontraron productos', 'planandino-shop'); ?></h2>
                <p><?php esc_html_e('No hay productos que coincidan con tu búsqueda.', 'planandino-shop'); ?></p>
                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="button">
                    <?php esc_html_e('Ver todos los productos', 'planandino-shop'); ?>
                </a>
            </div>
            
        <?php endif; ?>
        
        <?php get_sidebar('shop'); ?>
        
    </main>
</div>

<style>
/* Estilos específicos para archive-product.php */
.shop-page {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 40px;
    margin: 40px 0;
}

.shop-content {
    min-width: 0; /* Previene overflow en CSS Grid */
}

.shop-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding: 15px 20px;
    background: rgba(0, 0, 0, 0.02);
    border-radius: 5px;
}

.results-count {
    color: #666;
    font-size: 14px;
}

.shop-ordering {
    display: flex;
    align-items: center;
    gap: 10px;
}

.shop-ordering select {
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background: white;
    color: #333;
    font-size: 14px;
}

.shop-ordering select:focus {
    outline: none;
    border-color: #e6ae48;
}

.no-products-found {
    text-align: center;
    padding: 60px 20px;
    grid-column: 1 / -1;
}

.no-products-found h2 {
    font-size: 1.8rem;
    color: #333;
    margin-bottom: 15px;
}

.no-products-found p {
    color: #666;
    margin-bottom: 25px;
    font-size: 16px;
}

.no-products-found .button {
    background: #e6ae48;
    color: white;
    padding: 12px 25px;
    text-decoration: none;
    border-radius: 5px;
    display: inline-block;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.no-products-found .button:hover {
    background: #d19b3e;
    transform: translateY(-2px);
}

/* Responsive */
@media (max-width: 992px) {
    .shop-page {
        grid-template-columns: 1fr;
        gap: 30px;
    }
}

@media (max-width: 768px) {
    .shop-toolbar {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
    
    .shop-toolbar .results-count {
        order: 2;
    }
    
    .shop-ordering {
        order: 1;
    }
}
</style>

<?php get_footer(); ?>