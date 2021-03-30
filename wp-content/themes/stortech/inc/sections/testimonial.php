<?php
/**
 * Testimonial section
 *
 * This is the template for the content of testimonial section
 *
 * @package Theme Palace
 * @subpackage Stortech
 * @since Stortech 1.0.0
 */
if ( ! function_exists( 'stortech_add_testimonial_section' ) ) :
    /**
    * Add testimonial section
    *
    *@since Stortech 1.0.0
    */
    function stortech_add_testimonial_section() {
        $options = stortech_get_theme_options();
        // Check if testimonial is enabled on frontpage
        $testimonial_enable = apply_filters( 'stortech_section_status', true, 'testimonial_section_enable' );

        if ( true !== $testimonial_enable ) {
            return false;
        }
        // Get testimonial section details
        $section_details = array();
        $section_details = apply_filters( 'stortech_filter_testimonial_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render testimonial section now.
        stortech_render_testimonial_section( $section_details );
    }
endif;

if ( ! function_exists( 'stortech_get_testimonial_section_details' ) ) :
    /**
    * testimonial section details.
    *
    * @since Stortech 1.0.0
    * @param array $input testimonial section details.
    */
    function stortech_get_testimonial_section_details( $input ) {
        $options = stortech_get_theme_options();
        
        $content = array();
        $page_ids = array();
        for ( $i = 1; $i <= 3; $i++ ) {
            if ( ! empty( $options['testimonial_content_page_' . $i] ) ) :
                $page_ids[] = $options['testimonial_content_page_' . $i];
            endif;
        }
        
        $args = array(
            'post_type'         => 'page',
            'post__in'          => ( array ) $page_ids,
            'posts_per_page'    => 3,
            'orderby'           => 'post__in',
            );                    

            // Run The Loop.
            $query = new WP_Query( $args );
            $i = 0;
            if ( $query->have_posts() ) : 
                while ( $query->have_posts() ) : $query->the_post();
                    $page_post['id']        = get_the_id();
                    $page_post['title']     = get_the_title();
                    $page_post['url']       = get_the_permalink();
                    $page_post['excerpt']   = stortech_trim_content( 20 );
                    $page_post['image']     = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'large' ) : '';

                    // Push to the main array.
                    array_push( $content, $page_post );
                    $i++;
                endwhile;
            endif;
            wp_reset_postdata();
       

       
        
            
        if ( ! empty( $content ) ) {
            $input = $content;
        }
        return $input;
    }
endif;
// testimonial section content details.
add_filter( 'stortech_filter_testimonial_section_details', 'stortech_get_testimonial_section_details' );


if ( ! function_exists( 'stortech_render_testimonial_section' ) ) :
  /**
   * Start testimonial section
   *
   * @return string testimonial content
   * @since Stortech 1.0.0
   *
   */
   function stortech_render_testimonial_section( $content_details = array() ) {
        $options = stortech_get_theme_options();
        if ( empty( $content_details ) ) {
            return;
        } ?>
        <div id="testimonials" class="page-section">
            <div class="wrapper">
                <div class="testimonail-wrapper col-3">
                    <?php $i = 1 ; 
                    foreach ( $content_details as $content ) : 
                        $image = $content['image'] == '' ? get_template_directory_uri().'/assets/uploads/no-featured-image-590x650.jpg' : $content['image'] ;
                        $position = isset($options['testimonial_position_'.$i]) ? $options['testimonial_position_'.$i] : __(' Happy Client', 'stortech' );
                    ?>
                        <article class="hentry">
                                <div class="featured-image">
                                    <a href="<?php echo esc_url( $content['url'] ) ; ?>">
                                        <img src="<?php echo esc_url( $image ) ; ?>">
                                    </a>
                                </div><!-- .featured-image -->

                                <div class="entry-container">
                                    <div class="entry-content">
                                        <p><?php echo esc_html( $content['excerpt'] ) ; ?></p>
                                    </div><!-- .entry-content -->
                                    <div class="seperator"></div>
                                    <header class="entry-header">
                                        <h2 class="entry-title"><a href="<?php echo esc_url( $content['url'] ) ; ?>"><?php echo esc_html( $content['title'] ) ; ?> <?php echo esc_html( $position ) ; ?></a></h2>  
                                    </header>
                                </div><!-- .entry-container -->
                        </article>
                    <?php $i++; endforeach ?>
                </div><!-- .testimonial-wrapper -->
            </div><!-- .wrapper -->
        </div><!-- #testimonial-section -->
    <?php }
endif;
