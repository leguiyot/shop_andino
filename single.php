<?php
/**
 * Plan Andino Shop - Single Post Template
 * 
 * @package PlanAndinoShop
 */

get_header(); ?>

<?php while (have_posts()): the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="entry-header">
            <h1 class="entry-title"><?php the_title(); ?></h1>
            
            <div class="entry-meta">
                <span class="posted-on">
                    <i class="fa fa-calendar"></i>
                    <?php echo get_the_date(); ?>
                </span>
                <span class="byline">
                    <i class="fa fa-user"></i>
                    <?php _e('por', 'planandino-shop'); ?> 
                    <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                        <?php the_author(); ?>
                    </a>
                </span>
                <span class="cat-links">
                    <i class="fa fa-folder"></i>
                    <?php the_category(', '); ?>
                </span>
                <?php if (has_tag()): ?>
                    <span class="tag-links">
                        <i class="fa fa-tags"></i>
                        <?php the_tags('', ', '); ?>
                    </span>
                <?php endif; ?>
            </div>
        </header>

        <div class="entry-content">
            <?php if (has_post_thumbnail()): ?>
                <div class="post-thumbnail">
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

        <footer class="entry-footer">
            <?php
            $prev_post = get_previous_post();
            $next_post = get_next_post();
            ?>
            
            <?php if ($prev_post || $next_post): ?>
                <nav class="post-navigation">
                    <div class="nav-links">
                        <?php if ($prev_post): ?>
                            <div class="nav-previous">
                                <a href="<?php echo get_permalink($prev_post); ?>">
                                    <i class="fa fa-angle-left"></i>
                                    <?php echo get_the_title($prev_post); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($next_post): ?>
                            <div class="nav-next">
                                <a href="<?php echo get_permalink($next_post); ?>">
                                    <?php echo get_the_title($next_post); ?>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </nav>
            <?php endif; ?>
        </footer>

        <?php if (comments_open() || get_comments_number()): ?>
            <div class="comments-section">
                <?php comments_template(); ?>
            </div>
        <?php endif; ?>
    </article>
<?php endwhile; ?>

<?php get_footer(); ?>