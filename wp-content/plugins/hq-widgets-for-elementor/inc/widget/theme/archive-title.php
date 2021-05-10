<?php

namespace HQWidgetsForElementor\Widget\Theme;

defined('ABSPATH') || exit;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use HQWidgetsForElementor\Widget\Title_Base;
use const HQWidgetsForElementor\PLUGIN_SLUG;

class Archive_Title extends Title_Base {

    public function get_name() {
        return 'hq-theme-archive-title';
    }

    public function get_title() {
        return __('Archive Title', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-text-tool';
    }

    public function get_style_depends() {
        return ['hqt-widgets'];
    }

    public function get_categories() {
        return [PLUGIN_SLUG];
    }

    public function get_keywords() {
        return ['title', 'heading', 'archive', 'search', 'custom post type', 'cpt'];
    }

    protected function _register_controls() {
        parent::register_title_controls();
        $this->start_controls_section(
                'section_prefix', [
            'label' => __('Prefix', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'prefix', [
            'label' => __('Prefix', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'show' => __('Show', 'hq-widgets-for-elementor'),
                'hide' => __('Hide', 'hq-widgets-for-elementor'),
                'replace' => __('Replace with', 'hq-widgets-for-elementor'),
            ],
            'default' => 'show',
                ]
        );
        $this->add_control(
                'prefix_replace', [
            'label' => __('Replace Prefix With', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'separator' => 'after',
            'condition' => [
                'prefix' => 'replace'
            ],
                ]
        );

        $this->end_controls_section();




        $this->start_controls_section(
                'section_prefix_style', [
            'label' => __('Prefix', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'prefix_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                // Stronger selector to avoid section style from overwriting
                '{{WRAPPER}} .elementor-heading-title span, {{WRAPPER}} .elementor-heading-title a span' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'prefix_typography',
            'selector' => '{{WRAPPER}} .elementor-heading-title span, {{WRAPPER}} .elementor-heading-title span a',
                ]
        );

        $this->add_group_control(
                Group_Control_Text_Shadow::get_type(), [
            'name' => 'prefix_shadow',
            'selector' => '{{WRAPPER}} .elementor-heading-title span',
                ]
        );

        $this->add_control(
                'prefix_blend_mode', [
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
                '{{WRAPPER}} .elementor-heading-title span' => 'mix-blend-mode: {{VALUE}}',
            ],
            'separator' => 'none',
                ]
        );

        $this->add_responsive_control(
                'prefix_margin', [
            'label' => esc_html__('Margin', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .elementor-heading-title span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
            ]
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'prefix_border',
            'selector' => '{{WRAPPER}} .elementor-heading-title span'
                ]
        );

        $this->end_controls_section();

        parent::register_description_controls();
    }

    protected function render() {
        $this->_render_title();
        $this->_render_description();
    }

    protected function _render_title() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('title', 'class', 'elementor-heading-title');
        if ('yes' == $settings['truncate']) {
            $this->add_render_attribute('title', 'class', 'text-truncate');
        }

        add_filter('get_the_archive_title', [$this, 'get_the_archive_title'], 10, 3);

        $title_html = get_the_archive_title();

        $title_html = sprintf('<%1$s %2$s>' . $title_html . '</%1$s>', $settings['header_size'], $this->get_render_attribute_string('title'));

        echo $title_html;
    }

    public function get_the_archive_title($title, $original_title, $prefix) {
        $settings = $this->get_settings_for_display();

        if (is_search()) {
            $prefix = __('Search results for', 'hq-widgets-for-elementor');
            $prefix = apply_filters('get_the_archive_title_prefix', $prefix);
            $original_title = sprintf(__('&#8220;%1$s&#8221;', 'hq-widgets-for-elementor'), get_search_query(false));
        }

        if ('hide' === $settings['prefix']) {
            $prefix = '';
        } elseif ('replace' === $settings['prefix']) {
            $prefix = $settings['prefix_replace'];
        }

        if ($prefix) {
            $title = sprintf(
                    '<span>%1$s</span> %2$s',
                    $prefix,
                    $original_title
            );
        } else {
            $title = $original_title;
        }

        return $title;
    }

    protected function _render_description() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('description', 'class', 'elementor-heading-description');

        $beforeDescription = '<%1$s %2$s>';
        $afterDescription = '</%1$s>';

        if (Plugin::instance()->editor->is_edit_mode()) {
            // Test description
            $description_html = sprintf($beforeDescription . __('Lorem ipsum dolor sit amet', 'hq-widgets-for-elementor') . $afterDescription, $settings['header_description_size'], $this->get_render_attribute_string('description'));
        } elseif (is_home() || is_category()) {
            $description_html = sprintf($beforeDescription . get_the_archive_description() . $afterDescription, $settings['header_description_size'], $this->get_render_attribute_string('description'));
        } else {
            return;
        }

        echo $description_html;
    }

}
