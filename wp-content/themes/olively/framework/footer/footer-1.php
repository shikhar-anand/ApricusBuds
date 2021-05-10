<?php
/**
 *  Template for 1-Column Footer
 */
 ?>
 <div id="footer-sidebar" class="widget-area">
	 <?php if (get_theme_mod('olively_footer_bg')) { ?>
		<div id="footer-bg"></div>
	<?php } ?>
     <div class="container">
	     <div id="footer-top">
		    <?php
				if ( is_active_sidebar( 'before-footer' ) ) { ?>
					<div class="widget-area before-footer">
						<?php dynamic_sidebar( 'before-footer' ); ?>
					</div><!-- #secondary -->
				<?php
				}
			?>
		 </div>
		 
         <div class="row">
            <?php
            if ( is_active_sidebar( 'footer-1' ) ) : ?>
                <div class="footer-column col">
                    <?php dynamic_sidebar( 'footer-1'); ?>
                </div>
            <?php endif; ?>
        </div>
     </div>
 </div>