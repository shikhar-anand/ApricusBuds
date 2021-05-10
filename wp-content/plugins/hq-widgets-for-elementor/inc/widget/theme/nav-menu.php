<?php

namespace HQWidgetsForElementor\Widget\Theme;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Widget_Base;
use HQLib\Utils;
use const HQWidgetsForElementor\ELEMENTOR_BASE_UPLOADS;
use const HQWidgetsForElementor\PLUGIN_SLUG;
use const HQWidgetsForElementor\PLUGIN_URL;
use const HQWidgetsForElementor\VERSION;

class Nav_Menu extends Widget_Base {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        wp_register_style('jquery-hc-offcanvas-nav', PLUGIN_URL . 'assets/css/jquery.hc-offcanvas-nav.min.css', [], '5.0.10');
        wp_register_script('jquery-hc-offcanvas-nav', PLUGIN_URL . 'assets/js/jquery.hc-offcanvas-nav.js', [], '5.0.10', true);

        wp_register_style('hq-theme-nav-menu', ELEMENTOR_BASE_UPLOADS . 'css/hq-theme-nav-menu.css', ['elementor-icons-fa-solid'], VERSION);
        wp_register_script('hq-theme-nav-menu', PLUGIN_URL . 'assets/widgets/theme/nav-menu/script.js', ['elementor-frontend'], VERSION, true);
    }

    public function get_name() {
        return 'hq-theme-nav-menu';
    }

    public function get_title() {
        return __('Navigation Menu', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-navigation-menu';
    }

    public function get_script_depends() {
        return ['jquery-hc-offcanvas-nav', 'hq-theme-nav-menu'];
    }

    public function get_style_depends() {
        return ['jquery-hc-offcanvas-nav', 'hq-theme-nav-menu'];
    }

    public function get_categories() {
        return [PLUGIN_SLUG];
    }

    public function get_keywords() {
        return ['navigation', 'menu', 'navbar'];
    }

    protected function _register_controls() {
        $this->start_controls_section('section_menu_content', [
            'label' => __('Settings', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('nav_menu', [
            'label' => __('Select Menu', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'frontend_available' => true,
            'render_type' => 'template',
            'default' => '',
            'options' => Utils::get_nav_menus(),
            'description' => Utils::get_menu_howto(),
        ]);

        $this->add_control(
                'layout', [
            'label' => __('Layout', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HIDDEN,
            'prefix_class' => 'hq-navbar-layout-',
            'default' => 'row',
                ]
        );

        $this->add_responsive_control('alignment_justify', [
            'label' => __('Alignment Justify', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'selectors' => [
                '{{WRAPPER}} .hq-nav-menu-container > ul' => 'width: 100%; justify-content: space-between',
            ],
            'condition' => [
                'layout' => 'row',
            ]
        ]);

        $this->add_responsive_control('alignment', [
            'label' => esc_html__('Alignment', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'flex-start' => [
                    'title' => esc_html__('Left', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-left',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-center',
                ],
                'flex-end' => [
                    'title' => esc_html__('Right', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-right',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .hq-nav-menu-container' => 'justify-content: {{VALUE}};',
            ],
            'condition' => [
                'alignment_justify!' => 'yes'
            ],
        ]);

        $this->add_control('parent_indicator', [
            'label' => __('Parent Indicator', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'prefix_class' => 'hq-navbar-parent-indicator-',
            'label_on' => __('Show', 'hq-widgets-for-elementor'),
            'label_off' => __('Hide', 'hq-widgets-for-elementor'),
            'default' => 'yes',
            'return_value' => 'yes',
            'separator' => 'before',
        ]);

        $this->add_responsive_control('parent_indicator_offset', [
            'label' => esc_html__('Parent Indicator Offset', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'max' => 20,
                ],
            ],
            'size_units' => ['px'],
            'selectors' => [
                '{{WRAPPER}}.hq-navbar-parent-indicator-yes:not(.hq-navbar-column-row-reverse) .hq-nav-menu-container > ul > li.menu-item-has-children a:after' => 'margin-left: {{SIZE}}{{UNIT}}',
                '{{WRAPPER}}.hq-navbar-parent-indicator-yes.hq-navbar-column-row-reverse .hq-nav-menu-container > ul > li.menu-item-has-children a:after' => 'margin-right: {{SIZE}}{{UNIT}}',
            ],
            'condition' => [
                'parent_indicator' => 'yes'
            ]
        ]);

        $this->add_control('heading_mobile_menu_settings', [
            'label' => __('Mobile Menu Settings', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);

        $this->add_control('toggle_menu', [
            'label' => __('Toggle menu for smaller devices', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'frontend_available' => true,
            'default' => 'yes',
        ]);

        $this->add_control('breakpoint', [
            'label' => __('Breakpoint', 'hq-widgets-for-elementor'),
            'description' => __('Max width for Mobile menu', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'frontend_available' => true,
            'default' => (int) filter_var(\Elementor\Core\Responsive\Responsive::get_editable_breakpoints()['md'], FILTER_SANITIZE_NUMBER_INT),
            'condition' => [
                'toggle_menu' => 'yes',
            ],
        ]);

        $this->add_responsive_control('toggle_icon_alignment', [
            'label' => esc_html__('Toggle Icon Alignment', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'prefix_class' => 'hq-navbar%s__toggle-icon-',
            'options' => [
                'left' => [
                    'title' => esc_html__('Left', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-left',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-center',
                ],
                'right' => [
                    'title' => esc_html__('Right', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-right',
                ],
            ],
        ]);

        $this->add_control('sidebar_position', [
            'label' => __('Sidebar Position', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'label_block' => false,
            'frontend_available' => true,
            'options' => [
                'left' => [
                    'title' => __('Left', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-left',
                ],
                'right' => [
                    'title' => __('Right', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-right',
                ],
            ],
            'default' => 'left',
            'toggle' => false,
            'condition' => [
                'toggle_menu' => 'yes',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('menu_dropdown_content', [
            'label' => esc_html__('Dropdown', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('menu_dropdown_align', [
            'label' => esc_html__('Alignment', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'prefix_class' => 'hq-navbar-dropdown-mobile-',
            'options' => [
                'left' => [
                    'title' => esc_html__('Left', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-left',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-center',
                ],
                'right' => [
                    'title' => esc_html__('Right', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-right',
                ],
            ],
            'condition' => [
                'layout' => 'row'
            ]
        ]);

        $this->add_control('menu_last_dropdown_align', [
            'label' => esc_html__('Last Alignment', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'prefix_class' => 'hq-navbar-last-dropdown-mobile-',
            'options' => [
                'left' => [
                    'title' => esc_html__('Left', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-left',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-center',
                ],
                'right' => [
                    'title' => esc_html__('Right', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-right',
                ],
            ],
            'default' => 'right',
            'condition' => [
                'layout' => 'row'
            ]
        ]);

        $this->add_responsive_control('menu_dropdown_item_align', [
            'label' => esc_html__('Item Alignment', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => esc_html__('Left', 'hq-widgets-for-elementor'),
                    'icon' => 'fas fa-align-left',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'hq-widgets-for-elementor'),
                    'icon' => 'fas fa-align-center',
                ],
                'right' => [
                    'title' => esc_html__('Right', 'hq-widgets-for-elementor'),
                    'icon' => 'fas fa-align-right',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .hq-nav-menu-container .sub-menu li' => 'text-align: {{VALUE}};',
            ],
        ]);

        $this->add_responsive_control('menu_dropdown_width', [
            'label' => esc_html__('Dropdown Width', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 150,
                    'max' => 350,
                ],
            ],
            'size_units' => ['px'],
            'selectors' => [
                '{{WRAPPER}} .hq-nav-menu-container > ul > li > .sub-menu' => 'width: {{SIZE}}{{UNIT}};max-width: {{SIZE}}{{UNIT}}',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('nav_menu_style', [
            'label' => __('Navigation Menu', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->start_controls_tabs('menu_items_styles');

        $this->start_controls_tab('menu_item_normal', [
            'label' => esc_html__('Normal', 'hq-widgets-for-elementor')
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'menu_typography_normal',
            'label' => esc_html__('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hq-nav-menu-container > ul > li > a',
        ]);

        $this->add_control('menu_item_color', [
            'label' => esc_html__('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-nav-menu-container > ul > li > a' => 'color: {{VALUE}}',
            ],
        ]);

        $this->add_control('menu_item_background', [
            'label' => esc_html__('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-nav-menu-container > ul > li > a' => 'background-color: {{VALUE}}',
            ],
        ]);

        $this->add_responsive_control('menu_item_spacing', [
            'label' => esc_html__('Gap', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'size_units' => ['px'],
            'selectors' => [
                '{{WRAPPER}}.hq-navbar-layout-row .hq-nav-menu-container > ul > li:not(:last-of-type)' => 'margin-right: {{SIZE}}{{UNIT}}',
                '{{WRAPPER}}.hq-navbar-layout-column .hq-nav-menu-container > ul > li:not(:last-of-type)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'menu_item_border',
            'label' => esc_html__('Border', 'hq-widgets-for-elementor'),
            'default' => '1px',
            'selector' => '{{WRAPPER}} .hq-nav-menu-container > ul > li > a',
        ]);

        $this->add_responsive_control('menu_item_border_radius', [
            'label' => esc_html__('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .hq-nav-menu-container > ul > li > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
            ],
        ]);

        $this->add_responsive_control('menu_item_padding', [
            'label' => esc_html__('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .hq-nav-menu-container > ul > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
            ],
        ]);

        $this->add_control('menu_parent_arrow_color', [
            'label' => esc_html__('Parent Indicator Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.hq-navbar-parent-indicator-yes .hq-nav-menu-container > ul > li.menu-item-has-children > a:after' => 'border-color: {{VALUE}}',
            ],
            'condition' => ['parent_indicator' => 'yes']
        ]);

        $this->add_responsive_control('menu_parent_arrow_size', [
            'label' => esc_html__('Parent Indicator Size', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'max' => 30,
                ],
            ],
            'size_units' => ['px'],
            'selectors' => [
                '{{WRAPPER}}.hq-navbar-parent-indicator-yes .hq-nav-menu-container > ul > li.menu-item-has-children a:after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; top: calc(-{{SIZE}}{{UNIT}}/3)',
            ],
            'condition' => ['parent_indicator' => 'yes']
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('menu_item_hover', [
            'label' => esc_html__('Hover', 'hq-widgets-for-elementor')
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'menu_item_typography_hover',
            'label' => esc_html__('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hq-nav-menu-container > ul > li > a:hover, {{WRAPPER}} .hq-nav-menu-container > ul > li.focus > a',
        ]);


        $this->add_control('menu_item_color_hover', [
            'label' => esc_html__('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-nav-menu-container > ul > li > a:hover, {{WRAPPER}} .hq-nav-menu-container > ul > li.focus > a' => 'color: {{VALUE}}',
            ],
        ]);

        $this->add_control('menu_item_background_hover', [
            'label' => esc_html__('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-nav-menu-container > ul > li > a:hover, {{WRAPPER}} .hq-nav-menu-container > ul > li.focus > a' => 'background-color: {{VALUE}}',
            ],
        ]);

        $this->add_control('menu_item_border_color_hover', [
            'label' => esc_html__('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-nav-menu-container > ul > li > a:hover, {{WRAPPER}} .hq-nav-menu-container > ul > li.focus > a' => 'border-color: {{VALUE}}',
            ],
        ]);

        $this->add_control('menu_item_border_radius_hover', [
            'label' => esc_html__('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .hq-nav-menu-container > ul > li > a:hover, {{WRAPPER}} .hq-nav-menu-container > ul > li.focus > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
            ],
        ]);

        $this->add_control('menu_parent_arrow_color_hover', [
            'label' => esc_html__('Parent Indicator Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.hq-navbar-parent-indicator-yes .hq-nav-menu-container > ul > li.menu-item-has-children a:hover::after' => 'border-color: {{VALUE}}',
            ],
            'condition' => ['parent_indicator' => 'yes'],
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('menu_item_active', [
            'label' => esc_html__('Active', 'hq-widgets-for-elementor')
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'menu_item_typography_active',
            'label' => esc_html__('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hq-nav-menu-container > ul > li.current-menu-item > a,'
            . '{{WRAPPER}} .hq-nav-menu-container > ul > li.current_page_parent > a,'
            . '{{WRAPPER}} .hq-nav-menu-container > ul > li.current-menu-ancestor > a',
        ]);

        $this->add_control('menu_item_color_active', [
            'label' => esc_html__('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-nav-menu-container > ul > li.current-menu-item > a,'
                . '{{WRAPPER}} .hq-nav-menu-container > ul > li.current_page_parent > a,'
                . '{{WRAPPER}} .hq-nav-menu-container > ul > li.current-menu-ancestor > a' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('menu_item_background_color_active', [
            'label' => esc_html__('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-nav-menu-container > ul > li.current-menu-item > a,'
                . '{{WRAPPER}} .hq-nav-menu-container > ul > li.current_page_parent > a,'
                . '{{WRAPPER}} .hq-nav-menu-container > ul > li.current-menu-ancestor > a' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'menu_border_active',
            'label' => esc_html__('Border', 'hq-widgets-for-elementor'),
            'default' => '1px',
            'selector' => '{{WRAPPER}} .hq-nav-menu-container > ul > li.current-menu-item > a,'
            . '{{WRAPPER}} .hq-nav-menu-container > ul > li.current_page_parent > a,'
            . '{{WRAPPER}} .hq-nav-menu-container > ul > li.current-menu-ancestor > a',
        ]);

        $this->add_control('menu_item_border_radius_active', [
            'label' => esc_html__('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .hq-nav-menu-container > ul > li.current-menu-item > a,'
                . '{{WRAPPER}} .hq-nav-menu-container > ul > li.current_page_parent > a,'
                . '{{WRAPPER}} .hq-nav-menu-container > ul > li.current-menu-ancestor > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
            ],
        ]);

        $this->add_control('menu_parent_arrow_color_active', [
            'label' => esc_html__('Parent Indicator Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.hq-navbar-parent-indicator-yes .hq-nav-menu-container > ul > li.current-menu-item > a:after,'
                . '{{WRAPPER}}.hq-navbar-parent-indicator-yes .hq-nav-menu-container > ul > li.current_page_parent > a:after,'
                . '{{WRAPPER}}.hq-navbar-parent-indicator-yes .hq-nav-menu-container > ul > li.current-menu-ancestor > a:after' => 'border-color: {{VALUE}}',
            ],
            'condition' => ['parent_indicator' => 'yes'],
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section('dropdown_menu', [
            'label' => esc_html__('Dropdown', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('dropdown_background', [
            'label' => esc_html__('Dropdown Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-nav-menu-container > ul > li > .sub-menu' => 'background-color: {{VALUE}}',
            ],
        ]);

        $this->add_control(
                'heading_dropdown_items', [
            'label' => __('Dropdown Items', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->start_controls_tabs('dropdown_items_styles');

        $this->start_controls_tab('dropdown_item_normal', [
            'label' => esc_html__('Normal', 'hq-widgets-for-elementor')
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'dropdown_item_typography',
            'label' => esc_html__('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hq-nav-menu-container .sub-menu li a',
        ]);

        $this->add_control('dropdown_item_color', [
            'label' => esc_html__('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-nav-menu-container .sub-menu li a' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dropdown_item_padding', [
            'label' => esc_html__('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .hq-nav-menu-container .sub-menu li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'dropdown_item_border',
            'label' => esc_html__('Border', 'hq-widgets-for-elementor'),
            'default' => '1px',
            'selector' => '{{WRAPPER}} .hq-nav-menu-container .sub-menu li a',
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('dropdown_item_hover', [
            'label' => esc_html__('Hover', 'hq-widgets-for-elementor')]
        );

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'dropdown_item_typography_hover',
            'label' => esc_html__('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hq-nav-menu-container .sub-menu li a:hover, {{WRAPPER}} .hq-nav-menu-container .sub-menu li.focus a',
        ]);

        $this->add_control('dropdown_item_hover_color', [
            'label' => esc_html__('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-nav-menu-container .sub-menu li a:hover, {{WRAPPER}} .hq-nav-menu-container .sub-menu li.focus a' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('dropdown_item_border_hover_color', [
            'label' => esc_html__('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-nav-menu-container .sub-menu li a:hover, {{WRAPPER}} .hq-nav-menu-container .sub-menu li.focus a' => 'border-color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('dropdown_item_active', [
            'label' => esc_html__('Active', 'hq-widgets-for-elementor')
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'dropdown_item_typography_active',
            'label' => esc_html__('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hq-nav-menu-container .sub-menu li.current-menu-item a',
        ]);

        $this->add_control('dropdown_item_active_color', [
            'label' => esc_html__('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-nav-menu-container .sub-menu li.current-menu-item a' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'dropdown_item_active_border',
            'label' => esc_html__('Border', 'hq-widgets-for-elementor'),
            'default' => '1px',
            'selector' => '{{WRAPPER}} .hq-nav-menu-container .sub-menu li.current-menu-item a',
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section('toggle_icon_styles', [
            'label' => esc_html__('Toggle Icon', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'toggle_menu' => 'yes'
            ]
        ]);

        $this->add_control('toggle_icon_color', [
            'label' => esc_html__('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hc-nav-trigger i' => 'color: {{VALUE}}',
                '{{WRAPPER}} .hc-nav-trigger span, {{WRAPPER}} .hc-nav-trigger span::before, {{WRAPPER}} .hc-nav-trigger span::after' => 'background: {{VALUE}}',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('offcanvas_menu', [
            'label' => esc_html__('Offcanvas', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'toggle_menu' => 'yes'
            ]
        ]);

        $this->add_control(
                'heading_offcanvas_menu', [
            'label' => __('Sidebar', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
                ]
        );

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'offcanvas_box_shadow',
            'selector' => '{{WRAPPER}} .hc-offcanvas-nav.nav-position-top.nav-open .nav-wrapper,'
            . '{{WRAPPER}} .hc-offcanvas-nav.nav-position-left.nav-open .nav-wrapper,'
            . '{{WRAPPER}} .hc-offcanvas-nav.nav-position-right.nav-open .nav-wrapper,'
            . '{{WRAPPER}} .hc-offcanvas-nav.nav-position-bottom.nav-open .nav-wrapper',
        ]);

        $this->add_control('offcanvas_background', [
            'label' => esc_html__('Main Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hc-offcanvas-nav .nav-container > .nav-wrapper' => 'background-color: {{VALUE}}',
            ],
        ]);

        $this->add_control('offcanvas_submenu_background', [
            'label' => esc_html__('Submenu Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hc-offcanvas-nav .nav-container .menu-item .nav-wrapper' => 'background-color: {{VALUE}}',
            ],
        ]);

        $this->add_control('offcanvas_overlay', [
            'label' => esc_html__('Overlay Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hc-offcanvas-nav:after' => 'background-color: {{VALUE}}',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('offcanvas_menu_items', [
            'label' => esc_html__('Offcanvas Menu Items', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'toggle_menu' => 'yes'
            ]
        ]);

        $this->start_controls_tabs('offcanvas_items_styles');

        $this->start_controls_tab('offcanvas_item_normal', [
            'label' => esc_html__('Normal', 'hq-widgets-for-elementor')
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'offcanvas_item_typography',
            'label' => esc_html__('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hc-offcanvas-nav li.menu-item:not(.custom-content) > .nav-item-wrapper > a',
        ]);

        $this->add_control('offcanvas_item_color', [
            'label' => esc_html__('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hc-offcanvas-nav li.menu-item:not(.custom-content) > .nav-item-wrapper > a' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('offcanvas_item_background', [
            'label' => esc_html__('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hc-offcanvas-nav li.menu-item:not(.custom-content) > .nav-item-wrapper > a' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('offcanvas_item_padding', [
            'label' => esc_html__('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .hc-offcanvas-nav li.menu-item:not(.custom-content) > .nav-item-wrapper > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'offcanvas_item_border',
            'label' => esc_html__('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hc-offcanvas-nav li.menu-item:not(.custom-content) > .nav-item-wrapper > a',
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('offcanvas_item_hover', [
            'label' => esc_html__('Hover', 'hq-widgets-for-elementor')]
        );

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'offcanvas_item_typography_hover',
            'label' => esc_html__('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hc-offcanvas-nav li.menu-item:not(.custom-content) > .nav-item-wrapper > a:hover',
        ]);

        $this->add_control('offcanvas_item_hover_color', [
            'label' => esc_html__('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hc-offcanvas-nav li.menu-item:not(.custom-content) > .nav-item-wrapper > a:hover' => 'color: {{VALUE}};',
            ],
        ]);


        $this->add_control('offcanvas_item_background_hover_color', [
            'label' => esc_html__('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hc-offcanvas-nav li.menu-item:not(.custom-content) > .nav-item-wrapper > a:hover' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('offcanvas_item_border_hover_color', [
            'label' => esc_html__('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hc-offcanvas-nav li.menu-item:not(.custom-content) > .nav-item-wrapper > a:hover' => 'border-color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('offcanvas_item_active', [
            'label' => esc_html__('Active', 'hq-widgets-for-elementor')
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'offcanvas_item_typography_active',
            'label' => esc_html__('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hc-offcanvas-nav li.menu-item.current-menu-item:not(.custom-content) > .nav-item-wrapper > a,
                {{WRAPPER}} .hc-offcanvas-nav li.menu-item.current_page_parent:not(.custom-content) > .nav-item-wrapper > a,
                {{WRAPPER}} .hc-offcanvas-nav li.menu-item.current-menu-ancestor:not(.custom-content) > .nav-item-wrapper > a',
        ]);

        $this->add_control('offcanvas_item_text_color_active', [
            'label' => esc_html__('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hc-offcanvas-nav li.menu-item.current-menu-item:not(.custom-content) > .nav-item-wrapper > a,
                {{WRAPPER}} .hc-offcanvas-nav li.menu-item.current_page_parent:not(.custom-content) > .nav-item-wrapper > a,
                {{WRAPPER}} .hc-offcanvas-nav li.menu-item.current-menu-ancestor:not(.custom-content) > .nav-item-wrapper > a' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('offcanvas_item_background_color_active', [
            'label' => esc_html__('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hc-offcanvas-nav li.menu-item.current-menu-item:not(.custom-content) > .nav-item-wrapper > a,
                {{WRAPPER}} .hc-offcanvas-nav li.menu-item.current_page_parent:not(.custom-content) > .nav-item-wrapper > a,
                {{WRAPPER}} .hc-offcanvas-nav li.menu-item.current-menu-ancestor:not(.custom-content) > .nav-item-wrapper > a' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'offcanvas_item_border_active',
            'label' => esc_html__('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hc-offcanvas-nav li.menu-item.current-menu-item:not(.custom-content) > .nav-item-wrapper > a,
                {{WRAPPER}} .hc-offcanvas-nav li.menu-item.current_page_parent:not(.custom-content) > .nav-item-wrapper > a,
                {{WRAPPER}} .hc-offcanvas-nav li.menu-item.current-menu-ancestor:not(.custom-content) > .nav-item-wrapper > a',
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control('heading_offcanvas_sub_items', [
            'label' => __('Sub Menu Items', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);

        $this->start_controls_tabs('offcanvas_sub_items_styles');

        $this->start_controls_tab('offcanvas_sub_item_normal', [
            'label' => esc_html__('Normal', 'hq-widgets-for-elementor')
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'offcanvas_sub_item_typography',
            'label' => esc_html__('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hc-offcanvas-nav .sub-menu li.menu-item:not(.custom-content) > .nav-item-wrapper > a',
        ]);

        $this->add_control('offcanvas_sub_item_color', [
            'label' => esc_html__('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hc-offcanvas-nav .sub-menu li.menu-item:not(.custom-content) > .nav-item-wrapper > a' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('offcanvas_sub_item_background', [
            'label' => esc_html__('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hc-offcanvas-nav .sub-menu li.menu-item:not(.custom-content) > .nav-item-wrapper > a' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('offcanvas_sub_item_padding', [
            'label' => esc_html__('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .hc-offcanvas-nav .sub-menu li.menu-item:not(.custom-content) > .nav-item-wrapper > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'offcanvas_sub_item_border',
            'label' => esc_html__('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hc-offcanvas-nav .sub-menu li.menu-item:not(.custom-content) > .nav-item-wrapper > a',
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('offcanvas_sub_item_hover', [
            'label' => esc_html__('Hover', 'hq-widgets-for-elementor')]
        );

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'offcanvas_sub_item_typography_hover',
            'label' => esc_html__('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hc-offcanvas-nav .sub-menu li.menu-item:not(.custom-content) > .nav-item-wrapper > a:hover',
        ]);

        $this->add_control('offcanvas_sub_item_hover_color', [
            'label' => esc_html__('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hc-offcanvas-nav .sub-menu li.menu-item:not(.custom-content) > .nav-item-wrapper > a:hover' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('offcanvas_sub_item_background_hover_color', [
            'label' => esc_html__('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hc-offcanvas-nav .sub-menu li.menu-item:not(.custom-content) > .nav-item-wrapper > a:hover' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('offcanvas_sub_item_border_hover_color', [
            'label' => esc_html__('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hc-offcanvas-nav .sub-menu li.menu-item:not(.custom-content) > .nav-item-wrapper > a:hover' => 'border-color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('menu_wrapper', 'class', ['hq-nav-menu-wrapper', 'hidden']);
        $this->add_render_attribute('menu_wrapper', 'data-menu-id', $this->get_id_int());
        $this->add_render_attribute('menu_toggle', 'class', ['hq-nav-menu-trigger']);
        $this->add_render_attribute('menu_toggle_icon', 'class', ['hc-nav-trigger-icon']);
        $this->add_render_attribute('menu_toggle_text', 'class', ['hc-nav-trigger-label']);

        if (!empty($settings['nav_menu']) && is_nav_menu($settings['nav_menu'])) {
            add_filter('wp_nav_menu_objects', [$this, 'nav_menu_objects']);
            add_filter('wp_nav_menu_items', [$this, 'custom_menu_item'], 10, 2);
            ?>
            <div <?php echo $this->get_render_attribute_string('menu_wrapper'); ?>>
                <?php
                $args = [
                    'menu' => $settings['nav_menu'],
                    'container_class' => 'hq-nav-menu-container',
                    'menu_class' => 'hc-offcanvas',
                ];
                wp_nav_menu($this->nav_menu_args($args));
                ?>
            </div>
            <?php
            remove_filter('wp_nav_menu_objects', [$this, 'nav_menu_objects']);
            remove_filter('wp_nav_menu_items', [$this, 'custom_menu_item']);

            $toggleIcon = '<span></span>';
            $toggleText = false;
            $toggleTextPosition = null;

            if (isset($settings['toggle_icon']) && !empty($settings['toggle_icon']['value'])) {
                ob_start();
                Icons_Manager::render_icon($this->get_settings('toggle_icon'), ['aria-hidden' => 'true']);
                $toggleIcon = ob_get_clean();
            }
            $toggleIcon = '<div ' . $this->get_render_attribute_string('menu_toggle_icon') . '>' . $toggleIcon . '</div>';

            if (isset($settings['toggle_text']) && !empty($settings['toggle_text'])) {
                $toggleTextPosition = $settings['toggle_text_position'];
                $this->add_render_attribute('menu_toggle_text', 'data-position', $toggleTextPosition);
                ob_start();
                ?>
                <div <?php echo $this->get_render_attribute_string('menu_toggle_text'); ?>><?php echo esc_html($settings['toggle_text']); ?></div>
                <?php
                $toggleText = ob_get_clean();
            }

            if (!empty($toggleText)) {
                if ('append' == $toggleTextPosition) {
                    $toggleIcon .= $toggleText;
                } elseif ('prepend' == $toggleTextPosition) {
                    $toggleIcon = $toggleText . $toggleIcon;
                }
            }
            ?>
            <a <?php echo $this->get_render_attribute_string('menu_toggle'); ?>><?php echo $toggleIcon ?></a>
            <?php
        } else {
            esc_html_e('No menu selected.', 'hq-widgets-for-elementor');
        }
    }

    /*
     * Adds menu data support for HC Off-canvas Nav
     */

    private function nav_menu_args($args) {
        global $hc_nav_menu_walker;

        if (!empty($args['walker'])) {
            $hc_nav_menu_walker = $args['walker'];
        } else {
            $hc_nav_menu_walker = new \Walker_Nav_Menu();
        }

        $args['walker'] = new \HQWidgetsForElementor\Classes\HC_Walker_Nav_Menu();

        return $args;
    }

    public function nav_menu_objects($menu_items) {
        //Add first item class
        $menu_items[1]->classes[] = 'first-menu-item';

        //Add last item class
        $i = count($menu_items);
        while ($menu_items[$i]->menu_item_parent != 0 && $i > 0) {
            $i--;
        }
        $menu_items[$i]->classes[] = 'last-menu-item';

        // Unset active class for blog page if current page has custom post type
        if (class_exists('\Marmot\Pods')) {
            $custom_post_types = \Marmot\Pods::get_custom_post_types();
            // Remove extended Post Type
            unset($custom_post_types[array_search('Post', $custom_post_types, true)]);

            if (count($custom_post_types)) {
                $current_post_type = get_post_type();
                $page_for_posts = (int) get_option('page_for_posts');
                if (!$current_post_type || !array_key_exists($current_post_type, $custom_post_types)) {
                    return $menu_items;
                }

                foreach ($menu_items as $key => $menu_item) {
                    $classes = (array) $menu_item->classes;
                    $menu_id = (int) $menu_item->object_id;
                    // Unset active class for blog page
                    if ($page_for_posts === $menu_id) {
                        $menu_items[$key]->current = false;

                        if (in_array('current_page_parent', $classes, true)) {
                            unset($classes[array_search('current_page_parent', $classes, true)]);
                        }

                        if (in_array('current-menu-item', $classes, true)) {
                            unset($classes[array_search('current-menu-item', $classes, true)]);
                        }
                    } elseif (is_singular($current_post_type) && 'post_type_archive' == $menu_item->type && $current_post_type == $menu_item->object) {
                        // Set parent state if this is a single page.
                        $classes[] = 'current_page_parent';
                    }
                    $menu_items[$key]->classes = array_unique($classes);
                }
            }
        }

        return $menu_items;
    }

    public function custom_menu_item($items, $args) {
        $settings = $this->get_settings_for_display();
        if (isset($settings['custom_menu_item_section']) && $settings['custom_menu_item_section'] != 'noeltmp') {
            $this->add_render_attribute('custom_menu_item', 'class', ['menu-item', 'menu-item-custom']);

            ob_start();
            Utils::load_elementor_template($settings['custom_menu_item_section']);
            $lastMenuItem = ob_get_clean();
            if ('start' == $settings['custom_menu_item_position']) {
                $items = '<li data-nav-custom-content ' . $this->get_render_attribute_string('custom_menu_item') . '>' . $lastMenuItem . '</li>' . $items;
            } else {
                $items .= '<li data-nav-custom-content ' . $this->get_render_attribute_string('custom_menu_item') . '>' . $lastMenuItem . '</li>';
            }
        }
        return $items;
    }

}
