<?php

namespace HQWidgetsForElementor;

defined('ABSPATH') || exit;

use Elementor\Core\Responsive\Files\Frontend;
use Elementor\Core\Responsive\Responsive as Elementor_Resposive;

/**
 * Available placeholders
  ELEMENTOR_SCREEN_SM_MAX
  ELEMENTOR_SCREEN_MD_MIN
  ELEMENTOR_SCREEN_MD_MAX
  ELEMENTOR_SCREEN_LG_MIN
 * 
 * @since 1.0.0
 */
class Responsive {

    /**
     * Instance
     * 
     * @since 1.0.0
     * 
     * @var Responsive 
     */
    private static $_instance = null;

    /**
     * Get class instance
     *
     * @since 1.0.0
     *
     * @return Responsive
     */
    public static function instance() {

        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Class constructor
     *
     * @since 1.0.0
     */
    private function __construct() {
        // On change resolutions
        foreach (Elementor_Resposive::get_editable_breakpoints() as $breakpoint_key => $breakpoint) {
            foreach (['add', 'update'] as $action) {
                add_action("{$action}_option_elementor_viewport_{$breakpoint_key}", ['HQWidgetsForElementor\Responsive', 'compile_stylesheet_templates']);
            }
        }
    }

    /**
     * Compile all on resolution change
     * 
     * @since 1.0.0
     */
    public static function compile_stylesheet_templates() {
        // Prevent loop
        remove_action('elementor/core/files/clear_cache', ['HQWidgetsForElementor\Responsive', 'compile_stylesheet_templates']);

        foreach (self::get_stylesheet_templates() as $file_name => $template_path) {
            self::compile_stylesheet_template($file_name, $template_path);
        }
    }

    /**
     * Compile Single Template
     * 
     * @since 1.0.0
     * 
     * @param string $file_name
     * @param string $template_path
     */
    public static function compile_stylesheet_template($file_name, $template_path) {
        $file = new Frontend($file_name, $template_path);
        $file->update();
    }

    /**
     * Get main templates
     * 
     * @since 1.0.0
     * 
     * @return array
     */
    private static function get_stylesheet_templates() {
        return apply_filters('hqt/responsive/get_stylesheet_templates', self::get_widgets_stylesheet_templates());
    }

    public static function get_widgets_stylesheet_templates() {
        return [
            'hq-theme-contact-form-7.css' => PLUGIN_PATH . 'assets/widgets/theme/contact-form-7/style.tpl.css',
            'hq-theme-nav-menu.css' => PLUGIN_PATH . 'assets/widgets/theme/nav-menu/style.tpl.css',
            'hq-theme-polylang-switcher.css' => PLUGIN_PATH . 'assets/widgets/theme/polylang-switcher/style.tpl.css',
            'hq-theme-post-comments.css' => PLUGIN_PATH . 'assets/widgets/theme/post-comments/style.tpl.css',
            'hq-theme-author-box.css' => PLUGIN_PATH . 'assets/widgets/theme/author-box/style.tpl.css',
            'hq-theme-post-navigation.css' => PLUGIN_PATH . 'assets/widgets/theme/post-navigation/style.tpl.css',
            'hq-woocommerce-product-data-tabs.css' => PLUGIN_PATH . 'assets/widgets/woocommerce/product-data-tabs/style.tpl.css',
            'hq-woocommerce-product-reviews.css' => PLUGIN_PATH . 'assets/widgets/woocommerce/product-reviews/style.tpl.css',
            'hqt-widgets.css' => PLUGIN_PATH . 'assets/css/templates/widgets.tpl.css',
        ];
    }

}
