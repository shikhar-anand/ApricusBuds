<?php

/**
 *	Function to show Featured Page in Header
 */
function olively_featured() {
	
	$featured_page	=	get_post(get_theme_mod('olively_featured_page', 0));
	
	if (empty($featured_page)) {
		return;
	}
	?>
	
	<div id="olively-featured-page">
		
		<h3 id="featured-page-title"><a href="<?php the_permalink($featured_page) ?>" title="<?php echo esc_attr(get_the_title($featured_page)) ?>"><?php echo esc_html(get_the_title($featured_page)); ?></a></h3>
		<p id="olively-featured-excerpt"><?php do_action('olively_blog_excerpt', $featured_page, 15); ?></p>
	</div>
	<?php if (!empty(get_theme_mod('olively_social_enable', 1))) { ?>
	<div id="olively-social">
			<?php get_template_part('inc/social'); ?>
	</div>
	<?php
	}
}

/**
 *	Search Form
*/
function olively_get_search() {

	get_template_part('framework/header/search/search');
}
add_action('olively_search', 'olively_get_search');


/**
 *	Function to add Mobile Navigation
 */
function olively_navigation() {

	require get_template_directory() . '/framework/header/navigation/navigation.php';

}
 add_action('olively_get_navigation', 'olively_navigation');

/**
 *	Function for adding Site Branding via action
 */

function olively_branding() {

	require get_template_directory() . '/framework/header/branding/branding.php';

}
add_action('olively_get_branding', 'olively_branding');

/**
 *	Top Bar
 */
function olively_top_bar() { ?>
	<div id="top-bar" class="row no-gutters">
		<div class="container">
			<div class="row align-items-center">
		        <div class="site-branding col-4 col-lg-3">
					<?php do_action('olively_get_branding'); ?>
		        </div>
		        
		        <nav id="site-navigation" class="main-navigation col-lg-8">
		            <?php do_action('olively_get_navigation'); ?>
		        </nav>
		        
		        <button id="mobile-nav-btn" href="#menu" class="menu-link"><i class="fa fa-bars" aria-hidden="true"></i></button>
		        
		        <?php get_template_part('framework/header/search/search'); ?>
	        </div>
		</div>
	</div>
<?php
}

 
/**
 *	Control the Masthead of the theme
 */
function olively_get_masthead( $layout = 'front') {

    switch ($layout) {
        case 'front':
        ?>
        <header id="masthead" class="site-header front">
	        
	        <?php olively_top_bar(); ?>
    		
    		<div id="header-image"></div>
    		
    		<div id="olively-hero-section">
	    		
	    		<?php if ( get_theme_mod('olively_hero_text') ) { ?>
	    			<h1><?php echo esc_html(get_theme_mod('olively_hero_text')) ?></h1>
	    		<?php } ?>
	    		
	    		<?php if ( get_theme_mod('olively_hero_description') ) { ?>
	    			<p><?php echo esc_html(get_theme_mod('olively_hero_description')) ?></p>
	    		<?php } ?>
	    		
	    		<br>
	    		
	    		<?php if (get_theme_mod('oro_cta_text')) { ?>
	    			<a class="olively_cta" href="<?php echo esc_url(get_theme_mod('olively_hero_cta_url')) ?>"><?php echo esc_html(get_theme_mod('olively_hero_cta_text')) ?></a>
	    		<?php } ?>
    		</div>
    		
    		<div id="header-bottom-bar">
	    		
		    		<?php olively_featured(); ?>
		    		
    		</div>

    	</header><!-- #masthead -->
		<?php
        break;
        case 'blog': ?>
        	<header id="masthead" class="site-header singular">
	        
	        <?php olively_top_bar(); ?>
    		
    		<div id="header-image">
	    		<header class="entry-header container">
					<h1><?php _e('Blog Page', 'olively') ?></h1>
				</header><!-- .entry-header -->
    		</div>
    	</header><!-- #masthead -->
    	<?php
	    break;
        case 'singular': ?>
        <header id="masthead" class="site-header singular">
	        
	        <?php olively_top_bar(); ?>
    		
    		<div id="header-image">
	    		<header class="entry-header container">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				</header><!-- .entry-header -->
    		</div>

    	</header><!-- #masthead -->
        <?php
	    break;
	    case 'search': ?>
        <header id="masthead" class="site-header search">
	        
	        <?php olively_top_bar(); ?>
    		
    		<div id="header-image">
	    		<header class="page-header">
				<h2 class="page-title">
					<?php
					/* translators: %s: search query. */
					printf( esc_html__( '<h1>Search Results for: %s</h1>', 'olively' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h2>
			</header><!-- .page-header -->
    		</div>

    	</header><!-- #masthead -->
        <?php
	    break;
	    case 'archive': ?>
        <header id="masthead" class="site-header archive">
	        
	        <?php olively_top_bar(); ?>
    		
    		<div id="header-image">
	    		<header class="page-header">
					<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="archive-description">', '</div>' );
					?>
				</header><!-- .page-header -->
    		</div>

    	</header><!-- #masthead -->
        <?php
	    break;
        default: ?>
        <header id="masthead" class="site-header">
	        
	        <?php do_action('olively_get_mobile_navigation'); ?>

    		<div class="container">

    			<div id="top-wrapper" class="row align-items-center">

                        <div class="site-branding col-md-3">
        					<?php do_action('olively_get_branding'); ?>
                        </div>

                        <nav id="site-navigation" class="main-navigation col-md-9">
                            <?php do_action('olively_get_navigation'); ?>
                        </nav>

    			</div>

    		</div>

    		<div id="header-image">
                <div id="top-search">
        			<?php do_action( 'olively_search' ); ?>
        		</div>
            </div>

    	</header><!-- #masthead -->
        <?php
    }
}
add_action('olively_masthead', 'olively_get_masthead', 10, 1);