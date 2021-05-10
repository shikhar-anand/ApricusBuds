<?php

namespace HQWidgetsForElementor\Widget\Theme;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use Elementor\Plugin;
use const HQWidgetsForElementor\PLUGIN_SLUG;
use HQWidgetsForElementor\Widget\Posts_Base;
use HQWidgetsForElementor\Control\Group_Control_Posts;

abstract class Posts extends Posts_Base {

    public function get_categories() {
        return [PLUGIN_SLUG];
    }

    protected function _register_controls() {

        // Query Posts
        $this->register_query_section_controls();

        // Post layout
        $this->register_post_layout_section_controls();
    }

    protected function register_query_section_controls() {
        // Section Query
        $this->start_controls_section(
                'section_query', [
            'label' => __('Query', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_CONTENT,
                ]
        );

        // Post Type / Taxonomies
        $this->add_group_control(
                Group_Control_Posts::get_type(),
                [
                    'name' => 'posts',
                    'label' => esc_html__('Posts', 'hq-widgets-for-elementor'),
                ]
        );

        // Offset
        $this->register_query_offset_controls();
        $this->update_control('offset', [
            'condition' => [
                'post_type!' => [
                    'by_id',
                ],
            ]
        ]);

        // Avoid Duplicates
        $this->register_query_avoid_duplicates_controls();
        $this->update_control('avoid_duplicates', [
            'condition' => [
                'post_type!' => [
                    'by_id',
                ],
            ]
        ]);

        // Date
        $this->register_query_date_controls();
        $this->update_control('select_date', [
            'condition' => [
                'post_type!' => [
                    'by_id',
                ],
            ]
        ]);
        $this->update_control('before_date', [
            'condition' => [
                'select_date' => 'exact',
                'post_type!' => [
                    'by_id',
                ],
            ]
        ]);
        $this->update_control('after_date', [
            'condition' => [
                'select_date' => 'exact',
                'post_type!' => [
                    'by_id',
                ],
            ]
        ]);

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

        if (empty($settings['pagination_type'])) {
            $paged = 1;
            $offset = (empty($settings['offset']) ? null : $settings['offset']);
        } else {
            $paged = max(1, get_query_var('paged'), get_query_var('page'));
            $offset = null;
        }

        $args = [
            'post_status' => 'publish',
            'post_type' => $settings['posts_post_type'],
            'offset' => $offset,
            'posts_per_page' => $settings['posts_per_page'],
            'ignore_sticky_posts' => $settings['ignore_sticky_posts'],
            'date_query' => $this->calculate_date_args($settings),
            'orderby' => $settings['orderby'],
            'order' => $settings['order'],
            'paged' => $paged,
        ];


        $taxonomies = get_object_taxonomies($settings['posts_post_type'], 'objects');

        foreach ($taxonomies as $object) {
            $setting_key = 'posts_' . $object->name . '_ids';

            if (!empty($settings[$setting_key])) {
                $args['tax_query'][] = [
                    'taxonomy' => $object->name,
                    'field' => 'term_id',
                    'terms' => $settings[$setting_key],
                ];
            }
        }

        if (!empty($settings['posts_posts_ids'])) {
            $posts_posts_ids = explode(',', $settings['posts_posts_ids']);
            $posts_posts_ids = array_map(function($post_id) {
                return intval($post_id);
            }, $posts_posts_ids);

            $posts_posts_ids = array_filter($posts_posts_ids, function($v) {
                return $v > 0;
            });
            if (!empty($posts_posts_ids)) {
                $args['post__in'] = $posts_posts_ids;
            }
        }

        $this->query = new \WP_Query($args);
        return $this->query;
    }

}
