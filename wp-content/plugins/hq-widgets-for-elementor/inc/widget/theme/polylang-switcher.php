<?php

namespace HQWidgetsForElementor\Widget\Theme;

defined('ABSPATH') || exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use const HQWidgetsForElementor\ELEMENTOR_BASE_UPLOADS;
use const HQWidgetsForElementor\PLUGIN_SLUG;
use const HQWidgetsForElementor\VERSION;

class Polylang_Switcher extends Widget_Base {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        wp_register_style('hq-theme-polylang-switcher', ELEMENTOR_BASE_UPLOADS . 'css/hq-theme-polylang-switcher.css', [], VERSION);
    }

    public function get_name() {
        return 'hq-theme-polylang-switcher';
    }

    public function get_title() {
        return __('Polylang Switcher', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-translator';
    }

    public function get_style_depends() {
        return ['hq-theme-polylang-switcher'];
    }

    public function get_categories() {
        return [PLUGIN_SLUG];
    }

    public function get_keywords() {
        return ['languages', 'switcher', 'polylang', 'multilingual', 'flags', 'countries', 'country', 'wpml'];
    }

    protected function _register_controls() {
        if (!defined('POLYLANG_VERSION')) {
            $this->start_controls_section('section_plugin_missing', [
                'label' => __('Polylang', 'hq-widgets-for-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]);

            $this->add_control('plugin_alert', [
                'raw' => '<p>' . __('Polylang plugin is not installed.', 'hq-widgets-for-elementor') . '</p>' . sprintf('<a href="%s" target="_blank">%s</a>', esc_url(admin_url('plugin-install.php?s=polylang&tab=search&type=term')), __('Install Polylang.', 'hq-widgets-for-elementor')),
                'type' => Controls_Manager::RAW_HTML,
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
            ]);

            $this->end_controls_section();

            return;
        }

        $this->start_controls_section(
                'section_content',
                [
                    'label' => __('Content', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_responsive_control(
                'layout',
                [
                    'label' => __('Layout', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'horizontal',
                    'options' => [
                        'horizontal' => __('Horizontal', 'hq-widgets-for-elementor'),
                        'vertical' => __('Vertical', 'hq-widgets-for-elementor'),
                        'dropdown' => __('Dropdown', 'hq-widgets-for-elementor'),
                    ],
                    'label_block' => true,
                    'render_type' => 'template',
                    'prefix_class' => 'hq-polylang%s-layout-',
                ]
        );

        $this->add_responsive_control(
                'align_items',
                [
                    'label' => __('Align', 'hq-widgets-for-elementor'),
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
                        'justify' => [
                            'title' => __('Stretch', 'hq-widgets-for-elementor'),
                            'icon' => 'eicon-h-align-stretch',
                        ],
                    ],
                    'label_block' => true,
                    'prefix_class' => 'hq-polylang%s-align-',
                ]
        );

        $this->add_control('menu_dropdown_caret', [
            'label' => __('Caret', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'prefix_class' => 'hq-polylang-dropdown-caret-',
            'label_on' => __('Show', 'hq-widgets-for-elementor'),
            'label_off' => __('Hide', 'hq-widgets-for-elementor'),
            'default' => 'yes',
            'return_value' => 'yes',
            'condition' => [
                'layout' => 'dropdown'
            ]
        ]);

        $this->add_control(
                'hide_current',
                [
                    'label' => __('Hide the current language', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => '',
                    'separator' => 'before',
                ]
        );

        $this->add_control(
                'hide_missing',
                [
                    'label' => __('Hide languages with no translation', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => '',
                ]
        );

        $this->add_control(
                'show_country_flag',
                [
                    'label' => __('Show Country Flag', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
        );

        $this->add_control(
                'show_language_name',
                [
                    'label' => __('Show Language Name', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
        );

        $this->add_control(
                'show_language_code',
                [
                    'label' => __('Show Language Code', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => '',
                ]
        );

        // Create language drop-down for the select control
        $languages = pll_the_languages(array('raw' => 1));
        $dropdown = [];

        foreach ($languages as $language) {
            $dropdown[$language['slug']] = $language['name'];
        }

        $first_key['all'] = __('All languages', 'hq-widgets-for-elementor');

        $dropdown = array_merge($first_key, $dropdown);

        $this->add_control(
                'polylang_widget_display',
                [
                    'label' => __('Display widget for:', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'all',
                    'options' => $dropdown,
                ]
        );

        $this->end_controls_section();

        // Styles
        $this->start_controls_section('main_section', [
            'label' => __('Main Menu', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->start_controls_tabs('tabs_menu_item_style');

        $this->start_controls_tab('tab_menu_item_normal', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'lang_item_typography',
            'selector' => '{{WRAPPER}} .hq-polylang-menu > li > a',
        ]);

        $this->add_control('lang_item_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .hq-polylang-menu > li > a' => 'color: {{VALUE}}',
            ],
        ]);

        $this->add_control('lang_item_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .hq-polylang-menu > li > a' => 'background-color: {{VALUE}}',
            ],
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('tab_menu_item_hover', [
            'label' => __('Hover', 'hq-widgets-for-elementor'),
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'lang_item_hover_typography',
            'selector' => '{{WRAPPER}} .hq-polylang-menu > li > a:hover,
                        {{WRAPPER}} .hq-polylang-menu > li.menu-item__active > a:hover,
                        {{WRAPPER}} .hq-polylang-menu > li > a:focus',
        ]);

        $this->add_control('lang_item_text_hover_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-polylang-menu > li > a:hover,
                        {{WRAPPER}} .hq-polylang-menu > li.menu-item__active > a:hover,
                        {{WRAPPER}} .hq-polylang-menu > li > a:focus' => 'color: {{VALUE}}',
            ],
        ]);

        $this->add_control('lang_item_background_hover_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-polylang-menu > li > a:hover,
                        {{WRAPPER}} .hq-polylang-menu > li.menu-item__active > a:hover,
                        {{WRAPPER}} .hq-polylang-menu > li > a:focus' => 'background-color: {{VALUE}}',
            ],
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('tab_menu_item_active', [
            'label' => __('Active', 'hq-widgets-for-elementor'),
            'condition' => [
                'layout!' => 'dropdown'
            ]
        ]);

        $this->add_control('info_menu_item_active', [
            'type' => Controls_Manager::RAW_HTML,
            'raw' => __('This controls the item in the Switcher for the current active language', 'hq-widgets-for-elementor'),
            'content_classes' => 'elementor-control-field-description cpel-info-menu-item-active',
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'lang_item_active_typography',
            'selector' => '{{WRAPPER}} .hq-polylang-menu > li.menu-item__active > a',
        ]);

        $this->add_control('lang_item_text_active_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .hq-polylang-menu > li.menu-item__active > a' => 'color: {{VALUE}}',
            ],
        ]);

        $this->add_control('lang_item_background_active_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .hq-polylang-menu > li.menu-item__active > a' => 'background-color: {{VALUE}}',
            ],
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control('menu_item_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .hq-polylang-menu > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before',
        ]);

        $this->add_responsive_control('menu_item_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .hq-polylang-menu > li > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('menu_item_space_between', [
            'label' => __('Space Between', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'max' => 100,
                ],
            ],
            'selectors' => [
                'body:not(.rtl) {{WRAPPER}}.hq-polylang-layout-horizontal:not(.hq-polylang-layout-vertical) .hq-polylang-menu > li:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}}',
                'body.rtl {{WRAPPER}}.hq-polylang-layout-horizontal:not(.hq-polylang-layout-vertical) .hq-polylang-menu > li:not(:last-child)' => 'margin-left: {{SIZE}}{{UNIT}}',
                '{{WRAPPER}}.hq-polylang-layout-vertical:not(.hq-polylang-layout-horizontal) .hq-polylang-menu > li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
            ],
            'condition' => [
                'layout!' => 'dropdown'
            ]
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'menu_item_border',
            'selector' => '{{WRAPPER}} .hq-polylang-menu > li',
        ]);

        $this->end_controls_section();

        // Styles
        $this->start_controls_section('dropdown_section', [
            'label' => __('Dropdown', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'layout' => 'dropdown'
            ]
        ]);

        $this->add_control('dropdown_align', [
            'label' => esc_html__('Alignment', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'prefix_class' => 'hq-polylang-dropdown-',
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

        $this->add_responsive_control('dropdown_offset', [
            'label' => esc_html__('Offset', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'max' => 50,
                ],
            ],
            'size_units' => ['px'],
            'selectors' => [
                '{{WRAPPER}}.hq-polylang-layout-dropdown .hq-polylang-container li:hover a + .hq-polylang-dropdown,'
                . '{{WRAPPER}}.hq-polylang-layout-dropdown .hq-polylang-container li a + .hq-polylang-dropdown:hover,'
                . '{{WRAPPER}}.hq-polylang-layout-dropdown.hq-polylang-dropdown-caret-yes .hq-polylang-container > ul > li.menu-item-has-children:hover:after' => 'top: calc(100% + {{SIZE}}{{UNIT}})',
                '{{WRAPPER}}.hq-polylang-layout-dropdown .hq-polylang-container > ul > li.menu-item-has-children:hover:before' => 'height: {{SIZE}}{{UNIT}}',
            ],
        ]);

        $this->add_responsive_control('dropdown_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .hq-polylang-dropdown' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('dropdown_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .hq-polylang-dropdown' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_control('dropdown_background', [
            'label' => esc_html__('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-polylang-dropdown' => 'background-color: {{VALUE}}',
            ],
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'dropdown_box_shadow',
            'label' => __('Box Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hq-polylang-dropdown',
                ]
        );

        $this->add_control('divider_dropdown_items', [
            'type' => Controls_Manager::DIVIDER,
        ]);

        $this->add_control('dropdown_items_heading', [
            'label' => esc_html__('Items', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
        ]);

        $this->start_controls_tabs('dropdown_items_tabs');

        $this->start_controls_tab('dropdown_item_normal', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'dropdown_item_typography',
            'selector' => '{{WRAPPER}} .hq-polylang-dropdown > li > a',
        ]);

        $this->add_control('dropdown_item_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .hq-polylang-dropdown > li > a' => 'color: {{VALUE}}',
            ],
        ]);

        $this->add_responsive_control('dropdown_item_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .hq-polylang-dropdown > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'dropdown_item_border',
            'label' => esc_html__('Border Style', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hq-polylang-dropdown > li',
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('dropdown_item_hover', [
            'label' => __('Hover', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('dropdown_item_text_hover_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .hq-polylang-dropdown > li > a:hover' => 'color: {{VALUE}}',
            ],
        ]);

        $this->add_control('dropdown_item_border_hover_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .hq-polylang-dropdown > li:hover' => 'border-color: {{VALUE}}',
            ],
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /** Style: Language flag */
        $this->start_controls_section(
                'country_flag_section',
                [
                    'label' => __('Country Flag', 'hq-widgets-for-elementor'),
                    'tab' => Controls_Manager::TAB_STYLE,
                    'condition' => [
                        'show_country_flag' => ['yes'],
                    ],
                ]
        );

        $this->add_control(
                'margin_country_flag',
                [
                    'label' => __('Margin', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'em'],
                    'selectors' => [
                        '{{WRAPPER}} .hq-polylang-container .hq-polylang-country-flag' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->end_controls_section();


        /** Style: Language name */
        $this->start_controls_section(
                'language_name_section',
                [
                    'label' => __('Language Name', 'hq-widgets-for-elementor'),
                    'tab' => Controls_Manager::TAB_STYLE,
                    'condition' => [
                        'show_language_name' => ['yes'],
                    ],
                ]
        );

        $this->add_control(
                'uppercase_language_name',
                [
                    'label' => __('Uppercase', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => '',
                ]
        );

        $this->add_control(
                'margin_language_name',
                [
                    'label' => __('Margin', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'em'],
                    'selectors' => [
                        '{{WRAPPER}} .hq-polylang-container .hq-polylang-language-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->end_controls_section();


        /** Style: Language code */
        $this->start_controls_section(
                'language_code_section',
                [
                    'label' => __('Language Code', 'hq-widgets-for-elementor'),
                    'tab' => Controls_Manager::TAB_STYLE,
                    'condition' => [
                        'show_language_code' => ['yes'],
                    ],
                ]
        );

        $this->add_control(
                'uppercase_language_code',
                [
                    'label' => __('Uppercase', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
        );

        $this->add_control(
                'margin_language_code',
                [
                    'label' => __('Margin', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'em'],
                    'selectors' => [
                        '{{WRAPPER}} .hq-polylang-container .hq-polylang-language-code' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
        );

        $this->add_control(
                'before_language_code',
                [
                    'label' => __('Text before', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::TEXT,
                ]
        );

        $this->add_control(
                'after_language_code',
                [
                    'label' => __('Text after', 'hq-widgets-for-elementor'),
                    'type' => Controls_Manager::TEXT,
                ]
        );

        $this->end_controls_section();


        /** Help information - user guidance */
        $this->start_controls_section(
                'section_helpful_info',
                [
                    'label' => __('Helpful Information', 'hq-widgets-for-elementor'),
                ]
        );

        $output = '<div style="line-height: 1.2;">';
        $output .= sprintf(
                '<p style="margin-bottom: 15px;"><strong>%1$s:</strong><br />%2$s</p>',
                __('Country Flags', 'hq-widgets-for-elementor'),
                sprintf(
                        /* translators: %1$s - <code>16px</code> (width 16px) / %2$s - <code>11px</code> (height 11px) */
                        __('Country flags are by default used from Polylang plugin and have the static size of %1$s wide and %2$s high.', 'hq-widgets-for-elementor'),
                        '<code>16px</code>',
                        '<code>11px</code>'
                )
        );
        $output .= sprintf(
                '<p><strong>%1$s &rarr; %2$s &rarr; %3$s:</strong><br />%4$s</p>',
                __('Style', 'hq-widgets-for-elementor'),
                __('Main Menu', 'hq-widgets-for-elementor'),
                __('Tab: "Active"', 'hq-widgets-for-elementor'),
                __('This marks the language of currently viewed content - on the frontend. In Elementor Editor Panel this could be different.', 'hq-widgets-for-elementor')
        );
        $output .= '</div>';

        $this->add_control(
                'polylang_help_info',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => $output,
                    'content_classes' => 'cpel-help-info',
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        if (!defined('POLYLANG_VERSION')) {
            \HQLib\Utils::editor_alert_box('Polylang plugin is missing.');
            return;
        }

        $settings = $this->get_active_settings();

        $this->add_render_attribute('hq-polylang-container', 'class', [
            'hq-polylang-container',
        ]);

        // Get the available languages for a switcher
        $languages = pll_the_languages(array('raw' => 1));

        if (!empty($languages)) {

            $listHtml = '';
            $currentHtml = '';

            foreach ($languages as $language) {
                $this->remove_render_attribute('hq-polylang-menu-item', 'class');
                if ('yes' === $settings['hide_current'] && $language['current_lang']) {
                    continue;
                }

                if ('yes' === $settings['hide_missing'] && $language['no_translation']) {
                    continue;
                }

                $language_code = ( 'yes' === $settings['uppercase_language_code'] ) ? mb_strtoupper($language['slug']) : mb_strtolower($language['slug']);
                $language_name = ( 'yes' === $settings['uppercase_language_name'] ) ? mb_strtoupper($language['name']) : $language['name'];

                $this->add_render_attribute('hq-polylang-menu-item', 'class', 'menu-item');

                if ($language['current_lang']) {
                    $this->add_render_attribute('hq-polylang-menu-item', 'class', 'menu-item__active');
                }

                $html = '<a href="' . esc_url($language['url']) . '">';
                $html .= $settings['show_country_flag'] ? '<span class="hq-polylang-country-flag"><img src="' . $language['flag'] . '" alt="' . $language_code . '" width="16" height="11" /></span>' : '';
                $html .= $settings['show_language_name'] ? '<span class="hq-polylang-language-name">' . $language_name . '</span>' : '';
                $html .= $settings['before_language_code'] ?: '';
                $html .= $settings['show_language_code'] ? '<span class="hq-polylang-language-code">' . $language_code . '</span>' : '';
                $html .= $settings['after_language_code'] ?: '';
                $html .= '</a>';

                if ('dropdown' === $settings['layout'] && $language['current_lang']) {
                    $currentHtml = $html;
                } else {
                    $listHtml .= '<li ' . $this->get_render_attribute_string('hq-polylang-menu-item') . '>' . $html . '</li>';
                }
            }

            echo '<div ' . $this->get_render_attribute_string('hq-polylang-container') . '><ul class="hq-polylang-menu">';

            if ('dropdown' === $settings['layout']) {
                echo '<li class="hq-polylang-menu-item menu-item-has-children">';
                echo $currentHtml;
                echo '<ul class="hq-polylang-dropdown">';
                echo $listHtml;
                echo '</ul>';
                echo '</li>';
            } else {
                echo $listHtml;
            }

            echo '</ul></div>';
        }
    }

    protected function _content_template() {
        
    }

}
