<?php

namespace HQWidgetsForElementor\Widget\Theme;

defined('ABSPATH') || exit;

use const HQWidgetsForElementor\PLUGIN_SLUG;
use HQWidgetsForElementor\Widget\Theme\Post_Related_Posts;

class Post_Related_Posts_Slider extends Post_Related_Posts {

    public function get_name() {
        return 'hq-theme-post-related-posts-slider';
    }

    public function get_title() {
        return __('Post Related Posts Slider', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-carousel';
    }

    public function get_script_depends() {
        return $this->get_script_depends_slider();
    }

    public function get_style_depends() {
        return $this->get_style_depends_slider();
    }

    public function get_categories() {
        return [PLUGIN_SLUG];
    }

    public function get_keywords() {
        return ['related posts', 'post', 'related', 'slider'];
    }

    protected function _register_controls() {

        // Related Posts Controls
        parent::_register_controls();

        // Slide Controls
        $this->register_slider_controls();
    }

    public function render() {
        parent::render_slider();
    }

}
