<?php

namespace HQWidgetsForElementor\Widget\Woocommerce;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use HQWidgetsForElementor\Widget\Products_Base;
use const HQWidgetsForElementor\PLUGIN_SLUG;

abstract class Products extends Products_Base {

    public function get_icon() {
        return 'hq-w4e eicon-products';
    }

    public function get_categories() {
        return [PLUGIN_SLUG . '-woo'];
    }

    protected function _register_controls() {
        // Product layout
        $this->register_product_layout_section_controls();

        $this->start_controls_section(
                'section_content_query',
                [
                    'label' => esc_html__('Query', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'source',
                [
                    'label' => _x('Source', 'Posts Query Control', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        '' => esc_html__('Show All', 'hq-widgets-for-elementor'),
                        'by_name' => esc_html__('Manual Selection', 'hq-widgets-for-elementor'),
                    ],
                    'label_block' => true,
                ]
        );


        $product_categories = get_terms('product_cat');

        $options = [];
        foreach ($product_categories as $category) {
            $options[$category->slug] = $category->name;
        }

        $this->add_control(
                'product_categories',
                [
                    'label' => esc_html__('Categories', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::SELECT2,
                    'options' => $options,
                    'default' => [],
                    'label_block' => true,
                    'multiple' => true,
                    'condition' => [
                        'source' => 'by_name',
                    ],
                ]
        );

        $this->add_control(
                'exclude_products',
                [
                    'label' => esc_html__('Exclude Product(s)', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::TEXT,
                    'placeholder' => 'product_id',
                    'label_block' => true,
                    'description' => __('Write product id here, if you want to exclude multiple products so use comma as separator. Such as 1 , 2', ''),
                ]
        );

        $this->add_control(
                'posts_per_page',
                [
                    'label' => esc_html__('Products Per Page', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 8,
                ]
        );

        $this->add_control(
                'orderby',
                [
                    'label' => esc_html__('Order by', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'date',
                    'options' => [
                        'date' => esc_html__('Date', 'hq-widgets-for-elementor'),
                        'title' => esc_html__('Title', 'hq-widgets-for-elementor'),
                        'category' => esc_html__('Category', 'hq-widgets-for-elementor'),
                        'rand' => esc_html__('Random', 'hq-widgets-for-elementor'),
                        'meta_value_num' => esc_html__('Meta Key', 'hq-widgets-for-elementor'),
                    ],
                ]
        );

        $this->add_control(
                'meta_key',
                [
                    'label' => esc_html__('Meta Key', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'total_sales',
                    'options' => [
                        'total_sales' => esc_html__('Total Sales', 'hq-widgets-for-elementor'),
                        '_regular_price' => esc_html__('Regular Price', 'hq-widgets-for-elementor'),
                        '_sale_price' => esc_html__('Sale Price', 'hq-widgets-for-elementor'),
                    ],
                    'condition' => [
                        'orderby' => 'meta_value_num',
                    ],
                ]
        );

        $this->add_control(
                'order',
                [
                    'label' => esc_html__('Order', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'DESC',
                    'options' => [
                        'DESC' => esc_html__('Descending', 'hq-widgets-for-elementor'),
                        'ASC' => esc_html__('Ascending', 'hq-widgets-for-elementor'),
                    ],
                ]
        );

        $this->end_controls_section();
    }

    public function query_posts() {
        $settings = $this->get_settings();

        if (get_query_var('paged')) {
            $paged = get_query_var('paged');
        } elseif (get_query_var('page')) {
            $paged = get_query_var('page');
        } else {
            $paged = 1;
        }

        $exclude_products = ($settings['exclude_products']) ? explode(',', $settings['exclude_products']) : [];

        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1,
            'posts_per_page' => $settings['posts_per_page'],
            'orderby' => $settings['orderby'],
            'order' => $settings['order'],
            'paged' => $paged,
            'post__not_in' => $exclude_products,
        );

        if ('meta_value_num' === $settings['orderby']) {
            $args['meta_key'] = $settings['meta_key'];
        }

        if ('by_name' === $settings['source'] and ! empty($settings['product_categories'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => $settings['product_categories'],
                'post__not_in' => $exclude_products,
            );
        }

        $wp_query = new \WP_Query($args);

        return $wp_query;
    }

}
