<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package tafri-travel
 */
?>
<?php if( get_theme_mod( 'tafri_travel_hide_show_scroll',true) != '' || get_theme_mod( 'tafri_travel_enable_disable_scrolltop',true) != '') { ?>
  <?php $tafri_travel_theme_lay = get_theme_mod( 'tafri_travel_footer_options','Right');
    if($tafri_travel_theme_lay == 'Left align'){ ?>
      <a href="#" class="scrollup left"><i class="<?php echo esc_attr(get_theme_mod('tafri_travel_scroll_icon','fas fa-long-arrow-alt-up')); ?>"></i><span class="screen-reader-text"><?php esc_html_e( 'Scroll Up', 'tafri-travel' ); ?></span></a>
    <?php }else if($tafri_travel_theme_lay == 'Center align'){ ?>
      <a href="#" class="scrollup center"><i class="<?php echo esc_attr(get_theme_mod('tafri_travel_scroll_icon','fas fa-long-arrow-alt-up')); ?>"></i><span class="screen-reader-text"><?php esc_html_e( 'Scroll Up', 'tafri-travel' ); ?></span></a>
    <?php }else{ ?>
      <a href="#" class="scrollup"><i class="<?php echo esc_attr(get_theme_mod('tafri_travel_scroll_icon','fas fa-long-arrow-alt-up')); ?>"></i><span class="screen-reader-text"><?php esc_html_e( 'Scroll Up', 'tafri-travel' ); ?></span></a>
  <?php }?>
<?php }?>
  <footer role="contentinfo">
    <?php //Set widget areas classes based on user choice
        $tafri_travel_widget_areas = get_theme_mod('tafri_travel_footer_widget', '4');
        if ($tafri_travel_widget_areas == '3') {
          $cols = 'col-lg-4 col-md-4';
        } elseif ($tafri_travel_widget_areas == '4') {
          $cols = 'col-lg-3 col-md-3';
        } elseif ($tafri_travel_widget_areas == '2') {
          $cols = 'col-lg-6 col-md-6';
        } else {
          $cols = 'col-lg-12 col-md-12';
        }
    ?>
<!--
    <div id="footer" class="copyright-wrapper py-3 mt-4">
      <div class="container">
        <div class="row">
          <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
            <div class="sidebar-column <?php echo ( $cols ); ?>">
              <?php dynamic_sidebar( 'footer-1'); ?>
            </div>
          <?php endif; ?> 
          <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
            <div class="sidebar-column <?php echo ( $cols ); ?>">
              <?php dynamic_sidebar( 'footer-2'); ?>
            </div>
          <?php endif; ?> 
          <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
            <div class="sidebar-column <?php echo ( $cols ); ?>">
              <?php dynamic_sidebar( 'footer-3'); ?>
            </div>
          <?php endif; ?> 
          <?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
            <div class="sidebar-column <?php echo ( $cols ); ?>">
              <?php dynamic_sidebar( 'footer-4'); ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
-->
<!--
    <div class="copyright">
      <div class="container">
        <span><?php tafri_travel_credit(); ?> <?php echo esc_html(get_theme_mod('',__('',''))); ?> </span>
        <span class="footer_text"><?php echo esc_html_e('Powered By ApricusBuds','Apricus-travel') ?></span>
      </div>
    </div>
-->
  </footer>
  <?php wp_footer();?>
</body>
</html>