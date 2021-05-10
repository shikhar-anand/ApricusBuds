<?php

namespace HQWidgetsForElementor\Widget\Woocommerce;

defined('ABSPATH') || exit;

use Elementor\Widget_Image;
use Elementor\Controls_Manager;
use const HQWidgetsForElementor\PLUGIN_SLUG;

class Category_Image extends Widget_Image {

    public function get_name() {
        return 'hq-woocommerce-category-image';
    }

    public function get_title() {
        return __('Woo Category Image', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-document';
    }

    public function get_categories() {
        return [PLUGIN_SLUG . '-woo'];
    }

    public function get_keywords() {
        return ['woocommerce', 'category', 'image', 'thumbnail'];
    }

    protected function _register_controls() {
        if (!defined('WC_VERSION')) {
            $this->start_controls_section('section_plugin_missing', [
                'label' => __('Woocommerce', 'hq-widgets-for-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]);

            $this->add_control('plugin_alert', [
                'raw' => '<p>' . __('WooCommerce plugin is not installed.', 'hq-widgets-for-elementor') . '</p>' . sprintf('<a href="%s" target="_blank">%s</a>', esc_url(admin_url('plugin-install.php?s=woocommerce&tab=search&type=term')), __('Install WooCommerce.', 'hq-widgets-for-elementor')),
                'type' => Controls_Manager::RAW_HTML,
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
            ]);

            $this->end_controls_section();

            return;
        }

        parent::_register_controls();

        $this->remove_control('caption_source');
        $this->remove_control('link_to');
    }

    protected function render() {
        if (!defined('WC_VERSION')) {
            \HQLib\Utils::editor_alert_box('WooCommerce plugin is missing.');
            return;
        }
        
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('wrapper', 'class', 'elementor-image');
        // Get cateogry image id
        $image_id = $this->get_image_id();

        if (!empty($image_id)) :
            ?>
            <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
                <?php
                $size = $settings['image_size'];
                $attr = ['class' => !empty($settings['hover_animation']) ? 'elementor-animation-' . $settings['hover_animation'] : ''];
                echo wp_get_attachment_image($image_id, $size, false, $attr);
                ?>
            </div>
            <?php
        endif;
    }

    public function get_image_id() {
        $category_id = 0;

        if (is_product_category()) {
            $category_id = get_queried_object_id();
        } elseif (is_product()) {
            $product = wc_get_product();
            if ($product) {
                $category_ids = $product->get_category_ids();
                if (!empty($category_ids)) {
                    $category_id = $category_ids[0];
                }
            }
        }

        if ($category_id) {
            return get_term_meta($category_id, 'thumbnail_id', true);
        }
    }

    protected function content_template() {
        
    }

}
