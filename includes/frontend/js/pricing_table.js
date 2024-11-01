/*
Pricing table front end javascript
Author : wpdevart LLC
*/
(function($){
	$.fn.wpdevart_pricing_table_animation = function(effect,effect_time) {
		var element = $(this);
		if(typeof(effect_time)=="undefined"){
			var effect_time=0;
		}
		jQuery(window ).scroll(animated_element);
		animated_element();
		setTimeout(function(){animated_element()},100)
		function animated_element(){			
			if(!element.hasClass('animated') && isScrolledIntoView())	{	
				setTimeout(function(){element.css("visibility","visible");element.addClass("animated");element.addClass(effect);},effect_time);			
			}	
		}		
		function isScrolledIntoView(){
			var $window = jQuery(window);
			var docViewTop = $window.scrollTop();
			var docViewBottom = docViewTop + $window.height();
			var elemTop = element.offset().top;
			var elemBottom = elemTop + parseInt(element.css('height'));			
			return ( ( (docViewTop<=elemTop+5) && (elemTop-5<=docViewBottom) )  || ( (docViewTop<=elemBottom+5) && (elemBottom-5<=docViewBottom) ) || (docViewTop==0 && docViewBottom==0) || $window.height()==0);
		}
	}
	$.fn.wpdevart_pricing_table = function(options) {
		var element = $(this);
		var parent_width=jQuery(element).parent().width();
		var columns_count=jQuery(element).children().length;
		var initial_widths=[];
		var rate_of_widths=[];
		var initial_margin;
		var min_widths=[];
		var mobile=false		
		initial_witdhs();		
		set_rates();
		correct_widths();
		correct_heights();
		jQuery(window).resize(function() {
			parent_width=jQuery(element).parent().width();
			correct_widths();
			correct_heights();
		});
		function is_mobile(){
			var loc_mobile=false;
			jQuery(element).children().each(function(column_index,column_element){
				if(min_widths[column_index] > (rate_of_widths[column_index]*parent_width)){
					loc_mobile=true;
				}				
			})
			if(mobile!=loc_mobile){
				if(loc_mobile){
					jQuery(element).addClass('wpdevart_pt_mobile');
					add_feature_row_info_to_columns();
					hide_information_columns();	
				}else{
					jQuery(element).removeClass('wpdevart_pt_mobile');
					show_information_columns();
					remove_feature_row_info_to_columns();
				}
			}
			mobile=loc_mobile;
			return mobile;
		}
		function set_rates(){
			var summ=0;
			var count=initial_widths.length
			for(var i=0;i<count;i++){
				summ+=parseInt(initial_widths[i]);
			}
			summ+=parseInt(initial_margin)*(count-1);
			for(i=0;i<count;i++){
				rate_of_widths.push(initial_widths[i]/summ);
			}
			rate_of_widths.push(parseInt(initial_margin)/summ);
		}
		function initial_witdhs(){
			jQuery(element).children().each(function(column_index,column_element){
				initial_widths.push(jQuery(column_element).attr('data-width'));
				min_widths.push(jQuery(column_element).attr('data-min-width'));
			});
			initial_margin=jQuery(element).children().eq(0).css('margin-right');
		}
		
		
		function correct_widths(){
			if(is_mobile()){
				jQuery(element).children().outerWidth('100%');				
			}else{
				jQuery(element).children().each(function(column_index,column_element){
					if(initial_widths[column_index]>rate_of_widths[column_index]*parent_width){
						jQuery(column_element).outerWidth(Math.floor(rate_of_widths[column_index]*parent_width));
						jQuery(column_element).css('margin-right',Math.floor(rate_of_widths[rate_of_widths.length-1]*parent_width)+'px');
					}else{
						jQuery(column_element).outerWidth(initial_widths[column_index]);
						jQuery(column_element).css('margin-right',initial_margin);
					}
				});
				jQuery(element).children().eq(rate_of_widths.length-2).css('margin-right','0px')
			}
		}
		function hide_information_columns(){
			jQuery(element).find('.wpdevart_pt_info_group').parent().addClass('wpdevart_hidden');
		}
		function show_information_columns(){
			jQuery(element).find('.wpdevart_pt_info_group').parent().removeClass('wpdevart_hidden');
		}
		function add_feature_row_info_to_columns(){
			jQuery(element).find('.wpdevart_pt_info_group').eq(0).children().each(function(info_elem_index,info_elem){
				var information_row_html=jQuery(info_elem).html();
				jQuery(element).children().find('.wpdevart_pt_column').each(function(column_elem_index,column_elem){
					jQuery(column_elem).children('.wpdevart_pt_feature').eq(info_elem_index).children().before('<span class="wpdevart_removable_info">'+information_row_html+' : </span>');
				})
			})
		}
		function remove_feature_row_info_to_columns(){
			jQuery(element).find('.wpdevart_removable_info').remove();
		}
		function correct_heights(){
			var head_height=0,footer_height=0;feature_heights=[],name_height=0,button_height=0,price_height=0;
			if(is_mobile()){
				jQuery(element).children().children('.wpdevart_pt_column').children().height('auto');
			}else{				
				jQuery(element).children().find('.wpdevart_pt_feature').height('auto');	
				jQuery(element).children().find('.wpdevart_pt_name').height('auto');
				jQuery(element).children().find('.wpdevart_pt_price').height('auto');	
				jQuery(element).children().find('.wpdevart_pt_button').height('auto');
				jQuery(element).children().each(function(column_index,column_element){
					jQuery(column_element).find('.wpdevart_pt_feature').each(function(feature_index,feature_element){
						if(typeof(feature_heights[feature_index])==='undefined'){
							feature_heights[feature_index]=jQuery(feature_element).outerHeight()
						}else{
							feature_heights[feature_index]=Math.max(feature_heights[feature_index],jQuery(feature_element).outerHeight());
						}
					});					
					name_height=Math.max(name_height,jQuery(column_element).find('.wpdevart_pt_name').outerHeight());
					price_height=Math.max(price_height,jQuery(column_element).find('.wpdevart_pt_price').outerHeight());
					button_height=Math.max(button_height,jQuery(column_element).find('.wpdevart_pt_button').outerHeight());
				});
				var elements_class_max_height={
					wpdevart_pt_name:name_height,
					wpdevart_pt_price:price_height,
					wpdevart_pt_button:button_height
				}
				index=jQuery(element).children().find('.wpdevart_pt_column').eq(0).children().index(jQuery(element).children().find('.wpdevart_pt_column').eq(0).find('.wpdevart_pt_feature').eq(0))
				for(var i = 0; i < index; i++){
					head_height= head_height+elements_class_max_height[jQuery(element).children().find('.wpdevart_pt_column').eq(0).children().eq(i).attr('class')];
				}
				footer_height=name_height+price_height+button_height-head_height;
				jQuery(element).children().each(function(column_index,column_element){
					jQuery(column_element).find('.wpdevart_pt_feature').each(function(feature_index,feature_element){						
						jQuery(feature_element).outerHeight(feature_heights[feature_index])						
					});					
					jQuery(column_element).find('.wpdevart_pt_name').outerHeight(name_height);
					jQuery(column_element).find('.wpdevart_pt_price').outerHeight(price_height);
					jQuery(column_element).find('.wpdevart_pt_button').outerHeight(button_height);
					jQuery(column_element).find('.wpdevart_pt_info_head').outerHeight(head_height);
					jQuery(column_element).find('.wpdevart_pt_info_fotter').outerHeight(footer_height);
				});				
			}
		}
	}
})(jQuery)