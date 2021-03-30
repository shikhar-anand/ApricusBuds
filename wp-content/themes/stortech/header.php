<?php
	/**
	 * The header for our theme.
	 *
	 * This is the template that displays all of the <head> section and everything up until <div id="content">
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
	 *
	 * @package Theme Palace
	 * @subpackage Stortech
	 * @since Stortech 1.0.0
	 */

	/**
	 * stortech_doctype hook
	 *
	 * @hooked stortech_doctype -  10
	 *
	 */
	do_action( 'stortech_doctype' );

?>
<head>
<?php
	/**
	 * stortech_before_wp_head hook
	 *
	 * @hooked stortech_head -  10
	 *
	 */
	do_action( 'stortech_before_wp_head' );

	wp_head(); 
?>
</head>

<body <?php body_class(); ?>>

<?php do_action( 'wp_body_open' ); ?>

<?php
	/**
	 * stortech_page_start_action hook
	 *
	 * @hooked stortech_page_start -  10
	 *
	 */
	do_action( 'stortech_page_start_action' ); 

	/**
	 * stortech_loader_action hook
	 *
	 * @hooked stortech_loader -  10
	 *
	 */
	do_action( 'stortech_before_header' );

	/**
	 * stortech_header_action hook
	 *
	 * @hooked stortech_header_start -  10
	 * @hooked stortech_site_branding -  20
	 * @hooked stortech_site_navigation -  30
	 * @hooked stortech_header_end -  50
	 *
	 */
	do_action( 'stortech_header_action' );

	/**
	 * stortech_content_start_action hook
	 *
	 * @hooked stortech_content_start -  10
	 *
	 */
	do_action( 'stortech_content_start_action' );

	/**
	 * stortech_header_image_action hook
	 *
	 * @hooked stortech_header_image -  10
	 *
	 */
	do_action( 'stortech_header_image_action' );

    if ( stortech_is_frontpage() ) {
    	$options = stortech_get_theme_options();
    	$sorted = array();
    	if ( ! empty( $options['sortable'] ) ) {
			$sorted = explode( ',' , $options['sortable'] );
		}

		foreach ( $sorted as $section ) {
			add_action( 'stortech_primary_content', 'stortech_add_'. $section .'_section' );
		}
		do_action( 'stortech_primary_content' );
	}

?>
	