<?php

class Layouts_Integration_Layouts_Row_Type_Site_header
	extends WPDDL_Row_Type_Preset_Fullwidth_Background {

	public function setup() {

		$this->id   = 'genesis_header';
		$this->name = __('Genesis Header', 'ddl-layouts');
		$this->desc = sprintf(__('%sGenesis%s site header row', 'ddl-layouts'), '<b>', '</b>' );

		$this->addCssClass( 'site-header' );

		parent::setup();
	}
}