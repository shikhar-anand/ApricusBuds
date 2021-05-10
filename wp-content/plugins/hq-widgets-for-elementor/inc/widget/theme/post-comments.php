<?php

namespace HQWidgetsForElementor\Widget\Theme;

defined('ABSPATH') || exit;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use HQWidgetsForElementor\Widget\Theme\Posts;
use const HQWidgetsForElementor\ELEMENTOR_BASE_UPLOADS;
use const HQWidgetsForElementor\PLUGIN_SLUG;
use const HQWidgetsForElementor\VERSION;

class Post_Comments extends Posts {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        wp_register_style('hq-theme-post-comments', ELEMENTOR_BASE_UPLOADS . 'css/hq-theme-post-comments.css', [], VERSION);
    }

    public function get_name() {
        return 'hq-theme-post-comments';
    }

    public function get_title() {
        return __('Post Comments', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-conversation';
    }

    public function get_style_depends() {
        return ['hq-theme-post-comments'];
    }

    public function get_categories() {
        return [PLUGIN_SLUG];
    }

    public function get_keywords() {
        return ['comments', 'post', 'response', 'form'];
    }

    protected function _register_controls() {

        $this->register_test_post_item_section_controls();

        $this->start_controls_section('section_content', [
            'label' => __('Options', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('avatar_settings', [
            'raw' => sprintf('<a href="%s" target="_blank">%s</a>', esc_url(admin_url('options-discussion.php')), __('Wordpress Core Discussion Settings', 'hq-widgets-for-elementor')),
            'type' => Controls_Manager::RAW_HTML,
            'content_classes' => 'elementor-descriptor',
        ]);

        $this->add_control('hide_avatar', [
            'label' => __('Hide Avatar', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'prefix_class' => 'elementor-comment--hide-avatar-',
            'label_on' => __('Hide', 'hq-widgets-for-elementor'),
            'label_off' => __('Show', 'hq-widgets-for-elementor'),
            'separator' => 'before',
        ]);

        $this->add_control('hide_metadata', [
            'label' => __('Hide Metadata', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'prefix_class' => 'elementor-comment--hide-metadata-',
            'label_on' => __('Hide', 'hq-widgets-for-elementor'),
            'label_off' => __('Show', 'hq-widgets-for-elementor'),
            'separator' => 'before',
        ]);

        $this->end_controls_section();

        $this->start_controls_section('section_style_comments_list', [
            'label' => __('Comments List', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('comments_title_heading', [
            'label' => __('Comment List Heading', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
        ]);

        $this->add_control('comments_title_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .title-comments' => 'color: {{VALUE}}',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'comments_title_typo',
            'label' => __('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .title-comments',
        ]);

        $this->add_responsive_control('comments_title_spacing', [
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
                '{{WRAPPER}} .title-comments' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('comments_title_alignment', [
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
            'selectors' => ['{{WRAPPER}} .title-comments' => 'text-align: {{VALUE}}']
        ]);

        $this->add_control('child_comment_list', [
            'label' => __('Child Comment List', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);

        $this->add_responsive_control('child_comment_list_margin', [
            'label' => __('Margin', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .comment-list .comment .children' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('section_style_comment_box', [
            'label' => __('Comments Item', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('comment_item_heading', [
            'label' => __('Comment Box', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
        ]);

        $this->add_control('comment_box_background_even', [
            'label' => __('Even Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} ol.comment-list .comment.thread-even, {{WRAPPER}} ol.comment-list .children .even' => 'background-color: {{VALUE}}',
            ],
            'default' => '#ffffff',
        ]);

        $this->add_control('comment_box_background_odd', [
            'label' => __('Odd Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} ol.comment-list .comment.thread-odd, {{WRAPPER}} ol.comment-list .children .odd' => 'background-color: {{VALUE}}',
            ],
            'default' => '#f6f6f6',
        ]);

        $this->add_responsive_control('comment_box_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} ol.comment-list .comment' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('comment_box_margin', [
            'label' => __('Margin', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} ol.comment-list .comment' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('comment_box_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} ol.comment-list .comment' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->start_controls_tabs('comment_box_tabs');

        $this->start_controls_tab('main_comment_box_tab', [
            'label' => __('Main', 'hq-widgets-for-elementor'),
        ]);

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'comment_box_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} ol.comment-list > .comment',
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'comment_box_shadow',
            'label' => __('Box Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} ol.comment-list > .comment',
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('children_comment_box_tab', [
            'label' => __('Children', 'hq-widgets-for-elementor'),
        ]);

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'child_comment_box_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} ol.comment-list .children .comment',
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'child_comment_box_shadow',
            'label' => __('Box Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} ol.comment-list .children .comment',
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control('comment_body_heading_content', [
            'label' => __('Content', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'comment_body_content_typo',
            'label' => __('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} ol.comment-list .comment-content p',
        ]);

        $this->add_control('comment_body_content_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} ol.comment-list .comment-content p' => 'color: {{VALUE}}',
            ],
        ]);

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
                '{{WRAPPER}} ol.comment-list .comment-content p' => 'margin-top: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('comment_body_heading_author', [
            'label' => __('Author', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'comment_body_author_typo',
            'label' => __('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .comment-meta .fn, {{WRAPPER}} .comment-meta .fn a',
        ]);

        $this->add_control('comment_body_author_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .comment-meta .fn, {{WRAPPER}} .comment-meta .fn a' => 'color: {{VALUE}}',
            ],
        ]);

        $this->add_control('comment_body_author_vertical_align', [
            'label' => __('Vertical Align', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'prefix_class' => 'elementor-comment--author-valign-',
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
            'default' => 'middle',
        ]);

        $this->add_control('comment_body_heading_metadata', [
            'label' => __('Metadata', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => [
                'hide_metadata!' => 'yes',
            ],
        ]);

        $this->add_responsive_control('comment_body_metadata_margin', [
            'label' => __('Margin', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} ol.comment-list .comment-metadata' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->start_controls_tabs('comment_body_metadata_tabs', [
            'condition' => [
                'hide_metadata!' => 'yes',
            ],
        ]);

        $this->start_controls_tab('tab_metadata_normal', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'comment_body_metadata_typo',
            'label' => __('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .comment-metadata > a',
            'condition' => [
                'hide_metadata!' => 'yes',
            ],
        ]);

        $this->add_control('comment_body_metadata_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .comment-metadata > a' => 'color: {{VALUE}}; border-color: {{VALUE}}',
            ],
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('tab_metadata_hover', [
            'label' => __('Hover', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('comment_body_metadata_hover_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .comment-metadata > a:hover' => 'color: {{VALUE}}; border-color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section('section_style_avatar', [
            'label' => __('Avatar', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'hide_avatar!' => 'yes',
            ],
        ]);

        $this->add_responsive_control('avatar_alignment', [
            'label' => __('Alignment', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'prefix_class' => 'elementor-comment--avatar-position%s-',
            'label_block' => false,
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
            'default' => 'left',
            'toggle' => false,
        ]);

        $this->add_responsive_control('avatar_size', [
            'label' => __('Size', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 30,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} ol.comment-list .vcard img' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]);

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
                'size' => 20,
            ],
            'selectors' => [
                '{{WRAPPER}}.elementor-comment--avatar-position-left ol.comment-list .vcard img' => 'margin-right: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}}.elementor-comment--avatar-position-right ol.comment-list .vcard img' => 'margin-left: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('avatar_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} ol.comment-list .vcard img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'avatar_border',
            'selector' => '{{WRAPPER}} ol.comment-list .vcard img',
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_style_reply', [
            'label' => __('Reply', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control('heading_reply_button', [
            'label' => __('Reply Button', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
        ]);

        $this->add_responsive_control('reply_align', [
            'label' => __('Alignment', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'prefix_class' => 'elementor-comment--reply-position%s-',
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
            'default' => 'left',
            'toggle' => false,
        ]);

        $this->add_responsive_control('reply_spacing', [
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
                '{{WRAPPER}} ol.comment-list .reply' => 'margin-top: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->start_controls_tabs('reply_button_tabs');

        $this->start_controls_tab('tab_reply_button_normal', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'reply_typo',
            'label' => __('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} ol.comment-list .comment-reply-link',
        ]);

        $this->add_control('reply_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} ol.comment-list .comment-reply-link' => 'color: {{VALUE}}',
            ],
        ]);

        $this->add_control('reply_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} ol.comment-list .comment-reply-link' => 'background-color: {{VALUE}}',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'reply_border',
            'label' => __('Button Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} ol.comment-list .comment-reply-link',
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('tab_reply_button_hover', [
            'label' => __('Hover', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('reply_text_hover_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} ol.comment-list .comment-reply-link:hover' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('reply_background_hover_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} ol.comment-list .comment-reply-link:hover' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('reply_border_hover_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} ol.comment-list .comment-reply-link:hover' => 'border-color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'reply_hover_box_shadow',
            'label' => __('Button Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} ol.comment-list .comment-reply-link:hover',
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control('reply_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} ol.comment-list .comment-reply-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before'
        ]);

        $this->add_responsive_control('reply_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} ol.comment-list .comment-reply-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_control('heading_cancel_button', [
            'label' => __('Cancel Button', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before'
        ]);

        $this->start_controls_tabs('cancel_button_tabs');

        $this->start_controls_tab('tab_cancel_button_normal', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'cancel_typo',
            'label' => __('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} ol.comment-list #cancel-comment-reply-link',
        ]);

        $this->add_control('cancel_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} ol.comment-list #cancel-comment-reply-link' => 'color: {{VALUE}}',
            ],
        ]);

        $this->add_control('cancel_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} ol.comment-list #cancel-comment-reply-link' => 'background-color: {{VALUE}}',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'cancel_border',
            'label' => __('Button Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} ol.comment-list #cancel-comment-reply-link',
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('tab_cancel_button_hover', [
            'label' => __('Hover', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('cencel_text_hover_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} ol.comment-list #cancel-comment-reply-link:hover' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('cancel_background_hover_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} ol.comment-list #cancel-comment-reply-link:hover' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('cancel_border_hover_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} ol.comment-list #cancel-comment-reply-link:hover' => 'border-color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'cancel_hover_box_shadow',
            'label' => __('Button Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} ol.comment-list #cancel-comment-reply-link:hover',
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control('cancel_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} ol.comment-list #cancel-comment-reply-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before'
        ]);

        $this->add_responsive_control('cancel_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} ol.comment-list #cancel-comment-reply-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('section_style_comment_form', [
            'label' => __('Comment Form', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('comment_form_spacing', [
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
                '{{WRAPPER}} .comment-respond' => 'margin-top: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('comment_form_backround_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .comment-respond' => 'background-color: {{VALUE}}',
            ],
        ]);

        $this->add_control('comment_form_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .comment-respond' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_control('comment_form_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .comment-respond' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_control('heading_reply_heading', [
            'label' => __('Heading', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before'
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'reply_heading_typo',
            'label' => __('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} #reply-title',
        ]);

        $this->add_control('reply_heading_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} #reply-title' => 'color: {{VALUE}}',
            ],
        ]);

        $this->add_control('comment_form_heading_labels', [
            'label' => __('Post Comment Labels', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before'
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'comment_form_labels_typo',
            'label' => __('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .comment-form label',
        ]);

        $this->add_control('comment_form_labels_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .comment-form label' => 'color: {{VALUE}}',
            ],
        ]);

        $this->add_responsive_control('comment_form_labels_spacing', [
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
                '{{WRAPPER}} .comment-form label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('comment_form_heading_inputs', [
            'label' => __('Post Comment Input Fields', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before'
        ]);

        $this->add_responsive_control('comment_form_textarea_height', [
            'label' => __('Textarea Height', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'range' => [
                'px' => [
                    'step' => 1,
                ],
                'em' => [
                    'min' => 0,
                    'max' => 10,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .comment-form textarea' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('comment_form_input_height', [
            'label' => __('Input Field Height', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'range' => [
                'px' => [
                    'step' => 1,
                ],
                'em' => [
                    'min' => 0,
                    'max' => 10,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .comment-form input[type="text"], {{WRAPPER}} .comment-form input[type="email"], {{WRAPPER}} .comment-form input[type="url"]' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'comment_form_inputs_typo',
            'label' => __('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .comment-form textarea, {{WRAPPER}} .comment-form input[type="text"], {{WRAPPER}} .comment-form input[type="email"], {{WRAPPER}} .comment-form input[type="url"]',
        ]);

        $this->add_control('comment_form_inputs_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .comment-form textarea, {{WRAPPER}} .comment-form input[type="text"], {{WRAPPER}} .comment-form input[type="email"], {{WRAPPER}} .comment-form input[type="url"]' => 'color: {{VALUE}}',
            ],
        ]);

        $this->start_controls_tabs('comment_form_inputs_tabs');

        $this->start_controls_tab('tab_comment_form_inputs_normal', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'comment_form_inputs_box_shadow',
            'label' => __('Box Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .comment-form textarea, {{WRAPPER}} .comment-form input[type="text"], {{WRAPPER}} .comment-form input[type="email"], {{WRAPPER}} .comment-form input[type="url"]',
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'comment_form_inputs_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .comment-form textarea, {{WRAPPER}} .comment-form input[type="text"], {{WRAPPER}} .comment-form input[type="email"], {{WRAPPER}} .comment-form input[type="url"]',
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('tab_comment_form_inputs_focus', [
            'label' => __('Focus', 'hq-widgets-for-elementor'),
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'comment_form_inputs_focus_box_shadow',
            'label' => __('Box Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .comment-form textarea:focus, {{WRAPPER}} .comment-form input[type="text"]:focus, {{WRAPPER}} .comment-form input[type="email"]:focus, {{WRAPPER}} .comment-form input[type="url"]:focus',
        ]);

        $this->add_control('comment_form_inputs_focus_border_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .comment-form textarea:focus, {{WRAPPER}} .comment-form input[type="text"]:focus, {{WRAPPER}} .comment-form input[type="email"]:focus, {{WRAPPER}} .comment-form input[type="url"]:focus' => 'border-color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control('comment_form_inputs_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .comment-form textarea, {{WRAPPER}} .comment-form input[type="text"], {{WRAPPER}} .comment-form input[type="email"], {{WRAPPER}} .comment-form input[type="url"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before'
        ]);

        $this->add_responsive_control('comment_form_inputs_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .comment-form textarea, {{WRAPPER}} .comment-form textarea:focus, 
                    {{WRAPPER}} .comment-form input[type="text"], {{WRAPPER}} .comment-form input[type="text"]:focus,
                    {{WRAPPER}} .comment-form input[type="email"], {{WRAPPER}} .comment-form input[type="email"]:focus,
                    {{WRAPPER}} .comment-form input[type="url"], {{WRAPPER}} .comment-form input[type="url"]:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_control('comment_form_button', [
            'label' => __('Post Comment Button', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before'
        ]);

        $this->add_responsive_control('post_button_align', [
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
            'default' => 'left',
            'toggle' => false,
            'selectors' => [
                '{{WRAPPER}} .comment-respond .form-submit' => 'text-align: {{VALUE}}'
            ],
        ]);
        
        $this->add_responsive_control('post_button_width', [
            'label' => __('Width', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 500,
                    'step' => 10,
                ],
                '%' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} #respond input#submit' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]);

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
            'selectors' => [
                '{{WRAPPER}} .comment-respond .form-submit' => 'padding-top: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->start_controls_tabs('post_button_tabs');

        $this->start_controls_tab('tab_post_button_normal', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'post_button_typo',
            'label' => __('Typography', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} #respond input#submit',
        ]);

        $this->add_control('post_button_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} #respond input#submit' => 'color: {{VALUE}}',
            ],
        ]);

        $this->add_control('post_button_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} #respond input#submit' => 'background-color: {{VALUE}}',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'post_button_border',
            'label' => __('Button Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} #respond input#submit',
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('tab_post_button_hover', [
            'label' => __('Hover', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('post_button_text_hover_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} #respond input#submit:hover' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('post_button_background_hover_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} #respond input#submit:hover' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('post_button_border_hover_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} #respond input#submit:hover' => 'border-color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'post_button_hover_box_shadow',
            'label' => __('Button Shadow', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} #respond input#submit:hover',
        ]);

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
        $settings = $this->get_settings();

        // Prepare test item for editor mode
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

        if (!comments_open() && ( Plugin::instance()->preview->is_preview_mode() || Plugin::instance()->editor->is_edit_mode() )) {
            ?>
            <div class="elementor-alert elementor-alert-danger" role="alert">
                <span class="elementor-alert-title">
                    <?php esc_html_e('Comments are closed.', 'hq-widgets-for-elementor'); ?>
                </span>
                <span class="elementor-alert-description">
                    <?php esc_html_e('Switch on comments from either the discussion box on the WordPress post edit screen or from the WordPress discussion settings.', 'hq-widgets-for-elementor'); ?>
                </span>
            </div>
            <?php
        } elseif (!empty($GLOBALS['post'])) {
            comments_template();
        }

        //Rollback to the previous global post
        if (Plugin::instance()->editor->is_edit_mode()) {
            Plugin::instance()->db->restore_current_post();
        }
    }

}
