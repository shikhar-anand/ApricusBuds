<?php
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function olively_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'olively' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'olively' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		)
	);
	
	register_sidebar(
		array(
			'name'          => esc_html__( 'Post Sidebar', 'olively' ),
			'id'            => 'sidebar-single',
			'description'   => esc_html__( 'This is the sidebar for Post Page. Add widgets here.', 'olively' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		)
	);
	
	register_sidebar(
		array(
			'name'          => esc_html__( 'Page Sidebar', 'olively' ),
			'id'            => 'sidebar-page',
			'description'   => esc_html__( 'This is the sidebar for the Pages. Add widgets here.', 'olively' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		)
	);
	
	register_sidebar(
		array(
			'name'          => esc_html__( 'Before Footer', 'olively' ),
			'id'            => 'before-footer',
			'description'   => esc_html__( 'This is the sidebar to place content before Footer. Add widgets here.', 'olively' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		)
	);
	
	register_sidebar(
		array(
			'name'          => esc_html__( 'Before Content', 'olively' ),
			'id'            => 'before-content',
			'description'   => esc_html__( 'This is the sidebar for the Pages. Add widgets here.', 'olively' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s container">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		)
	);
	
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Sidebar 1', 'olively' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Footer Sidebar Column 1', 'olively' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Sidebar 2', 'olively' ),
			'id'            => 'footer-2',
			'description'   => esc_html__( 'Footer Sidebar Column 2', 'olively' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Sidebar 3', 'olively' ),
			'id'            => 'footer-3',
			'description'   => esc_html__( 'Footer Sidebar Column 3', 'olively' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Sidebar 4', 'olively' ),
			'id'            => 'footer-4',
			'description'   => esc_html__( 'Footer Sidebar Column 4', 'olively' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'olively_widgets_init' );