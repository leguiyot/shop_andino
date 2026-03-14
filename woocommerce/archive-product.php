<?php
/**
 * The template for displaying product archives (shop page)
 * 
 * @package PlanAndino_Shop
 */

get_header(); ?>

<div class="content">
    <div class="content_inner">
        <div class="column1">
            <div class="column_inner">

                <?php if ( have_posts() ) : ?>

                    <?php
                    /**
                     * Hook: woocommerce_before_shop_loop
                     * Incluye automáticamente: avisos, conteo de resultados y ordenamiento.
                     * NO duplicar manualmente woocommerce_result_count() ni woocommerce_catalog_ordering().
                     */
                    do_action( 'woocommerce_before_shop_loop' );
                    ?>

                    <?php woocommerce_product_loop_start(); ?>

                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php wc_get_template_part( 'content', 'product' ); ?>
                    <?php endwhile; ?>

                    <?php woocommerce_product_loop_end(); ?>

                    <?php
                    /**
                     * Hook: woocommerce_after_shop_loop
                     * Incluye paginación automáticamente.
                     */
                    do_action( 'woocommerce_after_shop_loop' );
                    ?>

                <?php else : ?>

                    <?php do_action( 'woocommerce_no_products_found' ); ?>

                <?php endif; ?>

            </div><!-- .column_inner -->
        </div><!-- .column1 -->

<?php get_footer(); ?>