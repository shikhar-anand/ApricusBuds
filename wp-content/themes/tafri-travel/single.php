<?php
/**
 * The Template for displaying all single posts.
 *
 * @package tafri-travel
 */

get_header(); ?>

<div class="container">
    <main id="main" role="main" class="middle-align">
    	<?php
        $tafri_travel_left_right = get_theme_mod( 'tafri_travel_post_sidebar_options','Right Sidebar');
        if($tafri_travel_left_right == 'Left Sidebar'){ ?>
            <div class="row m-0">
		    	<div id="sidebar" class="col-lg-4 col-md-4">
					<?php dynamic_sidebar('sidebar-1'); ?>
				</div>
				<div class="col-lg-8 col-md-8" class="content-box pages-te">
					<?php if(get_theme_mod('tafri_travel_single_post_breadcrumb',true) != ''){ ?>
			            <div class="post-breadcrumbs">
			                <?php tafri_travel_the_breadcrumb(); ?>
			            </div>
		          	<?php }?>
					<?php
						/* Start the Loop */
						while ( have_posts() ) : the_post();

							get_template_part( 'template-parts/content-single' );

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif; ?>

							<?php if( get_theme_mod( 'tafri_travel_show_single_post_pagination',true) != '') {

								the_post_navigation( array(
									'next_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html(get_theme_mod('tafri_travel_next_single_post_navigation_text','Next') ) . '</span> ' .
										'<span class="screen-reader-text">' . __( 'Next post:', 'tafri-travel' ) . '</span> ' ,
									'prev_text' => '<span class="meta-nav" aria-hidden="true">' .esc_html(get_theme_mod('tafri_travel_prev_single_post_navigation_text','Previous')) . '</span> ' .
										'<span class="screen-reader-text">' . __( 'Previous post:', 'tafri-travel' ) . '</span> ' ,
								) 	);
							}

						endwhile; // End of the loop.?>
		       	</div>
		    </div>
	    <?php }else if($tafri_travel_left_right == 'Right Sidebar'){ ?>
	    	<div class="row m-0">
		       	<div class="col-lg-8 col-md-8" class="content-box pages-te">
		       		<?php if(get_theme_mod('tafri_travel_single_post_breadcrumb',true) != ''){ ?>
			            <div class="post-breadcrumbs">
			                <?php tafri_travel_the_breadcrumb(); ?>
			            </div>
		          	<?php }?>
					<?php
						/* Start the Loop */
						while ( have_posts() ) : the_post();

							get_template_part( 'template-parts/content-single' );

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;?>

							<?php if( get_theme_mod( 'tafri_travel_show_single_post_pagination',true) != '') {

								the_post_navigation( array(
									'next_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html(get_theme_mod('tafri_travel_next_single_post_navigation_text','Next') ) . '</span> ' .
										'<span class="screen-reader-text">' . __( 'Next post:', 'tafri-travel' ) . '</span> ' ,
									'prev_text' => '<span class="meta-nav" aria-hidden="true">' .esc_html(get_theme_mod('tafri_travel_prev_single_post_navigation_text','Previous')) . '</span> ' .
										'<span class="screen-reader-text">' . __( 'Previous post:', 'tafri-travel' ) . '</span> ' ,
								) 	);
							}

						endwhile; // End of the loop.?>
		       	</div>
				<div id="sidebar" class="col-lg-4 col-md-4">
					<?php dynamic_sidebar('sidebar-1'); ?>
				</div>
			</div>
		<?php }else if($tafri_travel_left_right == 'One Column'){ ?>
			<div class="content-box pages-te">
				<?php if(get_theme_mod('tafri_travel_single_post_breadcrumb',true) != ''){ ?>
		            <div class="post-breadcrumbs">
		                <?php tafri_travel_the_breadcrumb(); ?>
		            </div>
	          	<?php }?>
				<?php
					/* Start the Loop */
					while ( have_posts() ) : the_post();

						get_template_part( 'template-parts/content-single' );

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;?>

						<?php if( get_theme_mod( 'tafri_travel_show_single_post_pagination',true) != '') {

							the_post_navigation( array(
								'next_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html(get_theme_mod('tafri_travel_next_single_post_navigation_text','Next') ) . '</span> ' .
									'<span class="screen-reader-text">' . __( 'Next post:', 'tafri-travel' ) . '</span> ' ,
								'prev_text' => '<span class="meta-nav" aria-hidden="true">' .esc_html(get_theme_mod('tafri_travel_prev_single_post_navigation_text','Previous')) . '</span> ' .
									'<span class="screen-reader-text">' . __( 'Previous post:', 'tafri-travel' ) . '</span> ' ,
							) 	);
						}

					endwhile; // End of the loop.?>
	       	</div>
	    <?php }else if($tafri_travel_left_right == 'Grid Layout'){ ?>
			<div class="row m-0">
				<div class="col-lg-8 col-md-8" class="content-box pages-te">
					<?php if(get_theme_mod('tafri_travel_single_post_breadcrumb',true) != ''){ ?>
			            <div class="post-breadcrumbs">
			                <?php tafri_travel_the_breadcrumb(); ?>
			            </div>
		          	<?php }?>
					<?php
						/* Start the Loop */
						while ( have_posts() ) : the_post();

							get_template_part( 'template-parts/content-single' );

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;?>

							<?php if( get_theme_mod( 'tafri_travel_show_single_post_pagination',true) != '') {

								the_post_navigation( array(
									'next_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html(get_theme_mod('tafri_travel_next_single_post_navigation_text','Next') ) . '</span> ' .
										'<span class="screen-reader-text">' . __( 'Next post:', 'tafri-travel' ) . '</span> ' ,
									'prev_text' => '<span class="meta-nav" aria-hidden="true">' .esc_html(get_theme_mod('tafri_travel_prev_single_post_navigation_text','Previous')) . '</span> ' .
										'<span class="screen-reader-text">' . __( 'Previous post:', 'tafri-travel' ) . '</span> ' ,
								) 	);
							}

						endwhile; // End of the loop.?>
		       	</div>
				<div id="sidebar" class="col-lg-4 col-md-4">
					<?php dynamic_sidebar('sidebar-2'); ?>
				</div>
			</div>
		<?php } else { ?>
			<div class="row m-0">
		       	<div class="col-lg-8 col-md-8" class="content-box pages-te">
		       		<?php if(get_theme_mod('tafri_travel_single_post_breadcrumb',true) != ''){ ?>
			            <div class="post-breadcrumbs">
			                <?php tafri_travel_the_breadcrumb(); ?>
			            </div>
		          	<?php }?>
					<?php
						/* Start the Loop */
						while ( have_posts() ) : the_post();

							get_template_part( 'template-parts/content-single' );

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;?>

							<?php if( get_theme_mod( 'tafri_travel_show_single_post_pagination',true) != '') {

								the_post_navigation( array(
									'next_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html(get_theme_mod('tafri_travel_next_single_post_navigation_text','Next') ) . '</span> ' .
										'<span class="screen-reader-text">' . __( 'Next post:', 'tafri-travel' ) . '</span> ' ,
									'prev_text' => '<span class="meta-nav" aria-hidden="true">' .esc_html(get_theme_mod('tafri_travel_prev_single_post_navigation_text','Previous')) . '</span> ' .
										'<span class="screen-reader-text">' . __( 'Previous post:', 'tafri-travel' ) . '</span> ' ,
								) 	);
							}

						endwhile; // End of the loop.?>
		       	</div>
				<div id="sidebar" class="col-lg-4 col-md-4">
					<?php dynamic_sidebar('sidebar-1'); ?>
				</div>
			</div>
		<?php }?>
	    <div class="clearfix"></div>
    </main>
</div>

<?php get_footer(); ?>