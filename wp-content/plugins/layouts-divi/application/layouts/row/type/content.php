<?php

class WPDDL_Integration_Layouts_Row_Type_Content
	extends WPDDL_Integration_Row_Type_Preset_Fullwidth_Background {

	public function setup() {

		$this->id   = 'divi_content';
		$this->name = 'Content';
		$this->desc = '<b>Divi</b> content row';

		$this->setCssId( 'et-main-area' );
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

			$el_container_class = empty($args['container_class']) ? '' : $args['container_class'];

			ob_start();
			echo '<' . $args['tag'] . ' id="et-main-area" class="' . $el_css . '" '.$this->renderDataAttributes($row, $renderer).'>';
			echo '<div id="main-content" class="' . $el_container_class . '">';
			echo '<div '. $el_id . 'class="' . $args['row_class'] . $args['type'] . '">';

			$markup = ob_get_clean();
		}

		return $markup;
	}

	public function htmlClose( $output, $mode, $tag ) {

		if( $mode === $this->id ) {
			$output = '</div></div></' . $tag . '>';
		}

		return $output;
	}
}