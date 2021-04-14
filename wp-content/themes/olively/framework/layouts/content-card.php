<?php
/**
 * List Layout for Blog
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Olively
 */
 
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('olively-card ' . $args["columns"] ); ?>>
		<div class="olively-card-wrapper">
			<div class="olively-thumb">
				<?php if ( has_post_thumbnail() ): ?>
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('olively_card_thumb'); ?></a>
				<?php
				else :
				?>	<a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/ph_card.png'); ?>"></a>
				<?php endif; ?>
			</div>
			
			<div class="olively_card_desc">
				<div class="olively_card_cat">
					<?php echo get_the_category_list(' '); ?>
				</div>
				<header class="entry-header">
				<?php
					the_title( '<h5 class="entry-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h5>' );
				 ?>
				</header><!-- .entry-header -->
				<div class="olively_card_excerpt">
					<?php do_action('olively_blog_excerpt'); ?>
				</div>
				<div class="olively_card_meta">
					<div class="olively_card_author ">
						<?php echo get_the_author_link(); ?>
					</div>
					<div class="card-posted-on">
						<div class="card-date"><?php echo get_the_date(); ?></div>
					</div>
				</div>
			</div><!-- .olively-desc -->
		</div>
</article><!-- #post-<?php the_ID(); ?> -->