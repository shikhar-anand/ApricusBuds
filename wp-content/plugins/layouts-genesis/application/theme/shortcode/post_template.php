<?php


class Layouts_Integration_Theme_Shortcode_Post_Template
	extends Layouts_Integration_Shortcode_Abstract {

	public function setup() {
		$this->setId( 'genesis-post-template' );
		$this->setTemplate( dirname( __FILE__ ) . '/view/post_template.php' );

		$this->setMediaButton( 'Post Template' );

		$option = new Layouts_Integration_Shortcode_Option_Default();
		$option->setLabel( 'Post Template' );
		$option->setName( 'Post Template' );

		$attribute = new Layouts_Integration_Shortcode_Option_Attribute_Default();
		$attribute->setId( 'display-options' );
		$attribute->setLabel( 'Display Options' );
		$attribute->setHeader( 'Display Options' );

		$field = new Layouts_Integration_Shortcode_Option_Attribute_Field_Default();
		$field->setId( 'output' );
		$field->setLabel( 'How to implement the template?' );
		$field->setDescription( '' );
		$field->setType( 'radio' );
		$field->addOption( new Layouts_Integration_Shortcode_Option_Attribute_Field_Option_Default(
			$this->getId(),
			$field->getId(),
			'default',
			'Genesis Output with all Hooks',
			true
		) );


		$field->addOption( new Layouts_Integration_Shortcode_Option_Attribute_Field_Option_Default(
			$this->getId(),
			$field->getId(),
			'editable',
			'Genesis Output - editable in Editor',
			false,
			dirname( __FILE__ ) . '/view/post_template_editable.php'
		) );

		$attribute->addField( $field );
		$option->addAttribute( $attribute );

		$this->setOption( $option );

		add_filter( 'ddl-do-not-apply-overlay-for-post-editor', array( &$this, 'disable_overlay_on_content_editor' ) );

		parent::setup();
	}

	function disable_overlay_on_content_editor( $codes ){
		$codes[] = $this->getId();
		return $codes;
	}
}