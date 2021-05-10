<?php

namespace HQWidgetsForElementor\Control;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Base;
use HQLib\Utils;

class Group_Control_Posts extends Group_Control_Base {

    const INLINE_MAX_RESULTS = 200;

    protected static $fields;

    public static function get_type() {
        return 'hq-posts';
    }

    protected function init_fields() {
        $fields = [];

        $fields['post_type'] = [
            'label' => _x('Post Type', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
        ];
        $fields['posts_ids'] = [
            'label' => _x('Posts Ids', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'description' => __('Select posts by id (comma-separated list of ids)', 'hq-widgets-for-elementor'),
        ];

        return $fields;
    }

    protected function prepare_fields($fields) {
        $args = $this->get_args();

        $post_type_args = [];
        if (!empty($args['post_type'])) {
            $post_type_args['post_type'] = $args['post_type'];
        }

        $post_types = Utils::get_post_types($post_type_args);

        $post_types_options = $post_types;

        $fields['post_type']['options'] = $post_types_options;

        $fields['post_type']['default'] = key($post_types);

        $fields['posts_ids']['object_type'] = array_keys($post_types);

        $taxonomy_filter_args = [
            'show_in_nav_menus' => true,
        ];

        if (!empty($args['post_type'])) {
            $taxonomy_filter_args['object_type'] = [$args['post_type']];
        }

        $taxonomies = get_taxonomies($taxonomy_filter_args, 'objects');

        foreach ($taxonomies as $taxonomy => $object) {
            $taxonomy_args = [
                'label' => $object->label,
                'type' => 'query',
                'label_block' => true,
                'multiple' => true,
                'object_type' => $taxonomy,
                'options' => [],
                'condition' => [
                    'post_type' => $object->object_type,
                ],
            ];

            $count = wp_count_terms($taxonomy);

            $options = [];

            // TODO For large websites, use Ajax to search
            if ($count > self::INLINE_MAX_RESULTS) {
                
            } else {
                $taxonomy_args['type'] = Controls_Manager::SELECT2;

                $terms = get_terms([
                    'taxonomy' => $taxonomy,
                    'hide_empty' => false,
                ]);

                foreach ($terms as $term) {
                    $options[$term->term_id] = $term->name;
                }

                $taxonomy_args['options'] = $options;
            }

            $fields[$taxonomy . '_ids'] = $taxonomy_args;
        }

        return parent::prepare_fields($fields);
    }

    protected function get_default_options() {
        return [
            'popover' => false,
        ];
    }

}
