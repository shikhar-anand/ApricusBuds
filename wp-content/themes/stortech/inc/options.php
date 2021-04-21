<?php
/**
 * Theme Palace options
 *
 * @package Theme Palace
 * @subpackage Stortech
 * @since Stortech 1.0.0
 */

/**
 * List of pages for page choices.
 * @return Array Array of page ids and name.
 */

function stortech_product_choices() {
    $full_product_list = array();
    $product_id = array();
    $loop = new WP_Query(array('post_type' => array('product', 'product_variation'), 'posts_per_page' => -1));
    while ($loop->have_posts()) : $loop->the_post();
        $product_id[] = get_the_id();
    endwhile;
    wp_reset_postdata();
    $choices = array();
    $choices[0] = esc_html__( '--Select--', 'stortech' );
    foreach ( $product_id  as $id ) {
        $choices[ $id ] = get_the_title( $id );
    }
    return  $choices;
}

function stortech_page_choices() {
    $pages = get_pages();
    $choices = array();
    $choices[0] = esc_html__( '--Select--', 'stortech' );
    foreach ( $pages as $page ) {
        $choices[ $page->ID ] = $page->post_title;
    }
    return  $choices;
}

/**
 * List of posts for post choices.
 * @return Array Array of post ids and name.
 */
function stortech_post_choices() {
    $posts = get_posts( array( 'numberposts' => -1 ) );
    $choices = array();
    $choices[0] = esc_html__( '--Select--', 'stortech' );
    foreach ( $posts as $post ) {
        $choices[ $post->ID ] = $post->post_title;
    }
    return  $choices;
}


if ( ! function_exists( 'stortech_selected_sidebar' ) ) :
    /**
     * Sidebars options
     * @return array Sidbar positions
     */
    function stortech_selected_sidebar() {
        $stortech_selected_sidebar = array(
            'sidebar-1'             => esc_html__( 'Default Sidebar', 'stortech' ),
        );

        $output = apply_filters( 'stortech_selected_sidebar', $stortech_selected_sidebar );

        return $output;
    }
endif;

if ( ! function_exists( 'stortech_site_layout' ) ) :
    /**
     * Site Layout
     * @return array site layout options
     */
    function stortech_site_layout() {
        $stortech_site_layout = array(
            'wide-layout'  => get_template_directory_uri() . '/assets/images/full.png',
            'boxed-layout' => get_template_directory_uri() . '/assets/images/boxed.png',
        );

        $output = apply_filters( 'stortech_site_layout', $stortech_site_layout );
        return $output;
    }
endif;


if ( ! function_exists( 'stortech_global_sidebar_position' ) ) :
    /**
     * Global Sidebar position
     * @return array Global Sidebar positions
     */
    function stortech_global_sidebar_position() {
        $stortech_global_sidebar_position = array(
            'right-sidebar' => get_template_directory_uri() . '/assets/images/right.png',
            'no-sidebar'    => get_template_directory_uri() . '/assets/images/full.png',
        );

        $output = apply_filters( 'stortech_global_sidebar_position', $stortech_global_sidebar_position );

        return $output;
    }
endif;


if ( ! function_exists( 'stortech_sidebar_position' ) ) :
    /**
     * Sidebar position
     * @return array Sidbar positions
     */
    function stortech_sidebar_position() {
        $stortech_sidebar_position = array(
            'right-sidebar' => get_template_directory_uri() . '/assets/images/right.png',
            'no-sidebar'    => get_template_directory_uri() . '/assets/images/full.png',
        );

        $output = apply_filters( 'stortech_sidebar_position', $stortech_sidebar_position );

        return $output;
    }
endif;


if ( ! function_exists( 'stortech_pagination_options' ) ) :
    /**
     * Pagination
     * @return array site pagination options
     */
    function stortech_pagination_options() {
        $stortech_pagination_options = array(
            'numeric'   => esc_html__( 'Numeric', 'stortech' ),
            'default'   => esc_html__( 'Default(Older/Newer)', 'stortech' ),
        );

        $output = apply_filters( 'stortech_pagination_options', $stortech_pagination_options );

        return $output;
    }
endif;

if ( ! function_exists( 'stortech_switch_options' ) ) :
    /**
     * List of custom Switch Control options
     * @return array List of switch control options.
     */
    function stortech_switch_options() {
        $arr = array(
            'on'        => esc_html__( 'Enable', 'stortech' ),
            'off'       => esc_html__( 'Disable', 'stortech' )
        );
        return apply_filters( 'stortech_switch_options', $arr );
    }
endif;

if ( ! function_exists( 'stortech_hide_options' ) ) :
    /**
     * List of custom Switch Control options
     * @return array List of switch control options.
     */
    function stortech_hide_options() {
        $arr = array(
            'on'        => esc_html__( 'Yes', 'stortech' ),
            'off'       => esc_html__( 'No', 'stortech' )
        );
        return apply_filters( 'stortech_hide_options', $arr );
    }
endif;

if ( ! function_exists( 'stortech_sortable_sections' ) ) :
    /**
     * List of sections Control options
     * @return array List of Sections control options.
     */
    function stortech_sortable_sections() {
        $sections = array(
            'slider'                => esc_html__( 'Main Slider', 'stortech' ),
            'accessories'           => esc_html__( 'Accessories Section', 'stortech' ),
            'testimonial'           => esc_html__( 'Testimonial Section', 'stortech' ),
        );
        return apply_filters( 'stortech_sortable_sections', $sections );
    }
endif;

if ( ! function_exists( 'stortech_accessories_product_content_type' ) ) :
    /**
     * List of accessories product
     * @return array List of accessories product.
     */
    function stortech_accessories_product_content_type() {
        $arr = array(
            'page'          => esc_html__( 'Page', 'stortech' ),
        );
        if ( class_exists( 'WooCommerce' ) ) {
            $arr = array_merge( $arr, 
                array( 
                    'product'           => esc_html__( 'Product', 'stortech' ), 
                    ) 
                );
        }

        return apply_filters( 'stortech_featured_options', $arr );
    }
endif;

