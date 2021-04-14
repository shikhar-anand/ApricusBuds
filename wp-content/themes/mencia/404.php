<?php /* Template Name: 404 */ ?>
<?php get_header(); ?>

	<!-- Page Header -->
	<header class="masthead" style="background-image: url('<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/contact-bg.jpg')">
		<div class="overlay"></div>
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-10 mx-auto">
					<div class="site-heading">
						<h1 class="archive-title"><?php esc_html_e( 'Error 404!', 'mencia' ); ?></h1>
					</div>
				</div>
			</div>
		</div>
	</header>

	<!-- Main Content -->
	<div class="container">
		<div class="col-lg-8 col-md-10 mx-auto">    	
			<h1 class="archive-title"><?php esc_html_e( 'Page Not Found', 'mencia' ); ?></h1>
			<p class="archive-subtitle"><?php esc_html_e( 'Oops, the page you are looking for is not available', 'mencia' ); ?></p>
			<?php get_search_form(); ?>
			<a class="boton" href="<?php echo esc_url( home_url('/') ); ?>"><?php esc_html_e( 'Go back to start', 'mencia' ); ?></a>
		</div><!--.col-lg-8 col-md-10 mx-auto-->
	</div><!--.container-->	
<?php get_footer(); ?>