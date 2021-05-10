<?php

namespace HQWidgetsForElementor\Widget\Theme;

defined('ABSPATH') || exit;

use HQWidgetsForElementor\Widget\Theme\Posts;

class Posts_Slider extends Posts {

    public function get_name() {
        return 'hq-theme-posts-slider';
    }

    public function get_title() {
        return __('Posts Slider', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-layer-slider';
    }

    public function get_script_depends() {
        return $this->get_script_depends_slider();
    }

    public function get_style_depends() {
        return $this->get_style_depends_slider();
    }

    public function get_keywords() {
        return ['related posts', 'post', 'related', 'slider'];
    }

    protected function _register_controls() {

        // Posts Controls
        parent::_register_controls();

        // Slide Controls
        $this->register_slider_controls();
    }

    public function render() {
        parent::render_slider();
    }

}
