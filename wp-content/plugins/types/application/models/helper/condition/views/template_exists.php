<?php

use OTGS\Toolset\Views\Services\ContentTemplateService;

/**
 * Types_Helper_Condition_Views_Template_Exists
 *
 * @since 2.0
 */
class Types_Helper_Condition_Views_Template_Exists extends Types_Helper_Condition_Views_Views_Exist {

	private static $template_id = array();
	private static $template_name = array();

	public function valid() {
		// if views not active
		if( ! defined( 'WPV_VERSION' ) )
			return false;

		$type = self::get_type_name();

		if( isset( self::$template_id[$type] )
		    && self::$template_id[$type] !== null
		    && self::$template_id[$type] !== false )
			return true;

		$wpv_options = get_option( 'wpv_options', array() );

		if( empty( $wpv_options )
		    || ! isset( $wpv_options['views_template_for_'.$type] )
		    || ! get_post_type( $wpv_options['views_template_for_'.$type] )
		) {
			self::$template_id[$type] = false;
			self::$template_name[$type] = false;
			return false;
		}

		$title = get_the_title( $wpv_options['views_template_for_'.$type] );
		self::$template_id[$type] = $wpv_options['views_template_for_'.$type];
		self::$template_name[$type] = $title;

		return true;
	}

	/**
	 * Renders the conditional toolset links if present.
	 * @return string
	 */
	public static function get_conditional_templates_list() {
		$views_assignments = apply_filters( 'wpv_get_archives_and_templates_assignments', [] );
		$conditional_templates = [];

		$post_type = self::get_post_type();

		foreach ( $views_assignments as $views_assignment ) {
			if (
				! isset( $views_assignment['loop_type'] ) ||
				! isset( $views_assignment['post_type_name'] ) ||
				$views_assignment['post_type_name'] !== $post_type->name ||
				! isset( $views_assignment['single_ct_conditions'] ) ||
				empty( $views_assignment['single_ct_conditions'] )
			) {
				continue;
			}
			/** @var \OTGS\Toolset\Views\Models\ContentTemplate\UsagePostType $usage_post_type */
			$usage_post_type = $views_assignment['single_ct_conditions'];
			$settings = $usage_post_type->getSettings();
			foreach ( $settings as $setting ) {
				$conditional_templates[] = array(
					'title' => get_the_title( $setting->getContentTemplateId() ),
					'link' => sprintf( '%s%s%s', admin_url(), 'admin.php?page=ct-editor&ct_id=', $setting->getContentTemplateId() ),
				);
			}
		}

		return self::get_twig()->render(  '/page/dashboard/table/cell/template-conditions-cell.twig', [ 'templates' => $conditional_templates ] );
	}

	public static function get_template_id() {
		$type = self::get_type_name();

		if( isset( self::$template_id[$type] ) )
			return self::$template_id[$type];

		// not set yet
		$self = new Types_Helper_Condition_Views_Template_Exists();

		if( $self->valid() )
			return self::get_template_id();
	}

	public static function get_template_name() {
		$type = self::get_type_name();

		if( ! isset( self::$template_name[$type] ) )
			self::$template_name[$type] = get_the_title( self::get_template_id() );

		return self::$template_name[$type];
	}

}
