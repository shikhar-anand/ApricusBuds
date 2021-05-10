<?php

namespace HQWidgetsForElementor\Widget\Theme;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use HQLib\Utils;
use Elementor\Plugin;

class Search_Results extends Archive_Posts {

    private static $instances = 0;

    public function get_name() {
        return 'hq-theme-search-results';
    }

    public function get_title() {
        return __('Search Results', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-grid-bordered';
    }

    public function get_keywords() {
        return ['posts', 'cpt', 'search', 'loop', 'query', 'cards', 'custom post type', 'listing'];
    }

    protected function _register_controls() {

        // Post layout
        $this->register_post_layout_section_controls();

        // Grid Controls
        $this->register_grid_controls();
        // Remove masonry tags control
        $this->remove_control('masonry_tags');
        // Pagination
        $this->register_pagination_section_controls();

        // Nothing Found
        $this->register_nothing_found_section_controls();
    }

    protected function register_post_layout_section_controls() {
        // Layout Section
        $this->start_controls_section(
                'section_layout',
                [
                    'label' => __('Layout', 'hq-widgets-for-elementor'),
                    'tab' => Controls_Manager::TAB_CONTENT,
                ]
        );

        // Post Layout
        $this->add_control(
                'post_layout_post_template',
                [
                    'label' => __('Post Layout', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'noeltmp',
                    'options' => Utils::get_elementor_templates('archive-post'),
                    'description' => Utils::get_elementor_tempalates_howto('archive-post'),
                ]
        );
        $this->add_control(
                'post_layout_page_template',
                [
                    'label' => __('Page Layout', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'default',
                    'description' => __('Default means use "Post Layout" template', 'hq-widgets-for-elementor'),
                    'options' => Utils::get_elementor_templates('archive-post', 1),
                    'description' => Utils::get_elementor_tempalates_howto('archive-post'),
                ]
        );

        $post_types = $this->get_searchable_post_types();

        foreach ($post_types as $post_type_key => $post_type) {
            // Ignore basic
            if (in_array($post_type_key, ['post', 'page'])) {
                continue;
            }
            $this->add_control(
                    'post_layout_' . $post_type . '_template',
                    [
                        'label' => ucfirst($post_type) . ' ' . __('Layout', 'hq-widgets-for-elementor'),
                        'type' => Controls_Manager::SELECT,
                        'default' => 'default',
                        'description' => __('Default means use "Post Layout" template', 'hq-widgets-for-elementor'),
                        'options' => Utils::get_elementor_templates('archive-post', 1),
                        'description' => Utils::get_elementor_tempalates_howto('archive-post'),
                    ]
            );
        }

        $this->end_controls_section();
    }

    protected function get_searchable_post_types() {

        $args = array(
            'public' => true,
            'exclude_from_search' => false,
        );
        return get_post_types($args);
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
                'post_type' => $this->get_searchable_post_types(),
                'posts_per_page' => get_option('posts_per_page'),
            ];

            return new \WP_Query($args);
        }

        $query_vars = $wp_query->query_vars;

        /**
         * Allow third party plugins to change query params
         */
        $query_vars = apply_filters('hqt/widget/posts_search/query_posts/query_vars', $query_vars);

        // Check if params are changed
        if ($query_vars !== $wp_query->query_vars) {
            $this->query = new \WP_Query($query_vars);
        } else {
            $this->query = $wp_query;
        }

        return $this->query;
    }

    protected function render_grid() {

        global $wp_query;

        $settings = $this->get_settings();

        $wp_query = $this->query_posts($settings);
        if ($wp_query && have_posts()) {

            $settings['wrapper_class'] = 'articles';

            $this->start_grid($settings);

            while (have_posts()) {
                the_post();
                if (is_sticky() && is_paged()) {
                    continue;
                }
                $masonryCssClass = '';
                ?> 
                <article id="post-<?php the_ID(); ?>" <?php post_class($masonryCssClass); ?>>
                    <?php
                    if ('default' !== $settings['post_layout_' . get_post_type() . '_template']) {
                        Utils::load_elementor_template($settings['post_layout_' . get_post_type() . '_template']);
                    } else {
                        Utils::load_elementor_template($settings['post_layout_post_template']);
                    }
                    ?>
                </article>
                <?php
            }

            $this->end_grid();

            if (!empty($settings['pagination_type']) && '' !== $settings['pagination_type']) {
                wp_reset_query();
                $this->render_pagination($settings);
            }
        }

        wp_reset_query();
    }

}
