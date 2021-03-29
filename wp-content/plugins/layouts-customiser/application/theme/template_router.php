<?php

/**
 * Hooks into the template_include filter and select different page template for content that has an Layout assigned.
 */
/** @noinspection PhpUndefinedClassInspection */
final class WPDDL_Integration_Theme_Template_Router extends WPDDL_Integration_Theme_Template_Router_Abstract {


	/**
	 * Hooked into the template_include filter.
	 *
	 * @param string $template Default template path.
	 * @return string Template path.
	 */
	public function template_include( $template ) {

		if( is_ddlayout_assigned() ) {
			$template_file = null;
			if( is_single() || is_404() || is_page()) {
                            $template_file = 'template-page.php';
			} else {
                            $template_file = 'template-page.php';
			} 

			if( null != $template_file ) {
                            $template = dirname( __FILE__ ) . '/view/' . $template_file;
			}
		}

		return $template;
	}


	/**
	 * @return string Absolute path (without the final slash) to the directory where custom page template files are located.
	 * @todo Change this if needed.
	 */
	protected function get_template_path() {
		return dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'view';
	}

}