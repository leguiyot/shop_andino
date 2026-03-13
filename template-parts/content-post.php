<?php
/**
 * Template part for displaying posts
 * 
 * @package PlanAndino_Shop
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('blog-post'); ?>>
    
    <div class="post-inner">
        
        <?php if (has_post_thumbnail() && !is_single()) : ?>
            <div class="post-thumbnail">
                <a href="<?php the_permalink(); ?>" class="thumbnail-link">
                    <?php the_post_thumbnail('large', array('alt' => get_the_title())); ?>
                </a>
                
                <?php if (is_sticky()) : ?>
                    <span class="sticky-badge">
                        <i class="fa fa-thumb-tack"></i>
                        <?php esc_html_e('Destacado', 'planandino-shop'); ?>
                    </span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <div class="post-content">
            
            <header class="post-header">
                
                <div class="post-meta">
                    <div class="post-categories">
                        <?php
                        $categories = get_the_category();
                        if (!empty($categories)) {
                            echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '" class="category-link">' . esc_html($categories[0]->name) . '</a>';
                        }
                        ?>
                    </div>
                    
                    <div class="post-date">
                        <time datetime="<?php echo get_the_date('c'); ?>">
                            <?php echo get_the_date(); ?>
                        </time>
                    </div>
                </div>
                
                <?php
                if (is_singular()) :
                    the_title('<h1 class="post-title">', '</h1>');
                else :
                    the_title('<h2 class="post-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
                endif;
                ?>
                
                <?php if (!is_single()) : ?>
                    <div class="post-excerpt">
                        <?php
                        if (has_excerpt()) {
                            the_excerpt();
                        } else {
                            echo wp_trim_words(get_the_content(), 25, '...');
                        }
                        ?>
                    </div>
                <?php endif; ?>
                
            </header>
            
            <?php if (is_single()) : ?>
                <div class="post-body">
                    <?php
                    the_content();
                    
                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . esc_html__('Páginas:', 'planandino-shop'),
                        'after'  => '</div>',
                    ));
                    ?>
                </div>
            <?php endif; ?>
            
            <footer class="post-footer">
                
                <div class="post-meta-bottom">
                    
                    <div class="author-info">
                        <span class="author-avatar">
                            <?php echo get_avatar(get_the_author_meta('ID'), 24); ?>
                        </span>
                        <span class="author-name">
                            <?php esc_html_e('Por', 'planandino-shop'); ?> 
                            <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                <?php the_author(); ?>
                            </a>
                        </span>
                    </div>
                    
                    <?php if (!is_single()) : ?>
                        <div class="read-more">
                            <a href="<?php the_permalink(); ?>" class="read-more-link">
                                <?php esc_html_e('Leer más', 'planandino-shop'); ?>
                                <i class="fa fa-arrow-right"></i>
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (is_single()) : ?>
                        <div class="post-tags">
                            <?php
                            $tags = get_the_tags();
                            if ($tags) :
                            ?>
                                <span class="tags-label"><?php esc_html_e('Etiquetas:', 'planandino-shop'); ?></span>
                                <div class="tag-list">
                                    <?php foreach ($tags as $tag) : ?>
                                        <a href="<?php echo esc_url(get_tag_link($tag)); ?>" class="tag-link">
                                            <?php echo esc_html($tag->name); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="post-sharing">
                            <span class="sharing-label"><?php esc_html_e('Compartir:', 'planandino-shop'); ?></span>
                            <div class="sharing-buttons">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="share-facebook">
                                    <i class="fa fa-facebook"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share-twitter">
                                    <i class="fa fa-twitter"></i>
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="share-linkedin">
                                    <i class="fa fa-linkedin"></i>
                                </a>
                                <a href="https://wa.me/?text=<?php echo urlencode(get_the_title() . ' ' . get_permalink()); ?>" target="_blank" class="share-whatsapp">
                                    <i class="fa fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                </div>
                
            </footer>
            
        </div>
        
    </div>
    
</article>

<style>
/* Estilos específicos para content-post.php */
.blog-post {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    margin-bottom: 40px;
    transition: all 0.3s ease;
}

.blog-post:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
}

.post-inner {
    display: flex;
    flex-direction: column;
    height: 100%;
}

/* Post thumbnail */
.post-thumbnail {
    position: relative;
    overflow: hidden;
    background: #f8f9fa;
}

.post-thumbnail img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.blog-post:hover .post-thumbnail img {
    transform: scale(1.05);
}

.thumbnail-link {
    display: block;
}

.sticky-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: #e6ae48;
    color: white;
    padding: 8px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 5px;
    z-index: 5;
}

/* Post content */
.post-content {
    padding: 25px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

/* Post header */
.post-header {
    margin-bottom: 20px;
    flex-grow: 1;
}

.post-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    font-size: 14px;
}

.post-categories a {
    background: rgba(230, 174, 72, 0.1);
    color: #e6ae48;
    padding: 4px 12px;
    border-radius: 15px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.post-categories a:hover {
    background: #e6ae48;
    color: white;
}

.post-date {
    color: #999;
}

/* Post title */
.post-title {
    font-size: 1.5rem;
    font-weight: 600;
    line-height: 1.3;
    margin: 0 0 15px 0;
}

.post-title a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.post-title a:hover {
    color: #e6ae48;
}

/* Single post title */
.blog-post .post-title:not(:has(a)) {
    font-size: 2.2rem;
    margin-bottom: 20px;
}

/* Post excerpt */
.post-excerpt {
    color: #666;
    line-height: 1.6;
    margin-bottom: 15px;
}

.post-excerpt p {
    margin-bottom: 15px;
}

/* Post body (single post) */
.post-body {
    color: #444;
    line-height: 1.7;
    font-size: 16px;
    margin-bottom: 30px;
}

.post-body h2,
.post-body h3,
.post-body h4,
.post-body h5,
.post-body h6 {
    color: #333;
    margin-top: 30px;
    margin-bottom: 15px;
    font-weight: 600;
}

.post-body h2 {
    font-size: 1.8rem;
    border-bottom: 2px solid #e6ae48;
    padding-bottom: 8px;
}

.post-body h3 {
    font-size: 1.5rem;
}

.post-body h4 {
    font-size: 1.3rem;
}

.post-body p {
    margin-bottom: 20px;
}

.post-body ul,
.post-body ol {
    margin-bottom: 20px;
    padding-left: 20px;
}

.post-body li {
    margin-bottom: 8px;
}

.post-body blockquote {
    background: rgba(230, 174, 72, 0.05);
    border-left: 4px solid #e6ae48;
    padding: 20px;
    margin: 25px 0;
    font-style: italic;
    color: #666;
}

.post-body img {
    max-width: 100%;
    height: auto;
    border-radius: 5px;
    margin: 20px 0;
}

.post-body a {
    color: #e6ae48;
    text-decoration: underline;
    transition: color 0.3s ease;
}

.post-body a:hover {
    color: #d19b3e;
}

/* Page links */
.page-links {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
    text-align: center;
}

.page-links a {
    display: inline-block;
    padding: 8px 12px;
    margin: 0 5px;
    background: #e6ae48;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    transition: background 0.3s ease;
}

.page-links a:hover {
    background: #d19b3e;
}

.page-links .current {
    display: inline-block;
    padding: 8px 12px;
    margin: 0 5px;
    background: #333;
    color: white;
    border-radius: 4px;
}

/* Post footer */
.post-footer {
    margin-top: auto;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
    padding-top: 20px;
}

.post-meta-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
}

.author-info {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: #666;
}

.author-avatar img {
    border-radius: 50%;
}

.author-name a {
    color: #333;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

.author-name a:hover {
    color: #e6ae48;
}

.read-more-link {
    color: #e6ae48;
    text-decoration: none;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: all 0.3s ease;
    font-size: 14px;
}

.read-more-link:hover {
    color: #d19b3e;
    transform: translateX(3px);
}

/* Post tags */
.post-tags {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.tags-label {
    color: #666;
    font-size: 14px;
    font-weight: 500;
}

.tag-list {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.tag-link {
    background: rgba(230, 174, 72, 0.1);
    color: #e6ae48;
    padding: 4px 12px;
    border-radius: 15px;
    text-decoration: none;
    font-size: 12px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.tag-link:hover {
    background: #e6ae48;
    color: white;
}

/* Post sharing */
.post-sharing {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
}

.sharing-label {
    color: #666;
    font-size: 14px;
    font-weight: 500;
}

.sharing-buttons {
    display: flex;
    gap: 8px;
}

.sharing-buttons a {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
}

.share-facebook {
    background: #3b5998;
}

.share-twitter {
    background: #1da1f2;
}

.share-linkedin {
    background: #0077b5;
}

.share-whatsapp {
    background: #25d366;
}

.sharing-buttons a:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

/* Responsive */
@media (max-width: 768px) {
    .blog-post {
        margin-bottom: 30px;
    }
    
    .post-content {
        padding: 20px;
    }
    
    .post-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
    
    .post-title {
        font-size: 1.3rem;
    }
    
    .blog-post .post-title:not(:has(a)) {
        font-size: 1.8rem;
    }
    
    .post-meta-bottom {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    
    .post-tags {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .post-sharing {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .post-thumbnail img {
        height: 200px;
    }
}

@media (max-width: 480px) {
    .post-content {
        padding: 15px;
    }
    
    .post-title {
        font-size: 1.2rem;
    }
    
    .blog-post .post-title:not(:has(a)) {
        font-size: 1.6rem;
    }
    
    .post-body {
        font-size: 15px;
    }
    
    .post-body h2 {
        font-size: 1.5rem;
    }
    
    .post-body h3 {
        font-size: 1.3rem;
    }
    
    .sharing-buttons a {
        width: 32px;
        height: 32px;
    }
    
    .post-thumbnail img {
        height: 180px;
    }
}
</style>