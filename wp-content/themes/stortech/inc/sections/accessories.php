<?php
/**
 * Accessories section
 *
 * This is the template for the content of accessories section
 *
 * @package Theme Palace
 * @subpackage Stortech
 * @since Stortech 1.0.0
 */
if ( ! function_exists( 'stortech_add_accessories_section' ) ) :
    /**
    * Add accessories section
    *
    *@since Stortech 1.0.0
    */
    function stortech_add_accessories_section() {
        $options = stortech_get_theme_options();
        // Check if accessories is enabled on frontpage
        $accessories_enable = apply_filters( 'stortech_section_status', true, 'accessories_section_enable' );

        if ( true !== $accessories_enable ) {
            return false;
        }
        // Get accessories section details
        $section_details = array();
        $section_details = apply_filters( 'stortech_filter_accessories_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render accessories section now.
        stortech_render_accessories_section( $section_details );
    }
endif;

if ( ! function_exists( 'stortech_get_accessories_section_details' ) ) :
    /**
    * accessories section details.
    *
    * @since Stortech 1.0.0
    * @param array $input accessories section details.
    */
    function stortech_get_accessories_section_details( $input ) {
        $options = stortech_get_theme_options();

        // Content type.
        $accessories_content_type  = $options['accessories_content_type'];        
        $content = array();
        switch ( $accessories_content_type ) {
            
            case 'page':
                $page_ids = array();

                for ( $i = 1; $i <= 5; $i++ ) {
                    if ( ! empty( $options['accessories_content_page_' . $i] ) )
                        $page_ids[] = $options['accessories_content_page_' . $i];
                }
                
                $args = array(
                    'post_type'         => 'page',
                    'post__in'          => ( array ) $page_ids,
                    'posts_per_page'    => absint( 5 ),
                    'orderby'           => 'post__in',
                    );                    
            break;
            case 'product':
                $page_ids = array();

                for ( $i = 1; $i <= 5; $i++ ) {
                    if ( ! empty( $options['accessories_product_content_page_' . $i] ) )
                        $page_ids[] = $options['accessories_product_content_page_' . $i];
                }

                $args = array(
                    'post_type'         => 'product',
                    'post__in'          => ( array ) $page_ids,
                    'posts_per_page'    => count( $page_ids ),
                    'orderby'           => 'post__in',
                    );
            break;

            default:
            break;
        }


            // Run The Loop.
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) : 
                while ( $query->have_posts() ) : $query->the_post();
                    $page_post['id']        = get_the_id();
                    $page_post['title']     = get_the_title();
                    $page_post['url']       = get_the_permalink();
                    $page_post['excerpt']   = stortech_trim_content( 10 );
                    $page_post['image']     = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'full' ) : '';

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
// accessories section content details.
add_filter( 'stortech_filter_accessories_section_details', 'stortech_get_accessories_section_details' );


if ( ! function_exists( 'stortech_render_accessories_section' ) ) :
  /**
   * Start accessories section
   *
   * @return string accessories content
   * @since Stortech 1.0.0
   *
   */
   function stortech_render_accessories_section( $content_details = array() ) {
        $options = stortech_get_theme_options();

        if ( empty( $content_details ) ) {
            return;
        } ?>

        <div id="accessories" class="relative">   
            <?php $i = 1 ; 
            foreach ($content_details as $content): 
                $image = $content['image'] == '' ? get_template_directory_uri().'/assets/uploads/no-featured-image-590x650.jpg' : $content['image'] ;
            ?>
            <?php if ($i==2) { ?>
                <div class="featured-wrapper">
                <?php } ?>
                    <article class="<?php if ($i==1) echo 'full-width'; ?> " >
                        <div class="featured-image" style="background-image:url('<?php echo esc_url( $image ); ?>');">
                            <div class="overlay" style="opacity: 0.3;"></div>
                            <div class="entry-container">
                                <header class="entry-header">
                                    <h2 class="entry-title"><a href="<?php echo esc_url($content['url']); ?>" ><?php echo esc_html( $content['title'] ); ?></a></h2>
                                </header>

                                <div class="entry-content">
                                   <p><?php echo esc_html( $content['excerpt'] ); ?></p>
                                   <?php
                                   $accessories_content_type  = $options['accessories_content_type'];

                                    if ( $accessories_content_type == 'product' ): ?>
                                        <p> <?php echo esc_html__('Starting at', 'stortech');
                                         $product = new WC_Product( $content['id'] );
                                                echo $product->get_price_html(); ?></p>
                                    <?php endif; ?>
                                </div><!-- .entry-content-->

                                
                                    <div class="read-more">
                                        <?php if ( !empty( $options['accessories_btn_label'] ) ) : ?>
                                        <a href="<?php echo esc_url($content['url']); ?>" class="btn btn-fill" > <?php echo esc_html( $options['accessories_btn_label'] ) ?></a>
                                        <?php endif; ?>
                                    </div><!-- .read-more -->                          
                            </div><!-- .accessories-content-wrapper -->
                        </div><!-- .wrapper -->
                    </article>
            <?php $i++; endforeach ; ?>
        </div>
        </div><!-- #accessories-accessories -->
                       
    <?php }
endif;