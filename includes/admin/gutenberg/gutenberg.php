<?php

// previus defined admin constants
// wpda_pricing_table_plugin_url
// wpda_pricing_table_plugin_path
class wpda_pricing_table_gutenberg{	
	function __construct(){
		$this->hooks_for_gutenberg();
	}
	private function hooks_for_gutenberg(){
		add_action( 'init', array($this,'guthenberg_init') );
	}
	public function guthenberg_init(){
		if ( ! function_exists( 'register_block_type' ) ) {
		// Gutenberg is not active.
		return;
		}
		register_block_type( 'wpdevart-pricingtable/pricingtable', array(
			'style' => 'wpda_pricing_table_gutenberg_css',
			'editor_script' => 'wpda_pricing_table_gutenberg_js',
		) );
		wp_add_inline_script(
			'wpda_pricing_table_gutenberg_js',
			sprintf('var wpda_pricing_table_gutenberg = { tables: %s,other_data: %s};', json_encode($this->get_tables(),JSON_PRETTY_PRINT), json_encode($this->other_dates(),JSON_PRETTY_PRINT)),
			'before'
		);
	}
	private function get_tables(){		
		global $wpdb;
		$tables=$wpdb->get_results('SELECT `id`,`name` FROM ' . wpda_pricing_table_databese::$table_names['columns']);
		$array=array();
		foreach($tables as $table){
			$array[$table->id]=$table->name;
		}
		return $array;
	}
	private function other_dates(){
		$array=array('icon_src'=>wpda_pricing_table_plugin_url."includes/admin/images/icon.png");
		return $array;
	}	
}

