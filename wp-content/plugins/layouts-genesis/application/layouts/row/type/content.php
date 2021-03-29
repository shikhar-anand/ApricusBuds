<?php

class Layouts_Integration_Layouts_Row_Type_Content
	extends WPDDL_Row_Type_Preset_Normal {

	public function setup() {

		$this->id   = 'genesis_content';
		$this->name = __('Genesis Content', 'ddl-layouts');
		$this->desc = sprintf(__('%sGenesis%s content row', 'ddl-layouts'), '<b>', '</b>' );

		$this->addCssClass( 'content' );

		parent::setup();
	}
}