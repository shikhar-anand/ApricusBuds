<?php
/**
 * The template for displaying Search Results pages.
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
                    <div class="col-lg-4 col-md-4">
                        <?php get_sidebar();?>
                    </div>
                    <div id="post-<?php the_ID(); ?>" <?php post_class('col-lg-8 col-md-8'); ?>>
                        <?php if(get_theme_mod('tafri_travel_pagination_position_options', 'Only Bottom') == 'Only Top' || get_theme_mod('tafri_travel_pagination_position_options', 'Only Bottom') == 'Both Top & Bottom'){ ?>
                            <?php if( get_theme_mod( 'tafri_travel_show_post_pagination',true) != '') { ?>
                                <div class="navigation">
                                    <?php tafri_travel_pagination_type(); ?>
                                </div> 
                            <?php } ?>
                        <?php } ?>
                        <h1 class="entry-title"><?php /* translators: %s: search term */ printf( esc_html__( 'Results For: %s','tafri-travel'), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
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
                        <h1 class="entry-title"><?php /* translators: %s: search term */ printf( esc_html__( 'Results For: %s','tafri-travel'), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
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
                    <h1 class="entry-title"><?php /* translators: %s: search term */ printf( esc_html__( 'Results For: %s','tafri-travel'), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
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
                        <h1 class="entry-title"><?php /* translators: %s: search term */ printf( esc_html__( 'Results For: %s','tafri-travel'), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
                        <?php if ( have_posts() ) :
                          /* Start the Loop */
                            while ( have_posts() ) : the_post();
                                get_template_part( 'template-parts/grid-layout' ); 
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
                <div class="row">
                    <div id="post-<?php the_ID(); ?>" <?php post_class('col-lg-8 col-md-8'); ?>>
                       <?php if(get_theme_mod('tafri_travel_pagination_position_options', 'Only Bottom') == 'Only Top' || get_theme_mod('tafri_travel_pagination_position_options', 'Only Bottom') == 'Both Top & Bottom'){ ?>
                            <?php if( get_theme_mod( 'tafri_travel_show_post_pagination',true) != '') { ?>
                                <div class="navigation">
                                    <?php tafri_travel_pagination_type(); ?>
                                </div> 
                            <?php } ?>
                        <?php } ?>
                        <h1 class="entry-title"><?php /* translators: %s: search term */ printf( esc_html__( 'Results For: %s','tafri-travel'), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
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