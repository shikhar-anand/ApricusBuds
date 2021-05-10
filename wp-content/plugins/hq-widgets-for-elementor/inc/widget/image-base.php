<?php

namespace HQWidgetsForElementor\Widget;

defined('ABSPATH') || exit;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use HQLib\Utils;
use Elementor\Widget_Image;

abstract class Image_Base extends Widget_Image {

    protected function register_test_post_item_section_controls($args = []) {
        // Test Post Type Section
        $this->start_controls_section(
                'section_test_post_item', [
            'label' => __('Test Item', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_CONTENT,
                ]
        );

        // Explanation
        $this->add_control(
                'test_post_item_alert', [
            'raw' => __('Test Item is used only in edit mode for better customization. On live page it will be ignored.', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::RAW_HTML,
            'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
        );

        // Test Post Item
        $this->add_control(
                'test_post_item', [
            'label' => __('Test Item', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT2,
            'label_block' => true,
            'default' => [],
            'options' => Utils::get_posts($args),
                ]
        );

        $this->end_controls_section();
    }

    protected function register_featured_image_controls() {
        parent::_register_controls();

        // Hide Image control
        $this->remove_control('image');

        // Update Caption Source control
        $caption_source = $this->get_controls('caption_source');
        unset($caption_source['options']['custom']);
        $this->update_control('caption_source', $caption_source);

        // Hide Link control
        $this->remove_control('link_to');

        // Add Clickable option
        $this->start_injection([
            'at' => 'after',
            'of' => 'caption_source',
        ]);

        $this->add_control(
                'clickable', [
            'label' => __('Clickable', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'no',
                ]
        );

        $this->end_injection();
    }

    private function has_link($settings) {
        return (!empty($settings['clickable']) && 'yes' == $settings['clickable'] && get_the_permalink());
    }

    private function has_caption($settings) {
        return (!empty($settings['caption_source']) && 'none' !== $settings['caption_source'] );
    }

    private function get_caption($settings) {
        $caption = '';
        if (!empty($settings['caption_source'])) {
            switch ($settings['caption_source']) {
                case 'attachment':
                    $caption = wp_get_attachment_caption(get_post_thumbnail_id());
                    break;
            }
        }
        return $caption;
    }

    protected function render_featured_image() {
        $settings = $this->get_settings_for_display();

        // Prepare test item for editor mode
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

        if (!get_post_thumbnail_id()) {
            return;
        }

        $has_link = $this->has_link($settings);
        $has_caption = $this->has_caption($settings);

        $this->add_render_attribute('wrapper', 'class', 'elementor-image');
        if (!empty($settings['hover_animation'])) {
            $this->add_render_attribute('image_wrapper', 'class', 'elementor-animation-' . $settings['hover_animation']);
        }
        ?>
        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
            <?php if ($has_caption) : ?>
                <figure class="wp-caption">
                <?php endif; ?>
                <div <?php echo $this->get_render_attribute_string('image_wrapper'); ?>>
                    <?php
                    if ($has_link) {
                        echo sprintf('<a href="%1$s">', get_the_permalink());
                    }
                    the_post_thumbnail($settings['image_size']);
                    if ($has_link) {
                        echo '</a>';
                    }
                    ?>
                </div>
                <?php if ($has_caption) : ?>
                    <figcaption class="widget-image-caption wp-caption-text"><?php echo $this->get_caption($settings); ?></figcaption>
                    <?php endif; ?>
                    <?php if ($has_caption) : ?>
                </figure>
            <?php endif; ?>
        </div>
        <?php
        //Rollback to the previous global post
        if (Plugin::instance()->editor->is_edit_mode()) {
            Plugin::instance()->db->restore_current_post();
        }
    }

    protected function _content_template() {
        
    }

}
