<?php
/**
 * recent_product section
 *
 * This is the template for the content of recent_product section
 *
 * @package Theme Palace
 * @subpackage Stortech Pro
 * @since Stortech Pro 1.0.0
 */
if ( ! function_exists( 'stortech_add_recent_product_section' ) ) :
    /**
    * Add recent_product section
    *
    *@since Stortech Pro 1.0.0
    */
    function stortech_add_recent_product_section() {
        $options = stortech_get_theme_options();
        // Check if recent_product is enabled on frontpage
        $recent_product_enable = apply_filters( 'stortech_section_status', true, 'recent_product_section_enable' );

        if ( true !== $recent_product_enable ) {
            return false;
        }
        // Get recent_product section details
        $section_details = array();
        $section_details = apply_filters( 'stortech_filter_recent_product_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }
        if ( !class_exists('WooCommerce') ) {
            return;
        }
        // Render recent_product section now.
        stortech_render_recent_product_section( $section_details );
    }
endif;

if ( ! function_exists( 'stortech_get_recent_product_section_details' ) ) :
    /**
    * recent_product section details.
    *
    * @since Stortech Pro 1.0.0
    * @param array $input recent_product section details.
    */
    function stortech_get_recent_product_section_details( $input ) {
        $options = stortech_get_theme_options();

        // Content type.
        $recent_product_content_type  = $options['recent_product_content_type'];     
        $recent_product_count = 8; 
        
        $content = array();
        $content = array();
        switch ( $recent_product_content_type ) {

            case 'recent_product':
                $args = array(
                    'post_type'             => 'product',
                    'posts_per_page'        => $recent_product_count,
                    'ignore_sticky_posts'   => true,
                    );
            break;

            case 'product':
                $page_ids = array();

                for ( $i = 1; $i <= $recent_product_count; $i++ ) {
                    if ( ! empty( $options['recent_product_content_page_' . $i] ) )
                        $page_ids[] = $options['recent_product_content_page_' . $i];
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
                $page_post['excerpt']   = stortech_trim_content( 20 );
                $page_post['image']     = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'large' ) : '';

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
// recent_product section content details.
add_filter( 'stortech_filter_recent_product_section_details', 'stortech_get_recent_product_section_details' );


if ( ! function_exists( 'stortech_render_recent_product_section' ) ) :
  /**
   * Start recent_product section
   *
   * @return string recent_product content
   * @since Stortech Pro 1.0.0
   *
   */
   function stortech_render_recent_product_section( $content_details = array() ) {
        $options = stortech_get_theme_options();

        if ( empty( $content_details ) ) {
            return;
        } ?>
      <div id="recent-products" class="relative page-section same-background">
            <div class="wrapper">
                <?php if (!empty( $options['recent_product_title'] ) || !empty( $options['recent_product_title'] ) ): ?>
                    <div class="section-header">
                        <h2 class="section-title"><?php echo esc_html( $options['recent_product_title'] ) ; ?></h2>
                        <p class="subtitle"><?php echo esc_html( $options['recent_product_subtitle'] ) ; ?></p>
                    </div><!-- .section-header -->
                <?php endif ?>

                <div class="section-content">
                    <ul class="products col-4">
                        <?php foreach ( $content_details as $content ): 
                            $image = $content['image'] == '' ? get_template_directory_uri().'/assets/uploads/no-featured-image-590x650.jpg' : $content['image'] ;
                        ?>
                            <li class="product featured-products">
                                <div class="post-thumbnail">
                                    <a href="<?php echo esc_url( $content['url'] ) ; ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                                    <?php 
                                        $product = new WC_Product( $content['id'] );
                                        if ( $product->get_sale_price() ): 
                                    ?>
                                    <span class="onsale">
                                        <?php esc_html_e('Sale!', 'stortech'); ?>
                                    </span>
                                    <?php endif ?>
                                    <img width="330" height="400" src="<?php echo esc_url($image); ?>">
                                    <h2 class="woocommerce-loop-product__title"><?php echo esc_html( $content['title'] ) ?></h2></a>
                                    <span class="price">
                                         <?php 
                                            $product = new WC_Product( $content['id'] );
                                            echo $product->get_price_html();
                                        ?>
                                    </span>
                                    </a>
                                </div><!-- .post-thumbnail -->                         
                            </li>
                        <?php endforeach ?>
                    </ul><!-- .product-slider -->                        
                    <?php if ( !empty( $options['recent_btn_label'] ) && !empty( $options['recent_btn_url'] ) ) : ?>
                        <div class="read-more">
                            <a href="<?php echo esc_url($options['recent_btn_url'] ); ?>" class="btn btn-fill" > <?php echo esc_html( $options['recent_btn_label'] ) ?>                                  
                            </a>
                        </div>
                    <?php endif; ?>
                </div><!-- .section-content -->
            </div><!-- .wrapper -->
        </div>
    <?php }
endif;