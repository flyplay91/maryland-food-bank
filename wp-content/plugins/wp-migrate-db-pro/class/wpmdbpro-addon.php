<?php
class WPMDBPro_Addon extends WPMDBPro_Base {
	protected $version_required;

	function __construct( $plugin_file_path ) {
		parent::__construct( $plugin_file_path );
	}

	function meets_version_requirements( $version_required ) {
		$wpmdb_pro_version = $GLOBALS['wpmdb_meta']['wp-migrate-db-pro']['version'];
		$result = version_compare( $wpmdb_pro_version, $version_required, '>=' );
		$this->version_required = $version_required;
		if( false == $result ) $this->hook_version_requirement_actions();

		if ( $result ) {
			// If pre-1.1.2 version of Media Files addon,
			// then it's not supported by this version of core
			if ( empty( $this->plugin_version ) ) {
				$result = false;
			}
			// Check that this version of core supports the addon version
			else {
				$required_addon_version = $this->addons[$this->plugin_basename]['required_version'];
				$result = version_compare( $this->plugin_version, $required_addon_version, '>=' );
			}
		}

		return $result;
	}

	function hook_version_requirement_actions() {
		add_action( 'wpmdb_notices', array( $this, 'version_requirement_actions' ) );
	}

	function version_requirement_actions() {
		$addon_requirement_check = get_option( 'wpmdb_addon_requirement_check', array() );
		// we only want to delete the transients once, here we keep track of which versions we've checked
		if( ! isset( $addon_requirement_check[$this->plugin_slug] ) || $addon_requirement_check[$this->plugin_slug] != $GLOBALS['wpmdb_meta'][$this->plugin_slug]['version'] ) {
			delete_site_transient( 'wpmdb_upgrade_data' );
			delete_site_transient( 'update_plugins' );
			$addon_requirement_check[$this->plugin_slug] = $GLOBALS['wpmdb_meta'][$this->plugin_slug]['version'];
			update_option( 'wpmdb_addon_requirement_check', $addon_requirement_check );
		}
		$this->version_requirement_warning();
	}

	function version_requirement_warning() { ?>
		<div class="updated warning inline-message below-h2">
				<strong>Update Required</strong> &mdash;
				<?php
					$addon_name = $this->get_plugin_name();
					$required = $this->version_required;
					$installed = $GLOBALS['wpmdb_meta']['wp-migrate-db-pro']['version'];
					$wpmdb_basename = sprintf( '%s/%s.php', $GLOBALS['wpmdb_meta']['wp-migrate-db-pro']['folder'], 'wp-migrate-db-pro' );
					$update = wp_nonce_url( network_admin_url( 'update.php?action=upgrade-plugin&plugin=' . urlencode( $wpmdb_basename ) ), 'upgrade-plugin_' . $wpmdb_basename );
					echo sprintf( 'The version of %s you have installed, requires version %s of WP Migrate DB Pro. You currently have %s installed. <a href="%s">Update Now</a>', $addon_name, $required, $installed, $update );
				?>
		</div>
		<?php
	}

}
