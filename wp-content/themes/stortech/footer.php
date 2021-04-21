<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Theme Palace
 * @subpackage Stortech
 * @since Stortech 1.0.0
 */

/**
 * stortech_footer_primary_content hook
 *
 * @hooked stortech_add_contact_section -  10
 *
 */
do_action( 'stortech_footer_primary_content' );

/**
 * stortech_content_end_action hook
 *
 * @hooked stortech_content_end -  10
 *
 */
do_action( 'stortech_content_end_action' );

/**
 * stortech_content_end_action hook
 *
 * @hooked stortech_footer_start -  10
 * @hooked stortech_Footer_Widgets->add_footer_widgets -  20
 * @hooked stortech_footer_site_info -  40
 * @hooked stortech_footer_end -  100
 *
 */
do_action( 'stortech_footer' );

/**
 * stortech_page_end_action hook
 *
 * @hooked stortech_page_end -  10
 *
 */
do_action( 'stortech_page_end_action' ); 

?>

<?php wp_footer(); ?>

</body>
</html>
