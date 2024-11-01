wpdevart_pricing_table_pro_txt="if you want use this feature upgrade Pricing Table pro";
function submitbutton(value){
	jQuery("#adminForm").attr("action",jQuery("#adminForm").attr("action")+"&task="+value);
	jQuery("#adminForm").submit();
}
wpda_pricing_theme_class={
	start_tab_id:"theme_general",
	list_of_fields_po_mo:["text_for_weeks","text_for_day","text_for_hour","text_for_minute","text_for_second"],
	conect_select_values_to_hidden_rows:{
		'type_1_from_top':['column_button_bg_color_select_grad','column_button_border_color'],
		'type_1_from_bottom':['column_button_bg_color_select_grad','column_button_border_color'],
		'type_1_from_middle':['column_button_bg_color_select_grad','column_button_border_color'],
		'type_1_from_left':['column_button_bg_color_select_grad','column_button_border_color'],
		'type_1_from_right':['column_button_bg_color_select_grad','column_button_border_color'],
		'type_3_animation_from_center_dioganal_right':['column_button_bg_color_select_grad'],
		'type_3_animation_from_center_dioganal_left':['column_button_bg_color_select_grad'],
		'type_3_animation_from_center_to_vertical':['column_button_bg_color_select_grad'],
		'type_3_animation_from_center_to_horizontal':['column_button_bg_color_select_grad'],
		'type_3_animation_from_bottom_to_top':['column_button_bg_color_select_grad'],
		'type_3_animation_from_top_to_bottom':['column_button_bg_color_select_grad'],
		'type_3_animation_from_left_to_right':['column_button_bg_color_select_grad'],
		'type_3_animation_from_right_to_left':['column_button_bg_color_select_grad'],
	},
	hided_rows:[],
	start:function(){
		var self=this;
		jQuery(document).ready(function(){
			self.conect_tab_activate_functionality();
			self.conect_theme_select_functionalyty();
			self.activete_tab(self.start_tab_id);
			self.add_hidden_rows(jQuery("#column_button_themes").val());
			self.hide_element_by_array();
			jQuery('.wpdevart_pro').mousedown(function(){alert(wpdevart_pricing_table_pro_txt);return;})
		})
	},
	conect_tab_activate_functionality:function(){
		var self=this;
		jQuery(".wpda_theme_link_tabs li").click(function(){
			self.activete_tab(jQuery(this).attr('id').replace("_tab",""));
		});
	},
	conect_theme_select_functionalyty:function(){
		var self=this;
		jQuery("#column_button_themes").change(function(){
			var select_value=jQuery(this).val();
			self.add_hidden_rows(select_value);
			self.hide_element_by_array();
		});
	},
	activete_tab:function(tab_id){
		jQuery(".wpda_theme_link_tabs li,.all_options_panel table tr").removeClass('active');	
		jQuery("#"+tab_id+"_tab").addClass('active');
		jQuery((".all_options_panel table tr" + "."+tab_id)).addClass('active');
		this.hide_element_by_array();
	},
	add_hidden_rows:function(select_value){
		var self=this;
		var count_of_rows=self.hided_rows.length;
		if(select_value in self['conect_select_values_to_hidden_rows']){
			for(var i =0;i<count_of_rows;i++){
				self.show_element_row(self.hided_rows.pop());
			}
			for(var i =0;i<self['conect_select_values_to_hidden_rows'][select_value].length;i++){
				self.hided_rows.push(self['conect_select_values_to_hidden_rows'][select_value][i])
			}
		}else{
			
			for(var i =0;i<count_of_rows;i++){
				self.show_element_row(self.hided_rows.pop());
			}
		}
	},
	hide_element_by_array:function(){
		var self=this;
		for(var i=0;i<self.hided_rows.length;i++){
			jQuery('#'+self.hided_rows[i]).closest('tr.tr_option').removeClass('active');
		}
	},
	show_element_row(element_id){
		jQuery('#'+element_id).closest('tr.tr_option').addClass('active');
	}
}

wpda_pricing_theme_class.start();