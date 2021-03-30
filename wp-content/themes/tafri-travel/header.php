<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div class="content-box">
 *
 * @package tafri-travel
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <?php if ( function_exists( 'wp_body_open' ) ) {
    wp_body_open();
  } else {
    do_action( 'wp_body_open' );
  } ?>
  <?php if(get_theme_mod('tafri_travel_loader_setting',true) != '' || get_theme_mod('tafri_travel_enable_disable_preloader',true) != ''){ ?>
    <div id="pre-loader">
      <div class='demo'>
        <?php $tafri_travel_theme_lay = get_theme_mod( 'tafri_travel_preloader_types','Default');
        if($tafri_travel_theme_lay == 'Default'){ ?>
          <div class='circle'>
            <div class='inner'></div>
          </div>
          <div class='circle'>
            <div class='inner'></div>
          </div>
          <div class='circle'>
            <div class='inner'></div>
          </div>
        <?php }elseif($tafri_travel_theme_lay == 'Circle'){ ?>
          <div class='circle'>
            <div class='inner'></div>
          </div>
        <?php }elseif($tafri_travel_theme_lay == 'Two Circle'){ ?>
          <div class='circle'>
            <div class='inner'></div>
          </div>
          <div class='circle'>
            <div class='inner'></div>
          </div>
        <?php } ?>
      </div>
    </div>
  <?php }?>
  <div id="header" class="text-md-left text-center">
    <a class="screen-reader-text skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'tafri-travel' ); ?></a>
    <?php if( get_theme_mod('tafri_travel_show_hide_topbar',true) != '' || get_theme_mod('tafri_travel_enable_disable_topbar',true) != ''){ ?>
      <div class="top-header">
        <div class="container">
          <div class="row">
            <div class="col-lg-5 col-md-5">
              <div class="timing text-md-left text-center">
                <?php if( get_theme_mod('tafri_travel_timing') != ''){ ?>
                  <p class="mt-2 mb-0"><i class="<?php echo esc_attr(get_theme_mod('tafri_travel_timing_icon','far fa-clock')); ?> mr-2"></i><?php echo esc_html( get_theme_mod('tafri_travel_timing','')); ?></p>
                <?php } ?>
              </div>
            </div>
            <div class="col-lg-4 col-md-4">
              <div class="social-icons mt-1 mb-md-0 mb-2">
                <?php if( get_theme_mod( 'tafri_travel_facebook_url') != '') { ?>
                  <a href="<?php echo esc_url( get_theme_mod( 'tafri_travel_facebook_url','' ) ); ?>"><i class="<?php echo esc_attr(get_theme_mod('tafri_travel_facebook_icon','fab fa-facebook-f')); ?> mt-2 mr-3 ml-2"></i><span class="screen-reader-text"><?php esc_html_e( 'Facebook','tafri-travel' );?></span></a><span>/</span>
                  <?php } ?>
                  <?php if( get_theme_mod( 'tafri_travel_twitter_url') != '') { ?>
                  <a href="<?php echo esc_url( get_theme_mod( 'tafri_travel_twitter_url','' ) ); ?>"><i class="<?php echo esc_attr(get_theme_mod('tafri_travel_twitter_icon','fab fa-twitter')); ?> mt-2 mr-3 ml-2"></i><span class="screen-reader-text"><?php esc_html_e( 'Twitter','tafri-travel' );?></span></a><span>/</span>
                  <?php } ?>
                  <?php if( get_theme_mod( 'tafri_travel_insta_url') != '') { ?>
                  <a href="<?php echo esc_url( get_theme_mod( 'tafri_travel_insta_url','' ) ); ?>"><i class="<?php echo esc_attr(get_theme_mod('tafri_travel_insta_icon','fab fa-instagram')); ?> mt-2 mr-3 ml-2"></i><span class="screen-reader-text"><?php esc_html_e( 'Instagram','tafri-travel' );?></span></a><span>/</span>
                  <?php } ?> 
                  <?php if( get_theme_mod( 'tafri_travel_linkedin_url') != '') { ?>
                  <a href="<?php echo esc_url( get_theme_mod( 'tafri_travel_linkedin_url','' ) ); ?>"><i class="<?php echo esc_attr(get_theme_mod('tafri_travel_linkedin_icon','fab fa-linkedin-in')); ?> mt-2 mr-3 ml-2"></i><span class="screen-reader-text"><?php esc_html_e( 'Linkedin','tafri-travel' );?></span></a><span>/</span>
                  <?php } ?> 
                  <?php if( get_theme_mod( 'tafri_travel_pintrest_url') != '') { ?>
                  <a href="<?php echo esc_url( get_theme_mod( 'tafri_travel_pintrest_url','' ) ); ?>"><i class="<?php echo esc_attr(get_theme_mod('tafri_travel_pintrest_icon','fab fa-pinterest-p')); ?> mt-2 mr-3 ml-2"></i><span class="screen-reader-text"><?php esc_html_e( 'Pinterest','tafri-travel' );?></span></a><span>/</span>
                  <?php } ?>  
                  <?php if( get_theme_mod( 'tafri_travel_youtube_url') != '') { ?>
                  <a href="<?php echo esc_url( get_theme_mod( 'tafri_travel_youtube_url','' ) ); ?>"><i class="<?php echo esc_attr(get_theme_mod('tafri_travel_youtube_icon','fab fa-youtube')); ?> mt-2 mr-3 ml-2"></i><span class="screen-reader-text"><?php esc_html_e( 'Youtube','tafri-travel' );?></span></a>
                <?php } ?>
              </div> 
            </div>
            <?php if( get_theme_mod('tafri_travel_enable_disable_search',true) != '' || get_theme_mod('tafri_travel_mobile_enable_disable_search',true) != ''){ ?>
              <div class="col-lg-1 col-md-1">
                <div class="search-body text-center">
                  <button type="button" class="search-show"><i class="<?php echo esc_attr(get_theme_mod('tafri_travel_search_icon','fas fa-search')); ?>"></i></button>
                </div>
              </div>
            <?php } ?>
            <?php if( get_theme_mod('tafri_travel_enable_disable_myaccount',true) != '' || get_theme_mod('tafri_travel_mobile_enable_disable_myaccount',true) != ''){ ?>
              <div class="<?php if( get_theme_mod('tafri_travel_enable_disable_search',true) != ''){ ?>col-lg-2 col-md-2 <?php } else{ ?>col-lg-3 col-md-3<?php }?>">
                <p class="account-btn my-2 text-center">
                  <a href="<?php the_permalink(get_option('woocommerce_myaccount_page_id')); ?>"><i class="<?php echo esc_attr(get_theme_mod('tafri_travel_myaccount_icon','fas fa-user')); ?> mr-2"></i><?php echo esc_html_e('My Account','tafri-travel'); ?><span class="screen-reader-text"><?php esc_html_e( 'My Account','tafri-travel' );?></span></a>
                </p>
              </div>
            <?php } ?>
            <div class="searchform-inner">
              <?php get_search_form(); ?>
              <button type="button" class="close"aria-label="Close"><span aria-hidden="true">X</span></button>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
    <div class="container">
      <div class="<?php if( get_theme_mod( 'tafri_travel_fixed_header', false) != '' || get_theme_mod( 'tafri_travel_enable_disable_fixed_header', false) != '') { ?> sticky-header"<?php } else { ?>close-sticky <?php } ?>">
        <div class="main-menu">
          <div class="row m-0">
            <div class="col-lg-4 col-md-12">
              <div role="navigation" class="nav left-menu">
                <nav id="primary-site-menu" class="primary-menu" role="navigation" aria-label="<?php esc_attr_e( 'Left Menu', 'tafri-travel' ); ?>">
                  <?php
                    if(has_nav_menu('left-primary')){ 
                      wp_nav_menu( array( 
                        'theme_location' => 'left-primary',
                        'container_class' => 'main-menu-navigation clearfix' ,
                        'menu_class' => 'clearfix',
                        'items_wrap' => '<ul id="%1$s" class="%2$s mobile_nav">%3$s</ul>',
                        'fallback_cb' => 'wp_page_menu',
                      ) );
                    } 
                  ?>
                </nav>
              </div>
            </div>
            <div class="col-lg-4 col-md-5 col-9">
              <div class="logo p-1 text-center">
                <?php if ( has_custom_logo() ) : ?>
                  <div class="site-logo"><?php the_custom_logo(); ?></div>
                <?php endif; ?>
                <?php $blog_info = get_bloginfo( 'name' ); ?>
                <?php if ( ! empty( $blog_info ) ) : ?>
                  <?php if( get_theme_mod('tafri_travel_show_site_title',true) != ''){ ?>
                    <?php if ( is_front_page() && is_home() ) : ?>
                      <h1 class="site-title m-0 text-lg-center text-left"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                    <?php else : ?>
                      <p class="site-title m-0 text-lg-center text-left"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                    <?php endif; ?>
                  <?php }?>
                <?php endif; ?>
                <?php
                $description = get_bloginfo( 'description', 'display' );
                if ( $description || is_customize_preview() ) :
                  ?>
                  <?php if( get_theme_mod('tafri_travel_show_tagline',true) != ''){ ?>
                    <p class="site-description m-0 text-lg-center text-left">
                    <?php echo esc_html($description); ?>
                    </p>
                  <?php }?>
                <?php endif; ?>
              </div>
            </div>
            <div class="col-lg-4 col-md-7 col-3">
              <?php 
                if(has_nav_menu('responsive-menu')){ ?>
                <div class="toggle-menu responsive-menu my-3 text-right">
                  <button role="tab" class="mobiletoggle" onclick="tafri_travel_resmenu_open()"><i class="<?php echo esc_attr(get_theme_mod('tafri_travel_mobile_media_open_menu_icon','fas fa-bars')); ?> p-2"></i><span class="screen-reader-text"><?php esc_html_e('Open Menu','tafri-travel'); ?></span></button>
                </div>
              <?php }?>
              <div id="resmenu-sidebar" class="nav sidebar">
                <nav id="primary-site-menu" class="primary-menu" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'tafri-travel' ); ?>">
                  <?php
                    if(has_nav_menu('responsive-menu')){ 
                      wp_nav_menu( array( 
                        'theme_location' => 'responsive-menu',
                        'container_class' => 'main-menu-navigation clearfix' ,
                        'menu_class' => 'clearfix',
                        'items_wrap' => '<ul id="%1$s" class="%2$s mobile_nav">%3$s</ul>',
                        'fallback_cb' => 'wp_page_menu',
                      ) );
                    } 
                  ?>
                  <a href="javascript:void(0)" class="closebtn responsive-menu" onclick="tafri_travel_resmenu_close()"><i class="<?php echo esc_attr(get_theme_mod('tafri_travel_mobile_media_close_menu_icon','fas fa-times')); ?>"></i><span class="screen-reader-text"><?php esc_html_e('Close Menu','tafri-travel'); ?></span></a>
                </nav>
              </div>
              <div role="navigation" class="nav right-menu">
                <nav id="primary-site-menu" class="primary-menu" role="navigation" aria-label="<?php esc_attr_e( 'Right Menu', 'tafri-travel' ); ?>">
                  <?php
                    if(has_nav_menu('right-primary')){ 
                      wp_nav_menu( array( 
                        'theme_location' => 'right-primary',
                        'container_class' => 'main-menu-navigation clearfix' ,
                        'menu_class' => 'clearfix',
                        'items_wrap' => '<ul id="%1$s" class="%2$s mobile_nav">%3$s</ul>',
                        'fallback_cb' => 'wp_page_menu',
                      ) );
                    } 
                  ?>
                </nav>
              </div>
            </div>
          </div>
          <hr class="m-0">
        </div>
      </div>
    </div>
  </div>