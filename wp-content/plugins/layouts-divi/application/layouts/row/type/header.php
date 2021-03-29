<?php

class WPDDL_Integration_Layouts_Row_Type_Header
	extends WPDDL_Integration_Row_Type_Preset_Fullwidth_Background {

	public function setup() {

		$this->id   = 'divi_header';
		$this->name = 'Header';
		$this->desc = '<b>Divi</b> header row';

		$this->setCssId( 'main-header' );
		$this->enableSameHeightColumns();

		parent::setup();
	}

	public function htmlOpen( $markup, $args, $row = null, $renderer = null ) {

		if( $args['mode'] === $this->id ) {

			$el_css = 'full-bg';

			$css_classes = $this->getCssClasses();

			$el_css .= ! empty( $css_classes )
					? ' ' . implode( $css_classes, ' ' )
					: '';

			$el_css .= isset( $args['additionalCssClasses'] )
					? ' '.$args['additionalCssClasses']
					: '';

			$el_id = isset( $args['cssId'] ) && ! empty( $args['cssId'] )
					? ' id="' . $args['cssId'] . '"'
					: '';

			$el_container_class = empty($args['container_class']) ? 'container' : $args['container_class'];

			ob_start();
			echo '<header id="main-header" class="' . $el_css . '" '.$this->renderDataAttributes($row, $renderer).'>';
			echo '<div class="' . $el_container_class . ' clearfix et_menu_container">';
			echo '<div '. $el_id . 'class="' . $args['row_class'] . $args['type'] . '">';

			$markup = ob_get_clean();
		}

		return $markup;
	}

	public function htmlClose( $output, $mode, $tag ) {

		if( $mode === $this->id ) {
			$output = '</div></div></header>';
		}

		return $output;
	}
}