<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Olively
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('olively-blog'); ?>>
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<?php
				olively_posted_on();
				olively_posted_by();
				?>
			</div><!-- .entry-meta -->
			
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php if ( has_post_thumbnail() ): ?>
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('olively_list_thumb'); ?></a>
	<?php
	else :
	?>	<a href="<?php the_permalink(); ?>"><img class="wp-post-image" src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/ph_list.png'); ?>"></a>
	<?php endif; ?>

	<div class="entry-content">
		
		<?php do_action('olively_blog_excerpt', NULL, 30); ?>
		
		<div class="olively-read-more"><a href="<?php the_permalink(); ?>" class="more-link"><?php _e("Read More", "olively"); ?></a></div>
<!--
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'olively' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'olively' ),
				'after'  => '</div>',
			)
		);
		?>
-->
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->