<?php

class WPDDL_Integration_Theme_Widgets_primarymenu extends WP_Widget {

    function __construct() {
        parent::__construct(
                'WPDDL_2015_primary_menu_widget',
                __('Layouts: Primary Menu', 'WPDDL_2015_primary_menu_domain'),
                array('description' => __('Primary menu widget', 'WPDDL_2015_primary_menu_domain'),)
        );
    }


    public function widget($args, $instance) {
         if ( has_nav_menu( 'primary' ) ) : ?>
                <nav id="site-navigation" class="main-navigation" role="navigation">
                        <?php
                                // Primary navigation menu.
                                wp_nav_menu( array(
                                        'menu_class'     => 'nav-menu',
                                        'theme_location' => 'primary',
                                ) );
                        ?>
                </nav><!-- .main-navigation -->
        <?php endif;
    }

}