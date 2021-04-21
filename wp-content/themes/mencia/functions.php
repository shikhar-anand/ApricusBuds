<?php

/*  -----------------------------------------------------------------------------------------------
  THEME SUPPORTS
  Default setup.
  --------------------------------------------------------------------------------------------------- */
  function mencia_theme_support() {
    // Automatic feed
    add_theme_support( 'automatic-feed-links' );

    // Custom background color
    add_theme_support( 'custom-background', array(
      'default-color' => 'FFFFFF'
    ) );

    // Set content-width
    global $content_width;
    if ( ! isset( $content_width ) ) {
      $content_width = 580;
    }

    // Post thumbnails
    add_theme_support( 'post-thumbnails' );

    // Set post thumbnail size
    $low_res_images = get_theme_mod( 'mencia_activate_low_resolution_images', false );
    if ( $low_res_images ) {
      set_post_thumbnail_size( 1120, 9999 );
    } else {
      set_post_thumbnail_size( 2240, 9999 );
    }

    // Add image sizes
    add_image_size( 'mencia_preview_image_low_resolution', 540, 9999 );
    add_image_size( 'mencia_preview_image_high_resolution', 1080, 9999 );
    add_image_size( 'mencia_fullscreen', 1980, 9999 );

    // Custom logo
    add_theme_support( 'custom-logo', 
      array(
      'height'      => 100,
      'width'       => 400,
      'flex-height' => true,
      'flex-width' => true,
    ) 
    );

    // Title tag
    add_theme_support( 'title-tag' );

    // HTML5 semantic markup
    add_theme_support( 'html5', array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
    ) );

    // Make the theme translation ready
    load_theme_textdomain( 'mencia' );

    // Alignwide and alignfull classes in the block editor
    add_theme_support( 'align-wide' );


  }
  add_action( 'after_setup_theme', 'mencia_theme_support' );



/*  -----------------------------------------------------------------------------------------------
  REGISTER STYLES & SCRIPTS
  Register and enqueue CSS & JavaScript
  --------------------------------------------------------------------------------------------------- */

  function mencia_main_scripts() {
    wp_enqueue_style( 'mencia_style', get_stylesheet_uri() );
    wp_enqueue_style('google-fonts', '//fonts.googleapis.com/css?family=Lora:400,700|Open+Sans:400,300,600,700,800', array());
    wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '1.1', 'all');
    wp_enqueue_style( 'font-awesome', get_stylesheet_directory_uri().'/assets/css/fontawesome/css/all.min.css' );

   
    wp_enqueue_script( 'mencia_main-script', get_template_directory_uri() . '/assets/js/mencia_main.js', array( 'jquery' ));
    wp_enqueue_script( 'mencia-index-script', get_template_directory_uri() . '/assets/js/index.js', array( 'jquery' ));
    wp_enqueue_script( 'mencia_clean-blog', get_template_directory_uri() . '/assets/js/mencia_clean-blog.js', array( 'jquery' ));
    wp_enqueue_script( 'bootstrap.bundle', get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js', array( 'jquery' ));

  
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
      wp_enqueue_script( 'comment-reply' );
    }
  }
  add_action( 'wp_enqueue_scripts', 'mencia_main_scripts' );


/* ---------------------------------------------------------------------------------------------
   EDITOR STYLES FOR THE CLASSIC EDITOR
   --------------------------------------------------------------------------------------------- */

function mencia_classic_editor_styles() {
  $classic_editor_styles = array(
    '/assets/css/editor-style-classic.css',
  );
  add_editor_style( $classic_editor_styles );
}
add_action( 'init', 'mencia_classic_editor_styles' );


/*  -----------------------------------------------------------------------------------------------
  MENUS
  Register navigational menus (wp_nav_menu)
  --------------------------------------------------------------------------------------------------- */

  function mencia_menus() {
    register_nav_menus(
      array(
        'primary' => __( 'Menu Above', 'mencia' ), 
      )
    );
  }
  add_action( 'init', 'mencia_menus' );


/* ------------------------------------------------------------------------------------------------
   REGISTER THEME WIDGETS
   --------------------------------------------------------------------------------------------------- */

   function mencia_widgets_mencia() {
    register_sidebar( array(
      'name'          => esc_html__( 'widget foot', 'mencia' ),
      'id'            => 'widgetsfoot',
      'description'   => esc_html__( 'Add widgets here.', 'mencia' ),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
    ) );
  }
  add_action( 'widgets_init', 'mencia_widgets_mencia' );



/*  -----------------------------------------------------------------------------------------------
  EXCERPT
  --------------------------------------------------------------------------------------------------- */

  function mencia_custom_length_excerpt($word_count_limit) {
    $content = wp_strip_all_tags(get_the_excerpt() , true );
    echo wp_trim_words($content, $word_count_limit);
  }
  add_filter('mencia_custom_length_excerpt', 'mencia_custom_length_excerpt');
  
  function mencia_new_excerpt_more( $more ) {
    if ( is_admin() ) return $more;
  }
  add_filter('excerpt_more', 'mencia_new_excerpt_more');


/*  -----------------------------------------------------------------------------------------------
  OPEN BODY
  --------------------------------------------------------------------------------------------------- */

  if ( ! function_exists( 'wp_body_open' ) ) {
        function wp_body_open() {
                do_action( 'wp_body_open' );
          }
  }


?>