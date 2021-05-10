<?php

namespace HQWidgetsForElementor\Widget\Theme;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Plugin;
use HQLib\Utils;
use HQWidgetsForElementor\Widget\Posts_Base;
use const HQWidgetsForElementor\ELEMENTOR_BASE_UPLOADS;
use const HQWidgetsForElementor\PLUGIN_SLUG;
use const HQWidgetsForElementor\VERSION;

class Post_Navigation extends Posts_Base {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        wp_register_style('hq-theme-post-navigation', ELEMENTOR_BASE_UPLOADS . 'css/hq-theme-post-navigation.css', [], VERSION);
    }

    public function get_name() {
        return 'hq-theme-post-navigation';
    }

    public function get_title() {
        return __('Post Navigation', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-transfer';
    }

    public function get_categories() {
        return [PLUGIN_SLUG];
    }

    public function get_style_depends() {
        return ['hq-theme-post-navigation'];
    }

    public function get_keywords() {
        return ['post', 'navigation', 'menu', 'links'];
    }

    protected function _register_controls() {
        $this->register_test_post_item_section_controls();

        $this->start_controls_section('section_post_navigation_content', [
            'label' => __('Post Navigation', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('show_label', [
            'label' => __('Labels', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Show', 'hq-widgets-for-elementor'),
            'label_off' => __('Hide', 'hq-widgets-for-elementor'),
            'default' => 'no',
            'return_value' => 'yes',
        ]);

        $this->add_control('prev_label', [
            'label' => __('Previous Label', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Previous', 'hq-widgets-for-elementor'),
            'condition' => [
                'show_label' => 'yes',
            ],
        ]);

        $this->add_control('next_label', [
            'label' => __('Next Label', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Next', 'hq-widgets-for-elementor'),
            'condition' => [
                'show_label' => 'yes',
            ],
            'separator' => 'after',
        ]);
        
        $this->add_control('hide_label_on_desktop', [
            'label' => __('Hide on Desktop', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'prefix_class' => 'post-navigation-hide-label-on-desktop-',
            'label_on' => __('Yes', 'hq-widgets-for-elementor'),
            'label_off' => __('No', 'hq-widgets-for-elementor'),
            'default' => 'no',
            'condition' => [
                'show_label' => 'yes',
            ],
        ]);
        
        $this->add_control('hide_label_on_tablet', [
            'label' => __('Hide on Tablet', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'prefix_class' => 'post-navigation-hide-label-on-tablet-',
            'label_on' => __('Yes', 'hq-widgets-for-elementor'),
            'label_off' => __('No', 'hq-widgets-for-elementor'),
            'default' => 'no',
            'condition' => [
                'show_label' => 'yes',
            ],
        ]);

        $this->add_control('show_icons', [
            'label' => __('Icons', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Show', 'hq-widgets-for-elementor'),
            'label_off' => __('Hide', 'hq-widgets-for-elementor'),
            'default' => 'yes',
        ]);

        $this->add_control('icon_prev', [
            'label' => __('Icon Prev', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-long-arrow-alt-left',
                'library' => 'solid'
            ],
            'condition' => [
                'show_icons' => 'yes',
            ],
        ]);

        $this->add_control('icon_next', [
            'label' => __('Choose Next', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-long-arrow-alt-right',
                'library' => 'solid'
            ],
            'separator' => 'after',
            'condition' => [
                'show_icons' => 'yes',
            ],
        ]);

        $this->add_control('show_title', [
            'label' => __('Post Title', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Show', 'hq-widgets-for-elementor'),
            'label_off' => __('Hide', 'hq-widgets-for-elementor'),
            'default' => 'yes',
        ]);
        
        $this->add_control('hide_title_on_tablet', [
            'label' => __('Hide on Tablet', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'prefix_class' => 'post-navigation-hide-title-on-tablet-',
            'label_on' => __('Yes', 'hq-widgets-for-elementor'),
            'label_off' => __('No', 'hq-widgets-for-elementor'),
            'default' => 'no',
            'separator' => 'after',
            'condition' => [
                'show_title' => 'yes',
            ],
        ]);

        $this->add_control('hide_title_on_mobile', [
            'label' => __('Hide on Mobile', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'prefix_class' => 'post-navigation-hide-title-on-mobile-',
            'label_on' => __('Yes', 'hq-widgets-for-elementor'),
            'label_off' => __('No', 'hq-widgets-for-elementor'),
            'default' => 'no',
            'condition' => [
                'show_title' => 'yes',
            ],
        ]);

        $this->add_control('show_borders', [
            'label' => __('Borders', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Show', 'hq-widgets-for-elementor'),
            'label_off' => __('Hide', 'hq-widgets-for-elementor'),
            'default' => 'yes',
            'prefix_class' => 'elementor-post-navigation-borders-',
        ]);

        // Filter out post type without taxonomies
        $post_type_options = [];
        $post_type_taxonomies = [];

        foreach (Utils::get_post_types() as $post_type => $post_type_label) {
            $taxonomies = Utils::get_taxonomies(['object_type' => $post_type], false);
            if (empty($taxonomies)) {
                continue;
            }

            $post_type_options[$post_type] = $post_type_label;
            $post_type_taxonomies[$post_type] = [];
            foreach ($taxonomies as $taxonomy) {
                $post_type_taxonomies[$post_type][$taxonomy->name] = $taxonomy->label;
            }
        }


        $this->add_control('in_same_term', [
            'label' => __('In same Term', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT2,
            'options' => $post_type_options,
            'default' => '',
            'multiple' => true,
            'label_block' => true,
            'description' => __('Whether other posts must be within the same taxonomy term as the current post, this lets you set a taxonomy per each post type.', 'hq-widgets-for-elementor'),
        ]);

        foreach ($post_type_options as $post_type => $post_type_label) {
            $this->add_control($post_type . '_taxonomy', [
                'label' => $post_type_label . ' ' . __('Taxonomy', 'hq-widgets-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => $post_type_taxonomies[$post_type],
                'default' => '',
                'condition' => [
                    'in_same_term' => $post_type,
                ],
            ]);
        }

        $this->end_controls_section();

        $this->start_controls_section('label_style', [
            'label' => __('Label', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'show_label' => 'yes',
            ],
        ]);

        $this->start_controls_tabs('tabs_label_style');

        $this->start_controls_tab('label_color_normal', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('label_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} span.post-navigation__prev--label' => 'color: {{VALUE}};',
                '{{WRAPPER}} span.post-navigation__next--label' => 'color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('label_color_hover', [
            'label' => __('Hover', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('label_hover_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} span.post-navigation__prev--label:hover' => 'color: {{VALUE}};',
                '{{WRAPPER}} span.post-navigation__next--label:hover' => 'color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'label_typography',
            'selector' => '{{WRAPPER}} span.post-navigation__prev--label, {{WRAPPER}} span.post-navigation__next--label',
        ]);

        $this->end_controls_section();

        $this->start_controls_section('title_style', [
            'label' => __('Title', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'show_title' => 'yes',
            ],
        ]);

        $this->start_controls_tabs('tabs_post_navigation_style');

        $this->start_controls_tab('tab_color_normal', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('text_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} span.post-navigation__prev--title, {{WRAPPER}} span.post-navigation__next--title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('tab_color_hover', [
            'label' => __('Hover', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('hover_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} span.post-navigation__prev--title:hover, {{WRAPPER}} span.post-navigation__next--title:hover' => 'color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'title_typography',
            'selector' => '{{WRAPPER}} span.post-navigation__prev--title, {{WRAPPER}} span.post-navigation__next--title',
        ]);

        $this->end_controls_section();

        $this->start_controls_section('arrow_style', [
            'label' => __('Icons', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'show_icons' => 'yes',
            ],
        ]);

        $this->start_controls_tabs('tabs_post_navigation_icon_style');

        $this->start_controls_tab('arrow_color_normal', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('arrow_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .post-navigation__icon-wrapper' => 'color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('arrow_color_hover', [
            'label' => __('Hover', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('arrow_hover_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .post-navigation__icon-wrapper:hover' => 'color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control('arrow_size', [
            'label' => __('Size', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 6,
                    'max' => 300,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .post-navigation__icon-wrapper' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('arrow_padding', [
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
                'size' => 5
            ],
            'selectors' => [
                'body:not(.rtl) {{WRAPPER}} .post-navigation__icon-prev' => 'padding-right: {{SIZE}}{{UNIT}};',
                'body:not(.rtl) {{WRAPPER}} .post-navigation__icon-next' => 'padding-left: {{SIZE}}{{UNIT}};',
                'body.rtl {{WRAPPER}} .post-navigation__icon-prev' => 'padding-left: {{SIZE}}{{UNIT}};',
                'body.rtl {{WRAPPER}} .post-navigation__icon-next' => 'padding-right: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('borders_section_style', [
            'label' => __('Borders', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'show_borders!' => '',
            ],
        ]);

        $this->add_control('sep_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '#dddddd',
            'selectors' => [
                '{{WRAPPER}} .hq-post-navigation__separator' => 'background-color: {{VALUE}};',
                '{{WRAPPER}} .hq-post-navigation-widget' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_responsive_control('borders_width', [
            'label' => __('Borders Width', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .hq-post-navigation-widget' => 'border-top-width: {{SIZE}}{{UNIT}}; border-bottom-width: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('separator_width', [
            'label' => __('Separator Size', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .hq-post-navigation__separator' => 'width: {{SIZE}}{{UNIT}}',
            ],
        ]);

        $this->add_control('borders_spacing', [
            'label' => __('Spacing', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'selectors' => [
                '{{WRAPPER}} .hq-post-navigation-widget' => 'padding: {{SIZE}}{{UNIT}} 0;',
                '{{WRAPPER}} .hq-post-navigation__prev' => 'padding-right: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .hq-post-navigation__next' => 'padding-left: {{SIZE}}{{UNIT}};',
            ],
            'range' => [
                'em' => [
                    'min' => 0,
                    'max' => 5,
                ],
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_active_settings();

        // Prepare post for editor mode
        if (Plugin::instance()->editor->is_edit_mode()) {
            if (!$settings['test_post_item']) {
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

        if ($settings['show_label'] === 'yes') {
            $prev_label = '<span class="post-navigation__prev--label">' . esc_html($settings['prev_label']) . '</span>';
            $next_label = '<span class="post-navigation__next--label">' . esc_html($settings['next_label']) . '</span>';
        } else {
            $prev_label = '';
            $next_label = '';
        }

        if ($settings['show_icons'] === 'yes') {
            ob_start();
            Icons_Manager::render_icon($this->get_settings('icon_prev'));
            $icon_prev = ob_get_clean();

            ob_start();
            Icons_Manager::render_icon($this->get_settings('icon_next'));
            $icon_next = ob_get_clean();

            if (is_rtl()) {
                $prev_icon = $icon_next;
                $next_icon = $icon_prev;
            } else {
                $prev_icon = $icon_prev;
                $next_icon = $icon_next;
            }

            $prev_icon = '<span class="post-navigation__icon-wrapper post-navigation__icon-prev">' . $prev_icon . '<span class="elementor-screen-only">' . esc_html__('Prev', 'hq-widgets-for-elementor') . '</span></span>';
            $next_icon = '<span class="post-navigation__icon-wrapper post-navigation__icon-next">' . $next_icon . '<span class="elementor-screen-only">' . esc_html__('Next', 'hq-widgets-for-elementor') . '</span></span>';
        } else {
            $prev_icon = '';
            $next_icon = '';
        }

        if ($settings['show_title'] === 'yes') {
            $prev_title = '<span class="post-navigation__prev--title">%title</span>';
            $next_title = '<span class="post-navigation__next--title">%title</span>';
        } else {
            $prev_title = '';
            $next_title = '';
        }

        $in_same_term = false;
        $taxonomy = 'category';

        $post_type = get_post_type(get_queried_object_id());

        if (!empty($settings['in_same_term']) && is_array($settings['in_same_term']) && in_array($post_type, $settings['in_same_term'])) {
            if (isset($settings[$post_type . '_taxonomy'])) {
                $in_same_term = true;
                $taxonomy = $settings[$post_type . '_taxonomy'];
            }
        }
        ?>
        <div class="hq-post-navigation-widget">
            <div class="hq-post-navigation__prev hq-post-navigation__link">
                <?php previous_post_link('%link', $prev_icon . '<span class="hq-post-navigation__link__prev">' . $prev_label . ' ' . $prev_title . '</span>', $in_same_term, '', $taxonomy); ?>
            </div>
            <?php if ($settings['show_borders'] === 'yes') : ?>
                <div class="hq-post-navigation__separator-wrapper">
                    <div class="hq-post-navigation__separator"></div>
                </div>
            <?php endif; ?>
            <div class="hq-post-navigation__next hq-post-navigation__link">
                <?php next_post_link('%link', '<span class="hq-post-navigation__link__next">' . $next_label . ' ' . $next_title . '</span>' . $next_icon, $in_same_term, '', $taxonomy); ?>
            </div>
        </div>
        <?php
        //Rollback to the previous global post
        if (Plugin::instance()->editor->is_edit_mode()) {
            Plugin::instance()->db->restore_current_post();
        }
    }

}
