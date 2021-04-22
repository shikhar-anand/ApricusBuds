<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package tafri-travel
 */

get_header(); ?>

<main id="main" role="main" class="content-box">
	<div class="container">
        <div class="middle-align">
			<h1><?php echo esc_html(get_theme_mod('tafri_travel_page_not_found_title',__('404 Not Found','tafri-travel')));?></h1>
			<p class="text-404"><?php echo esc_html(get_theme_mod('tafri_travel_page_not_found_content',__('Looks like you have taken a wrong turn&hellip. Dont worry&hellip it happens to the best of us.','tafri-travel')));?></p>
			<?php if( get_theme_mod('tafri_travel_page_not_found_button','Back to Home Page') != ''){ ?>
				<div class="read-moresec">
	        		<a href="<?php echo esc_url(home_url()); ?>" class="button"><?php echo esc_html(get_theme_mod('tafri_travel_page_not_found_button',__('Back to Home Page','tafri-travel')));?><span class="screen-reader-text"><?php esc_html_e( 'Back to Home Page', 'tafri-travel' ); ?></span></a>
	        	</div>
        	<?php } ?>
			<div class="clearfix"></div>
        </div>
	</div>
</main>

<?php get_footer(); ?>