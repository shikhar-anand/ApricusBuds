<?php

namespace HQWidgetsForElementor\Widget;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

abstract class Title_Base extends Widget_Base {

    protected function register_title_controls() {
        $this->start_controls_section(
                'section_title', [
            'label' => __('Title', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'header_size', [
            'label' => __('HTML Tag', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'h1' => 'H1',
                'h2' => 'H2',
                'h3' => 'H3',
                'h4' => 'H4',
                'h5' => 'H5',
                'h6' => 'H6',
                'div' => 'div',
                'span' => 'span',
                'p' => 'p',
            ],
            'default' => 'h3',
                ]
        );

        $this->add_responsive_control(
                'align', [
            'label' => __('Alignment', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Left', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-text-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-text-align-center',
                ],
                'right' => [
                    'title' => __('Right', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-text-align-right',
                ],
                'justify' => [
                    'title' => __('Justified', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-text-align-justify',
                ],
            ],
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .elementor-heading-title' => 'text-align: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'truncate', [
            'label' => __('Truncate with Ellipsis', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
                ]
        );

        $this->add_control(
                'view', [
            'label' => __('View', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HIDDEN,
            'default' => 'traditional',
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_title_style', [
            'label' => __('Title', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'title_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                // Stronger selector to avoid section style from overwriting
                '{{WRAPPER}} .elementor-heading-title, {{WRAPPER}} .elementor-heading-title a' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'typography',
            'selector' => '{{WRAPPER}} .elementor-heading-title, {{WRAPPER}} .elementor-heading-title a',
                ]
        );

        $this->add_group_control(
                Group_Control_Text_Shadow::get_type(), [
            'name' => 'text_shadow',
            'selector' => '{{WRAPPER}} .elementor-heading-title',
                ]
        );

        $this->add_control(
                'blend_mode', [
            'label' => __('Blend Mode', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                '' => __('Normal', 'hq-widgets-for-elementor'),
                'multiply' => 'Multiply',
                'screen' => 'Screen',
                'overlay' => 'Overlay',
                'darken' => 'Darken',
                'lighten' => 'Lighten',
                'color-dodge' => 'Color Dodge',
                'saturation' => 'Saturation',
                'color' => 'Color',
                'difference' => 'Difference',
                'exclusion' => 'Exclusion',
                'hue' => 'Hue',
                'luminosity' => 'Luminosity',
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-heading-title' => 'mix-blend-mode: {{VALUE}}',
            ],
            'separator' => 'none',
                ]
        );

        $this->add_responsive_control(
                'title_padding', [
            'label' => esc_html__('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .elementor-heading-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
            ],
            'separator' => 'before',
                ]
        );

        $this->add_responsive_control(
                'title_margin', [
            'label' => esc_html__('Margin', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .elementor-heading-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
            ]
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'title_border',
            'selector' => '{{WRAPPER}} .elementor-heading-title'
                ]
        );

        $this->end_controls_section();
    }

    protected function register_title_clickable_controls() {
        $this->start_injection([
            'at' => 'after',
            'of' => 'truncate',
        ]);

        $this->add_control(
                'clickable', [
            'label' => __('Clickable', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
                ]
        );

        $this->end_injection();

        $this->start_injection([
            'at' => 'after',
            'of' => 'title_color',
        ]);

        $this->add_control(
                'title_hover_color', [
            'label' => __('Hover Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elementor-heading-title:hover, {{WRAPPER}} .elementor-heading-title a:hover' => 'color: {{VALUE}};',
            ],
            'separator' => 'after',
            'condition' => [
                'clickable' => 'yes'
            ],
                ]
        );

        $this->end_injection();
    }

    protected function register_description_controls() {
        $this->start_controls_section(
                'section_description', [
            'label' => __('Description', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'header_description_size', [
            'label' => __('Description HTML Tag', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'h1' => __('H1', 'hq-widgets-for-elementor'),
                'h2' => __('H2', 'hq-widgets-for-elementor'),
                'h3' => __('H3', 'hq-widgets-for-elementor'),
                'h4' => __('H4', 'hq-widgets-for-elementor'),
                'h5' => __('H5', 'hq-widgets-for-elementor'),
                'h6' => __('H6', 'hq-widgets-for-elementor'),
                'p' => __('p', 'hq-widgets-for-elementor'),
                'div' => __('div', 'hq-widgets-for-elementor'),
                'span' => __('span', 'hq-widgets-for-elementor'),
            ],
            'default' => 'p',
                ]
        );

        $this->add_responsive_control(
                'description_align', [
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
                'justify' => [
                    'title' => __('Justified', 'hq-widgets-for-elementor'),
                    'icon' => 'fa fa-align-justify',
                ],
            ],
            'default' => 'left',
            'selectors' => [
                '{{WRAPPER}} .elementor-heading-description' => 'text-align: {{VALUE}};',
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_description_style', [
            'label' => __('Description', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'description_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elementor-heading-description' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'description_typography',
            'selector' => '{{WRAPPER}} .elementor-heading-description',
                ]
        );

        $this->add_group_control(
                Group_Control_Text_Shadow::get_type(), [
            'name' => 'description_text_shadow',
            'selector' => '{{WRAPPER}} .elementor-heading-description'
                ]
        );

        $this->add_responsive_control(
                'description_padding', [
            'label' => esc_html__('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .elementor-heading-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
            ],
            'separator' => 'before'
                ]
        );

        $this->add_responsive_control(
                'description_margin', [
            'label' => esc_html__('Margin', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .elementor-heading-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
            ]
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'description_border',
            'selector' => '{{WRAPPER}} .elementor-heading-description'
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        
    }

}
