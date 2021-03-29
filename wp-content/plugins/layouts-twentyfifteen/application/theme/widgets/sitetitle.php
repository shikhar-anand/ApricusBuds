<?php
// Creating the widget 
class WPDDL_Integration_Theme_Widgets_sitetitle extends WP_Widget {

    function __construct() {
        parent::__construct(
                'WPDDL_2015_header_widget',
                __('Layouts: Website Branding', 'WPDDL_2015_header_domain'),
                array('description' => __('Website title and tagline', 'WPDDL_2015_header_domain'),)
        );
    }


    public function widget($args, $instance) {
        ?>
        <header id="masthead" class="site-header" role="banner">
                <div class="site-branding">
                        <?php
                                if ( is_front_page() && is_home() ) : ?>
                                        <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                                <?php else : ?>
                                        <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                                <?php endif;

                                $description = get_bloginfo( 'description', 'display' );
                                if ( $description || is_customize_preview() ) : ?>
                                        <p class="site-description"><?php echo $description; ?></p>
                                <?php endif;
                        ?>
                        <button class="secondary-toggle"><?php _e( 'Menu and widgets', 'twentyfifteen' ); ?></button>
                </div><!-- .site-branding -->
        </header><!-- .site-header -->
        <?php
    }

}