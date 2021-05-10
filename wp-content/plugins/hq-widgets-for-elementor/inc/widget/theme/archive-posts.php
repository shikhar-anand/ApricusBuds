<?php

namespace HQWidgetsForElementor\Widget\Theme;

defined('ABSPATH') || exit;

use Elementor\Plugin;
use const HQWidgetsForElementor\PLUGIN_SLUG;
use HQWidgetsForElementor\Widget\Posts_Base;

class Archive_Posts extends Posts_Base {

    private static $instances = 0;

    public function get_name() {
        return 'hq-theme-archive-posts';
    }

    public function get_title() {
        return __('Archive Posts', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-list';
    }

    public function get_script_depends() {
        return $this->get_script_depends_grid();
    }

    public function get_style_depends() {
        return ['hqt-widgets'];
    }

    public function get_categories() {
        return [PLUGIN_SLUG];
    }

    public function get_keywords() {
        return ['posts', 'cpt', 'archive', 'loop', 'query', 'cards', 'custom post type', 'listing'];
    }

    protected function _register_controls() {

        // Test Post Type
        $this->register_test_post_type_section_controls();

        // Post layout
        $this->register_post_layout_section_controls();

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

        // Prepare query for editor mode
        if (Plugin::instance()->editor->is_edit_mode()) {
            $args = [
                'post_status' => 'publish',
                'post_type' => $settings['test_post_type'],
                'posts_per_page' => get_option('posts_per_page'),
            ];

            return new \WP_Query($args);
        }

        $query_vars = $wp_query->query_vars;

        /**
         * Allow third party plugins to change query params
         */
        $query_vars = apply_filters('hqt/widget/posts_archive/query_posts/query_vars', $query_vars);

        // Check if params are changed
        if ($query_vars !== $wp_query->query_vars) {
            $this->query = new \WP_Query($query_vars);
        } else {
            $this->query = $wp_query;
        }

        return $this->query;
    }

    public function render() {
        // Prevent using wigdet more than once on page
        if (self::$instances) {
            return;
        }
        ++self::$instances;

        $this->render_grid();
    }

}
