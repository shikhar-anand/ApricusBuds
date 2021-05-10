<?php

namespace HQWidgetsForElementor\Widget\Theme;

defined('ABSPATH') || exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use const HQWidgetsForElementor\VERSION;
use const HQWidgetsForElementor\PLUGIN_SLUG;
use const HQWidgetsForElementor\PLUGIN_URL;

class WPForms extends Widget_Base {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);

        if (function_exists('wpforms_setting')) {
            // Load CSS per global setting.
            if (wpforms_setting('disable-css', '1') == '1') {
                wp_register_style(
                        'wpforms-full', WPFORMS_PLUGIN_URL . 'assets/css/wpforms-full.css', array(), WPFORMS_VERSION
                );
            }
            if (wpforms_setting('disable-css', '1') == '2') {
                wp_register_style(
                        'wpforms-base', WPFORMS_PLUGIN_URL . 'assets/css/wpforms-base.css', array(), WPFORMS_VERSION
                );
            }
            wp_register_style('hq-theme-wpforms', PLUGIN_URL . 'assets/widgets/theme/wpforms/style.css', ['elementor-icons-fa-solid'], VERSION);
        }
    }

    public function get_name() {
        return 'hq-theme-wpforms';
    }

    public function get_title() {
        return __('WPForms', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e eicon-mail';
    }

    public function get_style_depends() {

        if (!function_exists('wpforms_setting')) {
            return [];
        }

        $depends = ['hq-theme-wpforms'];

        if (wpforms_setting('disable-css', '1') == '1') {
            $depends[] = 'wpforms-full';
        }
        if (wpforms_setting('disable-css', '1') == '2') {
            $depends[] = 'wpforms-base';
        }
        return $depends;
    }

    public function get_categories() {
        return [PLUGIN_SLUG];
    }

    public function get_keywords() {
        return ['advanced', 'wpforms', 'forms', 'contacts', 'newsletter'];
    }

    public function get_wpforms_list() {
        $formslist = [];

        $forms_args = [
            'posts_per_page' => -1,
            'post_type' => 'wpforms'
        ];

        $forms = get_posts($forms_args);

        if ($forms) {
            $formslist['0'] = __('Select form', 'hq-widgets-for-elementor');
            foreach ($forms as $form) {
                $formslist[$form->ID] = $form->post_title;
            }
        } else {
            $formslist['0'] = __('Form not found', 'hq-widgets-for-elementor');
        }
        return $formslist;
    }

    protected function _register_controls() {
        if (!function_exists('wpforms_display')) {
            // Test Post Type Section
            $this->start_controls_section(
                    'section_plugin_missing', [
                'label' => __('WPForms Plugin', 'hq-widgets-for-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
                    ]
            );

            // Explanation
            $this->add_control(
                    'plugin_alert', [
                'raw' => '<p>' . __('WPForms plugin is not installed.', 'hq-widgets-for-elementor') . '</p>' . sprintf('<a href="%s" target="_blank">%s</a>', esc_url(admin_url('plugin-install.php?s=WPForms&tab=search&type=term')), __('Install WPForms.', 'hq-widgets-for-elementor')),
                'type' => Controls_Manager::RAW_HTML,
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                    ]
            );
            $this->end_controls_section();
            return;
        }

        $this->start_controls_section(
                'content', [
            'label' => __('WP Form', 'hq-widgets-for-elementor'),
                ]
        );
        $this->add_control(
                'contact_form_list', [
            'label' => __('Select Form', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'label_block' => true,
            'options' => $this->get_wpforms_list(),
            'default' => '0',
                ]
        );

        $this->add_control(
                'show_form_title', [
            'label' => __('Title', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'no',
            'label_on' => __('Show', 'hq-widgets-for-elementor'),
            'label_off' => __('Hide', 'hq-widgets-for-elementor'),
            'return_value' => 'yes',
                ]
        );

        $this->add_control(
                'show_form_description', [
            'label' => __('Description', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'no',
            'label_on' => __('Show', 'hq-widgets-for-elementor'),
            'label_off' => __('Hide', 'hq-widgets-for-elementor'),
            'return_value' => 'yes',
                ]
        );

        $this->end_controls_section();

        // Style Title tab section
        $this->start_controls_section(
                'title_style_section', [
            'label' => __('Title', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'show_form_title' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'title_text_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpforms-container .wpforms-title' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'title_typography',
            'selector' => '{{WRAPPER}} .wpforms-container .wpforms-title',
                ]
        );

        $this->add_responsive_control(
                'title_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .wpforms-container .wpforms-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before',
                ]
        );

        $this->add_responsive_control(
                'title_margin', [
            'label' => __('Margin', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .wpforms-container .wpforms-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'title_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .wpforms-container .wpforms-title',
                ]
        );

        $this->add_responsive_control(
                'title_border_radius', [
            'label' => esc_html__('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .wpforms-container .wpforms-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'description_style_section', [
            'label' => __('Description', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'show_form_description' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'description_text_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpforms-container .wpforms-description' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'description_typography',
            'selector' => '{{WRAPPER}} .wpforms-container .wpforms-description',
                ]
        );

        $this->add_responsive_control(
                'description_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .wpforms-container .wpforms-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before',
                ]
        );

        $this->add_responsive_control(
                'description_margin', [
            'label' => __('Margin', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .wpforms-container .wpforms-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'description_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .wpforms-container .wpforms-description',
                ]
        );

        $this->add_responsive_control(
                'description_border_radius', [
            'label' => esc_html__('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .wpforms-container .wpforms-description' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'label_style', [
            'label' => __('Label', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'label_background', [
            'label' => __('Background', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpforms-form .wpforms-field-label' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'label_text_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpforms-form .wpforms-field-label' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'label_typography',
            'selector' => '{{WRAPPER}} .wpforms-form .wpforms-field-label',
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'label_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .wpforms-form .wpforms-field-label',
                ]
        );

        $this->add_responsive_control(
                'label_border_radius', [
            'label' => esc_html__('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .wpforms-form .wpforms-field-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before',
                ]
        );

        $this->add_responsive_control(
                'label_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .wpforms-form .wpforms-field-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before',
                ]
        );

        $this->add_responsive_control(
                'label_margin', [
            'label' => __('Margin', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .wpforms-form .wpforms-field-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before',
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'placeholder_style', [
            'label' => __('Placeholder', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'placeholder_text_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpforms-field ::placeholder' => 'color: {{VALUE}};',
                '{{WRAPPER}} .wpforms-field ::-webkit-input-placeholder' => 'color: {{VALUE}};',
                '{{WRAPPER}} .wpforms-field ::-moz-placeholder' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'placeholder_typography',
            'selector' => '{{WRAPPER}} .wpforms-field ::placeholder, {{WRAPPER}} .wpforms-field ::-webkit-input-placeholder',
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'input_style_section', [
            'label' => __('Input', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'input_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpforms-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .wpforms-field select' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'input_text_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpforms-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .wpforms-field select' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'input_typography',
            'selector' => '{{WRAPPER}} .wpforms-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .wpforms-field select',
                ]
        );

        $this->add_responsive_control(
                'input_height', [
            'label' => __('Height', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .wpforms-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .wpforms-field select' => 'height: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->add_responsive_control(
                'input_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .wpforms-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file])' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                '{{WRAPPER}} .wpforms-field select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before',
                ]
        );

        $this->add_responsive_control(
                'input_margin', [
            'label' => __('Margin', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .wpforms-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file])' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                '{{WRAPPER}} .wpforms-field select' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'input_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .wpforms-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .wpforms-field select',
                ]
        );

        $this->add_responsive_control(
                'input_border_radius', [
            'label' => esc_html__('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .wpforms-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file])' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                '{{WRAPPER}} .wpforms-field select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->start_controls_tabs('input_tabs');

        $this->start_controls_tab(
                'tab_input_normal', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'input_box_shadow',
            'label' => __('Box Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .wpforms-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file])',
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_input_focus', [
            'label' => __('Focus', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'input_focus_box_shadow',
            'label' => __('Box Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .wpforms-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]):focus',
                ]
        );

        $this->add_control(
                'comment_form_inputs_focus_border_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpforms-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]):focus' => 'border-color: {{VALUE}};',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
                'style_section', [
            'label' => __('Textarea', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'textarea_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpforms-field textarea' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'textarea_text_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpforms-field textarea' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'textarea_typography',
            'selector' => '{{WRAPPER}} .wpforms-field textarea',
                ]
        );

        $this->add_responsive_control(
                'textarea_height', [
            'label' => __('Height', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 500,
                    'step' => 1,
                ],
            ],
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .wpforms-field textarea' => 'height: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->add_responsive_control(
                'textarea_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .wpforms-field textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before',
                ]
        );

        $this->add_responsive_control(
                'textarea_margin', [
            'label' => __('Margin', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .wpforms-field textarea' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'textarea_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .wpforms-field textarea',
                ]
        );

        $this->add_responsive_control(
                'textarea_border_radius', [
            'label' => esc_html__('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .wpforms-field textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->start_controls_tabs('tabs');

        $this->start_controls_tab(
                'textarea_normal_tab', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'textarea_box_shadow',
            'label' => __('Box Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .wpforms-field textarea',
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'textarea_focus_tab', [
            'label' => __('Focus', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'textarea_focus_box_shadow',
            'label' => __('Box Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .wpforms-field textarea:focus',
                ]
        );

        $this->add_control(
                'textarea_focus_border_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpforms-field textarea:focus' => 'border-color: {{VALUE}};',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
                'checkbox_radio_section', [
            'label' => __('Checkboxes and Radios', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'checkbox_radio_typography',
            'selector' => '{{WRAPPER}} .wpforms-field-checkbox ul > li > label, {{WRAPPER}} .wpforms-field-radio ul > li > label',
                ]
        );

        $this->add_control('checkbox_radio_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpforms-field-checkbox ul > li > label, {{WRAPPER}} .wpforms-field-radio ul > li > label' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_responsive_control('checkbox_radio_size', [
            'label' => __('Size', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 15,
                    'max' => 50,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .wpforms-field-checkbox ul > li > label:before, {{WRAPPER}} .wpforms-field-radio ul > li > label:before' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
                '{{WRAPPER}} .wpforms-field-checkbox ul > li > label:after, {{WRAPPER}} .wpforms-field-radio ul > li > label:after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}}; font-size: calc({{SIZE}}{{UNIT}} / 2)',
            ],
        ]);

        $this->add_responsive_control('checkbox_radio_input_spacing', [
            'label' => __('Input Spacing', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 20,
                    'max' => 50,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .wpforms-field-checkbox ul > li > label, {{WRAPPER}} .wpforms-field-radio ul > li > label' => 'padding-left: {{SIZE}}{{UNIT}}',
            ],
        ]);

        $this->add_responsive_control('checkbox_radio_options_spacing', [
            'label' => __('Options Spacing', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'max' => 50,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .wpforms-field-checkbox ul > li, {{WRAPPER}} .wpforms-field-radio ul > li' => 'margin-bottom: {{SIZE}}{{UNIT}}!important',
            ],
        ]);

        $this->add_responsive_control(
                'checkboxes_border_radius', [
            'label' => __('Checkbox Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .wpforms-field-checkbox ul > li > label:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->start_controls_tabs('checkbox_radio_tabs');

        $this->start_controls_tab(
                'checkbox_radio_unchecked_tab', [
            'label' => __('Unchecked', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'checkbox_radio_unchecked_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .wpforms-field-checkbox ul > li > label:before, {{WRAPPER}} .wpforms-field-radio ul > li > label:before',
                ]
        );

        $this->add_control(
                'checkbox_radio_unchecked_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpforms-field-checkbox ul > li > label:before, {{WRAPPER}} .wpforms-field-radio ul > li > label:before' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'checkbox_radio_checked_tab', [
            'label' => __('Checked', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'checkbox_radio_checked_text_color', [
            'label' => __('Check Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpforms-field-checkbox ul > li > input:checked ~ label:after, {{WRAPPER}} .wpforms-field-radio ul > li > input:checked ~ label:after' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'checkbox_checked_background_color', [
            'label' => __('Checkbox Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpforms-field-checkbox ul > li > input:checked ~ label:before' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'radio_checked_background_color', [
            'label' => __('Radio Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpforms-field-radio ul > li > input:checked ~ label:before' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'checkbox_radio_checked_border_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpforms-field-checkbox ul > li > input:checked ~ label:before, {{WRAPPER}} .wpforms-field-radio ul > li > input:checked ~ label:before' => 'border-color: {{VALUE}};',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
                'input_submit_style_section', [
            'label' => __('Button', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_responsive_control(
                'input_submit_alignment', [
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
            'default' => 'left',
            'toggle' => false,
            'selectors' => [
                '{{WRAPPER}} .wpforms-form .wpforms-submit-container' => 'text-align: {{VALUE}}'
            ],
                ]
        );

        $this->add_responsive_control(
                'input_submit_width', [
            'label' => __('Width', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'max' => 300,
                ],
                '%' => [
                    'max' => 100
                ]
            ],
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .wpforms-form button[type="submit"]' => 'width: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'input_submit_height', [
            'label' => __('Height', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'max' => 150,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .wpforms-form button[type="submit"]' => 'height: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->start_controls_tabs('input_submit_style_tabs');

        $this->start_controls_tab(
                'input_submit_normal_tab', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'input_submit_typography',
            'selector' => '{{WRAPPER}} .wpforms-form button[type="submit"]',
                ]
        );

        $this->add_control(
                'input_submit_text_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpforms-form button[type="submit"]' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'input_submit_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpforms-form button[type="submit"]' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'input_submit_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .wpforms-form button[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'input_submit_margin', [
            'label' => __('Margin', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .wpforms-form button[type="submit"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'input_submit_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .wpforms-form button[type="submit"]',
                ]
        );

        $this->add_responsive_control(
                'input_submit_border_radius', [
            'label' => esc_html__('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .wpforms-form button[type="submit"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'input_submit_box_shadow',
            'label' => __('Box Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .wpforms-form button[type="submit"]',
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'input_submit_hover_tab', [
            'label' => __('Hover', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'input_submit_hover_text_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpforms-form button[type="submit"]:hover' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'input_submit_hover_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpforms-form button[type="submit"]:hover' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'input_submit_hover_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .wpforms-form button[type="submit"]:hover',
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render($instance = []) {
        if (!function_exists('wpforms_display')) {
            \HQLib\Utils::editor_alert_box('WPForms plugin is missing.');
            return;
        }

        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('hq_wpform_wrapper', 'class', 'hq-wpform_area');
        ?>
        <div <?php echo $this->get_render_attribute_string('hq_wpform_wrapper'); ?> >
            <?php
            if (!function_exists('wpforms_display')) {
                echo '<p>' . esc_html__('WPForms plugin is not installed.', 'hq-widgets-for-elementor') . '</p>';
            } else {
                if (!$settings['contact_form_list']) {
                    echo '<p>' . esc_html__('Please Select form.', 'hq-widgets-for-elementor') . '</p>';
                } else {
                    wpforms_display($settings['contact_form_list'], $settings['show_form_title'], $settings['show_form_description']);
                }
            }
            ?>
        </div>
        <?php
    }

}
