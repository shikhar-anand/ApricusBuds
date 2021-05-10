<form role="search" method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="s"></label>
	<input type="text" value="<?php echo get_search_query(); ?>" placeholder="<?php echo esc_attr_x( 'Search for&hellip;', 'Placeholder', 'mencia' ); ?>" name="s" class="s" />
	<button type="submit" class="searchsubmit">
		<?php esc_html_e( 'Search', 'mencia' ); ?>
	</button>
</form>