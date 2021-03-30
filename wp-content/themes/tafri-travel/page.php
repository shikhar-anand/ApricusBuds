<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package tafri-travel
 */

get_header(); ?>

<?php do_action( 'tafri_travel_page_header' ); ?>

<main id="main" role="main" class="content-box">
    <div  class="container">
        <?php $tafri_travel_theme_lay = get_theme_mod( 'tafri_travel_page_sidebar_option','One Column');
        if($tafri_travel_theme_lay == 'One Column'){ ?>
                <?php while ( have_posts() ) : the_post();

                    get_template_part( 'template-parts/content-page'); 
              
                endwhile; ?>
        <?php }else if($tafri_travel_theme_lay == 'Right Sidebar'){ ?>
            <div class="row">
                <div class="background-img-skin col-lg-9 col-md-9">
                    <?php while ( have_posts() ) : the_post();

                        get_template_part( 'template-parts/content-page'); 
                  
                    endwhile; ?>
                </div>
                <div id="sidebar" class="col-lg-3 col-md-3">
                    <?php dynamic_sidebar('sidebar-2'); ?>
                </div>
            </div>
        <?php }else if($tafri_travel_theme_lay == 'Left Sidebar'){ ?>
            <div class="row">
                <div id="sidebar" class="col-lg-3 col-md-3">
                    <?php dynamic_sidebar('sidebar-2'); ?>
                </div>
                <div class="background-img-skin col-lg-9 col-md-9">
                    <?php while ( have_posts() ) : the_post();

                        get_template_part( 'template-parts/content-page'); 
                  
                    endwhile; ?>
                </div>
            </div>
        <?php }else {?>
            <div class="row">
                <div class="background-img-skin col-lg-9 col-md-9">
                    <?php while ( have_posts() ) : the_post();

                        get_template_part( 'template-parts/content-page'); 
                  
                    endwhile; ?>
                </div>
                <div id="sidebar" class="col-lg-3 col-md-3">
                    <?php dynamic_sidebar('sidebar-2'); ?>
                </div>
            </div>
        <?php } ?>
    </div>
</main>

<?php do_action( 'tafri_travel_page_footer' ); ?>

<?php get_footer(); ?>