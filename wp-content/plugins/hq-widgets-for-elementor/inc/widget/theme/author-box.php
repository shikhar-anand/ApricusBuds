<?php

namespace HQWidgetsForElementor\Widget\Theme;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;
use const HQWidgetsForElementor\VERSION;
use const HQWidgetsForElementor\PLUGIN_SLUG;
use const HQWidgetsForElementor\ELEMENTOR_BASE_UPLOADS;

class Author_Box extends Widget_Base {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        wp_register_style('hq-theme-author-box', ELEMENTOR_BASE_UPLOADS . 'css/hq-theme-author-box.css', [], VERSION);
    }

    public function get_name() {
        return 'hq-theme-author-box';
    }

    public function get_title() {
        return __('Author Box', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-author-box';
    }

    public function get_style_depends() {
        return ['hq-theme-author-box'];
    }

    public function get_categories() {
        return [PLUGIN_SLUG];
    }

    public function get_keywords() {
        return ['author', 'user', 'profile', 'biography', 'avatar', 'post'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
                'section_author_info', [
            'label' => __('Author Info', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'source', [
            'label' => __('Source', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'current',
            'options' => [
                'current' => __('Current Author', 'hq-widgets-for-elementor'),
                'custom' => __('Custom', 'hq-widgets-for-elementor'),
            ],
                ]
        );

        $this->add_control(
                'show_avatar', [
            'label' => __('Profile Picture', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Show', 'hq-widgets-for-elementor'),
            'label_off' => __('Hide', 'hq-widgets-for-elementor'),
            'default' => 'yes',
            'separator' => 'before',
            'condition' => [
                'source!' => 'custom',
            ],
            'render_type' => 'template',
                ]
        );

        $this->add_control(
                'author_avatar', [
            'label' => __('Profile Picture', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::MEDIA,
            'default' => [
                'url' => Utils::get_placeholder_image_src(),
            ],
            'condition' => [
                'source' => 'custom',
            ],
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'show_name', [
            'label' => __('Display Name', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Show', 'hq-widgets-for-elementor'),
            'label_off' => __('Hide', 'hq-widgets-for-elementor'),
            'default' => 'yes',
            'condition' => [
                'source!' => 'custom',
            ],
            'render_type' => 'template',
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'author_name', [
            'label' => __('Name', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __('John Doe', 'hq-widgets-for-elementor'),
            'condition' => [
                'source' => 'custom',
                'show_name' => 'yes',
            ],
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'author_name_tag', [
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
            ],
            'default' => 'h4',
            'condition' => [
                'show_name' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'link_to', [
            'label' => __('Link', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                '' => __('None', 'hq-widgets-for-elementor'),
                'website' => __('Website', 'hq-widgets-for-elementor'),
                'posts_archive' => __('Posts Archive', 'hq-widgets-for-elementor'),
            ],
            'condition' => [
                'source!' => 'custom',
            ],
            'separator' => 'before',
            'description' => __('Link for the Author Name and Image', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'show_biography', [
            'label' => __('Biography', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Show', 'hq-widgets-for-elementor'),
            'label_off' => __('Hide', 'hq-widgets-for-elementor'),
            'default' => 'yes',
            'condition' => [
                'source!' => 'custom',
            ],
            'render_type' => 'template',
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'show_link', [
            'label' => __('Archive Button', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Show', 'hq-widgets-for-elementor'),
            'label_off' => __('Hide', 'hq-widgets-for-elementor'),
            'default' => 'no',
            'condition' => [
                'source!' => 'custom',
            ],
            'render_type' => 'template',
                ]
        );

        $this->add_control(
                'author_website', [
            'label' => __('Link', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::URL,
            'placeholder' => __('https://your-link.com', 'hq-widgets-for-elementor'),
            'condition' => [
                'source' => 'custom',
            ],
            'description' => __('Link for the Author Name and Image', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'author_bio', [
            'label' => __('Biography', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXTAREA,
            'default' => __('Biography text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'hq-widgets-for-elementor'),
            'rows' => 4,
            'condition' => [
                'source' => 'custom',
            ],
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'posts_url', [
            'label' => __('Archive Button', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::URL,
            'placeholder' => __('https://your-link.com', 'hq-widgets-for-elementor'),
            'condition' => [
                'source' => 'custom',
            ],
                ]
        );

        $this->add_control('link_text', [
            'label' => __('Archive Text', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __('All Posts', 'hq-widgets-for-elementor'),
            'conditions' => [
                'relation' => 'or',
                'terms' => [
                    ['terms' => [
                            [
                                'name' => 'source',
                                'operator' => '!=',
                                'value' => 'custom',
                            ],
                            [
                                'name' => 'show_link',
                                'value' => 'yes',
                            ],
                        ]
                    ],
                    ['terms' => [
                            [
                                'name' => 'source',
                                'value' => 'custom',
                            ],
                            [
                                'name' => 'posts_url[url]',
                                'operator' => '!=',
                                'value' => ''
                            ],
                        ],
                    ],
                ]
            ],
        ]);

        $this->add_control('layout', [
            'label' => __('Layout', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'label_block' => false,
            'options' => [
                'left' => [
                    'title' => __('Left', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-left',
                ],
                'above' => [
                    'title' => __('Above', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-v-align-top',
                ],
                'right' => [
                    'title' => __('Right', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-right',
                ],
            ],
            'separator' => 'before',
            'prefix_class' => 'author-box--layout-image-',
                ]);

        $this->add_control(
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
            ],
            'prefix_class' => 'author-box--align-',
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_image_style', [
            'label' => __('Image', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'image_vertical_align', [
            'label' => __('Vertical Align', 'hq-widgets-for-elementor'),
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
            ],
            'prefix_class' => 'author-box--image-valign-',
            'condition' => [
                'layout!' => 'above',
            ],
                ]
        );

        $this->add_responsive_control(
                'image_size', [
            'label' => __('Image Size', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 200,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 100,
            ],
            'selectors' => [
                '{{WRAPPER}} .author-box__avatar img' => 'width: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->add_responsive_control(
                'image_gap', [
            'label' => __('Gap', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 25,
            ],
            'selectors' => [
                'body.rtl {{WRAPPER}}.author-box--layout-image-left .author-box__avatar, 
                 body:not(.rtl) {{WRAPPER}}:not(.author-box--layout-image-above) .author-box__avatar' => 'margin-right: {{SIZE}}{{UNIT}}; margin-left: 0;',
                'body:not(.rtl) {{WRAPPER}}.author-box--layout-image-right .author-box__avatar, 
                 body.rtl {{WRAPPER}}:not(.author-box--layout-image-above) .author-box__avatar' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right:0;',
                '{{WRAPPER}}.author-box--layout-image-above .author-box__avatar' => 'margin-bottom: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'image_border',
            'selector' => '{{WRAPPER}} .author-box__avatar img',
                ]
        );

        $this->add_responsive_control(
                'image_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .author-box__avatar img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'image_box_shadow',
            'selector' => '{{WRAPPER}} .author-box__avatar img',
            'fields_options' => [
                'box_shadow_type' => [
                    'separator' => 'default',
                ],
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_text_style', [
            'label' => __('Text', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'heading_name_style', [
            'label' => __('Name', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'name_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .author-box__name' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'name_typography',
            'selector' => '{{WRAPPER}} .author-box__name',
                ]
        );

        $this->add_responsive_control(
                'name_gap', [
            'label' => __('Top Gap', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .author-box__name' => 'margin-top: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->add_control(
                'heading_bio_style', [
            'label' => __('Biography', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'bio_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .author-box__bio' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'bio_typography',
            'selector' => '{{WRAPPER}} .author-box__bio',
                ]
        );

        $this->add_responsive_control(
                'bio_gap', [
            'label' => __('Top Gap', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 15,
            ],
            'selectors' => [
                '{{WRAPPER}} .author-box__bio' => 'margin-top: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_style_button', [
            'label' => 'Button',
            'tab' => Controls_Manager::TAB_STYLE,
            'conditions' => [
                'relation' => 'or',
                'terms' => [
                    [
                        'name' => 'show_link',
                        'value' => 'yes',
                    ],
                    [
                        'name' => 'posts_url[url]',
                        'operator' => '!=',
                        'value' => ''
                    ],
                ]
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'button_typography',
            'selector' => '{{WRAPPER}} .author-box__button',
                ]
        );

        $this->start_controls_tabs('tabs_button_style');

        $this->start_controls_tab(
                'button_normal_tab', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'button_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .author-box__button' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'button_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .author-box__button' => 'background-color: {{VALUE}}',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'button_hover_tab', [
            'label' => __('Hover', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'button_hover_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .author-box__button:hover' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'button_hover_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .author-box__button:hover' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'button_hover_animation', [
            'label' => __('Animation', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HOVER_ANIMATION,
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'button_border',
            'label' => __('Button Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .author-box__button',
            'separator' => 'before'
                ]
        );

        $this->add_responsive_control(
                'button_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .author-box__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'button_gap', [
            'label' => __('Top Gap', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 15,
            ],
            'selectors' => [
                '{{WRAPPER}} .author-box__button' => 'margin-top: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->add_control(
                'button_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .author-box__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before',
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_active_settings();
        $author = [];
        $link_tag = 'div';
        $link_url = '';
        $link_target = '';
        $author_name_tag = $settings['author_name_tag'];
        $custom_src = ( 'custom' === $settings['source'] );

        if ('current' === $settings['source']) {

            $avatar_args['size'] = 300;

            $user_id = get_the_author_meta('ID');
            $author['avatar'] = get_avatar_url($user_id, $avatar_args);
            $author['display_name'] = get_the_author_meta('display_name');
            $author['website'] = get_the_author_meta('user_url');
            $author['bio'] = get_the_author_meta('description');
            $author['posts_url'] = get_author_posts_url($user_id);
        } elseif ($custom_src) {

            if (!empty($settings['author_avatar']['url'])) {
                $avatar_src = $settings['author_avatar']['url'];

                if ($settings['author_avatar']['id']) {
                    $attachment_image_src = wp_get_attachment_image_src($settings['author_avatar']['id'], 'medium');

                    if (!empty($attachment_image_src[0])) {
                        $avatar_src = $attachment_image_src[0];
                    }
                }

                $author['avatar'] = $avatar_src;
            }

            $author['display_name'] = $settings['author_name'];
            $author['website'] = $settings['author_website']['url'];
            $author['bio'] = wpautop($settings['author_bio']);
            $author['posts_url'] = $settings['posts_url']['url'];
        }

        $print_avatar = ( (!$custom_src && 'yes' === $settings['show_avatar'] ) || ( $custom_src && !empty($author['avatar']) ) );
        $print_name = ( (!$custom_src && 'yes' === $settings['show_name'] ) || ( $custom_src && !empty($author['display_name']) ) );
        $print_bio = ( (!$custom_src && 'yes' === $settings['show_biography'] ) || ( $custom_src && !empty($author['bio']) ) );
        $print_link = ( (!$custom_src && 'yes' === $settings['show_link'] ) && !empty($settings['link_text']) || ( $custom_src && !empty($author['posts_url']) && !empty($settings['link_text']) ) );

        if (!empty($settings['link_to']) || $custom_src) {
            if (( $custom_src || 'website' === $settings['link_to'] ) && !empty($author['website'])) {
                $link_tag = 'a';
                $link_url = $author['website'];

                if ($custom_src) {
                    $link_target = $settings['author_website']['is_external'] ? '_blank' : '';
                } else {
                    $link_target = '_blank';
                }
            } elseif ('posts_archive' === $settings['link_to'] && !empty($author['posts_url'])) {
                $link_tag = 'a';
                $link_url = $author['posts_url'];
            }

            if (!empty($link_url)) {
                $this->add_render_attribute('author_link', 'href', esc_url($link_url));

                if (!empty($link_target)) {
                    $this->add_render_attribute('author_link', 'target', $link_target);
                }
            }
        }

        $this->add_render_attribute(
                'button', 'class', [
            'author-box__button',
            'elementor-button',
                ]
        );

        if ($print_link) {
            $this->add_render_attribute('button', 'href', esc_url($author['posts_url']));
        }

        if ($print_link && !empty($settings['button_hover_animation'])) {
            $this->add_render_attribute(
                    'button', 'class', 'elementor-animation-' . $settings['button_hover_animation']
            );
        }

        if ($print_avatar) {
            $this->add_render_attribute('avatar', 'src', $author['avatar']);

            if (!empty($author['display_name'])) {
                $this->add_render_attribute('avatar', 'alt', esc_attr($author['display_name']));
            }
        }
        ?>
        <div class="author-box">
            <?php if ($print_avatar) { ?>
                <<?php echo $link_tag; ?> <?php echo $this->get_render_attribute_string('author_link'); ?> class="author-box__avatar">
                <img <?php echo $this->get_render_attribute_string('avatar'); ?>>
                </<?php echo $link_tag; ?>>
            <?php } ?>

            <div class="author-box__text">
                <?php if ($print_name) : ?>
                    <<?php echo $link_tag; ?> <?php echo $this->get_render_attribute_string('author_link'); ?>>
                    <?php echo '<' . $author_name_tag . ' class="author-box__name">' . esc_html($author['display_name']) . '</' . $author_name_tag . '>'; ?>
                    </<?php echo $link_tag; ?>>
                <?php endif; ?>

                <?php if ($print_bio) : ?>
                    <div class="author-box__bio">
                        <?php echo $author['bio']; ?>
                    </div>
                <?php endif; ?>

                <?php if ($print_link) : ?>
                    <a <?php echo $this->get_render_attribute_string('button'); ?>>
                        <?php echo esc_html($settings['link_text']); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

}
