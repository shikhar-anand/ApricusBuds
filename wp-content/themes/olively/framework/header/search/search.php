<?php
/**
 *  PHP file for Top Search
 */
?>


<div id="olively_search" class="">
    <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
       <span class="screen-reader-text"><?php _ex( 'Search for:', 'label', 'olively' ); ?></span>
       <button class="jump-to-icon" tabindex="-1"></button>
       <input type="text" class="search-field top_search_field" placeholder="<?php echo esc_attr_e( 'Search...', 'olively' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" tabindex="-1">
       <button type="button" id="search-btn"><i class="fa fa-search"></i></button>
       <button class="jump-to-field" tabindex="-1"></button>
	</form>
</div>