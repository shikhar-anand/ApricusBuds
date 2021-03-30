<?php

	$tafri_travel_first_theme_color = get_theme_mod('tafri_travel_first_theme_color');

	$tafri_travel_custom_css = '';

	$tafri_travel_custom_css .='#sidebar .tagcloud a:hover, .read-moresec a:hover,  #slider i:hover, #slider .inner_carousel .view-btn a, #destination hr, .date-color, .page-box:hover .read-more-btn a, #footer input[type="submit"], .copyright, .woocommerce span.onsale, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button,.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, #sidebar input[type="submit"], .pagination a:hover, .pagination .current, #footer .tagcloud a:hover, .des_box .des_content,.search-body i,input[type="submit"],.tags p a, #comments a.comment-reply-link,.post-navigation .nav-next a, .post-navigation .nav-previous a,.scrollup i, .widget .woocommerce-product-search button, #sidebar .widget_price_filter .ui-slider-horizontal .ui-slider-range, #sidebar .widget_price_filter .ui-slider .ui-slider-handle, #footer .widget_price_filter .ui-slider-horizontal .ui-slider-range, #footer .widget_price_filter .ui-slider .ui-slider-handle{';
		$tafri_travel_custom_css .='background-color: '.esc_attr($tafri_travel_first_theme_color).';';
	$tafri_travel_custom_css .='}';

	$tafri_travel_custom_css .='#comments input[type="submit"].submit{';
		$tafri_travel_custom_css .='background-color: '.esc_attr($tafri_travel_first_theme_color).'!important;';
	$tafri_travel_custom_css .='}';

	$tafri_travel_custom_css .='.pagination span, .pagination a,input[type="search"], .read-moresec a, .page-box:hover h4, .read-more-btn a, #footer h3, a.showcoupon,.woocommerce-message::before, .woocommerce ul.products li.product .price,.woocommerce div.product p.price, .woocommerce div.product span.price, .woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover,.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce .quantity .qty, #sidebar caption, #sidebar h3, h2.entry-title,
		h1.page-title, a, .content-box h2,.page-box-single .metabox, .content-box h3, #footer li a:hover, span.entry-date i, .primary-menu ul li a:hover,.primary-menu ul ul li a,.primary-menu ul ul a,#sidebar ul li a:hover, .widget ul.cart_list li .star-rating, .widget ul.product_list_widget li .star-rating, .woocommerce .woocommerce-product-rating .star-rating{';
		$tafri_travel_custom_css .='color: '.esc_attr($tafri_travel_first_theme_color).';';
	$tafri_travel_custom_css .='}';

	$tafri_travel_custom_css .='@media screen and (max-width: 1000px){
	.primary-menu ul li a, .primary-menu a, .primary-menu ul ul li a{';
		$tafri_travel_custom_css .='color: '.esc_attr($tafri_travel_first_theme_color).' !important;';
	$tafri_travel_custom_css .='} }';

	$tafri_travel_custom_css .='#slider i:hover,#destination h2, #slider .inner_carousel .view-btn a, #footer input[type="search"], .read-more-btn a,.woocommerce .quantity .qty, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .read-moresec a,.scrollup i{';
		$tafri_travel_custom_css .='border-color: '.esc_attr($tafri_travel_first_theme_color).';';
	$tafri_travel_custom_css .='}';

	$tafri_travel_custom_css .='.woocommerce-message{';
		$tafri_travel_custom_css .='border-top-color: '.esc_attr($tafri_travel_first_theme_color).';';
	$tafri_travel_custom_css .='}';

	$tafri_travel_custom_css .='.top-header{';
		$tafri_travel_custom_css .='border-bottom-color: '.esc_attr($tafri_travel_first_theme_color).'!important;';
	$tafri_travel_custom_css .='}';

	$tafri_travel_custom_css .='.primary-menu ul ul li:hover{';
		$tafri_travel_custom_css .='border-left-color: '.esc_attr($tafri_travel_first_theme_color).';';
	$tafri_travel_custom_css .='}';

	$tafri_travel_custom_css .='#comments input[type="submit"].submit, nav.woocommerce-MyAccount-navigation ul li{';
		$tafri_travel_custom_css .='background-color: '.esc_attr($tafri_travel_first_theme_color).'!important;';
	$tafri_travel_custom_css .='}';

	$tafri_travel_custom_css .='.page-box-single h1{';
		$tafri_travel_custom_css .='color: '.esc_attr($tafri_travel_first_theme_color).'!important;';
	$tafri_travel_custom_css .='}';

	/*---------------Second highlight color-------------------*/
	$tafri_travel_second_theme_color = get_theme_mod('tafri_travel_second_theme_color');

	$tafri_travel_custom_css .='#footer,.tags p a:hover,.post-navigation .nav-next a:hover, .post-navigation .nav-previous a:hover, .fixed-header, .page-template-home-custom .fixed-header .main-menu{';
		$tafri_travel_custom_css .='background-color: '.esc_attr($tafri_travel_second_theme_color).';';
	$tafri_travel_custom_css .='}';

	$tafri_travel_custom_css .='{';
		$tafri_travel_custom_css .='color: '.esc_attr($tafri_travel_second_theme_color).';';
	$tafri_travel_custom_css .='}';

	$tafri_travel_custom_css .='{';
		$tafri_travel_custom_css .='border-color: '.esc_attr($tafri_travel_second_theme_color).';';
	$tafri_travel_custom_css .='}';

	/*---------------------------Width Layout -------------------*/
	$tafri_travel_theme_lay = get_theme_mod( 'tafri_travel_theme_options','Default');
    if($tafri_travel_theme_lay == 'Default'){
		$tafri_travel_custom_css .='body{';
			$tafri_travel_custom_css .='max-width: 100%;';
		$tafri_travel_custom_css .='}';
		$tafri_travel_custom_css .='.page-template-custom-home-page .middle-header{';
			$tafri_travel_custom_css .='width: 97.3%';
		$tafri_travel_custom_css .='}';
	}else if($tafri_travel_theme_lay == 'Wide Layout'){
		$tafri_travel_custom_css .='body{';
			$tafri_travel_custom_css .='width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;';
		$tafri_travel_custom_css .='}';
		$tafri_travel_custom_css .='.page-template-custom-home-page .middle-header{';
			$tafri_travel_custom_css .='width: 97.7%';
		$tafri_travel_custom_css .='}';
	}else if($tafri_travel_theme_lay == 'Box Layout'){
		$tafri_travel_custom_css .='body{';
			$tafri_travel_custom_css .='max-width: 1140px; width: 100%; padding-right: 15px; padding-left: 15px; margin-right: auto; margin-left: auto;';
		$tafri_travel_custom_css .='}';
		$tafri_travel_custom_css .='.page-template-home-custom #header{';
			$tafri_travel_custom_css .=' right: 0;';
		$tafri_travel_custom_css .='}';
	}

	/*--------------------------- Slider Opacity -------------------*/
	$tafri_travel_slider_layout = get_theme_mod( 'tafri_travel_slider_opacity_color','0.7');
	if($tafri_travel_slider_layout == '0'){
		$tafri_travel_custom_css .='#slider img{';
			$tafri_travel_custom_css .='opacity:0';
		$tafri_travel_custom_css .='}';
		}else if($tafri_travel_slider_layout == '0.1'){
		$tafri_travel_custom_css .='#slider img{';
			$tafri_travel_custom_css .='opacity:0.1';
		$tafri_travel_custom_css .='}';
		}else if($tafri_travel_slider_layout == '0.2'){
		$tafri_travel_custom_css .='#slider img{';
			$tafri_travel_custom_css .='opacity:0.2';
		$tafri_travel_custom_css .='}';
		}else if($tafri_travel_slider_layout == '0.3'){
		$tafri_travel_custom_css .='#slider img{';
			$tafri_travel_custom_css .='opacity:0.3';
		$tafri_travel_custom_css .='}';
		}else if($tafri_travel_slider_layout == '0.4'){
		$tafri_travel_custom_css .='#slider img{';
			$tafri_travel_custom_css .='opacity:0.4';
		$tafri_travel_custom_css .='}';
		}else if($tafri_travel_slider_layout == '0.5'){
		$tafri_travel_custom_css .='#slider img{';
			$tafri_travel_custom_css .='opacity:0.5';
		$tafri_travel_custom_css .='}';
		}else if($tafri_travel_slider_layout == '0.6'){
		$tafri_travel_custom_css .='#slider img{';
			$tafri_travel_custom_css .='opacity:0.6';
		$tafri_travel_custom_css .='}';
		}else if($tafri_travel_slider_layout == '0.7'){
		$tafri_travel_custom_css .='#slider img{';
			$tafri_travel_custom_css .='opacity:0.7';
		$tafri_travel_custom_css .='}';
		}else if($tafri_travel_slider_layout == '0.8'){
		$tafri_travel_custom_css .='#slider img{';
			$tafri_travel_custom_css .='opacity:0.8';
		$tafri_travel_custom_css .='}';
		}else if($tafri_travel_slider_layout == '0.9'){
		$tafri_travel_custom_css .='#slider img{';
			$tafri_travel_custom_css .='opacity:0.9';
		$tafri_travel_custom_css .='}';
		}

	/*----------------Slider Content Layout ----------------*/
	$tafri_travel_slider_layout = get_theme_mod( 'tafri_travel_slider_content_option','Center');
    if($tafri_travel_slider_layout == 'Left'){
		$tafri_travel_custom_css .='#slider .carousel-caption, #slider .inner_carousel, #slider .inner_carousel h1, #slider .inner_carousel p, #slider .readbutton{';
			$tafri_travel_custom_css .='text-align:left; left:15%; right:45%;';
		$tafri_travel_custom_css .='}';
		$tafri_travel_custom_css .='
		@media screen and (max-width: 767px){
		#slider .inner_carousel .view-btn a{';
		$tafri_travel_custom_css .='padding: 12px 15px; font-size: 12px;';
		$tafri_travel_custom_css .='} }';
		$tafri_travel_custom_css .='
		@media screen and (max-width: 1024px) and (min-width: 768px){
		#slider .carousel-caption{';
		$tafri_travel_custom_css .='top:43%;';
		$tafri_travel_custom_css .='} }';
	}else if($tafri_travel_slider_layout == 'Center'){
		$tafri_travel_custom_css .='#slider .carousel-caption, #slider .inner_carousel, #slider .inner_carousel h1, #slider .inner_carousel p, #slider .readbutton{';
			$tafri_travel_custom_css .='text-align:center; left:20%; right:20%;';
		$tafri_travel_custom_css .='}';
	}else if($tafri_travel_slider_layout == 'Right'){
		$tafri_travel_custom_css .='#slider .carousel-caption, #slider .inner_carousel, #slider .inner_carousel h1, #slider .inner_carousel p, #slider .readbutton{';
			$tafri_travel_custom_css .='text-align:right; left:45%; right:15%;';
		$tafri_travel_custom_css .='}';
		$tafri_travel_custom_css .='
		@media screen and (max-width: 767px){
		#slider .inner_carousel .view-btn a{';
		$tafri_travel_custom_css .='padding: 12px 15px; font-size: 12px;';
		$tafri_travel_custom_css .='} }';
		$tafri_travel_custom_css .='
		@media screen and (max-width: 1024px) and (min-width: 768px){
		#slider .carousel-caption{';
		$tafri_travel_custom_css .='top:43%;';
		$tafri_travel_custom_css .='} }';
	}

	// css
	$tafri_travel_show_slider = get_theme_mod( 'tafri_travel_slider_hide', false);
	if($tafri_travel_show_slider == false){
		$tafri_travel_custom_css .='.page-template-home-custom #header{';
			$tafri_travel_custom_css .='position: static; background: #0f2036; width: 100%;';
		$tafri_travel_custom_css .='}';
	}
	if($tafri_travel_show_slider == false){
		$tafri_travel_custom_css .='.page-template-home-custom .top-header{';
			$tafri_travel_custom_css .='border-bottom: 1px solid #26bdf7;';
		$tafri_travel_custom_css .='}';
	}

	$tafri_travel_show_header = get_theme_mod( 'tafri_travel_show_hide_topbar', true);
	if($tafri_travel_show_header == true){
		$tafri_travel_custom_css .='.top-header{';
			$tafri_travel_custom_css .='border-bottom:1px solid #26bdf7;';
		$tafri_travel_custom_css .='}';
	}else if($tafri_travel_show_header == false){
		$tafri_travel_custom_css .='.top-header{';
			$tafri_travel_custom_css .='border-bottom:none;';
		$tafri_travel_custom_css .='}';
	}

	/*-------------------------- Button Settings option------------------*/
	$tafri_travel_top_bottom_padding = get_theme_mod('tafri_travel_top_bottom_padding');
	$tafri_travel_left_right_padding = get_theme_mod('tafri_travel_left_right_padding');
	$tafri_travel_custom_css .='.read-more-btn a, #slider .inner_carousel .view-btn a, #comments input[type="submit"].submit{';
		$tafri_travel_custom_css .='padding-top: '.esc_attr($tafri_travel_top_bottom_padding).'px; padding-bottom: '.esc_attr($tafri_travel_top_bottom_padding).'px; padding-left: '.esc_attr($tafri_travel_left_right_padding).'px; padding-right: '.esc_attr($tafri_travel_left_right_padding).'px; display:inline-block;';
	$tafri_travel_custom_css .='}';

	$tafri_travel_border_radius = get_theme_mod('tafri_travel_border_radius');
	$tafri_travel_custom_css .='.read-more-btn a,#slider .inner_carousel .view-btn a, #comments input[type="submit"].submit{';
		$tafri_travel_custom_css .='border-radius: '.esc_attr($tafri_travel_border_radius).'px;';
	$tafri_travel_custom_css .='}';

	/*---------------------------Blog Layout -------------------*/
	$tafri_travel_theme_lay = get_theme_mod( 'tafri_travel_blog_post_layout','Default');
    if($tafri_travel_theme_lay == 'Default'){
		$tafri_travel_custom_css .='.page-box{';
			$tafri_travel_custom_css .='';
		$tafri_travel_custom_css .='}';
	}else if($tafri_travel_theme_lay == 'Center'){
		$tafri_travel_custom_css .='.page-box, .page-box h2, .post-info, .text p, .page-box .post-link{';
			$tafri_travel_custom_css .='text-align:center;';
		$tafri_travel_custom_css .='}';
		$tafri_travel_custom_css .='.post-info{';
			$tafri_travel_custom_css .='margin-top:10px;';
		$tafri_travel_custom_css .='}';
		$tafri_travel_custom_css .='.page-box .post-link{';
			$tafri_travel_custom_css .='margin-top:25px;';
		$tafri_travel_custom_css .='}';
		$tafri_travel_custom_css .='.post-info hr{';
			$tafri_travel_custom_css .='margin:10px auto;';
		$tafri_travel_custom_css .='}';
	}else if($tafri_travel_theme_lay == 'left'){
		$tafri_travel_custom_css .='.page-box, .page-box h2, .post-info, .text p, .page-box .post-link, #our-services p{';
			$tafri_travel_custom_css .='text-align:Left;';
		$tafri_travel_custom_css .='}';
		$tafri_travel_custom_css .='.page-box .post-link{';
			$tafri_travel_custom_css .='margin:20px 0;';
		$tafri_travel_custom_css .='}';
		$tafri_travel_custom_css .='.post-info hr{';
			$tafri_travel_custom_css .='margin-bottom:10px;';
		$tafri_travel_custom_css .='}';
		$tafri_travel_custom_css .='.page-box h2{';
			$tafri_travel_custom_css .='margin-top:10px;';
		$tafri_travel_custom_css .='}';
	}

	/*--------- Preloader Color Option -------*/
	$tafri_travel_loader_color_setting = get_theme_mod('tafri_travel_loader_color_setting');

	if($tafri_travel_loader_color_setting != false){
		$tafri_travel_custom_css .=' .circle .inner{';
			$tafri_travel_custom_css .='border-color: '.esc_attr($tafri_travel_loader_color_setting).';';
		$tafri_travel_custom_css .='} ';
	}

	$tafri_travel_loader_background_color = get_theme_mod('tafri_travel_loader_background_color');

	if($tafri_travel_loader_background_color != false){
		$tafri_travel_custom_css .=' #pre-loader{';
			$tafri_travel_custom_css .='background-color: '.esc_attr($tafri_travel_loader_background_color).';';
		$tafri_travel_custom_css .='} ';
	}

	$tafri_travel_theme_lay = get_theme_mod( 'tafri_travel_preloader_types','Default');
    if($tafri_travel_theme_lay == 'Default'){
		$tafri_travel_custom_css .='{';
			$tafri_travel_custom_css .='';
		$tafri_travel_custom_css .='}';
	}elseif($tafri_travel_theme_lay == 'Circle'){
		$tafri_travel_custom_css .='.circle .inner{';
			$tafri_travel_custom_css .='width:unset;';
		$tafri_travel_custom_css .='}';
	}elseif($tafri_travel_theme_lay == 'Two Circle'){
		$tafri_travel_custom_css .='.circle .inner{';
			$tafri_travel_custom_css .='width:80%;
    border-right: 5px;';
		$tafri_travel_custom_css .='}';
	}

	// Responsive Media
	$tafri_travel_preloader = get_theme_mod( 'tafri_travel_enable_disable_preloader', true);
	if($tafri_travel_preloader == true && get_theme_mod( 'tafri_travel_loader_setting', true) == false){
    	$tafri_travel_custom_css .='#pre-loader{';
			$tafri_travel_custom_css .='display:none;';
		$tafri_travel_custom_css .='} ';
	}
    if($tafri_travel_preloader == true){
    	$tafri_travel_custom_css .='@media screen and (max-width:575px) {';
		$tafri_travel_custom_css .='#pre-loader{';
			$tafri_travel_custom_css .='display:block;';
		$tafri_travel_custom_css .='} }';
	}else if($tafri_travel_preloader == false){
		$tafri_travel_custom_css .='@media screen and (max-width:575px) {';
		$tafri_travel_custom_css .='#pre-loader{';
			$tafri_travel_custom_css .='display:none;';
		$tafri_travel_custom_css .='} }';
	}

	$tafri_travel_sidebar = get_theme_mod( 'tafri_travel_enable_disable_sidebar',true);
    if($tafri_travel_sidebar == true){
    	$tafri_travel_custom_css .='@media screen and (max-width:575px) {';
		$tafri_travel_custom_css .='#sidebar{';
			$tafri_travel_custom_css .='display:block;';
		$tafri_travel_custom_css .='} }';
	}else if($tafri_travel_sidebar == false){
		$tafri_travel_custom_css .='@media screen and (max-width:575px) {';
		$tafri_travel_custom_css .='#sidebar{';
			$tafri_travel_custom_css .='display:none;';
		$tafri_travel_custom_css .='} }';
	}

	$tafri_travel_topheader = get_theme_mod( 'tafri_travel_enable_disable_topbar',true);
	if($tafri_travel_topheader == true && get_theme_mod( 'tafri_travel_show_hide_topbar', true) == false){
    	$tafri_travel_custom_css .='.top-header{';
			$tafri_travel_custom_css .='display:none;';
		$tafri_travel_custom_css .='} ';
	}
    if($tafri_travel_topheader == true){
    	$tafri_travel_custom_css .='@media screen and (max-width:575px) {';
		$tafri_travel_custom_css .='.top-header{';
			$tafri_travel_custom_css .='display:block;';
		$tafri_travel_custom_css .='} }';
	}else if($tafri_travel_topheader == false){
		$tafri_travel_custom_css .='@media screen and (max-width:575px) {';
		$tafri_travel_custom_css .='.top-header{';
			$tafri_travel_custom_css .='display:none;';
		$tafri_travel_custom_css .='} }';
	}

	$tafri_travel_stickyheader = get_theme_mod( 'tafri_travel_enable_disable_fixed_header',false);
	if($tafri_travel_stickyheader == true && get_theme_mod( 'tafri_travel_fixed_header', false) == false){
    	$tafri_travel_custom_css .='.fixed-header{';
			$tafri_travel_custom_css .='position:static;';
		$tafri_travel_custom_css .='} ';
	}
    if($tafri_travel_stickyheader == true){
    	$tafri_travel_custom_css .='@media screen and (max-width:575px) {';
		$tafri_travel_custom_css .='.fixed-header{';
			$tafri_travel_custom_css .='position:fixed;';
		$tafri_travel_custom_css .='} }';
	}else if($tafri_travel_stickyheader == false){
		$tafri_travel_custom_css .='@media screen and (max-width:575px) {';
		$tafri_travel_custom_css .='.fixed-header{';
			$tafri_travel_custom_css .='position:static;';
		$tafri_travel_custom_css .='} }';
	}

	$tafri_travel_sliderbutton = get_theme_mod( 'tafri_travel_enable_disable_slider', false);
	if($tafri_travel_sliderbutton == true && get_theme_mod( 'tafri_travel_slider_hide', false) == false){
    	$tafri_travel_custom_css .='#slider{';
			$tafri_travel_custom_css .='display:none;';
		$tafri_travel_custom_css .='} ';
	}
    if($tafri_travel_sliderbutton == true){
    	$tafri_travel_custom_css .='@media screen and (max-width:575px) {';
		$tafri_travel_custom_css .='#slider{';
			$tafri_travel_custom_css .='display:block;';
		$tafri_travel_custom_css .='} }';
	}else if($tafri_travel_sliderbutton == false){
		$tafri_travel_custom_css .='@media screen and (max-width:575px){';
		$tafri_travel_custom_css .='#slider{';
			$tafri_travel_custom_css .='display:none;';
		$tafri_travel_custom_css .='} }';
	}

	$tafri_travel_sliderbutton = get_theme_mod( 'tafri_travel_show_hide_slider_button',true);
	if($tafri_travel_sliderbutton == true && get_theme_mod( 'tafri_travel_slider_button',true) == false){
    	$tafri_travel_custom_css .='.view-btn{';
			$tafri_travel_custom_css .='display:none;';
		$tafri_travel_custom_css .='} ';
	}
    if($tafri_travel_sliderbutton == true){
    	$tafri_travel_custom_css .='@media screen and (max-width:575px) {';
		$tafri_travel_custom_css .='.view-btn{';
			$tafri_travel_custom_css .='display:block;';
		$tafri_travel_custom_css .='} }';
	}else if($tafri_travel_sliderbutton == false){
		$tafri_travel_custom_css .='@media screen and (max-width:575px){';
		$tafri_travel_custom_css .='.view-btn{';
			$tafri_travel_custom_css .='display:none;';
		$tafri_travel_custom_css .='} }';
	}

	$tafri_travel_sliderbutton = get_theme_mod( 'tafri_travel_enable_disable_scrolltop',true);
	if($tafri_travel_sliderbutton == true && get_theme_mod( 'tafri_travel_hide_show_scroll',true) != true){
    	$tafri_travel_custom_css .='.scrollup i{';
			$tafri_travel_custom_css .='display:none;';
		$tafri_travel_custom_css .='} ';
	}
    if($tafri_travel_sliderbutton == true){
    	$tafri_travel_custom_css .='@media screen and (max-width:575px) {';
		$tafri_travel_custom_css .='.scrollup i{';
			$tafri_travel_custom_css .='display:block;';
		$tafri_travel_custom_css .='} }';
	}else if($tafri_travel_sliderbutton == false){
		$tafri_travel_custom_css .='@media screen and (max-width:575px){';
		$tafri_travel_custom_css .='.scrollup i{';
			$tafri_travel_custom_css .='display:none;';
		$tafri_travel_custom_css .='} }';
	}

	$tafri_travel_search = get_theme_mod( 'tafri_travel_mobile_enable_disable_search',true);
	if($tafri_travel_search == true && get_theme_mod( 'tafri_travel_enable_disable_search', true) == false){
    	$tafri_travel_custom_css .='.search-body{';
			$tafri_travel_custom_css .='display:none;';
		$tafri_travel_custom_css .='} ';
	}
    if($tafri_travel_search == true){
    	$tafri_travel_custom_css .='@media screen and (max-width:575px) {';
		$tafri_travel_custom_css .='.search-body{';
			$tafri_travel_custom_css .='display:block;';
		$tafri_travel_custom_css .='} }';
	}else if($tafri_travel_search == false){
		$tafri_travel_custom_css .='@media screen and (max-width:575px) {';
		$tafri_travel_custom_css .='.search-body{';
			$tafri_travel_custom_css .='display:none;';
		$tafri_travel_custom_css .='} }';
	}

	$tafri_travel_myaccount = get_theme_mod( 'tafri_travel_mobile_enable_disable_myaccount',true);
	if($tafri_travel_myaccount == true && get_theme_mod( 'tafri_travel_enable_disable_myaccount', true) == false){
    	$tafri_travel_custom_css .='.top-header .account-btn{';
			$tafri_travel_custom_css .='display:none;';
		$tafri_travel_custom_css .='} ';
	}
    if($tafri_travel_myaccount == true){
    	$tafri_travel_custom_css .='@media screen and (max-width:575px) {';
		$tafri_travel_custom_css .='.top-header .account-btn{';
			$tafri_travel_custom_css .='display:block;';
		$tafri_travel_custom_css .='} }';
	}else if($tafri_travel_myaccount == false){
		$tafri_travel_custom_css .='@media screen and (max-width:575px) {';
		$tafri_travel_custom_css .='.top-header .account-btn{';
			$tafri_travel_custom_css .='display:none;';
		$tafri_travel_custom_css .='} }';
	}

	$tafri_travel_post_date = get_theme_mod( 'tafri_travel_enable_disable_post_date',true);
	if($tafri_travel_post_date == true && get_theme_mod( 'tafri_travel_date_hide',true) != true){
    	$tafri_travel_custom_css .='.page-box .entry-date{';
			$tafri_travel_custom_css .='display:none;';
		$tafri_travel_custom_css .='} ';
	}
    if($tafri_travel_post_date == true){
    	$tafri_travel_custom_css .='@media screen and (max-width:575px) {';
		$tafri_travel_custom_css .='.page-box .entry-date{';
			$tafri_travel_custom_css .='display:block;';
		$tafri_travel_custom_css .='} }';
	}else if($tafri_travel_post_date == false){
		$tafri_travel_custom_css .='@media screen and (max-width:575px){';
		$tafri_travel_custom_css .='.page-box .entry-date{';
			$tafri_travel_custom_css .='display:none;';
		$tafri_travel_custom_css .='} }';
	}

	$tafri_travel_post_author = get_theme_mod( 'tafri_travel_enable_disable_post_author',true);
	if($tafri_travel_post_author == true && get_theme_mod( 'tafri_travel_author_hide',true) != true){
    	$tafri_travel_custom_css .='.metabox .entry-author{';
			$tafri_travel_custom_css .='display:none;';
		$tafri_travel_custom_css .='} ';
	}
    if($tafri_travel_post_author == true){
    	$tafri_travel_custom_css .='@media screen and (max-width:575px) {';
		$tafri_travel_custom_css .='.metabox .entry-author{';
			$tafri_travel_custom_css .='display:inline-block;';
		$tafri_travel_custom_css .='} }';
	}else if($tafri_travel_post_author == false){
		$tafri_travel_custom_css .='@media screen and (max-width:575px){';
		$tafri_travel_custom_css .='.metabox .entry-author{';
			$tafri_travel_custom_css .='display:none;';
		$tafri_travel_custom_css .='} }';
	}

	$tafri_travel_post_comment = get_theme_mod( 'tafri_travel_enable_disable_post_comment',true);
	if($tafri_travel_post_comment == true && get_theme_mod( 'tafri_travel_comment_hide',true) != true){
    	$tafri_travel_custom_css .='.metabox .entry-comments{';
			$tafri_travel_custom_css .='display:none;';
		$tafri_travel_custom_css .='} ';
	}
    if($tafri_travel_post_comment == true){
    	$tafri_travel_custom_css .='@media screen and (max-width:575px) {';
		$tafri_travel_custom_css .='.metabox .entry-comments{';
			$tafri_travel_custom_css .='display: inline-block;';
		$tafri_travel_custom_css .='} }';
	}else if($tafri_travel_post_comment == false){
		$tafri_travel_custom_css .='@media screen and (max-width:575px){';
		$tafri_travel_custom_css .='.metabox .entry-comments{';
			$tafri_travel_custom_css .='display:none;';
		$tafri_travel_custom_css .='} }';
	}

	$tafri_travel_post_time = get_theme_mod( 'tafri_travel_enable_disable_single_post_time',true);
	if($tafri_travel_post_time == true && get_theme_mod( 'tafri_travel_single_post_time',true) != true){
    	$tafri_travel_custom_css .='.metabox .entry-time{';
			$tafri_travel_custom_css .='display:none;';
		$tafri_travel_custom_css .='} ';
	}
    if($tafri_travel_post_time == true){
    	$tafri_travel_custom_css .='@media screen and (max-width:575px) {';
		$tafri_travel_custom_css .='.metabox .entry-time{';
			$tafri_travel_custom_css .='display:inline-block;';
		$tafri_travel_custom_css .='} }';
	}else if($tafri_travel_post_time == false){
		$tafri_travel_custom_css .='@media screen and (max-width:575px){';
		$tafri_travel_custom_css .='.metabox .entry-time{';
			$tafri_travel_custom_css .='display:none;';
		$tafri_travel_custom_css .='} }';
	}

	if($tafri_travel_post_author == false && $tafri_travel_post_comment == false){
		$tafri_travel_custom_css .='@media screen and (max-width:575px) {';
    	$tafri_travel_custom_css .='.page-box .metabox{';
			$tafri_travel_custom_css .='display:none;';
		$tafri_travel_custom_css .='} }';
	}

	// Copyright top-bottom padding setting 
	$tafri_travel_copyright_top_bottom_padding = get_theme_mod('tafri_travel_copyright_top_bottom_padding');
	$tafri_travel_custom_css .='.copyright{';
		$tafri_travel_custom_css .='padding-top: '.esc_attr($tafri_travel_copyright_top_bottom_padding).'px; padding-bottom: '.esc_attr($tafri_travel_copyright_top_bottom_padding).'px;';
	$tafri_travel_custom_css .='}';

	$tafri_travel_footer_text_font_size = get_theme_mod('tafri_travel_footer_text_font_size');
	$tafri_travel_custom_css .='.copyright span{';
		$tafri_travel_custom_css .='font-size: '.esc_attr($tafri_travel_footer_text_font_size).'px;';
	$tafri_travel_custom_css .='}';

	// scroll to top setting
	$tafri_travel_scroll_border_radius = get_theme_mod('tafri_travel_scroll_border_radius');
	$tafri_travel_custom_css .='.scrollup i{';
		$tafri_travel_custom_css .='border-radius: '.esc_attr($tafri_travel_scroll_border_radius).'px;';
	$tafri_travel_custom_css .='}';

	$tafri_travel_scroll_top_fontsize = get_theme_mod('tafri_travel_scroll_top_fontsize');
	$tafri_travel_custom_css .='.scrollup i{';
		$tafri_travel_custom_css .='font-size: '.esc_attr($tafri_travel_scroll_top_fontsize).'px;';
	$tafri_travel_custom_css .='}';

	$tafri_travel_scroll_top_bottom_padding = get_theme_mod('tafri_travel_scroll_top_bottom_padding');
	$tafri_travel_scroll_left_right_padding = get_theme_mod('tafri_travel_scroll_left_right_padding');
	$tafri_travel_custom_css .='.scrollup i{';
		$tafri_travel_custom_css .='padding-top: '.esc_attr($tafri_travel_scroll_top_bottom_padding).'px; padding-bottom: '.esc_attr($tafri_travel_scroll_top_bottom_padding).'px; padding-left: '.esc_attr($tafri_travel_scroll_left_right_padding).'px; padding-right: '.esc_attr($tafri_travel_scroll_left_right_padding).'px;';
	$tafri_travel_custom_css .='}';

	// Topbar padding top bottom
	$tafri_travel_topbar_top_bottom_padding = get_theme_mod('tafri_travel_topbar_top_bottom_padding');
	$tafri_travel_custom_css .='.top-header{';
		$tafri_travel_custom_css .='padding-top: '.esc_attr($tafri_travel_topbar_top_bottom_padding).'px; padding-bottom: '.esc_attr($tafri_travel_topbar_top_bottom_padding).'px;';
	$tafri_travel_custom_css .='}';

	// Slider Height 
	$tafri_travel_slider_height_option = get_theme_mod('tafri_travel_slider_height_option');
	$tafri_travel_custom_css .='#slider img{';
		$tafri_travel_custom_css .='height: '.esc_attr($tafri_travel_slider_height_option).'px;';
	$tafri_travel_custom_css .='}';
	$tafri_travel_custom_css .=' @media screen and (max-width:768px){
		#slider img{';
		$tafri_travel_custom_css .='height: auto;';
	$tafri_travel_custom_css .='} }';

	$tafri_travel_padding_top_bottom_slider_content = get_theme_mod('tafri_travel_padding_top_bottom_slider_content');
	$tafri_travel_padding_left_right_slider_content = get_theme_mod('tafri_travel_padding_left_right_slider_content');
	$tafri_travel_custom_css .='#slider .carousel-caption, #slider .inner_carousel, #slider .inner_carousel h1, #slider .inner_carousel p, #slider .readbutton{';
		$tafri_travel_custom_css .='top: '.esc_attr($tafri_travel_padding_top_bottom_slider_content).'%; bottom: '.esc_attr($tafri_travel_padding_top_bottom_slider_content).'%;left: '.esc_attr($tafri_travel_padding_left_right_slider_content).'%;right: '.esc_attr($tafri_travel_padding_left_right_slider_content).'%;';
	$tafri_travel_custom_css .='}';

	/*------------------ Background Skin Option  -------------------*/
	$tafri_travel_theme_lay = get_theme_mod( 'tafri_travel_background_image_type','Transparent');
    if($tafri_travel_theme_lay == 'Background'){
		$tafri_travel_custom_css .='.page-box, #sidebar aside, .woocommerce ul.products li.product, .woocommerce-page ul.products li.product, .front-page-content,.background-img-skin, .page-box-single,.pages-te,#destination{';
			$tafri_travel_custom_css .='background-color: #fff;';
		$tafri_travel_custom_css .='}';
	}else if($tafri_travel_theme_lay == 'Transparent'){
		$tafri_travel_custom_css .='{';
			$tafri_travel_custom_css .='background-color: transparent;';
		$tafri_travel_custom_css .='}';
	}

	// footer widget background
	$tafri_travel_footer_widget_background = get_theme_mod('tafri_travel_footer_widget_background');
	$tafri_travel_custom_css .='#footer{';
		$tafri_travel_custom_css .='background-color: '.esc_attr($tafri_travel_footer_widget_background).';';
	$tafri_travel_custom_css .='}';

	$tafri_travel_footer_widget_image = get_theme_mod('tafri_travel_footer_widget_image');
	if($tafri_travel_footer_widget_image != false){
		$tafri_travel_custom_css .='#footer{';
			$tafri_travel_custom_css .='background: url('.esc_attr($tafri_travel_footer_widget_image).');';
		$tafri_travel_custom_css .='}';
	}

	/*------------- Navigation Menu Font Size ------------------*/
	$tafri_travel_navigation_menu_font_size = get_theme_mod('tafri_travel_navigation_menu_font_size');
	$tafri_travel_custom_css .='.primary-menu a{';
		$tafri_travel_custom_css .='font-size: '.esc_attr($tafri_travel_navigation_menu_font_size).'px;';
	$tafri_travel_custom_css .='}';

	$tafri_travel_theme_lay = get_theme_mod( 'tafri_travel_menu_text_tranform','Default');
    if($tafri_travel_theme_lay == 'Default'){
		$tafri_travel_custom_css .='.primary-menu a,#resmenu-sidebar .primary-menu a{';
			$tafri_travel_custom_css .='';
		$tafri_travel_custom_css .='}';
	}else if($tafri_travel_theme_lay == 'Uppercase'){
		$tafri_travel_custom_css .='.primary-menu a,#resmenu-sidebar .primary-menu a{';
			$tafri_travel_custom_css .='text-transform:Uppercase;';
		$tafri_travel_custom_css .='}';
	}

	$tafri_travel_theme_lay = get_theme_mod( 'tafri_travel_menu_font_weight','Default');
    if($tafri_travel_theme_lay == 'Default'){
		$tafri_travel_custom_css .='.primary-menu a,#resmenu-sidebar .primary-menu a{';
			$tafri_travel_custom_css .='';
		$tafri_travel_custom_css .='}';
	}else if($tafri_travel_theme_lay == 'Normal'){
		$tafri_travel_custom_css .='.primary-menu a,#resmenu-sidebar .primary-menu a{';
			$tafri_travel_custom_css .='font-weight: normal;';
		$tafri_travel_custom_css .='}';
	}
	
	/*------------ Woocommerce Settings  --------------*/

	$tafri_travel_shop_button_padding_top = get_theme_mod('tafri_travel_shop_button_padding_top', 10);
	$tafri_travel_custom_css .='.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce button.button:disabled, .woocommerce button.button:disabled[disabled]{';
		$tafri_travel_custom_css .='padding-top: '.esc_attr($tafri_travel_shop_button_padding_top).'px; padding-bottom: '.esc_attr($tafri_travel_shop_button_padding_top).'px;';
	$tafri_travel_custom_css .='}';

	$tafri_travel_shop_button_padding_left = get_theme_mod('tafri_travel_shop_button_padding_left', 16);
	$tafri_travel_custom_css .='.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce button.button:disabled, .woocommerce button.button:disabled[disabled]{';
		$tafri_travel_custom_css .='padding-left: '.esc_attr($tafri_travel_shop_button_padding_left).'px; padding-right: '.esc_attr($tafri_travel_shop_button_padding_left).'px;';
	$tafri_travel_custom_css .='}';

	$tafri_travel_shop_button_border_radius = get_theme_mod('tafri_travel_shop_button_border_radius', 0);
	$tafri_travel_custom_css .='.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt{';
		$tafri_travel_custom_css .='border-radius: '.esc_attr($tafri_travel_shop_button_border_radius).'px;';
	$tafri_travel_custom_css .='}';

	$tafri_travel_display_related_products = get_theme_mod('tafri_travel_display_related_products',true);
	if($tafri_travel_display_related_products == false){
		$tafri_travel_custom_css .='.related.products{';
			$tafri_travel_custom_css .='display: none;';
		$tafri_travel_custom_css .='}';
	}

	$tafri_travel_shop_products_border = get_theme_mod('tafri_travel_shop_products_border', true);
	if($tafri_travel_shop_products_border == false){
		$tafri_travel_custom_css .='.woocommerce .products li{';
			$tafri_travel_custom_css .='border: none;';
		$tafri_travel_custom_css .='}';
	}

	$tafri_travel_shop_page_top_padding = get_theme_mod('tafri_travel_shop_page_top_padding',0);
	$tafri_travel_custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
		$tafri_travel_custom_css .='padding-top: '.esc_attr($tafri_travel_shop_page_top_padding).'px !important; padding-bottom: '.esc_attr($tafri_travel_shop_page_top_padding).'px !important;';
	$tafri_travel_custom_css .='}';

	$tafri_travel_shop_page_left_padding = get_theme_mod('tafri_travel_shop_page_left_padding',0);
	$tafri_travel_custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
		$tafri_travel_custom_css .='padding-left: '.esc_attr($tafri_travel_shop_page_left_padding).'px !important; padding-right: '.esc_attr($tafri_travel_shop_page_left_padding).'px !important;';
	$tafri_travel_custom_css .='}';

	$tafri_travel_shop_page_border_radius = get_theme_mod('tafri_travel_shop_page_border_radius',0);
	$tafri_travel_custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
		$tafri_travel_custom_css .='border-radius: '.esc_attr($tafri_travel_shop_page_border_radius).'px;';
	$tafri_travel_custom_css .='}';

	$tafri_travel_shop_page_box_shadow = get_theme_mod('tafri_travel_shop_page_box_shadow',0);
	$tafri_travel_custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
		$tafri_travel_custom_css .='box-shadow: '.esc_attr($tafri_travel_shop_page_box_shadow).'px '.esc_attr($tafri_travel_shop_page_box_shadow).'px '.esc_attr($tafri_travel_shop_page_box_shadow).'px #e4e4e4;';
	$tafri_travel_custom_css .='}';

	$tafri_travel_border_radius_product_sale = get_theme_mod('tafri_travel_border_radius_product_sale',0);
	$tafri_travel_custom_css .='.woocommerce span.onsale {';
		$tafri_travel_custom_css .='border-radius: '.esc_attr($tafri_travel_border_radius_product_sale).'px;';
	$tafri_travel_custom_css .='}';

	$tafri_travel_align_product_sale = get_theme_mod('tafri_travel_align_product_sale', 'Right');
	if($tafri_travel_align_product_sale == 'Right' ){
		$tafri_travel_custom_css .='.woocommerce ul.products li.product .onsale{';
			$tafri_travel_custom_css .=' left:auto; right:0;';
		$tafri_travel_custom_css .='}';
	}elseif($tafri_travel_align_product_sale == 'Left' ){
		$tafri_travel_custom_css .='.woocommerce ul.products li.product .onsale{';
			$tafri_travel_custom_css .=' left:0; right:auto;';
		$tafri_travel_custom_css .='}';
	}

	$tafri_travel_top_bottom_product_sale_padding = get_theme_mod('tafri_travel_top_bottom_product_sale_padding');
	$tafri_travel_left_right_product_sale_padding = get_theme_mod('tafri_travel_left_right_product_sale_padding');
	$tafri_travel_custom_css .='.woocommerce span.onsale{';
		$tafri_travel_custom_css .='padding-top: '.esc_attr($tafri_travel_top_bottom_product_sale_padding).'px; padding-bottom: '.esc_attr($tafri_travel_top_bottom_product_sale_padding).'px; padding-left: '.esc_attr($tafri_travel_left_right_product_sale_padding).'px; padding-right: '.esc_attr($tafri_travel_left_right_product_sale_padding).'px; display:inline-block;';
	$tafri_travel_custom_css .='}';

	$tafri_travel_product_sale_font_size = get_theme_mod('tafri_travel_product_sale_font_size',14);
	$tafri_travel_custom_css .='.woocommerce span.onsale{';
		$tafri_travel_custom_css .='font-size: '.esc_attr($tafri_travel_product_sale_font_size).'px;';
	$tafri_travel_custom_css .='}';
	
	// featured image setting
	$tafri_travel_post_image_border_radius = get_theme_mod('tafri_travel_post_image_border_radius', 0);
	$tafri_travel_custom_css .='.our-services img, .page-box-single img, .middle-align img{';
		$tafri_travel_custom_css .='border-radius: '.esc_attr($tafri_travel_post_image_border_radius).'%;';
	$tafri_travel_custom_css .='}';

	$tafri_travel_featured_image_box_shadow = get_theme_mod('tafri_travel_featured_image_box_shadow',0);
	$tafri_travel_custom_css .='.our-services img, .page-box-single img, .middle-align img{';
		$tafri_travel_custom_css .='box-shadow: '.esc_attr($tafri_travel_featured_image_box_shadow).'px '.esc_attr($tafri_travel_featured_image_box_shadow).'px '.esc_attr($tafri_travel_featured_image_box_shadow).'px #eee;';
	$tafri_travel_custom_css .='}';

	// fixed header padding option
	$tafri_travel_fixed_header_padding_option = get_theme_mod('tafri_travel_fixed_header_padding_option', 0);
	$tafri_travel_custom_css .='.fixed-header{';
		$tafri_travel_custom_css .='padding: '.esc_attr($tafri_travel_fixed_header_padding_option).'px;';
	$tafri_travel_custom_css .='}';

	// Post Block
	$tafri_travel_post_break_block_setting = get_theme_mod( 'tafri_travel_post_break_block_setting','Into Blocks');
    if($tafri_travel_post_break_block_setting == 'Without Blocks'){
		$tafri_travel_custom_css .='.page-box{';
			$tafri_travel_custom_css .='box-shadow: none; margin:30px 0;';
		$tafri_travel_custom_css .='}';
	}

	// slider overlay
	$tafri_travel_show_slider_image_overlay = get_theme_mod('tafri_travel_show_slider_image_overlay', true);
	if($tafri_travel_show_slider_image_overlay == false){
		$tafri_travel_custom_css .='#slider img{';
			$tafri_travel_custom_css .='opacity:1;';
		$tafri_travel_custom_css .='}';
	} 
	$tafri_travel_color_slider_image_overlay = get_theme_mod('tafri_travel_color_slider_image_overlay', true);
	if($tafri_travel_show_slider_image_overlay != false){
		$tafri_travel_custom_css .='#slider{';
			$tafri_travel_custom_css .='background-color: '.esc_attr($tafri_travel_color_slider_image_overlay).';';
		$tafri_travel_custom_css .='}';
	}

	// comment settings
	$tafri_travel_comment_button_text = get_theme_mod('tafri_travel_comment_button_text', 'Post Comment');
	if($tafri_travel_comment_button_text == ''){
		$tafri_travel_custom_css .='#comments p.form-submit {';
			$tafri_travel_custom_css .='display: none;';
		$tafri_travel_custom_css .='}';
	}

	$tafri_travel_comment_form_heading = get_theme_mod('tafri_travel_comment_form_heading', 'Leave a Reply');
	if($tafri_travel_comment_form_heading == ''){
		$tafri_travel_custom_css .='#comments h2#reply-title {';
			$tafri_travel_custom_css .='display: none;';
		$tafri_travel_custom_css .='}';
	}

	$tafri_travel_comment_form_size = get_theme_mod( 'tafri_travel_comment_form_size',100);
	$tafri_travel_custom_css .='#comments textarea{';
		$tafri_travel_custom_css .='width: '.esc_attr($tafri_travel_comment_form_size).'%;';
	$tafri_travel_custom_css .='}';

	// social icons font size
	$tafri_travel_social_icons_font_size = get_theme_mod('tafri_travel_social_icons_font_size', 14);
	$tafri_travel_custom_css .='.social-icons i{';
		$tafri_travel_custom_css .='font-size: '.esc_attr($tafri_travel_social_icons_font_size).'px;';
	$tafri_travel_custom_css .='}';

	// search settings
	$tafri_travel_search_font_size = get_theme_mod('tafri_travel_search_font_size', 16);
	$tafri_travel_custom_css .='.search-body i{';
		$tafri_travel_custom_css .='font-size: '.esc_attr($tafri_travel_search_font_size).'px;';
	$tafri_travel_custom_css .='}';

	$tafri_travel_search_border_radius = get_theme_mod('tafri_travel_search_border_radius',0);
	$tafri_travel_custom_css .='.search-body i, .search-body button{';
		$tafri_travel_custom_css .='border-radius: '.esc_attr($tafri_travel_search_border_radius).'px;';
	$tafri_travel_custom_css .='}';

	$tafri_travel_search_padding = get_theme_mod('tafri_travel_search_padding', 15);
	$tafri_travel_custom_css .='.search-body i{';
		$tafri_travel_custom_css .='padding: '.esc_attr($tafri_travel_search_padding).'px;';
	$tafri_travel_custom_css .='}';

	// post image 
	$tafri_travel_blog_post_featured_color = get_theme_mod('tafri_travel_blog_post_featured_color', '#26bdf7');
	$tafri_travel_blog_post_featured_option = get_theme_mod('tafri_travel_blog_post_featured_option','Post Image');
	if($tafri_travel_blog_post_featured_option == 'Post Color'){
		$tafri_travel_custom_css .='.blog-post-color{';
			$tafri_travel_custom_css .='background-color: '.esc_attr($tafri_travel_blog_post_featured_color).';';
		$tafri_travel_custom_css .='}';
	}

	// featured image dimention
	$tafri_travel_post_image_dimention = get_theme_mod('tafri_travel_post_image_dimention', 'Default');
	$tafri_travel_post_featured_image_width = get_theme_mod('tafri_travel_post_featured_image_width');
	$tafri_travel_post_featured_image_height = get_theme_mod('tafri_travel_post_featured_image_height');
	if($tafri_travel_post_image_dimention == 'Custom Image Size'){
		$tafri_travel_custom_css .='.our-services img{';
			$tafri_travel_custom_css .='width: '.esc_attr($tafri_travel_post_featured_image_width).'px; height: '.esc_attr($tafri_travel_post_featured_image_height).'px;';
		$tafri_travel_custom_css .='}';
	}

	// featured image dimention
	$tafri_travel_color_post_width = get_theme_mod('tafri_travel_color_post_width');
	$tafri_travel_color_post_height = get_theme_mod('tafri_travel_color_post_height');
	if($tafri_travel_blog_post_featured_option == 'Post Color'){
		$tafri_travel_custom_css .='.blog-post-color{';
			$tafri_travel_custom_css .='width: '.esc_attr($tafri_travel_color_post_width).'px; height: '.esc_attr($tafri_travel_color_post_height).'px;';
		$tafri_travel_custom_css .='}';
	}

	/*---------- Slider display option ---------*/
	$tafri_travel_slider_display = get_theme_mod('tafri_travel_slider_display_option', 'Home page');
	if( get_theme_mod('tafri_travel_slider_hide') == true){
		if($tafri_travel_slider_display == 'Blog Page' || $tafri_travel_slider_display == 'Both Home page & Blog Page' ){
			$tafri_travel_custom_css .='.blog #header{';
				$tafri_travel_custom_css .=' position: absolute; width: 100%;z-index: 999; background: transparent;border: none;';
			$tafri_travel_custom_css .='}';
			$tafri_travel_custom_css .='.blog .top-header{';
				$tafri_travel_custom_css .=' border: none; background: rgba(15, 32, 54, 0.5);';
			$tafri_travel_custom_css .='}';
			$tafri_travel_custom_css .='.blog .top-header{';
				$tafri_travel_custom_css .='border-bottom: 1px solid #0f2036;';
			$tafri_travel_custom_css .='}';
			$tafri_travel_custom_css .='.blog #header hr{';
				$tafri_travel_custom_css .='margin: 0px; background: #b1b1b1;';
			$tafri_travel_custom_css .='}';
		}
	}
	if( get_theme_mod('tafri_travel_slider_hide') == false){
		$tafri_travel_custom_css .='.page-template-home-custom #header{';
			$tafri_travel_custom_css .=' position: static; background: #0f2036;';
		$tafri_travel_custom_css .='}';
	}
	if( $tafri_travel_slider_display == 'Blog Page'){
		$tafri_travel_custom_css .='.page-template-home-custom #header{';
			$tafri_travel_custom_css .=' position: static !important; background: #0f2036;';
		$tafri_travel_custom_css .='}';
		$tafri_travel_custom_css .='.page-template-home-custom .top-header{';
			$tafri_travel_custom_css .='border-bottom: 1px solid #26bdf7;';
		$tafri_travel_custom_css .='}';
		$tafri_travel_custom_css .='.page-template-home-custom #header hr{';
			$tafri_travel_custom_css .='margin: 0px; background: #b1b1b1;';
		$tafri_travel_custom_css .='}';
	}

	// header Type
	$tafri_travel_header_type = get_theme_mod( 'tafri_travel_header_type','With Transparent');
    if($tafri_travel_header_type == 'With Transparent'){
		$tafri_travel_custom_css .='.page-template-home-custom #header{';
			$tafri_travel_custom_css .='Position:absolute;';
		$tafri_travel_custom_css .='}';
	}else if($tafri_travel_header_type == 'Without Transparent'){
		$tafri_travel_custom_css .='.page-template-home-custom #header, .blog #header{';
			$tafri_travel_custom_css .='position: static !important; background: #0f2036;';
		$tafri_travel_custom_css .='}';
		$tafri_travel_custom_css .='.page-template-home-custom .top-header, .blog .top-header{';
			$tafri_travel_custom_css .='border-bottom: 1px solid #26bdf7;';
		$tafri_travel_custom_css .='}';
		$tafri_travel_custom_css .='.page-template-home-custom #header hr{';
			$tafri_travel_custom_css .='margin: 0px; background:#b1b1b1;';
		$tafri_travel_custom_css .='}';
	}

	// woocommerce Product Navigation
	$tafri_travel_shop_products_navigation = get_theme_mod('tafri_travel_shop_products_navigation', 'Yes');
	if($tafri_travel_shop_products_navigation == 'No'){
		$tafri_travel_custom_css .='.woocommerce nav.woocommerce-pagination{';
			$tafri_travel_custom_css .='display: none;';
		$tafri_travel_custom_css .='}';
	}

	// site title font size option
	$tafri_travel_site_title_font_size = get_theme_mod('tafri_travel_site_title_font_size');{
	$tafri_travel_custom_css .='.logo h1, .site-title a{';
		$tafri_travel_custom_css .='font-size: '.esc_attr($tafri_travel_site_title_font_size).'px;';
		$tafri_travel_custom_css .='}';
	}

	$tafri_travel_tagline_font_size = get_theme_mod('tafri_travel_tagline_font_size');{
	$tafri_travel_custom_css .='.logo p{';
		$tafri_travel_custom_css .='font-size: '.esc_attr($tafri_travel_tagline_font_size).'px;';
		$tafri_travel_custom_css .='}';
	}








