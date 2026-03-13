<?php
/**
 * Plan Andino Shop - Index Template
 * 
 * @package PlanAndinoShop
 */

get_header(); ?>

<?php if (have_posts()): ?>
    <div class="blog-posts">
        <?php while (have_posts()): the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h2 class="entry-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    
                    <div class="entry-meta">
                        <span class="posted-on">
                            <?php echo get_the_date(); ?>
                        </span>
                        <span class="byline">
                            <?php _e('por', 'planandino-shop'); ?> 
                            <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                <?php the_author(); ?>
                            </a>
                        </span>
                    </div>
                </header>

                <div class="entry-content">
                    <?php if (has_post_thumbnail()): ?>
                        <div class="post-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium'); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <?php the_excerpt(); ?>
                    
                    <a href="<?php the_permalink(); ?>" class="read-more-link">
                        <?php _e('Leer más', 'planandino-shop'); ?>
                    </a>
                </div>
            </article>
        <?php endwhile; ?>
        
        <div class="pagination">
            <?php
            the_posts_pagination(array(
                'prev_text' => '<i class="fa fa-angle-left"></i>',
                'next_text' => '<i class="fa fa-angle-right"></i>',
            ));
            ?>
        </div>
    </div>
<?php else: ?>
    <div class="no-content">
        <h2><?php _e('No se encontró contenido', 'planandino-shop'); ?></h2>
        <p><?php _e('Lo sentimos, no hay contenido disponible en este momento.', 'planandino-shop'); ?></p>
    </div>
<?php endif; ?>

<?php get_footer(); ?>