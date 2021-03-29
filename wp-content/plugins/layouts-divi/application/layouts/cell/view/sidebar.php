<?php
if( $this->get_content_field_value( 'sidebar' ) ) {
	dynamic_sidebar($this->get_content_field_value( 'sidebar' ));
}
