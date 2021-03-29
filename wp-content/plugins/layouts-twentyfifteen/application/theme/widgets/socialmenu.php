<?php
class WPDDL_Integration_Theme_Widgets_socialmenu extends WP_Widget {

    function __construct() {
        parent::__construct(
                'WPDDL_2015_social_menu_widget',
                __('Layouts: Social Menu', 'WPDDL_2015_social_menu_domain'),
                array('description' => __('Social Menu Widget', 'WPDDL_2015_primary_menu_domain'),)
        );
    }


    public function widget($args, $instance) {
        if ( has_nav_menu( 'social' ) ) : ?>
            <nav id="social-navigation" class="social-navigation" role="navigation">
                    <?php
                            // Social links navigation menu.
                            wp_nav_menu( array(
                                    'theme_location' => 'social',
                                    'depth'          => 1,
                                    'link_before'    => '<span class="screen-reader-text">',
                                    'link_after'     => '</span>',
                            ) );
                    ?>
            </nav><!-- .social-navigation -->
        <?php endif; 

    }

}