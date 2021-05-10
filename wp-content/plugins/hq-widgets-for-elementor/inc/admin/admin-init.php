<?php

namespace HQWidgetsForElementor\Admin;

defined('ABSPATH') || exit;

use const HQWidgetsForElementor\PLUGIN_SLUG;
use const HQWidgetsForElementor\PLUGIN_URL;
use const HQWidgetsForElementor\VERSION;

class Admin_Init {

    /**
     * Plugin Instance
     * @var Admin_Init 
     */
    private static $_instance = null;

    /**
     * Get class instance
     *
     * @since 1.0.0
     *
     * @return Admin_Init
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct() {
        add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);
        add_action('admin_init', [$this, 'redirect_after_activation']);
        add_action('elementor/editor/before_enqueue_scripts', [$this, 'editor_enqueue_scripts']);
    }

    public function admin_enqueue_scripts() {
        if (isset($_GET['page']) && ($_GET['page'] == Admin_Settings::PAGE_ID)) {
            wp_enqueue_style('hq-widgets-icons', PLUGIN_URL . 'assets/css/hq-icons.css', '', VERSION);
            wp_enqueue_style('hq-elementor-widgets-admin', PLUGIN_URL . 'assets/css/admin.css', '', VERSION);
            wp_enqueue_script('hq-elementor-widgets-admin', PLUGIN_URL . 'assets/js/admin.js', ['jquery'], VERSION, true);
        }
    }

    public function editor_enqueue_scripts() {
        wp_enqueue_script('hq-elementor-editor', PLUGIN_URL . 'assets/js/editor.js', [], VERSION, true);
    }

    /**
     * @since 1.0.0
     * @access public
     */
    public function redirect_after_activation() {
        if (!get_transient(PLUGIN_SLUG . '_activation_redirect')) {
            return;
        }

        if (wp_doing_ajax()) {
            return;
        }

        delete_transient(PLUGIN_SLUG . '_activation_redirect');

        if (is_network_admin() || isset($_GET['activate-multi'])) {
            return;
        }

        wp_safe_redirect(admin_url('admin.php?page=hq-elementor-widgets'));

        exit;
    }

}
