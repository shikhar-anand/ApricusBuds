<!DOCTYPE html>
<html id="goup" class="no-js" <?php language_attributes();?>>
<head>
    <meta http-equiv="content-type" content="<?php bloginfo( 'html_type' ); ?>" charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open();?>
        <a class="skip-link" href="#site-content"><?php _e( 'Skip to the content', 'mencia' ); ?></a>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container">
          <?php the_custom_logo(); ?>
          <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
          <div class="header-titles-wrapper">
              <button class="navbar-toggler navbar-toggler-right toggle nav-toggle mobile-nav-toggle" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" data-toggle-target=".menu-modal"  data-toggle-body-class="showing-menu-modal" data-set-focus=".close-nav-toggle">
                <?php _e( 'Menu', 'mencia' ); ?>
                <i class="fas fa-bars"></i>
            </button>
        </div><!-- .header-titles-wrapper -->

        <!-- Collect the nav links, forms, and other content for toggling -->           
                <nav class="primary-menu-wrapper" aria-label="<?php esc_attr_e( 'Horizontal', 'mencia' ); ?>" role="navigation">
                    <ul class="primary-menu reset-list-style">   
                        <?php
                            if ( has_nav_menu( 'primary' ) ) {
                                wp_nav_menu( array(
                                    'theme_location' => 'primary',
                                    'menu_id' => 'menu-above',
                                    'container' => 'div',
                                    'container_class' => 'collapse navbar-collapse',
                                    'container_id' => 'navbarResponsive',
                                    'items_wrap' => '%3$s',
                                    'menu_class' => 'navbar-nav ml-auto'
                            )); 
                                    } else {
                                        wp_list_pages( array(
                                            'match_menu_classes'    => true,
                                            'title_li'              => false,
                                        ) );
                                    }
                            ?>
                    </ul>
                </nav><!-- .primary-menu-wrapper -->
        </div><!--.container-->
    </nav>
    <?php
        // Output the menu modal.
        get_template_part( 'parts/modal-menu' );
    ?>