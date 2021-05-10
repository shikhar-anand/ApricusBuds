<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Theme Palace
 * @subpackage Stortech
 * @since Stortech 1.0.0
 */
$options = stortech_get_theme_options();
$class = has_post_thumbnail() ? '' : 'no-post-thumbnail';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'clear ' . $class ); ?>>

	<div class="entry-meta">
		<?php if ( ! $options['single_post_hide_author'] ) :
			echo stortech_author( get_the_author_meta( 'ID' ) );
		endif; 

		if ( ! $options['single_post_hide_date'] ) :
			stortech_posted_on(); 
		endif; ?>
    </div><!-- .entry-meta -->

    <div class="entry-container">
        <div class="entry-content">
            <?php
				the_content( sprintf(
					/* translators: %s: Name of current post. */
					wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'stortech' ), array( 'span' => array( 'class' => array() ) ) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'stortech' ),
					'after'  => '</div>',
				) );
			?>
        </div><!-- .entry-content -->
    </div><!-- .entry-container -->
    
    <div class="entry-meta">
        <?php  
        	stortech_single_categories();
        	stortech_entry_footer();
    	?>
    </div><!-- .entry-meta -->


</article><!-- #post-## -->
