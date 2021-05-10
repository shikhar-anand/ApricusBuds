<?php

namespace HQWidgetsForElementor\Widget\Theme;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;
use const HQWidgetsForElementor\PLUGIN_SLUG;

class Post_Excerpt extends Posts {

    public function get_name() {
        return 'hq-theme-post-excerpt';
    }

    public function get_title() {
        return __('Post Excerpt', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-document-add';
    }

    public function get_categories() {
        return [PLUGIN_SLUG];
    }

    public function get_keywords() {
        return ['post', 'excerpt', 'description'];
    }

    protected function _register_controls() {

        $this->register_test_post_item_section_controls();

        $this->start_controls_section(
                'section_style', [
            'label' => __('Style', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_responsive_control(
                'alignment', [
            'label' => __('Alignment', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'label_block' => false,
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
                    'title' => __('Justify', 'hq-widgets-for-elementor'),
                    'icon' => 'fa fa-align-justify',
                ],
            ],
            'default' => 'left',
            'selectors' => [
                '{{WRAPPER}} .elementor-widget-container' => 'text-align: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'typography',
            'selector' => '{{WRAPPER}} .elementor-widget-container',
                ]
        );

        $this->add_control(
                'title_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elementor-widget-container' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'margin', [
            'label' => __('Paragraph Margin', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .elementor-widget-container p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        // Prepare post for editor mode
        if (Plugin::instance()->editor->is_edit_mode()) {
            if (empty($settings['test_post_item'])) {
                ?>
                <div class="elementor-alert elementor-alert-info" role="alert">
                    <span class="elementor-alert-title">
                        <?php esc_html_e('Please select Test Item', 'hq-widgets-for-elementor'); ?>
                    </span>
                    <span class="elementor-alert-description">
                        <?php esc_html_e('Test Item is used only in edit mode for better customization. On live page it will be ignored.', 'hq-widgets-for-elementor'); ?>
                    </span>
                </div>
                <?php
                return;
            }
            Plugin::instance()->db->switch_to_post($settings['test_post_item']);
        }

        the_excerpt();

        // Rollback to the previous global post
        if (Plugin::instance()->editor->is_edit_mode()) {
            Plugin::instance()->db->restore_current_post();
        }
    }

}
