<?php

namespace HQWidgetsForElementor\Widget\Theme;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;
use Elementor\Widget_Base;
use HQLib\Utils;
use const HQWidgetsForElementor\VERSION;
use const HQWidgetsForElementor\PLUGIN_SLUG;
use const HQWidgetsForElementor\PLUGIN_URL;

class Modal_Box extends Widget_Base {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        wp_register_style('jquery-modal', PLUGIN_URL . 'assets/css/jquery.modal.min.css', [], '0.9.1');
        wp_register_script('jquery-modal', PLUGIN_URL . 'assets/js/jquery.modal.min.js', ['jquery'], '0.9.2', true);

        wp_register_style('hq-theme-modal-box', PLUGIN_URL . 'assets/widgets/theme/modal-box/style.css', [], VERSION);
        wp_register_script('hq-theme-modal-box', PLUGIN_URL . 'assets/widgets/theme/modal-box/script.js', ['elementor-frontend'], VERSION, true);
    }

    public function get_name() {
        return 'hq-theme-modal-box';
    }

    public function get_title() {
        return __('Modal Box', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-send';
    }

    public function get_script_depends() {
        return ['mobile-detect', 'jquery-modal', 'hq-theme-modal-box'];
    }

    public function get_style_depends() {
        return ['jquery-modal', 'hq-theme-modal-box'];
    }

    public function get_categories() {
        return [PLUGIN_SLUG];
    }

    public function get_keywords() {
        return ['modal', 'lightbox', 'popup', 'dialog', 'box'];
    }

    protected function _register_controls() {

        // Content Section
        $this->start_controls_section(
                'section_content', [
            'label' => __('Modal Content', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_CONTENT,
                ]
        );

        $this->add_control(
                'modal_id', [
            'type' => Controls_Manager::HIDDEN,
            'frontend_available' => true,
            'default' => esc_attr($this->get_id()),
                ]
        );

        $this->add_control(
                'elementor_type', [
            'label' => __('Template Type', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'section',
            'description' => 'Choose a template for modal body',
            'options' => [
                'section' => __('Section', 'hq-widgets-for-elementor'),
                'page' => __('Page', 'hq-widgets-for-elementor'),
            ],
                ]
        );

        $this->add_control(
                'section_template', [
            'label' => __('Section Template', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'noeltmp',
            'options' => Utils::get_elementor_templates('section'),
            'description' => Utils::get_elementor_tempalates_howto('section'),
            'condition' => [
                'elementor_type' => 'section'
            ],
                ]
        );

        $this->add_control(
                'page_template', [
            'label' => __('Page Template', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'noeltmp',
            'options' => Utils::get_elementor_templates('page'),
            'description' => Utils::get_elementor_tempalates_howto('page'),
            'condition' => [
                'elementor_type' => 'page'
            ],
                ]
        );

        $this->add_control(
                'modal_position', [
            'label' => __('Position', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'frontend_available' => true,
            'default' => 'center-center',
            'options' => [
                'top-left' => __('Top Left', 'hq-widgets-for-elementor'),
                'top-center' => __('Top Center', 'hq-widgets-for-elementor'),
                'top-right' => __('Top Right', 'hq-widgets-for-elementor'),
                'center-left' => __('Center Left', 'hq-widgets-for-elementor'),
                'center-center' => __('Center Center', 'hq-widgets-for-elementor'),
                'center-right' => __('Center Right', 'hq-widgets-for-elementor'),
                'bottom-left' => __('Bottom Left', 'hq-widgets-for-elementor'),
                'bottom-center' => __('Bottom Center', 'hq-widgets-for-elementor'),
                'bottom-right' => __('Bottom Right', 'hq-widgets-for-elementor'),
            ],
                ]
        );

        $this->end_controls_section();

        // Content Section
        $this->start_controls_section(
                'section_trigger', [
            'label' => __('Triggers', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_CONTENT,
                ]
        );

        $this->add_control(
                'trigger_type', [
            'label' => __('Trigger Type', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'frontend_available' => true,
            'default' => 'auto',
            'options' => [
                'click' => __('Click Open', 'hq-widgets-for-elementor'),
                'auto' => __('Time Delay / Auto Open', 'hq-widgets-for-elementor'),
                'exit' => __('Exit Intent', 'hq-widgets-for-elementor'),
            ],
                ]
        );

        $this->add_control(
                'click_selectors', [
            'label' => __('Selectors', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'frontend_available' => true,
            'placeholder' => __('#button_id', 'hq-widgets-for-elementor'),
            'description' => __('For more than one selector, separate by comma (,) eg: .class-name, #button_id', 'hq-widgets-for-elementor'),
            'condition' => [
                'trigger_type' => 'click',
            ],
                ]
        );

        $this->add_control(
                'time_delay', [
            'label' => __('Delay', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'frontend_available' => true,
            'min' => 0,
            'step' => 500,
            'default' => 5000,
            'description' => __('Time delay in milliseconds', 'hq-widgets-for-elementor'),
            'condition' => [
                'trigger_type' => 'auto',
            ],
                ]
        );

        $this->add_control(
                'fade_duration', [
            'label' => __('Fade Duration', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'frontend_available' => true,
            'min' => 0,
            'step' => 100,
            'default' => 200,
                ]
        );

        $this->add_control(
                'cookie_setup', [
            'label' => __('Set up a cookie?', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER, 'frontend_available' => true,
            'default' => 'no',
            'return_value' => 'yes',
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'cookie_event', [
            'label' => __('Cookie Event', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'frontend_available' => true,
            'default' => 'on_close',
            'options' => [
                'on_close' => __('On Popup Close', 'hq-widgets-for-elementor'),
                'on_open' => __('On Popup Open', 'hq-widgets-for-elementor'),
            ],
            'description' => __('When should your cookie be created?', 'hq-widgets-for-elementor'),
            'condition' => [
                'cookie_setup' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'cookie_name', [
            'label' => __('Cookie Name', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'frontend_available' => true,
            'default' => 'cm-' . esc_attr($this->get_id()),
            'placeholder' => 'cm-' . esc_attr($this->get_id()),
            'description' => __('The name that will be used when checking for or saving this cookie.', 'hq-widgets-for-elementor'),
            'condition' => [
                'cookie_setup' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'cookie_time', [
            'label' => __('Cookie Expires Date', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DATE_TIME,
            'frontend_available' => true,
            'condition' => [
                'cookie_setup' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'cookie_sitewide', [
            'label' => __('Sitewide Cookie', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'no',
            'return_value' => 'yes',
            'condition' => [
                'cookie_setup' => 'yes',
            ],
                ]
        );

        $this->add_control(
                'heading_trigger_disable', [
            'label' => __('Disable Trigger', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'disable_trigger_cookie_name', [
            'label' => __('Cookie Name', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'frontend_available' => true,
            'description' => __('Choose which cookies will disable this trigger?', 'hq-widgets-for-elementor'),
            'separator' => 'after'
                ]
        );

        $this->add_control(
                'disable_on_mobile', [
            'label' => __('Disable Trigger on Mobile', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'frontend_available' => true,
                ]
        );

        $this->add_control(
                'disable_on_tablet', [
            'label' => __('Disable Trigger on Tablet', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'frontend_available' => true,
                ]
        );

        $this->add_control(
                'disable_on_desktop', [
            'label' => __('Disable Trigger on Desktop', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'frontend_available' => true,
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_close', [
            'label' => __('Close', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_CONTENT,
                ]
        );

        $this->add_control(
                'heading_close_button', [
            'label' => __('Button', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::HEADING,
                ]
        );

        $this->add_control(
                'show_close_button', [
            'label' => __('Show Close Button', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'frontend_available' => true,
            'default' => 'yes',
                ]
        );

        $this->add_control(
                'close_position', [
            'label' => __('Position', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'top_right',
            'options' => [
                'top_left' => __('Top Left', 'hq-widgets-for-elementor'),
                'top_right' => __('Top Right', 'hq-widgets-for-elementor'),
                'bottom_left' => __('Bottom Left', 'hq-widgets-for-elementor'),
                'bottom_right' => __('Bottom Right', 'hq-widgets-for-elementor'),
            ],
            'condition' => [
                'show_close_button' => 'yes'
            ],
                ]
        );

        $this->add_control(
                'close_button_text', [
            'label' => __('Text', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'frontend_available' => true,
            'placeholder' => __('Close', 'hq-widgets-for-elementor'),
            'description' => __('Override the default "X"', 'hq-widgets-for-elementor'),
            'condition' => [
                'show_close_button' => 'yes'
            ]
                ]
        );

        $this->add_control(
                'close_overlay', [
            'label' => __('Click Overlay to Close', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'frontend_available' => true,
            'default' => 'yes',
            'description' => __('Close the modal when user clicks on overlay.', 'hq-widgets-for-elementor'),
            'separator' => 'before',
                ]
        );

        $this->add_control(
                'close_esc', [
            'label' => __('Press ESC to Close', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'frontend_available' => true,
            'default' => 'yes',
            'description' => __('Close the modal when user presses ESC key.', 'hq-widgets-for-elementor'),
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_modal_style', [
            'label' => __('Modal', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        // Width
        $this->add_responsive_control(
                'modal_width', [
            'label' => __('Width', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                '%' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
                'px' => [
                    'min' => 100,
                    'max' => 2000,
                    'step' => 50,
                ],
            ],
            'default' => [
                'size' => 90,
                'unit' => '%'
            ],
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '.modal#modal-' . esc_attr($this->get_id()) => 'width: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        // Max-width
        $this->add_responsive_control(
                'modal_max_width', [
            'label' => __('Max Width', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                '%' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
                'px' => [
                    'min' => 100,
                    'max' => 2000,
                    'step' => 50,
                ],
            ],
            'default' => [
                'size' => 500,
                'unit' => 'px'
            ],
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '.modal#modal-' . esc_attr($this->get_id()) => 'max-width: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        // Padding
        $this->add_responsive_control(
                'modal_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '.modal#modal-' . esc_attr($this->get_id()) => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        // Box Shadow
        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'modal_box_shadow',
            'label' => __('Box Shadow', 'hq-widgets-for-elementor'),
            'selector' => '.modal#modal-' . esc_attr($this->get_id()),
                ]
        );

        // Border Radius
        $this->add_control(
                'modal_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '.modal#modal-' . esc_attr($this->get_id()) => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        // Border
        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'modal_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '.modal#modal-' . esc_attr($this->get_id()),
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_modal_close_style', [
            'label' => __('Close Button', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'show_close_button' => 'yes'
            ],
                ]
        );

        $this->start_controls_tabs(
                'close_tabs', []
        );

        $this->start_controls_tab(
                'tab_close_normal', [
            'label' => __('Normal', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'close_text_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '.modal#modal-' . esc_attr($this->get_id()) . ' a.close-modal' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'close_background', [
            'label' => __('Background', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '.modal#modal-' . esc_attr($this->get_id()) . ' a.close-modal' => 'background-color: {{VALUE}};',
            ]
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
                'tab_close_hover', [
            'label' => __('Hover', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'close_text_hover_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '.modal#modal-' . esc_attr($this->get_id()) . ' a.close-modal:hover' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'close_hover_background', [
            'label' => __('Background', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '.modal#modal-' . esc_attr($this->get_id()) . ' a.close-modal:hover' => 'background-color: {{VALUE}};',
            ]
                ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
                'hr', [
            'type' => \Elementor\Controls_Manager::DIVIDER,
                ]
        );

        // Typography
        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'close_typography',
            'selector' => '.modal#modal-' . esc_attr($this->get_id()) . ' a.close-modal',
                ]
        );

        // Padding
        $this->add_responsive_control(
                'close_padding', [
            'label' => __('Padding', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '.modal#modal-' . esc_attr($this->get_id()) . ' a.close-modal' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        // Border Radius
        $this->add_control(
                'close_border_radius', [
            'label' => __('Border Radius', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '.modal#modal-' . esc_attr($this->get_id()) . ' a.close-modal' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        // Border
        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'close_border',
            'label' => __('Border', 'hq-widgets-for-elementor'),
            'selector' => '.modal#modal-' . esc_attr($this->get_id()) . ' a.close-modal',
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'section_modal_overlay_style', [
            'label' => __('Overlay', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'modal_overlay_color', [
            'label' => __('Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => 'rgba(0,0,0,0.75)',
            'selectors' => [
                '.hq-modal-blocker__' . esc_attr($this->get_id()) => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->end_controls_section();
    }

    public function render() {
        $settings = $this->get_settings();
        $templateId = $settings[$settings['elementor_type'] . '_template'];
        if (empty($templateId) || $templateId == 'noeltmp') {
            ?>
            <div class="elementor-alert elementor-alert-info" role="alert">
                <span class="elementor-alert-description">
                    <?php esc_html_e('Please select a template for modal body.', 'hq-widgets-for-elementor'); ?>
                </span>
            </div>
            <?php
            return;
        }
        $this->add_render_attribute('modal', 'class', ['modal', 'hq-modal-box', 'hq-modal-box__' . $settings['modal_id']]);
        if ($settings['show_close_button']) {
            $this->add_render_attribute('modal', 'class', 'modal-close__' . $settings['close_position']);
        }

        if (Plugin::instance()->editor->is_edit_mode()) {
            ?>
            <div class="elementor-alert elementor-alert-info elementor-align-center" role="alert">
                <span class="elementor-alert-description">
                    <?php esc_html_e('In editor mode you can only trigger the modal box manually. Click the button to open the modal box.', 'hq-widgets-for-elementor'); ?>
                </span>
                <a href="#modal-<?php echo $settings['modal_id']; ?>" rel="modal:open" class="btn-open-modal">
                    <?php esc_html_e('Open Modal', 'hq-widgets-for-elementor'); ?>
                </a>
            </div>
            <?php
        }
        ?>
        <div id="modal-<?php echo $settings['modal_id']; ?>" <?php echo $this->get_render_attribute_string('modal'); ?>>
            <div class="modal-body">
                <?php Utils::load_elementor_template($settings[$settings['elementor_type'] . '_template']); ?>
            </div>
        </div>
        <?php
    }

}
