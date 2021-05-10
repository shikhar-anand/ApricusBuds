<?php

namespace HQWidgetsForElementor\Widget\Theme;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Plugin;
use Elementor\Repeater;
use HQWidgetsForElementor\Widget\Theme\Posts;
use const HQWidgetsForElementor\PLUGIN_SLUG;
use const HQWidgetsForElementor\PLUGIN_URL;
use const HQWidgetsForElementor\VERSION;

class Post_Meta_Data extends Posts {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        wp_register_style('hq-theme-post-meta-data', PLUGIN_URL . 'assets/widgets/theme/post-meta-data/style.css', ['elementor-icons-fa-solid'], VERSION);
    }

    public function get_name() {
        return 'hq-theme-post-meta-data';
    }

    public function get_title() {
        return __('Post Meta Data', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-menu-dots-horizontal';
    }

    public function get_style_depends() {
        return ['hq-theme-post-meta-data'];
    }

    public function get_categories() {
        return [PLUGIN_SLUG];
    }

    public function get_keywords() {
        return ['post', 'info', 'data', 'date', 'time', 'author', 'taxonomy', 'comments', 'terms', 'avatar'];
    }

    protected function _register_controls() {

        $this->register_test_post_item_section_controls();

        $this->start_controls_section('section_icon', [
            'label' => __('Meta Data', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control('layout', [
            'label' => __('Layout', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'default' => 'inline',
            'options' => [
                'block' => [
                    'title' => __('Default', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-editor-list-ul',
                ],
                'inline' => [
                    'title' => __('Inline', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-ellipsis-h',
                ],
            ],
        ]);

        $repeater = new Repeater();

        $repeater->add_control('type', [
            'label' => __('Type', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'date',
            'options' => [
                'author' => __('Author', 'hq-widgets-for-elementor'),
                'date' => __('Date', 'hq-widgets-for-elementor'),
                'time' => __('Time', 'hq-widgets-for-elementor'),
                'comments' => __('Comments', 'hq-widgets-for-elementor'),
                'terms' => __('Terms', 'hq-widgets-for-elementor'),
                'custom' => __('Custom', 'hq-widgets-for-elementor'),
            ],
        ]);

        $repeater->add_control('date_format', [
            'label' => __('Date Format', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'default',
            'options' => [
                'default' => 'Default',
                '0' => _x('June 15, 2018 (F j, Y)', 'Date Format', 'hq-widgets-for-elementor'),
                '1' => '2019-06-15 (Y-m-d)',
                '2' => '06/15/2019 (m/d/Y)',
                '3' => '15/06/2019 (d/m/Y)',
                'custom' => __('Custom', 'hq-widgets-for-elementor'),
            ],
            'condition' => [
                'type' => 'date',
            ],
        ]);

        $repeater->add_control('custom_date_format', [
            'label' => __('Custom Date Format', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => 'F j, Y',
            'condition' => [
                'type' => 'date',
                'date_format' => 'custom',
            ],
            'description' => sprintf(
                    /* translators: %s: Allowed data letters (see: http://php.net/manual/en/function.date.php). */
                    __('Use the letters: %s', 'hq-widgets-for-elementor'), 'l D d j S F m M n Y y'
            ),
        ]);

        $repeater->add_control('time_format', [
            'label' => __('Time Format', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'default',
            'options' => [
                'default' => 'Default',
                '0' => '5:22 pm (g:i a)',
                '1' => '5:22 PM (g:i A)',
                '2' => '17:22 (H:i)',
                'custom' => __('Custom', 'hq-widgets-for-elementor'),
            ],
            'condition' => [
                'type' => 'time',
            ],
        ]);

        $repeater->add_control('custom_time_format', [
            'label' => __('Custom Time Format', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => 'g:i a',
            'placeholder' => 'g:i a',
            'condition' => [
                'type' => 'time',
                'time_format' => 'custom',
            ],
            'description' => sprintf(
                    /* translators: %s: Allowed time letters (see: http://php.net/manual/en/function.time.php). */
                    __('Use the letters: %s', 'hq-widgets-for-elementor'), 'g G H i a A'
            ),
        ]);

        $repeater->add_control('taxonomy', [
            'label' => __('Taxonomy', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT2,
            'default' => [],
            'options' => $this->get_taxonomies(),
            'condition' => [
                'type' => 'terms',
            ],
        ]);

        $repeater->add_control('terms_limit', [
            'label' => __('Limit', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'min' => 0,
            'condition' => [
                'type' => 'terms',
                'taxonomy!' => '',
            ],
        ]);

        $repeater->add_control('text_prefix', [
            'label' => __('Before', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'condition' => [
                'type!' => 'custom',
            ],
        ]);

        $repeater->add_control('show_avatar', [
            'label' => __('Avatar', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'condition' => [
                'type' => 'author',
            ],
        ]);

        $repeater->add_responsive_control('avatar_size', [
            'label' => __('Size', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} .elementor-icon-list-icon' => 'width: {{SIZE}}{{UNIT}}',
            ],
            'condition' => [
                'show_avatar' => 'yes',
            ],
        ]);

        $repeater->add_control('comments_custom_strings', [
            'label' => __('Custom Format', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'default' => false,
            'condition' => [
                'type' => 'comments',
            ],
        ]);

        $repeater->add_control('string_no_comments', [
            'label' => __('No Comments', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'placeholder' => __('No Comments', 'hq-widgets-for-elementor'),
            'condition' => [
                'comments_custom_strings' => 'yes',
                'type' => 'comments',
            ],
        ]);

        $repeater->add_control('string_one_comment', [
            'label' => __('One Comment', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'placeholder' => __('One Comment', 'hq-widgets-for-elementor'),
            'condition' => [
                'comments_custom_strings' => 'yes',
                'type' => 'comments',
            ],
        ]);

        $repeater->add_control('string_comments', [
            'label' => __('Comments', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'placeholder' => __('%s Comments', 'hq-widgets-for-elementor'),
            'condition' => [
                'comments_custom_strings' => 'yes',
                'type' => 'comments',
            ],
        ]);

        $repeater->add_control('custom_text', [
            'label' => __('Custom', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'dynamic' => [
                'active' => true,
            ],
            'condition' => [
                'type' => 'custom',
            ],
        ]);

        $repeater->add_control('link', [
            'label' => __('Link', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => [
                'type!' => 'time',
            ],
        ]);

        $repeater->add_control('custom_url', [
            'label' => __('Custom URL', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::URL,
            'dynamic' => [
                'active' => true,
            ],
            'condition' => [
                'type' => 'custom',
            ],
        ]);

        $repeater->add_control('show_icon', [
            'label' => __('Icon', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'none' => __('None', 'hq-widgets-for-elementor'),
                'custom' => __('Custom', 'hq-widgets-for-elementor'),
            ],
            'default' => 'custom',
            'condition' => [
                'show_avatar!' => 'yes',
            ],
        ]);

        $repeater->add_control('icon', [
            'label' => __('Choose Icon', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::ICONS,
            'condition' => [
                'show_icon' => 'custom',
                'show_avatar!' => 'yes',
            ],
        ]);

        $this->add_control(
                'icon_list', [
            'label' => 'Content',
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                [
                    'type' => 'author',
                    'icon' => [
                        'value' => 'far fa-user-circle',
                        'library' => 'fa-regular',
                    ]
                ],
                [
                    'type' => 'date',
                    'icon' => [
                        'value' => 'far fa-calendar-alt',
                        'library' => 'fa-regular',
                    ]
                ],
                [
                    'type' => 'time',
                    'icon' => [
                        'value' => 'far fa-clock',
                        'library' => 'fa-regular',
                    ]
                ],
                [
                    'type' => 'comments',
                    'icon' => [
                        'value' => 'far fa-comment-dots',
                        'library' => 'fa-regular',
                    ]
                ],
            ],
            'separator' => 'before',
            'title_field' => '<i class="{{ icon.value }}" aria-hidden="true"></i> <span style="text-transform: capitalize;">{{{ type }}}</span>',
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_icon_list', [
            'label' => __('List', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_responsive_control(
                'space_between', [
            'label' => __('Space Between', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'max' => 50,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-icon-list-items:not(.elementor-inline-items) .elementor-icon-list-item:not(:last-child)' => 'padding-bottom: calc({{SIZE}}{{UNIT}}/2)',
                '{{WRAPPER}} .elementor-icon-list-items:not(.elementor-inline-items) .elementor-icon-list-item:not(:first-child)' => 'margin-top: calc({{SIZE}}{{UNIT}}/2)',
                '{{WRAPPER}} .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item' => 'margin-right: calc({{SIZE}}{{UNIT}}/2); margin-left: calc({{SIZE}}{{UNIT}}/2)',
                '{{WRAPPER}} .elementor-icon-list-items.elementor-inline-items' => 'margin-right: calc(-{{SIZE}}{{UNIT}}/2); margin-left: calc(-{{SIZE}}{{UNIT}}/2)',
                'body.rtl {{WRAPPER}} .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item:after' => 'left: calc(-{{SIZE}}{{UNIT}}/2)',
                'body:not(.rtl) {{WRAPPER}} .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item:after' => 'right: calc(-{{SIZE}}{{UNIT}}/2)',
            ],
                ]
        );

        $this->add_responsive_control(
                'icon_align', [
            'label' => __('Alignment', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Start', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-center',
                ],
                'right' => [
                    'title' => __('End', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-right',
                ],
            ],
            'prefix_class' => 'elementor%s-align-',
                ]
        );

        $this->add_control(
                'heading_items', [
            'label' => __('Items', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before'
                ]
        );

        $this->add_responsive_control(
                'item_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .elementor-icon-list-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_control(
                'divider', [
            'label' => __('Divider', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_off' => __('Off', 'hq-widgets-for-elementor'),
            'label_on' => __('On', 'hq-widgets-for-elementor'),
            'selectors' => [
                '{{WRAPPER}} .elementor-icon-list-item:not(:last-child):after' => 'content: ""',
            ],
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'divider_style', [
            'label' => __('Style', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'solid' => __('Solid', 'hq-widgets-for-elementor'),
                'double' => __('Double', 'hq-widgets-for-elementor'),
                'dotted' => __('Dotted', 'hq-widgets-for-elementor'),
                'dashed' => __('Dashed', 'hq-widgets-for-elementor'),
            ],
            'default' => 'solid',
            'condition' => [
                'divider' => 'yes',
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-icon-list-items:not(.elementor-inline-items) .elementor-icon-list-item:not(:last-child):after' => 'border-top-style: {{VALUE}};',
                '{{WRAPPER}} .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item:not(:last-child):after' => 'border-left-style: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'divider_weight', [
            'label' => __('Weight', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'unit' => 'px',
                'size' => 1,
            ],
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 20,
                ],
            ],
            'condition' => [
                'divider' => 'yes',
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-icon-list-items:not(.elementor-inline-items) .elementor-icon-list-item:not(:last-child):after' => 'border-top-width: {{SIZE}}{{UNIT}}',
                '{{WRAPPER}} .elementor-inline-items.elementor-inline-items .elementor-icon-list-item:not(:last-child):after' => 'border-left-width: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->add_control(
                'divider_width', [
            'label' => __('Width', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['%', 'px'],
            'default' => [
                'unit' => '%',
            ],
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 100,
                ],
                '%' => [
                    'min' => 1,
                    'max' => 100,
                ],
            ],
            'condition' => [
                'divider' => 'yes',
                'layout!' => 'inline',
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-icon-list-item:not(:last-child):after' => 'width: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->add_control(
                'divider_height', [
            'label' => __('Height', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['%', 'px'],
            'default' => [
                'unit' => '%',
            ],
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 100,
                ],
                '%' => [
                    'min' => 1,
                    'max' => 100,
                ],
            ],
            'condition' => [
                'divider' => 'yes',
                'layout' => 'inline',
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-icon-list-item:not(:last-child):after' => 'height: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->add_control(
                'divider_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ddd',
            'condition' => [
                'divider' => 'yes',
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-icon-list-item:not(:last-child):after' => 'border-color: {{VALUE}};',
            ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_icon_style', [
            'label' => __('Icon', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'icon_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .elementor-icon-list-icon i' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'icon_size', [
            'label' => __('Size', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 14,
            ],
            'range' => [
                'px' => [
                    'min' => 6,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-icon-list-icon' => 'width: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .elementor-icon-list-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
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

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'text_typography',
            'selector' => '{{WRAPPER}} .elementor-icon-list-text',
                ]
        );

        $this->add_control(
                'text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .elementor-icon-list-text' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'text_indent', [
            'label' => __('Indent', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'max' => 50,
                ],
            ],
            'selectors' => [
                'body:not(.rtl) {{WRAPPER}} .elementor-icon-list-text' => 'padding-left: {{SIZE}}{{UNIT}}',
                'body.rtl {{WRAPPER}} .elementor-icon-list-text' => 'padding-right: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->add_control(
                'links_heading', [
            'label' => __('Links', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before'
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'link_typography',
            'selector' => '{{WRAPPER}} a .elementor-icon-list-text, {{WRAPPER}} .elementor-icon-list-text a',
                ]
        );

        $this->start_controls_tabs(
                'links_tabs', []
        );

        $this->start_controls_tab(
                'tab_link_normal', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'link_text_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} a .elementor-icon-list-text, {{WRAPPER}} .elementor-icon-list-text a' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_link_hover', [
            'label' => __('Hover', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'link_text_hover_color', [
            'label' => __('Text Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} a:hover .elementor-icon-list-text, {{WRAPPER}} .elementor-icon-list-text a:hover' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function get_taxonomies() {
        $taxonomies = get_taxonomies([
            'show_in_nav_menus' => true,
                ], 'objects');

        $options = [
            '' => __('Choose', 'hq-widgets-for-elementor'),
        ];

        foreach ($taxonomies as $taxonomy) {
            $options[$taxonomy->name] = $taxonomy->label;
        }

        return $options;
    }

    protected function get_meta_data($repeater_item) {
        $item_data = [];

        switch ($repeater_item['type']) {
            case 'author':
                $item_data['text'] = get_the_author_meta('display_name');
                $item_data['icon'] = [
                    'value' => 'far fa-user-circle',
                    'library' => 'fa-regular',
                ];
                $item_data['itemprop'] = 'author';

                if ('yes' === $repeater_item['link']) {
                    $item_data['url'] = [
                        'url' => get_author_posts_url(get_the_author_meta('ID')),
                    ];
                }

                if ('yes' === $repeater_item['show_avatar']) {
                    $item_data['image'] = get_avatar_url(get_the_author_meta('ID'), 96);
                }

                break;

            case 'date':
                $custom_date_format = empty($repeater_item['custom_date_format']) ? 'F j, Y' : $repeater_item['custom_date_format'];

                $format_options = [
                    'default' => 'F j, Y',
                    '0' => 'F j, Y',
                    '1' => 'Y-m-d',
                    '2' => 'm/d/Y',
                    '3' => 'd/m/Y',
                    'custom' => $custom_date_format,
                ];

                $item_data['text'] = get_the_time($format_options[$repeater_item['date_format']]);
                $item_data['icon'] = [
                    'value' => 'far fa-calendar-alt',
                    'library' => 'fa-regular',
                ];
                $item_data['itemprop'] = 'datePublished';

                if ('yes' === $repeater_item['link']) {
                    $item_data['url'] = [
                        'url' => get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j')),
                    ];
                }
                break;

            case 'time':
                $custom_time_format = empty($repeater_item['custom_time_format']) ? 'g:i a' : $repeater_item['custom_time_format'];

                $format_options = [
                    'default' => 'g:i a',
                    '0' => 'g:i a',
                    '1' => 'g:i A',
                    '2' => 'H:i',
                    'custom' => $custom_time_format,
                ];
                $item_data['text'] = get_the_time($format_options[$repeater_item['time_format']]);
                $item_data['icon'] = [
                    'value' => 'far fa-clock',
                    'library' => 'fa-regular',
                ];
                break;

            case 'comments':
                if (comments_open()) {
                    $default_strings = [
                        'string_no_comments' => __('No Comments', 'hq-widgets-for-elementor'),
                        'string_one_comment' => __('One Comment', 'hq-widgets-for-elementor'),
                        'string_comments' => __('%s Comments', 'hq-widgets-for-elementor'),
                    ];

                    if ('yes' === $repeater_item['comments_custom_strings']) {
                        if (!empty($repeater_item['string_no_comments'])) {
                            $default_strings['string_no_comments'] = $repeater_item['string_no_comments'];
                        }

                        if (!empty($repeater_item['string_one_comment'])) {
                            $default_strings['string_one_comment'] = $repeater_item['string_one_comment'];
                        }

                        if (!empty($repeater_item['string_comments'])) {
                            $default_strings['string_comments'] = $repeater_item['string_comments'];
                        }
                    }

                    $num_comments = (int) get_comments_number(); // get_comments_number returns only a numeric value

                    if (0 === $num_comments) {
                        $item_data['text'] = $default_strings['string_no_comments'];
                    } else {
                        $item_data['text'] = sprintf(_n($default_strings['string_one_comment'], $default_strings['string_comments'], $num_comments, 'hq-widgets-for-elementor'), $num_comments);
                    }

                    if ('yes' === $repeater_item['link']) {
                        $item_data['url'] = [
                            'url' => get_comments_link(),
                        ];
                    }
                    $item_data['icon'] = [
                        'value' => 'far fa-comment-dots',
                        'library' => 'fa-regular',
                    ];
                    $item_data['itemprop'] = 'commentCount';
                }
                break;

            case 'terms':
                $item_data['icon'] = [
                    'value' => 'fas fa-tags',
                    'library' => 'fa-solid',
                ];
                $item_data['itemprop'] = 'about';
                $item_data['args'] = [
                    'number' => $repeater_item['terms_limit'],
                ];

                $taxonomy = $repeater_item['taxonomy'];
                $terms = wp_get_post_terms(get_the_ID(), $taxonomy, $item_data['args']);
                foreach ($terms as $term) {
                    $item_data['terms_list'][$term->term_id]['text'] = $term->name;
                    if ('yes' === $repeater_item['link']) {
                        $item_data['terms_list'][$term->term_id]['url'] = get_term_link($term);
                    }
                }
                break;

            case 'custom':
                $item_data['text'] = $repeater_item['custom_text'];
                $item_data['icon'] = [
                    'value' => 'fas fa-info-circle',
                    'library' => 'fa-solid',
                ];

                if ('yes' === $repeater_item['link'] && !empty($repeater_item['custom_url'])) {
                    $item_data['url'] = $repeater_item['custom_url'];
                }

                break;
        }

        $item_data['type'] = $repeater_item['type'];

        if (!empty($repeater_item['text_prefix'])) {
            $item_data['text_prefix'] = esc_html($repeater_item['text_prefix']);
        }

        return $item_data;
    }

    protected function render_item($repeater_item) {
        $item_data = $this->get_meta_data($repeater_item);
        $repeater_index = $repeater_item['_id'];

        if (empty($item_data['text']) && empty($item_data['terms_list'])) {
            return;
        }

        $has_link = false;
        $link_key = 'link_' . $repeater_index;
        $item_key = 'item_' . $repeater_index;

        $this->add_render_attribute($item_key, 'class', [
            'elementor-icon-list-item',
            'elementor-repeater-item-' . $repeater_item['_id'],
                ]
        );

        $active_settings = $this->get_active_settings();

        if ('inline' === $active_settings['layout']) {
            $this->add_render_attribute($item_key, 'class', 'elementor-inline-item');
        }

        if (!empty($item_data['url']['url'])) {
            $has_link = true;

            $url = $item_data['url'];
            $this->add_render_attribute($link_key, 'href', $url['url']);

            if (!empty($url['is_external'])) {
                $this->add_render_attribute($link_key, 'target', '_blank');
            }

            if (!empty($url['nofollow'])) {
                $this->add_render_attribute($link_key, 'rel', 'nofollow');
            }
        }

        if (!empty($item_data['itemprop'])) {
            $this->add_render_attribute($item_key, 'itemprop', $item_data['itemprop']);
        }
        ?>
        <li <?php echo $this->get_render_attribute_string($item_key); ?>>
            <?php if ($has_link) : ?>
                <a <?php echo $this->get_render_attribute_string($link_key); ?>>
                <?php endif; ?>
                <?php $this->render_item_icon_or_image($item_data, $repeater_item, $repeater_index); ?>
                <?php $this->render_item_text($item_data, $repeater_index); ?>
                <?php if ($has_link) : ?>
                </a>
            <?php endif; ?>
        </li>
        <?php
    }

    protected function render_item_icon_or_image($item_data, $repeater_item, $repeater_index) {

        if ('custom' === $repeater_item['show_icon'] && !empty($repeater_item['icon'])) {
            $item_data['icon'] = $repeater_item['icon'];
        } elseif ('none' === $repeater_item['show_icon']) {
            $item_data['icon'] = '';
        }

        if (empty($item_data['icon']['value']) && empty($item_data['image'])) {
            return;
        }
        ?>
        <span class="elementor-icon-list-icon">
            <?php
            if (!empty($item_data['image'])) :
                $image_data = 'image_' . $repeater_index;
                $this->add_render_attribute($image_data, 'src', $item_data['image']);
                $this->add_render_attribute($image_data, 'alt', $item_data['text']);
                ?>
                <img class="elementor-avatar" <?php echo $this->get_render_attribute_string($image_data); ?>>
            <?php else : ?>
                <?php Icons_Manager::render_icon($item_data['icon'], ['aria-hidden' => 'true']); ?>
            <?php endif; ?>
        </span>
        <?php
    }

    protected function render_item_text($item_data, $repeater_index) {
        $repeater_setting_key = $this->get_repeater_setting_key('text', 'icon_list', $repeater_index);

        $this->add_render_attribute($repeater_setting_key, 'class', ['elementor-icon-list-text', 'elementor-post-data__item', 'elementor-post-data__item--type-' . $item_data['type']]);
        if (!empty($item['terms_list'])) {
            $this->add_render_attribute($repeater_setting_key, 'class', 'elementor-terms-list');
        }
        ?>
        <span <?php echo $this->get_render_attribute_string($repeater_setting_key); ?>>
            <?php if (!empty($item_data['text_prefix'])) : ?>
                <span class="elementor-post-data__item-prefix"><?php echo esc_html($item_data['text_prefix']); ?> </span>
            <?php endif; ?>
            <?php
            if (!empty($item_data['terms_list'])) :
                $terms_list = [];
                $item_class = 'elementor-post-meta-data__terms-list-item';
                ?>
                <span class="elementor-post-meta-data__terms-list">
                    <?php
                    foreach ($item_data['terms_list'] as $term) :
                        if (!empty($term['url'])) :
                            $terms_list[] = '<a href="' . esc_attr($term['url']) . '" class="' . $item_class . '">' . esc_html($term['text']) . '</a>';
                        else :
                            $terms_list[] = '<span class="' . $item_class . '">' . esc_html($term['text']) . '</span>';
                        endif;
                    endforeach;

                    echo implode(', ', $terms_list);
                    ?>
                </span>
            <?php else : ?>
                <?php
                echo wp_kses($item_data['text'], [
                    'a' => [
                        'href' => [],
                        'title' => [],
                        'rel' => [],
                    ],
                ]);
                ?>
            <?php endif; ?>
        </span>
        <?php
    }

    protected function render() {
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
        }

        ob_start();
        if (!empty($settings['icon_list'])) {
            foreach ($settings['icon_list'] as $repeater_item) {
                $this->render_item($repeater_item);
            }
        }
        $items_html = ob_get_clean();

        if (empty($items_html)) {
            return;
        }

        if ('inline' === $settings['layout']) {
            $this->add_render_attribute('icon_list', 'class', 'elementor-inline-items');
        }

        $this->add_render_attribute('icon_list', 'class', ['elementor-icon-list-items', 'elementor-post-meta-data']);
        ?>
        <ul <?php echo $this->get_render_attribute_string('icon_list'); ?>>
            <?php echo $items_html; ?>
        </ul>
        <?php
        // Rollback to the previous global post
        if (Plugin::instance()->editor->is_edit_mode()) {
            Plugin::instance()->db->restore_current_post();
        }
    }

}
