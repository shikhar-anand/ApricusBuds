<?php

namespace HQWidgetsForElementor\Widget\Theme;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use const HQWidgetsForElementor\PLUGIN_SLUG;
use const HQWidgetsForElementor\PLUGIN_URL;
use const HQWidgetsForElementor\VERSION;
use HQLib\Utils;

class Post_Taxonomies extends Widget_Base {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);

        wp_register_style('hq-theme-post-taxonomies', PLUGIN_URL . 'assets/widgets/theme/post-taxonomies/style.css', [], VERSION);
    }

    public function get_name() {
        return 'hq-theme-post-taxonomies';
    }

    public function get_title() {
        return __('Post Taxonomies', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-price-tag';
    }

    public function get_style_depends() {
        return ['hq-theme-post-taxonomies'];
    }

    public function get_categories() {
        return [PLUGIN_SLUG];
    }

    public function get_keywords() {
        return ['category', 'categories', 'tags', 'taxonomies', 'taxonomy', 'post', 'metadata'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
                'section_content', [
            'label' => __('Content', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'taxonomy', [
            'label' => __('Taxonomy', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'category',
            'options' => Utils::get_taxonomies(['show_in_nav_menus' => true]),
                ]
        );

        $this->add_control('orderby', [
            'label' => __('Order By', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'name',
            'options' => [
                'id' => __('ID', 'hq-widgets-for-elementor'),
                'name' => __('Name', 'hq-widgets-for-elementor'),
            ],
                ]
        );

        $this->add_control('order', [
            'label' => __('Order', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'ASC',
            'options' => [
                'ASC' => __('ASC', 'hq-widgets-for-elementor'),
                'DESC' => __('DESC', 'hq-widgets-for-elementor'),
            ],
                ]
        );

        $this->add_control(
                'content_separator', [
            'type' => Controls_Manager::DIVIDER,
                ]
        );

        $this->add_control(
                'layout', [
            'label' => __('Layout', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'default' => 'block',
            'toggle' => false,
            'prefix_class' => 'taxonomy-list-',
            'options' => [
                'block' => [
                    'title' => __('Default', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-editor-list-ul',
                ],
                'inline' => [
                    'title' => __('Inline', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-ellipsis-h',
                ],
            ],
                ]
        );

        $this->add_responsive_control('alignment', [
            'label' => __('Alignment', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'flex-start' => [
                    'title' => __('Left', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-center',
                ],
                'flex-end' => [
                    'title' => __('Right', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-right',
                ],
            ],
            'default' => 'flex-start',
            'selectors' => [
                '{{WRAPPER}}.taxonomy-list-inline .hq-post-taxonomy-list' => 'justify-content: {{VALUE}}',
                '{{WRAPPER}}.taxonomy-list-block .hq-post-taxonomy-list' => 'align-items: {{VALUE}}',
            ],
            'toggle' => false,
        ]);

        $this->add_control(
                'hierarchical', [
            'label' => __('Hierarchical', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'condition' => [
                'taxonomy' => 'category'
            ]
                ]
        );

        $this->add_control(
                'hide_empty', [
            'label' => __('Hide Empty', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
                ]
        );

        $this->add_control(
                'show_count', [
            'label' => __('Count', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_off' => __('Hide', 'hq-widgets-for-elementor'),
            'label_on' => __('Show', 'hq-widgets-for-elementor'),
                ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
                'section_style_taxonomy_list', [
            'label' => __('Parent List Items', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'parent_item_typo',
            'label' => __('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hq-post-taxonomy-list > li, {{WRAPPER}} .hq-post-taxonomy-list > li > a',
                ]
        );

        $this->start_controls_tabs(
                'taxonomy_parent_tabs', [
                ]
        );

        $this->start_controls_tab(
                'tab_parent_item_normal', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'parent_item_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-post-taxonomy-list > li, {{WRAPPER}} .hq-post-taxonomy-list > li > a' => 'color: {{VALUE}}; border-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'parent_item_background', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-post-taxonomy-list > li' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'parent_item_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hq-post-taxonomy-list > li',
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_parent_item_hover', [
            'label' => __('Hover', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'parent_item_hover_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-post-taxonomy-list > li:hover, {{WRAPPER}} .hq-post-taxonomy-list > li:hover > a' => 'color: {{VALUE}}; border-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'parent_item_hover_background', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-post-taxonomy-list > li:hover' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'parent_item_hover_border_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-post-taxonomy-list > li:hover' => 'border-color: {{VALUE}}',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_parent_item_current', [
            'label' => __('Current', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'parent_item_current_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-post-taxonomy-list > li.current-cat, {{WRAPPER}} .hq-post-taxonomy-list > li.current-cat > a' => 'color: {{VALUE}}; border-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'parent_item_current_background', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-post-taxonomy-list > li.current-cat' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'parent_item_current_border_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-post-taxonomy-list > li.current-cat' => 'border-color: {{VALUE}}',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
                'parent_item_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .hq-post-taxonomy-list > li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before'
                ]
        );

        $this->add_responsive_control(
                'parent_item_margin', [
            'label' => __('Margin', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .hq-post-taxonomy-list > li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'parent_item_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .hq-post-taxonomy-list > li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_style_taxonomy_list_child', [
            'label' => __('Child List Items', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'hierarchical' => 'yes',
                'taxonomy' => 'category',
            ]
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'child_item_typo',
            'label' => __('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hq-post-taxonomy-list > li > ul > li, {{WRAPPER}} .hq-post-taxonomy-list > li > ul > li > a',
                ]
        );

        $this->start_controls_tabs(
                'taxonomy_child_tabs', [
                ]
        );

        $this->start_controls_tab(
                'tab_child_item_normal', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'child_item_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-post-taxonomy-list > li > ul > li, {{WRAPPER}} .hq-post-taxonomy-list > li > ul > li > a' => 'color: {{VALUE}}; border-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'child_item_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hq-post-taxonomy-list > li > ul > li',
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_child_item_hover', [
            'label' => __('Hover', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'child_item_hover_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-post-taxonomy-list > li > ul > li:hover, {{WRAPPER}} .hq-post-taxonomy-list > li > ul > li:hover > a' => 'color: {{VALUE}}; border-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'child_item_hover_border_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-post-taxonomy-list > li > ul > li:hover' => 'border-color: {{VALUE}}',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_child_item_current', [
            'label' => __('Current', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'child_item_current_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-post-taxonomy-list > li > ul > li.current-cat, {{WRAPPER}} .hq-post-taxonomy-list > li > ul > li.current-cat > a' => 'color: {{VALUE}}; border-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'child_item_current_border_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-post-taxonomy-list > li > ul > li.current-cat' => 'border-color: {{VALUE}}',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
                'child_item_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .hq-post-taxonomy-list > li > ul > li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before'
                ]
        );

        $this->add_responsive_control(
                'child_item_margin', [
            'label' => __('Margin', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .hq-post-taxonomy-list > li > ul > li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('main-list', 'class', ['hq-post-taxonomy-list', 'taxonomy-list-' . $settings['layout']]);

        $cat_args = array(
            'orderby' => $settings['orderby'],
            'order' => $settings['order'],
            'show_count' => (!empty($settings['show_count']) ? '1' : '0'),
            'hierarchical' => (!empty($settings['hierarchical']) ? '1' : '0'),
            'title_li' => '',
            'hide_empty' => (!empty($settings['hide_empty']) ? '1' : '0'),
            'taxonomy' => $settings['taxonomy'],
        );
        ?>
        <ul <?php echo $this->get_render_attribute_string('main-list'); ?>>
            <?php wp_list_categories($cat_args); ?>
        </ul>
        <?php
    }

}
