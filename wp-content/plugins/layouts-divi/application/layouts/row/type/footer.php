<?php

class WPDDL_Integration_Layouts_Row_Type_Footer
	extends WPDDL_Integration_Row_Type_Preset_Fullwidth_Background {

	public function setup() {

		$this->id   = 'divi_footer';
		$this->name = 'Footer';
		$this->desc = '<b>Divi</b> footer row';

		$this->setCssId( 'main-footer' );
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
					?  $args['cssId']
					: '';

			$el_container_class = empty($args['container_class']) ? 'container' : $args['container_class'];

			ob_start();
			echo '<footer id="main-footer" class="' . $el_css . '" '.$this->renderDataAttributes($row, $renderer).'>';
			echo '<div class="' . $el_container_class . ' clearfix">';
			echo '<div '. $el_id . 'class="' . $args['row_class'] . $args['type'] . '">';

			$markup = ob_get_clean();
		}

		return $markup;
	}

	public function htmlClose( $output, $mode, $tag ) {

		if( $mode === $this->id ) {
			$output = '</div></div></footer>';
		}

		return $output;
	}
}