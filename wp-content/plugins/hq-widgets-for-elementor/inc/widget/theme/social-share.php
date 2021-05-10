<?php

namespace HQWidgetsForElementor\Widget\Theme;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;
use Elementor\Widget_Base;
use Elementor\Repeater;
use const HQWidgetsForElementor\VERSION;
use const HQWidgetsForElementor\PLUGIN_URL;
use const HQWidgetsForElementor\PLUGIN_SLUG;

class Social_Share extends Widget_Base {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);

        wp_register_script('jquery-goodshare', PLUGIN_URL . 'assets/js/jquery.goodshare.min.js', ['jquery'], [], TRUE);
        wp_register_style('hq-theme-social-share', PLUGIN_URL . 'assets/widgets/theme/social-share/style.css', ['elementor-icons-fa-solid'], VERSION);
    }

    public function get_name() {
        return 'hq-theme-social-share';
    }

    public function get_title() {
        return __('Social Share', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-social-share';
    }

    public function get_categories() {
        return [PLUGIN_SLUG];
    }

    public function get_script_depends() {
        return ['jquery-goodshare'];
    }

    public function get_style_depends() {
        return ['hq-theme-social-share'];
    }

    protected function _register_controls() {

        $this->start_controls_section('social_media_sources', [
            'label' => __('Social Share', 'hq-widgets-for-elementor'),
        ]);

        $repeater = new Repeater();

        $repeater->start_controls_tabs('social_share_tabs');

        $repeater->start_controls_tab('social_content_tab', [
            'label' => __('Content', 'hq-widgets-for-elementor'),
        ]);

        $repeater->add_control('social_media', [
            'label' => __('Social Media', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'facebook',
            'options' => [
                'facebook' => __('Facebook', 'hq-widgets-for-elementor'),
                'twitter' => __('Twitter', 'hq-widgets-for-elementor'),
                'googleplus' => __('Google+', 'hq-widgets-for-elementor'),
                'pinterest' => __('Pinterest', 'hq-widgets-for-elementor'),
                'linkedin' => __('Linkedin', 'hq-widgets-for-elementor'),
                'tumblr' => __('tumblr', 'hq-widgets-for-elementor'),
                'vkontakte' => __('Vkontakte', 'hq-widgets-for-elementor'),
                'odnoklassniki' => __('Odnoklassniki', 'hq-widgets-for-elementor'),
                'moimir' => __('Moimir', 'hq-widgets-for-elementor'),
                'livejournal' => __('Live journal', 'hq-widgets-for-elementor'),
                'blogger' => __('Blogger', 'hq-widgets-for-elementor'),
                'digg' => __('Digg', 'hq-widgets-for-elementor'),
                'evernote' => __('Evernote', 'hq-widgets-for-elementor'),
                'reddit' => __('Reddit', 'hq-widgets-for-elementor'),
                'delicious' => __('Delicious', 'hq-widgets-for-elementor'),
                'stumbleupon' => __('Stumbleupon', 'hq-widgets-for-elementor'),
                'pocket' => __('Pocket', 'hq-widgets-for-elementor'),
                'surfingbird' => __('Surfingbird', 'hq-widgets-for-elementor'),
                'liveinternet' => __('Liveinternet', 'hq-widgets-for-elementor'),
                'buffer' => __('Buffer', 'hq-widgets-for-elementor'),
                'instapaper' => __('Instapaper', 'hq-widgets-for-elementor'),
                'xing' => __('Xing', 'hq-widgets-for-elementor'),
                'wordpress' => __('WordPress', 'hq-widgets-for-elementor'),
                'baidu' => __('Baidu', 'hq-widgets-for-elementor'),
                'renren' => __('Renren', 'hq-widgets-for-elementor'),
                'weibo' => __('Weibo', 'hq-widgets-for-elementor'),
                'skype' => __('Skype', 'hq-widgets-for-elementor'),
                'telegram' => __('Telegram', 'hq-widgets-for-elementor'),
                'viber' => __('Viber', 'hq-widgets-for-elementor'),
                'whatsapp' => __('Whatsapp', 'hq-widgets-for-elementor'),
                'line' => __('Line', 'hq-widgets-for-elementor'),
            ],
        ]);

        $repeater->add_control('social_title', [
            'label' => esc_html__('Title', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__('Facebook', 'hq-widgets-for-elementor'),
        ]);

        $repeater->add_control('social_icon', [
            'label' => esc_html__('Icon', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'fab fa-facebook-f',
                'library' => 'fa-brands',
            ],
        ]);

        $repeater->end_controls_tab();

        $repeater->start_controls_tab('social_style_tab', [
            'label' => __('Style', 'hq-widgets-for-elementor'),
        ]);

        $repeater->add_control('heading_style_normal', [
            'label' => __('Normal Style', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
        ]);

        $repeater->add_control('social_text_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-social-share {{CURRENT_ITEM}}' => 'color: {{VALUE}};',
            ],
        ]);

        $repeater->add_group_control(Group_Control_Background::get_type(), [
            'name' => 'social_background_color',
            'label' => __('Background', 'hq-widgets-for-elementor'),
            'types' => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .hq-social-share {{CURRENT_ITEM}}',
        ]);

        $repeater->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'social_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hq-social-share {{CURRENT_ITEM}}',
        ]);

        $repeater->add_control('heading_style_hover', [
            'label' => __('Hover Style', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
        ]);


        $repeater->add_control('social_text_hover_color', [
            'label' => __('Hover color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-social-share {{CURRENT_ITEM}}:hover' => 'color: {{VALUE}};',
            ],
        ]);

        $repeater->add_group_control(Group_Control_Background::get_type(), [
            'name' => 'social_background_hover_color',
            'label' => __('Background', 'hq-widgets-for-elementor'),
            'types' => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .hq-social-share {{CURRENT_ITEM}}:hover',
        ]);

        $repeater->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'social_hover_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hq-social-share {{CURRENT_ITEM}}:hover',
        ]);

        $repeater->end_controls_tab();

        $repeater->start_controls_tab('social_icon_style_tab', [
            'label' => __('Icon Style', 'hq-widgets-for-elementor'),
        ]);

        $repeater->add_control('heading_icon_style_normal', [
            'label' => __('Normal Style', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
        ]);

        $repeater->add_control('social_icon_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-social-share {{CURRENT_ITEM}} i' => 'color: {{VALUE}};',
            ],
        ]);

        $repeater->add_group_control(Group_Control_Background::get_type(), [
            'name' => 'social_icon_background',
            'label' => __('Background', 'hq-widgets-for-elementor'),
            'types' => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .hq-social-share {{CURRENT_ITEM}} i',
        ]);

        $repeater->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'social_icon_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hq-social-share {{CURRENT_ITEM}} i',
        ]);

        $repeater->add_responsive_control('social_icon_border_radius', [
            'label' => esc_html__('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .hq-social-share {{CURRENT_ITEM}} i' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
            ],
        ]);

        $repeater->add_control('heading_icon_style_hover', [
            'label' => __('Hover Style', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
        ]);


        $repeater->add_control('social_icon_hover_color', [
            'label' => __('Hover color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-social-share {{CURRENT_ITEM}}:hover i' => 'color: {{VALUE}};',
            ],
        ]);

        $repeater->add_group_control(Group_Control_Background::get_type(), [
            'name' => 'social_icon_hover_background',
            'label' => __('Background', 'hq-widgets-for-elementor'),
            'types' => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .hq-social-share {{CURRENT_ITEM}}:hover i',
        ]);

        $repeater->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'social_icon_hover_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hq-social-share {{CURRENT_ITEM}}:hover i',
        ]);

        $repeater->end_controls_tab();

        $repeater->end_controls_tabs();

        $this->add_control('hq_social_media_list', [
            'type' => Controls_Manager::REPEATER,
            'fields' => array_values($repeater->get_controls()),
            'default' => [
                [
                    'social_media' => 'facebook',
                    'social_title' => __('Facebook', 'hq-widgets-for-elementor'),
                    'social_icon' => [
                        'value' => 'fab fa-facebook-f',
                        'library' => 'fa-brands'
                    ],
                ],
                [
                    'social_media' => 'twitter',
                    'social_title' => __('Twitter', 'hq-widgets-for-elementor'),
                    'social_icon' => [
                        'value' => 'fab fa-twitter',
                        'library' => 'fa-brands'
                    ],
                ],
                [
                    'social_media' => 'googleplus',
                    'social_title' => __('Google Plus', 'hq-widgets-for-elementor'),
                    'social_icon' => [
                        'value' => 'fab fa-google-plus-g',
                        'library' => 'fa-brands'
                    ],
                ],
            ],
            'title_field' => '{{{social_title}}}',
        ]);

        $this->end_controls_section();

        $this->start_controls_section('social_share_options', [
            'label' => __('Options', 'hq-widgets-for-elementor'),
        ]);

        $this->add_control(
                'layout', [
            'label' => __('Layout', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'default' => 'row',
            'toggle' => false,
            'options' => [
                'row' => [
                    'title' => __('Inline', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-ellipsis-h',
                ],
                'column' => [
                    'title' => __('Block', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-editor-list-ul',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .hq-social-share ul' => 'flex-direction: {{VALUE}};',
            ],
                ]
        );

        $this->add_responsive_control('social_alignment', [
            'label' => esc_html__('Alignment', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'flex-start' => [
                    'title' => esc_html__('Left', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-left',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-center',
                ],
                'flex-end' => [
                    'title' => esc_html__('Right', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-right',
                ],
                'space-between' => [
                    'title' => esc_html__('Justify', 'hq-widgets-for-elementor'),
                    'icon' => 'eicon-h-align-stretch',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .hq-social-share ul' => 'justify-content: {{VALUE}};',
            ],
        ]);

        $this->add_control('social_view', [
            'label' => esc_html__('View', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'label_block' => false,
            'options' => [
                'icon' => 'Icon',
                'title' => 'Title',
                'icon-title' => 'Icon & Title',
            ],
            'default' => 'icon-title',
        ]);

        $this->end_controls_section();

        $this->start_controls_section('social_share_style_section', [
            'label' => __('Style', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('social_share_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hq-social-share ul li' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'social_share_title_typography',
            'selector' => '{{WRAPPER}} .hq-social-share ul li span',
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name' => 'social_share_background',
            'label' => __('Background', 'hq-widgets-for-elementor'),
            'types' => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .hq-social-share li',
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'social_share_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hq-social-share li',
        ]);

        $this->add_responsive_control('social_share_border_radius', [
            'label' => esc_html__('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .hq-social-share li' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
            ],
            'separator' => 'before',
        ]);

        $this->add_responsive_control('social_share_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .hq-social-share ul li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('social_share_margin', [
            'label' => __('Margin', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .hq-social-share ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('social_share_icon_style_section', [
            'label' => __('Icon', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'social_view' => array('icon-title', 'icon'),
            ]
        ]);

        $this->add_control('social_icon_size', [
            'label' => __('Icon Size', 'hq-widgets-for-elementor'),
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
                '{{WRAPPER}} .hq-social-share ul li i' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .hq-social-share ul li svg' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name' => 'social_icon_background',
            'label' => __('Background', 'hq-widgets-for-elementor'),
            'types' => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .hq-social-share li i,{{WRAPPER}} .hq-social-share li svg',
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'social_icon_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '{{WRAPPER}} .hq-social-share li i,{{WRAPPER}} .hq-social-share li svg',
        ]);

        $this->add_responsive_control('social_icon_border_radius', [
            'label' => esc_html__('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .hq-social-share li i' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                '{{WRAPPER}} .hq-social-share li svg' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
            ],
        ]);

        $this->add_control('social_icon_height', [
            'label' => __('Icon Height', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ]
            ],
            'default' => [
                'unit' => 'px',
                'size' => 42,
            ],
            'selectors' => [
                '{{WRAPPER}} .hq-social-share ul li i' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .hq-social-share ul li svg' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('social_icon_width', [
            'label' => __('Icon Width', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ]
            ],
            'default' => [
                'unit' => 'px',
                'size' => 42,
            ],
            'selectors' => [
                '{{WRAPPER}} .hq-social-share ul li i' => 'width: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .hq-social-share ul li svg' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render($instance = []) {

        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('hq_social_share', 'class', 'hq-social-share hq-social-style-1');
        if ('icon-title' === $settings['social_view'] || 'title' === $settings['social_view']) {
            $this->add_render_attribute('hq_social_share', 'class', 'hq-social-view-' . $settings['social_view']);
        }
        ?>
        <div <?php echo $this->get_render_attribute_string('hq_social_share'); ?> >
            <ul>
                <?php foreach ($settings['hq_social_media_list'] as $socialmedia) : ?>
                    <li class="elementor-repeater-item-<?php echo $socialmedia['_id']; ?>" data-social="<?php echo esc_attr($socialmedia['social_media']); ?>" > 
                        <?php
                        if ($settings['social_view'] == 'icon') {
                            Icons_Manager::render_icon($socialmedia['social_icon'], ['aria-hidden' => 'true']);
                        } elseif ($settings['social_view'] == 'title') {
                            echo sprintf('<span>%1$s</span>', $socialmedia['social_title']);
                        } else {
                            ob_start();
                            Icons_Manager::render_icon($socialmedia['social_icon'], ['aria-hidden' => 'true']);
                            $icon = ob_get_clean();
                            echo sprintf('%1$s<span>%2$s</span>', $icon, $socialmedia['social_title']);
                        }
                        ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
    }

}
