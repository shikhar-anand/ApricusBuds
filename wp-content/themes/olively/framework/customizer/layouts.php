<?php
/**
 *	Customizer Controls for Sidebar
**/

function olively_sidebr_customize_register( $wp_customize ) {
	
	$wp_customize->add_panel(
		"olively_layouts_panel", array(
			"title"			=>	esc_html__("Layouts", "olively"),
			"description"	=>	esc_html__("Layout Settings for the Theme", "olively"),
			"priority"		=>	20
		)
	);
	
	$wp_customize->add_section(
		"olively_blog", array(
			"title"			=>	esc_html__("Blog Page", "olively"),
			"description"	=>	esc_html__("Control the Layout Settings for the Blog Page", "olively"),
			"priority"		=>	10,
			"panel"			=>	"olively_layouts_panel"
		)
	);
	
	$wp_customize->add_setting(
		"olively_blog_layout", array(
			"default"	=> "card-2",
			"sanitize_callback"	=>	"olively_sanitize_select"
		)
	);
	
	$wp_customize->add_control(
		"olively_blog_layout", array(
			"label"	=>	__("Blog Layout", "olively"),
			"type"	=>	"select",
			"section"	=>	"olively_blog",
			"priority"	=>	3,
			"choices"	=>	array(
				"blog"		=>	__("Blog Layout", "olively"),
				"list"		=>	__("List Layout", "olively"),
				"card-2"	=>	__("Card Layout - 2 Columns", "olively"),
				"card-3"	=>	__("Card Layout - 3 Columns", "olively")
			)
		)
	);
	
	$wp_customize->add_setting(
		"olively_blog_sidebar_enable", array(
			"default"			=>	1,
			"sanitize_callback"	=>	"olively_sanitize_checkbox"
		)
	);
	
	$wp_customize->add_control(
		"olively_blog_sidebar_enable", array(
			"label"		=>	__("Enable Sidebar for Blog Page.", "olively"),
			"type"		=>	"checkbox",
			"section"	=>	"olively_blog",
			"priority"	=>	5
		)
	);
	
	
	
	$wp_customize->add_setting(
     "olively_blog_sidebar_layout", array(
       "default"  => "right",
       "sanitize_callback"  => "olively_sanitize_radio",
     )
   );
   
   $wp_customize->add_control(
	   new Olively_Image_Radio_Control(
		   $wp_customize, "olively_blog_sidebar_layout", array(
			   "label"		=>	__("Blog Layout", "olively"),
			   "type"		=>	"olively-image-radio",
			   "section"	=> "olively_blog",
			   "settings"	=> "olively_blog_sidebar_layout",
			   "priority"	=> 10,
			   "choices"	=>	array(
					"left"		=>	array(
						"name"	=>	__("Left Sidebar", "olively"),
						"image"	=>	esc_url(get_template_directory_uri() . "/assets/images/left-sidebar.png")
					),
					"right"		=>	array(
						"name"	=>	__("Right Sidebar", "olively"),
						"image"	=>	esc_url(get_template_directory_uri() . "/assets/images/right-sidebar.png")
					)   
			   )
		   )
	   )
   );
   
    $sidebar_controls = array_filter( array(
        $wp_customize->get_control( 'olively_blog_sidebar_layout' ),
    ) );
    foreach ( $sidebar_controls as $control ) {
        $control->active_callback = function( $control ) {
            $setting = $control->manager->get_setting( 'olively_blog_sidebar_enable' );
            if (  $setting->value() ) {
                return true;
            } else {
                return false;
            }
        };
    }
	
	$wp_customize->add_section(
		"olively_single", array(
			"title"			=>	esc_html__("Single Post", "olively"),
			"description"	=>	esc_html__("Control the Layout Settings for the Single Post Page", "olively"),
			"priority"		=>	20,
			"panel"			=>	"olively_layouts_panel"
		)
	);
	
	$wp_customize->add_setting(
		"olively_single_sidebar_enable", array(
			"default"			=>	1,
			"sanitize_callback"	=>	"olively_sanitize_checkbox"
		)
	);
	
	$wp_customize->add_control(
		"olively_single_sidebar_enable", array(
			"label"		=>	__("Enable Sidebar for Posts", "olively"),
			"type"		=>	"checkbox",
			"section"	=>	"olively_single",
			"priority"	=>	5
		)
	);
	
	$wp_customize->add_setting(
		'olively_single_meta_enable', array(
			'default'	=>	1,
			'sanitize_callback'	=>	'olively_sanitize_checkbox'
		)
	);
	
	$wp_customize->add_control(
		'olively_single_meta_enable', array(
			'label'		=>	__('Enable Post Meta', 'olively'),
			'type'		=>	'checkbox',
			'section'	=>	'olively_single',
			'priority'	=>	6
		)
	);
	
	$wp_customize->add_setting(
     "olively_single_sidebar_layout", array(
       "default"  => "right",
       "sanitize_callback"  => "olively_sanitize_radio",
     )
   );
   
   $wp_customize->add_control(
	   new Olively_Image_Radio_Control(
		   $wp_customize, "olively_single_sidebar_layout", array(
			   "label"		=>	__("Single Post Layout", "olively"),
			   "type"		=>	"olively-image-radio",
			   "section"	=> "olively_single",
			   "Settings"	=> "olively_single_sidebar_layout",
			   "priority"	=> 10,
			   "choices"	=>	array(
					"left"		=>	array(
						"name"	=>	__("Left Sidebar", "olively"),
						"image"	=>	esc_url(get_template_directory_uri() . "/assets/images/left-sidebar.png")
					),
					"right"		=>	array(
						"name"	=>	__("Right Sidebar", "olively"),
						"image"	=>	esc_url(get_template_directory_uri() . "/assets/images/right-sidebar.png")
					)   
			   )
		   )
	   )
   );
   
   $sidebar_controls = array_filter( array(
        $wp_customize->get_control( 'olively_single_sidebar_layout' ),
    ) );
    foreach ( $sidebar_controls as $control ) {
        $control->active_callback = function( $control ) {
            $setting = $control->manager->get_setting( 'olively_single_sidebar_enable' );
            if (  $setting->value() ) {
                return true;
            } else {
                return false;
            }
        };
    }
   
   $wp_customize->add_setting(
		"olively_single_navigation_enable", array(
			"default"			=>	1,
			"sanitize_callback"	=>	"olively_sanitize_checkbox"
		)
	);
	
	$wp_customize->add_control(
		"olively_single_navigation_enable", array(
			"label"		=>	__("Enable Post Navigation", "olively"),
			"type"		=>	"checkbox",
			"section"	=>	"olively_single",
			"priority"	=>	15
		)
	);
	
	$wp_customize->add_setting(
		"olively_single_related_enable", array(
			"default"			=>	1,
			"sanitize_callback"	=>	"olively_sanitize_checkbox"
		)
	);
	
	$wp_customize->add_control(
		"olively_single_related_enable", array(
			"label"		=>	__("Enable Related Posts Section", "olively"),
			"type"		=>	"checkbox",
			"section"	=>	"olively_single",
			"priority"	=>	20
		)
	);
	
	$wp_customize->add_section(
		"olively_search", array(
			"title"			=>	__("Search Page", "olively"),
			"description"	=>	__("Layout Settings for the Search Page", "olively"),
			"priority"		=>	30,
			"panel"			=>	"olively_layouts_panel"
		)
	);
	
	$wp_customize->add_setting(
		"olively_search_layout", array(
			"default"	=> "card",
			"sanitize_callback"	=>	"olively_sanitize_select"
		)
	);
	
	$wp_customize->add_control(
		"olively_search_layout", array(
			"label"	=>	__("Blog Layout", "olively"),
			"type"	=>	"select",
			"section"	=>	"olively_search",
			"priority"	=>	3,
			"choices"	=>	array(
				"blog"		=>	__("Blog Layout", "olively"),
				"list"		=>	__("List Layout", "olively"),
				"card"		=>	__("Card Layout", "olively")
			)
		)
	);
	
	$wp_customize->add_setting(
		"olively_search_sidebar_enable", array(
			"default"			=>	1,
			"sanitize_callback"	=>	"olively_sanitize_checkbox"
		)
	);
	
	$wp_customize->add_control(
		"olively_search_sidebar_enable", array(
			"label"		=>	__("Enable Sidebar for Search Page", "olively"),
			"type"		=>	"checkbox",
			"section"	=>	"olively_search",
			"priority"	=>	5
		)
	);
	
	$wp_customize->add_setting(
     "olively_search_sidebar_layout", array(
       "default"  => "right",
       "sanitize_callback"  => "olively_sanitize_radio",
     )
   );
   
   $wp_customize->add_control(
	   new Olively_Image_Radio_Control(
		   $wp_customize, "olively_search_sidebar_layout", array(
			   "label"		=>	__("Arc Page Layout", "olively"),
			   "type"		=>	"olively-image-radio",
			   "section"	=> "olively_search",
			   "Settings"	=> "olively_search_sidebar_layout",
			   "priority"	=> 10,
			   "choices"	=>	array(
					"left"		=>	array(
						"name"	=>	__("Left Sidebar", "olively"),
						"image"	=>	esc_url(get_template_directory_uri() . "/assets/images/left-sidebar.png")
					),
					"right"		=>	array(
						"name"	=>	__("Right Sidebar", "olively"),
						"image"	=>	esc_url(get_template_directory_uri() . "/assets/images/right-sidebar.png")
					)   
			   )
		   )
	   )
   );
   
   $sidebar_controls = array_filter( array(
        $wp_customize->get_control( 'olively_search_sidebar_layout' ),
    ) );
    foreach ( $sidebar_controls as $control ) {
        $control->active_callback = function( $control ) {
            $setting = $control->manager->get_setting( 'olively_search_sidebar_enable' );
            if (  $setting->value() ) {
                return true;
            } else {
                return false;
            }
        };
    }
   
   $wp_customize->add_section(
		"olively_archive", array(
			"title"			=>	__("archives", "olively"),
			"description"	=>	__("Layout Settings for the Archives", "olively"),
			"priority"		=>	40,
			"panel"			=>	"olively_layouts_panel"
		)
	);
	
	$wp_customize->add_setting(
		"olively_archive_layout", array(
			"default"	=> "card",
			"sanitize_callback"	=>	"olively_sanitize_select"
		)
	);
	
	$wp_customize->add_control(
		"olively_archive_layout", array(
			"label"	=>	__("Archive Layout", "olively"),
			"type"	=>	"select",
			"section"	=>	"olively_archive",
			"priority"	=>	3,
			"choices"	=>	array(
				"blog"		=>	__("Blog Layout", "olively"),
				"list"		=>	__("List Layout", "olively"),
				"card"		=>	__("Card Layout", "olively")
			)
		)
	);
	
	$wp_customize->add_setting(
		"olively_archive_sidebar_enable", array(
			"default"			=>	1,
			"sanitize_callback"	=>	"olively_sanitize_checkbox"
		)
	);
	
	$wp_customize->add_control(
		"olively_archive_sidebar_enable", array(
			"label"		=>	__("Enable Sidebar for Archives", "olively"),
			"type"		=>	"checkbox",
			"section"	=>	"olively_archive",
			"priority"	=>	5
		)
	);
	
	$wp_customize->add_setting(
     "olively_archive_sidebar_layout", array(
       "default"  => "right",
       "sanitize_callback"  => "olively_sanitize_radio",
     )
   );
   
   $wp_customize->add_control(
	   new Olively_Image_Radio_Control(
		   $wp_customize, "olively_archive_sidebar_layout", array(
			   "label"		=>	__("Archives Layout", "olively"),
			   "type"		=>	"olively-image-radio",
			   "section"	=> "olively_archive",
			   "Settings"	=> "olively_archive_sidebar_layout",
			   "priority"	=> 10,
			   "choices"	=>	array(
					"left"		=>	array(
						"name"	=>	__("Left Sidebar", "olively"),
						"image"	=>	esc_url(get_template_directory_uri() . "/assets/images/left-sidebar.png")
					),
					"right"		=>	array(
						"name"	=>	__("Right Sidebar", "olively"),
						"image"	=>	esc_url(get_template_directory_uri() . "/assets/images/right-sidebar.png")
					)   
			   )
		   )
	   )
   );
   
   $sidebar_controls = array_filter( array(
        $wp_customize->get_control( 'olively_search_sidebar_layout' ),
    ) );
    foreach ( $sidebar_controls as $control ) {
        $control->active_callback = function( $control ) {
            $setting = $control->manager->get_setting( 'olively_search_sidebar_enable' );
            if (  $setting->value() ) {
                return true;
            } else {
                return false;
            }
        };
    }
}
add_action("customize_register", "olively_sidebr_customize_register");