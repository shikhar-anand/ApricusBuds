<?php

namespace HQWidgetsForElementor\Widget\Woocommerce;

defined('ABSPATH') || exit;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use HQWidgetsForElementor\Widget\Theme\Posts;
use HQLib\Utils;
use const HQWidgetsForElementor\ELEMENTOR_BASE_UPLOADS;
use const HQWidgetsForElementor\VERSION;
use const HQWidgetsForElementor\PLUGIN_SLUG;
use const HQWidgetsForElementor\PLUGIN_URL;

class Product_Reviews extends Posts {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        wp_register_style('hq-woocommerce-product-reviews', ELEMENTOR_BASE_UPLOADS . 'css/hq-woocommerce-product-reviews.css', [], VERSION);
        if (Plugin::instance()->editor->is_edit_mode() || Plugin::instance()->preview->is_preview_mode()) {
            wp_register_script('hq-woocommerce-product-reviews', PLUGIN_URL . 'assets/widgets/woocommerce/product-reviews/script.js', ['elementor-frontend'], VERSION, true);
        }
    }

    public function get_name() {
        return 'hq-woocommerce-product-reviews';
    }

    public function get_title() {
        return __('Woo Product Reviews', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-feedback';
    }

    public function get_style_depends() {
        return ['hq-woocommerce-product-reviews'];
    }

    public function get_script_depends() {
        if (Plugin::instance()->editor->is_edit_mode() || Plugin::instance()->preview->is_preview_mode()) {
            return ['hq-woocommerce-product-reviews'];
        }
        return [];
    }

    public function get_categories() {
        return [PLUGIN_SLUG . '-woo'];
    }

    public function get_keywords() {
        return ['woocommerce', 'shop', 'store', 'reviews', 'product', 'comments'];
    }

    protected function _register_controls() {
        if (!defined('WC_VERSION')) {
            $this->start_controls_section('section_plugin_missing', [
                'label' => __('Woocommerce', 'hq-widgets-for-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]);

            $this->add_control('plugin_alert', [
                'raw' => '<p>' . __('WooCommerce plugin is not installed.', 'hq-widgets-for-elementor') . '</p>' . sprintf('<a href="%s" target="_blank">%s</a>', esc_url(admin_url('plugin-install.php?s=woocommerce&tab=search&type=term')), __('Install WooCommerce.', 'hq-widgets-for-elementor')),
                'type' => Controls_Manager::RAW_HTML,
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
            ]);

            $this->end_controls_section();

            return;
        }

        $args = [
            'post_type' => 'product'
        ];
        $this->register_test_post_item_section_controls($args);

        $this->start_controls_section(
                'section_content', [
            'label' => __('Options', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'avatar_settings', [
            'raw' => sprintf('<a href="%s" target="_blank">%s</a>', esc_url(admin_url('options-discussion.php')), __('Wordpress Core Discussion Settings', 'hq-widgets-for-elementor')),
            'type' => Controls_Manager::RAW_HTML,
            'content_classes' => 'elementor-descriptor',
                ]
        );

        $this->add_control(
                'hide_avatar', [
            'label' => __('Hide Avatar', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'prefix_class' => 'elementor-comment--hide-avatar-',
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'hide_metadata', [
            'label' => __('Hide Metadata', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'prefix_class' => 'elementor-comment--hide-metadata-',
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'hide_stars', [
            'label' => __('Hide Stars', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'prefix_class' => 'elementor-comment--hide-stars-',
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'hide_form', [
            'label' => __('Hide Review Form', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'prefix_class' => 'elementor-comment--hide-form-',
            'separator' => 'before',
                ]
        );

        $this->add_responsive_control(
                'reviews_layout', [
            'label' => __('Layout', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'devices' => ['desktop', 'tablet'],
            'desktop_default' => 'columns',
            'tablet_default' => 'columns',
            'options' => [
                'rows' => [
                    'title' => __('Rows', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-section',
                ],
                'columns' => [
                    'title' => __('Columns', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-column',
                ],
            ],
            'toggle' => false,
            'default' => 'rows',
            'prefix_class' => 'elementor-reviews--layout%s-',
            'condition' => [
                'hide_form!' => 'yes'
            ]
                ]
        );

        $this->add_responsive_control(
                'columns_width', [
            'label' => __('Columns Width', 'hq-widgets-for-elementor'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'range' => [
                '%' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'size_units' => ['%'],
            'devices' => ['desktop', 'tablet'],
            'desktop_default' => [
                'size' => 70,
                'unit' => '%',
            ],
            'tablet_default' => [
                'size' => 60,
                'unit' => '%',
            ],
            'selectors' => [
                '{{WRAPPER}}.elementor-reviews--layout-columns #comments' => 'width: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}}.elementor-reviews--layout-tablet-columns #comments' => 'width: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}}.elementor-reviews--layout-columns #review_form_wrapper' => 'width: calc(100% - {{SIZE}}{{UNIT}} - {{columns_spacing.SIZE}}{{columns_spacing.UNIT}});',
                '{{WRAPPER}}.elementor-reviews--layout-tablet-columns:not(.elementor-reviews--layout-rows) #review_form_wrapper' => 'width: calc(100% - {{SIZE}}{{UNIT}} - {{columns_spacing.SIZE}}{{columns_spacing.UNIT}});',
            ],
            'description' => __('Applicable only for Columns type layout', 'hq-widgets-for-elementor'),
            'condition' => [
                'hide_form!' => 'yes'
            ]
                ]
        );

        $this->add_responsive_control('columns_spacing', [
            'label' => __('Spacing', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
                'em' => [
                    'min' => 0,
                    'max' => 10,
                ],
            ],
            'default' => [
                'unit' => 'em',
                'size' => 1,
            ],
            'selectors' => [
                '{{WRAPPER}}.elementor-reviews--layout-columns #comments' => 'margin-right: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}}.elementor-reviews--layout-tablet-columns #comments' => 'margin-right: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}}.elementor-reviews--layout-rows #comments' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}}.elementor-reviews--layout-tablet-rows #comments' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'hide_form!' => 'yes'
            ]
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_style_comment_box', [
            'label' => __('Reviews Item', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'comment_box_background_even', [
            'label' => __('Even Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} #reviews #comments ol.commentlist > .thread-even' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'comment_box_background_odd', [
            'label' => __('Odd Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} #reviews #comments ol.commentlist > .thread-odd' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_responsive_control(
                'comment_box_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} #reviews #comments ol.commentlist li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before',
                ]
        );

        $this->add_responsive_control(
                'comment_box_margin', [
            'label' => __('Margin', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} #reviews #comments ol.commentlist li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'comment_box_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} #reviews #comments ol.commentlist li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'comment_box_shadow',
            'label' => __('Box Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} #reviews #comments ol.commentlist li',
            'separator' => 'before',
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'comment_box_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} #reviews #comments ol.commentlist li',
                ]
        );

        $this->add_control(
                'child_comment_list', [
            'label' => __('Child Comment List', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_responsive_control(
                'child_comment_list_margin', [
            'label' => __('Margin', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} #reviews #comments ol.commentlist ul.children' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_style_comment_body', [
            'label' => __('Reviews Body', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control('comment_body_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .commentlist .comment-text' => 'background-color: {{VALUE}}',
            ],
        ]);

        $this->add_control('child_comment_body_background_color', [
            'label' => __('Child Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} ol.commentlist ul.children .comment-text' => 'background-color: {{VALUE}}',
            ],
        ]);

        $this->add_responsive_control(
                'comment_body_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} #reviews #comments ol.commentlist li .comment-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'comment_body_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} #reviews #comments ol.commentlist li .comment-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'comment_body_border',
            'selector' => '{{WRAPPER}} #reviews #comments ol.commentlist li .comment-text',
                ]
        );

        $this->add_control(
                'comment_body_heading_content', [
            'label' => __('Comment', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before'
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'comment_body_content_typo',
            'label' => __('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} ol.commentlist .comment_container .description',
                ]
        );

        $this->add_control(
                'comment_body_content_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} ol.commentlist .comment_container .description' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_responsive_control('comment_body_content_spacing', [
            'label' => __('Spacing', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
                'em' => [
                    'min' => 0,
                    'max' => 10,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} ol.commentlist .comment_container .description' => 'margin-top: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->add_control(
                'comment_body_heading_author', [
            'label' => __('Author', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'comment_body_author_typo',
            'label' => __('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} ol.commentlist .comment_container .woocommerce-review__author',
                ]
        );

        $this->add_control(
                'comment_body_author_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} ol.commentlist .comment_container .woocommerce-review__author' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_responsive_control('comment_body_author_spacing', [
            'label' => __('Spacing', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
                'em' => [
                    'min' => 0,
                    'max' => 10,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} #reviews #comments ol.commentlist li .comment-text p.meta' => 'margin-top: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->add_control(
                'comment_body_heading_metadata', [
            'label' => __('Metadata', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => [
                'hide_metadata!' => 'yes',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'comment_body_metadata_typo',
            'label' => __('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} ol.commentlist .comment_container .woocommerce-review__published-date',
            'condition' => [
                'hide_metadata!' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'comment_body_metadata_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} ol.commentlist .comment_container .woocommerce-review__published-date' => 'color: {{VALUE}}',
            ],
            'condition' => [
                'hide_metadata!' => 'yes',
            ],
                ]
        );

        $this->add_responsive_control('comment_body_metadata_spacing', [
            'label' => __('Spacing', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
                'em' => [
                    'min' => 0,
                    'max' => 10,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} ol.commentlist .comment_container .woocommerce-review__published-date' => 'margin-top: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->add_control(
                'comment_body_heading_stars', [
            'label' => __('Stars', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => [
                'hide_stars!' => 'yes',
            ],
                ]
        );
        /*
          $this->add_responsive_control(
          'stars_alignment', [
          'label' => __('Alignment', 'hq-widgets-for-elementor'),
          'type' => Controls_Manager::CHOOSE,
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
          'toggle' => false,
          'default' => 'right',
          'prefix_class' => 'elementor-stars--align-',
          ]
          );
         */
        $this->add_responsive_control('comment_body_stars_spacing', [
            'label' => __('Spacing', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .comment_container .star-rating' => 'margin-top: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->add_control(
                'star_color', [
            'label' => __('Star Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .comment_container .star-rating' => 'color: {{VALUE}}',
            ],
            'condition' => [
                'hide_stars!' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'empty_star_color', [
            'label' => __('Empty Star Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .comment_container .star-rating::before' => 'color: {{VALUE}}',
            ],
            'condition' => [
                'hide_stars!' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'star_size', [
            'label' => __('Star Size', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'unit' => 'em',
            ],
            'range' => [
                'em' => [
                    'min' => 0,
                    'max' => 4,
                    'step' => 0.1,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .comment_container .star-rating' => 'font-size: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->add_control(
                'space_between', [
            'label' => __('Space Between', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'default' => [
                'unit' => 'em',
            ],
            'range' => [
                'em' => [
                    'min' => 0,
                    'max' => 4,
                    'step' => 0.1,
                ],
                'px' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .comment_container .star-rating::before' => 'letter-spacing: {{SIZE}}{{UNIT}}',
                '{{WRAPPER}} .comment_container .star-rating' => 'width: calc(5.3em + {{SIZE}}{{UNIT}}*4); letter-spacing: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_style_avatar', [
            'label' => __('Reviews Avatar', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'hide_avatar!' => 'yes',
            ],
                ]
        );

        $this->add_responsive_control('avatar_size', [
            'label' => __('Width', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 60,
            ],
            'selectors' => [
                '{{WRAPPER}} #reviews #comments .commentlist li .comment_container img' => 'width: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control('avatar_spacing', [
            'label' => __('Spacing', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
                'em' => [
                    'min' => 0,
                    'max' => 10,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 15,
            ],
            'selectors' => [
                '{{WRAPPER}} #reviews #comments .commentlist li .comment_container img' => 'margin-right: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->add_responsive_control(
                'avatar_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} #reviews #comments .commentlist li .comment_container img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'avatar_border',
            'selector' => '{{WRAPPER}} #reviews #comments .commentlist li .comment_container img',
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_style_comment_form', [
            'label' => __('Comment Form', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'hide_form!' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'comment_form_wrapper', [
            'label' => __('Post Comment Container', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
                ]
        );

        $this->add_control('comment_form_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} #review_form_wrapper' => 'background-color: {{VALUE}}',
            ],
        ]);

        $this->add_control(
                'comment_form_wrapper_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} #review_form_wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_control(
                'comment_form_wrapper_margin', [
            'label' => __('Margin', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} #review_form_wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'comment_form_wrapper_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} #review_form_wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'comment_form_wrapper_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} #review_form_wrapper',
                ]
        );

        $this->add_control(
                'comment_form_titles', [
            'label' => __('Post Comment Title and Labels', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before'
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'comment_body_title_typo',
            'label' => __('Form Title Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} #review_form_wrapper .comment-reply-title',
                ]
        );

        $this->add_control(
                'comment_body_title_text_color', [
            'label' => __('Form Title Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} #review_form_wrapper .comment-reply-title' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'comment_body_labels_typo',
            'label' => __('Form Label Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} #review_form_wrapper label',
                ]
        );

        $this->add_control(
                'comment_body_labels_text_color', [
            'label' => __('Form Label Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} #review_form_wrapper label' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'comment_form_inputs', [
            'label' => __('Post Comment Input Fields', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before'
                ]
        );

        $this->add_responsive_control('review_form_textarea_height', [
            'label' => __('Textarea Height', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'range' => [
                'px' => [
                    'max' => 300,
                    'step' => 10,
                ],
                'em' => [
                    'min' => 1,
                    'max' => 10,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} #reviews #comment' => 'height: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control('review_form_input_width', [
            'label' => __('Input Field Width', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['%'],
            'range' => [
                '%' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .comment-respond .comment-form-author,'
                . '{{WRAPPER}} .comment-respond .comment-form-email' => 'width: {{SIZE}}%;',
            ],
        ]);

        $this->add_responsive_control('review_form_input_height', [
            'label' => __('Input Field Height', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'range' => [
                'px' => [
                    'max' => 100,
                    'step' => 1,
                ],
                'em' => [
                    'min' => 1,
                    'max' => 10,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .comment-respond input[type="text"],'
                . '{{WRAPPER}} .comment-respond input[type="email"]' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('post_inputs_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .comment-respond .comment-form-comment textarea,'
                . '{{WRAPPER}} .comment-respond input[type="text"],'
                . '{{WRAPPER}} .comment-respond input[type="email"]' => 'background-color: {{VALUE}}',
            ],
        ]);

        $this->add_responsive_control(
                'post_inputs_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .comment-respond .comment-form-comment textarea,'
                . '{{WRAPPER}} .comment-respond input[type="text"],'
                . '{{WRAPPER}} .comment-respond input[type="email"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'post_inputs_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .comment-respond .comment-form-comment textarea,'
                . '{{WRAPPER}} .comment-respond input[type="text"],'
                . '{{WRAPPER}} .comment-respond input[type="email"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->start_controls_tabs('comment_form_inputs_tabs');

        $this->start_controls_tab('comment_form_inputs_normal_tab', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
        ]);

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'post_inputs_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .comment-respond .comment-form-comment textarea,'
            . '{{WRAPPER}} .comment-respond input[type="text"],'
            . '{{WRAPPER}} .comment-respond input[type="email"]',
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('comment_form_inputs_focus_tab', [
            'label' => __('Focus', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('post_inputs_border_focus_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .comment-respond .comment-form-comment textarea:focus,'
                . '{{WRAPPER}} .comment-respond input[type="text"]:focus,'
                . '{{WRAPPER}} .comment-respond input[type="email"]:focus' => 'border-color: {{VALUE}}',
            ],
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'post_inputs_border_focus_box_shadow',
            'label' => __('Box Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .comment-respond .comment-form-comment textarea:focus, {{WRAPPER}} .comment-respond input[type="text"]:focus, {{WRAPPER}} .comment-respond input[type="email"]:focus',
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->add_control(
                'comment_form_button', [
            'label' => __('Post Comment Button', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before'
                ]
        );

        $this->add_responsive_control(
                'post_button_align', [
            'label' => __('Alignment', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'prefix_class' => 'elementor-comment--post-button-position%s-',
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
                ]
        );

        $this->add_responsive_control('post_button_spacing', [
            'label' => __('Spacing', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
                'em' => [
                    'min' => 0,
                    'max' => 10,
                ],
            ],
            'default' => [
                'unit' => 'em',
                'size' => 1,
            ],
            'selectors' => [
                '{{WRAPPER}} #review_form #respond .form-submit' => 'margin-top: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->start_controls_tabs('post_button_tabs');

        $this->start_controls_tab(
                'tab_post_button_normal', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'post_button_typo',
            'label' => __('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} #respond input#submit',
                ]
        );

        $this->add_control(
                'post_button_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} #respond input#submit' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'post_button_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} #respond input#submit' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'post_button_border',
            'label' => __('Button Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} #respond input#submit',
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_post_button_hover', [
            'label' => __('Hover', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'post_button_text_hover_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} #respond input#submit:hover' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'post_button_border_hover_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} #respond input#submit:hover' => 'border-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'post_button_background_hover_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} #respond input#submit:hover' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'post_button_box_shadow',
            'label' => __('Button Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} #respond input#submit:hover',
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control('post_button_padding', [
            'label' => __('Button Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} #respond input#submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before'
        ]);

        $this->add_responsive_control('post_button_border_radius', [
            'label' => __('Button Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} #respond input#submit' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
            ],
        ]);

        $this->end_controls_section();
    }

    public function render() {
        if (!defined('WC_VERSION')) {
            Utils::editor_alert_box('WooCommerce plugin is missing.');
            return;
        }

        $settings = $this->get_settings();

        // Prepare test item for editor mode
        Utils::editor_switch_to_post($settings['test_post_item']);
        if (!$settings['test_post_item']) {
            return;
        }
        add_filter('comments_template', array('WC_Template_Loader', 'comments_template_loader'));

        remove_action('woocommerce_review_before', 'woocommerce_review_display_gravatar', 10);

        add_action('woocommerce_review_before_comment_meta', [$this, 'metabox_open'], 20);
        add_action('woocommerce_review_meta', 'woocommerce_review_display_gravatar', 5);
        add_action('woocommerce_review_before_comment_text', [$this, 'metabox_close'], 5);

        Utils::editor_start_woocommerce_section();

        if (!empty($GLOBALS['post'])) {
            comments_template();
        }

        Utils::editor_end_woocommerce_section();

        remove_action('woocommerce_review_before_comment_meta', [$this, 'metabox_open']);
        remove_action('woocommerce_review_before_comment_text', [$this, 'metabox_close']);

        // Rollback to the previous global post
        Utils::editor_restore_to_current_post();
    }

    public function metabox_open() {
        echo '<div class="meta-box">';
    }

    public function metabox_close() {
        echo '</div>';
    }

}
