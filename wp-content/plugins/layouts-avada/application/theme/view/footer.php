<?php
/**
 * The template for displaying the footer
 * Taken from Avada Theme.
 */

global $c_pageID;
?>

<?php // Footer moved to cell ?>

</div> <!-- wrapper -->

<?php
// Check if boxed side header layout is used; if so close the #boxed-wrapper container
if ( ( ( Avada()->settings->get( 'layout' ) == 'Boxed' && get_post_meta( $c_pageID, 'pyre_page_bg_layout', true ) == 'default' ) || get_post_meta( $c_pageID, 'pyre_page_bg_layout', true ) == 'boxed' ) &&
	 Avada()->settings->get( 'header_position' ) != 'Top'

) {
?>
	</div> <!-- #boxed-wrapper -->
<?php
}

?>
<a class="fusion-one-page-text-link fusion-page-load-link"></a>
<!-- W3TC-include-js-head -->

<?php
wp_footer();

// Echo the scripts added to the "before </body>" field in Theme Options
echo Avada()->settings->get( 'space_body' );
?>

<!--[if lte IE 8]>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/respond.js"></script>
<![endif]-->
</body>
</html>
