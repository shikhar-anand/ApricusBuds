<?php

namespace HQWidgetsForElementor\Widget\Theme;

defined('ABSPATH') || exit;

use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Widget_Base;
use const HQWidgetsForElementor\VERSION;
use const HQWidgetsForElementor\PLUGIN_URL;
use const HQWidgetsForElementor\PLUGIN_SLUG;

class Countdown_Timer extends Widget_Base {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);

        wp_register_script('jquery-countdownTimer', PLUGIN_URL . 'assets/js/jquery.countdownTimer.min.js', ['jquery'], '2.0.1', TRUE);
        wp_register_script('hq-theme-countdown-timer', PLUGIN_URL . 'assets/widgets/theme/countdown-timer/script.js', ['jquery-countdownTimer', 'elementor-frontend'], VERSION, true);
        wp_register_style('hq-theme-countdown-timer', PLUGIN_URL . 'assets/widgets/theme/countdown-timer/style.css', [], VERSION);
    }

    public function get_name() {
        return 'hq-theme-countdown-timer';
    }

    public function get_title() {
        return __('Countdown Timer', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-chronometer';
    }

    public function get_script_depends() {
        return ['hq-theme-countdown-timer'];
    }

    public function get_style_depends() {
        return ['hq-theme-countdown-timer'];
    }

    public function get_categories() {
        return [PLUGIN_SLUG];
    }

    protected function _register_controls() {
        $this->start_controls_section(
                'section', [
            'label' => __('Countdown', 'hq-widgets-for-elementor'),
                ]
        );
        $this->add_control(
                'widget_id', [
            'type' => Controls_Manager::HIDDEN,
            'frontend_available' => true,
            'default' => esc_attr($this->get_id()),
                ]
        );
        $this->add_control(
                'timer_mode', [
            'label' => __('Timer Mode', 'hq-widgets-for-elementor'),
            'label_block' => false,
            'type' => Controls_Manager::SELECT,
            'description' => __('Select whether you want to set end date or time interval', 'hq-widgets-for-elementor'),
            'frontend_available' => true,
            'options' => [
                'date' => __('End Date', 'hq-widgets-for-elementor'),
                'interval' => __('Time Interval', 'hq-widgets-for-elementor')
            ],
            'default' => 'date'
                ]
        );

        $this->add_control(
                'dateAndTime', [
            'label' => __('End Date', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DATE_TIME,
            'default' => date('Y-m-d H:i', strtotime('+1 day') + ( get_option('gmt_offset') * HOUR_IN_SECONDS )),
            'description' => sprintf(__('Date set according to your timezone: %s.', 'hq-widgets-for-elementor'), Utils::get_timezone_string()),
            'frontend_available' => true,
            'separator' => 'before',
            'condition' => [
                'timer_mode' => 'date'
            ]
                ]
        );

        $this->add_control(
                'heading_interval_setup', [
            'label' => __('Interval setup', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => [
                'timer_mode' => 'interval'
            ],
                ]
        );

        $this->add_control(
                'days', [
            'label' => __('Days', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 0,
            'frontend_available' => true,
            'condition' => [
                'timer_mode' => 'interval'
            ],
                ]
        );
        $this->add_control(
                'hours', [
            'label' => __('Hours', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 0,
            'frontend_available' => true,
            'condition' => [
                'timer_mode' => 'interval'
            ],
                ]
        );
        $this->add_control(
                'minutes', [
            'label' => __('Minutes', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 10,
            'frontend_available' => true,
            'condition' => [
                'timer_mode' => 'interval'
            ],
                ]
        );
        $this->add_control(
                'seconds', [
            'label' => __('Seconds', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 0,
            'frontend_available' => true,
            'condition' => [
                'timer_mode' => 'interval'
            ],
                ]
        );

        $this->add_control(
                'labelsFormat', [
            'label' => __('Labels Format', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'separator' => 'before',
            'frontend_available' => true,
                ]
        );

        $this->add_responsive_control(
                'timer_max_width', [
            'label' => __('Timer Max Width', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 1000,
                    'step' => 10,
                ],
                '%' => [
                    'min' => 0,
                    'max' => 100,
                ]
            ],
            'default' => [
                'size' => 300,
                'unit' => 'px'
            ],
            'selectors' => [
                '{{WRAPPER}} .countdown-timer-widget' => 'max-width: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->add_control(
                'heading_timer_elements', [
            'label' => __('Timer Elements', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before'
                ]
        );

        $this->add_control(
                'show_days', [
            'label' => __('Days', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Show', 'hq-widgets-for-elementor'),
            'label_off' => __('Hide', 'hq-widgets-for-elementor'),
            'return_value' => 'yes',
            'frontend_available' => true,
                ]
        );
        $this->add_control(
                'show_hours', [
            'label' => __('Hours', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Show', 'hq-widgets-for-elementor'),
            'label_off' => __('Hide', 'hq-widgets-for-elementor'),
            'return_value' => 'yes',
            'default' => 'yes',
            'frontend_available' => true,
                ]
        );
        $this->add_control(
                'show_minutes', [
            'label' => __('Minutes', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Show', 'hq-widgets-for-elementor'),
            'label_off' => __('Hide', 'hq-widgets-for-elementor'),
            'return_value' => 'yes',
            'default' => 'yes',
            'frontend_available' => true,
                ]
        );
        $this->add_control(
                'show_seconds', [
            'label' => __('Seconds', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Show', 'hq-widgets-for-elementor'),
            'label_off' => __('Hide', 'hq-widgets-for-elementor'),
            'return_value' => 'yes',
            'default' => 'yes',
            'frontend_available' => true,
                ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
                'expire_section', [
            'label' => __('Countdown Expire', 'hq-widgets-for-elementor')
                ]
        );
        $this->add_control(
                'expire_show_type', [
            'label' => __('Expire Type', 'hq-widgets-for-elementor'),
            'label_block' => false,
            'type' => Controls_Manager::SELECT,
            'description' => __('Select whether you want to set a message or a redirect link after expire countdown', 'hq-widgets-for-elementor'),
            'options' => [
                'message' => __('Message', 'hq-widgets-for-elementor'),
                'redirect_link' => __('Redirect to Link', 'hq-widgets-for-elementor')
            ],
            'default' => 'message',
            'frontend_available' => true,
                ]
        );
        $this->add_control(
                'expire_message', [
            'label' => __('Expire Message', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXTAREA,
            'frontend_available' => true,
            'default' => __('Sorry you are late!', 'hq-widgets-for-elementor'),
            'condition' => [
                'expire_show_type' => 'message'
            ]
                ]
        );
        $this->add_control(
                'expire_redirect_link', [
            'label' => __('Redirect On', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::URL,
            'frontend_available' => true,
            'condition' => [
                'expire_show_type' => 'redirect_link'
            ],
                ]
        );

        $this->end_controls_section();

        //TODO
        $this->start_controls_section(
                'label_text_section', [
            'label' => __('Change Labels Text', 'hq-widgets-for-elementor'),
            'condition' => [
                'labelsFormat' => 'TODOOOOO'
            ]
                ]
        );

        $this->add_control(
                'label_days', [
            'label' => __('Days', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Days', 'hq-widgets-for-elementor'),
            'placeholder' => __('Days', 'hq-widgets-for-elementor'),
            'frontend_available' => true,
            'condition' => [
                'show_days' => 'yes',
            ],
                ]
        );
        $this->add_control(
                'label_hours', [
            'label' => __('Hours', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Hours', 'hq-widgets-for-elementor'),
            'placeholder' => __('Hours', 'hq-widgets-for-elementor'),
            'frontend_available' => true,
            'condition' => [
                'show_hours' => 'yes',
            ],
                ]
        );
        $this->add_control(
                'label_minutes', [
            'label' => __('Minutes', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Minutes', 'hq-widgets-for-elementor'),
            'placeholder' => __('Minutes', 'hq-widgets-for-elementor'),
            'frontend_available' => true,
            'condition' => [
                'show_minutes' => 'yes',
            ],
                ]
        );
        $this->add_control(
                'label_seconds', [
            'label' => __('Seconds', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Seconds', 'hq-widgets-for-elementor'),
            'placeholder' => __('Seconds', 'hq-widgets-for-elementor'),
            'frontend_available' => true,
            'condition' => [
                'show_seconds' => 'yes',
            ],
                ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
                'style_section', [
            'label' => __('Box', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );
        $this->add_responsive_control(
                'box_align', [
            'label' => esc_html__('Alignment', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'flext-start' => [
                    'title' => esc_html__('Left', 'hq-widgets-for-elementor'),
                    'icon' => 'fa fa-align-left',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'hq-widgets-for-elementor'),
                    'icon' => 'fa fa-align-center',
                ],
                'flex-end' => [
                    'title' => esc_html__('Right', 'hq-widgets-for-elementor'),
                    'icon' => 'fa fa-align-right',
                ],
            ],
            'toggle' => false,
            'default' => 'center',
            'selectors' => [
                '{{WRAPPER}} .elementor-widget-container' => 'justify-content: {{VALUE}};',
            ],
                ]
        );
        $this->add_control(
                'box_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .countdown-timer' => 'background-color: {{VALUE}};',
            ],
            'separator' => 'after',
                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'box_border',
            'selector' => '{{WRAPPER}} .countdown-timer',
                ]
        );
        $this->add_control(
                'box_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .countdown-timer' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_control(
                'box_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'default' => [
                'top' => '1',
                'right' => '1',
                'bottom' => '1',
                'left' => '1',
                'unit' => 'em',
            ],
            'selectors' => [
                '{{WRAPPER}} .countdown-timer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_control(
                'heading_labels_format_style', [
            'label' => __('Labels Format', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => [
                'labelsFormat' => 'yes'
            ],
                ]
        );

        $this->add_responsive_control(
                'items_border_width', [
            'label' => __('Border Width', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 20,
                ],
            ],
            'default' => [
                'size' => 0,
                'unit' => 'px',
            ],
            'selectors' => [
                '{{WRAPPER}} .displaySection' => 'border-width: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'labelsFormat' => 'yes'
            ]
                ]
        );

        $this->add_control(
                'items_border_color', [
            'label' => __('Border Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .displaySection' => 'border-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_responsive_control(
                'digit_spacing', [
            'label' => __('Digit Gap', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 200,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .displaySection .numberDisplay' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'labelsFormat' => 'yes'
            ]
                ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
                'digits_style_section', [
            'label' => __('Digits', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );
        $this->add_control(
                'digit_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .countdown-timer .numberDisplay' => 'background-color: {{VALUE}};',
            ],
            'separator' => 'after',
                ]
        );

        $this->add_responsive_control(
                'digit_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .countdown-timer .numberDisplay' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_control(
                'digits_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .countdown-timer:not(.labelformat), {{WRAPPER}} .countdown-timer .numberDisplay' => 'color: {{VALUE}};',
            ],
                ]
        );
        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'digits_typography',
            'selector' => '{{WRAPPER}} .countdown-timer:not(.labelformat), {{WRAPPER}} .countdown-timer .numberDisplay',
                ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
                'labels_style_section', [
            'label' => __('Labels', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'labelsFormat' => 'yes'
            ],
                ]
        );
        $this->add_control(
                'label_background_color', [
            'label' => __('Background Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .countdown-timer .periodDisplay' => 'background-color: {{VALUE}};',
            ],
            'separator' => 'after',
                ]
        );

        $this->add_responsive_control(
                'label_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .countdown-timer .periodDisplay' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        $this->add_control(
                'label_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .countdown-timer .periodDisplay' => 'color: {{VALUE}};',
            ],
                ]
        );
        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'label_typography',
            'selector' => '{{WRAPPER}} .countdown-timer .periodDisplay',
                ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
                'message_style_section', [
            'label' => __('Message', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'expire_show_type' => 'message'
            ]
                ]
        );
        $this->add_control(
                'message_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .countdown-message' => 'color: {{VALUE}};',
            ],
                ]
        );
        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'message_typography',
            'selector' => '{{WRAPPER}} .countdown-message',
                ]
        );

        $this->add_responsive_control(
                'message_spacing', [
            'label' => __('Gap', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 200,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .countdown-message' => 'margin-top: {{SIZE}}{{UNIT}};',
            ],
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();

        $day = $settings['show_days'];
        $hours = $settings['show_hours'];
        $minute = $settings['show_minutes'];
        $seconds = $settings['show_seconds'];
        ?>
        <div class="countdown-timer-widget">
            <div id="countdown-timer-<?php echo esc_attr($this->get_id()); ?>" class="countdown-timer"></div>
            <div id="countdown-message-<?php echo esc_attr($this->get_id()); ?>" class="countdown-message"></div>
        </div>
        <?php
    }

    protected function _content_template() {
        
    }

}
