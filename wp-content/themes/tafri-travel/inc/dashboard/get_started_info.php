<?php

add_action( 'admin_menu', 'tafri_travel_gettingstarted' );
function tafri_travel_gettingstarted() {
	add_theme_page( esc_html__('About Theme', 'tafri-travel'), esc_html__('About Theme', 'tafri-travel'), 'edit_theme_options', 'tafri-travel-guide-page', 'tafri_travel_guide');   
}

function tafri_travel_admin_theme_style() {
   wp_enqueue_style('tafri-travel-custom-admin-style', esc_url(get_template_directory_uri()) . '/inc/dashboard/get_started_info.css');
   wp_enqueue_script('tabs', esc_url(get_template_directory_uri()) . '/inc/dashboard/js/tab.js');
}
add_action('admin_enqueue_scripts', 'tafri_travel_admin_theme_style');

function tafri_travel_notice(){
    global $pagenow;
    if ( is_admin() && ('themes.php' == $pagenow) && isset( $_GET['activated'] ) ) {?>
    <div class="notice notice-success is-dismissible getting_started">
		<div class="notice-content">
			<h2><?php esc_html_e( 'Thanks for installing Tafri Travel Lite Theme', 'tafri-travel' ) ?> </h2>
			<p><?php esc_html_e( "Please Click on the link below to know the theme setup information", 'tafri-travel' ) ?></p>
			<p><a href="<?php echo esc_url( admin_url( 'themes.php?page=tafri-travel-guide-page' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Get Started ', 'tafri-travel' ); ?></a></p>
		</div>
	</div>
	<?php }
}
add_action('admin_notices', 'tafri_travel_notice');

/**
 * Theme Info Page
 */
function tafri_travel_guide() {

	// Theme info
	$return = add_query_arg( array()) ;
	$theme = wp_get_theme( 'tafri-travel' ); ?>

	<div class="wrap getting-started">
		<div class="getting-started__header">
				<div class="intro">
					<div class="pad-box">
						<h2 align="center"><?php esc_html_e( 'Welcome to Tafri Travel Theme', 'tafri-travel' ); ?>
						<span class="version" align="center">Version: <?php echo esc_html($theme['Version']);?></span></h2>	
						</span>
						<div class="powered-by">
							<p align="center"><strong><?php esc_html_e( 'Theme created by ThemesEye', 'tafri-travel' ); ?></strong></p>
							<p align="center">
								<img role="img" class="logo" src="<?php echo esc_url(get_template_directory_uri() . '/inc/dashboard/media/logo.png'); ?>"/>
							</p>
						</div>
					</div>
				</div>

			<div class="tab">
			  <button role="tab" class="tablinks" onclick="tafri_travel_open(event, 'lite_theme')">Getting Started</button>		  
			  <button role="tab" class="tablinks" onclick="tafri_travel_open(event, 'pro_theme')">Get Premium</button>
			</div>

			<!-- Tab content -->
			<div id="lite_theme" class="tabcontent open">
				<h2 class="tg-docs-section intruction-title" id="section-4" align="center"><?php esc_html_e( '1). Tafri Travel Lite Theme', 'tafri-travel' ); ?></h2>
				<div class="row">
					<div class="col-md-5">
						<div class="pad-box">
	              			<img role="img" class="logo" src="<?php echo esc_url(get_template_directory_uri() . '/inc/dashboard/media/screenshot.png'); ?>"/>
	              		 </div> 
					</div>
					<div class="theme-instruction-block col-md-7">
						<div class="pad-box">
		                    <p><?php esc_html_e( 'This free WordPress travel theme is a great ally to design a beautiful, eye-catching, modern and clean website for travel agencies, tourist guides, travel and adventure bloggers, tour planners, tourism department and all other businesses related to tourism industry in one way or the other. With this theme, you dont have to worry about not having programming skills as using it is a cake walk for a professional coder and a WordPress newbie both. Compatibility of this free WordPress travel theme with almost all the plugins makes it super-efficient to perform any function; it is integrated with WooCommerce plugin to display products and plans sophisticatedly and inherit all the features and functionality needed for an online store in your website in the easiest possible way. It is extensively documented to further ease your work by giving you step by step guide on how to install, configure and make small changes to the theme on your own.', 'tafri-travel' ); ?></p>
							<ol>
								<li><?php esc_html_e( 'Start','tafri-travel'); ?> <a target="_blank" href="<?php echo esc_url( admin_url('customize.php') ); ?>"><?php esc_html_e( 'Customizing','tafri-travel'); ?></a> <?php esc_html_e( 'your website.','tafri-travel'); ?> </li>
								<li><?php esc_html_e( 'Tafri Travel','tafri-travel'); ?> <a target="_blank" href="<?php echo esc_url( TAFRI_TRAVEL_FREE_DOC ); ?>"><?php esc_html_e( 'Documentation','tafri-travel'); ?></a> </li>
							</ol>
	                    </div>
	                </div>
				</div><br><br>
				
	        </div>
	        <div id="pro_theme" class="tabcontent">
				<h2 class="dashboard-install-title" align="center"><?php esc_html_e( '2.) Premium Theme Information.','tafri-travel'); ?></h2>
            	<div class="row">
					<div class="col-md-7">
						<img role="img" src="<?php echo esc_url(get_template_directory_uri() . '/inc/dashboard/media/responsive.png'); ?>" alt="">
						<div class="pro-links" >
					    	<a href="<?php echo esc_url( TAFRI_TRAVEL_LIVE_DEMO ); ?>" target="_blank"><?php esc_html_e('Live Demo', 'tafri-travel'); ?></a>
							<a href="<?php echo esc_url( TAFRI_TRAVEL_BUY_PRO ); ?>"><?php esc_html_e('Buy Pro', 'tafri-travel'); ?></a>
							<a href="<?php echo esc_url( TAFRI_TRAVEL_PRO_DOC ); ?>" target="_blank"><?php esc_html_e('Pro Documentation', 'tafri-travel'); ?></a>
						</div>
						<div class="pad-box">
							<h3><?php esc_html_e( 'Pro Theme Description','tafri-travel'); ?></h3>
                    		<p class="pad-box-p"><?php esc_html_e( 'This WordPress travel theme is packed with some amazing shortcodes to implement features like multi-column layout, instagram feed, video, audio etc. without going into deep coding. It is optimized for search engines and has fast loading pages to boost your website speed. Colours play a vital role in a travel theme and we very well know this. Hence we provide unlimited colour options and numerous Google web fonts to use them anywhere in the website. It is a highly customizable theme to change its various elements in just a couple of clicks without involving in the coding part.', 'tafri-travel' ); ?><p>
                    	</div>
					</div>
					<div class="col-md-5 install-plugin-right">
						<div class="pad-box">								
							<h3><?php esc_html_e( 'Pro Theme Features','tafri-travel'); ?></h3>
							<div class="dashboard-install-benefit">
								<ul>
									<li><?php esc_html_e( 'Easy install 10 minute setup Themes','tafri-travel'); ?></li>
									<li><?php esc_html_e( 'Multiplue Domain Usage','tafri-travel'); ?></li>
									<li><?php esc_html_e( 'Premium Technical Support','tafri-travel'); ?></li>
									<li><?php esc_html_e( 'FREE Shortcodes','tafri-travel'); ?></li>
									<li><?php esc_html_e( 'Multiple page templates','tafri-travel'); ?></li>
									<li><?php esc_html_e( 'Google Font Integration','tafri-travel'); ?></li>
									<li><?php esc_html_e( 'Customizable Colors','tafri-travel'); ?></li>
									<li><?php esc_html_e( 'Theme customizer ','tafri-travel'); ?></li>
									<li><?php esc_html_e( 'Documention','tafri-travel'); ?></li>
									<li><?php esc_html_e( 'Unlimited Color Option','tafri-travel'); ?></li>
									<li><?php esc_html_e( 'Plugin Compatible','tafri-travel'); ?></li>
									<li><?php esc_html_e( 'Social Media Integration','tafri-travel'); ?></li>
									<li><?php esc_html_e( 'Incredible Support','tafri-travel'); ?></li>
									<li><?php esc_html_e( 'Eye Appealing Design','tafri-travel'); ?></li>
									<li><?php esc_html_e( 'Simple To Install','tafri-travel'); ?></li>
									<li><?php esc_html_e( 'Fully Responsive ','tafri-travel'); ?></li>
									<li><?php esc_html_e( 'Translation Ready','tafri-travel'); ?></li>
									<li><?php esc_html_e( 'Custom Page Templates ','tafri-travel'); ?></li>
									<li><?php esc_html_e( 'WooCommerce Integration','tafri-travel'); ?></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
          	<div class="dashboard__blocks">
				<div class="row">
					<div class="col-md-3">
						<h3><?php esc_html_e( 'Get Support','tafri-travel'); ?></h3>
						<ol>
							<li><a target="_blank" href="<?php echo esc_url( TAFRI_TRAVEL_FREE_SUPPORT ); ?>"><?php esc_html_e( 'Free Theme Support','tafri-travel'); ?></a></li>
							<li><a target="_blank" href="<?php echo esc_url( TAFRI_TRAVEL_PRO_SUPPORT ); ?>"><?php esc_html_e( 'Premium Theme Support','tafri-travel'); ?></a></li>
						</ol>
					</div>

					<div class="col-md-3">
						<h3><?php esc_html_e( 'Getting Started','tafri-travel'); ?></h3>
						<ol>
							<li><?php esc_html_e( 'Start','tafri-travel'); ?> <a target="_blank" href="<?php echo esc_url( admin_url('customize.php') ); ?>"><?php esc_html_e( 'Customizing','tafri-travel'); ?></a> <?php esc_html_e( 'your website.','tafri-travel'); ?> </li>
						</ol>
					</div>
					<div class="col-md-3">
						<h3><?php esc_html_e( 'Help Docs','tafri-travel'); ?></h3>
						<ol>
							<li><a target="_blank" href="<?php echo esc_url( TAFRI_TRAVEL_FREE_DOC ); ?>"><?php esc_html_e( 'Free Theme Documentation','tafri-travel'); ?></a></li>
							<li><a target="_blank" href="<?php echo esc_url( TAFRI_TRAVEL_PRO_DOC ); ?>"><?php esc_html_e( 'Premium Theme Documentation','tafri-travel'); ?></a></li>
						</ol>
					</div>
					<div class="col-md-3">
						<h3><?php esc_html_e( 'Buy Premium','tafri-travel'); ?></h3>
						<ol>
							<li><a href="<?php echo esc_url( TAFRI_TRAVEL_BUY_PRO ); ?>"><?php esc_html_e('Buy Pro', 'tafri-travel'); ?></a></li>
						</ol>
					</div>
				</div>
			</div>
		</div>
		
	</div>

<?php
}?>