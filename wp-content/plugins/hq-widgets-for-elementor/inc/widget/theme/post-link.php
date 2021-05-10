<?php

namespace HQWidgetsForElementor\Widget\Theme;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Widget_Base;
use const HQWidgetsForElementor\PLUGIN_SLUG;
use const HQWidgetsForElementor\PLUGIN_URL;
use const HQWidgetsForElementor\VERSION;

class Post_Link extends Widget_Base {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        wp_register_style('hq-theme-post-link', PLUGIN_URL . 'assets/widgets/theme/post-link/style.css', [], VERSION);
    }

    public function get_name() {
        return 'hq-theme-post-link';
    }

    public function get_title() {
        return __('Post Link', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-link';
    }

    public function get_style_depends() {
        return ['hq-theme-post-link'];
    }

    public function get_categories() {
        return [PLUGIN_SLUG];
    }

    public function get_keywords() {
        return ['link', 'post', 'read', 'more', 'details'];
    }

    protected function _register_controls() {
        $this->start_controls_section('section_link', [
            'label' => __('Button', 'hq-widgets-for-elementor'),
        ]);

        $this->add_responsive_control('alignment', [
            'label' => __('Alignment', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'prefix_class' => 'post-link--justify-',
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
            'toggle' => false,
        ]);

        $this->add_control('link_text', [
            'label' => __('Link text', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Read More', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('show_icon', [
            'label' => __('Icon', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Show', 'hq-widgets-for-elementor'),
            'label_off' => __('Hide', 'hq-widgets-for-elementor'),
            'separator' => 'before',
        ]);

        $this->add_control('link_icon', [
            'label' => __('Choose Icon', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-long-arrow-alt-right',
                'library' => 'solid'
            ],
            'condition' => [
                'show_icon' => 'yes',
            ],
        ]);

        $this->add_control('link_icon_position', [
            'label' => __('Position', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'label_block' => false,
            'prefix_class' => 'post-link--icon-',
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
            'default' => 'right',
            'toggle' => false,
            'condition' => [
                'show_icon' => 'yes',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('section_style_link', [
            'label' => __('Button', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'link_typography',
            'selector' => '{{WRAPPER}} .post-link__button',
        ]);

        $this->add_group_control(Group_Control_Text_Shadow::get_type(), [
            'name' => 'link_text_shadow',
            'selector' => '{{WRAPPER}} .post-link__button'
        ]);

        $this->start_controls_tabs('link_tabs', []);

        $this->start_controls_tab('tab_link_normal', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('link_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .post-link__button' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('link_background', [
            'label' => __('Background', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .post-link__button' => 'background-color: {{VALUE}};',
            ]
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'link_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .post-link__button'
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('tab_link_hover', [
            'label' => __('Hover', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('link_hover_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .post-link__button:hover' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('link_hover_background', [
            'label' => __('Background', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .post-link__button:hover' => 'background-color: {{VALUE}};',
            ]
        ]);

        $this->add_control('link_border_hover_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .post-link__button:hover' => 'border-color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control('link_padding', [
            'label' => esc_html__('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .post-link__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
            ],
            'separator' => 'before',
        ]);

        $this->add_responsive_control('link_margin', [
            'label' => esc_html__('Margin', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .post-link__wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
            ]
        ]);

        $this->add_control('link_border_radius', [
            'label' => esc_html__('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default' => [
                'top' => (int) filter_var(get_theme_mod('hq_forms_border_radius', 4), FILTER_SANITIZE_NUMBER_INT),
                'right' => (int) filter_var(get_theme_mod('hq_forms_border_radius', 4), FILTER_SANITIZE_NUMBER_INT),
                'bottom' => (int) filter_var(get_theme_mod('hq_forms_border_radius', 4), FILTER_SANITIZE_NUMBER_INT),
                'left' => (int) filter_var(get_theme_mod('hq_forms_border_radius', 4), FILTER_SANITIZE_NUMBER_INT),
            ],
            'selectors' => [
                '{{WRAPPER}} .post-link__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;'
            ]
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'link_box_shadow',
            'selector' => '{{WRAPPER}} .post-link__button'
        ]);

        $this->end_controls_section();

        $this->start_controls_section('section_style_icon', [
            'label' => __('Icon', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'show_icon' => 'yes'
            ]
        ]);

        $this->start_controls_tabs('tabs_link_icon_style');

        $this->start_controls_tab('tab_link_icon_normal', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('link_icon_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .post-link__button .post-link__icon' => 'color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('tab_link_icon_hover', [
            'label' => __('Hover', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('link_icon_hover_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .post-link__button:hover .post-link__icon' => 'color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control('link_icon_size', [
            'label' => __('Size', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 10,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .post-link__icon' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('icon_gap', [
            'label' => __('Offset', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 50,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 10,
            ],
            'selectors' => [
                '{{WRAPPER}}.post-link--icon-left .post-link__icon' => 'margin-right: {{SIZE}}{{UNIT}}',
                '{{WRAPPER}}.post-link--icon-right .post-link__icon' => 'margin-left: {{SIZE}}{{UNIT}}',
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $icon = '';
        if ('yes' == $settings['show_icon']) {
            ob_start();
            Icons_Manager::render_icon($this->get_settings('link_icon'), ['class' => 'post-link__icon']);
            $icon = ob_get_clean();
        }
        ?>
        <div class="post-link__wrapper">
            <a href="<?php echo get_the_permalink(); ?>" class="post-link__button">
                <span class="post-link__text"><?php echo esc_html($settings['link_text']); ?></span>
                <?php echo $icon; ?>
            </a>
        </div>
        <?php
    }

}
