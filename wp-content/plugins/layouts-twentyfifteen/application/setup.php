<?php

/**
 * Singleton for setting up the integration.
 *
 * Note that it doesn't have to have unique name. Because of autoloading, it will be loaded only once (when this
 * integration plugin is operational).
 *
 */
/** @noinspection PhpUndefinedClassInspection */
class WPDDL_Integration_Setup extends WPDDL_Theme_Integration_Setup_Abstract {

    
        private $row_count = 0;
    
	/**
	 * Run Integration.
	 *
	 * @return bool|WP_Error True when the integration was successful or a WP_Error with a sensible message
	 *     (which can be displayed to the user directly).
	 */
	public function run() {
	    $this-> set_layouts_path( dirname( dirname(__FILE__) ) . DIRECTORY_SEPARATOR . 'public/layouts/' );
            $this->addCustomRowModes();
            return parent::run();
            
            
            /**
            *
            * TODO: uncomment these lines if you want to overwrite 
            * parent class default template settings
            * 
            * $parent = parent::run();
            * $this->setPageDefaultTemplate( 'template-new-default.php' );
            * return $parent;
            *
            **/


            /**
            * TODO: if you want to add custom shortcode field button to Views Insert field dialog
            * 
            * $this->add_shortcodes();
            * $parent = parent::run();
            * return $parent;
            *
            **/
            
	}


	/**
	 * @return string
	 */
	protected function get_supported_theme_version() {
		return '1.0';
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
	 */
	protected function get_supported_templates() {
		return array(
			'template-page.php' => __( 'Template page', 'ddl-layouts' ),
			'single-page.php'   => __( 'Single page', 'ddl-layouts' )
		);
	}
        
        


	/**
	 * Layouts Support
	 *
	 *     - if theme has it's own loop, replace it by the_ddlayout()
	 *     - remove headers, footer, sidebars, menus and such, if achievable by filters
	 *     - otherwise you will have to resort to something like redirecting templates (see the template router below)
	 *     - add $this->clear_content() to some filters to remove unwanted site structure elements
	 */
	protected function add_layouts_support() {

		parent::add_layouts_support();

		/** @noinspection PhpUndefinedClassInspection */
		WPDDL_Integration_Theme_Template_Router::get_instance();

		register_sidebar( array(
			'name' => __( 'Header Widget Area', 'twentyfifteen' ),
			'id' => 'sidebar-header',
			'description' => __( 'Add widgets here to appear in your header sidebar area.', 'twentyfifteen' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		) );

		$this->register_custom_widgets();
	}


	/**
	 * Late registration of custom widgets.
	 *
	 * Because Theme integration API initializes way too late to register widgets, and there is no way around it,
	 * we need to force our widgets into WP core in a hacky way. We will manually update the array of widgets
	 * within $wp_widget_factory but preserve the already registered ones.
	 */
    public function register_custom_widgets() {

	    // This will add widgets to $wp_registered_widgets global.
	    register_widget( 'WPDDL_Integration_Theme_Widgets_sitetitle' );
	    register_widget( 'WPDDL_Integration_Theme_Widgets_primarymenu' );
	    register_widget( 'WPDDL_Integration_Theme_Widgets_socialmenu' );

	    // Now we need to do exactly what $wp_widget_factory->_register_widgets() would do
	    // EXCEPT unsetting widgets that are already registered.
	    global $wp_registered_widgets, $wp_widget_factory;
	    $keys = array_keys( $wp_widget_factory->widgets );
	    $registered = array_keys( $wp_registered_widgets );
	    $registered = array_map( '_get_widget_id_base', $registered );

	    foreach ( $keys as $key ) {
		    // don't register new widget if old widget with the same id is already registered
		    if ( in_array( $wp_widget_factory->widgets[ $key ]->id_base, $registered, true ) ) {
			    // NO UNSET HERE
			    continue;
		    }

		    /** @noinspection PhpUndefinedMethodInspection */
		    $wp_widget_factory->widgets[ $key ]->_register();
	    }
    }


	/**
	 * Add custom theme elements to Layouts.
	 *
	 */
	protected function add_layouts_cells() {

		$entry_meta_cell = new WPDDL_Integration_Layouts_Cell_Entry_Meta();
		$entry_meta_cell->setup();
                
                $post_navigation = new WPDDL_Integration_Layouts_Cell_Post_Navigation();
		$post_navigation->setup();

	}
        
        
        public function add_shortcodes() {
            // 
            /* post-template exapmle
            $post_content = new WPDDL_Integration_Theme_Shortcode_Post_Template();
            $post_content->setup();
            */
            return $this;
        }


	/**
	 * This method can be used to remove all theme settings which are obsolete with the use of Layouts
	 * i.e. "Default Layout" in "Theme Settings"
	 *
	 */
	protected function modify_theme_settings() {
		// ...
	}
        
        /**
	 * Add custom row modes.
	 */
	private function addCustomRowModes() {
		add_filter( 'ddl-get_rows_modes_gui_list', array($this, 'add_twentyfifteen_header_row_mode' ));
		add_filter('ddl_render_row_start', array($this, 'twentyfifteen_custom_row_open'), 98, 2);
		add_filter('ddl_render_row_end', array($this, 'twentyfifteen_custom_row_close'), 98, 3);
	}
        
        /**
	 * Header Row Mode
	 */
	public function add_twentyfifteen_header_row_mode($lists_html) {
		ob_start(); ?>
		<li>
                    <figure class="row-type">
                            <img class="item-preview" data-name="row_twenty_fifteen_content" src="<?php echo WPDDL_GUI_RELPATH; ?>dialogs/img/tn-boxed.png" alt="<?php _e('Twenty Fifteen content row', 'ddl-layouts'); ?>">
                            <span><?php _e('Twenty Fifteen content row', 'ddl-layouts'); ?></span>
                    </figure>
                    <label class="radio" data-target="row_twenty_fifteen_content" for="row_twenty_fifteen_content" style="display:none">
                            <input type="radio" name="row_type" id="row_twenty_fifteen_content" value="twenty_fifteen_content">
                            <?php _e('Twenty Fifteen content row', 'ddl-layouts'); ?>
                    </label>
		</li>

		<style type="text/css">
			.presets-list li{width:25%!important;}
		</style>
		<?php
		$lists_html .= ob_get_clean();

		return $lists_html;
	}

	public function twentyfifteen_custom_row_open($markup, $args) {
            if( $args['mode'] === 'twenty_fifteen_content' ){
                ob_start();?>
                <div class="row post type-post format-standard hentry <?php echo ($args['additionalCssClasses']) ? $args['additionalCssClasses']:'';?>" <?php echo ($args['cssId']) ? 'id="'.$args['cssId'].'"' : '';?>>
                    <div class="entry-content">
                <?php
                $markup = ob_get_clean();
            }

            return $markup;
	}

	public function twentyfifteen_custom_row_close($output, $mode, $tag) {
            if( $mode === 'twenty_fifteen_content' ) {
                ob_start(); ?>
                    </div>
                </div>
                <?php
                $output = ob_get_clean();
            }

            return $output;
	}

        
}
