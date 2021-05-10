<?php

/**
 * Plugin Name:       HQ Widgets for Elementor
 * Plugin URI:        https://marmot.hqwebs.net/hq-widgets-for-elementor/?utm_source=wp-admin&utm_medium=link&utm_campaign=default&utm_term=hq-widgets-for-elementor&utm_content=plugin-uri
 * Description:       The HQ Widgets for Elementor is an elementor addons package for Elementor page builder plugin for WordPress. Works Best with Marmot theme
 * Version:           1.0.13
 * Requires at least: 5.3
 * Requires PHP:      7.2
 * Author:            HQWebS
 * Author URI:        https://marmot.hqwebs.net/?utm_source=wp-admin&utm_medium=link&utm_campaign=default&utm_term=hq-widgets-for-elementor&utm_content=plugin-author
 * License:           GPL v3 or later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       hq-widgets-for-elementor
 */

namespace HQWidgetsForElementor;

defined('ABSPATH') || exit;

use Elementor\Plugin;
use HQWidgetsForElementor\Control\Group_Control_Posts;
use Elementor\Core\Responsive\Files\Frontend;

/**
 * Plugin URL
 *
 * @since 1.0.0
 * @var string
 */
define(__NAMESPACE__ . '\PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Plugin Directory Path
 *
 * @since 1.0.0
 * @var string
 */
define(__NAMESPACE__ . '\PLUGIN_PATH', plugin_dir_path(__FILE__));

/**
 * Plugin Unique slug
 *
 * @since 1.0.0
 * @var string
 */
const PLUGIN_SLUG = 'hq-widgets-for-elementor';

/**
 * Plugin Unique Name
 *
 * @since 1.0.0
 * @var string
 */
const PLUGIN_NAME = 'HQ Widgets for Elementor';

/**
 * Plugin Version
 *
 * @since 1.0.0
 * @var string
 */
const VERSION = '1.0.13';

// Load Autoloader
require_once PLUGIN_PATH . '/inc/autoloader.php';
Autoloader::run();

/**
 * Main HQ Widgets for Elementor Class
 *
 * Run plugin
 *
 * @since 1.0.0
 */
class HQ_Widgets_For_Elementor {

    /**
     * Cache some data
     * 
     * @since 1.0.0
     * 
     * @var array
     */
    public static $data = [];

    /**
     * Instance
     * 
     * @since 1.0.0
     * 
     * @var HQ_Widgets_For_Elementor 
     */
    private static $_instance = null;

    /**
     * Get class instance
     *
     * @since 1.0.0
     *
     * @return HQ_Widgets_For_Elementor
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
        /**
         * Plugin activation
         * Generate css
         */
        register_activation_hook(__FILE__, [$this, 'after_plugin_activation']);

        add_action('plugins_loaded', [$this, 'run']);
    }

    public function run() {
        // Check dependencies
        $dependencies = new Dependencies(PLUGIN_NAME);
        if (!$dependencies->is_dependencies_met()) {
            return;
        }

        // I18n
        add_action('init', 'load_plugin_textdomain');

        define(__NAMESPACE__ . '\ELEMENTOR_BASE_UPLOADS', Frontend::get_base_uploads_url());

        if (is_admin()) {
            Admin\Admin_Init::instance();
            Admin\Admin_Settings::instance();
        }

        // On clear cache generate templates
        add_action('elementor/core/files/clear_cache', ['HQWidgetsForElementor\Responsive', 'compile_stylesheet_templates']);
        add_action('elementor/init', [$this, 'elementor_init']);
        add_action('elementor/widgets/widgets_registered', [$this, 'includes_widgets']);
        add_action('elementor/editor/after_enqueue_styles', [$this, 'editor_styles']);
        add_action('elementor/frontend/after_register_styles', [$this, 'register_frontend_styles'], 10);
        add_action('elementor/frontend/after_register_scripts', [$this, 'register_fronted_scripts'], 10);
        add_action('elementor/controls/controls_registered', [$this, 'register_controls']);

        add_filter('elementor/editor/localize_settings', [Widget\Widgets_Control::instance(), 'promote_pro_elements']);
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), [$this, 'plugin_action_links']);
        add_filter('hqt/widgets_control/get_all', [Widget\Widgets_Control::instance(), 'hqt_widgets_control_get_all']);
        add_filter('pre_handle_404', [$this, 'allow_posts_widget_pagination'], 10, 2);
    }

    /**
     * Elementor category
     * 
     * @since 1.0.0
     */
    function elementor_init() {
        \Elementor\Plugin::instance()->elements_manager->add_category(
                PLUGIN_SLUG, [
            'title' => 'HQ Widgets',
            'icon' => 'font'
                ]
        );
        \Elementor\Plugin::instance()->elements_manager->add_category(
                PLUGIN_SLUG . '-woo', [
            'title' => 'HQ WooCommerce Widgets',
            'icon' => 'font'
                ]
        );

        Responsive::instance();
        if (defined('MARMOT_DEBUG') && MARMOT_DEBUG) {
            Responsive::compile_stylesheet_templates();
        }
    }

    /**
     * Hooked after plugin activation
     * 
     * @since 1.0.0
     */
    function after_plugin_activation($network_wide) {
        // Generate CSS
        if (did_action('elementor/loaded')) {
            Responsive::compile_stylesheet_templates();
        }

        if (is_multisite() && $network_wide) {
            return;
        }

        // Redirect to dashboard after plugin activation
        if (
                defined('\HQExtra\VERSION') &&
                defined('\ELEMENTOR_VERSION') &&
                !Dependencies::is_theme_active()
        ) {
            set_transient(PLUGIN_SLUG . '_activation_redirect', true, MINUTE_IN_SECONDS);
        }
    }

    /**
     * I18n
     * 
     * @since 1.0.0
     */
    public function load_plugin_textdomain() {
        load_plugin_textdomain('hq-widgets-for-elementor');
    }

    /**
     * Register Widgets
     * 
     * @since 1.0.0
     */
    public function includes_widgets() {
        Widget\Widgets_Control::instance()->load_active_widgets();
    }

    /**
     * Adds elementor editor some css
     * 
     * @since 1.0.0
     */
    public function editor_styles() {
        wp_enqueue_style(PLUGIN_SLUG . '-elementor-editor', PLUGIN_URL . 'assets/css/elementor-editor.css', '', VERSION);
        wp_enqueue_style(PLUGIN_SLUG . '-hq-icons', PLUGIN_URL . 'assets/css/hq-icons.css', '', VERSION);
    }

    /**
     * Register frontend styles
     * 
     * @since 1.0.0
     */
    public function register_frontend_styles() {
        wp_register_style('jquery-swiper', PLUGIN_URL . 'assets/css/jquery.swiper.min.css', [], '6.3.5');

        wp_register_style('hqt-widgets', ELEMENTOR_BASE_UPLOADS . 'css/hqt-widgets.css', [], VERSION);
    }

    /**
     * Register frontend scripts
     * 
     * @since 1.0.0
     */
    public function register_fronted_scripts() {

        wp_register_script('mobile-detect', PLUGIN_URL . 'assets/js/mobile-detect.min.js', [], VERSION, true);

        wp_register_script('isotope', PLUGIN_URL . 'assets/js/isotope.pkgd.min.js', ['jquery'], '3.0.6', true);

        wp_register_script('jquery.infinitescroll', PLUGIN_URL . 'assets/js/jquery.infinitescroll.js', ['jquery'], '2.0b2.120519', true);

        wp_register_script('jquery-swiper', PLUGIN_URL . 'assets/js/jquery.swiper.min.js', ['jquery'], '6.3.5', true);

        wp_register_script('hqt-widgets', PLUGIN_URL . 'assets/js/widgets.js', ['jquery'], VERSION, true);
    }

    /**
     * Register custom controls
     * 
     * @since 1.0.0
     */
    public function register_controls() {
        $controls_manager = Plugin::instance()->controls_manager;
        $controls_manager->add_group_control(Group_Control_Posts::get_type(), new Group_Control_Posts());
    }

    /**
     * Add settings links on plugin page
     *
     * @param  string $links Passing through the URL to be used within the HREF.
     * @return string        Returns the Links.
     */
    public function plugin_action_links($links) {
        $dashboard_page_url = admin_url('admin.php?page=' . Admin\Admin_Settings::PAGE_ID);
        $widgets_page_url = admin_url('admin.php?page=' . Admin\Admin_Settings::PAGE_ID . '&tab=' . Admin\Admin_Settings::TAB_CORE_WIDGETS);

        $dashboard_link = '<a href="' . esc_url($dashboard_page_url) . '">' . _x('Dashboard', 'admin dashboard', 'hq-widgets-for-elementor') . '</a>';
        $widgets_link = '<a href="' . esc_url($widgets_page_url) . '">' . _x('Widgets', 'admin dashboard', 'hq-widgets-for-elementor') . '</a>';

        array_unshift($links, $dashboard_link, $widgets_link);

        return $links;
    }

    /**
     * Fix WP 5.5 pagination issue.
     *
     * Return true to mark that it's handled and avoid WP to set it as 404.
     *
     * @see https://github.com/elementor/elementor/issues/12126
     * @see https://core.trac.wordpress.org/ticket/50976
     *
     * Based on the logic at \WP::handle_404.
     *
     * @param $handled - Default false.
     * @param $wp_query
     *
     * @return bool
     */
    public function allow_posts_widget_pagination($handled, $wp_query) {
        // Check it's not already handled and it's a single paged query.
        if ($handled || empty($wp_query->query_vars['page']) || !is_singular() || empty($wp_query->post)) {
            return $handled;
        }

        $document = \Elementor\Plugin::instance()->documents->get($wp_query->post->ID);

        return $this->is_valid_pagination($document->get_elements_data(), $wp_query->query_vars['page']);
    }

    /**
     * Checks a set of elements if there is a posts/archive widget that may be paginated to a specific page number.
     *
     * @param array $elements
     * @param       $current_page
     *
     * @return bool
     */
    public function is_valid_pagination(array $elements, $current_page) {
        $is_valid = false;

        // Get all widgets that may add pagination.
        $widgets = \Elementor\Plugin::instance()->widgets_manager->get_widget_types();
        $posts_widgets = [];
        foreach ($widgets as $widget) {
            if ($widget instanceof Widget\Theme\Posts || $widget instanceof Widget\Woocommerce\Products) {
                $posts_widgets[] = $widget->get_name();
            }
        }
        
        \Elementor\Plugin::instance()->db->iterate_data($elements, function( $element ) use ( &$is_valid, $posts_widgets, $current_page ) {
            if (isset($element['widgetType']) && in_array($element['widgetType'], $posts_widgets, true)) {
                // Has pagination.
                if (!empty($element['settings']['pagination_type'])) {
                    // No max pages limits.
                    if (empty($element['settings']['pagination_page_limit'])) {
                        $is_valid = true;
                    } elseif ((int) $current_page <= (int) $element['settings']['pagination_page_limit']) {
                        // Has page limit but current page is less than or equal to max page limit.
                        $is_valid = true;
                    }
                }
            }
        });
        
        return $is_valid;
    }

}

/**
 * Elementor Saved Template 
 * 
 * @since 1.0.0
 * 
 * @return array
 */
function get_saved_elementor_templates() {
    $cache_key = PLUGIN_SLUG . '_elementor_saved_templates';

    if (isset(HQ_Widgets_For_Elementor::$data[$cache_key])) {
        return HQ_Widgets_For_Elementor::$data[$cache_key];
    }

    $templates = \Elementor\Plugin::instance()->templates_manager->get_source('local')->get_items();

    if (empty($templates)) {
        $template_options = ['0' => __('You Haven’t Saved Templates Yet.', 'hq-widgets-for-elementor')];
    } else {
        $template_options = ['0' => __('Select Template', 'hq-widgets-for-elementor')];
        foreach ($templates as $template) {
            $template_options[$template['template_id']] = $template['title'] . ' (' . $template['type'] . ')';
        }
    }

    HQ_Widgets_For_Elementor::$data[$cache_key] = $template_options;

    return $template_options;
}

/**
 * Checks if plugin is installed
 *
 * @since 1.0.0
 *
 * @param string $plugin Plugin activation string
 * @return bool
 */
function is_plugin_installed($plugin) {
    require_once ABSPATH . 'wp-includes/pluggable.php';
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
    $plugins = \get_plugins();
    return isset($plugins[$plugin]);
}

// Run Plugin
HQ_Widgets_For_Elementor::instance();
