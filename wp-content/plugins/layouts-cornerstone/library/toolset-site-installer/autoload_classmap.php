<?php
// Generated by ZF2's ./bin/classmap_generator.php
$current_dir = dirname( __FILE__ );

// Include Toolset Advanced Export Classmap
$file_toolset_advanced_classmap = $current_dir . '/installer/library/toolset-advanced-export/application/autoload_classmap.php';
$toolset_advanced_classmap = file_exists( $file_toolset_advanced_classmap )
	? include( $file_toolset_advanced_classmap )
	: array();

// Classmap
return array_merge( $toolset_advanced_classmap, array(
	'TT_Autoloader'                              => $current_dir . '/autoloader.php',
	'TT_Controller_Abstract'                     => $current_dir . '/installer/application/controller/acontroller.php',
	'TT_Controller_Ajax_Import'                  => $current_dir . '/installer/application/controller/ajax-import.php',
	'TT_Controller_Ajax_Plugins'                 => $current_dir . '/installer/application/controller/ajax-plugins.php',
	'TT_Controller_Ajax_Host_Allowed'            => $current_dir . '/installer/application/controller/ajax-host-allowed.php',
	'TT_Controller_Ajax_Site_Key'                => $current_dir . '/installer/application/controller/ajax-site-key.php',
	'TT_Controller_Setup_Theme'                  => $current_dir . '/installer/application/controller/setup-theme.php',
	'TT_Controller_Setup_Plugin'                 => $current_dir . '/installer/application/controller/setup-plugin.php',
	'TT_Controller_Site_Installer'               => $current_dir . '/installer/application/controller/site-installer.php',
	'TT_Context_Interface'                       => $current_dir . '/installer/application/model/context/icontext.php',
	'TT_Context_Abstract'                        => $current_dir . '/installer/application/model/context/acontext.php',
	'TT_Context_Plugin'                          => $current_dir . '/installer/application/model/context/plugin.php',
	'TT_Context_Theme'                           => $current_dir . '/installer/application/model/context/theme.php',
	'TT_Context_Toolset_Starter'                 => $current_dir . '/installer/application/model/context/toolset-starter.php',
	'TT_Helper_Notice_Abstract'                  => $current_dir . '/installer/application/model/helper/notice/abstract.php',
	'TT_Helper_Notice_Installation_Incomplete'   => $current_dir . '/installer/application/model/helper/notice/installation-incomplete.php',
	'TT_Helper_Notice_Update_Incomplete'         => $current_dir . '/installer/application/model/helper/notice/update-incomplete.php',
	'TT_Upgrader_Skin_Ajax'                      => $current_dir . '/installer/application/model/helper/upgrader-skin/ajax.php',
	'TT_Helper_Zip'                              => $current_dir . '/installer/application/model/helper/zip.php',
	'TT_Import_Abstract'                         => $current_dir . '/installer/application/model/import/aimport.php',
	'TT_Import_Cred_Post_Forms'                  => $current_dir . '/installer/application/model/import/cred/post-forms.php',
	'TT_Import_Cred_User_Forms'                  => $current_dir . '/installer/application/model/import/cred/user-forms.php',
	'TT_Import_Cred'                             => $current_dir . '/installer/application/model/import/cred.php',
	'TT_Import_Interface'                        => $current_dir . '/installer/application/model/import/iimport.php',
	'TT_Import_Items_Group_Abstract'             => $current_dir . '/installer/application/model/import/items/agroup.php',
	'TT_Import_Items_Group_Interface'            => $current_dir . '/installer/application/model/import/items/igroup.php',
	'TT_Import_Layouts_Layouts'                  => $current_dir . '/installer/application/model/import/layouts/layouts.php',
	'TT_Import_Layouts'                          => $current_dir . '/installer/application/model/import/layouts.php',
	'TT_Import_Wordpress'                        => $current_dir . '/installer/application/model/import/wordpress.php',
	'TT_Import_Types_Post_Fields'                => $current_dir . '/installer/application/model/import/types/post-fields.php',
	'TT_Import_Types_Post_Groups'                => $current_dir . '/installer/application/model/import/types/post-groups.php',
	'TT_Import_Types_Post_Types'                 => $current_dir . '/installer/application/model/import/types/post-types.php',
	'TT_Import_Types_Taxonomies'                 => $current_dir . '/installer/application/model/import/types/taxonomies.php',
	'TT_Import_Types_Term_Fields'                => $current_dir . '/installer/application/model/import/types/term-fields.php',
	'TT_Import_Types_Term_Groups'                => $current_dir . '/installer/application/model/import/types/term-groups.php',
	'TT_Import_Types_User_Fields'                => $current_dir . '/installer/application/model/import/types/user-fields.php',
	'TT_Import_Types_User_Groups'                => $current_dir . '/installer/application/model/import/types/user-groups.php',
	'TT_Import_Types'                            => $current_dir . '/installer/application/model/import/types.php',
	'TT_Import_Views_Content_Templates'          => $current_dir . '/installer/application/model/import/views/content-templates.php',
	'TT_Import_Views_Wordpress_Archives'         => $current_dir . '/installer/application/model/import/views/wordpress-archives.php',
	'TT_Import_Views_Views'                      => $current_dir . '/installer/application/model/import/views/views.php',
	'TT_Import_Views'                            => $current_dir . '/installer/application/model/import/views.php',
	'TT_Import_Toolset_Extra'                    => $current_dir . '/installer/application/model/import/toolset-extra.php',
	'TT_Plugin'                                  => $current_dir . '/installer/application/model/plugin/plugin.php',
	'TT_Plugin_Layouts'                          => $current_dir . '/installer/application/model/plugin/layouts.php',
	'TT_Plugin_Views'                            => $current_dir . '/installer/application/model/plugin/views.php',
	'TT_Plugin_Types'                            => $current_dir . '/installer/application/model/plugin/types.php',
	'TT_Plugin_Cred'                             => $current_dir . '/installer/application/model/plugin/cred.php',
	'TT_Plugin_Access'                           => $current_dir . '/installer/application/model/plugin/access.php',
	'TT_Plugin_Maps'                             => $current_dir . '/installer/application/model/plugin/maps.php',
	'TT_Repository_Abstract'                     => $current_dir . '/installer/application/model/repository/arepository.php',
	'TT_Repository_Interface'                    => $current_dir . '/installer/application/model/repository/irepository.php',
	'TT_Repository_OTGS'                         => $current_dir . '/installer/application/model/repository/otgs.php',
	'TT_Repository_TBT'                          => $current_dir . '/installer/application/model/repository/tbt.php',
	'TT_Response_Interface'                      => $current_dir . '/installer/application/model/response/iresponse.php',
	'TT_Response_Wp_Ajax'                        => $current_dir . '/installer/application/model/response/wp-ajax.php',
	'TT_Step_Abstract'                           => $current_dir . '/installer/application/model/step/abstract.php',
	'TT_Step_Demo_Import'                        => $current_dir . '/installer/application/model/step/demo-import.php',
	'TT_Step_Finish'                             => $current_dir . '/installer/application/model/step/finish.php',
	'TT_Step_Plugin_Installation'                => $current_dir . '/installer/application/model/step/plugin-installation.php',
	'TT_Step_Welcome'                            => $current_dir . '/installer/application/model/step/welcome.php',
	'TT_Step_PHP_Version_Incompatible'           => $current_dir . '/installer/application/model/step/php-version-incompatible.php',
	'TT_Step_Site_Key'                           => $current_dir . '/installer/application/model/step/site-key.php',
	'TT_Settings_Files'                          => $current_dir . '/settings/files.php',
	'TT_Settings_Files_Interface'                => $current_dir . '/settings/ifiles.php',
	'TT_Settings_Protocol_Interface'             => $current_dir . '/settings/iprotocol.php',
	'TT_Settings_Interface'                      => $current_dir . '/settings/isettings.php',
	'TT_Settings_Protocol'                       => $current_dir . '/settings/protocol.php',
	'TT_Settings'                                => $current_dir . '/settings/settings.php',
	'TT_Updater_Plugin'                          => $current_dir . '/updater/plugin.php',
	'TT_Updater_Theme'                           => $current_dir . '/updater/theme.php',
	'TT_Update_Theme_Info'                       => $current_dir . '/updater/theme.php',
) );
