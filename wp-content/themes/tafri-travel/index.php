<?php
/**
 * The template for displaying home page.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package tafri-travel
 */

get_header(); ?>

<main id="main" role="main" class="our-services">
  <div class="innerlightbox">
    <?php if(get_theme_mod('tafri_travel_slider_display_option','Home page') == 'Blog Page' || get_theme_mod('tafri_travel_slider_display_option') == 'Both Home page & Blog Page'){ ?>
      <?php if( get_theme_mod( 'tafri_travel_slider_hide', false) != '' || get_theme_mod( 'tafri_travel_enable_disable_slider', false) != '') { ?>
        <section id="slider">
          <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="<?php echo esc_attr(get_theme_mod('tafri_travel_slider_speed', 3000)); ?>"> 
            <?php $tafri_travel_slider_pages = array();
              for ( $count = 1; $count <= 4; $count++ ) {
                $mod = intval( get_theme_mod( 'tafri_travel_slider_page' . $count ));
                if ( 'page-none-selected' != $mod ) {
                  $tafri_travel_slider_pages[] = $mod;
                }
              }
              if( !empty($tafri_travel_slider_pages) ) :
                $args = array(
                  'post_type' => 'page',
                  'post__in' => $tafri_travel_slider_pages,
                  'orderby' => 'post__in'
                );
                $query = new WP_Query( $args );
              if ( $query->have_posts() ) :
                $i = 1;
            ?>     
            <div class="carousel-inner" role="listbox">
              <?php  while ( $query->have_posts() ) : $query->the_post(); ?>
                <div <?php if($i == 1){echo 'class="carousel-item active"';} else{ echo 'class="carousel-item"';}?>>
                  <?php the_post_thumbnail(); ?>
                  <div class="carousel-caption">
                    <div class="inner_carousel">
                      <?php if( get_theme_mod('tafri_travel_slider_title',true) != ''){ ?>
                        <h1><?php the_title(); ?></h1>
                        <hr>
                      <?php } ?> 
                      <?php if( get_theme_mod('tafri_travel_slider_content',true) != ''){ ?>
                        <p><?php $excerpt = get_the_excerpt(); echo esc_html( tafri_travel_string_limit_words( $excerpt, esc_attr(get_theme_mod('tafri_travel_slider_excerpt_number','15')))); ?></p>
                      <?php } ?> 
                      <?php if (get_theme_mod( 'tafri_travel_slider_button',true) != '' || get_theme_mod( 'tafri_travel_show_hide_slider_button',true) != ''){ ?>
                        <?php if( get_theme_mod('tafri_travel_slider_button_text','View All Travels') != ''){ ?>
                          <div class="view-btn">
                            <a href="<?php the_permalink(); ?>"><?php echo esc_html(get_theme_mod('tafri_travel_slider_button_text','View All Travels'));?><span class="screen-reader-text"><?php echo esc_html(get_theme_mod('tafri_travel_slider_button_text','View All Travels'));?></span></a>
                          </div>
                        <?php } ?>
                      <?php }?> 
                    </div>
                  </div>
                </div>
              <?php $i++; endwhile; 
              wp_reset_postdata();?>
            </div>
            <?php else : ?>
              <div class="no-postfound"></div>
            <?php endif;
            endif;?>
            <div class="slider-nex-pre">
              <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
                <span class="screen-reader-text"><?php esc_html_e( 'Previous','tafri-travel' );?></span>
              </a>
              <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
                <span class="screen-reader-text"><?php esc_html_e( 'Next','tafri-travel' );?></span>
              </a>
            </div>
          </div>
          <div class="clearfix"></div>
        </section>
      <?php } ?>
    <?php }?>
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
        <div id="post-<?php the_ID(); ?>" <?php post_class('row'); ?>>
          <?php if(get_theme_mod('tafri_travel_pagination_position_options', 'Only Bottom') == 'Only Top' || get_theme_mod('tafri_travel_pagination_position_options', 'Only Bottom') == 'Both Top & Bottom'){ ?>
            <?php if( get_theme_mod( 'tafri_travel_show_post_pagination',true) != '') { ?>
              <div class="navigation">
                <?php tafri_travel_pagination_type(); ?>
              </div> 
            <?php } ?>
          <?php } ?>
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