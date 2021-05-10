<?php
/**
 * List Layout for Blog
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Olively
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('olively-list col-12'); ?>>
	
	<div class="list-wrapper no-gutters row">
		<div class="olively-thumb col-md-5">
			<?php if ( has_post_thumbnail() ): ?>
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('olively_list_thumb'); ?></a>
			<?php
			else :
			?>	<a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/ph_list.png'); ?>"></a>
			<?php endif; ?>
		</div>
		
		<div class="olively-list-content col-md-7">
			<header class="entry-header">
				<?php
					the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' );
				?>
			</header><!-- .entry-header -->
	
			<div class="entry-content">
				
				<?php do_action('olively_blog_excerpt', NULL, 20); ?>
				
			</div><!-- .entry-content -->
			<div class="olively-read-more"><a href="<?php esc_url( the_permalink() ); ?>" class="more-link"><?php _e("Read More", "olively"); ?></a></div><!-- .olively-read-more -->
		</div><!-- .olively-list-content -->
	</div>
</article><!-- #post-<?php the_ID(); ?> -->