<?php
/**
 * Date: 05/04/18
 * Time: 10:43
 */
class Toolset_Framework_Installer_Unpack extends Toolset_Framework_Installer_Install_Step {

	/**
	 * @var string
	 */
	private $wpml_mo_files_path = '';

	/**
	 * @var string
	 */
	private $blog_wpml_mo_files_path = '';


	/**
	 * Step 2: Unpack files
	 *
	 * @return array
	 */
	public function unpack_site() {
		global $frameworkinstaller;

		if ( isset( $_POST['wpml'] ) && 'wpml' === $_POST['wpml'] ) { //phpcs:ignore
			if ( is_multisite() ) {
				$this->wpml_mo_files_path = WP_CONTENT_DIR . '/languages/wpml/';
				$this->blog_wpml_mo_files_path = WP_CONTENT_DIR . '/languages/wpml/' . get_current_blog_id() . '/';
			} else {
				$this->blog_wpml_mo_files_path = WP_CONTENT_DIR . '/languages/wpml/';
			}

			wp_mkdir_p( $this->blog_wpml_mo_files_path );
		}

		$status = $this->unzip_site( $this->dest );
		if ( ! $status ) {
			return $this->generate_respose_error( false, __( 'Cannot unpack demo files', 'wpvdemo' ) );
		}

		if ( ! $frameworkinstaller->is_discoverwp() && ! is_multisite() ) {

			$status = true;
			if ( ! $this->is_theme_installed( $this->get_selected_theme(), $this->get_theme_version() ) ) {
				$status = $this->unzip_theme( $this->theme_dest, $this->get_selected_theme() );
			}

			$parent_theme = $this->get_parent_theme();
			if ( ! empty( $parent_theme ) ) {
				if ( ! $this->is_theme_installed( $this->get_parent_theme(), $this->get_parent_theme_version() ) ) {
					$status = $this->unzip_theme( $this->theme_parent_dest, $this->get_parent_theme() );
				}
			}

			if ( ! $status ) {
				return $this->generate_respose_error( false, __( 'Cannot unpack theme files', 'wpvdemo' ) );
			}
		}

		if ( $status ) {
			$data = $this->generate_respose_error( true, __( 'Files successfully unpacked', 'wpvdemo' ) );
		}

		$this->disable_site_plugins();

		return $data;
	}


	/**
	 * Unpack site zip to uploads directory
	 *
	 * @return bool
	 */
	public function unzip_site() {
		global $frameworkinstaller;
		$search_for = 'files/';
		if ( $this->use_optimized_version() ) {
			$search_for = 'files2/';
		}
		$status = false;
		$zip = new ZipArchive();
		if ( $zip->open( $this->dest ) === true ) {
			for ( $i = 0; $i < $zip->numFiles; $i ++ ) { // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase

				$filename = $zip->getNameIndex( $i );
				$file_info = pathinfo( $filename );
				$source_file = 'zip://' . $this->dest . '#' . $filename;
				if ( 'wpml' === $file_info['dirname'] ) {
					$destination_file = $this->wpml_mo_files_path . str_replace( 'wpml/', '', $filename );
					if ( ! $this->unzip_file( $source_file, $destination_file ) ) {
						return false;
					}
					continue;
				}

				if ( 'wpml/files' === $file_info['dirname'] ) {
					if ( is_multisite() ) {
						$destination_file = $this->blog_wpml_mo_files_path
							. str_replace( 'wpml/files/', '', $filename );
					} else {
						$destination_file = $this->wpml_mo_files_path . str_replace( 'wpml/files/', '', $filename );
					}
					$this->unzip_file( $source_file, $destination_file );
					continue;
				}

				if ( 'sql' === $file_info['extension'] ) {
					$this->unzip_file( $source_file, $this->upload_dir['basedir'] . '/fidemo_sql_dump.sql' );
				} else {
					$upload_dir = explode( '/', str_replace( $search_for, '', $file_info['dirname'] ) );
					$dest_path = $this->upload_dir['basedir'];
					foreach ( $upload_dir as $index => $dir ) { //phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
						if ( '.' === $dir ) {
							continue;
						}
						$dest_path .= '/' . $dir;
						if ( ! file_exists( $dest_path ) ) {
							mkdir( $dest_path, 0755 );
						}
					}
					$destination_file = $this->upload_dir['basedir'] . '/' . str_replace( $search_for, '', $filename );
					$this->unzip_file( $source_file, $destination_file );
				}
			}
			$zip->close();
			$status = true;
		}
		if ( $frameworkinstaller->is_discoverwp() ) {
			unlink( $this->dest );
		}

		return $status;
	}


	/**
	 * @param string $source_file
	 * @param string $destination_file
	 */
	public function unzip_file( $source_file, $destination_file ) {
		wp_delete_file( $destination_file );

		return copy( $source_file, $destination_file );
	}


	/**
	 * Unpack selected theme to the themes directory
	 *
	 * @param string $file
	 * @param string $theme
	 *
	 * @return bool
	 */
	public function unzip_theme( $file, $theme ) {
		$status = false;
		$zip = new ZipArchive();
		$theme_root = get_theme_root() . '/' . $theme;

		if ( ! file_exists( $theme_root ) ) {
			mkdir( $theme_root, 0755 );
		}
		if ( $zip->open( $file ) === true ) {
			for ( $i = 0; $i < $zip->numFiles; $i ++ ) { // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase

				$filename = $zip->getNameIndex( $i );
				$fileinfo = pathinfo( $filename );
				$upload_dir = explode( '/', $fileinfo['dirname'] );
				$dest_path = $theme_root;
				foreach ( $upload_dir as $index => $dir ) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
					if ( '.' === $dir ) {
						continue;
					}
					$dest_path .= '/' . $dir;
					if ( ! file_exists( $dest_path ) ) {
						mkdir( $dest_path, 0755 );
					}
				}
				copy( 'zip://' . $file . '#' . $filename, $theme_root . '/' . $filename );
			}
			$zip->close();
			$status = true;
		}
		wp_delete_file( $file );

		return $status;
	}


	/**
	 * Disable site plugins before import DB
	 */
	public function disable_site_plugins() {
		global $wpdb;
		$active_site_plugins = get_option( 'active_plugins' );
		$plugins_list = array();
		foreach ( $active_site_plugins as $plugin ) {
			if ( 'framework-installer.php' === basename( $plugin ) ) {
				$plugins_list[] = $plugin;
			}
		}

		$sql = "UPDATE {$wpdb->prefix}options set option_value='%s' where option_name='active_plugins'";
		$wpdb->query( $wpdb->prepare( $sql, serialize( $plugins_list ) ) ); // phpcs:ignore
	}

}
