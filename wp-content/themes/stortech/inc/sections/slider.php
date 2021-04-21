<?php
/**
 * Slider section
 *
 * This is the template for the content of slider section
 *
 * @package Theme Palace
 * @subpackage Stortech
 * @since Stortech 1.0.0
 */
if ( ! function_exists( 'stortech_add_slider_section' ) ) :
    /**
    * Add slider section
    *
    *@since Stortech 1.0.0
    */
    function stortech_add_slider_section() {
    	$options = stortech_get_theme_options();
        // Check if slider is enabled on frontpage
        $slider_enable = apply_filters( 'stortech_section_status', true, 'slider_section_enable' );

        if ( true !== $slider_enable ) {
            return false;
        }
        // Get slider section details
        $section_details = array();
        $section_details = apply_filters( 'stortech_filter_slider_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render slider section now.
        stortech_render_slider_section( $section_details );
    }
endif;

if ( ! function_exists( 'stortech_get_slider_section_details' ) ) :
    /**
    * slider section details.
    *
    * @since Stortech 1.0.0
    * @param array $input slider section details.
    */
    function stortech_get_slider_section_details( $input ) {
        $options = stortech_get_theme_options();
      
        $content = array();
        $page_ids = array();

        for ( $i = 1; $i <= 3; $i++ ) {
            if ( ! empty( $options['slider_content_page_' . $i] ) )
                $page_ids[] = $options['slider_content_page_' . $i];
        }
        
        $args = array(
            'post_type'         => 'page',
            'post__in'          => ( array ) $page_ids,
            'posts_per_page'    => 3,
            'orderby'           => 'post__in',
            );                    

            // Run The Loop.
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) : 
                while ( $query->have_posts() ) : $query->the_post();
                    $page_post['id']        = get_the_id();
                    $page_post['title']     = get_the_title();
                    $page_post['url']       = get_the_permalink();
                    $page_post['excerpt']   = stortech_trim_content( 10 );
                    $page_post['image']  	= has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'full' ) : '';

                    // Push to the main array.
                    array_push( $content, $page_post );
                endwhile;
            endif;
            wp_reset_postdata();
            
        if ( ! empty( $content ) ) {
            $input = $content;
        }
        return $input;
    }
endif;
// slider section content details.
add_filter( 'stortech_filter_slider_section_details', 'stortech_get_slider_section_details' );


if ( ! function_exists( 'stortech_render_slider_section' ) ) :
  /**
   * Start slider section
   *
   * @return string slider content
   * @since Stortech 1.0.0
   *
   */
   function stortech_render_slider_section( $content_details = array() ) {
        $options = stortech_get_theme_options();

        if ( empty( $content_details ) ) {
            return;
        } ?>

        <div id="featured-slider" data-slick='{"slidesToShow": 1, "slidesToScroll": 1, "infinite": true, "speed": 800, "dots": true, "arrows": true, "autoplay": true, "draggable": true, "fade": false }'>    
            <?php $i = 1 ; 
            foreach ($content_details as $content): 
                $image = $content['image'] == '' ? get_template_directory_uri().'/assets/uploads/no-featured-image-590x650.jpg' : $content['image'] ;
            ?>
                <article style="background-image:url('<?php echo esc_url( $image ); ?>');">
                    <div class="overlay" style="opacity: 0.3;"></div>
                    <div class="wrapper">
                        <div class="featured-content-wrapper">

                            <header class="entry-header">
                                <h2 class="entry-title"><a href="<?php echo esc_url($content['url']); ?>" ><?php echo esc_html( $content['title'] ); ?></a></h2>
                            </header>

                            <div class="entry-content">
                               <?php echo esc_html( $content['excerpt'] ); ?>
                            </div><!-- .entry-content-->

                            
                                <div class="read-more">
                                    <?php if ( !empty( $options['slider_btn_label'] ) ) : ?>
                                    <a href="<?php echo esc_url($content['url']); ?>" class="btn btn-fill" > <?php echo esc_html( $options['slider_btn_label'] ) ?></a>
                                <?php endif; ?>
                                    <?php if ( !empty( $options['slider_alt_btn_label_'.$i] ) && !empty( $options['slider_btn_url_'.$i] ) && ($options['home_layout'] == 'first-design') ) :  ?>
                                        <a href="<?php echo esc_url( $options['slider_btn_url_'.$i] ) ?>" class="btn"><?php echo esc_html( $options['slider_alt_btn_label_'.$i] ) ?>
                                            <svg viewBox="0 0 443.52 443.52">
                                                <path d="M336.226,209.591l-204.8-204.8c-6.78-6.548-17.584-6.36-24.132,0.42c-6.388,6.614-6.388,17.099,0,23.712l192.734,192.734
                                                L107.294,414.391c-6.663,6.664-6.663,17.468,0,24.132c6.665,6.663,17.468,6.663,24.132,0l204.8-204.8
                                                C342.889,227.058,342.889,216.255,336.226,209.591z"/>
                                            </svg>
                                        </a>
                                    <?php endif; ?>
                                </div><!-- .read-more -->                          
                        </div><!-- .featured-content-wrapper -->
                    </div><!-- .wrapper -->
                </article>
            <?php $i++; endforeach ; ?>
        </div><!-- #featured-slider -->
                       
    <?php }
endif;