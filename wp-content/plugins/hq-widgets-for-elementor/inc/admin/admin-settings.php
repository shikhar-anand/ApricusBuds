<?php

namespace HQWidgetsForElementor\Admin;

defined('ABSPATH') || exit;

use HQWidgetsForElementor\Widget\Widgets_Control;
use const HQWidgetsForElementor\PLUGIN_NAME;
use const HQWidgetsForElementor\PLUGIN_URL;
use const HQWidgetsForElementor\VERSION;
use const HQLib\THEME_SITE_URL;

class Admin_Settings {

    const PAGE_ID = 'hq-elementor-widgets';
    const TAB_CORE_WIDGETS = 'core_widgets';
    const TAB_THIRD_PARTY_WIDGETS = 'third_party_widgets';
    const TAB_ELEMENTOR_EXTEND = 'elementor_extend';

    /**
     * Plugin Instance
     * @var Admin_Settings 
     */
    private static $_instance = null;

    /**
     * Get class instance
     *
     * @since 1.0.0
     *
     * @return Admin_Settings
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct() {
        add_filter('hqt/update/widget/options', [$this, 'add_pro_widgets'], 10, 2);
        add_action('admin_init', [$this, 'admin_init']);
        add_action('admin_menu', [$this, 'admin_menu'], 201);
        // Admin thank you footer
        add_filter('admin_footer_text', [\HQLib\HQLib::instance(), 'admin_footer_text']);

        // Widgets container top buttons
        add_action('hqt/container/' . self::TAB_CORE_WIDGETS . '/before', [$this, 'widgets_container_top_buttons']);
        add_action('hqt/container/' . self::TAB_THIRD_PARTY_WIDGETS . '/before', [$this, 'widgets_container_top_buttons']);
    }

    public function add_pro_widgets($widgets, $type) {
        if (!empty(Widgets_Control::$pro_widgets[$type])) {
            $widgets->add_field(\HQLib\Field::mk('separator', $type . '_widgets_separator', __('Widgets available with Marmot PRO', 'admin pro widgets', 'hq-widgets-for-elementor'))->set_classes('hqt-col-1-1'));
            foreach (Widgets_Control::$pro_widgets[$type] as $module_key => $module_widgets) {
                foreach ($module_widgets as $widget_key => $widget_config) {
                    $widget_requires_check = \HQLib\Helper::field_requires_check($widget_config);
                    $contentAfter = false;
                    if (\HQLib\License::is_activated() && !$widget_requires_check->success) {
                        $contentAfter = '<div class="mt-3 border-top-dotted">' . $widget_requires_check->html . '</div>';
                    }
                    if (empty($widget_config['demo_url'])) {
                        $description = sprintf('<i class="%1$s"></i>', $widget_config['icon_class']);
                    } else {
                        $description = sprintf('<i class="%1$s"></i><a href="%2$s" class="btn-widget-demo" target="_blank"><i class="eicon-device-desktop"></i></a>', $widget_config['icon_class'], $widget_config['demo_url']);
                    }
                    $widgets->add_field(
                            \HQLib\Field::mk('html', $widget_key)
                                    ->set_description($description)
                                    ->set_classes('hqt-field-widget-box hqt-col-1-2__md hqt-col-1-3__lg hqt-col-1-4__xl')
                                    ->set_html(sprintf('<span class="flex">%1$s</span>', __($widget_config['name'], 'admin pro widgets', 'hq-widgets-for-elementor')))
                                    ->set_args(['badge' => 'pro'])
                                    ->set_content_after($contentAfter)
                    );
                }
            }
        }
        if (!\HQLib\License::is_activated()) {
            $widgets->add_button('get-license', [
                'type' => 'link',
                'link' => THEME_SITE_URL . '/pricing/?utm_source=wp-admin&utm_medium=button&utm_campaign=default&utm_term=hq-widgets-for-elementor&utm_content=options-container',
                'target' => '_blank',
                'class' => 'btn-border',
                'label' => _x('Get License', 'admin pro widgets', 'hq-widgets-for-elementor'),
            ]);
        }

        return $widgets;
    }

    public function widgets_container_top_buttons() {
        ?>
        <div class="hqt-container pb-0">
            <div class="hqt-container-buttons">
                <a href="" class="btn-toggle btn-activate" data-toggle="all"><?php _e('Activate All', 'admin widgets', 'hq-widgets-for-elementor'); ?></a>
                <a href="" class="btn-toggle btn-deactivate" data-toggle="none"><?php _e('Deactivate All', 'admin widgets', 'hq-widgets-for-elementor'); ?></a>
            </div>
        </div>
        <?php
    }

    public function admin_init() {
        $core_widgets = \HQLib\Options\Container::mk(self::TAB_CORE_WIDGETS, 'Core Widgets')->set_is_grouped(true)->disable_title()->set_ajax_submit();

        foreach (Widgets_Control::$core_widgets as $module_key => $module_widgets) {
            foreach ($module_widgets as $widget_key => $widget_config) {
                $widget_requires_check = \HQLib\Helper::field_requires_check($widget_config);
                if (empty($widget_config['demo_url'])) {
                    $description = sprintf('<i class="%1$s"></i>', $widget_config['icon_class']);
                } else {
                    $description = sprintf('<i class="%1$s"></i><a href="%2$s" class="btn-widget-demo" target="_blank"><i class="eicon-device-desktop"></i></a>', $widget_config['icon_class'], $widget_config['demo_url']);
                }
                $core_widgets->add_field(
                        \HQLib\Field::mk('checkbox', $widget_key, _x($widget_config['name'], 'admin widgets', 'hq-widgets-for-elementor'))
                                ->set_description($description)
                                ->set_default_value($widget_requires_check->success ? $widget_config['default_activation'] : 'off')
                                ->set_option_value($widget_requires_check->success ? 'on' : 'off')
                                ->set_classes('hqt-field-widget-box hqt-col-1-2__md hqt-col-1-3__lg hqt-col-1-4__xl')
                                ->set_args(['switch' => true])
                                ->add_attribute('disabled', !$widget_requires_check->success)
                                ->set_content_after(!$widget_requires_check->success ? '<div class="mt-3 border-top-dotted">' . $widget_requires_check->html . '</div>' : false)
                );
            }
        }

        $third_party_widgets = \HQLib\Options\Container::mk(self::TAB_THIRD_PARTY_WIDGETS, '3rd Party Widgets')->set_is_grouped(true)->disable_title()->set_ajax_submit();

        foreach (Widgets_Control::$third_party_widgets as $module_key => $module_widgets) {
            foreach ($module_widgets as $widget_key => $widget_config) {
                $widget_requires_check = \HQLib\Helper::field_requires_check($widget_config);
                if (empty($widget_config['demo_url'])) {
                    $description = sprintf('<i class="%1$s"></i>', $widget_config['icon_class']);
                } else {
                    $description = sprintf('<i class="%1$s"></i><a href="%2$s" class="btn-widget-demo" target="_blank"><i class="eicon-device-desktop"></i></a>', $widget_config['icon_class'], $widget_config['demo_url']);
                }
                $third_party_widgets->add_field(
                        \HQLib\Field::mk('checkbox', $widget_key, _x($widget_config['name'], 'admin widgets', 'hq-widgets-for-elementor'))
                                ->set_description($description)
                                ->set_default_value($widget_requires_check->success ? $widget_config['default_activation'] : 'off')
                                ->set_option_value($widget_requires_check->success ? 'on' : 'off')
                                ->set_classes('hqt-field-widget-box hqt-col-1-2__md hqt-col-1-3__lg hqt-col-1-4__xl')
                                ->set_args(['switch' => true])
                                ->add_attribute('disabled', !$widget_requires_check->success)
                                ->set_content_after(!$widget_requires_check->success ? '<div class="mt-3 border-top-dotted">' . $widget_requires_check->html . '</div>' : false)
                );
            }
        }

        \HQLib\Options\Tabs::mk('hq-elementor-widgets-settings')
                ->add_tab(apply_filters('hqt/update/widget/options', $core_widgets, 'core'))
                ->add_tab(apply_filters('hqt/update/widget/options', $third_party_widgets, 'third_party'));
    }

    public function admin_menu() {
        add_menu_page(
                PLUGIN_NAME . ' ' . esc_html__('Dashboard', 'hq-widgets-for-elementor'),
                PLUGIN_NAME,
                'manage_options',
                self::PAGE_ID,
                [$this, 'plugin_page'],
                null,
                64
        );

        add_submenu_page(
                self::PAGE_ID,
                PLUGIN_NAME,
                esc_html__('Dashboard', 'hq-widgets-for-elementor'),
                'manage_options',
                self::PAGE_ID,
                [$this, 'plugin_page']
        );

        add_submenu_page(
                self::PAGE_ID,
                PLUGIN_NAME,
                esc_html__('Core Widgets', 'hq-widgets-for-elementor'),
                'manage_options',
                self::PAGE_ID . '&tab=' . self::TAB_CORE_WIDGETS,
                [$this, 'display_page']
        );

        add_submenu_page(
                self::PAGE_ID,
                PLUGIN_NAME,
                esc_html__('3rd Party Widgets', 'hq-widgets-for-elementor'),
                'manage_options',
                self::PAGE_ID . '&tab=' . self::TAB_THIRD_PARTY_WIDGETS,
                [$this, 'display_page']
        );
    }

    public function plugin_page() {
        ?>
        <div class="hqt-admin-page">
            <div class="wrap">
                <h1 class="hqt-invisible"></h1>
                <div class="hqt-logo-wrap">
                    <a href="https://marmot.hqwebs.net/hq-widgets-for-elementor/?utm_source=wp-admin&utm_medium=logo&utm_campaign=default&utm_term=hq-widgets-for-elementor&utm_content=settings-tabs-top" target="_blank">
                        <img src="<?php echo \HQLib\LIB_URL; ?>assets/images/admin/logo-hq-widgets.png" class="img-fluid">
                    </a>
                    <p class="mt-0">Version <?php echo VERSION; ?></p>
                </div>
                <?php
                $dashboard_content_field = \HQLib\Field::mk('html', 'dashboard-page')
                        ->set_classes('hqt-col-1-1')
                        ->set_html($this->dashboard_tab());

                // Create dashboard container
                $dashboard_container = \HQLib\Options\Container::mk('dashboard')
                        ->set_is_grouped()
                        ->disable_submit()
                        ->add_field($dashboard_content_field);

                // Prepend dashboard container tab
                \HQLib\Options\Tabs::get('hq-elementor-widgets-settings')
                        ->add_tab($dashboard_container, 'Dashboard', true);

                // Display settings tabs
                \HQLib\Options::display_tabs('hq-elementor-widgets-settings');
                $this->footer_info();
                ?>
            </div>
        </div>
        <?php
    }

    private function dashboard_tab() {
        ob_start();
        ?>
        <div class="hqt-row align-items-center">
            <div class="hqt-col-1-2__md">
                <h2 class="my-4"><?php _ex('Welcome to HQ Widgets For Elementor', 'admin dashboard', 'hq-widgets-for-elementor'); ?></h2>
                <p class="my-4"><?php _ex('Beautiful and intuitive Elementor Widgets make the process of website building a lot more fun and easy. <br> It works smoothly with all other products.', 'admin dashboard', 'hq-widgets-for-elementor'); ?></p>
                <div class="mb-4">
                    <a href="https://marmot.hqwebs.net/hq-widgets-for-elementor/?utm_source=wp-admin&utm_medium=button&utm_campaign=default&utm_term=hq-widgets-for-elementor&utm_content=dashboard-learn-more" class="btn btn-border" target="_blank">
                        <?php _ex('Learn More', 'admin dashboard', 'hq-widgets-for-elementor'); ?>
                    </a>
                </div>
            </div>
            <div class="hqt-col-1-2__md">
                <div class="px-5 text-right">
                    <img src="<?php echo PLUGIN_URL; ?>assets/images/admin/dashboard-main.png" class="img-fluid">
                </div>
            </div>
        </div>
        <div class="hqt-row mt-5">
            <div class="hqt-col-1-4 mb-4">
                <div class="d-flex border-rad-10 overflow-hidden box-shadow">
                    <div class="p-2" style="background: #72016D;">
                        <img src="<?php echo PLUGIN_URL; ?>/assets/images/admin/skills.svg" class="hqt-svg-icon white">
                    </div>
                    <div class="d-flex flex-basis-100 align-items-center">
                        <h3 class="px-3"><?php _ex('Design friendly', 'admin dashboard', 'hq-widgets-for-elementor'); ?></h3>
                    </div>
                </div>
            </div>
            <div class="hqt-col-1-4 mb-4">
                <div class="d-flex border-rad-10 overflow-hidden box-shadow">
                    <div class="p-2" style="background: #C60196;">
                        <img src="<?php echo PLUGIN_URL; ?>/assets/images/admin/responsive.svg" class="hqt-svg-icon white">
                    </div>
                    <div class="d-flex flex-basis-100 align-items-center">
                        <h3 class="px-3"><?php _ex('Fully Responsive', 'admin dashboard', 'hq-widgets-for-elementor'); ?></h3>
                    </div>
                </div>
            </div>
            <div class="hqt-col-1-4 mb-4">
                <div class="d-flex border-rad-10 overflow-hidden box-shadow">
                    <div class="p-2" style="background: #DC057C;">
                        <img src="<?php echo PLUGIN_URL; ?>/assets/images/admin/ui.svg" class="hqt-svg-icon white">
                    </div>
                    <div class="d-flex flex-basis-100 align-items-center">
                        <h3 class="px-3"><?php _ex('No Coding Required', 'admin dashboard', 'hq-widgets-for-elementor'); ?></h3>
                    </div>
                </div>
            </div>
            <div class="hqt-col-1-4 mb-4">
                <div class="d-flex border-rad-10 overflow-hidden box-shadow">
                    <div class="p-2" style="background: #F6356E;">
                        <img src="<?php echo PLUGIN_URL; ?>/assets/images/admin/ecommerce.svg" class="hqt-svg-icon white">
                    </div>
                    <div class="d-flex flex-basis-100 align-items-center">
                        <h3 class="px-3"><?php _ex('WooCommerce compatible', 'admin dashboard', 'hq-widgets-for-elementor'); ?></h3>
                    </div>
                </div>
            </div>
        </div>


        <div class="hqt-row my-6">
            <div class="hqt-col-1-2__sm">
                <img src="<?php echo PLUGIN_URL; ?>/assets/images/admin/widgets.png" class="img-fluid">
            </div>
            <div class="hqt-col-1-2__sm px-3">
                <h3 class="mt-2 mb-0"><?php _ex('Theme building widgets', 'admin dashboard', 'hq-widgets-for-elementor'); ?></h3>
                <p class="m-0"><?php _ex('Combine with Marmot theme to use our theme building widget to create you custom templates for posts, archives, custom posts, etc..', 'admin dashboard', 'hq-widgets-for-elementor'); ?></p>
                <a href="https://marmot.hqwebs.net/hq-widgets-for-elementor/?utm_source=wp-admin&utm_medium=button&utm_campaign=default&utm_term=hq-widgets-for-elementor&utm_content=theme-widgets-learn-more#posts" target="_blank">
                    <?php _ex('Learn more', 'admin dashboard', 'hq-widgets-for-elementor'); ?>
                </a>

                <h3 class="mt-2 mb-0"><?php _ex('Forms widgets', 'admin dashboard', 'hq-widgets-for-elementor'); ?></h3>
                <p class="m-0"><?php _ex('Customize Contact Form 7 and WPForm forms with our widgets.', 'admin dashboard', 'hq-widgets-for-elementor'); ?></p>
                <a href="https://marmot.hqwebs.net/hq-widgets-for-elementor/?utm_source=wp-admin&utm_medium=button&utm_campaign=default&utm_term=hq-widgets-for-elementor&utm_content=forms-widgets-learn-more#forms" target="_blank">
                    <?php _ex('Learn more', 'admin dashboard', 'hq-widgets-for-elementor'); ?>
                </a>
                <h3 class="mt-2 mb-0"><?php _ex('WooCommerce building widgets', 'admin dashboard', 'hq-widgets-for-elementor'); ?></h3>
                <p class="m-0"><?php _ex('Build smooth user experience throughout the whole selling process.', 'admin dashboard', 'hq-widgets-for-elementor'); ?></p>
                <a href="https://marmot.hqwebs.net/hq-widgets-for-elementor/?utm_source=wp-admin&utm_medium=button&utm_campaign=default&utm_term=hq-widgets-for-elementor&utm_content=woo-widgets-learn-more#woocommerce" target="_blank">
                    <?php _ex('Learn more', 'admin dashboard', 'hq-widgets-for-elementor'); ?>
                </a>
                <h3 class="mt-2 mb-0"><?php _ex('New widgets coming...', 'admin dashboard', 'hq-widgets-for-elementor'); ?></h3>
                <p class="m-0"><?php _ex('We are improving it all the time by adding new widgets.', 'admin dashboard', 'hq-widgets-for-elementor'); ?></p>
                <div class="mt-4">
                    <a href="https://marmot.hqwebs.net/hq-widgets-for-elementor/?utm_source=wp-admin&utm_medium=button&utm_campaign=default&utm_term=hq-widgets-for-elementor&utm_content=all-widgets-learn-more"class="btn btn-primary" target="_blank">
                        <?php _ex('View all widgets', 'admin dashboard', 'hq-widgets-for-elementor'); ?>
                    </a>
                </div>
            </div>
        </div>
        <?php /* Theme presentaion */ ?>
        <div class="hqt-row mt-3">
            <div class="hqt-col-1-2__md">
                <h3 class="my-1 mb-2"><?php _ex('HQ Widgets for Elementor Recommends Marmot Theme', 'admin', 'marmot'); ?></h3>                
                <div class="hqt-logo-wrap">
                    <a href="https://marmot.hqwebs.net/?utm_source=wp-admin&utm_medium=logo&utm_campaign=default&utm_content=hqwidgets" target="_blank">
                        <img src="<?php echo PLUGIN_URL; ?>/assets/images/admin/logo-marmot.png">
                    </a>
                </div>

                <h2 class="mt-6 mb-0 text-medium"><?php _ex('Fully customizable WordPress theme', 'admin', 'marmot'); ?></h2>
                <ul class="hqt-list list-dot my-3">
                    <li><?php _ex('The most flexible theme for Elementor page builder fans', 'admin', 'marmot'); ?></li>
                    <li><?php _ex('Professionally ready to use demos right behind a click', 'admin', 'marmot'); ?></li>
                    <li><?php _ex('Fast and light - Marmot theme is made for speed', 'admin', 'marmot'); ?></li>
                </ul>
                <div class="mt-5">
                    <a target="_blank" href="https://marmot.hqwebs.net/ready-demos/?utm_source=wp-admin&utm_medium=link&utm_campaign=default&utm_content=learn-more" class="btn btn-border ml-2 mr-1"><?php _ex('View Demos', 'admin', 'marmot'); ?></a>
                    <a target="_blank" href="https://marmot.hqwebs.net/?utm_source=wp-admin&utm_medium=link&utm_campaign=default&utm_content=learn-more" ><?php _ex('Learn More', 'admin', 'marmot'); ?></a>
                </div>
            </div>
            <div class="hqt-col-1-2__md d-flex align-items-center">
                <img src="<?php echo PLUGIN_URL; ?>/assets/images/admin/dashboard-theme.png" class="img-fluid">
            </div>
        </div>
        <div class="hqt-row mt-5">
            <div class="hqt-col-1-2__sm hqt-col-2-3__lg hqt-col-1-2__xl">
                <div class="hqt-row">
                    <div class="hqt-col-1-2 mb-4">
                        <div class="d-flex border-rad-10 overflow-hidden box-shadow">
                            <div class="p-2" style="background: #f40c3c;">
                                <img src="<?php echo PLUGIN_URL; ?>/assets/images/admin/startup.svg" class="hqt-svg-icon white">
                            </div>
                            <div class="d-flex flex-basis-100 align-items-center">
                                <h3 class="px-3"><?php _ex('Modern Design', 'admin', 'marmot'); ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="hqt-col-1-2 mb-4">
                        <div class="d-flex border-rad-10 overflow-hidden box-shadow">
                            <div class="p-2" style="background: #f7382b;">
                                <img src="<?php echo PLUGIN_URL; ?>/assets/images/admin/responsive.svg" class="hqt-svg-icon white">
                            </div>
                            <div class="d-flex flex-basis-100 align-items-center">
                                <h3 class="px-3"><?php _ex('Fully Responsive', 'admin', 'marmot'); ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="hqt-col-1-2 mb-4">
                        <div class="d-flex border-rad-10 overflow-hidden box-shadow">
                            <div class="p-2" style="background: #fb7015;">
                                <img src="<?php echo PLUGIN_URL; ?>/assets/images/admin/development.svg" class="hqt-svg-icon white">
                            </div>
                            <div class="d-flex flex-basis-100 align-items-center">
                                <h3 class="px-3"><?php _ex('No Coding Required', 'admin', 'marmot'); ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="hqt-col-1-2 mb-4">
                        <div class="d-flex border-rad-10 overflow-hidden box-shadow">
                            <div class="p-2" style="background: #ffa002;">
                                <img src="<?php echo PLUGIN_URL; ?>/assets/images/admin/content.svg" class="hqt-svg-icon white">
                            </div>
                            <div class="d-flex flex-basis-100 align-items-center">
                                <h3 class="px-3"><?php _ex('Customize Everything', 'admin', 'marmot'); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hqt-col-1-2__sm hqt-col-1-3__lg hqt-col-1-2__xl px-6">
                <h2 class="mt-0 mb-2 text-medium"><?php _ex('Use Elementor templates for', 'admin', 'marmot'); ?></h2>
                <h3 class="mt-2 mb-0"><?php _ex('Header and Footer', 'admin', 'marmot'); ?></h3>
                <a href="https://marmot.hqwebs.net/?utm_source=wp-admin&utm_medium=button&utm_campaign=default&utm_content=learn-more" target="_blank">
                    <?php _ex('Learn how', 'admin', 'marmot'); ?>
                </a>
                <h3 class="mt-2 mb-0"><?php _ex('Single and Archive post page', 'admin', 'marmot'); ?></h3>
                <a href="https://marmot.hqwebs.net/?utm_source=wp-admin&utm_medium=button&utm_campaign=default&utm_content=learn-more" target="_blank">
                    <?php _ex('Learn how', 'admin', 'marmot'); ?>
                </a>
                <h3 class="mt-2 mb-0"><?php _ex('WooCommerce product and Woo Archive page', 'admin', 'marmot'); ?></h3>
                <a href="https://marmot.hqwebs.net/woocommerce-integration/?utm_source=wp-admin&utm_medium=button&utm_campaign=default&utm_content=learn-more" target="_blank">
                    <?php _ex('Learn how', 'admin', 'marmot'); ?>
                </a>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    private function footer_info() {
        ?>
        <div class="hqt-page-footer-info">
            <p>Thank you for choosing <?php echo PLUGIN_NAME; ?> by <a href="https://marmot.hqwebs.net/?utm_source=wp-admin&utm_medium=link&utm_campaign=default&utm_term=hq-widgets-for-elementor&utm_content=page-footer" target="_blank">Marmot theme</a>.</p> 
        </div>
        <?php
    }

}
