<?php

namespace HQWidgetsForElementor\Widget\Theme;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use HQLib\Utils;
use const HQWidgetsForElementor\PLUGIN_SLUG;
use function \HQWidgetsForElementor\get_saved_elementor_templates;

class Elementor_Global_Template extends Widget_Base {

    public function get_name() {
        return 'hq-theme-elementor-global-template';
    }

    public function get_title() {
        return __('Elementor Global Template', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-global-template';
    }

    public function get_categories() {
        return [PLUGIN_SLUG];
    }

    protected function _register_controls() {
        $this->start_controls_section(
                'section_menu_content', [
            'label' => __('Elementor Content', 'hq-widgets-for-elementor'),
                ]
        );

        $this->add_control(
                'elementor_template', [
            'label' => esc_html__('Elementor Template', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => '',
            'options' => get_saved_elementor_templates()
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if (!empty($settings['elementor_template'])) {
            echo Utils::load_elementor_template($settings['elementor_template']);
        } else {
            esc_html_e('No template selected.', 'hq-widgets-for-elementor');
        }
    }

    private function parseNavMenuArgs($args) {
        return $args;
    }

}
