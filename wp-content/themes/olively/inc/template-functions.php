<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package olively
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function olively_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'olively_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function olively_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'olively_pingback_header' );


/**
 *	Pagination
 */
function olively_get_pagination() {

	$args	=	array(
		'mid_size' => 2,
		'prev_text' => __( '<i class="fas fa-angle-left"></i>', 'olively' ),
		'next_text' => __( '<i class="fas fa-angle-right"></i>', 'olively' ),
	);

	the_posts_pagination($args);

}
add_action('olively_pagination', 'olively_get_pagination');


 /**
  *	Function to call Featured Image
	*/

	function olively_get_featured_thumnail( $layout ) {

		if ( has_post_thumbnail() ) :
			?>
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'olively_' . $layout ); ?></a>
			<?php
		else :
			$path = esc_url( get_template_directory_uri() . '/assets/images/ph_' . $layout . '.png');
			?>
			<a href="<?php the_permalink(); ?>"><img src="<?php echo $path; ?>" alt="Featured Thumbnail"></a>
		<?php
		endif;
	}
	add_action('olively_featured_thumbnail', 'olively_get_featured_thumnail', 10, 1);




	function olively_get_post_categories() {

		$cats		=	wp_get_post_categories( get_the_ID() );
		$link_html	=	'<span class="cat-links"><i class="fas fa-folder"></i>';
		?>



		<?php
			foreach($cats as $cat) {
				$link_html	.=	'<a href=' . esc_url(get_category_link($cat)) . ' tabindex="0">' . esc_html(get_cat_name($cat)) . '</a>';
			}
			$link_html	.=	'</span>';
		echo $link_html;
		?>
		<?php
	}


	function olively_get_comments() {
		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link"><i class="fas fa-comment"></i>';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'olively' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}
	}


	/**
	 *	Function to generate meta data for the posts
	 */
function olively_get_metadata() {
	if ( 'post' === get_post_type() ) :
		?>
			<div class="entry-meta">
				<?php
				olively_posted_by();
				olively_posted_on();
				olively_get_post_categories();
				olively_get_comments();
				?>
			</div>
	<?php endif;
}
add_action('olively_metadata', 'olively_get_metadata');


/**
 *	Function to load Showcase Featured Area
 */
function olively_get_showcase() {

	include_once get_template_directory() . '/framework/featured_areas/showcase.php';

}

/**
 *	Function to load Featured Posts Area
 */
function olively_get_featured_posts() {

	include_once get_template_directory() . '/framework/featured_areas/featured-posts.php';

}


/**
 *	Function for Blog Page Title
 */

function olively_get_blog_page_title() {

	if ( get_theme_mod('olively_blog_title', '' ) ) {
		?>
		<h3 id="blog_title" class="section-title title-font">
			<?php echo esc_html(get_theme_mod('olively_blog_title')) ?>
		</h3>
	<?php
	}
}
 add_action('olively_blog_title', 'olively_get_blog_page_title');


/**
 *	Function for post content on Blog Page
 */
 function olively_get_blog_excerpt( $post = NULL, $length = 30 ) {
	 
	if (NULL == $post ) {
		global $post;
	}

	 $output	=	'';

	 if ( isset($post->ID) && has_excerpt($post->ID) ) {
		 $output = $post->post_excerpt;
	 }

	 elseif ( isset( $post->post_content ) ) {
		if ( strpos($post->post_content, '<!--more-->') ) {
			$output	=	get_the_content('');
		}
		else {
			$output	=	wp_trim_words( strip_shortcodes( $post->post_content ), $length );
		}
	}

	 $output	=	apply_filters('olively_excerpt', $output);

	 echo $output;
 }
 add_action('olively_blog_excerpt', 'olively_get_blog_excerpt', 10, 2);



 function olively_get_layout( $template = 'blog') {

	 $layout	=	'framework/layouts/content';

	 switch( $template ) {
		case 'blog':
			$blog = strpos(get_theme_mod("olively_blog_layout", "card"), 'card') !== false ? 'card' : get_theme_mod("olively_blog_layout", "card");
			
			if ($blog == 'card') {
				switch (get_theme_mod("olively_blog_layout", "card")) {
					case 'card-2':
						$columns = 'col-md-6';
						break;
					case 'card-3':
						$columns = 'col-md-4';
						break;
					default:
						$columns = 'col-md-6';
				} 
			} else {
				$columns = '';
			}
			get_template_part( $layout, $blog, array('columns' => $columns) );
		break;
		case 'single':
			get_template_part( 'template-parts/content', 'single' );
		break;
		case 'search':
			get_template_part( $layout, get_theme_mod("olively_search_layout", "card" ), array('columns' => 'col-md-6') );
		break;
		case 'archive':
			get_template_part( $layout, get_theme_mod("olively_archive_layout", "card" ), array('columns' => 'col-md-6') );
		break;
		default:
			get_template_part( $layout, get_theme_mod('olively_blog_layout', 'card' ), array('columns' => 'col-md-6') );
	 }
 }
 add_action('olively_layout', 'olively_get_layout', 10, 1);


 /**
  *	Function for 'Read More' link
  */
  function olively_read_more_link() {
	  ?>
	  <div class="read-more title-font"><a href="<?php the_permalink() ?>"><?php _e('Read More', 'olively'); ?></a></div>
	  <?php
  }


/**
 *	Function to Enable Sidebar
 */
function olively_get_sidebar( $template ) {

   global $post;

   switch( $template ) {
	   
	    case "blog";
	    if ( is_home() &&
	    	get_theme_mod('olively_blog_sidebar_enable', 1) !== "" ) {
		    get_sidebar(NULL, ['page' => 'blog']);
		}
		break;
	    case "single":
	   		if( is_single() &&
	   		get_theme_mod('olively_single_sidebar_enable', 1) !== "" ) {
				get_sidebar('single');
			}
		break;
		case "search":
	   		if( is_search() &&
	   		get_theme_mod('olively_search_sidebar_enable', 1) !== "" ) {
				get_sidebar(NULL, ['page' => 'search']);
			}
		break;
		case "archive":
	   		if( is_archive() &&
	   		get_theme_mod('olively_archive_sidebar_enable', 1) !== "" ) {
				get_sidebar(NULL, ['page' => 'archive']);
			}
		break;
		case "page":
			if ( '' == get_post_meta($post->ID, 'enable-sidebar', true) ) {
				get_sidebar('page');
			}
		break;
	    default:
	    	get_sidebar();
	}
}
add_action('olively_sidebar', 'olively_get_sidebar', 10, 1);



 /**
  *	Function for Sidebar alignment
  */
function olively_sidebar_align( $template = 'blog' ) {
	
		$align = 'page'	== $template ? get_post_meta( get_the_ID(), 'align-sidebar', true ) : get_theme_mod('olively_' . $template . '_sidebar_layout', 'right');

	$align_arr	=	['order-1', 'order-2'];

	if ( in_array( $template, ['single', 'blog', 'page', 'search', 'archive'] ) ) {
		return 'right' == $align ? $align_arr : array_reverse($align_arr);
	}
	else {
		return $align_arr;
	}
}


 /**
  *	Function to get Social icons
  */
 function olively_get_social_icons() {
 	get_template_part('social');
 }
 add_action('olively_social_icons', 'olively_get_social_icons');


 /**
  *	Get Custom sizes for 'image' post format
  */
  function olively_thumb_dim( $id, $size ) {

	$img_array	=	wp_get_attachment_image_src( $id, $size );

	$dim	=	[];
	$dim['width']	= $img_array[1];
	$dim['height']	= $img_array[2];

	return $dim;

}


/**
 *	The About Author Section
 */
function olively_get_about_author( $post ) { ?>
	<div id="author_box" class="row no-gutters">
		<div class="author_avatar col-2">
			<?php echo get_avatar( intval($post->post_author), 96 ); ?>
		</div>
		<div class="author_info col-10">
			<h4 class="author_name title-font">
				<?php echo get_the_author_meta( 'display_name', intval($post->post_author) ); ?>
			</h4>
			<div class="author_bio">
				<?php echo get_the_author_meta( 'description', intval($post->post_author) ); ?>
			</div>
		</div>
	</div>
<?php
}
add_action('olively_about_author', 'olively_get_about_author', 10, 1);

 /**
  *	Function to add featured Areas before Content
  */
function olively_get_before_content() { ?>
	<div id="olively-before-content">
		<?php
		if ( is_front_page() && is_active_sidebar('before-content') ) :
			dynamic_sidebar('before-content');
		endif;
		?>
	</div>
<?php  
}
add_action('olively_before_content', 'olively_get_before_content');


  /**
   *	Function to add Content to the front page area
   */
   function olively_get_front_page_content() { ?>
	   <div class="col">
		   <?php if ( is_active_sidebar('above-content' ) ) :
			   dynamic_sidebar('above-content');
		   endif; ?>
		   <div class="row no-gutters">
			   <div class="col-md-6">
				   <?php if ( is_active_sidebar('left-content' ) ) :
					   dynamic_sidebar('left-content');
				   endif; ?>
			   </div>
			   <div class="col-md-6">
				   <?php if ( is_active_sidebar('right-content' ) ) :
					   dynamic_sidebar('right-content');
				   endif; ?>
			   </div>
		   </div>
	   </div>
	<?php
   }
   add_action('olively_front_page_content', 'olively_get_front_page_content');


  /**
   *	Function to add Featured Areas After Content
   */
   function olively_get_after_content() {

	    if ( is_front_page() && is_active_sidebar('after-content') ) :
			dynamic_sidebar('after-content');
		endif;
   }
   add_action('olively_after_content', 'olively_get_after_content');


/**
 *	Functions for footer section
 */
 function olively_get_footer() {
	 
	$path 	=	'/framework/footer/footer';
	get_template_part( $path, get_theme_mod( 'olively_footer_cols', 4 ) );
 }
 add_action('olively_footer', 'olively_get_footer', 20);
   
/**
 *	Function for AJAX request to get meta data of page set as Front Page
**/

/*
add_action('wp_ajax_front_page_meta', 'olively_front_page_ajax');
function olively_front_page_ajax() {
	
	$page_id	=	intval( $_POST['id'] );
	$path		=	get_page_template_slug($page_id);

	echo $path;
	
	wp_die();
	
}
*/


/**
 *	Related Posts of a Single Post
 */
 
function olively_get_related_posts() {
	
	global $post;
	
	$related_args = [
		"posts_per_page"		=>	3,
		"ignore_sticky_posts"	=>	true,
		"post__not_in"			=>	[get_the_ID()],
		"category_name"			=>	get_the_category($post)[0]->slug,
		"orderby"				=> "rand"
	];
	
	$related_query	=	new WP_Query( $related_args );
	
	if ( $related_query->have_posts() ) : ?>
		<div id="olively-related-posts-wrapper">
			<h3 id="olively-related-posts-title"><?php _e('Related Posts', 'olively'); ?></h3>
			<div id="olively-related-posts row">
				<?php
					while ( $related_query->have_posts() ) : $related_query->the_post();
			
						get_template_part( 'framework/layouts/content', 'card', array('columns' => 'col-lg-4') );
						
					endwhile;
				?>
			</div>
		</div>
	<?php
	endif;
	wp_reset_postdata();
}
add_action('olively_related_posts', 'olively_get_related_posts');

/**
 *	Front Page - Featured Category
 */
function olively_featured_category_front() {
	 
	$cat = get_theme_mod('olively_front_featured_cat', 0);
	 
	$args = array(
		'cat'	=>	$cat,
		'posts_per_page'	=>	2,
		'ignore_sticky_posts'	=>	true
	);
	 
	$front_cat_query = new WP_Query($args);
	 
	// The Loop
	if ( $front_cat_query->have_posts() ) : ?>
		<div id="olively_front_featured_cat" class="container">
		<?php
			while ( $front_cat_query->have_posts() ) : $front_cat_query->the_post();
			  
			  get_template_part('framework/layouts/content', 'card', ['columns'	=>	'col-md-6']);
			endwhile;
		?>
		<div class="featured_cat_read_more"><a href="<?php echo get_category_link($cat); ?>" class="olively-btn primary"><?php _e('Read More', 'olively'); ?></a></div>
		</div>
		<?php
	endif;	
	wp_reset_postdata();	
	 
}
 
function olively_front_featured_post() {
	
	if (empty(get_theme_mod('olively_front_custom_post'))) {
		return;
	}
	
	$f_post = get_post(get_theme_mod('olively_front_custom_post'));
	?>
	
	<div id="olively_front_custom_post">
		<div id="f_post_image"></div>
		<div id="f_post_content">
			<h3 class="f_post_title"><?php echo esc_html(get_the_title($f_post)); ?></h3>
			<p class="f_post_excerpt"><?php do_action('olively_blog_excerpt', $f_post, 30); ?></p>
			<div class="f_post_author">
				<?php	echo get_avatar($f_post->ID, 48);
						echo get_the_author_meta('user_nicename');
				?>
			</div>
			<div class="f_post_read_more"><a href="<?php echo get_permalink($f_post); ?>" class="olively-btn primary"><?php _e('Read More', 'olively'); ?></a></div>
		</div>
	</div>
<?php
}


//blog Page URL
function olively_get_blog_posts_page_url() {

	// If front page is set to display a static page, get the URL of the posts page.
	if ( 'page' === get_option( 'show_on_front' ) ) {
		return get_permalink( get_option( 'page_for_posts' ) );
	}

	// The front page IS the posts page. Get its URL.
	return get_home_url();
}


//Latest Posts Section - Front Page
function olively_front_latest_posts() { ?>
	
	<div id="olively_front_latest_posts" class="container">
		<h3 class="section-title"><?php _e('From The Blog', 'olively'); ?></h3>
		
		<?php
		$args = array(
			'posts_per_page' => 3,
			'ignore_sticky_posts' => true
		);
		
		$latest_query = new WP_Query($args);
		
		if ( $latest_query->have_posts() ) : ?>
			<div class="olively_front_rp_wrapper">
				<?php
					while ( $latest_query->have_posts() ) : $latest_query->the_post();
					  
					  get_template_part('framework/layouts/content', 'card', ['columns'	=>	'col-md-4']);
					endwhile;
				?>
			</div>
			<div class="recent_posts_read_more"><a href="<?php echo olively_get_blog_posts_page_url() ?>" class="olively-btn primary"><?php _e('Go to Blog Page', 'olively'); ?></a></div>
		<?php
		endif;	
		?>
	</div>
	<?php
	wp_reset_postdata();
}