<?php

namespace HQWidgetsForElementor\Widget\Woocommerce;

defined('ABSPATH') || exit;

use Elementor\Plugin;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use HQLib\Utils;
use const HQWidgetsForElementor\VERSION;
use const HQWidgetsForElementor\PLUGIN_SLUG;
use const HQWidgetsForElementor\PLUGIN_URL;

class Product_Rating extends Widget_Base {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        wp_register_style('hq-woocommerce-product-rating', PLUGIN_URL . 'assets/widgets/woocommerce/product-rating/style.css', [], VERSION);
    }

    public function get_name() {
        return 'hq-woocommerce-product-rating';
    }

    public function get_title() {
        return __('Woo Product Rating', 'hq-widgets-for-elementor');
    }

    public function get_icon() {
        return 'hq-w4e hq-icon-product-rating';
    }

    public function get_style_depends() {
        return ['hq-woocommerce-product-rating'];
    }

    public function get_keywords() {
        return ['woocommerce', 'shop', 'store', 'rating', 'review', 'comments', 'stars', 'product'];
    }

    public function get_categories() {
        return [PLUGIN_SLUG . '-woo'];
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

        $args = [
            'post_type' => 'product'
        ];
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

        $this->start_controls_section(
                'section_product_rating_style', [
            'label' => __('Style', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'star_color', [
            'label' => __('Star Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .star-rating' => 'color: {{VALUE}}',
            ],
                ]
        );

        $this->add_control(
                'empty_star_color', [
            'label' => __('Empty Star Color', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .star-rating::before' => 'color: {{VALUE}}',
            ],
                ]
        );
        /*
          $this->add_control(
          'link_color', [
          'label' => __('Link Color', 'hq-widgets-for-elementor'),
          'type' => Controls_Manager::COLOR,
          'selectors' => [
          '{{WRAPPER}} .woocommerce-review-link' => 'color: {{VALUE}}',
          ],
          ]
          );

          $this->add_group_control(
          Group_Control_Typography::get_type(), [
          'name' => 'text_typography',
          'selector' => '{{WRAPPER}} .woocommerce-review-link',
          ]
          );
         */
        $this->add_control(
                'star_size', [
            'label' => __('Star Size', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'unit' => 'em',
            ],
            'range' => [
                'em' => [
                    'min' => 0,
                    'max' => 4,
                    'step' => 0.1,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .star-rating' => 'font-size: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->add_control(
                'space_between', [
            'label' => __('Space Between', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'default' => [
                'unit' => 'em',
            ],
            'range' => [
                'em' => [
                    'min' => 0,
                    'max' => 4,
                    'step' => 0.1,
                ],
                'px' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .star-rating::before' => 'letter-spacing: {{SIZE}}{{UNIT}}',
                '{{WRAPPER}} .star-rating' => 'width: calc(5.3em + {{SIZE}}{{UNIT}}*4); letter-spacing: {{SIZE}}{{UNIT}}',
            ],
                ]
        );

        $this->add_responsive_control(
                'alignment', [
            'label' => __('Alignment', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Left', 'hq-widgets-for-elementor'),
                    'icon' => 'fa fa-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'hq-widgets-for-elementor'),
                    'icon' => 'fa fa-align-center',
                ],
                'right' => [
                    'title' => __('Right', 'hq-widgets-for-elementor'),
                    'icon' => 'fa fa-align-right',
                ],
            ],
            'prefix_class' => 'elementor-product-rating--align-',
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        if (!defined('WC_VERSION')) {
            Utils::editor_alert_box('WooCommerce plugin is missing.');
            return;
        }
        
        $settings = $this->get_settings();

        global $product;
        $product = wc_get_product();

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

            $product = wc_get_product($settings['test_post_item']);
        }

        if (empty($product)) {
            return;
        }

        wc_get_template('single-product/rating.php');

        // Rollback to the previous global post
        if (Plugin::instance()->editor->is_edit_mode()) {
            Plugin::instance()->db->restore_current_post();
        }
    }

    public function render_plain_content() {
        
    }

}
