<?php

namespace HQWidgetsForElementor\Widget;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use HQLib\Utils;
use HQWidgetsForElementor\Widget\Base;

abstract class Posts_Base extends Base {

    /**
     * Posts query
     * @var \WP_Query
     */
    protected $query;

    /*
      protected function register_post_type_section_controls() {
      // Post Type Section
      $this->start_controls_section(
      'section_post_type',
      [
      'label' => __('Post Type', 'hq-widgets-for-elementor'),
      'tab' => Controls_Manager::TAB_CONTENT,
      ]
      );

      // Post Type
      $this->register_post_type_controls();

      $this->end_controls_section();
      }
     */

    protected function register_post_layout_section_controls() {
        // Layout Section
        $this->start_controls_section('section_layout', [
            'label' => __('Layout', 'hq-widgets-for-elementor'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        // Post Layout
        $this->add_control('post_layout_template', [
            'label' => __('Post Layout', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'noeltmp',
            'options' => Utils::get_elementor_templates('archive-post'),
            'description' => Utils::get_elementor_tempalates_howto('archive-post')
        ]);

        $this->end_controls_section();
    }

    protected function register_grid_controls() {
        parent::register_grid_controls();

        $tags = [];
        $_tags = get_terms(['post_tag']);
        foreach ($_tags as $tag) {
            $tags[$tag->term_id] = $tag->name;
        }
        $this->update_control('masonry_tags', [
            'options' => $tags,
        ]);
    }

    protected function register_query_ignore_sticky_posts_control() {
        // Ignore Sticky Posts
        $this->add_control(
                'ignore_sticky_posts', [
            'label' => __('Ignore Sticky Posts', 'hq-widgets-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => [
                'post_type' => 'post',
            ],
            'description' => __('Sticky-posts ordering is visible on frontend only', 'hq-widgets-for-elementor'),
                ]
        );
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
                    if (is_sticky() && is_paged()) {
                        continue;
                    }
                    $masonryCssClass = '';
                    if ($settings['masonry_grid'] && has_tag($settings['masonry_tags'])) {
                        $masonryCssClass = 'masonry-x2';
                    }
                    ?> 
                    <article id="post-<?php the_ID(); ?>" <?php post_class($masonryCssClass); ?>>
                        <?php
                        Utils::load_elementor_template_with_help($settings['post_layout_template'], 'Content Tab > Layout > Post Layout');
                        ?>
                    </article>
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
                    <article id="post-<?php the_ID(); ?>"> 
                        <?php
                        Utils::load_elementor_template_with_help($settings['post_layout_template'], 'Content Tab > Layout > Post Layout');
                        ?>
                    </article>
                </div>
                <?php
            }

            $this->end_slider($settings);
        }

        wp_reset_query();
    }

}
