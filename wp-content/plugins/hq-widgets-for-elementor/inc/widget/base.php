<?php

namespace HQWidgetsForElementor\Widget;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Plugin;
use Elementor\Widget_Base;
use HQLib\Utils;

abstract class Base extends Widget_Base {

    protected $post_type = 'post';
    protected $post_type_display_name = 'post';

    protected function register_test_post_type_section_controls() {
        // Test Post Type Section
        $this->start_controls_section(
                'section_test_post_type', [
            'label' => __('Test Post Type', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_CONTENT,
                ]
        );

        // Explanation
        $this->add_control(
                'test_post_type_alert', [
            'raw' => __('Test Post Type is used only in edit mode for better customization. On live page it will be ignored.', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::RAW_HTML,
            'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
        );

        // Test Post Type
        $this->add_control(
                'test_post_type', [
            'label' => __('Test Post Type', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'post',
            'options' => Utils::get_post_types(),
                ]
        );

        $this->end_controls_section();
    }

    protected function update_pagination_section_controls() {
        $this->update_control('pagination_type', [
            'options' => [
                '' => __('None', 'hq-widgets-for-elementor'),
                'infinite_scroll' => __('AJAX (Infinite Scroll)', 'hq-widgets-for-elementor'),
            ],
        ]);

        $this->update_control('load_more_btn', [
            'type' => \Elementor\Controls_Manager::HIDDEN, 'default' => 'yes'
        ]);

        $this->remove_control('infinite_history');
    }

    protected function register_test_post_item_section_controls($args = []) {
        // Test Post Type Section
        $this->start_controls_section(
                'section_test_post_item', [
            'label' => __('Test Item', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_CONTENT,
                ]
        );

        // Explanation
        $this->add_control(
                'test_post_item_alert', [
            'raw' => __('Test Item is used only in edit mode for better customization. On live page it will be ignored.', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::RAW_HTML,
            'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
        );

        // Test Post Item
        $this->add_control(
                'test_post_item', [
            'label' => __('Test Item', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT2,
            'label_block' => true,
            'default' => [],
            'options' => Utils::get_posts($args),
                ]
        );

        $this->end_controls_section();
    }

    protected function start_slider($settings) {
        $this->add_render_attribute('carousel', 'class', 'swiper-wrapper');
        ?>
        <div class="swiper-container">
            <div <?php echo $this->get_render_attribute_string('carousel'); ?>>
                <?php
            }

            protected function end_slider($settings) {
                ?>
            </div>
        </div>
        <?php
        if (isset($settings['navigation']) && in_array($settings['navigation'], ['dots', 'both'])) {
            ?>
            <div class="swiper-pagination"></div>
            <?php
        }
        if (isset($settings['navigation']) && in_array($settings['navigation'], ['arrows', 'both'])) {
            ?>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <?php
        }
    }

    protected function start_grid($settings) {

        $this->add_render_attribute('items', 'class', [
            'articles',
            'layout-grid',
            'layout-grid-col-' . $settings['columns'],
            'layout-grid-col-tablet-' . $settings['columns_tablet'],
            'layout-grid-col-mobile-' . $settings['columns_mobile'],
            'layout-grid-gap-' . $settings['row_gap'],
        ]);
        $this->add_render_attribute('items', 'data-articles-id', 'articles-' . $this->get_id());

        if (!$settings['masonry_grid']) {
            $this->add_render_attribute('items', 'class', 'layout-grid-flex');
        } else {
            $this->add_render_attribute('items', 'class', 'layout-grid-masonry');
        }
        ?>
        <div <?php echo $this->get_render_attribute_string('items'); ?>>
            <?php
        }

        protected function end_grid() {
            ?>
        </div>
        <?php
    }

    protected function get_script_depends_slider($depends = []) {
        array_unshift($depends, 'jquery-swiper', 'hqt-widgets');
        return $depends;
    }

    protected function get_style_depends_slider($depends = []) {
        array_unshift($depends, 'jquery-swiper', 'hqt-widgets');
        return $depends;
    }

    protected function get_script_depends_grid($depends = []) {
        array_unshift($depends, 'isotope', 'jquery.infinitescroll', 'hqt-widgets');
        return $depends;
    }

    protected function register_slider_controls() {

        // Section Slider
        $this->start_controls_section('section_slider', [
            'label' => __('Slider', 'hq-widgets-for-elementor'),
        ]);

        // Slides to Show
        $slides_to_show = range(1, 10);
        $slides_to_show = array_combine($slides_to_show, $slides_to_show);

        $this->add_responsive_control('slides_to_show', [
            'label' => __('Slides to Show', 'hq-widgets-for-elementor'),
            'default' => '1',
            'type' => Controls_Manager::SELECT,
            'options' => $slides_to_show,
            'frontend_available' => true,
        ]);

        // Slides to Scroll
        $this->add_responsive_control('slides_to_scroll', [
            'label' => __('Slides to Scroll', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'description' => __('Set how many slides are scrolled per swipe.', 'hq-widgets-for-elementor'),
            'options' => [
        '' => __('Default', 'hq-widgets-for-elementor'),
            ] + $slides_to_show,
            'condition' => [
                'slides_to_show!' => '1',
            ],
            'frontend_available' => true,
        ]);

        // Position
        $this->add_responsive_control('slides_space_between', [
            'label' => __('Space Between Slides', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'frontend_available' => true,
            'units' => ['px', 'en'],
            'condition' => [
                'slides_to_show!' => '1',
            ],
        ]);

        $this->add_control('slider_auto_height', [
            'label' => __('Auto Height', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'description' => __('Slider wrapper will adopt its height to the height of the currently active slide.', 'hq-widgets-for-elementor'),
            'frontend_available' => true,
        ]);

        // Navigation
        $this->add_control('navigation', [
            'label' => __('Navigation', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'both',
            'options' => [
                'both' => __('Arrows and Dots', 'hq-widgets-for-elementor'),
                'arrows' => __('Arrows', 'hq-widgets-for-elementor'),
                'dots' => __('Dots', 'hq-widgets-for-elementor'),
                'none' => __('None', 'hq-widgets-for-elementor'),
            ],
            'frontend_available' => true,
        ]);

        // Autoplay
        $this->add_control('autoplay', [
            'label' => __('Autoplay', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_off' => __('No', 'hq-widgets-for-elementor'),
            'label_on' => __('Yes', 'hq-widgets-for-elementor'),
            'frontend_available' => true,
        ]);

        // Autoplay Speed
        $this->add_control('autoplay_speed', [
            'label' => __('Autoplay Speed', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 5000,
            'frontend_available' => true,
            'condition' => [
                'autoplay' => 'yes',
            ],
        ]);

        // Pause on Hover
        $this->add_control('disable_on_interaction', [
            'label' => __('Disable on Interaction', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_off' => __('No', 'hq-widgets-for-elementor'),
            'label_on' => __('Yes', 'hq-widgets-for-elementor'),
            'frontend_available' => true,
            'condition' => [
                'autoplay' => 'yes',
            ],
        ]);

        // Infinite Loop
        $this->add_control('infinite', [
            'label' => __('Infinite Loop', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_off' => __('No', 'hq-widgets-for-elementor'),
            'label_on' => __('Yes', 'hq-widgets-for-elementor'),
            'frontend_available' => true,
        ]);

        // Effect
        $this->add_control('effect', [
            'label' => __('Effect', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'slide',
            'options' => [
                'slide' => __('Slide', 'hq-widgets-for-elementor'),
                'fade' => __('Fade', 'hq-widgets-for-elementor'),
                'cube' => __('Cube', 'hq-widgets-for-elementor'),
                'coverflow' => __('Coverflow', 'hq-widgets-for-elementor'),
                'flip' => __('Flip', 'hq-widgets-for-elementor'),
            ],
            'description' => __('Fade, Cube and Flip effects works well only if Slides to Show is set to 1', 'hq-widgets-for-elementor'),
            'frontend_available' => true,
        ]);

        // Animation Speed
        $this->add_control('speed', [
            'label' => __('Animation Speed', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 500,
            'frontend_available' => true,
        ]);

        $this->end_controls_section();

        // Section Navigation Styles
        $this->start_controls_section('navigation_arrows', [
            'label' => __('Arrows', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'navigation' => ['arrows', 'both'],
            ],
        ]);

        // Position
        $this->add_responsive_control('arrows_position', [
            'label' => __('Position', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => -100,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'navigation' => ['arrows', 'both'],
            ],
        ]);

        // Size
        $this->add_responsive_control('arrows_size', [
            'label' => __('Size', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 20,
                    'max' => 60,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .swiper-button-prev, {{WRAPPER}} .swiper-button-next' => 'width: calc({{SIZE}}{{UNIT}} / 44 * 27);height: {{SIZE}}{{UNIT}}',
                '{{WRAPPER}} .swiper-button-next:after, {{WRAPPER}} .swiper-button-prev:after' => 'font-size: {{SIZE}}{{UNIT}}',
            ],
            'condition' => [
                'navigation' => ['arrows', 'both'],
            ],
        ]);

        $this->add_responsive_control('arrows_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('arrows_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->start_controls_tabs('arrows_tabs', [
            'condition' => [
                'navigation' => ['arrows', 'both'],
            ],
        ]);

        $this->start_controls_tab('arrows_tab_normal', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('arrows_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'color: {{VALUE}}',
            ],
            'default' => '#333333',
        ]);

        $this->add_control('arrows_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'background: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'arrows_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev',
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('arrows_tab_hover', [
            'label' => __('Hover', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('arrows_hover_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .swiper-button-next:hover, {{WRAPPER}} .swiper-button-prev:hover' => 'color: {{VALUE}}',
            ],
        ]);

        $this->add_control('arrows_background_hover_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .swiper-button-next:hover, {{WRAPPER}} .swiper-button-prev:hover' => 'background: {{VALUE}};',
            ],
        ]);

        $this->add_control('arrows_hover_border_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .swiper-button-next:hover, {{WRAPPER}} .swiper-button-prev:hover' => 'border-color: {{VALUE}}',
            ],
        ]);

        $this->add_control('arrows_transition_duration', [
            'label' => __('Transition Duration', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 1000,
                    'step' => 100,
                ],
            ],
            'default' => [
                'size' => 300,
            ],
            'selectors' => [
                '{{WRAPPER}} .swiper-button-prev, {{WRAPPER}} .swiper-button-next' => 'transition-duration: {{SIZE}}ms',
            ],
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section('navigatoin_dots', [
            'label' => __('Dots', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'navigation' => ['dots', 'both'],
            ],
        ]);

        $this->add_responsive_control('dots_alignment', [
            'label' => __('Alignment', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Left', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-center',
                ],
                'right' => [
                    'title' => __('Right', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-right',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .swiper-pagination' => 'text-align: {{VALUE}}'
            ],
        ]);

        // Position
        $this->add_responsive_control('dots_position', [
            'label' => __('Offset', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => -100,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .swiper-container-horizontal+.swiper-pagination-bullets' => 'bottom: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'navigation' => ['dots', 'both'],
            ],
        ]);

        // Size
        $this->add_responsive_control('dots_size', [
            'label' => __('Size', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 5,
                    'max' => 20,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .swiper-container-horizontal+.swiper-pagination-bullets .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}}',
            ],
            'condition' => [
                'navigation' => ['dots', 'both'],
            ],
        ]);

        // Gap
        $this->add_control('dots_gap', [
            'label' => __('Gap', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 20,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .swiper-container-horizontal+.swiper-pagination-bullets .swiper-pagination-bullet' => 'margin: 0 {{SIZE}}{{UNIT}}',
            ],
            'condition' => [
                'navigation' => ['dots', 'both'],
            ],
        ]);

        // Color
        $this->add_control('dots_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .swiper-pagination-bullet-active' => 'background: {{VALUE}};',
            ],
            'default' => '#333333',
            'condition' => [
                'navigation' => ['dots', 'both'],
            ],
        ]);

        $this->end_controls_section();
    }

    protected function register_grid_controls() {
        // Section Grid
        $this->start_controls_section('section_grid', [
            'label' => __('Grid', 'hq-widgets-for-elementor'),
        ]);

        // Columns
        $this->add_responsive_control('columns', [
            'label' => __('Columns', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => '3',
            'tablet_default' => '2',
            'mobile_default' => '1',
            'options' => [
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
            ],
        ]);

        // Columns Gap
        $this->add_control('column_gap', [
            'label' => __('Columns Gap', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 30,
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 5,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .layout-grid' => 'margin-left: -{{SIZE}}px',
                '{{WRAPPER}} .layout-grid > *' => 'padding-left: {{SIZE}}px',
            ],
        ]);

        // Rows Gap
        $this->add_control('row_gap', [
            'label' => __('Rows Gap', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'small',
            'options' => [
                'small' => __('Small', 'hq-widgets-for-elementor'),
                'medium' => __('Medium', 'hq-widgets-for-elementor'),
                'large' => __('Large', 'hq-widgets-for-elementor'),
                'none' => __('None', 'hq-widgets-for-elementor'),
            ],
        ]);

        // Masonry Grid
        $this->add_control('masonry_grid', [
            'label' => __('Masonry', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'default' => '',
            'frontend_available' => true,
        ]);



        // Masonry Styles
        $this->add_control('masonry_tags', [
            'label' => __('Tags', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT2,
            'options' => [],
            'description' => 'Posts with selected tags will be displayed with double width',
            'multiple' => true,
            'condition' => [
                'masonry_grid' => 'yes'
            ]
        ]);

        $this->end_controls_section();

        $this->start_controls_section('section_grid_cell_style', [
            'tab' => Controls_Manager::TAB_STYLE,
            'label' => __('Grid Cell', 'hq-widgets-for-elementor'),
        ]);

        $this->start_controls_tabs('tabs_grid_cell_style');

        $this->start_controls_tab('tab_grid_cell_normal', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name' => 'grid_cell_background',
            'label' => __('Background', 'hq-widgets-for-elementor'),
            'types' => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .layout-grid article > *, {{WRAPPER}} .layout-grid .product > *',
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'grid_cell_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .layout-grid article > *, {{WRAPPER}} .layout-grid .product > *',
            'separator' => 'before',
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'grid_cell_box_shadow',
            'label' => __('Box Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .layout-grid article > *, {{WRAPPER}} .layout-grid .product > *',
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('tab_grid_cell_hover', [
            'label' => __('Hover', 'hq-widgets-for-elementor'),
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name' => 'grid_cell_hover_background',
            'label' => __('Background', 'hq-widgets-for-elementor'),
            'types' => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .layout-grid article:hover > *, {{WRAPPER}} .layout-grid .product:hover > *',
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'grid_cell_hover_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .layout-grid article:hover > *, {{WRAPPER}} .layout-grid .product:hover > *',
            'separator' => 'before',
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'grid_cell_hover_box_shadow',
            'label' => __('Box Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .layout-grid article:hover > *, {{WRAPPER}} .layout-grid .product:hover > *',
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    public function register_nothing_found_section_controls() {

        $this->start_controls_section('section_advanced', [
            'label' => __('Nothing Found', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('nothing_found_message', [
            'label' => __('Nothing Found Message', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXTAREA,
            'default' => __('It seems we can\'t find what you\'re looking for.', 'hq-widgets-for-elementor'),
            'dynamic' => [
                'active' => true,
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('section_nothing_found_style', [
            'tab' => Controls_Manager::TAB_STYLE,
            'label' => __('Nothing Found Message', 'hq-widgets-for-elementor'),
            'condition' => [
                'nothing_found_message!' => '',
            ],
        ]);

        $this->add_control('nothing_found_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elementor-posts-nothing-found' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'nothing_found_typography',
            'selector' => '{{WRAPPER}} .elementor-posts-nothing-found',
        ]);

        $this->end_controls_section();
    }

    protected function register_pagination_section_controls() {
        // Section Pagination
        $this->start_controls_section('section_pagination', [
            'label' => __('Pagination', 'hq-widgets-for-elementor'),
        ]);

        // Pagination
        $this->add_control('pagination_type', [
            'label' => __('Pagination', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => '',
            'frontend_available' => true,
            'options' => [
                '' => __('None', 'hq-widgets-for-elementor'),
                'infinite_scroll' => __('AJAX (Infinite Scroll)', 'hq-widgets-for-elementor'),
                'numbers' => __('Numbers', 'hq-widgets-for-elementor'),
                'prev_next' => __('Previous/Next', 'hq-widgets-for-elementor'),
                'numbers_and_prev_next' => __('Numbers', 'hq-widgets-for-elementor') . ' + ' . __('Previous/Next', 'hq-widgets-for-elementor'),
            ],
        ]);

        // Page Limit
        $this->add_control('pagination_page_limit', [
            'label' => __('Page Limit', 'hq-widgets-for-elementor'),
            'default' => '5',
            'condition' => [
                'pagination_type!' => [
                    '',
                ]
            ],
        ]);

        $this->add_control('infinite_history', [
            'label' => __('History', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => '',
            'options' => [
                '' => __('None', 'hq-widgets-for-elementor'),
                'replace' => __('Replace', 'hq-widgets-for-elementor'),
                'push' => __('Push', 'hq-widgets-for-elementor'),
            ],
            'render_type' => 'none',
            'frontend_available' => true,
            'description' => __('Changes page URL and browser history.', 'hq-widgets-for-elementor'),
            'condition' => [
                'pagination_type' => 'infinite_scroll',
            ],
        ]);

        $this->add_control('load_on_scroll', [
            'label' => __('Load On Scroll', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'render_type' => 'none',
            'frontend_available' => true,
            'description' => __('Loads next page when scroll crosses over scroll threshold (200px)', 'hq-widgets-for-elementor'),
            'condition' => [
                'pagination_type' => 'infinite_scroll',
            ],
        ]);

        $this->add_control('load_more_btn', [
            'label' => __('Load More Button', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'frontend_available' => true,
            'default' => 'yes',
            'condition' => [
                'pagination_type' => 'infinite_scroll',
            ],
        ]);

        $this->add_control('load_more_label', [
            'label' => __('Button Label', 'hq-widgets-for-elementor'),
            'default' => 'Load More',
            'frontend_available' => true,
            'condition' => [
                'pagination_type' => 'infinite_scroll',
                'load_more_btn' => 'yes'
            ],
        ]);

        // Alignment
        $this->add_responsive_control('load_more_align', [
            'label' => __('Alignment', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Left', 'hq-widgets-for-elementor'),
                    'icon' => 'fa fa-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'hq-widgets-for-elementor'),
                    'icon' => 'fa fa-align-center',
                ],
                'right' => [
                    'title' => __('Right', 'hq-widgets-for-elementor'),
                    'icon' => 'fa fa-align-right',
                ],
            ],
            'default' => 'center',
            'selectors' => [
                '{{WRAPPER}} .hqt-load-more-btn' => 'text-align: {{VALUE}};',
            ],
            'condition' => [
                'pagination_type' => 'infinite_scroll',
                'load_more_btn' => 'yes'
            ],
        ]);

        $this->add_control('infinite_status_messages', [
            'label' => __('Status Messages', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'separator' => 'before',
            'condition' => [
                'pagination_type' => 'infinite_scroll',
            ],
        ]);

        $this->add_control('infinite_loader', [
            'label' => __('Enable Preloader', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => [
                'pagination_type' => 'infinite_scroll',
                'infinite_status_messages' => 'yes',
            ],
        ]);

        $this->add_control('infinite_scroll_msg_request', [
            'label' => __('Loading content message', 'hq-widgets-for-elementor'),
            'default' => 'Loading...',
            'condition' => [
                'pagination_type' => 'infinite_scroll',
                'infinite_status_messages' => 'yes'
            ],
        ]);

        $this->add_control('infinite_scroll_msg_last', [
            'label' => __('End of content message', 'hq-widgets-for-elementor'),
            'default' => 'End of content',
            'condition' => [
                'pagination_type' => 'infinite_scroll',
                'infinite_status_messages' => 'yes'
            ],
        ]);

        $this->add_control('infinite_scroll_msg_error', [
            'label' => __('Error message', 'hq-widgets-for-elementor'),
            'default' => 'No more pages to load',
            'condition' => [
                'pagination_type' => 'infinite_scroll',
                'infinite_status_messages' => 'yes'
            ],
        ]);

        // Shorten
        $this->add_control('pagination_numbers_shorten', [
            'label' => __('Shorten', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'default' => '',
            'condition' => [
                'pagination_type' => [
                    'numbers',
                    'numbers_and_prev_next',
                ],
            ],
        ]);

        // Previous Icon
        $this->add_control('pagination_prev_icon', [
            'label' => __('Previous Icon', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-angle-left',
                'library' => 'fa-solid',
            ],
            'condition' => [
                'pagination_type' => [
                    'prev_next',
                    'numbers_and_prev_next',
                ],
            ],
        ]);

        // Previous Label
        $this->add_control('pagination_prev_label', [
            'label' => __('Previous Label', 'hq-widgets-for-elementor'),
            'default' => __('Previous', 'hq-widgets-for-elementor'),
            'condition' => [
                'pagination_type' => [
                    'prev_next',
                    'numbers_and_prev_next',
                ],
            ],
        ]);

        // Next Icon
        $this->add_control('pagination_next_icon', [
            'label' => __('Next Icon', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-angle-right',
                'library' => 'fa-solid',
            ],
            'condition' => [
                'pagination_type' => [
                    'prev_next',
                    'numbers_and_prev_next',
                ],
            ],
        ]);

        // Next Label
        $this->add_control('pagination_next_label', [
            'label' => __('Next Label', 'hq-widgets-for-elementor'),
            'default' => __('Next', 'hq-widgets-for-elementor'),
            'condition' => [
                'pagination_type' => [
                    'prev_next',
                    'numbers_and_prev_next',
                ],
            ],
        ]);

        // Alignment
        $this->add_responsive_control('pagination_align', [
            'label' => __('Alignment', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Left', 'hq-widgets-for-elementor'),
                    'icon' => 'fa fa-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'hq-widgets-for-elementor'),
                    'icon' => 'fa fa-align-center',
                ],
                'right' => [
                    'title' => __('Right', 'hq-widgets-for-elementor'),
                    'icon' => 'fa fa-align-right',
                ],
            ],
            'default' => 'center',
            'selectors' => [
                '{{WRAPPER}} .hqt-pagination' => 'text-align: {{VALUE}};',
            ],
            'condition' => [
                'pagination_type!' => [
                    '',
                    'infinite_scroll'
                ],
            ],
        ]);

        $this->end_controls_section();

        // Section Pagination Styles
        $this->start_controls_section('section_pagination_style', [
            'label' => __('Pagination', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'pagination_type!' => [
                    '',
                    'infinite_scroll',
                ],
            ],
        ]);

        // Typography
        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'pagination_typography',
            'selector' => '{{WRAPPER}} .hqt-pagination .page-numbers',
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'label' => 'Icon Typography',
            'name' => 'pagination_icon_typography',
            'selector' => '{{WRAPPER}} .hqt-pagination .page-numbers > i',
            'exclude' => ['font_family', 'font_weight', 'text_transform', 'font_style', 'text_decoration', 'letter_spacing'],
        ]);

        $this->add_responsive_control('pagination_icon_spacing', [
            'label' => __('Icon Spacing', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 50,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .hqt-pagination .page-numbers.prev > i' => 'margin-right: {{SIZE}}{{UNIT}}',
                '{{WRAPPER}} .hqt-pagination .page-numbers.next > i' => 'margin-left: {{SIZE}}{{UNIT}}',
            ],
        ]);

        // Colors
        $this->add_control('pagination_color_heading', [
            'label' => __('Colors', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);

        $this->start_controls_tabs('pagination_colors');

        // Tab Normal
        $this->start_controls_tab('pagination_color_normal', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
        ]);

        // Color
        $this->add_control('pagination_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hqt-pagination .page-numbers:not(.dots)' => 'color: {{VALUE}};',
            ],
        ]);

        // Background Color
        $this->add_control('pagination_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hqt-pagination .page-numbers:not(.dots)' => 'background: {{VALUE}};',
            ],
        ]);

        // Border
        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'pagination_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hqt-pagination .page-numbers:not(.dots)',
        ]);

        $this->end_controls_tab();

        // Tab Hover
        $this->start_controls_tab('pagination_color_hover', [
            'label' => __('Hover', 'hq-widgets-for-elementor'),
        ]);

        // Color
        $this->add_control(
                'pagination_hover_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hqt-pagination a.page-numbers:hover' => 'color: {{VALUE}};',
            ],
                ]
        );

        // Background Color
        $this->add_control(
                'pagination_hover_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hqt-pagination a.page-numbers:hover' => 'background: {{VALUE}};',
            ],
                ]
        );

        // Border
        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'pagination_hover_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hqt-pagination a.page-numbers:hover',
                ]
        );

        $this->end_controls_tab();

        // Tab Active
        $this->start_controls_tab(
                'pagination_color_active', [
            'label' => __('Active', 'hq-widgets-for-elementor'),
                ]
        );

        // Color
        $this->add_control(
                'pagination_active_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hqt-pagination .page-numbers.current' => 'color: {{VALUE}};',
            ],
                ]
        );

        // Background Color
        $this->add_control(
                'pagination_active_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hqt-pagination .page-numbers.current' => 'background: {{VALUE}};',
            ],
                ]
        );

        // Border
        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'pagination_active_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hqt-pagination .page-numbers.current',
                ]
        );

        $this->end_controls_tab();

        // Tab Disabled
        $this->start_controls_tab(
                'pagination_color_disabled', [
            'label' => __('Disabled', 'hq-widgets-for-elementor'),
                ]
        );

        // Color
        $this->add_control(
                'pagination_disabled_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hqt-pagination span.page-numbers:not(.dots):not(.current)' => 'color: {{VALUE}};',
            ],
                ]
        );

        // Background Color
        $this->add_control(
                'pagination_disabled_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hqt-pagination span.page-numbers:not(.dots):not(.current)' => 'background: {{VALUE}};',
            ],
                ]
        );

        // Border
        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'pagination_disabled_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hqt-pagination span.page-numbers:not(.dots):not(.current)',
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        // Space Between
        $this->add_responsive_control(
                'pagination_offset', [
            'label' => __('Offset', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'separator' => 'before',
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .hqt-pagination ' => 'margin-top: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        // Space Between
        $this->add_responsive_control(
                'pagination_spacing', [
            'label' => __('Space Between', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 10,
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                'body:not(.rtl) {{WRAPPER}} .hqt-pagination .page-numbers:not(:first-child)' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 );',
                'body:not(.rtl) {{WRAPPER}} .hqt-pagination .page-numbers:not(:last-child)' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
                'body.rtl {{WRAPPER}} .hqt-pagination .page-numbers:not(:first-child)' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
                'body.rtl {{WRAPPER}} .hqt-pagination .page-numbers:not(:last-child)' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 );',
            ],
                ]
        );

        // Padding
        $this->add_responsive_control(
                'pagination_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .hqt-pagination .page-numbers' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before'
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section('section_infinite_pagination_style', [
            'label' => __('Infinite Pagination', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'conditions' => [
                'relation' => 'and',
                'terms' => [
                    [
                        'name' => 'pagination_type',
                        'operator' => '==',
                        'value' => 'infinite_scroll'
                    ],
                    [
                        'relation' => 'or',
                        'terms' => [
                            [
                                'name' => 'load_more_btn',
                                'operator' => '==',
                                'value' => 'yes'
                            ],
                            [
                                'name' => 'infinite_status_messages',
                                'operator' => '==',
                                'value' => 'yes'
                            ]
                        ]
                    ]
                ]
            ],
            'condition' => [
                'pagination_type' => 'infinite_scroll',
            ],
        ]);

        $this->add_control('infinite_button_heading', [
            'label' => __('Load More Button', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'condition' => [
                'pagination_type' => 'infinite_scroll',
                'load_more_btn' => 'yes'
            ],
        ]);

        $this->add_responsive_control('infinite_button_width', [
            'label' => __('Width', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['%', 'px', 'em',],
            'range' => [
                'px' => [
                    'min' => 10,
                    'max' => 1200,
                ],
                'em' => [
                    'min' => 1,
                    'max' => 80,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-button.archive-load-more' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('infinite_button_gap', [
            'label' => __('Top Gap', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .hqt-load-more-btn' => 'margin-top: {{SIZE}}{{UNIT}}',
            ],
            'condition' => [
                'pagination_type' => 'infinite_scroll',
                'load_more_btn' => 'yes'
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'infinite_button_typography',
            'selector' => '{{WRAPPER}} .elementor-button.archive-load-more',
            'condition' => [
                'pagination_type' => 'infinite_scroll',
                'load_more_btn' => 'yes'
            ],
        ]);

        $this->start_controls_tabs('infinite_button_tabs', [
            'condition' => [
                'pagination_type' => 'infinite_scroll',
                'load_more_btn' => 'yes'
            ],
        ]);

        $this->start_controls_tab('infinite_button_normal_tab', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('infinite_button_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elementor-button.archive-load-more' => 'color: {{VALUE}}',
            ],
        ]);

        $this->add_control('infinite_button_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elementor-button.archive-load-more' => 'background-color: {{VALUE}}',
            ],
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('infinite_button_hover_tab', [
            'label' => __('Hover', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('infinite_hover_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elementor-button.archive-load-more:hover' => 'color: {{VALUE}}',
            ],
        ]);

        $this->add_control('infinite_button_hover_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elementor-button.archive-load-more:hover' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('infinite_button_hover_border_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elementor-button.archive-load-more:hover' => 'border-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('infinite_button_hover_animation', [
            'label' => __('Animation', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HOVER_ANIMATION,
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'infinite_button_border',
            'label' => __('Button Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .elementor-button.archive-load-more',
            'separator' => 'before',
            'condition' => [
                'pagination_type' => 'infinite_scroll',
                'load_more_btn' => 'yes'
            ],
        ]);

        $this->add_responsive_control('infinite_button_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .elementor-button.archive-load-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'condition' => [
                'pagination_type' => 'infinite_scroll',
                'load_more_btn' => 'yes'
            ],
        ]);

        $this->add_responsive_control('infinite_button_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .elementor-button.archive-load-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'condition' => [
                'pagination_type' => 'infinite_scroll',
                'load_more_btn' => 'yes'
            ],
        ]);

        $this->add_control('infinite_status_heading', [
            'label' => __('Status Messages', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => [
                'pagination_type' => 'infinite_scroll',
                'infinite_status_messages' => 'yes'
            ],
        ]);

        $this->add_responsive_control('infinite_scroll_msg_align', [
            'label' => __('Alignment', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Left', 'hq-widgets-for-elementor'),
                    'icon' => 'fa fa-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'hq-widgets-for-elementor'),
                    'icon' => 'fa fa-align-center',
                ],
                'right' => [
                    'title' => __('Right', 'hq-widgets-for-elementor'),
                    'icon' => 'fa fa-align-right',
                ],
            ],
            'default' => 'center',
            'selectors' => [
                '{{WRAPPER}} .hqt-load-more-status' => 'text-align: {{VALUE}};',
            ],
            'condition' => [
                'pagination_type' => 'infinite_scroll',
                'infinite_status_messages' => 'yes'
            ],
        ]);

        $this->add_responsive_control('infinite_status_gap', [
            'label' => __('Gap', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .hqt-load-more-status' => 'margin-top: {{SIZE}}{{UNIT}}',
            ],
            'condition' => [
                'pagination_type' => 'infinite_scroll',
                'infinite_status_messages' => 'yes'
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'infinite_status_typography',
            'selector' => '{{WRAPPER}} .hqt-load-more-status .hqt-load-more-text',
            'condition' => [
                'pagination_type' => 'infinite_scroll',
                'infinite_status_messages' => 'yes'
            ],
        ]);

        $this->add_control('infinite_status_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hqt-load-more-status .hqt-load-more-text' => 'color: {{VALUE}}',
            ],
            'condition' => [
                'pagination_type' => 'infinite_scroll',
                'infinite_status_messages' => 'yes'
            ],
        ]);

        $this->add_control('infinite_loader_heading', [
            'label' => __('Preloader', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => [
                'pagination_type' => 'infinite_scroll',
                'infinite_status_messages' => 'yes',
                'infinite_loader' => 'yes'
            ],
        ]);

        $this->add_responsive_control('infinite_loader_align', [
            'label' => __('Alignment', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Left', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-center',
                ],
                'right' => [
                    'title' => __('Right', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-right',
                ],
            ],
            'default' => 'center',
            'selectors_dictionary' => [
                'left' => 'margin-left: 0; margin-right: auto;',
                'center' => 'margin-left: auto; margin-right: auto;',
                'right' => 'margin-left: auto; margin-right: 0;',
            ],
            'selectors' => [
                '{{WRAPPER}} .hqt-loader' => '{{VALUE}};',
            ],
            'condition' => [
                'pagination_type' => 'infinite_scroll',
                'infinite_status_messages' => 'yes'
            ],
        ]);

        $this->add_responsive_control('infinite_loader_width', [
            'label' => __('Size', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 10,
                    'max' => 50,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .hqt-loader' => 'width: calc({{SIZE}}{{UNIT}} * 4)',
                '{{WRAPPER}} .hqt-loader > div' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
            ],
            'condition' => [
                'pagination_type' => 'infinite_scroll',
                'infinite_status_messages' => 'yes',
                'infinite_loader' => 'yes'
            ],
        ]);

        $this->add_responsive_control('infinite_loader_gap', [
            'label' => __('Bottom Gap', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .hqt-loader' => 'margin-bottom: {{SIZE}}{{UNIT}}',
            ],
            'condition' => [
                'pagination_type' => 'infinite_scroll',
                'infinite_status_messages' => 'yes',
                'infinite_loader' => 'yes',
                'infinite_scroll_msg_request!' => '',
            ],
        ]);

        $this->add_control('infinite_loader_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hqt-loader > div' => 'background: {{VALUE}}',
            ],
            'condition' => [
                'pagination_type' => 'infinite_scroll',
                'infinite_status_messages' => 'yes',
                'infinite_loader' => 'yes'
            ],
        ]);

        $this->end_controls_section();
    }

    protected function register_query_posts_per_page_controls() {
        // Posts Per Page
        $this->add_control(
                'posts_per_page', [
            'label' => __('Posts Per Page', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 4,
                ]
        );
    }

    protected function register_query_offset_controls() {
        // Offset
        $this->add_control(
                'offset', [
            'label' => __('Offset', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => '',
            'separator' => 'before',
            'description' => __('Use this setting to skip over ' . $this->post_type_display_name . 's (e.g. \'5\' to skip over 5 posts).', 'hq-widgets-for-elementor'),
                ]
        );
    }

    protected function register_query_avoid_duplicates_controls() {
        // Avoid Duplicates
        $this->add_control(
                'avoid_duplicates', [
            'label' => __('Avoid Duplicates', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'default' => '',
                ]
        );
    }

    protected function register_query_date_controls() {
        // Date
        $this->add_control(
                'select_date', [
            'label' => __('Date', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'post_type' => '',
            'options' => [
                'anytime' => __('All', 'hq-widgets-for-elementor'),
                'today' => __('Past Day', 'hq-widgets-for-elementor'),
                'week' => __('Past Week', 'hq-widgets-for-elementor'),
                'month' => __('Past Month', 'hq-widgets-for-elementor'),
                'quarter' => __('Past Quarter', 'hq-widgets-for-elementor'),
                'year' => __('Past Year', 'hq-widgets-for-elementor'),
                'exact' => __('Custom', 'hq-widgets-for-elementor'),
            ],
            'default' => 'anytime',
            'label_block' => false,
            'multiple' => false,
            'filter_type' => 'date',
            'include_type' => true,
            'separator' => 'before',
                ]
        );

        // Before
        $this->add_control(
                'date_before', [
            'label' => __('Before', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DATE_TIME,
            'post_type' => '',
            'label_block' => false,
            'multiple' => false,
            'filter_type' => 'date',
            'include_type' => true,
            'condition' => [
                'select_date' => 'exact',
            ],
            'placeholder' => __('Choose', 'hq-widgets-for-elementor'),
            'description' => __('Setting a ‘Before’ date will show all the ' . $this->post_type_display_name . 's published until the chosen date (inclusive).', 'hq-widgets-for-elementor'),
                ]
        );

        // After
        $this->add_control(
                'date_after', [
            'label' => __('After', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DATE_TIME,
            'post_type' => '',
            'label_block' => false,
            'multiple' => false,
            'filter_type' => 'date',
            'include_type' => true,
            'condition' => [
                'select_date' => 'exact',
            ],
            'placeholder' => __('Choose', 'hq-widgets-for-elementor'),
            'description' => __('Setting an ‘After’ date will show all the ' . $this->post_type_display_name . 's published since the chosen date (inclusive).', 'hq-widgets-for-elementor'),
                ]
        );
    }

    protected function register_query_order_section_controls() {
        // Order By
        $this->add_control(
                'orderby', [
            'label' => __('Order By', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'post_date',
            'options' => [
                'post_date' => __('Date', 'hq-widgets-for-elementor'),
                'post_title' => __('Title', 'hq-widgets-for-elementor'),
                'menu_order' => __('Menu Order', 'hq-widgets-for-elementor'),
                'rand' => __('Random', 'hq-widgets-for-elementor'),
            ],
            'separator' => 'before',
                ]
        );

        // Order
        $this->add_control(
                'order', [
            'label' => __('Order', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'desc',
            'options' => [
                'asc' => __('ASC', 'hq-widgets-for-elementor'),
                'desc' => __('DESC', 'hq-widgets-for-elementor'),
            ],
                ]
        );
    }

    protected function register_query_include_exclude_section_controls() {

        $this->start_controls_tabs('query_args');

        // Tab Include
        $this->start_controls_tab('query_include', [
            'label' => __('Include', 'hq-widgets-for-elementor'),
            'condition' => [
                'post_type!' => [
                    'by_id',
                ],
            ],
        ]);

        // Include By
        $this->add_control(
                'include', [
            'label' => __('Include By', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT2,
            'multiple' => true,
            'options' => [
                'terms' => __('Term', 'hq-widgets-for-elementor'),
                'authors' => __('Author', 'hq-widgets-for-elementor'),
            ],
            'condition' => [
                'post_type!' => [
                    'by_id',
                ],
            ],
            'label_block' => true,
                ]
        );

        $this->end_controls_tab();

        // Tab Exclude
        $this->start_controls_tab('query_exclude', [
            'label' => __('Exclude', 'hq-widgets-for-elementor'),
            'condition' => [
                'post_type!' => [
                    'by_id',
                ],
            ],
        ]);

        // Exclude By
        $this->add_control(
                'exclude', [
            'label' => __('Exclude By', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT2,
            'multiple' => true,
            'options' => [
                'terms' => __('Term', 'hq-widgets-for-elementor'),
                'authors' => __('Author', 'hq-widgets-for-elementor'),
            ],
            'condition' => [
                'post_type!' => [
                    'by_id',
                ],
            ],
            'label_block' => true,
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
    }

    protected function calculate_date_args($settings) {
        $select_date = $settings['select_date'];
        if (!empty($select_date)) {
            $date_query = [];
            switch ($select_date) {
                case 'today':
                    $date_query['after'] = '-1 day';
                    break;
                case 'week':
                    $date_query['after'] = '-1 week';
                    break;
                case 'month':
                    $date_query['after'] = '-1 month';
                    break;
                case 'quarter':
                    $date_query['after'] = '-3 month';
                    break;
                case 'year':
                    $date_query['after'] = '-1 year';
                    break;
                case 'exact':
                    $after_date = $settings['date_after'];
                    if (!empty($after_date)) {
                        $date_query['after'] = $after_date;
                    }
                    $before_date = $settings['date_before'];
                    if (!empty($before_date)) {
                        $date_query['before'] = $before_date;
                    }
                    $date_query['inclusive'] = true;
                    break;
            }

            return $date_query;
        }
    }

    /**
     * Render pagination for grids.
     * It is important to wp_reset_query if you do are not in main query
     * @global type $wp_rewrite
     * @param type $settings
     * @return type
     */
    protected function render_pagination($settings) {

        $page_limit = $this->query_posts($settings)->max_num_pages;

        if ('' !== $settings['pagination_page_limit']) {
            $page_limit = min($settings['pagination_page_limit'], $page_limit);
        }
        if (2 > $page_limit) {
            return;
        }

        $has_numbers = in_array($settings['pagination_type'], ['numbers', 'numbers_and_prev_next']);
        $has_prev_next = in_array($settings['pagination_type'], ['prev_next', 'numbers_and_prev_next']);

        $links = [];

        // Numbers
        if ($has_numbers) {
            $paginate_args = [
                'type' => 'array',
                'current' => $this->get_paged(),
                'total' => $page_limit,
                'prev_next' => false,
                'show_all' => 'yes' !== $settings['pagination_numbers_shorten'],
                'before_page_number' => '<span class="elementor-screen-only">' . __('Page', 'hq-widgets-for-elementor') . '</span>',
            ];

            if (is_singular() && !is_front_page()) {
                global $wp_rewrite;
                if ($wp_rewrite->using_permalinks()) {
                    $paginate_args['base'] = trailingslashit(get_permalink()) . '%_%';
                    $paginate_args['format'] = user_trailingslashit('%#%', 'single_paged');
                } else {
                    $paginate_args['format'] = '?page=%#%';
                }
            }

            $links = paginate_links($paginate_args);
        }

        // Prev / Next
        if ($has_prev_next || $settings['pagination_type'] == 'infinite_scroll') {
            $prev_next = $this->get_posts_nav_link($page_limit);
            array_unshift($links, $prev_next['prev']);
            $links[] = $prev_next['next'];
        }

        $this->add_render_attribute('pagination', 'class', ['hqt-pagination', $settings['pagination_type']]);
        $this->add_render_attribute('pagination', 'role', 'navigation');
        $this->add_render_attribute('pagination', 'aria-label', esc_attr__('Pagination', 'hq-widgets-for-elementor'));
        ?>

        <nav <?php echo $this->get_render_attribute_string('pagination'); ?>>
            <?php echo implode('', $links); ?>
        </nav>

        <?php
        if ('infinite_scroll' == $settings['pagination_type']) {
            ?>
            <div class="hqt-load-more-wrapper">
                <?php
                if ('yes' == $settings['infinite_status_messages']) :
                    $this->add_render_attribute('load_more_status', 'class', 'hqt-load-more-status');
                    if (!Plugin::instance()->editor->is_edit_mode()) {
                        $this->add_render_attribute('load_more_status', 'class', 'hide');
                    }
                    ?>
                    <div <?php echo $this->get_render_attribute_string('load_more_status'); ?>>
                        <div class="infinite-scroll-request">
                            <?php if ('yes' == $settings['infinite_loader']) : ?>
                                <div class="hqt-loader-wrapper">
                                    <div class="hqt-loader">
                                        <div></div><div></div><div></div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if (esc_html__($settings['infinite_scroll_msg_request'])) : ?>
                                <div class="hqt-load-more-text"><?php esc_html_e($settings['infinite_scroll_msg_request']); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="hqt-load-more-text infinite-scroll-last"><?php esc_html_e($settings['infinite_scroll_msg_last']); ?></div>
                        <div class="hqt-load-more-text infinite-scroll-error"><?php esc_html_e($settings['infinite_scroll_msg_error']); ?></div>
                    </div>
                    <?php
                endif;
                if ('yes' == $settings['load_more_btn'] && $this->get_paged() < $this->query_posts($settings)->max_num_pages) :
                    $this->add_render_attribute('infinite_button', 'class', ['archive-load-more', 'elementor-button']);
                    if (!empty($settings['infinite_button_hover_animation'])) {
                        $this->add_render_attribute('infinite_button', 'class', 'elementor-animation-' . $settings['infinite_button_hover_animation']);
                    }
                    ?>
                    <div class="hqt-load-more-btn">
                        <button <?php echo $this->get_render_attribute_string('infinite_button'); ?>><?php esc_html_e($settings['load_more_label']); ?></button>
                    </div>
                <?php endif; ?>
            </div>
            <?php
        }
    }

    public function render_no_results() {
        echo '<div class="elementor-nothing-found elementor-products-nothing-found">' . esc_html($this->get_settings('nothing_found_message')) . '</div>';
    }

    /**
     * Get current page
     * @return int
     */
    protected function get_paged() {
        return max(1, get_query_var('paged'), get_query_var('page'));
    }

    protected function get_posts_nav_link($page_limit = null) {

        $settings = $this->get_settings();

        if (!$page_limit) {
            $page_limit = $this->query->max_num_pages;
        }

        $return = [];

        $paged = $this->get_paged();

        $link_template = '<a class="page-numbers %s" href="%s">%s%s</a>';
        $disabled_template = '<span class="page-numbers %s">%s%s</span>';
        if (empty($settings['pagination_prev_icon']['value'])) {
            $prev_icon = '';
        } else {
            ob_start();
            Icons_Manager::render_icon($this->get_settings('pagination_prev_icon'));
            $prev_icon = ob_get_clean();
        }
        if (empty($settings['pagination_next_icon']['value'])) {
            $next_icon = '';
        } else {
            ob_start();
            Icons_Manager::render_icon($this->get_settings('pagination_next_icon'));
            $next_icon = ob_get_clean();
        }

        if ($paged > 1) {
            $next_page = intval($paged) - 1;
            if ($next_page < 1) {
                $next_page = 1;
            }
            $return['prev'] = sprintf($link_template, 'prev', $this->get_wp_link_page($next_page), $prev_icon, $this->get_settings('pagination_prev_label'));
        } else {
            $return['prev'] = sprintf($disabled_template, 'prev', $prev_icon, $this->get_settings('pagination_prev_label'));
        }

        $next_page = intval($paged) + 1;

        if ($next_page <= $page_limit) {
            $return['next'] = sprintf($link_template, 'next', $this->get_wp_link_page($next_page), $this->get_settings('pagination_next_label'), $next_icon);
        } else {
            $return['next'] = sprintf($disabled_template, 'next', $this->get_settings('pagination_next_label'), $next_icon);
        }

        return $return;
    }

    private function get_wp_link_page($i) {
        if (!is_singular() || is_front_page()) {
            return get_pagenum_link($i);
        }

        global $wp_rewrite;
        $post = get_post();
        $query_args = [];
        $url = get_permalink();

        if ($i > 1) {
            if ('' === get_option('permalink_structure') || in_array($post->post_status, ['draft', 'pending'])) {
                $url = add_query_arg('page', $i, $url);
            } elseif (get_option('show_on_front') === 'page' && (int) get_option('page_on_front') === $post->ID) {
                $url = trailingslashit($url) . user_trailingslashit("$wp_rewrite->pagination_base/" . $i, 'single_paged');
            } else {
                $url = trailingslashit($url) . user_trailingslashit($i, 'single_paged');
            }
        }

        if (is_preview()) {
            if (( 'draft' !== $post->post_status ) && isset($_GET['preview_id'], $_GET['preview_nonce'])) {
                $query_args['preview_id'] = wp_unslash($_GET['preview_id']);
                $query_args['preview_nonce'] = wp_unslash($_GET['preview_nonce']);
            }

            $url = get_preview_post_link($post, $query_args, $url);
        }

        return $url;
    }

}
