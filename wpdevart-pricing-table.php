<?php
/**
 * Plugin Name: Wpdevart Pricing Table
 * Plugin URI: https://wpdevart.com/wordpress-pricing-table-plugin/
 * Author URI: https://wpdevart.com
 * Description: WordPress Pricing Table plugin is a nice tool for creating beautiful pricing tables. Use WpDevArt pricing table themes and create tables just in a few minutes.
 * Version: 1.4.7
 * Author: wpdevart
 * License: GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

class wpda_pricing_table{
	
	private $admin_menu;
	
	private $front_end;
	
	function __construct(){		
		
		$this->define_constants();
		// include files 
		$this->include_files();
		// call filters for plugin
		$this->call_base_filters();
		// crate admin panel	
		$this->databese = new wpda_pricing_table_databese();
		$this->create_admin();
		$this->create_front_end();		
	}	
	
	/*###################### Create admin function ##################*/
	
	private function create_admin(){
		// create admin menu		
		$this->admin_menu = new wpda_pricing_table_admin_panel();		
	}
	
	/*###################### Create Front-End function ##################*/	
	
	public function create_front_end(){
		// create front end	
		$this->front_end = new wpdevart_pricing_table_frontend();	
	}

	/*###################### Required scripts function ##################*/
	
	public function registr_requeried_scripts(){
		wp_register_style( 'font-awesome-5',wpda_pricing_table_plugin_url.'includes/admin/css/fontawesome.css' );
		wp_register_style('wpda_pricing_table_gutenberg_css',wpda_pricing_table_plugin_url.'includes/admin/gutenberg/style.css');
		wp_register_script('wpda_pricing_table_gutenberg_js',wpda_pricing_table_plugin_url.'includes/admin/gutenberg/block.js',array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'underscore' ));		
	}
	public function plugin_multilanguage(){	
		load_plugin_textdomain( 'wpdevart_pricing_table', FALSE, basename(dirname(__FILE__)).'/languages' );
	}
	private function call_base_filters(){
		register_activation_hook( __FILE__, array($this,'install_databese') );
		add_action('init',  array($this,'registr_requeried_scripts') );
		add_action('init',  array($this,'plugin_multilanguage') );
	}
  	private function define_constants(){
		 define('wpda_pricing_table_plugin_url',trailingslashit( plugins_url('', __FILE__ ) ));
		 define('wpda_pricing_table_plugin_path',trailingslashit( plugin_dir_path( __FILE__ ) ));
		 define('wpdevart_pricing_table_support_url',"https://wordpress.org/support/plugin/wpdevart-pricing-table");
		
	}	
	
	/*###################### Including files function ##################*/
	
	private function include_files(){
		require_once(wpda_pricing_table_plugin_path.'includes/wpdevart_library.php'); 
		require_once(wpda_pricing_table_plugin_path.'includes/install_databese.php');
		require_once(wpda_pricing_table_plugin_path.'includes/admin/pricing_table_theme_page.php');
		require_once(wpda_pricing_table_plugin_path.'includes/admin/pricing_table_page.php');		
		require_once(wpda_pricing_table_plugin_path.'includes/admin/admin.php');
		require_once(wpda_pricing_table_plugin_path.'includes/frontend/front_end.php');
	}	
	
	/*###################### Database function ##################*/	
		
	public function install_databese(){
		// new class for installing databese
		$this->databese->instal_pricing_table_columns();
		$this->databese->install_theme_tabel();
		update_option('wpdevart_pricing_table_databese_status','free');
	}
}
$wpda_contdown_extend = new wpda_pricing_table();
?>