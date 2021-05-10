<?php

namespace HQWidgetsForElementor\Widget;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use HQLib\Utils;
use HQWidgetsForElementor\Widget\Base;

abstract class Products_Base extends Base {

    /**
     * Products query
     * @var \WP_Query
     */
    protected $query;

    protected function register_product_layout_section_controls() {
        // Layout Section
        $this->start_controls_section(
                'section_layout', [
            'label' => __('Layout', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_CONTENT,
                ]
        );

        // Post Layout
        $this->add_control(
                'product_layout_template', [
            'label' => __('Product Layout', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'noeltmp',
            'options' => Utils::get_elementor_templates('archive-post'),
            'description' => Utils::get_elementor_tempalates_howto('archive-post')
                ]
        );

        $this->end_controls_section();
    }

    protected function register_grid_controls() {
        parent::register_grid_controls();

        $tags = [];
        $_tags = get_terms(['product_tag']);
        foreach ($_tags as $tag) {
            $tags[$tag->term_id] = $tag->name;
        }
        $this->update_control('masonry_tags', [
            'options' => $tags,
        ]);
    }

    protected function render_grid() {

        global $wp_query;

        $settings = $this->get_settings();

        $wp_query = $this->query_posts($settings);

        if ($wp_query && have_posts()) {
            ?>
            <div id="articles-<?php echo $this->get_id(); ?>">
                <?php
                $this->start_grid($settings);

                while (have_posts()) {
                    the_post();
                    $masonryCssClass = '';
                    if ($settings['masonry_grid'] && has_term($settings['masonry_tags'], 'product_tag')) {
                        $masonryCssClass = 'masonry-x2';
                    }
                    ?> 
                    <div id="product-<?php the_ID(); ?>" <?php post_class($masonryCssClass); ?>> 
                        <?php
                        Utils::load_elementor_template_with_help($settings['product_layout_template'], 'Content Tab > Layout > Product Layout');
                        ?>
                    </div>
                    <?php
                }

                $this->end_grid();

                if (!empty($settings['pagination_type']) && '' !== $settings['pagination_type']) {
                    wp_reset_query();
                    $this->render_pagination($settings);
                }
                ?>
            </div>
            <?php
        } else {
            $this->render_no_results();
        }

        wp_reset_query();
    }

    protected function render_slider() {

        global $wp_query;

        $settings = $this->get_settings();

        $wp_query = $this->query_posts($settings);

        if ($wp_query && have_posts()) {

            $this->start_slider($settings);

            while (have_posts()) {
                the_post();
                ?> 
                <div class="swiper-slide">
                    <div id="product-<?php the_ID(); ?>"> 
                        <?php
                        Utils::load_elementor_template_with_help($settings['product_layout_template'], 'Content Tab > Layout > Product Layout');
                        ?>
                    </div>
                </div>
                <?php
            }

            $this->end_slider($settings);
        }

        wp_reset_query();
    }

}
