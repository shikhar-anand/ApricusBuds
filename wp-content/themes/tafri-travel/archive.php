<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package tafri-travel
 */

get_header(); ?>

<main id="main" role="main" class="our-services">
    <div class="innerlightbox">
        <div class="container">
            <?php
            $tafri_travel_left_right = get_theme_mod( 'tafri_travel_post_sidebar_options','Right Sidebar');
            if($tafri_travel_left_right == 'Left Sidebar'){ ?>
                <div class="row m-0">
                    <div class="col-lg-4 col-md-4"><?php get_sidebar();?></div>
                    <div id="post-<?php the_ID(); ?>" <?php post_class('col-lg-8 col-md-8'); ?>>
                        <?php if(get_theme_mod('tafri_travel_pagination_position_options', 'Only Bottom') == 'Only Top' || get_theme_mod('tafri_travel_pagination_position_options', 'Only Bottom') == 'Both Top & Bottom'){ ?>
                            <?php if( get_theme_mod( 'tafri_travel_show_post_pagination',true) != '') { ?>
                                <div class="navigation">
                                    <?php tafri_travel_pagination_type(); ?>
                                </div> 
                            <?php } ?>
                        <?php } ?>
                        <?php
                            the_archive_title( '<h1 class="page-title">', '</h1>' );
                            the_archive_description( '<div class="taxonomy-description">', '</div>' );
                        ?>
                        <?php tafri_travel_post_content(); ?>
                        <?php if(get_theme_mod('tafri_travel_pagination_position_options', 'Only Bottom') == 'Only Bottom' || get_theme_mod('tafri_travel_pagination_position_options', 'Only Bottom') == 'Both Top & Bottom'){ ?>
                            <?php if( get_theme_mod( 'tafri_travel_show_post_pagination',true) != '') { ?>
                                <div class="navigation">
                                    <?php tafri_travel_pagination_type(); ?>
                                </div> 
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            <?php }else if($tafri_travel_left_right == 'Right Sidebar'){ ?>
                <div class="row m-0">
                    <div id="post-<?php the_ID(); ?>" <?php post_class('col-lg-8 col-md-8'); ?>>
                        <?php if(get_theme_mod('tafri_travel_pagination_position_options', 'Only Bottom') == 'Only Top' || get_theme_mod('tafri_travel_pagination_position_options', 'Only Bottom') == 'Both Top & Bottom'){ ?>
                            <?php if( get_theme_mod( 'tafri_travel_show_post_pagination',true) != '') { ?>
                                <div class="navigation">
                                    <?php tafri_travel_pagination_type(); ?>
                                </div> 
                            <?php } ?>
                        <?php } ?>
                        <?php
                            the_archive_title( '<h1 class="page-title">', '</h1>' );
                            the_archive_description( '<div class="taxonomy-description">', '</div>' );
                        ?>
                        <?php tafri_travel_post_content(); ?>
                        <?php if(get_theme_mod('tafri_travel_pagination_position_options', 'Only Bottom') == 'Only Bottom' || get_theme_mod('tafri_travel_pagination_position_options', 'Only Bottom') == 'Both Top & Bottom'){ ?>
                            <?php if( get_theme_mod( 'tafri_travel_show_post_pagination',true) != '') { ?>
                                <div class="navigation">
                                    <?php tafri_travel_pagination_type(); ?>
                                </div> 
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <?php get_sidebar();?>
                    </div>
                </div>
            <?php }else if($tafri_travel_left_right == 'One Column'){ ?>
                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <?php if(get_theme_mod('tafri_travel_pagination_position_options', 'Only Bottom') == 'Only Top' || get_theme_mod('tafri_travel_pagination_position_options', 'Only Bottom') == 'Both Top & Bottom'){ ?>
                        <?php if( get_theme_mod( 'tafri_travel_show_post_pagination',true) != '') { ?>
                            <div class="navigation">
                                <?php tafri_travel_pagination_type(); ?>
                            </div> 
                        <?php } ?>
                    <?php } ?>
                    <?php
                        the_archive_title( '<h1 class="page-title">', '</h1>' );
                        the_archive_description( '<div class="taxonomy-description">', '</div>' );
                    ?>
                    <?php tafri_travel_post_content(); ?>
                    <?php if(get_theme_mod('tafri_travel_pagination_position_options', 'Only Bottom') == 'Only Bottom' || get_theme_mod('tafri_travel_pagination_position_options', 'Only Bottom') == 'Both Top & Bottom'){ ?>
                        <?php if( get_theme_mod( 'tafri_travel_show_post_pagination',true) != '') { ?>
                            <div class="navigation">
                                <?php tafri_travel_pagination_type(); ?>
                            </div> 
                        <?php } ?>
                    <?php } ?>
                </div>
            <?php }else if($tafri_travel_left_right == 'Grid Layout'){ ?>
                <div class="row m-0">
                    <div id="post-<?php the_ID(); ?>" <?php post_class('col-lg-9 col-md-9 row'); ?>>
                        <?php if(get_theme_mod('tafri_travel_pagination_position_options', 'Only Bottom') == 'Only Top' || get_theme_mod('tafri_travel_pagination_position_options', 'Only Bottom') == 'Both Top & Bottom'){ ?>
                            <?php if( get_theme_mod( 'tafri_travel_show_post_pagination',true) != '') { ?>
                                <div class="navigation">
                                    <?php tafri_travel_pagination_type(); ?>
                                </div> 
                            <?php } ?>
                        <?php } ?>
                        <?php
                            the_archive_title( '<h1 class="page-title">', '</h1>' );
                            the_archive_description( '<div class="taxonomy-description">', '</div>' );
                        ?>
                        <?php if ( have_posts() ) :
                          /* Start the Loop */
                            while ( have_posts() ) : the_post();
                                get_template_part( 'template-parts/grid-layout' ); 
                            endwhile;
                            else :
                                get_template_part( 'no-results' );
                            endif; 
                        ?>
                        <?php if ( have_posts() ) :
                          /* Start the Loop */
                          while ( have_posts() ) : the_post();
                            get_template_part( 'template-parts/single-post' ); 
                          endwhile;
                          else :
                            get_template_part( 'no-results' ); 
                          endif; 
                        ?>
                        <?php if(get_theme_mod('tafri_travel_pagination_position_options', 'Only Bottom') == 'Only Bottom' || get_theme_mod('tafri_travel_pagination_position_options', 'Only Bottom') == 'Both Top & Bottom'){ ?>
                            <?php if( get_theme_mod( 'tafri_travel_show_post_pagination',true) != '') { ?>
                                <div class="navigation">
                                    <?php tafri_travel_pagination_type(); ?>
                                </div> 
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <?php get_sidebar();?>
                    </div>
                </div>
            <?php } else { ?>
                <div class="row m-0">
                    <div id="post-<?php the_ID(); ?>" <?php post_class('col-lg-8 col-md-8'); ?>>
                        <?php if(get_theme_mod('tafri_travel_pagination_position_options', 'Only Bottom') == 'Only Top' || get_theme_mod('tafri_travel_pagination_position_options', 'Only Bottom') == 'Both Top & Bottom'){ ?>
                            <?php if( get_theme_mod( 'tafri_travel_show_post_pagination',true) != '') { ?>
                                <div class="navigation">
                                    <?php tafri_travel_pagination_type(); ?>
                                </div> 
                            <?php } ?>
                        <?php } ?>
                        <?php
                            the_archive_title( '<h1 class="page-title">', '</h1>' );
                            the_archive_description( '<div class="taxonomy-description">', '</div>' );
                        ?>
                        <?php tafri_travel_post_content(); ?>
                        <?php if(get_theme_mod('tafri_travel_pagination_position_options', 'Only Bottom') == 'Only Bottom' || get_theme_mod('tafri_travel_pagination_position_options', 'Only Bottom') == 'Both Top & Bottom'){ ?>
                            <?php if( get_theme_mod( 'tafri_travel_show_post_pagination',true) != '') { ?>
                                <div class="navigation">
                                    <?php tafri_travel_pagination_type(); ?>
                                </div> 
                            <?php } ?>
                        <?php } ?> 
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <?php get_sidebar();?>
                    </div>
                </div>
            <?php }?>
            <div class="clearfix"></div>
        </div>
    </div>
</main>

<?php get_footer(); ?>