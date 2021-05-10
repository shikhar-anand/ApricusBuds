<?php

namespace HQWidgetsForElementor\Widget\Theme;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Modules\DynamicTags\Module as TagsModule;
use Elementor\Utils;
use Elementor\Widget_Base;
use const HQWidgetsForElementor\VERSION;
use const HQWidgetsForElementor\PLUGIN_SLUG;
use const HQWidgetsForElementor\PLUGIN_URL;

class Flip_Box extends Widget_Base {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        wp_register_style('hq-theme-flip-box', PLUGIN_URL . 'assets/widgets/theme/flip-box/style.css', [], VERSION);
    }

    public function get_name() {
        return 'hq-theme-flip-box';
    }

    public function get_title() {
        return esc_html__('Flip Box', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-flip';
    }

    public function get_style_depends() {
        return ['hq-theme-flip-box'];
    }

    public function get_categories() {
        return [PLUGIN_SLUG];
    }

    public function get_keywords() {
        return ['flip', 'box'];
    }

    protected function _register_controls() {

        $this->start_controls_section('flipbox_front_content', [
            'label' => esc_html__('Front', 'hq-widgets-for-elementor')
        ]);

        $this->add_control('front_graphic_type', [
            'label' => esc_html__('Graphic Type', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'none' => [
                    'title' => esc_html__('Left', 'hq-widgets-for-elementor'),
                    'icon' => 'fas fa-ban',
                ],
                'image' => [
                    'title' => esc_html__('Center', 'hq-widgets-for-elementor'),
                    'icon' => 'fas fa-image',
                ],
                'icon' => [
                    'title' => esc_html__('Right', 'hq-widgets-for-elementor'),
                    'icon' => 'fas fa-heart',
                ],
            ],
            'toggle' => false,
            'default' => 'icon',
        ]);

        $this->add_control('image', [
            'label' => __('Choose Image', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::MEDIA,
            'default' => [
                'url' => Utils::get_placeholder_image_src(),
            ],
            'condition' => [
                'front_graphic_type' => 'image',
            ],
            'dynamic' => ['active' => true],
        ]);

        $this->add_group_control(Group_Control_Image_Size::get_type(), [
            'name' => 'image',
            'label' => __('Image Size', 'hq-widgets-for-elementor'),
            'default' => 'thumbnail',
            'condition' => [
                'front_graphic_type' => 'image',
            ],
        ]);

        $this->add_control('front_icon', [
            'label' => __('Icon', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-heart',
                'library' => 'fa-solid',
            ],
            'condition' => [
                'front_graphic_type' => 'icon',
            ],
        ]);

        $this->add_control('front_title', [
            'label' => esc_html__('Title', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'label_block' => true,
            'dynamic' => ['active' => true],
            'default' => esc_html__('Front Title', 'hq-widgets-for-elementor'),
            'separator' => 'before'
        ]);

        $this->add_control('front_description', [
            'label' => __('Description', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXTAREA,
            'dynamic' => ['active' => true],
            'default' => __('Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'hq-widgets-for-elementor'),
            'placeholder' => __('Description text', 'hq-widgets-for-elementor'),
        ]);

        $this->end_controls_section();

        $this->start_controls_section('flipbox_back_content', [
            'label' => esc_html__('Back', 'hq-widgets-for-elementor')
        ]);

        $this->add_control('back_title', [
            'label' => esc_html__('Title', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'label_block' => true,
            'dynamic' => ['active' => true],
            'default' => esc_html__('Back Title', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('back_description', [
            'label' => __('Description', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXTAREA,
            'dynamic' => ['active' => true],
            'default' => __('Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'hq-widgets-for-elementor'),
            'placeholder' => __('Description text', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('back_link_heading', [
            'label' => esc_html__('Link', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before'
        ]);

        $this->add_control('flipbox_link_type', [
            'label' => __('Type', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'none',
            'options' => [
                'none' => __('None', 'hq-widgets-for-elementor'),
                'button' => __('Button', 'hq-widgets-for-elementor'),
            ],
        ]);

        $this->add_control('flipbox_link', [
            'label' => __('Url', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::URL,
            'dynamic' => [
                'active' => true,
                'categories' => [
                    TagsModule::POST_META_CATEGORY,
                    TagsModule::URL_CATEGORY
                ],
            ],
            'placeholder' => 'https://www.your-link.com',
            'default' => [
                'url' => '#',
            ],
            'condition' => [
                'flipbox_link_type!' => 'none',
            ],
        ]);

        $this->add_control('flipbox_button_text', [
            'label' => __('Button Text', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'dynamic' => [
                'active' => true,
            ],
            'default' => __('Get Started', 'hq-widgets-for-elementor'),
            'condition' => [
                'flipbox_link_type' => 'button',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('flipbox_settings', [
            'label' => esc_html__('Settings', 'hq-widgets-for-elementor')
        ]);

        $this->add_responsive_control('flipbox_height', [
            'label' => __('Height', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 100,
                    'max' => 1000,
                    'step' => 10
                ],
                'vh' => [
                    'min' => 10,
                    'max' => 100,
                ],
            ],
            'size_units' => ['px', 'vh'],
            'selectors' => [
                '{{WRAPPER}} .hq-flipbox-wrapper' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('flipbox_effect', [
            'label' => __('Flip Effect', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'flip',
            'options' => [
                'flip' => __('Flip', 'hq-widgets-for-elementor'),
            ],
            'prefix_class' => 'hq-flipbox-effect-',
        ]);

        $this->add_control('flipbox_effect_direction', [
            'label' => __('Effect Direction', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'left',
            'options' => [
                'up' => __('Up', 'hq-widgets-for-elementor'),
                'down' => __('Down', 'hq-widgets-for-elementor'),
                'left' => __('Left', 'hq-widgets-for-elementor'),
                'right' => __('Right', 'hq-widgets-for-elementor'),
            ],
            'prefix_class' => 'hq-flipbox-dir-',
        ]);

        $this->end_controls_section();

        $this->start_controls_section('flipbox_front_style', [
            'label' => esc_html__('Front', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE
        ]);
        
        $this->add_group_control(Group_Control_Background::get_type(), [
            'name' => 'front_background',
            'types' => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .hq-flipbox-front-container',
        ]);

        $this->add_control('front_alignment', [
            'label' => __('Alignment', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'label_block' => false,
            'options' => [
                'left' => [
                    'title' => __('Left', 'hq-widgets-for-elementor'),
                    'icon' => 'fas fa-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'hq-widgets-for-elementor'),
                    'icon' => 'fas fa-align-center',
                ],
                'right' => [
                    'title' => __('Right', 'hq-widgets-for-elementor'),
                    'icon' => 'fas fa-align-right',
                ],
            ],
            'default' => 'center',
            'selectors' => [
                '{{WRAPPER}} .hq-flipbox-front-container .hq-flipbox-layer-inner' => 'text-align: {{VALUE}}',
            ],
            'separator' => 'before'
        ]);

        $this->add_control('front_vertical_position', [
            'label' => __('Vertical Position', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'label_block' => false,
            'options' => [
                'top' => [
                    'title' => __('Top', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-v-align-top',
                ],
                'middle' => [
                    'title' => __('Middle', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-v-align-middle',
                ],
                'bottom' => [
                    'title' => __('Bottom', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-v-align-bottom',
                ],
            ],
            'selectors_dictionary' => [
                'top' => 'flex-start',
                'middle' => 'center',
                'bottom' => 'flex-end',
            ],
            'selectors' => [
                '{{WRAPPER}} .hq-flipbox-front-container .hq-flipbox-layer-overlay' => 'justify-content: {{VALUE}}',
            ],
        ]);

        $this->add_responsive_control('front_padding', [
            'label' => esc_html__('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .hq-flipbox-front-container .hq-flipbox-layer-overlay' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('front_border_radius', [
            'label' => esc_html__('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .hq-flipbox-front-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'front_border',
            'label' => esc_html__('Border Style', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hq-flipbox-front-container',
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'front_box_shadow',
            'selector' => '{{WRAPPER}} .hq-flipbox-front-container'
        ]);

        $this->end_controls_section();

        $this->start_controls_section('flipbox_front_elements', [
            'label' => esc_html__('Front Elements', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->start_controls_tabs('front_elements_tabs');

        $this->start_controls_tab('front_text_tab', [
            'label' => __('Text', 'hq-widgets-for-elementor')
        ]);

        $this->add_control('front_text_title_heading', [
            'label' => esc_html__('Title', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'front_title_typography',
            'selector' => '{{WRAPPER}} .hq-flipbox-front-container .hq-flipbox-heading'
        ]);

        $this->add_control('front_title_color', [
            'label' => esc_html__('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-flipbox-front-container .hq-flipbox-heading' => 'color: {{VALUE}};',
            ]
        ]);

        $this->add_control('front_title_spacing', [
            'label' => __('Spacing', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .hq-flipbox-front-container .hq-flipbox-heading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('front_text_description_heading', [
            'label' => esc_html__('Description', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before'
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'front_description_typography',
            'selector' => '{{WRAPPER}} .hq-flipbox-front-container .hq-flipbox-description'
        ]);

        $this->add_control('front_description_color', [
            'label' => esc_html__('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-flipbox-front-container .hq-flipbox-description' => 'color: {{VALUE}};',
            ]
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('front_image_tab', [
            'label' => __('Image', 'hq-widgets-for-elementor'),
            'condition' => [
                'front_graphic_type' => 'image',
            ],
        ]);

        $this->add_control('front_image_spacing', [
            'label' => __('Spacing', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .hq-flipbox-front-container .hq-flipbox-image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('front_image_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 200,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}}.hq-flipbox-fit-image-yes .hq-flipbox-front-container .hq-flipbox-image, {{WRAPPER}} .hq-flipbox-front-container .hq-flipbox-image img' => 'border-radius: {{SIZE}}{{UNIT}}',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'front_image_border',
            'label' => __('Image Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}}.hq-flipbox-fit-image-yes .hq-flipbox-front-container .hq-flipbox-image, {{WRAPPER}} .hq-flipbox-front-container .hq-flipbox-image img',
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('front_icon_tab', [
            'label' => __('Icon', 'hq-widgets-for-elementor'),
            'condition' => [
                'front_graphic_type' => 'icon',
            ],
        ]);

        $this->add_responsive_control('front_icon_spacing', [
            'label' => __('Spacing', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .hq-flipbox-front-container .elementor-icon-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('front_icon_primary_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-flipbox-front-container .elementor-view-stacked .elementor-icon' => 'background-color: {{VALUE}}',
                '{{WRAPPER}} .hq-flipbox-front-container .elementor-view-framed .elementor-icon, {{WRAPPER}} .hq-flipbox-front-container .elementor-view-default .elementor-icon' => 'color: {{VALUE}}; border-color: {{VALUE}}',
                '{{WRAPPER}} .hq-flipbox-front-container .elementor-view-framed .elementor-icon svg, {{WRAPPER}} .hq-flipbox-front-container .elementor-view-default .elementor-icon svg' => 'fill: {{VALUE}};',
            ],
        ]);

        $this->add_responsive_control('front_icon_size', [
            'label' => __('Size', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 10,
                    'max' => 200,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .hq-flipbox-front-container .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section('flipbox_back_style', [
            'label' => esc_html__('Back', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name' => 'back_background',
            'types' => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .hq-flipbox-back-container',
        ]);

        $this->add_control('back_alignment', [
            'label' => __('Alignment', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'label_block' => false,
            'options' => [
                'left' => [
                    'title' => __('Left', 'hq-widgets-for-elementor'),
                    'icon' => 'fas fa-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'hq-widgets-for-elementor'),
                    'icon' => 'fas fa-align-center',
                ],
                'right' => [
                    'title' => __('Right', 'hq-widgets-for-elementor'),
                    'icon' => 'fas fa-align-right',
                ],
            ],
            'default' => 'center',
            'selectors' => [
                '{{WRAPPER}} .hq-flipbox-back-container .hq-flipbox-layer-inner' => 'text-align: {{VALUE}}',
            ],
            'separator' => 'before'
        ]);

        $this->add_control('back_vertical_position', [
            'label' => __('Vertical Position', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'label_block' => false,
            'options' => [
                'top' => [
                    'title' => __('Top', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-v-align-top',
                ],
                'middle' => [
                    'title' => __('Middle', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-v-align-middle',
                ],
                'bottom' => [
                    'title' => __('Bottom', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-v-align-bottom',
                ],
            ],
            'selectors_dictionary' => [
                'top' => 'flex-start',
                'middle' => 'center',
                'bottom' => 'flex-end',
            ],
            'selectors' => [
                '{{WRAPPER}} .hq-flipbox-back-container .hq-flipbox-layer-overlay' => 'justify-content: {{VALUE}}',
            ],
        ]);

        $this->add_responsive_control('back_padding', [
            'label' => esc_html__('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .hq-flipbox-back-container .hq-flipbox-layer-overlay' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('back_border_radius', [
            'label' => esc_html__('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .hq-flipbox-back-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'back_border',
            'label' => esc_html__('Border Style', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hq-flipbox-back-container',
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'back_box_shadow',
            'selector' => '{{WRAPPER}} .hq-flipbox-back-container'
        ]);

        $this->end_controls_section();

        $this->start_controls_section('flipbox_back_elements', [
            'label' => esc_html__('Back Elements', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->start_controls_tabs('back_text_tabs');

        $this->start_controls_tab('back_title_tab', [
            'label' => __('Title', 'hq-widgets-for-elementor')
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'back_title_typography',
            'selector' => '{{WRAPPER}} .hq-flipbox-back-container .hq-flipbox-heading'
        ]);

        $this->add_control('back_title_color', [
            'label' => esc_html__('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-flipbox-back-container .hq-flipbox-heading' => 'color: {{VALUE}};',
            ]
        ]);

        $this->add_control('back_title_spacing', [
            'label' => __('Spacing', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .hq-flipbox-back-container .hq-flipbox-heading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('back_description_tab', [
            'label' => __('Description', 'hq-widgets-for-elementor')
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'back_description_typography',
            'selector' => '{{WRAPPER}} .hq-flipbox-back-container .hq-flipbox-description'
        ]);

        $this->add_control('back_description_color', [
            'label' => esc_html__('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-flipbox-back-container .hq-flipbox-description' => 'color: {{VALUE}};',
            ]
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control('separator_back_button', [
            'type' => Controls_Manager::DIVIDER,
            'condition' => [
                'flipbox_link_type' => 'button'
            ]
        ]);

        $this->add_control('back_button_heading', [
            'label' => esc_html__('Button', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'condition' => [
                'flipbox_link_type' => 'button'
            ]
        ]);

        $this->add_control('back_button_spacing', [
            'label' => __('Spacing', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .hq-flipbox-back-container .hq-flipbox-button' => 'margin-top: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'flipbox_link_type' => 'button'
            ]
        ]);

        $this->start_controls_tabs('back_button_tabs', [
            'condition' => [
                'flipbox_link_type' => 'button'
            ]
        ]);

        $this->start_controls_tab('back_button_normal_tab', [
            'label' => esc_html__('Normal', 'hq-widgets-for-elementor'),
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'back_button_typography',
            'label' => esc_html__('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hq-flipbox-back-container .hq-flipbox-button',
        ]);

        $this->add_control('back_button_text_color', [
            'label' => esc_html__('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-flipbox-back-container .hq-flipbox-button' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('back_button_icon_color', [
            'label' => esc_html__('Icon Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-flipbox-back-container .hq-flipbox-button i' => 'color: {{VALUE}};',
            ],
            'condition' => [
                'flipbox_link_type' => 'button',
                'flipbox_button_icon[value]!' => '',
            ],
        ]);

        $this->add_control('back_button_background_color', [
            'label' => esc_html__('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-flipbox-back-container .hq-flipbox-button' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('back_button_border_radius', [
            'label' => esc_html__('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .hq-flipbox-back-container .hq-flipbox-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('back_button_padding', [
            'label' => esc_html__('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .hq-flipbox-back-container .hq-flipbox-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'back_button_border',
            'label' => esc_html__('Border', 'hq-widgets-for-elementor'),
            'placeholder' => '1px',
            'default' => '1px',
            'selector' => '{{WRAPPER}} .hq-flipbox-back-container .hq-flipbox-button',
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'back_button_box_shadow',
            'selector' => '{{WRAPPER}} .hq-flipbox-back-container .hq-flipbox-button',
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('back_button_hover_tab', [
            'label' => esc_html__('Hover', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('back_button_text_hover_color', [
            'label' => esc_html__('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-flipbox-back-container .hq-flipbox-button:hover' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('back_button_icon_hover_color', [
            'label' => esc_html__('Icon Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-flipbox-back-container .hq-flipbox-button:hover i' => 'color: {{VALUE}};',
            ],
            'condition' => [
                'flipbox_link_type' => 'button',
                'flipbox_button_icon[value]!' => '',
            ],
        ]);

        $this->add_control('back_button_background_hover_color', [
            'label' => esc_html__('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-flipbox-back-container .hq-flipbox-button:hover' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('back_button_border_hover_color', [
            'label' => esc_html__('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-flipbox-back-container .hq-flipbox-button:hover' => 'border-color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'back_button_hover_box_shadow',
            'selector' => '{{WRAPPER}} .hq-flipbox-back-container .hq-flipbox-button:hover',
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        $flipbox_html_tag = 'div';
        $flipbox_back_title_tag = 'h2';

        $this->add_render_attribute('hq_flipbox_wrapper', 'class', 'hq-flipbox-wrapper');
        $this->add_render_attribute('hq_flipbox_front', [
            'class' => [
                'hq-flipbox-container',
                'hq-flipbox-front-container',
            ],
        ]);
        $this->add_render_attribute('hq_flipbox_back', [
            'class' => [
                'hq-flipbox-container',
                'hq-flipbox-back-container',
            ],
        ]);

        $this->add_render_attribute('hq_flipbox_back_title', 'class', 'hq-flipbox-heading');
        $this->add_render_attribute('hq_flipbox_front_image', 'class', 'hq-flipbox-image');

        if (isset($settings['front_image_fit']) && 'yes' === $settings['front_image_fit']) {
            $frontImageSrc = Group_Control_Image_Size::get_attachment_image_src($settings['image']['id'], 'image', $settings);
            $this->add_render_attribute('hq_flipbox_front_image', 'style', 'background-image: url("' . $frontImageSrc . '");');
        }

        if ($settings['flipbox_link_type'] != 'none') {
            if (!empty($settings['flipbox_link']['url'])) {
                if ($settings['flipbox_link_type'] == 'box') {
                    $flipbox_html_tag = 'a';

                    $this->add_render_attribute('hq_flipbox_wrapper', 'href', esc_url($settings['flipbox_link']['url']));

                    if ($settings['flipbox_link']['is_external']) {
                        $this->add_render_attribute('hq_flipbox_wrapper', 'target', '_blank');
                    }

                    if ($settings['flipbox_link']['nofollow']) {
                        $this->add_render_attribute('hq_flipbox_wrapper', 'rel', 'nofollow');
                    }
                } elseif ($settings['flipbox_link_type'] == 'title') {
                    $flipbox_back_title_tag = 'a';

                    $this->add_render_attribute(
                            'hq_flipbox_back_title',
                            [
                                'class' => 'flipbox-linked-title',
                                'href' => $settings['flipbox_link']['url']
                            ]
                    );

                    if ($settings['flipbox_link']['is_external']) {
                        $this->add_render_attribute('hq_flipbox_back_title', 'target', '_blank');
                    }

                    if ($settings['flipbox_link']['nofollow']) {
                        $this->add_render_attribute('hq_flipbox_back_title', 'rel', 'nofollow');
                    }
                } elseif ($settings['flipbox_link_type'] == 'button') {
                    $btnAnimation = !empty($settings['back_button_hover_animation']) ? ' elementor-animation-' . $settings['back_button_hover_animation'] : '';
                    $btnSize = !empty($settings['flipbox_button_size']) ? ' elementor-size-' . $settings['flipbox_button_size'] : '';
                    $this->add_render_attribute('hq_flipbox_button', [
                        'class' => [
                            'hq-flipbox-button',
                            'elementor-button',
                            $btnSize,
                            $btnAnimation,
                        ],
                        'href' => !empty($settings['flipbox_link']['url']) ? $settings['flipbox_link']['url'] : '#',
                    ]);

                    if ($settings['flipbox_link']['is_external']) {
                        $this->add_render_attribute('hq_flipbox_button', 'target', '_blank');
                    }

                    if ($settings['flipbox_link']['nofollow']) {
                        $this->add_render_attribute('hq_flipbox_button', 'rel', 'nofollow');
                    }
                }
            }
        }

        if ('icon' === $settings['front_graphic_type']) {
            $this->add_render_attribute('icon_wrapper', 'class', [
                'elementor-icon-wrapper',
                (!empty($settings['front_icon_view']) ? 'elementor-view-' . $settings['front_icon_view'] : ''),
            ]);
            if (!empty($settings['front_icon_view']) && 'default' != $settings['front_icon_view']) {
                $this->add_render_attribute('icon_wrapper', 'class', 'elementor-shape-' . $settings['front_icon_shape']);
            }
        }
        ?>

        <<?php echo $flipbox_html_tag, ' ', $this->get_render_attribute_string('hq_flipbox_wrapper'); ?>>
        <div <?php echo $this->get_render_attribute_string('hq_flipbox_front'); ?>>
            <div class="hq-flipbox-layer-overlay">
                <div class="hq-flipbox-layer-inner">
                    <?php if ('image' === $settings['front_graphic_type']) : ?>
                        <div <?php echo $this->get_render_attribute_string('hq_flipbox_front_image'); ?>>
                            <?php
                            if (!empty($settings['image']['url']) && (!isset($settings['front_image_fit']) || 'yes' == !$settings['front_image_fit'])) {
                                echo Group_Control_Image_Size::get_attachment_image_html($settings);
                            }
                            ?>
                        </div>
                    <?php elseif ('icon' === $settings['front_graphic_type'] && !empty($settings['front_icon']['value'])) : ?>
                        <div <?php echo $this->get_render_attribute_string('icon_wrapper'); ?>>
                            <div class="elementor-icon">
                                <?php Icons_Manager::render_icon($settings['front_icon'], ['aria-hidden' => 'true']); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <h2 class="hq-flipbox-heading"><?php echo esc_html__($settings['front_title'], 'hq-widgets-for-elementor'); ?></h2>
                    <div class="hq-flipbox-description">
                        <p><?php _e($settings['front_description'], 'hq-widgets-for-elementor'); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div <?php echo $this->get_render_attribute_string('hq_flipbox_back'); ?>>
            <div class="hq-flipbox-layer-overlay">
                <div class="hq-flipbox-layer-inner">
                    <<?php echo $flipbox_back_title_tag, ' ', $this->get_render_attribute_string('hq_flipbox_back_title'); ?>>
                    <?php echo esc_html__($settings['back_title'], 'hq-widgets-for-elementor'); ?>
                    </<?php echo $flipbox_back_title_tag; ?>>
                    <div class="hq-flipbox-description">
                        <p><?php _e($settings['back_description'], 'hq-widgets-for-elementor'); ?></p>
                    </div>

                    <?php if ($settings['flipbox_link_type'] == 'button' && !empty($settings['flipbox_button_text'])) : ?>
                        <a <?php echo $this->get_render_attribute_string('hq_flipbox_button'); ?>>
                            <?php if (isset($settings['flipbox_button_icon']) && 'before' == $settings['flipbox_button_icon_position']) : ?>
                                <?php if (!empty($settings['flipbox_button_icon']['value'])) { ?>
                                    <?php Icons_Manager::render_icon($settings['flipbox_button_icon'], ['aria-hidden' => 'true']); ?>
                                <?php } ?>
                            <?php endif; ?>
                            <?php echo esc_html($settings['flipbox_button_text']); ?>
                            <?php if (isset($settings['flipbox_button_icon']) && 'after' == $settings['flipbox_button_icon_position']) : ?>
                                <?php if (!empty($settings['flipbox_button_icon']['value'])) { ?>
                                    <?php Icons_Manager::render_icon($settings['flipbox_button_icon'], ['aria-hidden' => 'true']); ?>
                                <?php } ?>
                            <?php endif; ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        </<?php echo $flipbox_html_tag; ?>>

        <?php
    }

}
