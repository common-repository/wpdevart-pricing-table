(function( blocks,  element ) {
	var el = element.createElement;
	var icon_iamge = el( 'img', {
      width: 24,
      height: 24,
      src: window['wpda_pricing_table_gutenberg']["other_data"]["icon_src"],
	  className: "wpda_pricing_table_gutenberg_icon"
    } );
	blocks.registerBlockType( 'wpdevart-pricingtable/pricingtable', {
		title: 'WpDevArt Pricing Table',
		icon: icon_iamge ,
		category: 'common',
		keywords:['table','pricing','price'],
		attributes: {			
			table: {
				type: 'string',
				selector: 'select',
			}
		},
		edit: function( props ) {
			var attributes = props.attributes;
			var table_options=new Array();
			var selected_option=false;
	
			for(var key in wpda_pricing_table_gutenberg["tables"]) {
				selected_option=false;
				if(typeof(attributes.table)=="undefined"){					
					props.setAttributes( { table: key })
					attributes.table=key;
				}else{
					if(props.attributes.table==key){
						selected_option=true;
					}
				}
				table_options.push(el('option',{value:''+key+'',selected:selected_option},wpda_pricing_table_gutenberg["tables"][key]))
			}
			
			
			return (
				el( 'div', { className: props.className },				   
				  el( 'div', { className: "wpdevart_gutenberg_pt_main_div"},
				    el( 'label', { },"Select a Table"),
					el( 'select', { className: "wpdevart_gutenberg_table_css",onChange: function( value ) {var select=value.target; props.setAttributes( { table: select.options[select.selectedIndex].value })}},table_options)
				  )
				)
			);
			
		},
		save: function( props ) {			
			return "[wpdevart_pricing_table id=\""+props.attributes.table+"\"]";
		}

	} )
} )(
	window.wp.blocks,
	window.wp.element
);