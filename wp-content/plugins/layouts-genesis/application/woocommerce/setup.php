<?php
class WPDDL_Integration_Woocommerce_Setup{

    private static $instance;

    protected function __construct()
    {
        $this->setup();
    }

    protected function setup(){
        if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )
            return;

        /** Ensure WooCommerce 2.0+ compatibility */
        add_theme_support( 'woocommerce' );

        /** Add Genesis Layout and SEO options to Product edit screen */
        add_post_type_support( 'product', array( 'genesis-seo', 'genesis-layouts' ) );
        add_filter('ddl-check_layout_template_for_woocommerce', array(&$this, 'check_layout_template_for_woocommerce'), 10, 2);

        WPDDL_Integration_Woocommerce_Template_Router::get_instance();
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new WPDDL_Integration_Woocommerce_Setup();
        }

        return self::$instance;
    }

    public function check_layout_template_for_woocommerce( $message, $found ){
        return '';
    }

}