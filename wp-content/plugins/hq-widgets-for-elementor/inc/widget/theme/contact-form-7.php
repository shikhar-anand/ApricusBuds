<?php

namespace HQWidgetsForElementor\Widget\Theme;

defined('ABSPATH') || exit;

use Elementor\Plugin;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use const HQWidgetsForElementor\ELEMENTOR_BASE_UPLOADS;
use const HQWidgetsForElementor\VERSION;
use const HQWidgetsForElementor\PLUGIN_SLUG;
use const HQWidgetsForElementor\PLUGIN_URL;

class Contact_Form_7 extends Widget_Base {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        wp_register_style('hq-theme-contact-form-7', ELEMENTOR_BASE_UPLOADS . 'css/hq-theme-contact-form-7.css', [], VERSION);
        wp_register_script('hq-theme-contact-form-7', PLUGIN_URL . 'assets/widgets/theme/contact-form-7/script.js', ['elementor-frontend'], VERSION, true);
    }

    public function get_name() {
        return 'hq-theme-contact-form-7';
    }

    public function get_title() {
        return __('Contact Form 7', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-contact';
    }

    public function get_script_depends() {
        return ['hq-theme-contact-form-7'];
    }

    public function get_style_depends() {
        return ['hq-theme-contact-form-7'];
    }

    public function get_categories() {
        return [PLUGIN_SLUG];
    }

    public function get_keywords() {
        return ['contact', 'forms', '7', 'newsletter', 'cf7'];
    }

    public function get_contactform7_list() {
        $formslist = [];

        $forms_args = [
            'posts_per_page' => -1,
            'post_type' => 'wpcf7_contact_form'
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
        if (!defined('WPCF7_VERSION')) {
            $this->start_controls_section('section_plugin_missing', [
                'label' => __('Contact Form 7', 'hq-widgets-for-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]);

            // Explanation
            $this->add_control('plugin_alert', [
                'raw' => '<p>' . __('Contact Form 7 plugin is not installed.', 'hq-widgets-for-elementor') . '</p>' . sprintf('<a href="%s" target="_blank">%s</a>', esc_url(admin_url('plugin-install.php?s=contact+form+7&tab=search&type=term')), __('Install Contact Form 7.', 'hq-widgets-for-elementor')),
                'type' => Controls_Manager::RAW_HTML,
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
            ]);

            $this->end_controls_section();

            return;
        }

        $this->start_controls_section('content', [
            'label' => __('Contact Form 7', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('contact_form_id', [
            'label' => __('Select Form', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'label_block' => true,
            'options' => $this->get_contactform7_list(),
            'default' => '0',
            'description' => \HQLib\Utils::get_cf7_howto(),
        ]);

        $this->end_controls_section();

        // Style tab section
        $this->start_controls_section('cf7_section_style', [
            'label' => __('Contact Form', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('cf7_alignment', [
            'label' => __('Align Items', 'hq-widgets-for-elementor'),
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
            'selectors' => [
                '{{WRAPPER}} .hq-cf7-wrapper' => 'text-align: {{VALUE}};',
            ],
            'default' => 'left',
        ]);

        $this->end_controls_section();

        $this->start_controls_section('cf7_label_style', [
            'label' => __('Label', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'cf7_label_typography',
            'selector' => '{{WRAPPER}} .wpcf7-form label',
        ]);

        $this->add_control('cf7_label_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-cf7-wrapper form.wpcf7-form label' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_responsive_control('cf7_label_margin', [
            'label' => __('Margin', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .wpcf7-form label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('cf7_input_style', [
            'label' => __('Input', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->start_controls_tabs('cf7_input_tabs');

        $this->start_controls_tab('cf7_input_normal_tab', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'cf7_input_typography',
            'exclude' => [
                'line_height'
            ],
            'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select',
        ]);

        $this->add_control('cf7_input_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"]' => 'color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"]' => 'color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"]' => 'color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"]' => 'color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"]' => 'color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"]' => 'color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('cf7_input_background', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"]' => 'background-color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"]' => 'background-color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"]' => 'background-color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"]' => 'background-color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"]' => 'background-color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"]' => 'background-color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('cf7_input_placeholder_color', [
            'label' => __('Placeholder Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"]::-webkit-input-placeholder' => 'color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"]::-moz-placeholder' => 'color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"]:-ms-input-placeholder' => 'color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"]::-webkit-input-placeholder' => 'color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"]::-moz-placeholder' => 'color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"]:-ms-input-placeholder' => 'color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"]::-webkit-input-placeholder' => 'color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"]::-moz-placeholder' => 'color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"]:-ms-input-placeholder' => 'color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"]::-webkit-input-placeholder' => 'color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"]::-moz-placeholder' => 'color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"]:-ms-input-placeholder' => 'color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"]::-webkit-input-placeholder' => 'color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"]::-moz-placeholder' => 'color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"]:-ms-input-placeholder' => 'color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"]::-webkit-input-placeholder' => 'color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"]::-moz-placeholder' => 'color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"]:-ms-input-placeholder' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'cf7_input_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select',
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'cf7_input_box_shadow',
            'label' => __('Box Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select',
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('cf7_input_focus_tab', [
            'label' => __('Focus', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('cf7_input_focus_border_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"]:focus' => 'border-color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"]:focus' => 'border-color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"]:focus' => 'border-color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"]:focus' => 'border-color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"]:focus' => 'border-color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"]:focus' => 'border-color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select:focus' => 'border-color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'cf7_input_focus_box_shadow',
            'label' => __('Box Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"]:focus, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"]:focus, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"]:focus, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"]:focus, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"]:focus, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"]:focus, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select:focus',
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('cf7_input_invalid_tab', [
            'label' => __('Invalid', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('cf7_input_invalid_border_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"].wpcf7-not-valid' => 'border-color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"].wpcf7-not-valid' => 'border-color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"].wpcf7-not-valid' => 'border-color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"].wpcf7-not-valid' => 'border-color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"].wpcf7-not-valid' => 'border-color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"].wpcf7-not-valid' => 'border-color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select.wpcf7-not-valid' => 'border-color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'cf7_input_invalid_box_shadow',
            'label' => __('Box Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"].wpcf7-not-valid, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"].wpcf7-not-valid, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"].wpcf7-not-valid, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"].wpcf7-not-valid, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"].wpcf7-not-valid, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"].wpcf7-not-valid, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select.wpcf7-not-valid',
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control('cf7_input_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before',
        ]);

        $this->add_responsive_control('cf7_input_margin', [
            'label' => __('Margin', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('cf7_input_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before',
        ]);

        $this->end_controls_section();

        $this->start_controls_section('cf7_textarea_style', [
            'label' => __('Textarea', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('cf7_textarea_height', [
            'label' => __('Height', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'max' => 500,
                ],
            ],
            'default' => [
                'size' => 175,
            ],
            'selectors' => [
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->start_controls_tabs('cf7_textarea_tabs');

        $this->start_controls_tab('cf7_textarea_normal_tab', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'cf7_textarea_typography',
            'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea',
        ]);

        $this->add_control('cf7_textarea_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('cf7_textarea_background', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('cf7_textarea_placeholder_color', [
            'label' => __('Placeholder Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea::-webkit-input-placeholder' => 'color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea::-moz-placeholder' => 'color: {{VALUE}};',
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea:-ms-input-placeholder' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'cf7_textarea_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea',
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'cf7_textarea_box_shadow',
            'label' => __('Box Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea',
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('cf7_textarea_focus_tab', [
            'label' => __('Focus', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('cf7_textarea_focus_border_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea:focus' => 'border-color: {{VALUE}}',
            ],
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'cf7_textarea_focus_box_shadow',
            'label' => __('Box Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea:focus',
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('cf7_textarea_invalid_tab', [
            'label' => __('Invalid', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('cf7_textarea_invalid_border_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea.wpcf7-not-valid' => 'border-color: {{VALUE}}',
            ],
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'cf7_textarea_invalid_box_shadow',
            'label' => __('Box Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea.wpcf7-not-valid',
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control('cf7_textarea_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before',
        ]);

        $this->add_responsive_control('cf7_textarea_margin', [
            'label' => __('Margin', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('cf7_textarea_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('cf7_checkbox_radio_section', [
            'label' => __('Checkboxes and Radios', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('cf7_checkbox_radio_wrapper_margin', [
            'label' => __('Container Offset', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .wpcf7-form .wpcf7-checkbox, {{WRAPPER}} .wpcf7-form .wpcf7-acceptance, {{WRAPPER}} .wpcf7-form .wpcf7-radio' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'after',
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'cf7_checkbox_radio_typography',
            'selector' => '{{WRAPPER}} .wpcf7-checkbox .wpcf7-list-item-label, {{WRAPPER}} .wpcf7-acceptance .wpcf7-list-item-label, {{WRAPPER}} .wpcf7-radio .wpcf7-list-item-label',
        ]);

        $this->add_control('cf7_checkbox_radio_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpcf7-checkbox .wpcf7-list-item-label, {{WRAPPER}} .wpcf7-acceptance .wpcf7-list-item-label, {{WRAPPER}} .wpcf7-radio .wpcf7-list-item-label' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_responsive_control('cf7_checkbox_radio_size', [
            'label' => __('Size', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 15,
                    'max' => 50,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .wpcf7-checkbox label .wpcf7-list-item-label:before,'
                . '{{WRAPPER}} .wpcf7-acceptance label .wpcf7-list-item-label:before,'
                . '{{WRAPPER}} .wpcf7-radio label .wpcf7-list-item-label:before' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
                '{{WRAPPER}} .wpcf7-checkbox label .wpcf7-list-item-label:after,'
                . '{{WRAPPER}} .wpcf7-acceptance label .wpcf7-list-item-label:after' => 'width: calc({{SIZE}}{{UNIT}} / 2.5); height: calc({{SIZE}}{{UNIT}} / 1.666); top: calc(-{{SIZE}}{{UNIT}} / 5); left: calc({{SIZE}}{{UNIT}} / 2 - {{SIZE}}{{UNIT}} / 5)',
                '{{WRAPPER}} .wpcf7-radio label .wpcf7-list-item-label:after' => 'width: calc({{SIZE}}{{UNIT}} / 2.5); height: calc({{SIZE}}{{UNIT}} / 2.5); left: calc({{SIZE}}{{UNIT}} / 2 - {{SIZE}}{{UNIT}} / 5)',
            ],
        ]);

        $this->add_responsive_control('cf7_checkbox_radio_input_spacing', [
            'label' => __('Input Spacing', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 20,
                    'max' => 50,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .wpcf7-checkbox label .wpcf7-list-item-label, {{WRAPPER}} .wpcf7-acceptance label .wpcf7-list-item-label, {{WRAPPER}} .wpcf7-radio label .wpcf7-list-item-label' => 'padding-left: {{SIZE}}{{UNIT}}',
            ],
        ]);

        $this->add_responsive_control('cf7_checkbox_radio_options_spacing', [
            'label' => __('Options Spacing', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'max' => 50,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .wpcf7-checkbox .wpcf7-list-item:not(.last), {{WRAPPER}}.cf7-radio-align-block .wpcf7-radio .wpcf7-list-item:not(.last)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
            ],
        ]);

        $this->add_responsive_control(
                'cf7_checkboxes_border_radius', [
            'label' => __('Checkbox Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .wpcf7-checkbox label .wpcf7-list-item-label:before, {{WRAPPER}} .wpcf7-acceptance label .wpcf7-list-item-label:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->start_controls_tabs('cf7_checkbox_radio_tabs');

        $this->start_controls_tab(
                'cf7_checkbox_radio_unchecked_tab', [
            'label' => __('Unchecked', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'cf7_checkbox_radio_unchecked_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .wpcf7-checkbox label .wpcf7-list-item-label:before, {{WRAPPER}} .wpcf7-acceptance label .wpcf7-list-item-label:before, {{WRAPPER}} .wpcf7-radio label .wpcf7-list-item-label:before',
                ]
        );

        $this->add_control(
                'cf7_checkbox_radio_unchecked_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpcf7-checkbox label .wpcf7-list-item-label:before, {{WRAPPER}} .wpcf7-acceptance label .wpcf7-list-item-label:before, {{WRAPPER}} .wpcf7-radio label .wpcf7-list-item-label:before' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'cf7_checkbox_radio_checked_tab', [
            'label' => __('Checked', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'cf7_checkbox_radio_checked_text_color', [
            'label' => __('Check Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpcf7-checkbox label input:checked ~ .wpcf7-list-item-label:after,'
                . '{{WRAPPER}} .wpcf7-acceptance label input:checked ~ .wpcf7-list-item-label:after' => 'border-color: {{VALUE}}',
                '{{WRAPPER}} .wpcf7-radio label input:checked ~ .wpcf7-list-item-label:after' => 'background: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'cf7_checkbox_checked_background_color', [
            'label' => __('Checkbox Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpcf7-checkbox label input:checked ~ .wpcf7-list-item-label:before,'
                . '{{WRAPPER}} .wpcf7-acceptance label input:checked ~ .wpcf7-list-item-label:before' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'cf7_radio_checked_background_color', [
            'label' => __('Radio Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpcf7-radio label input:checked ~ .wpcf7-list-item-label:before' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'cf7_checkbox_radio_checked_border_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpcf7-checkbox label input:checked ~ .wpcf7-list-item-label:before,'
                . '{{WRAPPER}} .wpcf7-acceptance label input:checked ~ .wpcf7-list-item-label:before,'
                . '{{WRAPPER}} .wpcf7-radio label input:checked ~ .wpcf7-list-item-label:before' => 'border-color: {{VALUE}};',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section('cf7_submit_style', [
            'label' => __('Button', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('cf7_submit_width', [
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
                '{{WRAPPER}} .wpcf7-form .submit-wrapper' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('cf7_submit_align', [
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
            'toggle' => false,
            'selectors_dictionary' => [
                'left' => 'margin-left: 0; margin-right: auto;',
                'center' => 'margin-left: auto; margin-right: auto;',
                'right' => 'margin-left: auto; margin-right: 0;',
            ],
            'selectors' => [
                '{{WRAPPER}} .wpcf7-form .submit-wrapper' => '{{VALUE}};',
            ],
            'default' => 'right',
        ]);

        $this->start_controls_tabs('cf7_submit_tabs');

        $this->start_controls_tab('cf7_submit_normal_tab', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'cf7_submit_typography',
            'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-submit',
        ]);

        $this->add_control('cf7_submit_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpcf7-form .wpcf7-submit' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('cf7_submit_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpcf7-form .wpcf7-submit' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'cf7_submit_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-submit',
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'cf7_submit_box_shadow',
            'label' => __('Box Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-submit',
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('cf7_submit_hover_tab', [
            'label' => __('Hover', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('cf7_submit_hover_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpcf7-form .wpcf7-submit:hover' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('cf7_submit_hover_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpcf7-form .wpcf7-submit:hover' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('cf7_submit_hover_border_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpcf7-form .wpcf7-submit:hover' => 'border-color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control('cf7_submit_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .wpcf7-form .wpcf7-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before'
        ]);

        $this->add_responsive_control('cf7_submit_margin', [
            'label' => __('Margin', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .wpcf7-form .wpcf7-submit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('cf7_submit_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .wpcf7-form .wpcf7-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_control('heading_cf7_submit_loader', [
            'label' => __('Loader', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);

        $this->add_control('cf7_submit_loader_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpcf7-form .ajax-loader span' => 'background: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('cf7_msg_style', [
            'label' => __('Messages', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('heading_cf7_msg_error', [
            'label' => __('Validation Error', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
        ]);

        $this->add_responsive_control('cf7_error_alignment', [
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
            'selectors' => [
                '{{WRAPPER}} .wpcf7-not-valid-tip' => 'text-align: {{VALUE}};',
            ],
            'default' => 'center',
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'cf7_error_typography',
            'selector' => '{{WRAPPER}} .wpcf7-not-valid-tip',
        ]);

        $this->add_control('cf7_error_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpcf7-not-valid-tip' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('cf7_error_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpcf7-not-valid-tip' => 'background: {{VALUE}};',
            ],
        ]);

        $this->add_responsive_control('cf7_error_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .wpcf7-not-valid-tip' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('cf7_error_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .wpcf7-not-valid-tip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('cf7_error_margin', [
            'label' => __('Margin', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .wpcf7-not-valid-tip' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_control('heading_cf7_msg_response', [
            'label' => __('Response Output', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);

        $this->add_responsive_control('cf7_response_alignment', [
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
            'selectors' => [
                '{{WRAPPER}} .wpcf7-response-output' => 'text-align: {{VALUE}};',
            ],
            'default' => 'center',
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'cf7_response_typography',
            'selector' => '{{WRAPPER}} .wpcf7-response-output',
        ]);

        $this->add_control('cf7_response_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpcf7-response-output' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('cf7_response_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .wpcf7-response-output' => 'background: {{VALUE}};',
            ],
        ]);

        $this->add_responsive_control('cf7_response_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .wpcf7-response-output' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('cf7_response_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .wpcf7-response-output' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('cf7_response_margin', [
            'label' => __('Margin', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .wpcf7-response-output' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        if (!defined('WPCF7_VERSION')) {
            if (Plugin::instance()->editor->is_edit_mode()) {
                ?>
                <div class="elementor-alert elementor-alert-info" role="alert">
                    <span class="elementor-alert-description">
                <?php __('Contact Form 7 plugin is not installed.', 'hq-widgets-for-elementor') . '</p>' . sprintf('<a href="%s" target="_blank">%s</a>', esc_url(admin_url('plugin-install.php?s=contact+form+7&tab=search&type=term')), __('Install Contact Form 7.', 'hq-widgets-for-elementor')); ?>
                    </span>
                </div>
                <?php
            }
            return;
        }

        $settings = $this->get_settings_for_display();
        $this->add_render_attribute('hq_cf7_wrapper', 'class', 'hq-cf7-wrapper');
        $this->add_render_attribute('hq_cf7_container', 'class', 'hq-cf7-container');
        ?>
        <div <?php echo $this->get_render_attribute_string('hq_cf7_wrapper'); ?> >
            <div <?php echo $this->get_render_attribute_string('hq_cf7_container'); ?> >
        <?php
        if (!empty($settings['contact_form_id'])) {
            $this->add_render_attribute('shortcode', 'id', $settings['contact_form_id']);
            $shortcode = sprintf('[contact-form-7 %s]', $this->get_render_attribute_string('shortcode'));
            echo do_shortcode($shortcode);
        } else {
            if (Plugin::instance()->editor->is_edit_mode()) {
                ?>
                        <div class="elementor-alert elementor-alert-info" role="alert">
                            <span class="elementor-alert-description">
                <?php esc_html_e('Please Select a contact form.', 'hq-widgets-for-elementor'); ?>
                            </span>
                        </div>
                <?php
            }
        }
        ?>
            </div>
        </div>
        <?php
    }

}
