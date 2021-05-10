<?php

namespace HQWidgetsForElementor\Widget\Theme;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use const HQWidgetsForElementor\PLUGIN_SLUG;

class Breadcrumbs extends Widget_Base {

    public function get_name() {
        return 'hq-theme-breadcrumbs';
    }

    public function get_title() {
        return __('Breadcrumbs', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-arrows';
    }

    public function get_categories() {
        return [PLUGIN_SLUG];
    }

    public function get_keywords() {
        return ['yoast', 'rank math', 'seo', 'breadcrumbs', 'internal links'];
    }

    protected function _register_controls() {
        $this->start_controls_section('section_breadcrumbs_content', [
            'label' => __('Breadcrumbs', 'hq-widgets-for-elementor'),
        ]);

        // Select SEO Plugin
        $this->add_control('seo_plugin', [
            'label' => __('SEO Plugin', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'yoast' => __('Yoast', 'hq-widgets-for-elementor'),
                'rank_math' => 'Rank Math',
            ],
            'default' => 'yoast',
        ]);

        // Warning Yoast
        if (!function_exists('yoast_breadcrumb')) {
            $this->add_control('yoast_disabled_alert', [
                'raw' => __('Breadcrumbs are disabled in the Yoast SEO.', 'hq-widgets-for-elementor') . ' ' . sprintf('<a href="%s" target="_blank">%s</a>', esc_url(admin_url('admin.php?page=wpseo_titles#top#breadcrumbs')), __('Breadcrumbs Panel', 'hq-widgets-for-elementor')),
                'type' => Controls_Manager::RAW_HTML,
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-danger',
                'condition' => [
                    'seo_plugin' => 'yoast',
                ],
            ]);
        }

        // Warning Rank Math
        if (!function_exists('rank_math_the_breadcrumbs')) {
            $this->add_control('rank_math_disabled_alert', [
                'raw' => __('Rank Math is disabled.', 'hq-widgets-for-elementor') . ' ' . sprintf('<a href="%s" target="_blank">%s</a>', esc_url(admin_url('plugins.php')), __('Plugins', 'hq-widgets-for-elementor')),
                'type' => Controls_Manager::RAW_HTML,
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-danger',
                'condition' => [
                    'seo_plugin' => 'rank_math',
                ],
            ]);
        }

        $this->add_responsive_control('align', [
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
            'prefix_class' => 'elementor%s-align-',
        ]);

        $this->add_control('html_tag', [
            'label' => __('HTML Tag', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'p' => 'p',
                'div' => 'div',
                'nav' => 'nav',
                'span' => 'span',
            ],
            'default' => 'nav',
        ]);

        $description = __('Additional settings are available in the Yoast SEO and Rank Math plugins.', 'hq-widgets-for-elementor');
        if (function_exists('yoast_breadcrumb')) {
            $description .= '<br />' . sprintf('<a href="%s" target="_blank">%s</a>', esc_url(admin_url('admin.php?page=wpseo_titles#top#breadcrumbs')), __('Yoast Breadcrumbs Panel', 'hq-widgets-for-elementor'));
        }
        if (function_exists('rank_math_the_breadcrumbs')) {
            $description .= '<br />' . sprintf('<a href="%s" target="_blank">%s</a>', esc_url(admin_url('admin.php?page=rank-math-options-general#setting-panel-breadcrumbs')), __('Rank Math Breadcrumbs Panel', 'hq-widgets-for-elementor'));
        }
        $this->add_control('html_description', [
            'raw' => $description,
            'type' => Controls_Manager::RAW_HTML,
            'content_classes' => 'elementor-descriptor',
        ]);

        $this->end_controls_section();

        $this->start_controls_section('section_style', [
            'label' => __('Breadcrumbs', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'typography',
            'selector' => '{{WRAPPER}}',
        ]);

        $this->add_control('text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}}' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('heading_links', [
            'label' => esc_html__('Links', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);

        $this->start_controls_tabs('tabs_breadcrumbs_links');

        $this->start_controls_tab('link_color_normal_tab', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
        ]);
        
        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'link_typography',
            'selector' => '{{WRAPPER}} a',
        ]);

        $this->add_control('link_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} a' => 'color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('link_color_hover_tab', [
            'label' => __('Hover', 'hq-widgets-for-elementor'),
        ]);
        
        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'link_hover_typography',
            'selector' => '{{WRAPPER}} a:hover',
        ]);

        $this->add_control('link_hover_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} a:hover' => 'color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();

        $has_function = 0;
        if ($settings['seo_plugin'] == 'yoast') {
            if (function_exists('yoast_breadcrumb')) {
                $has_function = 1;
                yoast_breadcrumb('<' . $settings['html_tag'] . ' class="yoast-breadcrumb" id="breadcrumbs">', '</' . $settings['html_tag'] . '>');
            }
        } elseif ($settings['seo_plugin'] == 'rank_math') {
            if (function_exists('rank_math_the_breadcrumbs')) {
                $has_function = 1;
                rank_math_the_breadcrumbs([
                    'wrap_before' => '<' . $settings['html_tag'] . ' class="rank-math-breadcrumb" id="breadcrumbs">',
                    'wrap_after' => '</' . $settings['html_tag'] . '>',
                ]);
            }
        }
        if (!$has_function) {
            echo 'Breadcrumbs: You need to install Yoast or Rank Math plugin.';
        }
    }

}
