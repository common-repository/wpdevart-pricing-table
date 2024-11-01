<?php	 
class wpdevart_pricing_table_frontend{
// previus defined admin constants
// wpda_pricing_table_plugin_url
// wpda_pricing_table_plugin_path
	private static $unique_sufix=0;
	private $themes,$theme_ids,$widget_options,$columns;
	function __construct(){
		$this->call_filters();
	}
	private function call_filters(){
		add_filter('wp_head',array($this,'include_scripts'),0);		
		add_shortcode('wpdevart_pricing_table', array($this,'shortcode'));		
	}
	public function include_scripts(){
		wp_enqueue_script('jquery');
		wp_enqueue_script('wpdevart_pricing_table_js',wpda_pricing_table_plugin_url.'includes/frontend/js/pricing_table.js');
		//wp_enqueue_style('FontAwesome');		
		wp_enqueue_style('wpdevart_pricing_table_css',wpda_pricing_table_plugin_url.'includes/frontend/css/pricing_table.css');
		wp_enqueue_style('animated',wpda_pricing_table_plugin_url.'includes/frontend/css/effects.css');
		wp_enqueue_style( 'font-awesome-5');
	}

	/*###################### Shortcode function ##################*/	
	
	public function shortcode($atts){
		if(isset($atts['id']) && $atts['id']){
			return $this->controller($atts['id']);
		}else{
			return "<h3>Incorrect id in shortcode</h3>";
		}
	}
	
	/*###################### Controller function ##################*/		
	
	private function controller($table_id){
		self::$unique_sufix++;
		/*get table information*/
		if(!$this->get_table_info($table_id)){
			return "<h3>Database Error(can't find pricing table)</h3>";
		}
		if(!$theme_ids=$this->get_theme_info()){
			return "<h3>Database Error(can't find pricing table)</h3>";
		}	
		
		return $this->html().$this->css().$this->js();
	}
	/*###############   Model   ###############*/
	private function get_table_info($id){
		$columns_all_info=wpda_pricing_table_page::get_pricing_table($id);
		if($columns_all_info!==null){
			
			$this->widget_options=json_decode($columns_all_info->widget_options,true);
			$this->columns=json_decode($columns_all_info->columns,true);
			return true;
		}			
		return false;
	}
	/*generete themes*/
	private function get_theme_info(){
		$this->theme_ids=array();
		foreach($this->columns as $column){
			array_push($this->theme_ids,$column["theme"]);
		}
		$this->themes=wpda_pricing_table_theme_page::get_themes_by_ids($this->theme_ids);
		if($this->themes===false){
			return false;
		}
		return true;
	}

	/*###############   HTML   ###############*/
	private function html(){
		$pricing_tabel_html="";
		$pricing_tabel_html.='<div class="wpdevart_pt_main wpdevart_pt_main_'.self::$unique_sufix.'">';
		foreach($this->columns as $column){
			$pricing_tabel_html.='<div data-min-width="'.$this->themes[$column["theme"]]["column_min_width"].'" data-width="'.$this->themes[$column["theme"]]["column_width"].'" class="wpdevart_pt_column_coneiner wpdevart_pt_column_coneiner_'.$column['theme'].'">';
				if($this->themes[$column['theme']]['column_aditional_text_position']=='above_column' && $this->themes[$column['theme']]['column_aditional_text']!=''){
					$pricing_tabel_html.='<div class="wpdevart_pt_column_adit_txt wpdevart_pt_column_adit_txt_'.$column['theme'].'">'.htmlspecialchars_decode($this->themes[$column['theme']]['column_aditional_text']).'</div>';
				}
				
				$pricing_tabel_html.='<div class="wpdevart_pt_column wpdevart_pt_column_'.$column['theme'].'">';
				$pricing_tabel_html.='<div class="wpdevart_pt_name">';
				if($this->themes[$column['theme']]['column_aditional_text']!=''){
					switch($this->themes[$column['theme']]['column_aditional_text_position']){
						case "above_the_title" :
							$pricing_tabel_html.='<div class="wpdevart_pt_column_adit_txt wpdevart_pt_column_adit_txt_'.$column['theme'].'">'.htmlspecialchars_decode($this->themes[$column['theme']]['column_aditional_text']).'</div><span>'.htmlspecialchars_decode($column['title']).'</span>';
						break;
						case "below_the_title" :
							$pricing_tabel_html.='<span>'.htmlspecialchars_decode($column['title']).'</span><div class="wpdevart_pt_column_adit_txt wpdevart_pt_column_adit_txt_'.$column['theme'].'">'.htmlspecialchars_decode($this->themes[$column['theme']]['column_aditional_text']).'</div>';
						break;
						default:
							$pricing_tabel_html.='<span>'.htmlspecialchars_decode($column['title']).'</span>';
					}	
				}else{
					$pricing_tabel_html.='<span>'.htmlspecialchars_decode($column['title']).'</span>';
				}
				$pricing_tabel_html.='</div>';						
				$pricing_tabel_html.='<div class="wpdevart_pt_price">';
				if($this->themes[$column['theme']]['column_aditional_text']!=''){
					switch($this->themes[$column['theme']]['column_aditional_text_position']){
						case "above_the_price" :
							$pricing_tabel_html.='<div class="wpdevart_pt_column_adit_txt wpdevart_pt_column_adit_txt_'.$column['theme'].'">'.htmlspecialchars_decode($this->themes[$column['theme']]['column_aditional_text']).'</div><span>'.htmlspecialchars_decode($column['price']).'</span>';
						break;
						case "below_the_price" :
							$pricing_tabel_html.='<span>'.htmlspecialchars_decode($column['price']).'</span><div class="wpdevart_pt_column_adit_txt wpdevart_pt_column_adit_txt_'.$column['theme'].'">'.htmlspecialchars_decode($this->themes[$column['theme']]['column_aditional_text']).'</div>';
						break;
						default:
							$pricing_tabel_html.='<span>'.htmlspecialchars_decode($column['price']).'</span>';
					}
				}else{
					$pricing_tabel_html.='<span>'.htmlspecialchars_decode($column['price']).'</span>';
				}
				$pricing_tabel_html.='</div>';						
				$count_of_feature=count($column['feature']);
				for($k=0;$k<$count_of_feature;$k++){
					$pricing_tabel_html.='<div class="'.(($k==(0)?'wpdevart_first_feature ':'')).(($k==($count_of_feature-1))?'wpdevart_last_feature ':'').' wpdevart_pt_feature"><span>'.htmlspecialchars_decode($column['feature'][$k]).'</span></div>';
				}
				$pricing_tabel_html.='<div class="wpdevart_pt_button"><a href="'.$column['button_url'].'" >'.htmlspecialchars_decode($column['button_text']).'</a></div>';	
				$pricing_tabel_html.='</div>';	
				$pricing_tabel_html.='</div>';				
			}	
		$pricing_tabel_html.='</div>';
		return $pricing_tabel_html;
	}

	/*###############   CSS   ###############*/
	private function css(){
		$style="<style>";
		$style.='.wpdevart_pt_main_'.self::$unique_sufix.'{
			text-align:'.$this->widget_options["table_align"].';
		}';
		$style.='.wpdevart_pt_main_'.self::$unique_sufix.' .wpdevart_pt_column_coneiner{
			margin-right:'.$this->widget_options["distance_between_columns"].'px;
		}';
		$style.='.wpdevart_pt_main_'.self::$unique_sufix.' .wpdevart_pt_column_coneiner:last-child{
			margin-right:0px;
		}';
		foreach($this->themes as $theme_id => $theme){
			$visibility='';
			$this->correct_gradients($theme);
			$style.='.wpdevart_pt_main_'.self::$unique_sufix.' .wpdevart_pt_column_coneiner_'.$theme_id.'{
				width:'.$theme['column_width'].'px;
				margin-bottom:-'.$theme['column_outside_border_width']['bottom'].'px;				
				'.$visibility.'

			}';
			
			$style.='.wpdevart_pt_main_'.self::$unique_sufix.' .wpdevart_pt_column_'.$theme_id.',.wpdevart_pt_main_'.self::$unique_sufix.' .wpdevart_pt_info_group_'.$theme_id.'{
				background-image: linear-gradient('.$theme['column_bg_color']['gradient'].', '.$theme['column_bg_color']['color1'].', '.$theme['column_bg_color']['color2'].');
			}';
			
			
			$aditional_text_element_align='';
			if($theme['column_additional_text_conteiner_align']=="center"){
				$aditional_text_element_align='margin-left:auto;margin-right:auto;';
			}
			if($theme['column_additional_text_conteiner_align']=="right"){
				$aditional_text_element_align='margin-left:auto;';
			}
			$style.='.wpdevart_pt_main_'.self::$unique_sufix.' .wpdevart_pt_column_adit_txt_'.$theme_id.'{
				border-radius:'.$theme['column_additional_text_border_radius']['top'].'px '.$theme['column_additional_text_border_radius']['right'].'px '.$theme['column_additional_text_border_radius']['bottom'].'px '.$theme['column_additional_text_border_radius']['right'].'px;
				border:'.$theme['column_additional_text_border_type'].';
				border-width:'.$theme['column_additional_text_border_width'].'px;
				border-color:'.$theme['column_additional_text_border_color'].';
				color:'.$theme['column_additional_text_color'].';
				width:'.$theme['column_additional_text_conteiner_width'].'%;
				'.$aditional_text_element_align.'
				text-align:'.$theme['column_additional_text_align'].';
				font-size:'.$theme['column_additional_text_font_size'].'px;
				font-family:'.$theme['column_additional_text_font_family'].';
				padding:'.$theme['column_additional_text_padding']['top'].'px '.$theme['column_additional_text_padding']['right'].'px '.$theme['column_additional_text_padding']['bottom'].'px '.$theme['column_additional_text_padding']['left'].'px;
				margin-top:'.$theme['column_additional_text_distance_top_bottom']['top'].'px;
				margin-bottom:'.$theme['column_additional_text_distance_top_bottom']['bottom'].'px;';
				$style.='background-image: linear-gradient('.$theme['column_additional_text_bg_color']['gradient'].', '.$theme['column_additional_text_bg_color']['color1'].', '.$theme['column_additional_text_bg_color']['color2'].');';
			
			$style.='}';
			$style.='.wpdevart_pt_main_'.self::$unique_sufix.' .wpdevart_pt_column_'.$theme_id.'{
				border:'.$theme['column_outside_border_type'].';
				border-top-width:'.$theme['column_outside_border_width']['top'].'px;
				border-right-width:'.$theme['column_outside_border_width']['right'].'px;
				border-bottom-width:'.$theme['column_outside_border_width']['bottom'].'px;
				border-left-width:'.$theme['column_outside_border_width']['left'].'px;
				border-color:'.$theme['column_outside_border_color'].';
				border-radius:'.$theme['column_outside_border_radius']['top'].'px '.$theme['column_outside_border_radius']['right'].'px '.$theme['column_outside_border_radius']['bottom'].'px '.$theme['column_outside_border_radius']['left'].'px;
				text-align:'.$theme['text_align'].';
			}';
			
			$style.='.wpdevart_pt_main_'.self::$unique_sufix.' .wpdevart_pt_info_group_'.$theme_id.'{
				border:'.$theme['column_outside_border_type'].';
				border-top-width:'.$theme['column_outside_border_width']['top'].'px;
				border-right-width:'.$theme['column_outside_border_width']['right'].'px;
				border-bottom-width:'.$theme['column_outside_border_width']['bottom'].'px;
				border-left-width:'.$theme['column_outside_border_width']['left'].'px;
				border-color:'.$theme['column_outside_border_color'].';
				border-radius:'.$theme['column_outside_border_radius']['top'].'px '.$theme['column_outside_border_radius']['right'].'px '.$theme['column_outside_border_radius']['bottom'].'px '.$theme['column_outside_border_radius']['left'].'px;
				text-align:'.$theme['text_align'].';
				overflow: hidden;
			}';
			
			$style.='.wpdevart_pt_main_'.self::$unique_sufix.' .wpdevart_pt_column_'.$theme_id.' .wpdevart_pt_name{
				color:'.$theme['column_title_txt_color'].';
				font-size:'.$theme['column_title_font_size'].'px;
				font-family:'.$theme['column_title_font_family'].'px;
				border:'.$theme['column_title_border_type'].';
				border-color:'.$theme['column_title_border_color'].';				
				border-width:'.$theme['column_title_top_bottom_border_wdith']['top'].'px 0px '.$theme['column_title_top_bottom_border_wdith']['bottom'].'px 0px;
				padding:'.$theme['column_title_padding']['top'].'px '.$theme['column_title_padding']['right'].'px '.$theme['column_title_padding']['bottom'].'px '.$theme['column_title_padding']['left'].'px;
				margin:'.$theme['column_title_margin']['top'].'px '.$theme['column_title_margin']['right'].'px '.$theme['column_title_margin']['bottom'].'px '.$theme['column_title_margin']['left'].'px;';
				$style.='background-image: linear-gradient('.$theme['column_title_bg_color']['gradient'].', '.$theme['column_title_bg_color']['color1'].', '.$theme['column_title_bg_color']['color2'].');';
			
			$style.='}';
			$style.='.wpdevart_pt_main_'.self::$unique_sufix.' .wpdevart_pt_column_'.$theme_id.' .wpdevart_pt_price{
				color:'.$theme['column_price_txt_color'].';
				font-size:'.$theme['column_price_font_size'].'px;
				font-family:'.$theme['column_price_font_family'].'px;
				border:'.$theme['column_price_border_type'].';
				border-color:'.$theme['column_price_border_color'].';				
				border-width:'.$theme['column_price_top_bottom_border_wdith']['top'].'px 0px '.$theme['column_price_top_bottom_border_wdith']['bottom'].'px 0px;
				padding:'.$theme['column_price_padding']['top'].'px '.$theme['column_price_padding']['right'].'px '.$theme['column_price_padding']['bottom'].'px '.$theme['column_price_padding']['left'].'px;
				margin:'.$theme['column_price_margin']['top'].'px '.$theme['column_price_margin']['right'].'px '.$theme['column_price_margin']['bottom'].'px '.$theme['column_price_margin']['left'].'px;';
				$style.='background-image: linear-gradient('.$theme['column_price_bg_color']['gradient'].', '.$theme['column_price_bg_color']['color1'].', '.$theme['column_price_bg_color']['color2'].');';
			$style.='}';
			$style.='.wpdevart_pt_main_'.self::$unique_sufix.' .wpdevart_pt_column_'.$theme_id.' .wpdevart_pt_feature{
				color:'.$theme['column_feature_txt_color'].';
				font-size:'.$theme['column_feature_font_size'].'px;
				font-family:'.$theme['column_feature_font_family'].';
				padding:'.$theme['column_feature_padding']['top'].'px '.$theme['column_feature_padding']['right'].'px '.$theme['column_feature_padding']['bottom'].'px '.$theme['column_feature_padding']['left'].'px;
				margin:'.$theme['column_feature_margin']['top'].'px '.$theme['column_feature_margin']['right'].'px '.$theme['column_feature_margin']['bottom'].'px '.$theme['column_feature_margin']['left'].'px;
				border:'.$theme['column_feature_border_type'].';
				border-color:'.$theme['column_feature_border_color'].';				
				border-width:'.$theme['column_feature_top_bottom_border_wdith']['top'].'px 0px '.$theme['column_feature_top_bottom_border_wdith']['bottom'].'px 0px;';
				$style.='background-image: linear-gradient('.$theme['column_feature_bg_color']['gradient'].', '.$theme['column_feature_bg_color']['color1'].', '.$theme['column_feature_bg_color']['color2'].');';
			$style.='}';
			
			$style.='.wpdevart_pt_main_'.self::$unique_sufix.' .wpdevart_pt_info_group_'.$theme_id.' .wpdevart_pt_feature{
				color:'.$theme['column_feature_txt_color'].';
				font-size:'.$theme['column_feature_font_size'].'px;
				font-family:'.$theme['column_feature_font_family'].'px;
				padding:'.$theme['column_feature_padding']['top'].'px '.$theme['column_feature_padding']['right'].'px '.$theme['column_feature_padding']['bottom'].'px '.$theme['column_feature_padding']['left'].'px;
				margin:'.$theme['column_feature_margin']['top'].'px '.$theme['column_feature_margin']['right'].'px '.$theme['column_feature_margin']['bottom'].'px '.$theme['column_feature_margin']['left'].'px;
				border:'.$theme['column_feature_border_type'].';
				border-color:'.$theme['column_feature_border_color'].';				
				border-width:'.$theme['column_feature_top_bottom_border_wdith']['top'].'px 0px '.$theme['column_feature_top_bottom_border_wdith']['bottom'].'px 0px;';
				$style.='background-image: linear-gradient('.$theme['column_feature_bg_color']['gradient'].', '.$theme['column_feature_bg_color']['color1'].', '.$theme['column_feature_bg_color']['color2'].');';
			$style.='}';
			$style.=$this->generete_button_css($theme,$theme_id);
		}
		
		$style.="</style>";
		return $style;
	}

	/*###################### Button CSS function ##################*/		
	
	private function generete_button_css($theme,$theme_id){
		$style='';
		$style.='.wpdevart_pt_main_'.self::$unique_sufix.' .wpdevart_pt_column_'.$theme_id.' .wpdevart_pt_button{		
			padding:'.$theme['column_button_row_padding']['top'].'px '.$theme['column_button_row_padding']['right'].'px '.$theme['column_button_row_padding']['bottom'].'px '.$theme['column_button_row_padding']['left'].'px;
			margin:'.$theme['column_button_row_margin']['top'].'px '.$theme['column_button_row_margin']['right'].'px '.$theme['column_button_row_margin']['bottom'].'px '.$theme['column_button_row_margin']['left'].'px;
			border:'.$theme['column_button_row_border_type'].';
			border-color:'.$theme['column_button_row_border_color'].';				
			border-width:'.$theme['column_button_row_top_bottom_border_wdith']['top'].'px 0px '.$theme['column_button_row_top_bottom_border_wdith']['bottom'].'px 0px;';
			$style.='background-image: linear-gradient('.$theme['column_button_bg_row_color']['gradient'].', '.$theme['column_button_bg_row_color']['color1'].', '.$theme['column_button_bg_row_color']['color2'].');';
			$style.='}';
			$style.='.wpdevart_pt_main_'.self::$unique_sufix.' .wpdevart_pt_column_'.$theme_id.' .wpdevart_pt_button a{
					display:inline-block;
					color:'.$theme['column_button_txt_color'].';
					padding:'.$theme['column_button_padding']['top'].'px '.$theme['column_button_padding']['right'].'px '.$theme['column_button_padding']['bottom'].'px '.$theme['column_button_padding']['left'].'px;
					margin:'.$theme['column_button_margin']['top'].'px '.$theme['column_button_margin']['right'].'px '.$theme['column_button_margin']['bottom'].'px '.$theme['column_button_margin']['left'].'px;
					font-size:'.$theme['column_button_font_size'].'px;
					font-family:'.$theme['column_button_font_family'].'px;
					border-radius:'.$theme['column_button_border_radius'].'px;
					border:'.$theme['column_button_border_type'].';
					border-width:'.$theme['column_button_border_width'].'px;
					border-color:'.$theme['column_button_border_color'].';';
					$style.='background-image: linear-gradient('.$theme['column_button_bg_color']['gradient'].', '.$theme['column_button_bg_color']['color1'].', '.$theme['column_button_bg_color']['color2'].');';
				$style.='}';
				$style.='.wpdevart_pt_main_'.self::$unique_sufix.' .wpdevart_pt_column_'.$theme_id.' .wpdevart_pt_button a:hover{
					color:'.$theme['column_button_txt_color_hover'].';
					border-color:'.$theme['column_button_border_color_hover'].';';
					$style.='background-image: linear-gradient('.$theme['column_button_bg_color_hover']['gradient'].', '.$theme['column_button_bg_color_hover']['color1'].', '.$theme['column_button_bg_color_hover']['color2'].');';
			$style.='}';
		return $style;	
	}
	private function js(){
		$js='';
		$js.= "<script>jQuery(document).ready(function(){
			";
		$js.= "jQuery('.wpdevart_pt_main.wpdevart_pt_main_".self::$unique_sufix."').wpdevart_pricing_table();
		})</script>";
		return $js;
	}
	
	/*###################### Correct gradients function ##################*/		
	
	private function correct_gradients(&$theme){
		$gradient_lists=['column_bg_color','column_title_bg_color','column_price_bg_color','column_feature_bg_color','column_feature_odd_bg_color','column_additional_text_bg_color','column_button_bg_row_color','column_button_bg_color','column_button_bg_color_hover'];
		foreach($gradient_lists as $gradient_elem){
			if($theme[$gradient_elem]['gradient']=='none'){
				$theme[$gradient_elem]['color2']=$theme[$gradient_elem]['color1'];
				$theme[$gradient_elem]['gradient']='to right';
			}
		}
	}
}