<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Theme Palace
 * @subpackage Stortech 
 * @since Stortech  1.0.0
 */
$class = has_post_thumbnail() ? 'has-post-thumbnail' : '';
$options = stortech_get_theme_options();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'hentry' . $class ); ?>>
    <div class="post-wrapper">
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="featured-image" style="background-image: url('<?php the_post_thumbnail_url(); ?>');">
                <a href="<?php the_permalink() ; ?>" class="post-thumbnail-link"></a>
            </div><!-- .featured-image -->
        <?php endif; ?>

        <div class="entry-container">
            <div class="entry-meta">
                <?php 
                    if ( ! $options['hide_date'] ) :
                        stortech_posted_on(); 
                    endif; 
                ?>
                <?php 
                if ( ! $options['hide_author'] ) :
                    echo stortech_author( get_the_author_meta( 'ID' ) );
                endif; ?>
            </div><!-- .entry-meta -->

            <header class="entry-header">
               <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            </header>

            <div class="entry-content">
                <?php the_excerpt(); ?>
            </div><!-- .entry-content -->
        </div><!-- .entry-container -->
    </div><!-- .post-wrapper -->
</article>