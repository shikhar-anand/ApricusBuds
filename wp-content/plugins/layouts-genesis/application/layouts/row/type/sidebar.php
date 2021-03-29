<?php

class Layouts_Integration_Layouts_Row_Type_Sidebar
	extends WPDDL_Row_Type_Preset_Fullwidth_Background {

	public function setup() {

		$this->id   = 'genesis_sidebar';
		$this->name = __('Genesis Sidebar', 'ddl-layouts');
		$this->desc = sprintf(__('%sGenesis%s sidebar row', 'ddl-layouts'), '<b>', '</b>' );

		$this->addCssClass( 'sidebar' );

		parent::setup();
	}
}