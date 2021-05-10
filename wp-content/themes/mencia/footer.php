	<hr>
	<!-- Footer -->
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-10 mx-auto">
					<?php if(!dynamic_sidebar('widgetsfoot')); ?>
					<p class="fcopyright text-muted">&copy; 
						<?php echo esc_html( date_i18n( __( 'Y', 'mencia' ) ) ); ?> <a href="<?php echo esc_url( home_url('/') ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					</p>
					<p class="theme-credits">	
						<?php _e( 'Theme by', 'mencia' ); ?>
						<a href="<?php echo esc_url( __( 'https://www.bernibernal.com/', 'mencia' ) ); ?>">
							<?php _e( 'Berni Bernal', 'mencia' ); ?>
						</a>
					</p><!-- .theme-credits -->
				</div>
			</div>
		</div>
	</footer>
	<a href="#goup" class="goup"><i class="arrow-up icon" aria-hidden="true"></i></a>
	<?php wp_footer(); ?>

</body>
</html>