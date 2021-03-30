<?php
/**
 * Services section
 *
 * This is the template for the content of services section
 *
 * @package Theme Palace
 * @subpackage Stortech
 * @since Stortech 1.0.0
 */
if ( ! function_exists( 'stortech_add_services_section' ) ) :
    /**
    * Add services section
    *
    *@since Stortech Pro 1.0.0
    */
    function stortech_add_services_section() {
    	$options = stortech_get_theme_options();
        // Check if services is enabled on frontpage
        $services_enable = apply_filters( 'stortech_section_status', true, 'services_section_enable' );

        if ( true !== $services_enable ) {
            return false;
        }
        // Get services section details
        $section_details = array();
        $section_details = apply_filters( 'stortech_filter_services_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render services section now.
        stortech_render_services_section( $section_details );
    }
endif;

if ( ! function_exists( 'stortech_get_services_section_details' ) ) :
    /**
    * services section details.
    *
    * @since Stortech Pro 1.0.0
    * @param array $input services section details.
    */
    function stortech_get_services_section_details( $input ) {
        $options = stortech_get_theme_options();


        $services_count = 6;
        
        $content = array();
    
        $page_ids = array();

        for ( $i = 1; $i <= $services_count; $i++ ) {
            if ( ! empty( $options['services_content_page_' . $i] ) )
                $page_ids[] = $options['services_content_page_' . $i];
        }
        
        $args = array(
            'post_type'         => 'page',
            'post__in'          => ( array ) $page_ids,
            'posts_per_page'    => absint( $services_count ),
            'orderby'           => 'post__in',
            );                    
            
        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : 
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['id']        = get_the_id();
                $page_post['title']     = get_the_title();
                $page_post['url']       = get_the_permalink();

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
// services section content details.
add_filter( 'stortech_filter_services_section_details', 'stortech_get_services_section_details' );


if ( ! function_exists( 'stortech_render_services_section' ) ) :
  /**
   * Start services section
   *
   * @return string services content
   * @since Stortech Pro 1.0.0
   *
   */
   function stortech_render_services_section( $content_details = array() ) {
        $options = stortech_get_theme_options();

        if ( empty( $content_details ) ) {
            return;
        } ?>
       <div id="our-services" class="relative page-section">
            <div class="wrapper">
                <div class="col-3 clear">
                    <?php $i =1 ; foreach ($content_details as $content): 
                    $icon    = isset($options['services_content_icon_'.$i]) ? $options['services_content_icon_'.$i] : '';
                    ?>
                        <article>
                            <div class="service-item-wrapper">
                                <?php if ( $icon !== '' ): ?>
                                    <div class="service-icon">
                                        <a href="<?php echo esc_url( $content['url'] ) ; ?>"><i class="fa <?php echo esc_attr( $icon ) ; ?>"></i></a>
                                    </div><!-- .service-icon -->
                                <?php endif ?>
                                <div class="entry-container">
                                    <header class="entry-header">
                                        <h2 class="entry-title"><a href="<?php echo esc_url( $content['url'] ) ; ?>"><?php echo esc_html( $content['title'] ) ; ?></a></h2>
                                    </header>
                                </div><!-- .entry-container -->
                            </div><!-- .services-item-wrapper -->
                        </article>
                    <?php $i++; endforeach ?>
                   
                </div><!-- .col-3 -->
            </div><!-- .wrapper -->
        </div><!-- #our-servicess -->
        
    <?php }
endif;