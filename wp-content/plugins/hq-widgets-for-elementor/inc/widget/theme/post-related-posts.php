<?php

namespace HQWidgetsForElementor\Widget\Theme;

defined('ABSPATH') || exit;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use const HQWidgetsForElementor\PLUGIN_SLUG;
use HQWidgetsForElementor\Widget\Posts_Base;

abstract class Post_Related_Posts extends Posts_Base {

    public function get_categories() {
        return [PLUGIN_SLUG];
    }

    protected function _register_controls() {

        $this->register_test_post_item_section_controls();

        // Post layout
        $this->register_post_layout_section_controls();

        // Section Query
        $this->start_controls_section(
                'section_query',
                [
                    'label' => __('Query', 'hq-widgets-for-elementor'),
                    'tab' => Controls_Manager::TAB_CONTENT,
                ]
        );

        // Relation
        $this->add_control(
                'posts_relation',
                [
                    'label' => __('Ralation', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'category' => __('Category', 'hq-widgets-for-elementor'),
                        'tag' => __('Tag', 'hq-widgets-for-elementor'),
                    ],
                    'default' => 'category',
                ]
        );

        // Offset
        $this->register_query_offset_controls();

        // Avoid Duplicates
        //$this->register_query_avoid_duplicates_controls();
        //
        // Date
        $this->register_query_date_controls();

        // Order
        $this->register_query_order_section_controls();

        // Posts Per Page
        $this->register_query_posts_per_page_controls();

        // Ignore Sticky Posts
        $this->register_query_ignore_sticky_posts_control();

        $this->end_controls_section();
    }

    public function query_posts($settings) {
        if ($this->query) {
            return $this->query;
        }

        // Prepare test item for editor mode
        if (Plugin::instance()->editor->is_edit_mode()) {
            if (!$settings['test_post_item']) {
                ?>
                <div class="elementor-alert elementor-alert-info" role="alert">
                    <span class="elementor-alert-title">
                        <?php esc_html_e('Please select Test Item', 'hq-widgets-for-elementor'); ?>
                    </span>
                    <span class="elementor-alert-description">
                        <?php esc_html_e('Test Item is used only in edit mode for better customization. On live page it will be ignored.', 'hq-widgets-for-elementor'); ?>
                    </span>
                </div>
                <?php
                return;
            }
            Plugin::instance()->db->switch_to_post($settings['test_post_item']);
        }

        global $post;
        
        if (empty($post)) {
            return;
        }

        $post_id = $post->ID;

        $relation = $settings['posts_relation'];
        if ($relation == 'category') {
            $relation_items = get_the_category($post_id);
        } else {
            $relation_items = wp_get_post_tags($post_id);
        }

        if (!$relation_items) {
            return;
        }

        $relation_ids = wp_list_pluck($relation_items, 'term_id');

        $args = [
            $relation . '__in' => $relation_ids,
            'post__not_in' => [$post_id],
            'offset' => $settings['offset'],
            'posts_per_page' => $settings['posts_per_page'],
            'ignore_sticky_posts' => $settings['ignore_sticky_posts'],
            'date_query' => $this->calculate_date_args($settings),
            'orderby' => $settings['orderby'],
            'order' => $settings['order'],
        ];

        $this->query = new \WP_Query($args);


        // Rollback to the previous global post
        if (Plugin::instance()->editor->is_edit_mode()) {
            Plugin::instance()->db->restore_current_post();
        }

        return $this->query;
    }

}
