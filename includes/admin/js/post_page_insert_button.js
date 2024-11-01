(function($) {
	tinymce.PluginManager.add('wpda_pricing_table', function( editor, url ) {
		var sh_tag = 'wpda_pricing_table';
		//helper functions 
		
		//add popup
		editor.addCommand('wpda_pricing_table_popup', function() {
			button_object = {
				title: 'WpDevArt Pricing Table', 
				file:  document.location.origin+ajaxurl + '?action=wpda_pricing_table_post_page_content', 
				width: 400, 
				height: 250,   
				id : 'my-custom-wpdialog',
				inline: 1          					
			};
		   editor_loc_object={
				editor: editor,  
				jquery: $,  								
				plugin_url : url
				//php_version: php_version   
			};		  
			editor.windowManager.open( button_object,  editor_loc_object);			
		});

		//add button
		editor.addButton('wpda_pricing_table', {
			image : url.replace('/js','/images') + '/icon.png',			
			//icon: 'wpda_pricing_table',
			tooltip: 'WpDevArt Pricing Table',
			onclick: function() {	
				editor.execCommand('wpda_pricing_table_popup','',{});
			}
		});
	});
})(jQuery);