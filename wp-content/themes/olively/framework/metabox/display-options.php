<?php
/**
 * Adds a meta box to the post editing screen
 */
function olively_custom_meta() {
    add_meta_box( 'olively_meta', esc_html__( 'Display Options', 'olively' ), 'olively_meta_callback', 'page','side','high' );
}
add_action( 'add_meta_boxes', 'olively_custom_meta' );

/**
 * Outputs the content of the meta box
 */

function olively_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'olively_nonce' );

    $defaults = array(
        'enable-sidebar'  =>  ['yes'],
        'align-sidebar' =>  ['right'],
        'page-head'     =>  ['default'],
    );
	
    $olively_stored_meta = wp_parse_args( get_post_meta( $post->ID ), $defaults );
    ?>

    <p>
	    <div class="olively-row-content">

		    <label>
                <strong><?php _e( 'Enable the Sidebar', 'olively' ) ?></strong>
	            <input type="checkbox" name="enable-sidebar" id="enable-sidebar" value="yes" <?php if ( isset( $olively_stored_meta['enable-sidebar'] ) ) checked( $olively_stored_meta['enable-sidebar'][0], 'yes' ); ?> />
	        </label>
	        <br />
	        
            <div class="page-sidebar-align">
	            <h4> <?php _e('Sidebar Alignment', 'olively'); ?></h4>
	            <label class="align-sidebar-label">
					<input type="radio" name="align-sidebar" value="left" <?php if ( isset( $olively_stored_meta['align-sidebar'] ) ) checked( $olively_stored_meta['align-sidebar'][0], 'left' ); ?>>
					<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/left-sidebar.png'); ?>" title="<?php _e('Left Sidebar', 'olively'); ?>">
				</label>
				<label class="align-sidebar-label">
					<input type="radio" name="align-sidebar" value="right" <?php if ( isset( $olively_stored_meta['align-sidebar'] ) ) checked( $olively_stored_meta['align-sidebar'][0], 'right' ); ?>>
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/right-sidebar.png'); ?>" title="<?php _e('Right Sidebar', 'olively'); ?>">
				</label>
			</div>
	    </div>
	</p>

	<script>
		jQuery(document).ready(function() {
			var toggler	=	jQuery('#olively_meta').find('input#enable-sidebar'),
				toggled	=	jQuery('#olively_meta').find('.page-sidebar-align');
				
				function checked( a, b ) {
					if ( jQuery(a).is(':checked') ) {
						b.slideDown(100);
					} else {
						b.slideUp(100);
					}
				}
				
			checked(toggler, toggled);
			
			toggler.on('change', function() {
				checked(toggler, toggled);
			});
		});
	</script>
    <?php
}


/**
 * Saves the custom meta input
 */
function olively_meta_save( $post_id ) {

    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'olively_nonce' ] ) && wp_verify_nonce( $_POST[ 'olively_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    // Checks for input and saves
	if ( array_key_exists('enable-sidebar', $_POST) ) {
	    update_post_meta( $post_id, 'enable-sidebar', 'yes' );
	}
    else {
	    update_post_meta( $post_id, 'enable-sidebar', '' );
	}

	// Checks for input and saves
	if ( array_key_exists('align-sidebar', $_POST) ) {
	    update_post_meta( $post_id, 'align-sidebar', sanitize_text_field( $_POST['align-sidebar'] ) );
	}
    else {
	    update_post_meta( $post_id, 'align-sidebar', 'right' );
	}

    // Checks for input and saves
/*
	if ( array_key_exists('page-head', $_POST) ) {
		update_post_meta( $post_id, 'page-head', esc_attr( $_POST['page-head'] ) );
	}
    else {
		update_post_meta( $post_id, 'page-head', 'default' );
	}
*/
}
add_action( 'save_post', 'olively_meta_save', 10, 2 );