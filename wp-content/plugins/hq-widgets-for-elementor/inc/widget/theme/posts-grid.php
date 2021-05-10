<?php

namespace HQWidgetsForElementor\Widget\Theme;

defined('ABSPATH') || exit;

use const HQWidgetsForElementor\PLUGIN_SLUG;
use HQWidgetsForElementor\Widget\Theme\Posts;

class Posts_Grid extends Posts {

    public function get_name() {
        return 'hq-theme-posts-grid';
    }

    public function get_title() {
        return __('Posts Grid', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-wireframe-list';
    }

    public function get_script_depends() {
        return $this->get_script_depends_grid();
    }

    public function get_style_depends() {
        return ['hqt-widgets'];
    }

    public function get_categories() {
        return [PLUGIN_SLUG];
    }

    public function get_keywords() {
        return ['related posts', 'post', 'related', 'grid'];
    }

    protected function _register_controls() {

        // Posts Controls
        parent::_register_controls();

        // Grid Controls
        $this->register_grid_controls();

        // Pagination
        $this->register_pagination_section_controls();

        // Update Pagination controls for not-archive widgets
        $this->update_pagination_section_controls();

        // Nothing Found
        $this->register_nothing_found_section_controls();
    }

    public function render() {
        parent::render_grid();
    }

}
