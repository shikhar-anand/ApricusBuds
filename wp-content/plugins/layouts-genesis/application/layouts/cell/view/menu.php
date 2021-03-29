<?php

if( $this->get_content_field_value( 'menu_select' ) ) {
	switch( $this->get_content_field_value( 'menu_select' ) ) {
		case 'primary':
			genesis_do_nav();
			break;
		case 'secondary':
			genesis_do_subnav();
			break;
	}
}