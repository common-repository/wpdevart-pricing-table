<?php
class wpda_pricing_table_theme_page{
	
	private $options;
	
	function __construct(){		
		$this->options=self::return_params_array();	
	}
	public static function get_theme_id_and_name(){
		global $wpdb;
		$query = "SELECT `id`,`name`,`default` FROM ".wpda_pricing_table_databese::$table_names['theme'];
		$rows=$wpdb->get_results($query,ARRAY_A);
		return $rows;
	}
	private function aaaa(&$test){
		$test++;
	}
	
	/*###################### Return params function ##################*/		
	
	public static function return_params_array(){	
		return array(
			"theme_general"=>array(
				"heading_name"=>__("General Settings","wpdevart_pricing_table"),
				"params"=>array(
					"column_type"=>array(
						"title"=>__("Column type","wpdevart_pricing_table"),
						"description"=>__("Select the Column Type","wpdevart_pricing_table"),				
						"function_name"=>"simple_select",
						"values"=>array("normal"=>__("Normal","wpdevart_pricing_table"),"only_info"=>__("Only Info","wpdevart_pricing_table")),
						"default_value"=>"normal",
						'pro'=>true,
					),
					"column_width"=>array(
						"title"=>__("Column width","wpdevart_pricing_table"),
						"description"=>__("Type the column width","wpdevart_pricing_table"),				
						"function_name"=>"simple_input",
						"default_value"=>"220",
						"small_text"=>"px"
					),
					"column_min_width"=>array(
						"title"=>__("Column minimum width","wpdevart_pricing_table"),
						"description"=>__("Type the column minimum width","wpdevart_pricing_table"),				
						"function_name"=>"simple_input",
						"default_value"=>"160",
						"small_text"=>"px"
					),
					"column_scale"=>array(
						"title"=>__("Column scale","wpdevart_pricing_table"),
						"description"=>__("Set the column scale","wpdevart_pricing_table"),				
						"function_name"=>"range_input",
						"small_text"=>"(%)",	
						"default_value"=>"0",
						"pro"=>true,
					),
					"column_bg_color"=>array(
						"title"=>__("Background color","wpdevart_pricing_table"),
						"description"=>__("Set the background color of the title","wpdevart_pricing_table"),				
						"function_name"=>"gradient_color_input",
						"values"=>array("color1"=>"","color2"=>"","gradient"=>"0"),
						"pro_grad"=>true,
						"default_value"=>array("color1"=>"rgba(255,255,255,0)","color2"=>"rgba(255,255,255,0)","gradient"=>"none"),
						
					),
					"column_outside_box_shadow"=>array(
						"title"=>__("Column outside box shadow","wpdevart_pricing_table"),
						"description"=>__("Set the column outside box shadow","wpdevart_pricing_table"),				
						"function_name"=>"simple_input",
						"placeholder"=>"5px 5px 10px #dddddd",
						"default_value"=>"",
						'pro'=>true,
					),
					"column_outside_border_type"=>array(
						"title"=>__("Column outside border type","wpdevart_pricing_table"),
						"description"=>__("Select the border type","wpdevart_pricing_table"),				
						"function_name"=>"simple_select",
						"values"=>array("solid"=>__("Solid","wpdevart_pricing_table"),"dotted"=>__("Dotted","wpdevart_pricing_table"),"dashed"=>__("Dashed","wpdevart_pricing_table"),"double"=>__("Double","wpdevart_pricing_table"),"groove"=>__("Groove","wpdevart_pricing_table"),"ridge"=>__("Ridge","wpdevart_pricing_table"),"inset"=>__("Inset","wpdevart_pricing_table"),"outset"=>__("Outset","wpdevart_pricing_table")),
						"default_value"=>"solid",
					),
					"column_outside_border_width"=>array(
						"title"=>__("Column outside border width","wpdevart_pricing_table"),
						"description"=>__("Type here the width of the column outside border","wpdevart_pricing_table"),				
						"function_name"=>"padding_margin_input",
						"values"=>array("top"=>"0","right"=>"0","bottom"=>"0","left"=>"0"),
						"default_value"=>array("top"=>"1","right"=>"1","bottom"=>"1","left"=>"1"),
					),
					"column_outside_border_color"=>array(
						"title"=>__("Column outside border color","wpdevart_pricing_table"),
						"description"=>__("Set the width of the column outside border color","wpdevart_pricing_table"),
						"default_value"=>"#000000",
						"function_name"=>"color_input",
					),
					"column_outside_border_radius"=>array(
						"title"=>__("Column outside border radius","wpdevart_pricing_table"),
						"description"=>__("Type here the column outside border radius","wpdevart_pricing_table"),				
						"function_name"=>"padding_margin_input",
						"values"=>array("top"=>"0","right"=>"0","bottom"=>"0","left"=>"0"),
						"default_value"=>array("top"=>"5","right"=>"0","bottom"=>"5","left"=>"0"),
					),
					"text_align"=>array(
						"title"=>__("Text align","wpdevart_pricing_table"),
						"description"=>__("Select the horizontal alignment for texts","wpdevart_pricing_table"),				
						"function_name"=>"simple_select",
						"values"=>array("left"=>__("Left","wpdevart_pricing_table"),"center"=>__("Center","wpdevart_pricing_table"),"right"=>__("Right","wpdevart_pricing_table")),
						"default_value"=>"center",
					),					
				)
			),
			"content_styling"=>array(
				"heading_name"=>__("Content Styling","wpdevart_pricing_table"),
				"params"=>array(					
					"column_title_bg_color"=>array(
						"title"=>__("Title background color","wpdevart_pricing_table"),
						"description"=>__("Type here title background color","wpdevart_pricing_table"),				
						"function_name"=>"gradient_color_input",
						"values"=>array("color1"=>"","color2"=>"","gradient"=>""),
						"pro_grad"=>true,
						"default_value"=>array("color1"=>"rgba(255,255,255,0)","color2"=>"rgba(255,255,255,0)","gradient"=>"none"),
					),
					"column_title_txt_color"=>array(
						"title"=>__("Title text color","wpdevart_pricing_table"),
						"description"=>__("Type here title text color","wpdevart_pricing_table"),
						"default_value"=>"#000000",
						"function_name"=>"color_input",
					),
					"column_title_font_size"=>array(
						"title"=>__("Title font size","wpdevart_pricing_table"),
						"description"=>__("Type here title font size","wpdevart_pricing_table"),				
						"function_name"=>"simple_input",
						"default_value"=>"18",
						"small_text"=>"px"
					),
					"column_title_font_family"=>array(
						"title"=>__("Title font family","wpdevart_pricing_table"),
						"description"=>__("Type here Title font family","wpdevart_pricing_table"),				
						"function_name"=>"font_select",
						"values"=>wpda_pricing_table_library::fonts_select(),
						"default_value"=>"Arial,Helvetica Neue,Helvetica,sans-serif",
					),
					"column_title_padding"=>array(
						"title"=>__("Title padding","wpdevart_pricing_table"),
						"description"=>__("Type here title padding","wpdevart_pricing_table"),				
						"function_name"=>"padding_margin_input",
						"values"=>array("top"=>"0","right"=>"0","bottom"=>"0","left"=>"0"),
						"default_value"=>array("top"=>"5","right"=>"0","bottom"=>"5","left"=>"0"),
					),
					"column_title_margin"=>array(
						"title"=>__("Title margin","wpdevart_pricing_table"),
						"description"=>__("Type here title margin","wpdevart_pricing_table"),				
						"function_name"=>"padding_margin_input",
						"values"=>array("top"=>"0","right"=>"0","bottom"=>"0","left"=>"0"),
						"default_value"=>array("top"=>"0","right"=>"0","bottom"=>"0","left"=>"0"),
					),
					"column_title_border_type"=>array(
						"title"=>__("Title border type","wpdevart_pricing_table"),
						"description"=>__("Select title border type","wpdevart_pricing_table"),				
						"function_name"=>"simple_select",
						"values"=>array("solid"=>__("Solid","wpdevart_pricing_table"),"dotted"=>__("Dotted","wpdevart_pricing_table"),"dashed"=>__("Dashed","wpdevart_pricing_table"),"double"=>__("Double","wpdevart_pricing_table"),"groove"=>__("Groove","wpdevart_pricing_table"),"ridge"=>__("Ridge","wpdevart_pricing_table"),"inset"=>__("Inset","wpdevart_pricing_table"),"outset"=>__("Outset","wpdevart_pricing_table")),
						"default_value"=>"solid",
					),
					"column_title_top_bottom_border_wdith"=>array(
						"title"=>__("Title border width","wpdevart_pricing_table"),
						"description"=>__("Type here title border width","wpdevart_pricing_table"),				
						"function_name"=>"padding_margin_input",
						"values"=>array("top"=>"0","bottom"=>"0"),
						"default_value"=>array("top"=>"0","bottom"=>"0"),
					),
					"column_title_border_color"=>array(
						"title"=>__("Title border color","wpdevart_pricing_table"),
						"description"=>__("Type here title border color","wpdevart_pricing_table"),
						"default_value"=>"#cccccc",
						"function_name"=>"color_input",
					),
					"column_price_bg_color"=>array(
						"title"=>__("Price background color","wpdevart_pricing_table"),
						"description"=>__("Type here price background color","wpdevart_pricing_table"),
						"function_name"=>"gradient_color_input",
						"values"=>array("color1"=>"","color2"=>"","gradient"=>""),
						"pro_grad"=>true,
						"default_value"=>array("color1"=>"rgba(255,255,255,0)","color2"=>"rgba(255,255,255,0)","gradient"=>"none"),
					),
					"column_price_txt_color"=>array(
						"title"=>__("Price text color","wpdevart_pricing_table"),
						"description"=>__("Type here price text color","wpdevart_pricing_table"),
						"default_value"=>"#000000",
						"function_name"=>"color_input",
					),
					"column_price_font_size"=>array(
						"title"=>__("Price font size","wpdevart_pricing_table"),
						"description"=>__("Type here price font size","wpdevart_pricing_table"),				
						"function_name"=>"simple_input",
						"default_value"=>"18",
						"small_text"=>"px"
					),
					"column_price_font_family"=>array(
						"title"=>__("Price font family","wpdevart_pricing_table"),
						"description"=>__("Type here price font family","wpdevart_pricing_table"),				
						"function_name"=>"font_select",
						"values"=>wpda_pricing_table_library::fonts_select(),
						"default_value"=>"Arial,Helvetica Neue,Helvetica,sans-serif",
					),
					"column_price_padding"=>array(
						"title"=>__("Price padding","wpdevart_pricing_table"),
						"description"=>__("Type here price padding","wpdevart_pricing_table"),				
						"function_name"=>"padding_margin_input",
						"values"=>array("top"=>"0","right"=>"0","bottom"=>"0","left"=>"0"),
						"default_value"=>array("top"=>"5","right"=>"0","bottom"=>"5","left"=>"0"),
					),
					"column_price_margin"=>array(
						"title"=>__("Price margin","wpdevart_pricing_table"),
						"description"=>__("Type here price margin","wpdevart_pricing_table"),				
						"function_name"=>"padding_margin_input",
						"values"=>array("top"=>"0","right"=>"0","bottom"=>"0","left"=>"0"),
						"default_value"=>array("top"=>"0","right"=>"0","bottom"=>"0","left"=>"0"),
					),
					"column_price_border_type"=>array(
						"title"=>__("Price border type","wpdevart_pricing_table"),
						"description"=>__("Select price border type","wpdevart_pricing_table"),				
						"function_name"=>"simple_select",
						"values"=>array("solid"=>__("Solid","wpdevart_pricing_table"),"dotted"=>__("Dotted","wpdevart_pricing_table"),"dashed"=>__("Dashed","wpdevart_pricing_table"),"double"=>__("Double","wpdevart_pricing_table"),"groove"=>__("Groove","wpdevart_pricing_table"),"ridge"=>__("Ridge","wpdevart_pricing_table"),"inset"=>__("Inset","wpdevart_pricing_table"),"outset"=>__("Outset","wpdevart_pricing_table")),
						"default_value"=>"solid",
					),
					"column_price_top_bottom_border_wdith"=>array(
						"title"=>__("Price border width","wpdevart_pricing_table"),
						"description"=>__("Type here price border width","wpdevart_pricing_table"),				
						"function_name"=>"padding_margin_input",
						"values"=>array("top"=>"0","bottom"=>"0"),
						"default_value"=>array("top"=>"0","bottom"=>"0"),
					),
					"column_price_border_color"=>array(
						"title"=>__("Price border color","wpdevart_pricing_table"),
						"description"=>__("Type here price border color","wpdevart_pricing_table"),
						"default_value"=>"#cccccc",
						"function_name"=>"color_input",
					),
					"column_feature_bg_color"=>array(
						"title"=>__("Feature background color","wpdevart_pricing_table"),
						"description"=>__("Type here feature background color","wpdevart_pricing_table"),
						"function_name"=>"gradient_color_input",
						"values"=>array("color1"=>"","color2"=>"","gradient"=>""),
						"pro_grad"=>true,
						"default_value"=>array("color1"=>"rgba(255,255,255,0)","color2"=>"rgba(255,255,255,0)","gradient"=>"none"),
					),
					"column_feature_odd_bg_color"=>array(
						"title"=>__("Feature odd background color","wpdevart_pricing_table"),
						"description"=>__("Type here feature odd background color","wpdevart_pricing_table"),
						"function_name"=>"gradient_color_input",
						"pro"=>true,
						"values"=>array("color1"=>"","color2"=>"","gradient"=>""),
						"default_value"=>array("color1"=>"rgba(255,255,255,0)","color2"=>"rgba(255,255,255,0)","gradient"=>"none"),
					),
					"column_feature_txt_color"=>array(
						"title"=>__("Feature text color","wpdevart_pricing_table"),
						"description"=>__("Type here feature text color","wpdevart_pricing_table"),
						"default_value"=>"#000000",
						"function_name"=>"color_input",
					),
					"column_feature_font_size"=>array(
						"title"=>__("Feature font size","wpdevart_pricing_table"),
						"description"=>__("Type here feature font size","wpdevart_pricing_table"),				
						"function_name"=>"simple_input",
						"default_value"=>"18",
						"small_text"=>"px"
					),
					"column_feature_font_family"=>array(
						"title"=>__("Feature font family","wpdevart_pricing_table"),
						"description"=>__("Type here feature font family","wpdevart_pricing_table"),				
						"function_name"=>"font_select",
						"values"=>wpda_pricing_table_library::fonts_select(),
						"default_value"=>"Arial,Helvetica Neue,Helvetica,sans-serif",
					),
					"column_feature_padding"=>array(
						"title"=>__("Feature padding","wpdevart_pricing_table"),
						"description"=>__("Type here feature padding","wpdevart_pricing_table"),				
						"function_name"=>"padding_margin_input",
						"values"=>array("top"=>"0","right"=>"0","bottom"=>"0","left"=>"0"),
						"default_value"=>array("top"=>"5","right"=>"0","bottom"=>"5","left"=>"0"),
					),
					"column_feature_margin"=>array(
						"title"=>__("Feature margin","wpdevart_pricing_table"),
						"description"=>__("Type here feature margin","wpdevart_pricing_table"),				
						"function_name"=>"padding_margin_input",
						"values"=>array("top"=>"0","right"=>"0","bottom"=>"0","left"=>"0"),
						"default_value"=>array("top"=>"0","right"=>"15","bottom"=>"0","left"=>"15"),
					),
					"column_feature_border_type"=>array(
						"title"=>__("Feature border type","wpdevart_pricing_table"),
						"description"=>__("Select feature border type","wpdevart_pricing_table"),				
						"function_name"=>"simple_select",
						"values"=>array("solid"=>__("Solid","wpdevart_pricing_table"),"dotted"=>__("Dotted","wpdevart_pricing_table"),"dashed"=>__("Dashed","wpdevart_pricing_table"),"double"=>__("Double","wpdevart_pricing_table"),"groove"=>__("Groove","wpdevart_pricing_table"),"ridge"=>__("Ridge","wpdevart_pricing_table"),"inset"=>__("Inset","wpdevart_pricing_table"),"outset"=>__("Outset","wpdevart_pricing_table")),
						"default_value"=>"solid",
					),
					"column_feature_top_bottom_border_wdith"=>array(
						"title"=>__("Feature border width","wpdevart_pricing_table"),
						"description"=>__("Type here feature border width","wpdevart_pricing_table"),				
						"function_name"=>"padding_margin_input",
						"values"=>array("top"=>"0","bottom"=>"0"),
						"default_value"=>array("top"=>"5","bottom"=>"5"),
					),
					"column_feature_border_color"=>array(
						"title"=>__("Feature border color","wpdevart_pricing_table"),
						"description"=>__("Type here feature border color","wpdevart_pricing_table"),
						"default_value"=>"#cccccc",
						"function_name"=>"color_input",
					)
					
				),
			),
			"additional_text_styling"=>array(
				"heading_name"=>__("Additional Text","wpdevart_pricing_table"),
				"params"=>array(
				"column_aditional_text"=>array(
						"title"=>__("Column top additional text","wpdevart_pricing_table"),
						"description"=>__("Type here additional text for showing at the top of the column. It can be the best price or favorite or other text","wpdevart_pricing_table"),				
						"function_name"=>"simple_input",
						"default_value"=>"",
					),
					"column_aditional_text_position"=>array(
						"title"=>__("Additional text position","wpdevart_pricing_table"),
						"description"=>__("Select the additional text position","wpdevart_pricing_table"),				
						"function_name"=>"simple_select",
						"values"=>array("above_column"=>__("Above the column","wpdevart_pricing_table"),"above_the_title"=>__("Above the title","wpdevart_pricing_table"),"below_the_title"=>__("Below the title","wpdevart_pricing_table"),"above_the_price"=>__("Above the price","wpdevart_pricing_table"),"below_the_price"=>__("Below the price","wpdevart_pricing_table")),
						"default_value"=>"center",
					),
					"column_additional_text_border_type"=>array(
						"title"=>__("Column additional text border type","wpdevart_pricing_table"),
						"description"=>__("Select column additional text border type","wpdevart_pricing_table"),				
						"function_name"=>"simple_select",
						"values"=>array("solid"=>__("Solid","wpdevart_pricing_table"),"dotted"=>__("Dotted","wpdevart_pricing_table"),"dashed"=>__("Dashed","wpdevart_pricing_table"),"double"=>__("Double","wpdevart_pricing_table"),"groove"=>__("Groove","wpdevart_pricing_table"),"ridge"=>__("Ridge","wpdevart_pricing_table"),"inset"=>__("Inset","wpdevart_pricing_table"),"outset"=>__("Outset","wpdevart_pricing_table")),
						"default_value"=>"solid",
					),
					"column_additional_text_border_width"=>array(
						"title"=>__("Column additional text border width","wpdevart_pricing_table"),
						"description"=>__("Type here column additional text border width","wpdevart_pricing_table"),				
						"function_name"=>"simple_input",
						"default_value"=>"1",
						"small_text"=>"px"
					),
					"column_additional_text_border_color"=>array(
						"title"=>__("Column additional text border color","wpdevart_pricing_table"),
						"description"=>__("Type here column additional text border color","wpdevart_pricing_table"),
						"default_value"=>"#000000",
						"function_name"=>"color_input",
					),
					"column_additional_text_border_radius"=>array(
						"title"=>__("Column additional text border radius","wpdevart_pricing_table"),
						"description"=>__("Type here column additional text border radius","wpdevart_pricing_table"),				
						"function_name"=>"padding_margin_input",
						"values"=>array("top"=>"0","right"=>"0","bottom"=>"0","left"=>"0"),
						"default_value"=>array("top"=>"5","right"=>"0","bottom"=>"5","left"=>"0"),
					),
					"column_additional_text_bg_color"=>array(
						"title"=>__("Column additional text background color","wpdevart_pricing_table"),
						"description"=>__("Type here column additional text background color","wpdevart_pricing_table"),
						"function_name"=>"gradient_color_input",
						"values"=>array("color1"=>"","color2"=>"","gradient"=>""),
						"pro_grad"=>true,
						"default_value"=>array("color1"=>"rgba(255,255,255,0)","color2"=>"rgba(255,255,255,0)","gradient"=>"none"),
					),
					"column_additional_text_color"=>array(
						"title"=>__("Column additional text color","wpdevart_pricing_table"),
						"description"=>__("Type here column additional text color","wpdevart_pricing_table"),
						"default_value"=>"#ffffff",
						"function_name"=>"color_input",
					),
					"column_additional_text_conteiner_width"=>array(
						"title"=>__("Column additional text element width","wpdevart_pricing_table"),
						"description"=>__("Type here column additional text element width","wpdevart_pricing_table"),
						"function_name"=>"simple_input",
						"default_value"=>"100",
						"small_text"=>"(%)"
					),
					"column_additional_text_conteiner_align"=>array(
						"title"=>__("Column additional text element position","wpdevart_pricing_table"),
						"description"=>__("Type here column additional text element position","wpdevart_pricing_table"),
						"function_name"=>"simple_select",
						"values"=>array("left"=>__("Left","wpdevart_pricing_table"),"center"=>__("Center","wpdevart_pricing_table"),"right"=>__("Right","wpdevart_pricing_table")),
						"default_value"=>"center",
					),
					"column_additional_text_align"=>array(
						"title"=>__("Column additional text position","wpdevart_pricing_table"),
						"description"=>__("Type here column additional text position","wpdevart_pricing_table"),
						"function_name"=>"simple_select",
						"values"=>array("left"=>__("Left","wpdevart_pricing_table"),"center"=>__("Center","wpdevart_pricing_table"),"right"=>__("Right","wpdevart_pricing_table")),
						"default_value"=>"center",
					),
					"column_additional_text_font_size"=>array(
						"title"=>__("Column additional text font size","wpdevart_pricing_table"),
						"description"=>__("Type here column additional text font size","wpdevart_pricing_table"),				
						"function_name"=>"simple_input",
						"default_value"=>"18",
						"small_text"=>"px"
					),
					"column_additional_text_font_family"=>array(
						"title"=>__("Column additional text font family","wpdevart_pricing_table"),
						"description"=>__("Type here column additional text font family","wpdevart_pricing_table"),				
						"function_name"=>"font_select",
						"values"=>wpda_pricing_table_library::fonts_select(),
						"default_value"=>"Arial,Helvetica Neue,Helvetica,sans-serif",
					),
					"column_additional_text_font_size"=>array(
						"title"=>__("Column additional text font size","wpdevart_pricing_table"),
						"description"=>__("Type here column additional text font size","wpdevart_pricing_table"),				
						"function_name"=>"simple_input",
						"default_value"=>"18",
						"small_text"=>"px"
					),
					"column_additional_text_distance_top_bottom"=>array(
						"title"=>__("Column additional text distance from top and bottom","wpdevart_pricing_table"),
						"description"=>__("Type here column additional text distance from top and bottom","wpdevart_pricing_table"),				
						"function_name"=>"padding_margin_input",
						"values"=>array("top"=>"0","bottom"=>"0"),
						"default_value"=>array("top"=>"5","bottom"=>"5"),
					),
					"column_additional_text_padding"=>array(
						"title"=>__("Column additional text padding","wpdevart_pricing_table"),
						"description"=>__("Type here column additional text padding","wpdevart_pricing_table"),				
						"function_name"=>"padding_margin_input",
						"values"=>array("top"=>"0","right"=>"0","bottom"=>"0","left"=>"0"),
						"default_value"=>array("top"=>"5","right"=>"0","bottom"=>"5","left"=>"0"),
					)
				)
			),
			"button_styling"=>array(
				"heading_name"=>__("Button Styling","wpdevart_pricing_table"),
				"params"=>array(	
					"column_button_bg_row_color"=>array(
						"title"=>__("Button row background color","wpdevart_pricing_table"),
						"description"=>__("Type here button row background color","wpdevart_pricing_table"),
						"function_name"=>"gradient_color_input",
						"values"=>array("color1"=>"","color2"=>"","gradient"=>""),
						"pro_grad"=>true,
						"default_value"=>array("color1"=>"rgba(255,255,255,0)","color2"=>"rgba(255,255,255,0)","gradient"=>"none"),
					),
					"column_button_row_padding"=>array(
						"title"=>__("Button row padding","wpdevart_pricing_table"),
						"description"=>__("Type here button padding","wpdevart_pricing_table"),				
						"function_name"=>"padding_margin_input",
						"values"=>array("top"=>"0","right"=>"0","bottom"=>"0","left"=>"0"),
						"default_value"=>array("top"=>"5","right"=>"0","bottom"=>"5","left"=>"0"),
					),
					"column_button_row_margin"=>array(
						"title"=>__("Button row margin","wpdevart_pricing_table"),
						"description"=>__("Type here button margin","wpdevart_pricing_table"),				
						"function_name"=>"padding_margin_input",
						"values"=>array("top"=>"0","right"=>"0","bottom"=>"0","left"=>"0"),
						"default_value"=>array("top"=>"0","right"=>"0","bottom"=>"0","left"=>"0"),
					),
					"column_button_row_border_type"=>array(
						"title"=>__("Button row border type","wpdevart_pricing_table"),
						"description"=>__("Select button border type","wpdevart_pricing_table"),				
						"function_name"=>"simple_select",
						"values"=>array("solid"=>__("Solid","wpdevart_pricing_table"),"dotted"=>__("Dotted","wpdevart_pricing_table"),"dashed"=>__("Dashed","wpdevart_pricing_table"),"double"=>__("Double","wpdevart_pricing_table"),"groove"=>__("Groove","wpdevart_pricing_table"),"ridge"=>__("Ridge","wpdevart_pricing_table"),"inset"=>__("Inset","wpdevart_pricing_table"),"outset"=>__("Outset","wpdevart_pricing_table")),
						"default_value"=>"solid",
					),
					"column_button_row_top_bottom_border_wdith"=>array(
						"title"=>__("Button row border width","wpdevart_pricing_table"),
						"description"=>__("Type here button border width","wpdevart_pricing_table"),				
						"function_name"=>"padding_margin_input",
						"values"=>array("top"=>"0","bottom"=>"0"),
						"default_value"=>array("top"=>"0","bottom"=>"0"),
					),
					"column_button_row_border_color"=>array(
						"title"=>__("Button row border color","wpdevart_pricing_table"),
						"description"=>__("Type here button border color","wpdevart_pricing_table"),
						"default_value"=>"#cccccc",
						"function_name"=>"color_input",
					),
					"column_button_themes"=>array(
						"title"=>__("Button hover style","wpdevart_pricing_table"),
						"description"=>__("Select the button style","wpdevart_pricing_table"),				
						"function_name"=>"simple_select",
						'pro'=>true,
						"values"=>array(
							"standart"=>__("Standard","wpdevart_pricing_table"),
							"Sliding_background"=>array(
								"type_1_from_left"=>__("Slide from left","wpdevart_pricing_table"),
								"type_1_from_right"=>__("Slide from right","wpdevart_pricing_table"),
								"type_1_from_top"=>__("Slide from top","wpdevart_pricing_table"),
								"type_1_from_bottom"=>__("Slide from bottom","wpdevart_pricing_table"),
								"type_1_from_middle"=>__("Slide from middle","wpdevart_pricing_table"),
							),
							"Loading_border_animation"=>array(
								"type_2_animation_border_bottom"=>__("Border bottom","wpdevart_pricing_table"),
								"type_2_animation_border_top"=>__("Border top","wpdevart_pricing_table")
							),
							"Sliding_background_fixed_border"=>array(
								"type_3_animation_from_center_dioganal_right"=>__("From center diagonal right","wpdevart_pricing_table"),
								"type_3_animation_from_center_dioganal_left"=>__("From center diagonal left","wpdevart_pricing_table"),
								"type_3_animation_from_center_to_vertical"=>__("From center to vertical","wpdevart_pricing_table"),
								"type_3_animation_from_center_to_horizontal"=>__("From center to horizontal","wpdevart_pricing_table"),
								"type_3_animation_from_bottom_to_top"=>__("From bottom to top","wpdevart_pricing_table"),
								"type_3_animation_from_top_to_bottom"=>__("From top to bottom","wpdevart_pricing_table"),
								"type_3_animation_from_left_to_right"=>__("From left to right","wpdevart_pricing_table"),
								"type_3_animation_from_right_to_left"=>__("From right to left","wpdevart_pricing_table"),
								
							)
						),
						"default_value"=>"Standard",
					),
					"column_button_bg_color"=>array(
						"title"=>__("Button background color","wpdevart_pricing_table"),
						"description"=>__("Type here button background color","wpdevart_pricing_table"),
						"function_name"=>"gradient_color_input",
						"values"=>array("color1"=>"","color2"=>"","gradient"=>""),
						"pro_grad"=>true,
						"default_value"=>array("color1"=>"rgba(255,255,255,0)","color2"=>"rgba(255,255,255,0)","gradient"=>"none"),
					),
					"column_button_txt_color"=>array(
						"title"=>__("Button text color","wpdevart_pricing_table"),
						"description"=>__("Type here button text color","wpdevart_pricing_table"),
						"default_value"=>"#000000",
						"function_name"=>"color_input",
					),
					"column_button_border_color"=>array(
						"title"=>__("Button border color","wpdevart_pricing_table"),
						"description"=>__("Type here button border color","wpdevart_pricing_table"),
						"default_value"=>"#000000",
						"function_name"=>"color_input",
					),					
					"column_button_bg_color_hover"=>array(
						"title"=>__("Button background color on hover","wpdevart_pricing_table"),
						"description"=>__("Type here button background color on hover","wpdevart_pricing_table"),
						"function_name"=>"gradient_color_input",
						"values"=>array("color1"=>"","color2"=>"","gradient"=>""),
						"pro_grad"=>true,
						"default_value"=>array("color1"=>"rgba(255,255,255,0)","color2"=>"rgba(255,255,255,0)","gradient"=>"none"),
					),
					"column_button_txt_color_hover"=>array(
						"title"=>__("Button text color on hover","wpdevart_pricing_table"),
						"description"=>__("Type here button text color","wpdevart_pricing_table"),
						"default_value"=>"#000000",
						"function_name"=>"color_input",
					),
					"column_button_border_color_hover"=>array(
						"title"=>__("Button border color on hover","wpdevart_pricing_table"),
						"description"=>__("Type here button border color on hover","wpdevart_pricing_table"),
						"default_value"=>"#000000",
						"function_name"=>"color_input",
					),
					"column_button_border_type"=>array(
						"title"=>__("Button border type","wpdevart_pricing_table"),
						"description"=>__("Select button border type","wpdevart_pricing_table"),				
						"function_name"=>"simple_select",
						"values"=>array("solid"=>__("Solid","wpdevart_pricing_table"),"dotted"=>__("Dotted","wpdevart_pricing_table"),"dashed"=>__("Dashed","wpdevart_pricing_table"),"double"=>__("Double","wpdevart_pricing_table"),"groove"=>__("Groove","wpdevart_pricing_table"),"ridge"=>__("Ridge","wpdevart_pricing_table"),"inset"=>__("Inset","wpdevart_pricing_table"),"outset"=>__("Outset","wpdevart_pricing_table")),
						"default_value"=>"solid",
					),
					"column_button_border_width"=>array(
						"title"=>__("Button border width","wpdevart_pricing_table"),
						"description"=>__("Type here button border width","wpdevart_pricing_table"),				
						"function_name"=>"simple_input",
						"default_value"=>"5",
						"small_text"=>"px"
					),
					"column_button_border_radius"=>array(
						"title"=>__("Button border radius","wpdevart_pricing_table"),
						"description"=>__("Type here button border radius","wpdevart_pricing_table"),				
						"function_name"=>"simple_input",
						"default_value"=>"5",
						"small_text"=>"px"
					),
					"column_button_font_size"=>array(
						"title"=>__("Button font size","wpdevart_pricing_table"),
						"description"=>__("Type here button font size","wpdevart_pricing_table"),				
						"function_name"=>"simple_input",
						"default_value"=>"18",
						"small_text"=>"px"
					),
					"column_button_font_family"=>array(
						"title"=>__("Button font family","wpdevart_pricing_table"),
						"description"=>__("Type here button font family","wpdevart_pricing_table"),				
						"function_name"=>"font_select",
						"values"=>wpda_pricing_table_library::fonts_select(),
						"default_value"=>"Arial,Helvetica Neue,Helvetica,sans-serif",
					),					
					"column_button_padding"=>array(
						"title"=>__("Button padding","wpdevart_pricing_table"),
						"description"=>__("Type here button padding","wpdevart_pricing_table"),				
						"function_name"=>"padding_margin_input",
						"values"=>array("top"=>"0","right"=>"0","bottom"=>"0","left"=>"0"),
						"default_value"=>array("top"=>"2","right"=>"5","bottom"=>"2","left"=>"5"),
					),					
					"column_button_margin"=>array(
						"title"=>__("Button margin","wpdevart_pricing_table"),
						"description"=>__("Type here button margin","wpdevart_pricing_table"),				
						"function_name"=>"padding_margin_input",
						"values"=>array("top"=>"0","right"=>"0","bottom"=>"0","left"=>"0"),
						"default_value"=>array("top"=>"0","right"=>"0","bottom"=>"0","left"=>"0"),
					)
				),
			),
			"animations"=>array(
				"heading_name"=>__("Animation","wpdevart_pricing_table")." <span class='pro_feature'>".__("(pro)","wpdevart_pricing_table")."</span>",
				"params"=>array(	
					"column_animation_type"=>array(
						"title"=>__("Animation effect","wpdevart_pricing_table"),
						"description"=>__("Select the animation effect","wpdevart_pricing_table"),				
						"function_name"=>"simple_select",
						"pro"=>true,
						"values"=>array(
							"none"=>__("None","wpdevart_pricing_table"),
							"random"=>__("Random","wpdevart_pricing_table"),
							"Attention_Seekers"=>array(
								"bounce"=>__("Bounce","wpdevart_pricing_table"),
								"flash"=>__("Flash","wpdevart_pricing_table"),
								"pulse"=>__("Pulse","wpdevart_pricing_table"),
								"rubberBand"=>__("RubberBand","wpdevart_pricing_table"),
								"shake"=>__("Shake","wpdevart_pricing_table"),
								"swing"=>__("Swing","wpdevart_pricing_table"),
								"tada"=>__("Tada","wpdevart_pricing_table"),
								"wobble"=>__("Wobble","wpdevart_pricing_table"),
							),		
							"Bouncing_Entrances"=>array(
								"bounceIn"=>__("BounceIn","wpdevart_pricing_table"),
								"bounceInDown"=>__("BounceInDown","wpdevart_pricing_table"),
								"bounceInLeft"=>__("BounceInLeft","wpdevart_pricing_table"),
								"bounceInRight"=>__("BounceInRight","wpdevart_pricing_table"),
								"bounceInUp"=>__("BounceInUp","wpdevart_pricing_table"),
							),						
							"Fading_Entrances"=>array(
								"fadeIn"=>__("FadeIn","wpdevart_pricing_table"),
								"fadeInDown"=>__("FadeInDown","wpdevart_pricing_table"),
								"fadeInDownBig"=>__("FadeInDownBig","wpdevart_pricing_table"),
								"fadeInLeft"=>__("FadeInLeft","wpdevart_pricing_table"),
								"fadeInLeftBig"=>__("FadeInLeftBig","wpdevart_pricing_table"),
								"fadeInRight"=>__("FadeInRight","wpdevart_pricing_table"),
								"fadeInRightBig"=>__("FadeInRightBig","wpdevart_pricing_table"),
								"fadeInUp"=>__("FadeInUp","wpdevart_pricing_table"),
								"fadeInUpBig"=>__("FadeInUpBig","wpdevart_pricing_table"),
							),
							"Flippers"=>array(
								"flip"=>__("Flip","wpdevart_pricing_table"),
								"flipInX"=>__("FlipInX","wpdevart_pricing_table"),
								"flipInY"=>__("FlipInY","wpdevart_pricing_table"),
							),
							"Lightspeed"=>array(
								"lightSpeedIn"=>__("LightSpeedIn","wpdevart_pricing_table"),
							),
							"Rotating_Entrances"=>array(
								"rotateIn"=>__("RotateIn","wpdevart_pricing_table"),
								"rotateInDownLeft"=>__("RotateInDownLeft","wpdevart_pricing_table"),
								"rotateInDownRight"=>__("RotateInDownRight","wpdevart_pricing_table"),
								"rotateInUpLeft"=>__("RotateInUpLeft","wpdevart_pricing_table"),
								"rotateInUpRight"=>__("RotateInUpRight","wpdevart_pricing_table"),
							),
							"Specials"=>array(
								"rollIn"=>__("RollIn","wpdevart_pricing_table"),
							),
							"Zoom_Entrances"=>array(
								"zoomIn"=>__("ZoomIn","wpdevart_pricing_table"),
								"zoomInDown"=>__("ZoomInDown","wpdevart_pricing_table"),
								"zoomInLeft"=>__("ZoomInLeft","wpdevart_pricing_table"),
								"zoomInRight"=>__("ZoomInRight","wpdevart_pricing_table"),
								"zoomInUp"=>__("ZoomInUp","wpdevart_pricing_table"),
							),
						),
						"default_value"=>"none",
					),
					"column_animation_delay"=>array(
						"title"=>__("Animation delay","wpdevart_pricing_table"),
						"description"=>__("Type here the animation delay","wpdevart_pricing_table"),				
						"function_name"=>"simple_input",
						"default_value"=>"100",
						"small_text"=>"(ms)",
						"pro"=>true,
					)
				),
			)			
		);
	}
	public static function get_default_values_array(){
		$array_of_returned=array();
		$options=self::return_params_array();
		foreach($options as $param_heading_key=>$param_heading_value){
			foreach($param_heading_value['params'] as $key=>$value){
				$array_of_returned[$key]=$value['default_value'];
			}
		}	
		return $array_of_returned;
	}
	
	/*###################### Controller page function ##################*/		
	
	public function controller_page(){
		global $wpdb;
		$task="default";
		$id=0;
		if(isset($_GET["task"])){
			$task=sanitize_text_field($_GET["task"]);
		}
		if(isset($_GET["id"])){
			$id=intval($_GET["id"]);
		}		
		switch($task){
		case 'add_wpda_pricing_table_themes':	
			$this->add_edit_theme($id);
			break;
			
		case 'add_edit_theme':	
			$this->add_edit_theme($id);
			break;
		case 'duplicate':	
			$this->duplicate_theme($id);
			$this->display_table_list_theme();	
			break;
		case 'save_theme':		
			if($id)	
				$this->update_theme($id);
			else
				$this->save_theme();
				
			$this->display_table_list_theme();	
			break;
			
			
		case 'update_theme':		
			if($id){
				$this->update_theme($id);
			}else{
				$this->save_theme();
				$_GET['id']=$wpdb->get_var("SELECT MAX(id) FROM ".wpda_pricing_table_databese::$table_names['theme']);
				$id=intval($_GET['id']);
			}
			$this->add_edit_theme($id);
			break;
		case 'set_default_theme':
			$this->set_default_theme($id);
			$this->display_table_list_theme();	
		break;
		case 'remove_theme':	
			$this->remove_theme($id);
			$this->display_table_list_theme();
			break;				
		default:
			$this->display_table_list_theme();
		}
	}
	
/*############  Save function  ################*/
	
	private function save_theme(){
		global $wpdb;
		if(count($_POST)==0)
			return;		
		$params_array=array();
		if(isset($_POST['name'])){
			$name=sanitize_text_field($_POST['name']);
		}else{
			$name="theme";
		}
		
		$params_array=array('name'=>sanitize_text_field($name));
		foreach($this->options as $param_heading_key=>$param_heading_value){
			foreach($param_heading_value['params'] as $key=>$value){
				if(isset($_POST[$key])){
					if(is_array($_POST[$key])){
						$arr=[];
						foreach($_POST[$key] as $loc_param_key =>$loc_param_value){
							$arr[$loc_param_key]=sanitize_text_field($loc_param_value);
						}
						$params_array[$key]=$arr;
					}else{
						if($key=='column_aditional_text'){
							$params_array[$key]=sanitize_text_field(htmlspecialchars(stripslashes(($_POST[$key]))));
						}else{
							$params_array[$key]=stripslashes(sanitize_text_field($_POST[$key]));
						}
					}
				}else{
					$params_array[$key]=$value['default_value'];
				}
			}
		}	
		
		$save_or_no=$wpdb->insert( wpda_pricing_table_databese::$table_names['theme'], 
			array( 
				'name' => $name,
				'option_value' => json_encode($params_array),
			), 
			array( 
				'%s', 
				'%s',
			) 
		);
		if($save_or_no){
			?><div class="updated"><p><strong><?php echo __("Item Saved","wpdevart_pricing_table"); ?></strong></p></div><?php
		}
		else{
			?><div id="message" class="error"><p><?php echo __("Error please reinstall plugin","wpdevart_pricing_table"); ?></p></div> <?php
		}
	}
	
/*############  Update theme ID function  ################*/
	
	private function update_theme($id){
		global $wpdb;
		if(count($_POST)==0)
			return;
		$params_array=array();
		if(isset($_POST['name'])){
			$name=sanitize_text_field($_POST['name']);
		}else{
			$name="theme";
		}
		$params_array=array('name'=>sanitize_text_field($name));
		foreach($this->options as $param_heading_key=>$param_heading_value){
			foreach($param_heading_value['params'] as $key=>$value){
				if(isset($_POST[$key])){
					if(is_array($_POST[$key])){
						$arr=[];
						foreach($_POST[$key] as $loc_param_key =>$loc_param_value){
							$arr[$loc_param_key]=sanitize_text_field($loc_param_value);
						}
						$params_array[$key]=$arr;
					}else{
						if($key=='column_aditional_text'){
							$params_array[$key]=sanitize_text_field(htmlspecialchars(stripslashes($_POST[$key])));
						}else{
							$params_array[$key]=stripslashes(sanitize_text_field($_POST[$key]));
						}
					}
				}else{
					$params_array[$key]=$value['default_value'];
				}
			}
		}		
		$wpdb->update( wpda_pricing_table_databese::$table_names['theme'], 
			array( 
				'name' => $name,
				'option_value' => json_encode($params_array),
			), 
			array( 
				'id'=>$id 
			),
			array( 
				'%s', 
				'%s'
			),
			array( 
				'%d'
			)  
		);
		
		?><div class="updated"><p><strong><?php echo __("Item Saved","wpdevart_pricing_table"); ?></strong></p></div><?php
		
	}
	
	private function duplicate_theme($id){
		global $wpdb;
		if(!$id){
			?><div id="message" class="error"><p><?php echo __("incorect theme id","wpdevart_pricing_table"); ?></p></div> <?php
			return;
		}
		$theme_params = $wpdb->get_row('SELECT * FROM '.wpda_pricing_table_databese::$table_names['theme'].' WHERE id='.$id);
		$name = $theme_params->name;
		$save_or_no=$wpdb->insert( wpda_pricing_table_databese::$table_names['theme'], 
			array( 
				'name' => $name.'_copy',
				'option_value' => $theme_params->option_value,
			), 
			array( 
				'%s', 
				'%s',
			) 
		);
		if($save_or_no){
			?><div id="message" class="updated"><p><?php echo __("Theme duplicated","wpdevart_pricing_table"); ?></p></div> <?php
		}else{			
			?><div id="message" class="error"><p><?php echo __("Error","wpdevart_pricing_table"); ?></p></div> <?php
		
		}
		
	}
	private function copy_name($name){
		$name_length=strlen($name);
		$numer_before_copy='';
		for($i=0;$i<strlen($name);$i++){
			if(is_numeric($name[$name_length-1-$i])){
				$numer_before_copy.=$name[$name_length-1-$i];
			}else{
				$numer_before_copy=(int)$numer_before_copy;
				$numer_before_copy+=1;
				if($name[$name_length-1-$i]=='-')
					return substr($name,0,$name_length-$i).$numer_before_copy;
				else
					return substr($name,0,$name_length-$i).'-'.$numer_before_copy;
			}
		}
	}
	private function remove_theme($id){
		global $wpdb;
		$default_theme = $wpdb->get_var($wpdb->prepare('SELECT `default` FROM ' . wpda_pricing_table_databese::$table_names['theme'].' WHERE id="%d"', $id));
		if (!$default_theme) {
			$wpdb->query($wpdb->prepare('DELETE FROM ' . wpda_pricing_table_databese::$table_names['theme'].' WHERE id="%d"', $id));
		}
		else{
			?><div id="message" class="error"><p><?php __("You cannot remove default theme","wpdevart_pricing_table"); ?></p></div> <?php
		}
	}
	
	private function display_table_list_theme(){
		
		?>
        <style>
        .description_row:nth-child(odd){
			background-color: #f9f9f9;
		}
		
        </style>
        <script> var my_table_list=<?php echo $this->generete_jsone_list(); ?></script>
        <div class="wrap">
			<div class="wpdevart_plugins_header div-for-clear">
				<div class="wpdevart_plugins_get_pro div-for-clear">
					<div class="wpdevart_plugins_get_pro_info">
						<h3><?php echo __("WpDevArt Pricing Table Premium","wpdevart_pricing_table"); ?></h3>
						<p><?php echo __("Powerful and Customizable Pricing Table","wpdevart_pricing_table"); ?></p>
					</div>
						<a target="blank" href="https://wpdevart.com/wordpress-pricing-table-plugin/   " class="wpdevart_upgrade"><?php echo __("Upgrade","wpdevart_pricing_table"); ?></a>
				</div>
				<a target="blank" href="<?php echo wpdevart_pricing_table_support_url; ?>" class="wpdevart_support"><?php echo __("Have any Questions? Get a quick support!","wpdevart_pricing_table"); ?></a>
			</div>
            <form method="post"  action="" id="admin_form" name="admin_form" ng-app="" ng-controller="customersController">
			<h2 class="wpda_pt_h2"><?php echo __("Theme","wpdevart_pricing_table"); ?> <a href="admin.php?page=wpda_pricing_table_themes&task=add_wpda_pricing_table_themes" class="add-new-h2"><?php echo __("Add New","wpdevart_pricing_table"); ?> </a></h2>            
   
            <div class="tablenav top" style="width:95%">  
                <input type="text" placeholder="<?php echo __("Search","wpdevart_pricing_table"); ?>" ng-change="filtering_table();" ng-model="searchText">            
                <div class="tablenav-pages"><span class="displaying-num">{{filtering_table().length}} <?php echo __("items","wpdevart_pricing_table"); ?></span>
                <span ng-show="(numberOfPages()-1)>=1">
                    <span class="pagination-links"><a class="button first-page" ng-class="{disabled:(curPage < 1 )}" title="Go to the first page" ng-click="curPage=0;curect()">«</a>
                    <a class="button prev-page" title="Go to the previous page" ng-class="{disabled:(curPage < 1 )}" ng-click="curPage=curPage-1; curect()">‹</a>
                    <span class="paging-input"><span class="total-pages">{{curPage + 1}}</span> <?php echo __("of","wpdevart_pricing_table"); ?> <span class="total-pages">{{ numberOfPages() }}</span></span>
                    <a class="button next-page" title="Go to the next page" ng-class="{disabled:(curPage >= (numberOfPages() - 1))}" ng-click=" curPage=curPage+1; curect()">›</a>
                    <a class="button last-page" title="Go to the last page" ng-class="{disabled:(curPage >= (numberOfPages() - 1))}" ng-click="curPage=numberOfPages()-1;curect()">»</a></span></div>
                </span>
            </div>
            <table class="wp-list-table widefat fixed pages" style="width:95%">
                <thead>
                    <tr>
                        <th style="width: 100px;" id='oreder_by_id' data-ng-click="order_by='id'; reverse=!reverse; ordering($event,order_by,reverse);" class="manage-column sortable desc" scope="col"><a><span>ID</span><span class="sorting-indicator"></span></a></th>
                        <th data-ng-click="order_by='name'; reverse=!reverse; ordering($event,order_by,reverse)" class="manage-column sortable desc"><a><span><?php echo __("Name","wpdevart_pricing_table"); ?></span><span class="sorting-indicator"></span></a></th>
                        <th style="width:100px"><a><?php echo __("Default","wpdevart_pricing_table"); ?></span></a></th>
                        <th style="width:80px"><?php echo __("Edit","wpdevart_pricing_table"); ?></th> 
						<th style="width:120px"><?php echo __("Duplicate","wpdevart_pricing_table"); ?></th>						
                        <th  style="width:60px"><?php echo __("Delete","wpdevart_pricing_table"); ?></th>
                    </tr>
                </thead>
                <tbody>
                 <tr ng-repeat="rows in names | filter:filtering_table" class="description_row">
					 <td>{{rows.id}}</td>
					 <td><a href="admin.php?page=wpda_pricing_table_themes&task=add_edit_theme&id={{rows.id}}">{{rows.name}}</a></td>
					 <td><a href="admin.php?page=wpda_pricing_table_themes&task=set_default_theme&id={{rows.id}}"><img src="<?php echo wpda_pricing_table_plugin_url.'includes/admin/images/default' ?>{{rows.default}}.png"></a></td>
					 <td><a href="admin.php?page=wpda_pricing_table_themes&task=add_edit_theme&id={{rows.id}}"><?php echo __("Edit","wpdevart_pricing_table"); ?></a></td>
					  <td><a href="admin.php?page=wpda_pricing_table_themes&task=duplicate&id={{rows.id}}"><?php echo __("Duplicate","wpdevart_pricing_table"); ?></a></td>
					 <td><a class="wpdevart_red" href="admin.php?page=wpda_pricing_table_themes&task=remove_theme&id={{rows.id}}"><?php echo __("Delete","wpdevart_pricing_table"); ?></a></td>                               
                  </tr> 
                </tbody>
            </table>
        </form>
        </div>
    <script>

jQuery(document).ready(function(e) {
    jQuery('a.disabled').click(function(){return false});
	jQuery('form').on("keyup keypress", function(e) {
		var code = e.keyCode || e.which; 
		if (code  == 13) {               
			e.preventDefault();
			return false;
		}
	});
});
    function customersController($scope,$filter) {
		var orderBy = $filter('orderBy');
		$scope.previsu_search_result='';
		$scope.oredering=new Array();
		$scope.baza = my_table_list;
		$scope.curPage = 0;
		$scope.pageSize = 20;
		$scope.names=$scope.baza.slice( $scope.curPage* $scope.pageSize,( $scope.curPage+1)* $scope.pageSize)
		$scope.numberOfPages = function(){
		   return Math.ceil($scope.filtering_table().length / $scope.pageSize);
	   };
	   $scope.filtering_table=function(){
		   var new_searched_date_array=new Array;
		   new_searched_date_array=[];
		   angular.forEach($scope.baza,function(value,key){
			   var catched=0;
			   angular.forEach(value,function(value_loc,key_loc){
				   if((''+value_loc).indexOf($scope.searchText)!=-1 || $scope.searchText=='' || typeof($scope.searchText) == 'undefined')
					  catched=1;
			   })
			  if(catched)
				  new_searched_date_array.push(value);
		   })
		   if($scope.previsu_search_result != $scope.searchText){
			  
			  $scope.previsu_search_result=$scope.searchText;
			   $scope.ordering($scope.oredering[0],$scope.oredering[1], $scope.oredering[2]);
			   
		   }
		   if(new_searched_date_array.length<=$scope.pageSize)
		   		$scope.curPage = 0;
		   return new_searched_date_array;
	   }
	   $scope.curect=function(){
		   if( $scope.curPage<0){
				$scope.curPage=0;
		   }
		   if( $scope.curPage> $scope.numberOfPages()-1)
			   $scope.curPage=$scope.numberOfPages()-1;
		  $scope.names=$scope.filtering_table().slice( $scope.curPage* $scope.pageSize,( $scope.curPage+1)* $scope.pageSize)
	   }
		
		$scope.ordering=function($event,order_by,revers){
		   if( typeof($event) != 'undefined' && typeof($event.currentTarget) != 'undefined')
		   		element=$event.currentTarget;
			else
				element=jQuery();
		   
			if(revers)
			  indicator='asc'
			else
			  indicator='desc'
			 $scope.oredering[0]=$event;
			 $scope.oredering[1]=order_by;
			 $scope.oredering[2]=revers;
			jQuery(element).parent().find('.manage-column').removeClass('sortable desc asc sorted');
			jQuery(element).parent().find('.manage-column').not(element).addClass('sortable desc');
			jQuery(element).addClass('sorted '+indicator);		  
			$scope.names=orderBy($scope.filtering_table(),order_by,revers).slice( $scope.curPage* $scope.pageSize,( $scope.curPage+1)* $scope.pageSize)
		}
	}
    </script>
		<?php
		$this->generete_jsone_list();
	}
	private function generete_jsone_list(){
		global $wpdb;
		$query = "SELECT `id`,`name`,`default` FROM ".wpda_pricing_table_databese::$table_names['theme'];
		$rows=$wpdb->get_results($query);
		$json="[";
		$no_frst_storaket=1;
		foreach($rows as $row){
			$json.=(($no_frst_storaket) ? '' : ',' )."{";
			$no_frst_storaket=1;
			foreach($row as $key=>$value){
				if($key!='id'){
					$json.= "".(($no_frst_storaket) ? '' : ',' )."'".$key."':"."'".(($value)?preg_replace('/^\s+|\n|\r|\s+$/m', '',htmlspecialchars_decode(addslashes(strip_tags($value)))):'0')."'";				
				}
				else{					
					$json.= "".(($no_frst_storaket) ? '' : ',' )."'".$key."':".(($value)?htmlspecialchars_decode(addslashes($value)):'0'); 
				}
				
				$no_frst_storaket=0;
			 }			 
			 $json.="}";
		}
		$json.="]";
		return $json;
	}	
	public static function get_themes_by_ids($ids){
		global $wpdb;
		$ids_to_string=implode(",",$ids);
		$all_themes=array();
		$all_themes_info_from_db=$wpdb->get_results('SELECT * FROM '.wpda_pricing_table_databese::$table_names['theme'].' WHERE ID IN('.$ids_to_string.')');
		if($all_themes_info_from_db==null){
			return false;
		}
		foreach($all_themes_info_from_db as $theme_value){
			$all_themes[$theme_value->id]=json_decode($theme_value->option_value, true);
		}
		return $all_themes;
	}
	private function generete_theme_parametrs($id=0){
		global $wpdb;	
		$theme_params = NULL;
		$new_theme=1;
		if($id){
			$theme_params = $wpdb->get_row('SELECT * FROM '.wpda_pricing_table_databese::$table_names['theme'].' WHERE id='.$id);	
			$new_theme=0;
		}else{
			$theme_params = $wpdb->get_row('SELECT * FROM '.wpda_pricing_table_databese::$table_names['theme'].' WHERE `default`=1');	
			
		}
		if($theme_params==NULL){			
			foreach($this->options as $param_heading_key=>$param_heading_value){
				foreach($param_heading_value['params'] as $key=>$value){
					$this->options[$param_heading_key]['params'][$key]["value"]=$this->options[$param_heading_key]['params'][$key]["default_value"];
				}
			}
		}else{
			$databases_parametrs=json_decode($theme_params->option_value, true);
			foreach($this->options as $param_heading_key=>$param_heading_value){
				foreach($param_heading_value['params'] as $key=>$value){
					if(isset($databases_parametrs[$key])){
						$this->options[$param_heading_key]['params'][$key]["value"]=$databases_parametrs[$key];
					}else{
						$this->options[$param_heading_key]['params'][$key]["value"]=$this->options[$param_heading_key]['params'][$key]["default_value"];
					}
				}
			}
			if($new_theme){
				return "New Theme";
			}else{
				return $theme_params->name;
			}
		}
	}
	
	
	private function add_edit_theme($id=0){
		global $wpdb;
		$name=$this->generete_theme_parametrs($id);
		?>		         
		<form action="admin.php?page=wpda_pricing_table_themes<?php if($id) echo '&id='.$id; ?>" method="post" name="adminForm" class="top_description_table" id="adminForm">
            <div class="conteiner">
                <div class="header">
                    <span><h2 class="wpda_theme_title"><?php echo $id?__("Edit Theme","wpdevart_pricing_table"):__("Add Theme","wpdevart_pricing_table"); ?> </h2></span>
                    <div class="header_action_buttons">
                        <span><input type="button" onclick="submitbutton('save_theme')" value="<?php echo __("Save","wpdevart_pricing_table"); ?>" class="button-primary action"> </span> 
                        <span><input type="button" onclick="submitbutton('update_theme')" value="<?php echo __("Apply","wpdevart_pricing_table"); ?>" class="button-primary action"> </span> 
                        <span><input type="button" onclick="window.location.href='admin.php?page=wpda_pricing_table_themes'" value="<?php echo __("Cancel","wpdevart_pricing_table"); ?>" class="button-secondary action"> </span> 
                    </div>
                </div>
                <div class="option_panel">            
                    <div class="parametr_name"></div>
                    <div class="all_options_panel">
                        <input type="text" class="theme_name" name="name" placeholder="<?php echo __("Enter title","wpdevart_pricing_table"); ?>" value="<?php echo isset($name)?$name:'' ?>" >
                        <div class="wpda_theme_link_tabs">
							<?php
								echo "<ul>";
								foreach($this->options as $params_grup_name =>$params_group_value){ 
									echo '<li id="'.$params_grup_name.'_tab">'.$params_group_value['heading_name'].'</li>';
								}
								echo "</ul>";
							?>
						</div>
                        <table>
						<?php 
						foreach($this->options as $params_grup_name =>$params_group_value){ 
							wpda_pricing_table_library::create_table_heading($params_group_value['heading_name'],$params_grup_name);
							foreach($params_group_value['params'] as $param_name => $param_value){
								$args=array(
									"name"=>$param_name,
									"heading_name"=>$params_group_value['heading_name'],
									"heading_group"=>$params_grup_name,
								);
								$args=array_merge($args,$param_value);
								$function_name=$param_value['function_name'];
								wpda_pricing_table_library::$function_name($args);
							}
						}

						?>
					</table>
                    </div>
                </div>
            </div>
		</form>
		<?php

		 
	}
	private function set_default_theme($id){
		global $wpdb;
		$wpdb->update(wpda_pricing_table_databese::$table_names['theme'], array('default' => 0), array('default' => 1));
		$save = $wpdb->update(wpda_pricing_table_databese::$table_names['theme'], array('default' => 1), array('id' => $id));		
	}
	private function border_types(){
		$border_type[ 'dotted' ] = 'dotted';
		$border_type[ 'dashed' ] = 'dashed';
		$border_type[ 'solid' ] = 'solid';
		$border_type[ 'double' ] = 'double';
		$border_type[ 'groove' ] = 'groove';
		$border_type[ 'ridge' ] = 'ridge';
		$border_type[ 'inset' ] = 'inset';	
		$border_type[ 'outset' ] = 'outset';
		return $border_type;
	}
	private function fonts_options(){
		  $font_choices[ 'Arial,Helvetica Neue,Helvetica,sans-serif' ] = 'Arial *';
		  $font_choices[ 'Arial Black,Arial Bold,Arial,sans-serif' ] = 'Arial Black *';
		  $font_choices[ 'Arial Narrow,Arial,Helvetica Neue,Helvetica,sans-serif' ] = 'Arial Narrow *';
		  $font_choices[ 'Courier,Verdana,sans-serif' ] = 'Courier *';
		  $font_choices[ 'Georgia,Times New Roman,Times,serif' ] = 'Georgia *';
		  $font_choices[ 'Times New Roman,Times,Georgia,serif' ] = 'Times New Roman *';
		  $font_choices[ 'Trebuchet MS,Lucida Grande,Lucida Sans Unicode,Lucida Sans,Arial,sans-serif' ] = 'Trebuchet MS *';
		  $font_choices[ 'Verdana,sans-serif' ] = 'Verdana *';
		  $font_choices[ 'American Typewriter,Georgia,serif' ] = 'American Typewriter';
		  $font_choices[ 'Andale Mono,Consolas,Monaco,Courier,Courier New,Verdana,sans-serif' ] = 'Andale Mono';
		  $font_choices[ 'Baskerville,Times New Roman,Times,serif' ] = 'Baskerville';
		  $font_choices[ 'Bookman Old Style,Georgia,Times New Roman,Times,serif' ] = 'Bookman Old Style';
		  $font_choices[ 'Calibri,Helvetica Neue,Helvetica,Arial,Verdana,sans-serif' ] = 'Calibri';
		  $font_choices[ 'Cambria,Georgia,Times New Roman,Times,serif' ] = 'Cambria';
		  $font_choices[ 'Candara,Verdana,sans-serif' ] = 'Candara';
		  $font_choices[ 'Century Gothic,Apple Gothic,Verdana,sans-serif' ] = 'Century Gothic';
		  $font_choices[ 'Century Schoolbook,Georgia,Times New Roman,Times,serif' ] = 'Century Schoolbook';
		  $font_choices[ 'Consolas,Andale Mono,Monaco,Courier,Courier New,Verdana,sans-serif' ] = 'Consolas';
		  $font_choices[ 'Constantia,Georgia,Times New Roman,Times,serif' ] = 'Constantia';
		  $font_choices[ 'Corbel,Lucida Grande,Lucida Sans Unicode,Arial,sans-serif' ] = 'Corbel';
		  $font_choices[ 'Franklin Gothic Medium,Arial,sans-serif' ] = 'Franklin Gothic Medium';
		  $font_choices[ 'Garamond,Hoefler Text,Times New Roman,Times,serif' ] = 'Garamond';
		  $font_choices[ 'Gill Sans MT,Gill Sans,Calibri,Trebuchet MS,sans-serif' ] = 'Gill Sans MT';
		  $font_choices[ 'Helvetica Neue,Helvetica,Arial,sans-serif' ] = 'Helvetica Neue';
		  $font_choices[ 'Hoefler Text,Garamond,Times New Roman,Times,sans-serif' ] = 'Hoefler Text';
		  $font_choices[ 'Lucida Bright,Cambria,Georgia,Times New Roman,Times,serif' ] = 'Lucida Bright';
		  $font_choices[ 'Lucida Grande,Lucida Sans,Lucida Sans Unicode,sans-serif' ] = 'Lucida Grande';
		  $font_choices[ 'Palatino Linotype,Palatino,Georgia,Times New Roman,Times,serif' ] = 'Palatino Linotype';
		  $font_choices[ 'Tahoma,Geneva,Verdana,sans-serif' ] = 'Tahoma';
		  $font_choices[ 'Rockwell, Arial Black, Arial Bold, Arial, sans-serif' ] = 'Rockwell';
		  $font_choices[ 'Segoe UI' ] = 'Segoe UI';
		  return $font_choices;
	}	
}


 ?>