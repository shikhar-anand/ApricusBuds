<?php

namespace HQWidgetsForElementor\Widget\Theme;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;
use Elementor\Widget_Base;
use const HQWidgetsForElementor\PLUGIN_SLUG;
use const HQWidgetsForElementor\PLUGIN_URL;
use const HQWidgetsForElementor\VERSION;

class Post_Content extends \HQWidgetsForElementor\Widget\Base {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);

        wp_register_style('hq-theme-post-content', PLUGIN_URL . 'assets/widgets/theme/post-content/style.css', [], VERSION);
    }

    public function get_name() {
        return 'hq-theme-post-content';
    }

    public function get_title() {
        return __('Post Content', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-content-writing';
    }

    public function get_style_depends() {
        return ['hq-theme-post-content'];
    }

    public function get_categories() {
        return [PLUGIN_SLUG];
    }

    public function get_keywords() {
        return ['content', 'post'];
    }

    protected function _register_controls() {
        $this->register_test_post_item_section_controls();
        $this->register_controls();
    }

    protected function register_controls() {

        $this->start_controls_section('section_content', [
            'label' => __('Content', 'hq-widgets-for-elementor'),
        ]);

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
                'justify' => [
                    'title' => __('Justified', 'hq-widgets-for-elementor'),
                    'icon' => 'fa fa-align-justify',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}}' => 'text-align: {{VALUE}};',
            ],
        ]);

        $this->add_control('multi_columns', [
            'label' => __('Multi-column Layout', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'description' => __('Works for paragraphs only.', 'hq-widgets-for-elementor'),
        ]);

        $this->add_responsive_control('columns', [
            'label' => __('Columns', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 4,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 1,
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-widget-container' => 'column-count: {{SIZE}};',
            ],
            'condition' => [
                'multi_columns' => 'yes',
            ],
        ]);

        $this->add_control('heading_content_pagination', [
            'label' => __('Content Pagination', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before'
        ]);

        $this->add_responsive_control('content_pagination_alignment', [
            'label' => __('Alignment', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'flex-start' => [
                    'title' => __('Left', 'hq-widgets-for-elementor'),
                    'icon' => 'fa fa-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'hq-widgets-for-elementor'),
                    'icon' => 'fa fa-align-center',
                ],
                'flex-end' => [
                    'title' => __('Right', 'hq-widgets-for-elementor'),
                    'icon' => 'fa fa-align-right',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .hq-page-links' => 'justify-content: {{VALUE}};',
            ],
            'default' => 'center',
        ]);

        $this->add_control('content_pagination_label', [
            'label' => __('Label', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Pages:', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('content_pagination_has_separator', [
            'label' => __('Enable Separator', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes'
        ]);

        $this->add_control('content_pagination_separator', [
            'label' => __('Separator', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __(',', 'hq-widgets-for-elementor'),
            'condition' => [
                'content_pagination_has_separator' => 'yes',
            ],
        ]);

        $this->end_controls_section();

        /* STYLES */
        $this->start_controls_section('headings_style', [
            'label' => __('Heading', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('heading_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .elementor-widget-container h1' => 'color: {{VALUE}};',
                '{{WRAPPER}} .elementor-widget-container h2' => 'color: {{VALUE}};',
                '{{WRAPPER}} .elementor-widget-container h3' => 'color: {{VALUE}};',
                '{{WRAPPER}} .elementor-widget-container h4' => 'color: {{VALUE}};',
                '{{WRAPPER}} .elementor-widget-container h5' => 'color: {{VALUE}};',
                '{{WRAPPER}} .elementor-widget-container h6' => 'color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('text_style', [
            'label' => __('Paragraphs', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .elementor-widget-container' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'text_typography',
            'selector' => '{{WRAPPER}} .elementor-widget-container p',
        ]);

        $this->end_controls_section();

        $this->start_controls_section('columns_style', [
            'label' => __('Columns', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'multi_columns' => 'yes',
            ],
        ]);

        $this->add_responsive_control('columns_gap', [
            'label' => __('Columns Gap', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', '%'],
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 100,
                ],
                'em' => [
                    'min' => 1,
                    'max' => 10,
                ],
                '%' => [
                    'min' => 1,
                    'max' => 50,
                ],
            ],
            'default' => [
                'unit' => 'em',
                'size' => 1,
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-widget-container' => 'column-gap: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'multi_columns' => 'yes',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('content_pagination_style', [
            'label' => __('Content Pagination', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('content_pagination_offset', [
            'label' => __('Offset', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 200,
                ],
                'em' => [
                    'min' => 1,
                    'max' => 10,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .hq-page-links' => 'margin-top: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('heading_content_pagination_label', [
            'label' => __('Label', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'content_pagination_label_typography',
            'selector' => '{{WRAPPER}} .hq-page-links .hq-page-links-title',
        ]);

        $this->add_control('content_pagination_label_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-page-links .hq-page-links-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_responsive_control('content_pagination_label_gap', [
            'label' => __('Gap', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .hq-page-links .hq-page-links-title' => 'margin-right: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('heading_content_pagination_links', [
            'label' => __('Links', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before'
        ]);

        $this->start_controls_tabs('content_pagination_links');

        $this->start_controls_tab('content_pagination_link_normal', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'content_pagination_link_typography',
            'selector' => '{{WRAPPER}} .hq-page-links .post-page-numbers',
        ]);

        $this->add_control('content_pagination_link_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-page-links .post-page-numbers' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control('content_pagination_link_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-page-links .post-page-numbers' => 'background: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'content_pagination_link_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hq-page-links .post-page-numbers',
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('content_pagination_link_hover', [
            'label' => __('Hover', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('content_pagination_link_hover_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-page-links .post-page-numbers:hover' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('content_pagination_link_hover_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-page-links .post-page-numbers:hover' => 'background: {{VALUE}};',
            ],
        ]);

        $this->add_control('content_pagination_link_hover_border_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-page-links .post-page-numbers:hover' => 'border-color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('content_pagination_current', [
            'label' => __('Current', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('content_pagination_current_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-page-links .post-page-numbers.current' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('content_pagination_current_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-page-links .post-page-numbers.current' => 'background: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'content_pagination_current_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hq-page-links .post-page-numbers.current',
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control('content_pagination_links_divider', [
            'type' => Controls_Manager::DIVIDER,
        ]);

        $this->add_responsive_control('content_pagination_links_gap', [
            'label' => __('Gap', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 50,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .hq-page-links .post-page-numbers:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('content_pagination_links_padding', [
            'label' => esc_html__('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .hq-page-links .post-page-numbers' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('content_pagination_links_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .hq-page-links .post-page-numbers' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'content_pagination_links_box_shadow',
            'selector' => '{{WRAPPER}} .hq-page-links .post-page-numbers',
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        static $did_posts = [];

        $post = get_post();

        if (empty($post)) {
            return;
        }

        if (post_password_required($post->ID)) {
            echo get_the_password_form($post->ID);

            return;
        }

        // Avoid recursion
        if (isset($did_posts[$post->ID])) {
            return;
        }
        $did_posts[$post->ID] = true;
        // End avoid recursion

        $settings = $this->get_settings_for_display();

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
        } else {

            Plugin::instance()->frontend->remove_content_filter();

            // Split to pages.
            setup_postdata($post);
        }

        /** This filter is documented in wp-includes/post-template.php */
        echo apply_filters('the_content', get_the_content());

        // Content Paging
        $contentPagingSeparator = $settings['content_pagination_separator'] ? $settings['content_pagination_separator'] : ', ';
        $contentPagingSeparatorClass = $settings['content_pagination_separator'] ? 'hq-page-links-separator' : 'screen-reader-text';
        wp_link_pages([
            'before' => '<div class="hq-page-links"><span class="hq-page-links-title">' . $settings['content_pagination_label'] . '</span>',
            'after' => '</div>',
            'link_before' => '<span>',
            'link_after' => '</span>',
            'pagelink' => '<span class="screen-reader-text">' . __('Page', 'hq-widgets-for-elementor') . ' </span>%',
            'separator' => '<span class="' . $contentPagingSeparatorClass . '">' . $contentPagingSeparator . ' </span>',
        ]);

        // Rollback to the previous global post
        if (Plugin::instance()->editor->is_edit_mode()) {
            Plugin::instance()->db->restore_current_post();
        } else {

            Plugin::instance()->frontend->add_content_filter();
        }
    }

}
