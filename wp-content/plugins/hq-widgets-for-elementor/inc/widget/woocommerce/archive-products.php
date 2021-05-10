<?php

namespace HQWidgetsForElementor\Widget\Woocommerce;

defined('ABSPATH') || exit;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use HQWidgetsForElementor\Widget\Products_Base;
use const HQWidgetsForElementor\PLUGIN_SLUG;

class Archive_Products extends Products_Base {

    public function get_name() {
        return 'hq-woocommerce-archive-products';
    }

    public function get_title() {
        return __('Woo Archive Products', 'hq-widgets-for-elementor');
    }

    public function get_categories() {
        return [PLUGIN_SLUG . '-woo'];
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-products-layout';
    }

    public function get_script_depends() {
        return $this->get_script_depends_grid();
    }

    public function get_style_depends() {
        return ['hqt-widgets'];
    }

    protected function _register_controls() {
        if (!defined('WC_VERSION')) {
            $this->start_controls_section('section_plugin_missing', [
                'label' => __('Woocommerce', 'hq-widgets-for-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]);

            $this->add_control('plugin_alert', [
                'raw' => '<p>' . __('WooCommerce plugin is not installed.', 'hq-widgets-for-elementor') . '</p>' . sprintf('<a href="%s" target="_blank">%s</a>', esc_url(admin_url('plugin-install.php?s=woocommerce&tab=search&type=term')), __('Install WooCommerce.', 'hq-widgets-for-elementor')),
                'type' => Controls_Manager::RAW_HTML,
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
            ]);

            $this->end_controls_section();

            return;
        }

        // Product layout
        $this->register_product_layout_section_controls();

        // Grid Controls
        $this->register_grid_controls();

        // Pagination
        $this->register_pagination_section_controls();

        // Nothing Found
        $this->register_nothing_found_section_controls();
    }

    public function query_posts($settings) {
        if ($this->query) {
            return $this->query;
        }

        global $wp_query;

        if (Plugin::instance()->editor->is_edit_mode()) {
            $args = [
                'post_status' => 'publish',
                'post_type' => 'product',
                'posts_per_page' => get_option('posts_per_page'),
            ];

            return new \WP_Query($args);
        }

        $query_vars = $wp_query->query_vars;

        $query_vars = apply_filters('hqt/widget/products_archive/query_posts/query_vars', $query_vars);

        if ($query_vars !== $wp_query->query_vars) {
            $this->query = new \WP_Query($query_vars);
        } else {
            $this->query = $wp_query;
        }
        return $this->query;
    }

    public function render_no_results() {
        echo '<div class="elementor-nothing-found elementor-products-nothing-found">' . esc_html($this->get_settings('nothing_found_message')) . '</div>';
    }

    public function render() {
        if (!defined('WC_VERSION')) {
            \HQLib\Utils::editor_alert_box('WooCommerce plugin is missing.');
            return;
        }

        parent::render_grid();
    }

}
