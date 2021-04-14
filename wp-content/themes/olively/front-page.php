<?php
/**
 *	Front Page of the Theme
 */
 
get_header('front', ['layout' => 'container']);
?>

<?php if (get_option('show_on_front') == 'page') { ?>

	<main id="primary" class="site-main">
		
		<?php
		olively_featured_category_front();	
	
		olively_front_featured_post();
	
		olively_front_latest_posts();
		?>
		</main><!-- #main -->
		
	<?php
	} else {
		
		include( get_home_template() );
		
	}
	
get_footer();