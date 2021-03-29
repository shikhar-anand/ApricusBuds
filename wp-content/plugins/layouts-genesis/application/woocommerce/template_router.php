<?php

/**
 * Hooks into the template_include filter and select different page template for content that has an Layout assigned.
 */
/** @noinspection PhpUndefinedClassInspection */
final class WPDDL_Integration_Woocommerce_Template_Router extends WPDDL_Integration_Theme_Template_Router_Abstract {

    protected function __construct()
    {
        global $woocommerce;
        /** Take control of shop template loading */
        remove_filter( 'template_include', array( &$woocommerce, 'template_loader' ) );
        parent::__construct();
    }

    /**
	 * Hooked into the template_include filters
	 *
	 * @param string $template Default template path.
	 * @return string Template path.
	 */
	public function template_include( $template ) {
		$tpl = '';

		if( is_ddlayout_assigned() ) {

			if ( is_single() && 'product' == get_post_type() ) {

				$tpl = locate_template( array( 'page.php' ) );

			}
			elseif ( is_post_type_archive( 'product' ) ||  is_page( get_option( 'woocommerce_shop_page_id' ) ) ) {

                $tpl = locate_template( array( 'page_archive.php' ) );

			}
			elseif ( is_tax() ) {

                $tpl = locate_template( array( 'page_archive.php' ) );
			}

            if( $tpl ) $template = $tpl;
		}

		return $template;
	}


	/**
	 * @return string Absolute path (without the final slash) to the directory where custom page template files are located.
	 * @todo Change this if needed.
	 */
	protected function get_template_path() {
		return get_template_directory();
	}

}