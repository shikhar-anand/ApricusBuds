<?php

class TT_Controller_Setup_Theme extends TT_Controller_Abstract
{
    const PAGE   = 'toolset-based-theme-setup';
	const RUN_AS = 'theme';

    /**
     * @var array
     */
    private $response = array(
        'message'        => '',
        'success'        => 1,
        'failed'         => 0,
        'modified_items' => 0,
    );

    /**
     * @var TT_Step_Abstract[]
     */
    private $steps = array();

    /**
     * @var TT_Step_Abstract[]
     */
    private $steps_active;

    public function __construct(TT_Settings_Interface $settings)
    {
        parent::__construct($settings);

        // ajax actions
        add_action('wp_ajax_tt_ajax', array($this, 'ajax'));

        // disable Beaver Builder Lite redirect on activation
        $this->disableBeaverBuilderRedirect();

        // redirect to full screen installer on theme activation
        $this->redirectOnThemeActivation();

	    // redirect to full screen installer on theme activation
	    $this->redirectOnThemeUpdate();

        // full screen installer
        $this->pageFullScreenInstaller();

        // possible notices
        $this->notices();
    }

    public function ajax()
    {
        if (! check_ajax_referer('tt-theme-setup', 'request_key', false) || ! current_user_can('manage_options')) {
            // todo make an ajax response here
            throw new Exception('You are not allowed todo this command.');
        }

        if (! array_key_exists('command', $_REQUEST)) {
            // todo make an ajax response here
            throw new Exception('Command must be declared');
        }

        switch ($_REQUEST['command']) {
            case 'load_step':
                return $this->ajaxLoadStep();
            case 'step_requirements_done':
                return $this->ajaxRequirementsDone();
            case TT_Controller_Ajax_Import::COMMAND:
                $controller = new TT_Controller_Ajax_Import($this->settings);
                break;
            case TT_Controller_Ajax_Plugins::COMMAND:
                $controller = new TT_Controller_Ajax_Plugins($this->settings);
                break;
	        case TT_Controller_Ajax_Host_Allowed::COMMAND:
	        	$controller = new TT_Controller_Ajax_Host_Allowed($this->settings);
	        	break;
            default:
                throw new Exception('Invalid command');
        }

        $controller->handleAjaxRequest();
    }

	private function notices() {
		if ( ! $this->getUnfinishedStep() ) {
			// no notices when there is no unfinished step
			return;
		}


		if ( $this->themeUpdated() ) {
			// notice: update not finished
			return new TT_Helper_Notice_Update_Incomplete();
		}

		// notice: installation not finished
		return new TT_Helper_Notice_Installation_Incomplete();
	}

    private function pageFullScreenInstaller()
    {

        if (isset($_GET['page'])
            && $_GET['page'] == self::PAGE
        ) {
	        $this->settings->getProtocol()->setLastInstalledThemeVersion();
            $this->initSteps();
            add_action('admin_init', array($this, 'actionScriptsAndStyles'));
            add_action('admin_init', array($this, 'actionRunInstaller'));
            add_action('admin_menu', array($this, 'actionAdminMenu'));
        }
    }

    /**
     * First time the theme gets activated the installer will automatically run
     */
    private function redirectOnThemeActivation()
    {
        global $pagenow;

        // redirect, if...
        if ('themes.php' == $pagenow                            // on themes overview page
            && isset($_GET['activated'])                      // theme gets activated
            && ! $this->settings->getProtocol()->getFirstInstalledThemeVersion() // installer did not run before
        ) {
            // time to store the first installed theme version
            $this->settings->getProtocol()->setFirstInstalledThemeVersion();
            wp_redirect(admin_url('index.php?page=' . self::PAGE));
        }
    }

	/**
	 * Run theme installer on theme update
	 */
	private function redirectOnThemeUpdate()
	{
		if ( $this->settings->getProtocol()->getLastInstalledThemeVersion() != TT_THEME_VERSION
			&& ( ! array_key_exists( 'page', $_GET ) || $_GET['page'] != self::PAGE )
		) {
			// redirect
			wp_redirect(admin_url('index.php?page=' . self::PAGE));
		}
	}

    public function ajaxLoadStep()
    {
        $id = array_key_exists('tt_step_id', $_REQUEST)
            ? $_REQUEST['tt_step_id']
            : 0;

        $this->initSteps();

        $return = array();

        if (isset($this->steps[$id])) {
            ob_start();
            $this->steps[$id]->render();
            $return['html'] = ob_get_contents();
            ob_end_clean();
        }

        if ($this->steps[$id]->isFinished()) {
            $return['finished'] = 1;
        }

        echo json_encode($return);
        die(1);
    }

    public function getUnfinishedStep()
    {
        $this->initSteps();

        foreach ($this->steps as $step) {
            if ($step->isRequired() && ! $step->isFinished()) {
                return $step;
            }
        }

        return false;
    }

    public function ajaxRequirementsDone()
    {
        $id = array_key_exists('tt_step_id', $_REQUEST)
            ? $_REQUEST['tt_step_id']
            : 0;

        $this->initSteps();

        if (isset($this->steps[$id])) {
            echo $this->steps[$id]->requirementsDone();
        }

        die(1);
    }


    /**
     * Default way for ajax response
     */
    private function ajaxResponse()
    {
        echo json_encode($this->response);
        die(1);
    }

    protected function initSteps()
    {
        if (! empty($this->steps)) {
            return;
        }

        // welcome
        $step = new TT_Step_Welcome($this->settings);
        if( ! $step->isUpdate() ) {
            $step->setTitle(__('Welcome!', 'toolset-themes'));
        } else {
            $step->setTitle(__('Hi again!', 'toolset-themes'));
        }

        $step->setTemplate(TT_INSTALLER_DIR . '/application/view/theme/installer/welcome.phtml');
        $this->addStep($step);

        // plugin installation
        $step = new TT_Step_Plugin_Installation($this->settings);
        $step->setTitle(__('Plugin Installation', 'toolset-themes'));
        $step->setTemplate(TT_INSTALLER_DIR . '/application/view/theme/installer/plugin-installation.phtml');
        $this->addStep($step);

        // import settings and content
        $step = new TT_Step_Demo_Import($this->settings);
        $step->setTitle(__('Demo Design', 'toolset-themes'));
        $step->setTemplate(TT_INSTALLER_DIR . '/application/view/theme/installer/demo-import.phtml');
        $this->addStep($step);

        // finish
        $step = new TT_Step_Finish($this->settings);
        $step->setTitle(__('Finish', 'toolset-themes'));
        $step->setTemplate(TT_INSTALLER_DIR . '/application/view/theme/installer/finish.phtml');
        $this->addStep($step);
    }

    /*
	function toolset_get_plugin() {
		require_once( TT_INSTALLER_DIR . '/library/plugin-installer-ajax.php' );
	}
	*/
    public function actionScriptsAndStyles()
    {
        wp_register_style(
            'tt-installer-css',
	        $this->settings->getContext()->getAssetsUrl() . '/public/css/installer.css',
            array('dashicons'),
	        TOOLSET_SITE_INSTALLER_VERSION
        );

        wp_register_script(
            'tt-installer-js',
	        $this->settings->getContext()->getAssetsUrl() . '/public/js/installer.js',
            array('jquery-ui-dialog', 'backbone'),
	        TOOLSET_SITE_INSTALLER_VERSION,
            true
        );

        wp_localize_script('tt-installer-js', 'toolsetinstaller', array(
            'ajax_url'              => admin_url('admin-ajax.php'),
            'request_key'           => wp_create_nonce('tt-theme-setup'),
            // wp ajaxurl is not available on our fullscreen installer
            'user_choice_skip'      => TT_Controller_Ajax_Import::USER_CHOICE_SKIP,
            'user_choice_duplicate' => TT_Controller_Ajax_Import::USER_CHOICE_DUPLICATE,
            'user_choice_overwrite' => TT_Controller_Ajax_Import::USER_CHOICE_OVERWRITE,
            'user_choice_decide_per_item' => TT_Controller_Ajax_Import::USER_CHOICE_DECIDE_PER_ITEM,
	        'l10n' => array(
	        	'continue' => __( 'Continue', 'toolset-themes' ),
		        'close'    => __( 'Close', 'toolset-themes' ),
	        )
        ));
    }

    public function actionRunInstaller()
    {
        $template = TT_INSTALLER_DIR . '/application/view/theme/installer.phtml';
        if (! file_exists($template)) {
            die('Installer broken. Template file missing.');
        }

        include_once($template);

        // we don't want to have all resources of Wordpress in the installer
        die();
    }

    public function getSteps()
    {
        if ($this->steps_active !== null) {
            return $this->steps_active;
        }

        $this->steps_active = array();

        foreach ($this->steps as $step) {
            if ($step->isActive()) {
                $this->steps_active[] = $step;
            }
        }

        return $this->steps_active;
    }

    public function addStep(TT_Step_Abstract $step)
    {
        if ($step->isActive()) {
            $this->steps[] = $step;
        }
    }

    public function actionAdminMenu()
    {
        add_dashboard_page('', '', 'manage_options', self::PAGE, '');
    }

    public function themeUpdated()
    {
        if ($this->settings->getProtocol()->getFirstInstalledThemeVersion() == TT_THEME_VERSION) {
            return false;
        }

        if (! $this->settings->getProtocol()->getLastInstalledThemeVersion()
            || version_compare($this->settings->getProtocol()->getLastInstalledThemeVersion(), TT_THEME_VERSION, '>=')
        ) {
            return false;
        }

        return true;
    }

    /**
     * This removes the hook Beaver Builder adds to perform a redirect after activation
     * This is required if the plugin is installed throught our Installer
     */
    public function disableBeaverBuilderRedirect()
    {
        remove_action( 'admin_init', array( 'FLBuilderAdmin', 'show_activate_notice' ) );
    }
}
