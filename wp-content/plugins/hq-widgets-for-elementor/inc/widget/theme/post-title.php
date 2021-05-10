<?php

namespace HQWidgetsForElementor\Widget\Theme;

defined('ABSPATH') || exit;

use Elementor\Plugin;
use HQWidgetsForElementor\Widget\Title_Base;
use const HQWidgetsForElementor\PLUGIN_SLUG;

class Post_Title extends Title_Base {

    public function get_name() {
        return 'hq-theme-post-title';
    }

    public function get_title() {
        return __('Post Title', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-title';
    }

    public function get_style_depends() {
        return ['hqt-widgets'];
    }

    public function get_categories() {
        return [PLUGIN_SLUG];
    }

    public function get_keywords() {
        return ['title', 'heading', 'post'];
    }

    protected function _register_controls() {
        parent::register_title_controls();
        parent::register_title_clickable_controls();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('_wrapper', 'class', 'elementor-widget-heading');
        $this->add_render_attribute('title', 'class', ['elementor-heading-title', 'post_title', 'entry-title']);
        if ('yes' == $settings['truncate']) {
            $this->add_render_attribute('title', 'class', 'text-truncate');
        }

        $beforeTitle = '<%1$s %2$s>';
        $afterTitle = '</%1$s>';

        if (Plugin::instance()->editor->is_edit_mode()) {
            // Test title
            $title_html = sprintf($beforeTitle . $this->get_title() . $afterTitle, $settings['header_size'], $this->get_render_attribute_string('title'));
        } else {
            if ('yes' == $settings['clickable']) {
                $beforeTitle .= '<a href="%3$s">';
                $afterTitle = '</a>' . $afterTitle;
            }
            $title_html = sprintf(the_title($beforeTitle, $afterTitle, false), $settings['header_size'], $this->get_render_attribute_string('title'), get_the_permalink());
        }

        echo $title_html;
    }

}
