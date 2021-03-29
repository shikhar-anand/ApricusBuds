<?php

do_action( 'genesis_before_entry' );

printf( '<article %s>', genesis_attr( 'entry' ) );

do_action( 'genesis_entry_header' );

do_action( 'genesis_before_entry_content' );

genesis_do_post_image();
printf( '<div %s>', genesis_attr( 'entry-content' ) );


/** CONTENT OUTPUT */
if ( is_singular() ) {
	global $post;

	echo apply_filters( 'the_content', wpautop( $post->post_content ) );

	if ( is_single() && 'open' === get_option( 'default_ping_status' ) && post_type_supports( get_post_type(), 'trackbacks' ) ) {
		echo '<!--';
		trackback_rdf();
		echo '-->' . "\n";
	}

	if ( is_page() && apply_filters( 'genesis_edit_post_link', true ) )
		edit_post_link( __( '(Edit)', 'genesis' ), '', '' );
}
elseif ( 'excerpts' === genesis_get_option( 'content_archive' ) ) {
	global $post;
	echo $post->post_excerpt;
}
else {
	the_post();

	if ( genesis_get_option( 'content_archive_limit' ) )
		the_content_limit( (int) genesis_get_option( 'content_archive_limit' ), genesis_a11y_more_link( __( '[Read more...]', 'genesis' ) ) );
	else
		the_content( genesis_a11y_more_link( __( '[Read more...]', 'genesis' ) ) );
}
/** /CONTENT OUTPUT */
echo '</div>';

do_action( 'genesis_after_entry_content' );

do_action( 'genesis_entry_footer' );

echo '</article>';

do_action( 'genesis_after_entry' );