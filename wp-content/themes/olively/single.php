<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Olively
 */

get_header('singular', ['layout'	=>	'container']);
?>

	<main id="primary" class="site-main container <?php echo olively_sidebar_align('single')[0]; ?>">

		<?php
		while ( have_posts() ) :
			the_post();
			
			do_action('olively_layout', 'single');
			
			if ( get_theme_mod('olively_single_navigation_enable') !== "" ) :
				$prev_post = get_adjacent_post( false, '', true );
				$next_post = get_adjacent_post( false, '', false );
				
				$prev_thumb = has_post_thumbnail($prev_post) ? get_the_post_thumbnail($prev_post, array(100, 100)) : '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/ph_post_nav.png') . '">';
				
				$next_thumb = has_post_thumbnail($next_post) ? get_the_post_thumbnail($next_post, array(100, 100)) : '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/ph_post_nav.png') . '">';
	
				
				the_post_navigation(
					array(
						'prev_text' => $prev_post == '' ? '' : '<span class="nav-thumb nav-prev-thumb" title="' . $prev_post->post_title . '">' . $prev_thumb . '</span><br><span class="nav-prev-title">%title</span>',
						'next_text' => $next_post == '' ? '' : '<span class="nav-thumb nav-next-thumb" title="' . $next_post->post_title . '">' . $next_thumb . '</span><br><span class="nav-next-title">%title</span>',
					)
				);
			endif;
			
			if ( get_theme_mod('olively_single_related_enable', 1) !== "" ) :
				do_action('olively_related_posts');
			endif;
			
			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
do_action('olively_sidebar', 'single');
get_footer();
