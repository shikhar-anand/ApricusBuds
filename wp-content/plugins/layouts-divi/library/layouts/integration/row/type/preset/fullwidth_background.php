<?php


abstract class WPDDL_Integration_Row_Type_Preset_Fullwidth_Background
	extends WPDDL_Row_Type_Preset_Fullwidth_Background {

	protected function setup() {
		$this->image = WPDDL_GUI_RELPATH . 'dialogs/img/tn-full-fixed.png';

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

			// html id set by constructor
			$el_id = ! empty( $this->html_id )
				? array( $this->html_id )
				: array();

			// html id set by user
			$el_id = isset( $args['cssId'] ) && ! empty( $args['cssId'] )
				? array_merge( $el_id, explode( ' ', $args['cssId'] ) )
				: $el_id;

			// any html id set
			$el_id = ! empty( $el_id )
				? ' id="' . implode( " ", $el_id ) . '"'
				: '';

			// option to have all columns on same height
			$same_height_colums = ( $this->same_height_columns )
				?  '<div class="ddl-same-height-columns">'
				: '';

			ob_start();
			echo '<' . $args['tag'] . $el_id . ' class="' . $el_css . '">';
			echo '<div class="' . $args['container_class'] . '">';
			echo '<div class="' . $args['row_class'] . $args['type'] . '">';
			echo $same_height_colums;

			$markup = ob_get_clean();
		}

		return $markup;
	}

	public function htmlClose( $output, $mode, $tag ) {

		if( $mode === $this->id ) {

			// option to have all columns on same height
			$same_height_colums = ( $this->same_height_columns )
				?  '</div>'
				: '';

			$output = '</div></div></' . $tag . '>'.$same_height_colums;
		}

		return $output;
	}
}