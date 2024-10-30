<?php
/**
Plugin Name: Canecto
Plugin URI: https://www.canecto.com
Version: 1.0.0
Author: Canecto
Author URI: https://www.canecto.com
Description: Out Of The Box Website Analytics and Optimisation
*/

if( !defined( 'CANECTO_URL' ) ) {
  define( 'CANECTO_URL', plugin_dir_url( __FILE__ ) );   // Plugin url
}

/**
* Canecto Connecticator Class
*/
class canecto_mainPlug {
	/**
	* Constructor
	*/
	public function __construct() {
		// Plugin Details
        $this->plugin = new stdClass;
        $this->plugin->name = 'canecto'; // Plugin Folder
        $this->plugin->displayName = 'Canecto'; // Plugin Name
        $this->plugin->version = '1.1.1';
        $this->plugin->folder = WP_PLUGIN_DIR.'/'.$this->plugin->name; // Full Path to Plugin Folder
        $this->plugin->url = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));

        // Dashboard Submodule
        if (!class_exists('CanectoDashboardWidget')) {
			require_once($this->plugin->folder.'/_modules/dashboard/dashboard.php');
		}
		$this->dashboard = new CanectoDashboardWidget($this->plugin); 

		// Hooks
		add_action('admin_init', array(&$this, 'registerSettings'));
        add_action('admin_menu', array(&$this, 'adminPanelsAndMetaBoxes'));

        // Frontend Hooks
        add_action('wp_head', array(&$this, 'frontendHeader'));
	}

	/**
	* Register Settings
	*/
	function registerSettings() {
		register_setting($this->plugin->name, 'canecto_insert_header', 'trim');
	}

	/**
    * Register the plugin settings panel
    */
    function adminPanelsAndMetaBoxes() {
    	add_submenu_page('options-general.php', $this->plugin->displayName, $this->plugin->displayName, 'manage_options', $this->plugin->name, array(&$this, 'adminPanel'));
	}

    /**
    * Output the Administration Panel
    * Save POSTed data from the Administration Panel into a WordPress option
    */
    function adminPanel() {
    	// Save Settings
        if (isset($_POST['submit'])) {
        	// Check nonce
        	if (!isset($_POST[$this->plugin->name.'_nonce'])) {
	        	// Missing nonce
	        	$this->errorMessage = __('nonce field is missing. Settings NOT saved.', $this->plugin->name);
        	} elseif (!wp_verify_nonce($_POST[$this->plugin->name.'_nonce'], $this->plugin->name)) {
	        	// Invalid nonce
	        	$this->errorMessage = __('Invalid nonce specified. Settings NOT saved.', $this->plugin->name);
        	} else {
	        	// Save
	    		update_option('canecto_insert_header', $_POST['canecto_insert_header']);
				$this->message = __('Settings Saved.', $this->plugin->name);
			}
        }

        // Get latest settings
        $this->settings = array(
        	'canecto_insert_header' => stripslashes(get_option('canecto_insert_header')),
        );

    	// Load Settings Form
        include_once(WP_PLUGIN_DIR.'/'.$this->plugin->name.'/views/settings.php');
    }

    /**
	* Loads plugin textdomain
	*/
	function loadLanguageFiles() {
		load_plugin_textdomain($this->plugin->name, false, $this->plugin->name.'/languages/');
	}

	/**
	* Outputs script / CSS to the frontend header
	*/
	function frontendHeader(){

		$canecto_insert_header = get_option( 'canecto_insert_header' );

		if( !empty( $canecto_insert_header ) )
		{
?>
<!-- Begin Test Canecto Analytics -->
<script>
document.canecto = { id: <?php echo $canecto_insert_header; ?> };
</script><script async src="https://resource.canecto.info/analytics.js"></script>
<!-- End Test Canecto Analytics -->
<?php
		}
	}


	/**
	* Outputs the given setting, if conditions are met
	*
	* @param string $setting Setting Name
	* @return output
	*/
	function output($setting) {
		// Ignore admin, feed, robots or trackbacks
		if (is_admin() OR is_feed() OR is_robots() OR is_trackback()) {
			return;
		}

		// Get meta
		$meta = get_option($setting);
		if (empty($meta)) {
			return;
		}
		if (trim($meta) == '') {
			return;
		}

		// Output
		echo stripslashes($meta);
	}
}

$canecto = new canecto_mainPlug();
?>
