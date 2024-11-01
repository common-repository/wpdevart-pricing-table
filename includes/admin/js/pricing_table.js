wpdevart_pricing_table_pro_txt="if you want use this feature upgrade Pricing Table pro";
function submitbutton(value){
	jQuery("#adminForm").attr("action",jQuery("#adminForm").attr("action")+"&task="+value);
	var column_filds_oredering='';
	jQuery("#ordering").children().each(function() {
		column_filds_oredering=column_filds_oredering+jQuery( this ).attr( "data-info" )+',';
	});
	jQuery("#column_fields_ordering").val(column_filds_oredering);
	jQuery("#adminForm").submit();
}
wpda_pricing_table_class={
	insert_div_id:"column_body",
	add_new_button_id:"add_new_column",
	sortable_handel_icon_class:"sortable_handel_icon",
	remove_column_class:"remove_column",
	translated_words:{remove:"Remove",title:"Title",price:"Price",fetured_line:"Features line",button_url:"Button Url",button_text:"Button text",select_theme:"Select the column theme"},
	columns_info:[],
	themes:Array(),
	start:function(){
		self=this;
		jQuery(document).ready(function(){
			jQuery('#'+self.add_new_button_id).click(function(){
				self.create_column_html(null);
				
				return false;
			});
			if(self.columns_info.length){
				for(var i=0;i<self.columns_info.length;i++){
					self.create_column_html(self.columns_info[i]);
				}
			}else{
				self.create_column_html(null);
				self.create_column_html(null);
			}
			jQuery('#ordering').mousedown(function(){alert(wpdevart_pricing_table_pro_txt); return false;})
			self.select_icon();
		})
		
	},
	create_column_html:function(column_info){
		self=this;
		var col_name=null
		var col_price=null
		var col_feature=null
		var col_button_url=null
		var col_button_text=null
		var col_theme=null
		var main_div = jQuery('<div class="column_div"></div>');
		main_div.append(self.create_drag_drop_and_remove_row());
		if(column_info!==null){
			col_name=column_info['title']
		}
		main_div.append(self.create_name_div(col_name));
		if(column_info!==null){
			col_price=column_info['price']
		}
		main_div.append(self.create_price_div(col_price));
		if(column_info!==null){
			col_feature=column_info['feature']
		}
		main_div.append(self.create_feature_div(col_feature));
		if(column_info!==null){
			col_button_url=column_info['button_url']
		}
		main_div.append(self.create_button_url_div(col_button_url));
		if(column_info!==null){
			col_button_text=column_info['button_text']
		}
		main_div.append(self.create_button_text_div(col_button_text));
		if(column_info!==null){
			col_theme=column_info['theme']
		}
		main_div.append(self.create_theme(col_theme));		
		jQuery('#'+self.insert_div_id).append(main_div);
		self.add_sortable_functionality();
	},
	create_drag_drop_and_remove_row:function(){
		self=this;
		console.log(self.translated_words)
		var drag_drop_and_remove_div = jQuery('<div class="drag_drop_and_remove_div"></div>');
		var remove_element=jQuery('<button class="'+self.remove_column_class+'" ></button>');
		var remove_element_icon=jQuery('<span class="dashicons dashicons-no-alt"></span>');
		var remove_element_text=jQuery('<span>'+self.translated_words.remove+'</span>');
		drag_drop_and_remove_div.append('<span class="'+self.sortable_handel_icon_class+' dashicons dashicons-move"></span>');
		remove_element.append(remove_element_icon);
		remove_element.append(remove_element_text);
		self.remove_column(remove_element);
		drag_drop_and_remove_div.append(remove_element);
		return drag_drop_and_remove_div;
	},
	create_name_div:function(name){
		if(name===null){
			name=''
		}
		var name_div = jQuery('<div class="name_div"></div>');
		name_div.append('<input placeholder="'+this.translated_words.title+'" name="title[]" class="input" type="text" value="'+name+'">');
		return name_div;
	},
	create_price_div:function(price){
		if(price===null){
			price=''
		}
		var price_div = jQuery('<div class="price_div"></div>');
		price_div.append('<input placeholder="'+this.translated_words.price+'" name="price[]" class="input" type="text" value="'+price+'">');
		return price_div;
	},
	create_feature_div:function(feature){
		if(feature===null){
			feature=[];
		}
		var feature_div = jQuery('<div class="feature_div"></div>');
		feature_div.append('<textarea name="feature[]" placeholder="'+this.translated_words.fetured_line+' 1 \n'+self.translated_words.fetured_line+' 2 \n'+self.translated_words.fetured_line+' 3" class="textarea">'+feature.join("\r\n")+'</textarea>');
		return feature_div;
	},
	create_button_url_div:function(button_url){
		if(button_url===null){
			button_url='';
		}
		var button_url_div = jQuery('<div class="button_url_div"></div>');
		button_url_div.append('<input name="button_url[]" placeholder="'+this.translated_words.button_url+'" class="input" type="text" value="'+button_url+'">');
		return button_url_div;
	},
	create_button_text_div:function(button_text){
		if(button_text===null){
			button_text='';
		}
		var button_text_div = jQuery('<div class="button_text_div"></div>');
		button_text_div.append('<input name="button_text[]" placeholder="'+this.translated_words.button_text+'" class="input" type="text" value="'+button_text+'">');
		return button_text_div;
	},
	create_theme:function(theme){
		var self=this;
		if(theme===null){
			theme='';
		}
		var select_theme_div = jQuery('<div class="select_theme_div"></div>');
		var select_theme = jQuery('<select name="theme[]" class="select_theme"></select>');
		var select_option;
		for(var i=0;i<self.themes.length;i++){
			select_option=jQuery('<option value="'+self.themes[i]['id']+'">'+self.themes[i]['name']+'</option>');
			if(theme!==""){
				if(self.themes[i]['id']===theme){
					select_option.prop("selected", true);
				}
			}{
				if(self.themes[i]['default']=='1'){
					select_option.prop("selected", true);
				}
			}
			select_theme.append(select_option);
		}
		select_theme_div.append(select_theme);
		select_theme_div.append('<span data-tooltip="'+self.translated_words.select_theme+'" class="information_div">?</span>')
		return select_theme_div;
	},
	add_sortable_functionality:function(){
		self=this;
		jQuery('#'+self.insert_div_id ).sortable({placeholder: "show_current_placeholder", handle: '.'+self.sortable_handel_icon_class });
		jQuery( '#'+self.insert_div_id ).disableSelection();
	},	
	remove_column:function(cur_element){
		jQuery(cur_element).click(function(){
			jQuery(this).parent().parent().remove();
			
		})
	},
	select_icon:function(){
		jQuery('.set_this_font').click(function(){
			var html=jQuery(this).html();
			jQuery('#wpdevart_icon_html_input').val(html);
		})
	}
}
