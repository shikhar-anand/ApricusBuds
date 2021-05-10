<?php

/**
 * Class responsible of types/generic video field creation on frontend
 */
class WPToolset_Field_Credvideo extends CRED_Abstract_WPToolset_Field_Credfile {

	protected $_settings = array( 'min_wp_version' => '3.6' );

	/**
	 * Specification of metaform that contains description array of field structure
	 *
	 * @return array|void
	 */
	public function metaform() {
		$validation = $this->getValidationData();
		$this->set_allowed_extensions_validation_by_field_upload_type( $validation, 'video' );
		$this->setValidationData( $validation );

		return parent::metaform();
	}

	/**
	 * Error to be shown when trying to upload a file of an unsupported format.
	 *
	 * @return string
	 * @since 2.4
	 */
	protected function get_extension_error() {
		$media_model = $this->get_media_model();
		return $media_model->get_upload_validation_error_message( 'video' );
	}

	/**
	 * Get the default label for the Media Manager button when selecting a value.
	 *
	 * @return string
	 * @since 2.4
	 */
	protected function get_select_label() {
		$attributes = $this->getAttr();
		$select_label = toolset_getarr( $attributes, 'select_label' );
		if ( empty( $select_label ) ) {
			/* translators: Default label for a button to select a video file field value */
			$select_label = __( 'Upload or select video', 'wp-cred' );
		} else {
			// Translate the label
		}
		return $select_label;
	}

	/**
	 * Get the default label for the Media Manager button when editing a value.
	 *
	 * @return string
	 * @since 2.4
	 */
	protected function get_edit_label() {
		$attributes = $this->getAttr();
		$edit_label = toolset_getarr( $attributes, 'edit_label' );
		if ( empty( $edit_label ) ) {
			/* translators: Default label for a button to edit or modify a video file field value */
			$edit_label = __( 'Replace video', 'wp-cred' );
		} else {
			// Translate the label
		}
		return $edit_label;
	}

	/**
	 * Get the preview default format.
	 *
	 * @return string
	 * @since 2.4
	 */
	protected function get_preview_format() {
		$attributes = $this->getAttr();
		$preview = toolset_getarr( $attributes, 'preview', 'filename', array( 'url', 'filename' ) );
		return $preview;
	}
}
