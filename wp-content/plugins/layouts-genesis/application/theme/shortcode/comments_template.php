<?php
class Layouts_Integration_Theme_Shortcode_Comments_Template
	extends Layouts_Integration_Shortcode_Abstract {

	public function setup() {
		$this->setId( 'genesis-comments-template' );
		$this->setTemplate( dirname( __FILE__ ) . '/view/comments_template.php' );
		parent::setup();
	}

	function disable_overlay_on_content_editor( $codes ){
		$codes[] = $this->getId();
		return $codes;
	}
}