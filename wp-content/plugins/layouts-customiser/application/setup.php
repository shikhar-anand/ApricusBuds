<?php
/**
 * Singleton for setting up the integration.
 *
 * Note that it doesn't have to have unique name. Because of autoloading, it will be loaded only once (when this
 * integration plugin is operational).
 *
 * @todo Take look at the parent class, explore it's code and figure out if anything needs overriding.
 */
/** @noinspection PhpUndefinedClassInspection */
class WPDDL_Integration_Setup extends WPDDL_Theme_Integration_Setup_Abstract {

    /**
     * Run Integration.
     *
     * @return bool|WP_Error True when the integration was successful or a WP_Error with a sensible message
     *     (which can be displayed to the user directly).
     */
    public function run() {
	    $this->set_layouts_path( dirname( dirname( __FILE__) ) . DIRECTORY_SEPARATOR . 'public/layouts' );
            $this->addCustomRowModes();
            return parent::run();
    }


    /**
     * @todo Set supported theme version here.
     * @return string
     */
    protected function get_supported_theme_version() {
            return '';
    }


    /**
     * Build URL of an resource from path relative to plugin's root directory.
     *
     * @param string $relative_path Some path relative to the plugin's root directory.
     * @return string URL of the given path.
     */
    protected function get_plugins_url( $relative_path ) {
            return plugins_url( '/../' . $relative_path , __FILE__ );
    }


    /**
     * Get list of templates supported by Layouts with this theme.
     *
     * @return array Associative array with template file names as keys and theme names as values.
     * @todo Update the array of templates according to what the integration plugin offers
     */
    protected function get_supported_templates() {
            return array(
                    'template-page.php' => __( 'Template page', 'ddl-layouts' )
            );
    }


    /**
     * Layouts Support
     *
     * @todo Implement theme-specific logic here. For example, you may want to:
     *     - if theme has it's own loop, replace it by the_ddlayout()
     *     - remove headers, footer, sidebars, menus and such, if achievable by filters
     *     - otherwise you will have to resort to something like redirecting templates (see the template router below)
     *     - add $this->clear_content() to some filters to remove unwanted site structure elements
     */
    protected function add_layouts_support() {

            parent::add_layouts_support();

            /** @noinspection PhpUndefinedClassInspection */
            WPDDL_Integration_Theme_Template_Router::get_instance();

            // remove sidebars
            if (class_exists('TC_sidebar')) {
                remove_action ( 'wp', array( TC_sidebar::$instance , 'tc_set_sidebar_hooks' ) );
            }

            // For some reason it is necessary to hook up wp_head and init, and then remove actions
            add_action('wp_head', array(&$this, 'customizr_remove_actions_wp_head'), 10, 2);
            // remove unnecassary classes from logo
            add_filter( 'tc_logo_class', array( $this, 'clear_tc_logo_class' ) );
            // remove classess from tagline
            add_filter( 'tc_tagline_class', array( $this, 'remove_tagline_class' ));
            // replace span with col-sm in featured pages output
            add_filter('tc_fp_block_display',array( $this, 'replace_span_with_cols' ));



            add_action( 'customize_register', array( $this, 'customizr_customize_register' ),100 );
            add_action('admin_head', array( $this, 'customizr_remove_metaboxes' ),99);


    }
    
    public function remove_tagline_class($class){
        return'';
    }
    
    public function replace_span_with_cols($html){
        return str_replace('class="span','class="col-sm-',$html);
    }

    public function customizr_remove_metaboxes(){
        remove_meta_box('layout_sectionid','post','side');
	remove_meta_box('layout_sectionid','page','side');
    }
        

    function customizr_customize_register( $wp_customize ) {
            // section frontpage_sec
            $wp_customize->remove_control('show_on_front');
            $wp_customize->remove_control('page_on_front');
            $wp_customize->remove_control('page_for_posts');
            $wp_customize->remove_control('homecontent_title');
            $wp_customize->remove_control('tc_theme_options[tc_blog_restrict_by_cat]');
            
            // remove sidebar options
            $wp_customize->remove_control('tc_theme_options[tc_sidebar_post_layout]');
            $wp_customize->remove_control('tc_theme_options[tc_sidebar_force_layout]');
            $wp_customize->remove_control('tc_theme_options[tc_sidebar_global_layout]');
            $wp_customize->remove_control('tc_theme_options[tc_sidebar_page_layout]');
            
            // remove some header options
            $wp_customize->remove_control('tc_theme_options[tc_header_layout]');
            $wp_customize->remove_control('tc_theme_options[tc_show_tagline]');
            $wp_customize->remove_control('tc_theme_options[tc_social_in_header]');
            $wp_customize->remove_control('tc_theme_options[tc_front_layout]');
            
            
            // Remove entire sections
            $wp_customize->remove_section('post_lists_sec');
            $wp_customize->remove_section('single_posts_sec');
            $wp_customize->remove_section('breadcrumb_sec');
            $wp_customize->remove_section('post_metas_sec');
            $wp_customize->remove_section('comments_sec');
            $wp_customize->remove_section('post_navigation_sec');
            $wp_customize->remove_section('post_lists_sec');
            $wp_customize->remove_section('post_lists_sec');
            $wp_customize->remove_section('post_lists_sec');
            $wp_customize->remove_section('post_lists_sec');
            
            $wp_customize->remove_section('titles_icons_sec');
            $wp_customize->remove_section('authors_sec');
            $wp_customize->remove_section('sidebar_socials_sec');
            
            $wp_customize->remove_panel('tc-footer-panel');
            
            
            return $wp_customize;
        }
        
        
        public function clear_tc_logo_class( $logo_classes ) {
            if( is_array( $logo_classes ) ) {
                $logo_classes = array_diff( $logo_classes, array( 'span3' ) );
            }
            return $logo_classes;
         }
         
        
        public function customizr_remove_slider_options($default_options){
            unset($default_options['tc_front_slider']);
            return $default_options;
        }
        
        public function customizr_remove_actions_wp_head() {
            if (class_exists('TC_comments')) {
                remove_action('__after_loop', array(TC_comments::$instance, 'tc_comments'), 10);
            }
            if (class_exists('TC_post_navigation')) {
                remove_action('__after_loop', array(TC_post_navigation::$instance, 'tc_post_nav'), 20);
            }
            if (class_exists('TC_breadcrumb')) {
                remove_action( '__before_main_container', array( TC_breadcrumb::$instance , 'tc_breadcrumb_display' ), 20 );
            }
            if (class_exists('TC_featured_pages')) {
                remove_action( '__before_main_container', array( TC_featured_pages::$instance , 'tc_fp_block_display'), 10 );
            }
            if (class_exists('TC_slider')) {
                remove_action( '__after_header', array( TC_slider::$instance , 'tc_slider_display'), 10 );
            }
            
            // remove social icons class
            if(class_exists('TC_menu')){
                remove_filter( 'tc_social_header_block_class'  , array( TC_menu::$instance, 'tc_set_social_header_class') );
            }
            
            // Remove filters and actions from header bar
            if (class_exists('TC_header_main')) {
                remove_filter( 'tc_logo_class', array( TC_header_main::$instance, 'tc_set_logo_title_layout'),10);

                
                if (is_rtl()) {
                    remove_action ( '__navbar', array( TC_header_main::$instance , 'tc_social_in_header' ) , 20, 2 );
                    remove_action ( '__navbar', array( TC_header_main::$instance , 'tc_tagline_display' ) , 10, 1 );
                } else {
                    remove_action ( '__navbar', array( TC_header_main::$instance , 'tc_social_in_header' ) , 10, 2 );
                    remove_action ( '__navbar', array( TC_header_main::$instance , 'tc_tagline_display' ) , 20, 1 );
                }
            }

        }
        
        /**
	 * Add custom row modes.
	 */
	private function addCustomRowModes() {
		add_filter( 'ddl-get_rows_modes_gui_list', array($this, 'add_customizr_header_row_mode' ));
		add_filter('ddl_render_row_start', array($this, 'customizr_custom_row_open'), 99, 2);
		add_filter('ddl_render_row_end', array($this, 'customizr_custom_row_close'), 99, 3);
	}

	/**
	 * Header Row Mode
	 */
	public function add_customizr_header_row_mode($lists_html) {
		ob_start(); ?>
		<li>
			<figure class="row-type">
				<img class="item-preview" data-name="row_customizr_header" src="<?php echo WPDDL_GUI_RELPATH; ?>dialogs/img/tn-boxed.png" alt="<?php _e('Customizr header', 'ddl-layouts'); ?>">
				<span><?php _e('Customizr header row', 'ddl-layouts'); ?></span>
			</figure>
			<label class="radio" data-target="row_customizr_header" for="row_customizr_header" style="display:none">
				<input type="radio" name="row_type" id="row_customizr_header" value="customizr_header">
				<?php _e('Customizr header', 'ddl-layouts'); ?>
			</label>
		</li>

		<style type="text/css">
			.presets-list li{width:25%!important;}
		</style>
		<?php
		$lists_html .= ob_get_clean();

		return $lists_html;
	}

	public function customizr_custom_row_open($markup, $args) {
            
            if( $args['mode'] === 'customizr_header' ){
                ob_start();?>
                <header class="<?php echo implode( " ", apply_filters('tc_header_classes', array('tc-header' ,'clearfix', 'row-fluid') ) ) ?>" role="banner">
                <?php
                $markup = ob_get_clean();
            }

            return $markup;
	}

	public function customizr_custom_row_close($output, $mode, $tag) {
            
            if( $mode === 'customizr_header' ) {
                ob_start(); ?>
                </header>
                <?php
                $output = ob_get_clean();
            }

            return $output;
	}


	/**
	 * Add custom theme elements to Layouts.
	 *
	 * @todo Setup your custom layouts cell here.
	 */
	protected function add_layouts_cells() {

		$left_sidebar_cell = new WPDDL_Integration_Layouts_Cell_Left_Sidebar();
		$left_sidebar_cell->setup();
                
                $right_sidebar_cell = new WPDDL_Integration_Layouts_Cell_Right_Sidebar();
		$right_sidebar_cell->setup();
                
                $footer_widgets_cell = new WPDDL_Integration_Layouts_Cell_Footer_Widgets();
		$footer_widgets_cell->setup();
                
                $slider_cell = new WPDDL_Integration_Layouts_Cell_Slider();
		$slider_cell->setup();
                
                $featured_pages_cell = new WPDDL_Integration_Layouts_Cell_Featured_Posts();
		$featured_pages_cell->setup();
                
                $breadcrumb_cell = new WPDDL_Integration_Layouts_Cell_Breadcrumb();
		$breadcrumb_cell->setup();
               
                $logo_cell = new WPDDL_Integration_Layouts_Cell_Logo();
		$logo_cell->setup();

                $tagline_cell = new WPDDL_Integration_Layouts_Cell_Tagline();
		$tagline_cell->setup();
                
                $header_navbar_cell = new WPDDL_Integration_Layouts_Cell_Navbar();
		$header_navbar_cell->setup();
                
                $header_social_icons = new WPDDL_Integration_Layouts_Cell_Social_Icons();
		$header_social_icons->setup();
                
                $post_navigation = new WPDDL_Integration_Layouts_Cell_Post_Navigation();
		$post_navigation->setup();
                
	}


	/**
	 * This method can be used to remove all theme settings which are obsolete with the use of Layouts
	 * i.e. "Default Layout" in "Theme Settings"
	 *
	 * @todo You can either use this class for very simple tasks or create dedicated classes in application/theme/settings.
	 */
	protected function modify_theme_settings() {
            // remove slider option if slider not enabled for the page
            add_filter('tc_generates_featured_pages',array(&$this, 'customizr_remove_slider_options'));
	}


}