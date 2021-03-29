<?php

/**
 * Hooks into the template_include filter and select different page template for content that has an Layout assigned.
 */
final class WPDDL_Integration_Theme_Template_Router extends WPDDL_Integration_Theme_Template_Router_Abstract {

	public function template_include( $template ) {

		if( is_ddlayout_assigned() ) {
			$template_file = 'template-default.php';

			if( null != $template_file ) {
				$template = dirname( __FILE__ ) . '/view/' . $template_file;
			}

			// modify body class
			add_filter( 'body_class', array( $this, 'modifyBodyClass' ) );
		}

		return $template;
	}

	function modifyBodyClass( $body_class ) {
		$body_class[] = 'layouts-active';

		return $body_class;
	}

	/**
	 * @return string Absolute path (without the final slash) to the directory where custom page template files are located.
	 */
	protected function get_template_path() {
		return dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'view';
	}
}