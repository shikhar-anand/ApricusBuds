<?php

namespace OTGS\Toolset\Types\Wordpress;

/**
 * Gateway to WordPress post/user/term/comment meta functions.
 *
 * Extend at will, but keep it extremely simple.
 *
 * @since 3.4.2
 * @codeCoverageIgnore
 */
class Meta {

	/**
	 * @see \get_post_meta()
	 *
	 * @param $post_id
	 * @param string $key
	 * @param false $single
	 *
	 * @return mixed
	 */
	public function get_post_meta( $post_id, $key = '', $single = false ) {
		return get_post_meta( $post_id, $key, $single );
	}


	/**
	 * @see \update_post_meta()
	 *
	 * @param $post_id
	 * @param $meta_key
	 * @param $meta_value
	 * @param string $prev_value
	 *
	 * @return bool|int
	 */
	public function update_post_meta( $post_id, $meta_key, $meta_value, $prev_value = '' ) {
		return update_post_meta( $post_id, $meta_key, $meta_value, $prev_value );
	}
}
