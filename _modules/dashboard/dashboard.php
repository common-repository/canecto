<?php
/**
* Dashboard Widget
*/
class CanectoDashboardWidget {
	/**
	* Constructor
	*
	* @param object $plugin Plugin Object (name, displayName, version, folder, url)
	*/
	function __construct($plugin) {
		// Plugin Details
        $this->dashboard = $plugin;
        $this->dashboardURL = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));

		// Hooks
		add_action('admin_enqueue_scripts', array(&$this, 'adminScriptsAndCSS'));
		add_action('wp_dashboard_setup', array(&$this, 'dashboardWidgetNew'));
		add_action('wp_network_dashboard_setup', array(&$this, 'dashboardWidget'));
	}

	/**
    * Register and enqueue dashboard CSS
    */
    function adminScriptsAndCSS() {
    	// CSS
    	// This will only enqueue once, despite this hook being called by up to several plugins,
    	// as we have set a single, distinct name
        wp_enqueue_style('Canecto', $this->dashboardURL.'css/admin.css', array(), 7 );
    }

	/**
    * Adds a dashboard widget to output Canecto RSS
    *
    * Checks if another CANECTO plugin has already created this widget - if so, doesn't duplicate it
    */
    function dashboardWidget() {
    	global $wp_meta_boxes;

    	if (isset($wp_meta_boxes['dashboard']['normal']['core']['Canecto'])) return; // Another plugin has already registered this widget
    	wp_add_dashboard_widget('Canecto', __('Latest from Canecto', $this->dashboard->name), array(&$this, 'outputDashboardWidget'));
    }

    function dashboardWidgetNew() {
    	global $wp_meta_boxes;

    	if (isset($wp_meta_boxes['dashboard']['normal']['core']['Canecto2'])) return; // Another plugin has already registered this widget
    	wp_add_dashboard_widget('Canecto2', __('Canecto', $this->dashboard->name), array(&$this, 'outputDashboardWidgetNew'));
    }

    /**
    * Called by dashboardWidget(), includes dashboard.php to output the Dashboard Widget
    */
    function outputDashboardWidget(){
    	include_once(WP_PLUGIN_DIR.'/'.$this->dashboard->name.'/_modules/dashboard/views/dashboard.php');
    }

    function outputDashboardWidgetNew(){
    	include_once(WP_PLUGIN_DIR.'/'.$this->dashboard->name.'/_modules/dashboard/views/dashboard-new.php');
    }
}
?>
