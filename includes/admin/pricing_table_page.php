<?php
class wpda_pricing_table_page{
	
	private $options;
	private $font_avesome_icon_list;
	function __construct(){	
		$this->get_fontawesome_icon_classes();
	}
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
		case 'add_wpda_pricing_table_menu':	
			$this->add_edit_table($id);
			break;
			
		case 'add_edit_table':	
			$this->add_edit_table($id);
			break;
		case 'duplicate':	
			$this->duplicate_table($id);
			$this->display_table_list();	
			break;
		case 'save_table':		
			if($id)	
				$this->update_table($id);
			else
				$this->save_table();
				
			$this->display_table_list();	
			break;
			
			
		case 'update_table':		
			if($id){
				$this->update_table($id);
			}else{
				$this->save_table();
				$_GET['id']=$wpdb->get_var("SELECT MAX(id) FROM ".wpda_pricing_table_databese::$table_names['columns']);
				$id=intval($_GET['id']);
			}
			$this->add_edit_table($id);
			break;
		case 'remove_table':	
			$this->remove_table($id);
			$this->display_table_list();
			break;				
		default:
			$this->display_table_list();
		}
	}

/*############  Save function  ################*/
	
	private function save_table(){
		global $wpdb;
		if(!(isset($_POST['feature']) && isset($_POST['price']) && isset($_POST['button_url']) && isset($_POST['button_text'])  && isset($_POST['title']))){
			?><div class="wpdevart_error"><p><strong><?php echo __("Save function error(Post information missing)","wpdevart_pricing_table"); ?></strong></p></div><?php
			return false;
		}
		$columns_array=array();
		$count_of_columns=count($_POST['title']);
		$features=array();
		$count_of_feature=0;
		if(isset($_POST['name']) && $_POST['name']!='' ){
			$name=sanitize_text_field($_POST['name']);
		}else{
			$name="Untitled";
		}
		for($i=0; $i<$count_of_columns; $i++){
			$features[$i]=explode("\r\n",$_POST['feature'][$i]);
			$count_of_feature=max($count_of_feature,count($features[$i]));
		}
		for($i=0; $i<$count_of_columns; $i++){
			$columns_array[$i]['title']=sanitize_text_field(stripslashes(htmlspecialchars($_POST['title'][$i])));
			$columns_array[$i]['price']=sanitize_text_field(stripslashes(htmlspecialchars($_POST['price'][$i])));
			$columns_array[$i]['feature']=array();
			for($k=0;$k<$count_of_feature;$k++){
				if(isset($features[$i][$k])){
					$columns_array[$i]['feature'][$k]=sanitize_text_field(stripslashes(htmlspecialchars($features[$i][$k])));
				}else{
					$columns_array[$i]['feature'][$k]="";
				}
			}

			$columns_array[$i]['button_url']=sanitize_text_field($_POST['button_url'][$i]);
			$columns_array[$i]['button_text']=sanitize_text_field(stripslashes(htmlspecialchars($_POST['button_text'][$i])));
			$columns_array[$i]['theme']=sanitize_text_field($_POST['theme'][$i]);
		}		
		$column_filds_ordering=explode(',',sanitize_text_field($_POST['column_fields_ordering']));
		unset($column_filds_ordering[4]);
		$widget_options=array();
		$widget_options["column_filds_ordering"]=$column_filds_ordering;
		$widget_options['distance_between_columns']=sanitize_text_field($_POST['distance_between_columns']);
		$widget_options['table_align']=sanitize_text_field($_POST['table_align']);
		$save_or_no=$wpdb->insert( wpda_pricing_table_databese::$table_names['columns'], 
			array( 
				'name' => $name,
				'columns' => json_encode($columns_array),
				'widget_options' =>json_encode($widget_options),
			), 
			array( 
				'%s', 
				'%s',
				'%s',
			) 
		);
		if($save_or_no){
			?><div class="wpdevart_updated"><p><strong><?php echo __("Item Saved","wpdevart_pricing_table"); ?></strong></p></div><?php
		}
		else{
			?><div id="message" class="wpdevart_error"><p><?php echo __("Error please reinstall plugin","wpdevart_pricing_table"); ?></p></div> <?php
		}
	}
	
/*############  Update table function  ################*/
	
	private function update_table($id){
		global $wpdb;
		if(!(isset($_POST['feature']) && isset($_POST['price']) && isset($_POST['button_url']) && isset($_POST['button_text'])  && isset($_POST['title']))){
			?><div class="wpdevart_error"><p><strong><?php echo __("Update function error(Post information missing)","wpdevart_pricing_table"); ?></strong></p></div><?php
			return false;
		}
		$columns_array=array();
		$count_of_columns=count($_POST['title']);
		$features=array();
		$count_of_feature=0;
		
		if(isset($_POST['name']) && $_POST['name']!='' ){
			$name=sanitize_text_field($_POST['name']);
		}else{
			$name="Untitled";
		}
		for($i=0; $i<$count_of_columns; $i++){
			$features[$i]=explode("\r\n",$_POST['feature'][$i]);
			$count_of_feature=max($count_of_feature,count($features[$i]));
		}
		for($i=0; $i<$count_of_columns; $i++){
			$columns_array[$i]['title']=sanitize_text_field(stripslashes(htmlspecialchars($_POST['title'][$i])));
			$columns_array[$i]['price']=sanitize_text_field(stripslashes(htmlspecialchars($_POST['price'][$i])));
			$columns_array[$i]['feature']=array();
			for($k=0;$k<$count_of_feature;$k++){
				if(isset($features[$i][$k])){
					$columns_array[$i]['feature'][$k]=sanitize_text_field(stripslashes(htmlspecialchars($features[$i][$k])));
				}else{
					$columns_array[$i]['feature'][$k]="";
				}
			}
			
			$columns_array[$i]['button_url']=sanitize_text_field(stripslashes(htmlspecialchars($_POST['button_url'][$i])));
			$columns_array[$i]['button_text']=sanitize_text_field(stripslashes(htmlspecialchars($_POST['button_text'][$i])));
			$columns_array[$i]['theme']=sanitize_text_field(stripslashes(htmlspecialchars($_POST['theme'][$i])));
		}		
		$column_filds_ordering=explode(',',sanitize_text_field($_POST['column_fields_ordering']));
		unset($column_filds_ordering[4]);
		$widget_options=array();
		$widget_options["column_filds_ordering"]=$column_filds_ordering;
		$widget_options['distance_between_columns']=sanitize_text_field($_POST['distance_between_columns']);
		$widget_options['table_align']=sanitize_text_field($_POST['table_align']);		
		$wpdb->update( wpda_pricing_table_databese::$table_names['columns'], 
			array( 
				'name' => $name,
				'columns' => json_encode($columns_array),
				'widget_options' =>json_encode($widget_options),
			), 
			array( 
				'id'=>$id 
			),
			array( 
				'%s',
				'%s', 
				'%s'
			),
			array( 
				'%d'
			)  
		);
		
		?><div class="wpdevart_updated"><p><strong><?php echo __("Item Saved","wpdevart_pricing_table"); ?></strong></p></div><?php
		
	}
	
	
	private function remove_table($id){
		global $wpdb;
		$wpdb->query($wpdb->prepare('DELETE FROM ' . wpda_pricing_table_databese::$table_names['columns'].' WHERE id="%d"', $id));
	}
	
	/*###################### Duplicate table function ##################*/		
	
	private function duplicate_table($id){
		global $wpdb;
		if(!$id){
			?><div id="message" class="error"><p><?php echo __("incorect table id","wpdevart_pricing_table"); ?></p></div> <?php
			return;
		}
		$table_info = $wpdb->get_row('SELECT * FROM '.wpda_pricing_table_databese::$table_names['columns'].' WHERE id='.$id);
		$name = $table_info->name;
		$save_or_no=$wpdb->insert( wpda_pricing_table_databese::$table_names['columns'], 
			array( 
				'name' => $name.'_copy',
				'columns' => $table_info->columns,
				'widget_options' => $table_info->widget_options,
			), 
			array( 
				'%s', 
				'%s',
				'%s',
			) 
		);
		if($save_or_no){
			?><div id="message" class="updated"><p><?php echo __("Table duplicated","wpdevart_pricing_table"); ?></p></div> <?php
		}else{			
			?><div id="message" class="error"><p><?php echo __("Error","wpdevart_pricing_table"); ?></p></div> <?php
		
		}
	}
	
	/*###################### Display table function ##################*/		
	
	private function display_table_list(){
		
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
						<a target="blank" href="https://wpdevart.com/wordpress-pricing-table-plugin/" class="wpdevart_upgrade"><?php echo __("Upgrade","wpdevart_pricing_table"); ?></a>
				</div>
				<a target="blank" href="<?php echo wpdevart_pricing_table_support_url; ?>" class="wpdevart_support"><?php echo __("Have any Questions? Get a quick support!","wpdevart_pricing_table"); ?></a>
			</div>
            <form method="post"  action="" id="admin_form" name="admin_form" ng-app="" ng-controller="customersController">
			<h2 class="wpda_pt_h2"><?php echo __("Pricing Table","wpdevart_pricing_table"); ?> <a href="admin.php?page=wpda_pricing_table_menu&task=add_wpda_pricing_table_menu" class="add-new-h2"><?php echo __("Add New","wpdevart_pricing_table"); ?></a></h2>            
   
            <div class="tablenav top" style="width:95%">  
                <input type="text" placeholder="<?php echo __("Search","wpdevart_pricing_table"); ?>" ng-change="filtering_table();" ng-model="searchText">            
                <div class="tablenav-pages"><span class="displaying-num">{{filtering_table().length}} <?php echo __("items","wpdevart_pricing_table"); ?></span>
                <span ng-show="(numberOfPages()-1)>=1">
                    <span class="pagination-links"><a class="button first-page" ng-class="{disabled:(curPage <= 1 )}" title="Go to the first page" ng-click="curPage=0;curect()">«</a>
                    <a class="button prev-page" title="Go to the previous page" ng-class="{disabled:(curPage <= 1 )}" ng-click="curPage=curPage-1; curect()">‹</a>
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
                        <th style="width:80px"><?php echo __("Edit","wpdevart_pricing_table"); ?></th>                        
                        <th style="width:120px"><?php echo __("Duplicate","wpdevart_pricing_table"); ?></th>						
                        <th  style="width:60px"><?php echo __("Delete","wpdevart_pricing_table"); ?></th>
                    </tr>
                </thead>
                <tbody>
                 <tr ng-repeat="rows in names | filter:filtering_table" class="description_row">
					 <td>{{rows.id}}</td>
					 <td><a href="admin.php?page=wpda_pricing_table_menu&task=add_edit_table&id={{rows.id}}">{{rows.name}}</a></td>
					 <td><a href="admin.php?page=wpda_pricing_table_menu&task=add_edit_table&id={{rows.id}}"><?php echo __("Edit","wpdevart_pricing_table"); ?></a></td>
					 <td><a href="admin.php?page=wpda_pricing_table_menu&task=duplicate&id={{rows.id}}"><?php echo __("Duplicate","wpdevart_pricing_table"); ?></a></td>
					 <td><a class="wpdevart_red" href="admin.php?page=wpda_pricing_table_menu&task=remove_table&id={{rows.id}}"><?php echo __("Delete","wpdevart_pricing_table"); ?></a></td>                               
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
		$query = "SELECT `id`,`name` FROM ".wpda_pricing_table_databese::$table_names['columns'];
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
	
	/*###################### Get pricing table function ##################*/		
	
	public static function get_pricing_table($id){
		global $wpdb;
		$pricing_table_info = $wpdb->get_row("SELECT * FROM ".wpda_pricing_table_databese::$table_names['columns'].' WHERE `id`='.$id);
		return $pricing_table_info;
	}	
	
	/*###################### Add/Edit table function ##################*/		
	
	private function add_edit_table($id=0){
		
		$name="";
		$columns='[]';
		$ordering=array("title","price","feature","button",);
		$column_width='280';
		$distance_between_columns='10';
		$table_align='left';
		if($id){
			$all_info=self::get_pricing_table($id);			
			$name=$all_info->name;
			$columns=$all_info->columns;
			$widget_options=$all_info->widget_options;			
			$widget_options=json_decode($widget_options,true);
			$ordering=$widget_options['column_filds_ordering'];
			$table_align=$widget_options['table_align'];
			$column_width=isset($widget_options['column_width'])?$widget_options['column_width']:'280';
			$distance_between_columns=isset($widget_options['distance_between_columns'])?$widget_options['distance_between_columns']:'10';
		}
		
		?>		         
		<form action="admin.php?page=wpda_pricing_table_menu<?php if($id) echo '&id='.$id; ?>" method="post" name="adminForm" class="top_description_table" id="adminForm">
            <div class="conteiner wrap">
                <div class="header">
                    <span><h2 class="wpda_table_title"><?php echo $id?__("Edit Pricing Table","wpdevart_pricing_table"):__("Add Pricing Table","wpdevart_pricing_table"); ?></h2></span>
                    <div class="header_action_buttons">
                        <span><input type="button" onclick="submitbutton('save_table')" value="<?php echo __("Save","wpdevart_pricing_table"); ?>" class="button-primary action"> </span> 
                        <span><input type="button" onclick="submitbutton('update_table')" value="<?php echo __("Apply","wpdevart_pricing_table"); ?>" class="button-primary action"> </span> 
                        <span><input type="button" onclick="window.location.href='admin.php?page=wpda_pricing_table_menu'" value="<?php echo __("Cancel","wpdevart_pricing_table"); ?>" class="button-secondary action"> </span> 
                    </div>
                </div>
				<div class="body">
					<input type="text" class="table_name" name="name" placeholder="<?php echo __("Enter title","wpdevart_pricing_table"); ?>" value="<?php echo $name; ?>">
					
					<div class="widget_info">
						<div class="widget_header"><h3><?php echo __("General Settings","wpdevart_pricing_table"); ?></h3></div>
						<div class="widget_option_title"><?php echo __("Column fields ordering:","wpdevart_pricing_table"); ?> <span class="pro_feature"><?php echo __("(pro)","wpdevart_pricing_table") ?></span></div>
						<ul id="ordering">
						<?php for($i=0;$i<count($ordering);$i++){ ?>
						<?php if($ordering[$i] == "title"){ ?>
						<li data-info="title" class="ordering_element"><span class="ordering_handle dashicons dashicons-move"></span><span class="title_oredeing_elem"><?php echo __("Column Title","wpdevart_pricing_table"); ?></span></li>
						<?php } 
						if($ordering[$i] == "price"){ ?>
						  <li data-info="price" class="ordering_element"><span class="ordering_handle dashicons dashicons-move"></span><span class="title_oredeing_elem"><?php echo __("Column Price","wpdevart_pricing_table"); ?></span></li>
						 <?php } 
						if($ordering[$i] == "feature"){ ?>
						 <li data-info="feature" class="ordering_element"><span class="ordering_handle dashicons dashicons-move"></span><span class="title_oredeing_elem"><?php echo __("Column Feature","wpdevart_pricing_table"); ?></span></li>
						 <?php } 
						if($ordering[$i] == "button"){ ?>
						 <li data-info="button" class="ordering_element"><span class="ordering_handle dashicons dashicons-move"></span><span class="title_oredeing_elem"><?php echo __("Column Button","wpdevart_pricing_table"); ?></span></li>
						<?php }} ?>
						</ul>
						<input type="hidden" name="column_fields_ordering" id="column_fields_ordering" value="<?php echo implode(',',$ordering); ?>">
						<div class="widget_option_title"><?php echo __("Distance between columns:","wpdevart_pricing_table"); ?></div>
						<input class="input wpdevart_widget_input" type="text" name="distance_between_columns" placeholder="10" value="<?php echo $distance_between_columns; ?>"><small>(Px)</small>
						<div class="widget_option_title"><?php echo __("Table align:","wpdevart_pricing_table"); ?></div>
						<select name="table_align">
							<option value="left" <?php selected('left',$table_align) ?> ><?php echo __("Left","wpdevart_pricing_table"); ?></option>
							<option value="center" <?php selected('center',$table_align) ?> ><?php echo __("Center","wpdevart_pricing_table"); ?></option>
							<option value="right" <?php selected('right',$table_align) ?> ><?php echo __("Right","wpdevart_pricing_table"); ?></option>
						</select>
						<div class="widget_option_title"><?php echo __("Click on icon, then copy the code and paste it where you need:","wpdevart_pricing_table"); ?></div>
						<input id="wpdevart_icon_html_input" type="text" class="input wpdevart_widget_input" style="width:95%">
						<div class="fonts_conteiner">
						<?php  
							__("Accessibility","wpdevart_pricing_table");
							__("Arrows","wpdevart_pricing_table");
							__("Audio & Video","wpdevart_pricing_table");
							__("Business","wpdevart_pricing_table");
							__("Chess","wpdevart_pricing_table");
							__("Code","wpdevart_pricing_table");
							__("Communication","wpdevart_pricing_table");
							__("Computers","wpdevart_pricing_table");
							__("Currency","wpdevart_pricing_table");
							__("Date & Time","wpdevart_pricing_table");
							__("Design","wpdevart_pricing_table");
							__("Editors","wpdevart_pricing_table");
							__("Files","wpdevart_pricing_table");
							__("Genders","wpdevart_pricing_table");
							__("Health","wpdevart_pricing_table");
							__("Images","wpdevart_pricing_table");
							__("Interfaces","wpdevart_pricing_table");
							__("Maps","wpdevart_pricing_table");
							__("Objects","wpdevart_pricing_table");
							__("Payments & Shopping","wpdevart_pricing_table");
							__("Shapes","wpdevart_pricing_table");
							__("Spinners","wpdevart_pricing_table");
							__("Sports","wpdevart_pricing_table");
							__("Status","wpdevart_pricing_table");
							__("Users & People","wpdevart_pricing_table");
							__("Vehicles","wpdevart_pricing_table");
							__("Writing","wpdevart_pricing_table");
							foreach($this->font_avesome_icon_list as $key=>$font_category){
								echo '<div class="font_category">'.__($key,"wpdevart_pricing_table").'</div>';
								foreach($font_category as $font){
									echo '<span class="set_this_font"><i class="'.$font.'"></i></span>';
								}
							}
						?>
						</div>
					</div>
					
					
					<div class="columns_main_div">
						<div class="column_head"><span><?php echo __("Pricing table columns","wpdevart_pricing_table") ?></span><button id="add_new_column" class="add-new-h2 add_new_column"><?php echo __("Add Column","wpdevart_pricing_table"); ?></button></div>
						<div id="column_body" class="column_body"></div>					
					</div>		
				</div>
            </div>
		</form>
		<?php
		echo '<script>
		
		wpda_pricing_table_class["themes"]='.json_encode($this->generete_theme_list_to_js_variable()).';
		wpda_pricing_table_class["columns_info"]='.$columns.';
		wpda_pricing_table_class["translated_words"]={remove:"'.__("Remove","wpdevart_pricing_table").'",title:"'.__("Title","wpdevart_pricing_table").'",price:"'.__("Price","wpdevart_pricing_table").'",fetured_line:"'.__("Features line","wpdevart_pricing_table").'",button_url:"'.__("Button Url","wpdevart_pricing_table").'",button_text:"'.__("Button text","wpdevart_pricing_table").'",select_theme:"'.__("Select the column theme","wpdevart_pricing_table").'"}
		wpda_pricing_table_class.start();
		</script>';
	}
	private function generete_theme_list_to_js_variable(){
		$themes=wpda_pricing_table_theme_page::get_theme_id_and_name();
		return $themes;
	}
	private function get_fontawesome_icon_classes(){
		$this->font_avesome_icon_list=["Accessibility"=>["fab fa-accessible-icon","fas fa-american-sign-language-interpreting","fas fa-assistive-listening-systems","fas fa-audio-description","fas fa-blind","fas fa-braille","fas fa-closed-captioning","far fa-closed-captioning","fas fa-deaf","fas fa-low-vision","fas fa-phone-volume","fas fa-question-circle","far fa-question-circle","fas fa-sign-language","fas fa-tty","fas fa-universal-access","fas fa-wheelchair"	],	"Arrows"=>["far fa-check-circle","fas fa-check-circle","far fa-check-square","fas fa-check-square","fas fa-check","fas fa-times","far fa-times-circle","fas fa-times-circle","fas fa-angle-double-down","fas fa-angle-double-left","fas fa-angle-double-right","fas fa-angle-double-up","fas fa-angle-down","fas fa-angle-left","fas fa-angle-right","fas fa-angle-up","fas fa-arrow-alt-circle-down","far fa-arrow-alt-circle-down","fas fa-arrow-alt-circle-left","far fa-arrow-alt-circle-left","fas fa-arrow-alt-circle-right","far fa-arrow-alt-circle-right","fas fa-arrow-alt-circle-up","far fa-arrow-alt-circle-up","fas fa-arrow-circle-down","fas fa-arrow-circle-left","fas fa-arrow-circle-right","fas fa-arrow-circle-up","fas fa-arrow-down","fas fa-arrow-left","fas fa-arrow-right","fas fa-arrow-up","fas fa-arrows-alt","fas fa-arrows-alt-h","fas fa-arrows-alt-v","fas fa-caret-down","fas fa-caret-left","fas fa-caret-right","fas fa-caret-square-down","far fa-caret-square-down","fas fa-caret-square-left","far fa-caret-square-left","fas fa-caret-square-right","far fa-caret-square-right","fas fa-caret-square-up","far fa-caret-square-up","fas fa-caret-up","fas fa-cart-arrow-down","fas fa-chart-line","fas fa-chevron-circle-down","fas fa-chevron-circle-left","fas fa-chevron-circle-right","fas fa-chevron-circle-up","fas fa-chevron-down","fas fa-chevron-left","fas fa-chevron-right","fas fa-chevron-up","fas fa-cloud-download-alt","fas fa-cloud-upload-alt","fas fa-download","fas fa-exchange-alt","fas fa-expand-arrows-alt","fas fa-external-link-alt","fas fa-external-link-square-alt","fas fa-hand-point-down","far fa-hand-point-down","fas fa-hand-point-left","far fa-hand-point-left","fas fa-hand-point-right","far fa-hand-point-right","fas fa-hand-point-up","far fa-hand-point-up","fas fa-hand-pointer","far fa-hand-pointer","fas fa-history","fas fa-level-down-alt","fas fa-level-up-alt","fas fa-location-arrow","fas fa-long-arrow-alt-down","fas fa-long-arrow-alt-left","fas fa-long-arrow-alt-right","fas fa-long-arrow-alt-up","fas fa-mouse-pointer","fas fa-play","fas fa-random","fas fa-recycle","fas fa-redo","fas fa-redo-alt","fas fa-reply","fas fa-reply-all","fas fa-retweet","fas fa-share","fas fa-share-square","far fa-share-square","fas fa-sign-in-alt","fas fa-sign-out-alt","fas fa-sort","fas fa-sort-alpha-down","fas fa-sort-alpha-up","fas fa-sort-amount-down","fas fa-sort-amount-up","fas fa-sort-down","fas fa-sort-numeric-down","fas fa-sort-numeric-up","fas fa-sort-up","fas fa-sync","fas fa-sync-alt","fas fa-text-height","fas fa-text-width","fas fa-undo","fas fa-undo-alt","fas fa-upload"	],	"Audio & Video"=>["fas fa-audio-description","fas fa-backward","fas fa-circle","far fa-circle","fas fa-closed-captioning","far fa-closed-captioning","fas fa-compress","fas fa-eject","fas fa-expand","fas fa-expand-arrows-alt","fas fa-fast-backward","fas fa-fast-forward","fas fa-file-audio","far fa-file-audio","fas fa-file-video","far fa-file-video","fas fa-film","fas fa-forward","fas fa-headphones","fas fa-microphone","fas fa-microphone-slash","fas fa-music","fas fa-pause","fas fa-pause-circle","far fa-pause-circle","fas fa-phone-volume","fas fa-play","fas fa-play-circle","far fa-play-circle","fas fa-podcast","fas fa-random","fas fa-redo","fas fa-redo-alt","fas fa-rss","fas fa-rss-square","fas fa-step-backward","fas fa-step-forward","fas fa-stop","fas fa-stop-circle","far fa-stop-circle","fas fa-sync","fas fa-sync-alt","fas fa-undo","fas fa-undo-alt","fas fa-video","fas fa-volume-down","fas fa-volume-off","fas fa-volume-up","fab fa-youtube"	],	"Business"=>["fas fa-address-book","far fa-address-book","fas fa-address-card","far fa-address-card","fas fa-archive","fas fa-balance-scale","fas fa-birthday-cake","fas fa-book","fas fa-briefcase","fas fa-building","far fa-building","fas fa-bullhorn","fas fa-bullseye","fas fa-calculator","fas fa-calendar","far fa-calendar","fas fa-calendar-alt","far fa-calendar-alt","fas fa-certificate","fas fa-chart-area","fas fa-chart-bar","far fa-chart-bar","fas fa-chart-line","fas fa-chart-pie","fas fa-clipboard","far fa-clipboard","fas fa-coffee","fas fa-columns","fas fa-compass","far fa-compass","fas fa-copy","far fa-copy","fas fa-copyright","far fa-copyright","fas fa-cut","fas fa-edit","far fa-edit","fas fa-envelope","far fa-envelope","fas fa-envelope-open","far fa-envelope-open","fas fa-envelope-square","fas fa-eraser","fas fa-fax","fas fa-file","far fa-file","fas fa-file-alt","far fa-file-alt","fas fa-folder","far fa-folder","fas fa-folder-open","far fa-folder-open","fas fa-globe","fas fa-industry","fas fa-paperclip","fas fa-paste","fas fa-pen-square","fas fa-pencil-alt","fas fa-percent","fas fa-phone","fas fa-phone-square","fas fa-phone-volume","fas fa-registered","far fa-registered","fas fa-save","far fa-save","fas fa-sitemap","fas fa-sticky-note","far fa-sticky-note","fas fa-suitcase","fas fa-table","fas fa-tag","fas fa-tags","fas fa-tasks","fas fa-thumbtack","fas fa-trademark"	],	"Chess"=>["fas fa-chess","fas fa-chess-bishop","fas fa-chess-board","fas fa-chess-king","fas fa-chess-knight","fas fa-chess-pawn","fas fa-chess-queen","fas fa-chess-rook","fas fa-square-full"	],	"Code"=>["fas fa-archive","fas fa-barcode","fas fa-bath","fas fa-bug","fas fa-code","fas fa-code-branch","fas fa-coffee","fas fa-file","far fa-file","fas fa-file-alt","far fa-file-alt","fas fa-file-code","far fa-file-code","fas fa-filter","fas fa-fire-extinguisher","fas fa-folder","far fa-folder","fas fa-folder-open","far fa-folder-open","fas fa-keyboard","far fa-keyboard","fas fa-microchip","fas fa-qrcode","fas fa-shield-alt","fas fa-sitemap","fas fa-terminal","fas fa-user-secret","fas fa-window-close","far fa-window-close","fas fa-window-maximize","far fa-window-maximize","fas fa-window-minimize","far fa-window-minimize","fas fa-window-restore","far fa-window-restore"	],	"Communication"=>["fas fa-address-book","far fa-address-book","fas fa-address-card","far fa-address-card","fas fa-american-sign-language-interpreting","fas fa-assistive-listening-systems","fas fa-at","fas fa-bell","far fa-bell","fas fa-bell-slash","far fa-bell-slash","fab fa-bluetooth","fab fa-bluetooth-b","fas fa-bullhorn","fas fa-comment","far fa-comment","fas fa-comment-alt","far fa-comment-alt","fas fa-comments","far fa-comments","fas fa-envelope","far fa-envelope","fas fa-envelope-open","far fa-envelope-open","fas fa-envelope-square","fas fa-fax","fas fa-inbox","fas fa-language","fas fa-microphone","fas fa-microphone-slash","fas fa-mobile","fas fa-mobile-alt","fas fa-paper-plane","far fa-paper-plane","fas fa-phone","fas fa-phone-square","fas fa-phone-volume","fas fa-rss","fas fa-rss-square","fas fa-tty","fas fa-wifi"	],	"Computers"=>["fas fa-desktop","fas fa-download","fas fa-hdd","far fa-hdd","fas fa-headphones","fas fa-keyboard","far fa-keyboard","fas fa-laptop","fas fa-microchip","fas fa-mobile","fas fa-mobile-alt","fas fa-plug","fas fa-power-off","fas fa-print","fas fa-save","far fa-save","fas fa-server","fas fa-tablet","fas fa-tablet-alt","fas fa-tv","fas fa-upload"	],	"Currency"=>["fab fa-bitcoin","fab fa-btc","fas fa-dollar-sign","fas fa-euro-sign","fab fa-gg","fab fa-gg-circle","fas fa-lira-sign","fas fa-money-bill-alt","far fa-money-bill-alt","fas fa-pound-sign","fas fa-ruble-sign","fas fa-rupee-sign","fas fa-shekel-sign","fas fa-won-sign","fas fa-yen-sign"	],	"Date & Time"=>["fas fa-bell","far fa-bell","fas fa-bell-slash","far fa-bell-slash","fas fa-calendar","far fa-calendar","fas fa-calendar-alt","far fa-calendar-alt","fas fa-calendar-check","far fa-calendar-check","fas fa-calendar-minus","far fa-calendar-minus","fas fa-calendar-plus","far fa-calendar-plus","fas fa-calendar-times","far fa-calendar-times","fas fa-clock","far fa-clock","fas fa-hourglass","far fa-hourglass","fas fa-hourglass-end","fas fa-hourglass-half","fas fa-hourglass-start","fas fa-stopwatch"	],	"Design"=>["fas fa-adjust","fas fa-clone","far fa-clone","fas fa-copy","far fa-copy","fas fa-crop","fas fa-crosshairs","fas fa-cut","fas fa-edit","far fa-edit","fas fa-eraser","fas fa-eye","fas fa-eye-dropper","fas fa-eye-slash","far fa-eye-slash","fas fa-object-group","far fa-object-group","fas fa-object-ungroup","far fa-object-ungroup","fas fa-paint-brush","fas fa-paste","fas fa-pencil-alt","fas fa-save","far fa-save","fas fa-tint"	],	"Editors"=>["fas fa-align-center","fas fa-align-justify","fas fa-align-left","fas fa-align-right","fas fa-bold","fas fa-clipboard","far fa-clipboard","fas fa-clone","far fa-clone","fas fa-columns","fas fa-copy","far fa-copy","fas fa-cut","fas fa-edit","far fa-edit","fas fa-eraser","fas fa-file","far fa-file","fas fa-file-alt","far fa-file-alt","fas fa-font","fas fa-heading","fas fa-i-cursor","fas fa-indent","fas fa-italic","fas fa-link","fas fa-list","fas fa-list-alt","far fa-list-alt","fas fa-list-ol","fas fa-list-ul","fas fa-outdent","fas fa-paper-plane","far fa-paper-plane","fas fa-paperclip","fas fa-paragraph","fas fa-paste","fas fa-pencil-alt","fas fa-print","fas fa-quote-left","fas fa-quote-right","fas fa-redo","fas fa-redo-alt","fas fa-reply","fas fa-reply-all","fas fa-share","fas fa-strikethrough","fas fa-subscript","fas fa-superscript","fas fa-sync","fas fa-sync-alt","fas fa-table","fas fa-tasks","fas fa-text-height","fas fa-text-width","fas fa-th","fas fa-th-large","fas fa-th-list","fas fa-trash","fas fa-trash-alt","far fa-trash-alt","fas fa-underline","fas fa-undo","fas fa-undo-alt","fas fa-unlink"	],	"Files"=>["fas fa-archive","fas fa-clone","far fa-clone","fas fa-copy","far fa-copy","fas fa-cut","fas fa-file","far fa-file","fas fa-file-alt","far fa-file-alt","fas fa-file-archive","far fa-file-archive","fas fa-file-audio","far fa-file-audio","fas fa-file-code","far fa-file-code","fas fa-file-excel","far fa-file-excel","fas fa-file-image","far fa-file-image","fas fa-file-pdf","far fa-file-pdf","fas fa-file-powerpoint","far fa-file-powerpoint","fas fa-file-video","far fa-file-video","fas fa-file-word","far fa-file-word","fas fa-folder","far fa-folder","fas fa-folder-open","far fa-folder-open","fas fa-paste","fas fa-save","far fa-save","fas fa-sticky-note","far fa-sticky-note"	],	"Genders"=>["fas fa-genderless","fas fa-mars","fas fa-mars-double","fas fa-mars-stroke","fas fa-mars-stroke-h","fas fa-mars-stroke-v","fas fa-mercury","fas fa-neuter","fas fa-transgender","fas fa-transgender-alt","fas fa-venus","fas fa-venus-double","fas fa-venus-mars"	],	"Hands"=>["fas fa-hand-lizard","far fa-hand-lizard","fas fa-hand-paper","far fa-hand-paper","fas fa-hand-peace","far fa-hand-peace","fas fa-hand-point-down","far fa-hand-point-down","fas fa-hand-point-left","far fa-hand-point-left","fas fa-hand-point-right","far fa-hand-point-right","fas fa-hand-point-up","far fa-hand-point-up","fas fa-hand-pointer","far fa-hand-pointer","fas fa-hand-rock","far fa-hand-rock","fas fa-hand-scissors","far fa-hand-scissors","fas fa-hand-spock","far fa-hand-spock","fas fa-handshake","far fa-handshake","fas fa-thumbs-down","far fa-thumbs-down","fas fa-thumbs-up","far fa-thumbs-up"	],	"Health"=>["fab fa-accessible-icon","fas fa-ambulance","fas fa-h-square","fas fa-heart","far fa-heart","fas fa-heartbeat","fas fa-hospital","far fa-hospital","fas fa-medkit","fas fa-plus-square","far fa-plus-square","fas fa-stethoscope","fas fa-user-md","fas fa-wheelchair"	],	"Images"=>["fas fa-adjust","fas fa-bolt","fas fa-camera","fas fa-camera-retro","fas fa-clone","far fa-clone","fas fa-compress","fas fa-expand","fas fa-eye","fas fa-eye-dropper","fas fa-eye-slash","far fa-eye-slash","fas fa-file-image","far fa-file-image","fas fa-film","fas fa-id-badge","far fa-id-badge","fas fa-id-card","far fa-id-card","fas fa-image","far fa-image","fas fa-images","far fa-images","fas fa-sliders-h","fas fa-tint"	],	"Interfaces"=>["fas fa-ban","fas fa-barcode","fas fa-bars","fas fa-beer","fas fa-bell","far fa-bell","fas fa-bell-slash","far fa-bell-slash","fas fa-bug","fas fa-bullhorn","fas fa-bullseye","fas fa-calculator","fas fa-calendar","far fa-calendar","fas fa-calendar-alt","far fa-calendar-alt","fas fa-calendar-check","far fa-calendar-check","fas fa-calendar-minus","far fa-calendar-minus","fas fa-calendar-plus","far fa-calendar-plus","fas fa-calendar-times","far fa-calendar-times","fas fa-certificate","fas fa-check","fas fa-check-circle","far fa-check-circle","fas fa-check-square","far fa-check-square","fas fa-circle","far fa-circle","fas fa-clipboard","far fa-clipboard","fas fa-clone","far fa-clone","fas fa-cloud","fas fa-cloud-download-alt","fas fa-cloud-upload-alt","fas fa-coffee","fas fa-cog","fas fa-cogs","fas fa-copy","far fa-copy","fas fa-cut","fas fa-database","fas fa-dot-circle","far fa-dot-circle","fas fa-download","fas fa-edit","far fa-edit","fas fa-ellipsis-h","fas fa-ellipsis-v","fas fa-envelope","far fa-envelope","fas fa-envelope-open","far fa-envelope-open","fas fa-eraser","fas fa-exclamation","fas fa-exclamation-circle","fas fa-exclamation-triangle","fas fa-external-link-alt","fas fa-external-link-square-alt","fas fa-eye","fas fa-eye-slash","far fa-eye-slash","fas fa-file","far fa-file","fas fa-file-alt","far fa-file-alt","fas fa-filter","fas fa-flag","far fa-flag","fas fa-flag-checkered","fas fa-folder","far fa-folder","fas fa-folder-open","far fa-folder-open","fas fa-frown","far fa-frown","fas fa-hashtag","fas fa-heart","far fa-heart","fas fa-history","fas fa-home","fas fa-i-cursor","fas fa-info","fas fa-info-circle","fas fa-language","fas fa-magic","fas fa-meh","far fa-meh","fas fa-microphone","fas fa-microphone-slash","fas fa-minus","fas fa-minus-circle","fas fa-minus-square","far fa-minus-square","fas fa-paste","fas fa-pencil-alt","fas fa-plus","fas fa-plus-circle","fas fa-plus-square","far fa-plus-square","fas fa-qrcode","fas fa-question","fas fa-question-circle","far fa-question-circle"	],	"Maps"=>["fas fa-ambulance","fas fa-anchor","fas fa-balance-scale","fas fa-bath","fas fa-bed","fas fa-beer","fas fa-bell","far fa-bell","fas fa-bell-slash","far fa-bell-slash","fas fa-bicycle","fas fa-binoculars","fas fa-birthday-cake","fas fa-blind","fas fa-bomb","fas fa-book","fas fa-bookmark","far fa-bookmark","fas fa-briefcase","fas fa-building","far fa-building","fas fa-car","fas fa-coffee","fas fa-crosshairs","fas fa-dollar-sign","fas fa-eye","fas fa-eye-slash","far fa-eye-slash","fas fa-fighter-jet","fas fa-fire","fas fa-fire-extinguisher","fas fa-flag","far fa-flag","fas fa-flag-checkered","fas fa-flask","fas fa-gamepad","fas fa-gavel","fas fa-gift","fas fa-glass-martini","fas fa-globe","fas fa-graduation-cap","fas fa-h-square","fas fa-heart","far fa-heart","fas fa-heartbeat","fas fa-home","fas fa-hospital","far fa-hospital","fas fa-image","far fa-image","fas fa-images","far fa-images","fas fa-industry","fas fa-info","fas fa-info-circle","fas fa-key","fas fa-leaf","fas fa-lemon","far fa-lemon","fas fa-life-ring","far fa-life-ring","fas fa-lightbulb","far fa-lightbulb","fas fa-location-arrow","fas fa-low-vision","fas fa-magnet","fas fa-male","fas fa-map","far fa-map","fas fa-map-marker","fas fa-map-marker-alt","fas fa-map-pin","fas fa-map-signs","fas fa-medkit","fas fa-money-bill-alt","far fa-money-bill-alt","fas fa-motorcycle","fas fa-music","fas fa-newspaper","far fa-newspaper","fas fa-paw","fas fa-phone","fas fa-phone-square","fas fa-phone-volume","fas fa-plane","fas fa-plug","fas fa-plus","fas fa-plus-square","far fa-plus-square","fas fa-print","fas fa-recycle","fas fa-road","fas fa-rocket","fas fa-search","fas fa-search-minus","fas fa-search-plus","fas fa-ship","fas fa-shopping-bag","fas fa-shopping-basket","fas fa-shopping-cart","fas fa-shower","fas fa-street-view","fas fa-subway","fas fa-suitcase","fas fa-tag","fas fa-tags","fas fa-taxi","fas fa-thumbtack"	],	"Objects"=>["fas fa-ambulance","fas fa-anchor","fas fa-archive","fas fa-balance-scale","fas fa-bath","fas fa-bed","fas fa-beer","fas fa-bell","far fa-bell","fas fa-bicycle","fas fa-binoculars","fas fa-birthday-cake","fas fa-bomb","fas fa-book","fas fa-bookmark","far fa-bookmark","fas fa-briefcase","fas fa-bug","fas fa-building","far fa-building","fas fa-bullhorn","fas fa-bullseye","fas fa-bus","fas fa-calculator","fas fa-calendar","far fa-calendar","fas fa-calendar-alt","far fa-calendar-alt","fas fa-camera","fas fa-camera-retro","fas fa-car","fas fa-clipboard","far fa-clipboard","fas fa-cloud","fas fa-coffee","fas fa-cog","fas fa-cogs","fas fa-compass","far fa-compass","fas fa-copy","far fa-copy","fas fa-cube","fas fa-cubes","fas fa-cut","fas fa-envelope","far fa-envelope","fas fa-envelope-open","far fa-envelope-open","fas fa-eraser","fas fa-eye","fas fa-eye-dropper","fas fa-fax","fas fa-fighter-jet","fas fa-file","far fa-file","fas fa-file-alt","far fa-file-alt","fas fa-film","fas fa-fire","fas fa-fire-extinguisher","fas fa-flag","far fa-flag","fas fa-flag-checkered","fas fa-flask","fas fa-futbol","far fa-futbol","fas fa-gamepad","fas fa-gavel","fas fa-gem","far fa-gem","fas fa-gift","fas fa-glass-martini","fas fa-globe","fas fa-graduation-cap","fas fa-hdd","far fa-hdd","fas fa-headphones","fas fa-heart","far fa-heart","fas fa-home","fas fa-hospital","far fa-hospital","fas fa-hourglass","far fa-hourglass","fas fa-image","far fa-image","fas fa-images","far fa-images","fas fa-industry","fas fa-key","fas fa-keyboard","far fa-keyboard","fas fa-laptop","fas fa-leaf","fas fa-lemon","far fa-lemon","fas fa-life-ring","far fa-life-ring","fas fa-lightbulb","far fa-lightbulb","fas fa-lock","fas fa-lock-open","fas fa-magic","fas fa-magnet","fas fa-map","far fa-map","fas fa-map-marker","fas fa-map-marker-alt"	],	"Payments & Shopping"=>["fab fa-amazon-pay","fab fa-apple-pay","fas fa-bell","far fa-bell","fas fa-bookmark","far fa-bookmark","fas fa-bullhorn","fas fa-camera","fas fa-camera-retro","fas fa-cart-arrow-down","fas fa-cart-plus","fab fa-cc-amazon-pay","fab fa-cc-amex","fab fa-cc-apple-pay","fab fa-cc-diners-club","fab fa-cc-discover","fab fa-cc-jcb","fab fa-cc-mastercard","fab fa-cc-paypal","fab fa-cc-stripe","fab fa-cc-visa","fas fa-certificate","fas fa-credit-card","far fa-credit-card","fab fa-ethereum","fas fa-gem","far fa-gem","fas fa-gift","fab fa-google-wallet","fas fa-handshake","far fa-handshake","fas fa-heart","far fa-heart","fas fa-key","fab fa-paypal","fas fa-shopping-bag","fas fa-shopping-basket","fas fa-shopping-cart","fas fa-star","far fa-star","fab fa-stripe","fab fa-stripe-s","fas fa-tag","fas fa-tags","fas fa-thumbs-down","far fa-thumbs-down","fas fa-thumbs-up","far fa-thumbs-up","fas fa-trophy"	],	"Shapes"=>["fas fa-bookmark","far fa-bookmark","fas fa-calendar","far fa-calendar","fas fa-certificate","fas fa-circle","far fa-circle","fas fa-cloud","fas fa-comment","far fa-comment","fas fa-file","far fa-file","fas fa-folder","far fa-folder","fas fa-heart","far fa-heart","fas fa-map-marker","fas fa-play","fas fa-square","far fa-square","fas fa-star","far fa-star"	],	"Spinners"=>["fas fa-asterisk","fas fa-certificate","fas fa-circle-notch","fas fa-cog","fas fa-compass","far fa-compass","fas fa-crosshairs","fas fa-life-ring","far fa-life-ring","fas fa-snowflake","far fa-snowflake","fas fa-spinner","fas fa-sun","far fa-sun","fas fa-sync"	],	"Sports"=>["fas fa-baseball-ball","fas fa-basketball-ball","fas fa-bowling-ball","fas fa-football-ball","fas fa-futbol","far fa-futbol","fas fa-golf-ball","fas fa-hockey-puck","fas fa-quidditch","fas fa-table-tennis","fas fa-volleyball-ball"	],	"Status"=>["fas fa-ban","fas fa-battery-empty","fas fa-battery-full","fas fa-battery-half","fas fa-battery-quarter","fas fa-battery-three-quarters","fas fa-bell","far fa-bell","fas fa-bell-slash","far fa-bell-slash","fas fa-calendar","far fa-calendar","fas fa-calendar-alt","far fa-calendar-alt","fas fa-calendar-check","far fa-calendar-check","fas fa-calendar-minus","far fa-calendar-minus","fas fa-calendar-plus","far fa-calendar-plus","fas fa-calendar-times","far fa-calendar-times","fas fa-cart-arrow-down","fas fa-cart-plus","fas fa-exclamation","fas fa-exclamation-circle","fas fa-exclamation-triangle","fas fa-eye","fas fa-eye-slash","far fa-eye-slash","fas fa-file","far fa-file","fas fa-file-alt","far fa-file-alt","fas fa-folder","far fa-folder","fas fa-folder-open","far fa-folder-open","fas fa-info","fas fa-info-circle","fas fa-lock","fas fa-lock-open","fas fa-minus","fas fa-minus-circle","fas fa-minus-square","far fa-minus-square","fas fa-plus","fas fa-plus-circle","fas fa-plus-square","far fa-plus-square","fas fa-question","fas fa-question-circle","far fa-question-circle","fas fa-shield-alt","fas fa-shopping-cart","fas fa-sign-in-alt","fas fa-sign-out-alt","fas fa-thermometer-empty","fas fa-thermometer-full","fas fa-thermometer-half","fas fa-thermometer-quarter","fas fa-thermometer-three-quarters","fas fa-thumbs-down","far fa-thumbs-down","fas fa-thumbs-up","far fa-thumbs-up","fas fa-toggle-off","fas fa-toggle-on","fas fa-unlock","fas fa-unlock-alt"	],	"Users & People"=>["fab fa-accessible-icon","fas fa-address-book","far fa-address-book","fas fa-address-card","far fa-address-card","fas fa-bed","fas fa-blind","fas fa-child","fas fa-female","fas fa-frown","far fa-frown","fas fa-id-badge","far fa-id-badge","fas fa-id-card","far fa-id-card","fas fa-male","fas fa-meh","far fa-meh","fas fa-power-off","fas fa-smile","far fa-smile","fas fa-street-view","fas fa-user","far fa-user","fas fa-user-circle","far fa-user-circle","fas fa-user-md","fas fa-user-plus","fas fa-user-secret","fas fa-user-times","fas fa-users","fas fa-wheelchair"	],	"Vehicles"=>["fab fa-accessible-icon","fas fa-ambulance","fas fa-bicycle","fas fa-bus","fas fa-car","fas fa-fighter-jet","fas fa-motorcycle","fas fa-paper-plane","far fa-paper-plane","fas fa-plane","fas fa-rocket","fas fa-ship","fas fa-shopping-cart","fas fa-space-shuttle","fas fa-subway","fas fa-taxi","fas fa-train","fas fa-truck","fas fa-wheelchair"	],	"Writing"=>["fas fa-archive","fas fa-book","fas fa-bookmark","far fa-bookmark","fas fa-edit","far fa-edit","fas fa-envelope","far fa-envelope","fas fa-envelope-open","far fa-envelope-open","fas fa-eraser","fas fa-file","far fa-file","fas fa-file-alt","far fa-file-alt","fas fa-folder","far fa-folder","fas fa-folder-open","far fa-folder-open","fas fa-keyboard","far fa-keyboard","fas fa-newspaper","far fa-newspaper","fas fa-paper-plane","far fa-paper-plane","fas fa-paperclip","fas fa-paragraph","fas fa-pen-square","fas fa-pencil-alt","fas fa-quote-left","fas fa-quote-right","fas fa-sticky-note","far fa-sticky-note","fas fa-thumbtack"	]];
	}
}

 ?>