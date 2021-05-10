<?php

namespace HQWidgetsForElementor\Widget\Theme;

defined('ABSPATH') || exit;

use HQWidgetsForElementor\Widget\Image_Base;
use const HQWidgetsForElementor\PLUGIN_SLUG;

class Post_Featured_Image extends Image_Base {

    public function get_name() {
        return 'hq-theme-post-featured-image';
    }

    public function get_title() {
        return __('Post Featured Image', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-adjust';
    }

    public function get_categories() {
        return [PLUGIN_SLUG];
    }

    public function get_keywords() {
        return ['post', 'image', 'featured', 'thumbnail'];
    }

    protected function _register_controls() {
        parent::register_test_post_item_section_controls();
        parent::register_featured_image_controls();
    }

    protected function render() {
        parent::render_featured_image();
    }

}
