<?php
/**
 * Plan Andino Shop - Page Template
 * 
 * @package PlanAndinoShop
 */

get_header(); ?>

<?php while (have_posts()): the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="entry-header">
            <h1 class="entry-title"><?php the_title(); ?></h1>
        </header>

        <div class="entry-content">
            <?php if (has_post_thumbnail()): ?>
                <div class="page-thumbnail">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>
            
            <?php the_content(); ?>
            
            <?php
            wp_link_pages(array(
                'before' => '<div class="page-links">' . __('Páginas:', 'planandino-shop'),
                'after'  => '</div>',
            ));
            ?>
        </div>

        <?php if (comments_open() || get_comments_number()): ?>
            <div class="comments-section">
                <?php comments_template(); ?>
            </div>
        <?php endif; ?>
    </article>
<?php endwhile; ?>

<?php get_footer(); ?>