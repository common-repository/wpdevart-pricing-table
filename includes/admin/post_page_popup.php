<?php

class wpda_pricing_table_post_page_popup{	
	function __construct(){
		$this->generete_html();
	}
	private function required_js_and_style(){
		wp_print_scripts("jquery");
		?>
		<script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
		<script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
		<script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
		<?php
	}
	
	/*###################### Generate HTML function ##################*/		
	
	private function generete_html(){
		?>
		<!DOCTYPE html>
		<!--[if IE 8]>
		<html xmlns="http://www.w3.org/1999/xhtml" class="ie8 wp-toolbar"  >
		<![endif]-->
		<!--[if !(IE 8) ]><!-->
		<html xmlns="http://www.w3.org/1999/xhtml">
		<!--<![endif]-->
		<head>
			<?php
			$this->required_js_and_style();
			?>
			<title>WpDevArt Pricing Table</title>
			<style>
				table tr{
					height: 40px;
				}
				
			</style>
           </head><body>
            <table width="100%" style="min-height:200px;" class="paramlist admintable" cellspacing="1">
                <tbody>
                    <tr>
                        <td style="width: 150px;vertical-align: top;" class="paramlist_key">
                            <span class="editlinktip">
                                <label style="font-size:12px" class="hasTip">Select Table: </label>
                            </span>
                        </td>
                        <td style="vertical-align:top;" class="paramlist_value" >                        
							<select style="font-size:13px" id="select_table">
								<?php $this->print_tables() ?>
							</select>  
							<div><a target="_blank" style="text-decoration: none; color: #5b9dd9; font-size: 14px;" href="<?php echo get_admin_url().'admin.php?page=wpda_pricing_table_menu&task=add_wpda_pricing_table_menu'  ?>">(Add new table)</a></div>      
                        </td>
                    </tr>
                </tbody>
            </table>
       		<div class="mceActionPanel">
                <div style="float: left">
                    <input type="button" id="cancel" name="cancel" value="Cancel" onClick="tinyMCEPopup.close();"/>
                </div>
    
                <div style="float: right">
                    <input type="submit" id="insert" name="insert" value="Insert" onClick="insert_poll();"/>
                    <input type="hidden" name="iden" value="1"/>
                </div>
            </div>
        
    
        	<script type="text/javascript">
				function insert_poll() {					  
					if(jQuery('#wpdevart_forms_id').val()!='0'){
						var tagtext;
						tagtext = '<p>[wpdevart_pricing_table id="' + jQuery('#select_table').val()+'"]</p>';
						window.parent.tinyMCE.execCommand('mceInsertContent', false, tagtext);
						tinyMCEPopup.close();
					}
					else{
						tinyMCEPopup.close();
					}
				}  
			</script>
        	</body></html>
				<?php
		die();
	}

		/*###################### Print Tables function ##################*/
		
	private function print_tables(){
		global $wpdb;
		$tables=$wpdb->get_results('SELECT `id`,`name` FROM ' . wpda_pricing_table_databese::$table_names['columns']);
		$table_id=0;
		if(isset($_GET['table_id']))
			$table_id=(int)sanitize_text_field($_GET['table_id']);
		foreach($tables as $table){
			?><option <?php selected($table_id,$table->id); ?> value="<?php echo $table->id ?>"><?php echo $table->name ?></option><?php 
		}
	}
}
?>
