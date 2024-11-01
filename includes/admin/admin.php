<?php

class wpda_pricing_table_admin_panel{
// previous defined admin constants
// wpda_pricing_table_plugin_url
// wpda_pricing_table_plugin_path

	private $text_fileds;
	
	function __construct(){
		$this->admin_filters();
	}

	/*###################### Function for filters ##################*/	
	
	private function admin_filters(){
		//hook for admin menu
		add_action( 'admin_menu', array($this,'create_admin_menu') );
		/* for post page button*/
		add_filter( 'mce_external_plugins', array( $this ,'mce_external_plugins' ) );
		add_filter( 'mce_buttons', array($this, 'mce_buttons' ) );
		add_action('wp_ajax_wpda_pricing_table_post_page_content', array($this,"post_page_popup_content"));
		if( is_admin() ){
			add_action( 'wp_default_scripts', array($this,'alpha_picker') );
		}
		$this->gutenberg();	
		
	}
	
	/*###################### Alpha picker function ##################*/	
	
	public function alpha_picker( $scripts ){
		$scripts->add( 'wp-color-picker', "/wp-admin/js/color-picker.js", array( 'iris' ), false, 1 );
		did_action( 'init' ) && $scripts->localize(
			'wp-color-picker',
			'wpColorPickerL10n',
			array(
				'clear'            => __( 'Clear' ),
				'clearAriaLabel'   => __( 'Clear color' ),
				'defaultString'    => __( 'Default' ),
				'defaultAriaLabel' => __( 'Select default color' ),
				'pick'             => __( 'Select Color' ),
				'defaultLabel'     => __( 'Color value' ),
			)
		);
	}
	//connect admin menu
	public function create_admin_menu(){
		global $submenu;
		/* connect admin pages to WordPress core*/
		$main_page=add_menu_page( "Pricing Table", __("Pricing Table","wpdevart_pricing_table"), 'manage_options', "wpda_pricing_table_menu", array($this, 'create_pricing_table'),wpda_pricing_table_plugin_url.'includes/admin/images/small_icon.png');
		add_submenu_page( "wpda_pricing_table_menu", __("Pricing Tables","wpdevart_pricing_table"), __("Pricing Tables","wpdevart_pricing_table"), 'manage_options',"wpda_pricing_table_menu",array($this, 'create_pricing_table'));
		$pricing_table_theme=add_submenu_page( "wpda_pricing_table_menu",  __("Column Themes","wpdevart_pricing_table"), __("Column Themes","wpdevart_pricing_table"), 'manage_options',"wpda_pricing_table_themes",array($this, 'pricing_table_themes_page'));			
		add_submenu_page( "wpda_pricing_table_menu", __("Featured Plugins","wpdevart_pricing_table"), __("Featured Plugins","wpdevart_pricing_table"), 'manage_options',"wpda_pricing_table_featured_plugins",array($this, 'featured_plugins'));
		/*for including page styles and scripts*/
		add_action('admin_print_styles-' .$main_page, array($this,'create_pricing_table_style_js'));
		add_action('admin_print_styles-' .$pricing_table_theme, array($this,'create_theme_page_style_js'));		
		
		if(isset($submenu['wpda_pricing_table_menu']))
			add_submenu_page( 'wpda_pricing_table_menu', __("Support or Any Ideas?","wpdevart_pricing_table"), "<span style='color:#00ff66' >".__("Support or Any Ideas?","wpdevart_pricing_table")."</span>", 'manage_options',"wpdevart_pt_any_ideas",array($this, 'any_ideas'),155);
		if(isset($submenu['wpda_pricing_table_menu']))
			$submenu['wpda_pricing_table_menu'][3][2]=wpdevart_pricing_table_support_url;
	}
	
	/*###################### Any ideas function ##################*/		
	
	public function any_ideas(){
		
	}
	/* timer page style and js*/	
	public function create_pricing_table_style_js(){
		
		//scripts
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('jquery-ui-datepicker');		
		wp_enqueue_script( 'jquery-ui-spinner');	
		wp_enqueue_script("jquery-ui-date-time-picker-js");
		wp_enqueue_script("jquery-ui-date-time-picker-js");
		wp_enqueue_script('angularejs',wpda_pricing_table_plugin_url.'includes/admin/js/angular.min.js');
		wp_enqueue_script("wpda_pricing_table_admin_main",wpda_pricing_table_plugin_url.'includes/admin/js/pricing_table.js');
		//styles
		wp_enqueue_style( 'jquery-ui' );
		wp_enqueue_style('wpda_pricing_table_admin_main_css',wpda_pricing_table_plugin_url.'includes/admin/css/pricing_table.css');
		wp_enqueue_style('jquery-ui-date-time-picker-css');
		wp_enqueue_style( 'font-awesome-5');
				
	}
	
	/* Themes page style and js*/	
	public function create_theme_page_style_js(){
		wp_enqueue_script('jquery');
		wp_enqueue_style( 'jquery-ui' );
		wp_enqueue_script('jquery-ui-slider');	
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'alpha-color-picker', wpda_pricing_table_plugin_url.'includes/admin/js/alpha-color-picker.js', array( 'wp-color-picker' ),'2.4',true );
		wp_enqueue_script('angularejs',wpda_pricing_table_plugin_url.'includes/admin/js/angular.min.js');
		wp_enqueue_style('wpda_contdown_extend_timer_page_css',wpda_pricing_table_plugin_url.'includes/admin/css/theme_page.css');
		wp_enqueue_script("wpda_contdown_extend_timer_page_js",wpda_pricing_table_plugin_url.'includes/admin/js/theme_page.js');
	}
	
	/* Popup page style and js*/	
	public function create_popup_page_style_js(){		
		wp_enqueue_style('FontAwesome');
		wp_enqueue_script('jquery');
		wp_enqueue_style( 'jquery-ui' );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script( 'wpdevart_chosen' );
		wp_enqueue_script( 'wpdevart_prism' );
		wp_enqueue_style('wpda_contdown_extend_admin_popup_page_css',wpda_pricing_table_plugin_url.'includes/admin/css/popup_page.css');
		wp_enqueue_script('wpda_contdown_extend_admin_popup_page_css',wpda_pricing_table_plugin_url.'includes/admin/js/popup_page.js');
		if (function_exists('wp_enqueue_media')) wp_enqueue_media();
	}
	
	/* Timer page main*/	
	public function create_pricing_table(){				
		$pricing_table=new wpda_pricing_table_page();
		$pricing_table->controller_page();	
	}	
	/* themes*/		
	public function pricing_table_themes_page(){	
		$theme_page_objet=new wpda_pricing_table_theme_page();	
		$theme_page_objet->controller_page();
	}
	
	
	
	/*post page button*/
	public function mce_external_plugins( $plugin_array ) {
		$plugin_array["wpda_pricing_table"] = wpda_pricing_table_plugin_url.'includes/admin/js/post_page_insert_button.js';
		return $plugin_array;
	}
	/*post page button add_class*/
	public function mce_buttons( $buttons ) {
		array_push( $buttons, "wpda_pricing_table" );
		return $buttons;
	}
	/*post page button insert in content*/
	public function post_page_popup_content(){	
		require_once(wpda_pricing_table_plugin_path.'includes/admin/post_page_popup.php');
		$popup_page_objet=new wpda_pricing_table_post_page_popup();		
	}
	/*concect with gutenberg editor*/
	public function gutenberg(){	
		require_once(wpda_pricing_table_plugin_path.'includes/admin/gutenberg/gutenberg.php');
		$gutenberg=new wpda_pricing_table_gutenberg();		
		
	}
		/*############################### Featured plugins function ########################################*/
	
	public function featured_plugins(){
		$plugins_array=array(
			'gallery_album'=>array(
						'image_url'		=>	wpda_pricing_table_plugin_url.'includes/admin/images/featured_plugins/gallery-album-icon.png',
						'site_url'		=>	'http://wpdevart.com/wordpress-gallery-plugin',
						'title'			=>	__('WordPress Gallery plugin',"wpdevart_pricing_table"),
						'description'	=>	__('The WpDevArt gallery plugin is a useful tool that will help you to create Galleries and Albums. Try our nice Gallery views and awesome animations.',"wpdevart_pricing_table")
						),	
			'countdown-extended'=>array(
						'image_url'		=>	wpda_pricing_table_plugin_url.'includes/admin/images/featured_plugins/icon-128x128.png',
						'site_url'		=>	'https://wpdevart.com/wordpress-countdown-extended-version/',
						'title'			=>	__('WordPress Countdown Extended',"wpdevart_pricing_table"),
						'description'	=>	__('Countdown extended is a fresh and extended version of the countdown timer. You can easily create and add countdown timers to your website.',"wpdevart_pricing_table")
						),						
			'coming_soon'=>array(
						'image_url'		=>	wpda_pricing_table_plugin_url.'includes/admin/images/featured_plugins/coming_soon.png',
						'site_url'		=>	'http://wpdevart.com/wordpress-coming-soon-plugin/',
						'title'			=>	__('Coming soon and Maintenance mode',"wpdevart_pricing_table"),
						'description'	=>	__('Coming soon and Maintenance mode plugin is an awesome tool to show your visitors that you are working on your website to make it better.',"wpdevart_pricing_table")
						),
			'Contact forms'=>array(
						'image_url'		=>	wpda_pricing_table_plugin_url.'includes/admin/images/featured_plugins/contact_forms.png',
						'site_url'		=>	'http://wpdevart.com/wordpress-contact-form-plugin/',
						'title'			=>	__('Contact Form Builder',"wpdevart_pricing_table"),
						'description'	=>	__('Contact Form Builder plugin is a handy tool for creating different types of contact forms on your WordPress websites.',"wpdevart_pricing_table")
						),	
			'Booking Calendar'=>array(
						'image_url'		=>	wpda_pricing_table_plugin_url.'includes/admin/images/featured_plugins/Booking_calendar_featured.png',
						'site_url'		=>	'http://wpdevart.com/wordpress-booking-calendar-plugin/',
						'title'			=>	__('WordPress Booking Calendar',"wpdevart_pricing_table"),
						'description'	=>	__('WordPress Booking Calendar plugin is an awesome tool to create a booking system for your website. Create booking calendars in a few minutes.',"wpdevart_pricing_table")
						),
			'chart'=>array(
						'image_url'		=>	wpda_pricing_table_plugin_url.'includes/admin/images/featured_plugins/chart-featured.png',
						'site_url'		=>	'https://wpdevart.com/wordpress-organization-chart-plugin/',
						'title'			=>	__('WordPress Organization Chart',"wpdevart_pricing_table"),
						'description'	=>	__('WordPress organization chart plugin is a great tool for adding organizational charts to your WordPress websites.',"wpdevart_pricing_table")
						),						
			'youtube'=>array(
						'image_url'		=>	wpda_pricing_table_plugin_url.'includes/admin/images/featured_plugins/youtube.png',
						'site_url'		=>	'http://wpdevart.com/wordpress-youtube-embed-plugin',
						'title'			=>	__('WordPress YouTube Embed',"wpdevart_pricing_table"),
						'description'	=>	__('YouTube Embed plugin is a convenient tool for adding videos to your website. Use YouTube Embed plugin for adding YouTube videos in posts/pages, widgets.',"wpdevart_pricing_table")
						),
            'facebook-comments'=>array(
						'image_url'		=>	wpda_pricing_table_plugin_url.'includes/admin/images/featured_plugins/facebook-comments-icon.png',
						'site_url'		=>	'http://wpdevart.com/wordpress-facebook-comments-plugin/',
						'title'			=>	__('Wpdevart Social comments',"wpdevart_pricing_table"),
						'description'	=>	__('WordPress Facebook comments plugin will help you to display Facebook Comments on your website. You can use Facebook Comments on your pages/posts.',"wpdevart_pricing_table")
						),						
			'countdown'=>array(
						'image_url'		=>	wpda_pricing_table_plugin_url.'includes/admin/images/featured_plugins/countdown.jpg',
						'site_url'		=>	'http://wpdevart.com/wordpress-countdown-plugin/',
						'title'			=>	__('WordPress Countdown plugin',"wpdevart_pricing_table"),
						'description'	=>	__('WordPress Countdown plugin is a nice tool for creating countdown timers for your website posts/pages and widgets.',"wpdevart_pricing_table")
						),
			'lightbox'=>array(
						'image_url'		=>	wpda_pricing_table_plugin_url.'includes/admin/images/featured_plugins/lightbox.png',
						'site_url'		=>	'http://wpdevart.com/wordpress-lightbox-plugin',
						'title'			=>	__('WordPress Lightbox plugin',"wpdevart_pricing_table"),
						'description'	=>	__('WordPress Lightbox Popup is a highly customizable and responsive plugin for displaying images and videos in the popup.',"wpdevart_pricing_table")
						),
			'facebook'=>array(
						'image_url'		=>	wpda_pricing_table_plugin_url.'includes/admin/images/featured_plugins/facebook.png',
						'site_url'		=>	'http://wpdevart.com/wordpress-facebook-like-box-plugin',
						'title'			=>	__('Social Like Box',"wpdevart_pricing_table"),
						'description'	=>	__('Facebook like box plugin will help you to display Facebook like box on your website, just add Facebook Like box widget to the sidebar or insert it into posts/pages and use it.',"wpdevart_pricing_table")
						),
			'vertical_menu'=>array(
						'image_url'		=>	wpda_pricing_table_plugin_url.'includes/admin/images/featured_plugins/vertical-menu.png',
						'site_url'		=>	'https://wpdevart.com/wordpress-vertical-menu-plugin/',
						'title'			=>	__('WordPress Vertical Menu',"wpdevart_pricing_table"),
						'description'	=>	__('WordPress Vertical Menu is a handy tool for adding nice vertical menus. You can add icons for your website vertical menus using our plugin.',"wpdevart_pricing_table")
						),						
			'poll'=>array(
						'image_url'		=>	wpda_pricing_table_plugin_url.'includes/admin/images/featured_plugins/poll.png',
						'site_url'		=>	'http://wpdevart.com/wordpress-polls-plugin',
						'title'			=>	__('WordPress Polls system',"wpdevart_pricing_table"),
						'description'	=>	__('WordPress Polls system is a handy tool for creating polls and survey forms for your visitors. You can use our polls on widgets, posts, and pages.',"wpdevart_pricing_table")
						),
			'duplicate_page'=>array(
						'image_url'		=>	wpda_pricing_table_plugin_url.'includes/admin/images/featured_plugins/featured-duplicate.png',
						'site_url'		=>	'https://wpdevart.com/wordpress-duplicate-page-plugin-easily-clone-posts-and-pages/',
						'title'			=>	__('WordPress Duplicate page',"wpdevart_pricing_table"),
						'description'	=>	__('Duplicate Page or Post is a great tool that allows duplicating pages and posts. Now you can do it with one click.',"wpdevart_pricing_table")
						),						
						
			
		);
		?>
        <style>
         .featured_plugin_main{
			background-color: #ffffff;
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box;
			float: left;
			margin-right: 30px;
			margin-bottom: 30px;
			width: calc((100% - 90px)/3);
			border-radius: 15px;
			box-shadow: 1px 1px 7px rgba(0,0,0,0.04);
			padding: 20px 25px;
			text-align: center;
			-webkit-transition:-webkit-transform 0.3s;
			-moz-transition:-moz-transform 0.3s;
			transition:transform 0.3s;   
			-webkit-transform: translateY(0);
			-moz-transform: translateY0);
			transform: translateY(0);
			min-height: 344px;
		 }
		.featured_plugin_main:hover{
			-webkit-transform: translateY(-2px);
			-moz-transform: translateY(-2px);
			transform: translateY(-2px);
		 }
		.featured_plugin_image{
			max-width: 128px;
			margin: 0 auto;
		}
		.blue_button{
    display: inline-block;
    font-size: 15px;
    text-decoration: none;
    border-radius: 5px;
    color: #ffffff;
    font-weight: 400;
    opacity: 1;
    -webkit-transition: opacity 0.3s;
    -moz-transition: opacity 0.3s;
    transition: opacity 0.3s;
    background-color: #7052fb;
    padding: 10px 22px;
    text-transform: uppercase;
		}
		.blue_button:hover,
		.blue_button:focus {
			color:#ffffff;
			box-shadow: none;
			outline: none;
		}
		.featured_plugin_image img{
			max-width: 100%;
		}
		.featured_plugin_image a{
		  display: inline-block;
		}
		.featured_plugin_information{	

		}
		.featured_plugin_title{
	color: #7052fb;
	font-size: 18px;
	display: inline-block;
		}
		.featured_plugin_title a{
	text-decoration:none;
	font-size: 19px;
    line-height: 22px;
	color: #7052fb;
					
		}
		.featured_plugin_title h4{
			margin: 0px;
			margin-top: 20px;		
			min-height: 44px;	
		}
		.featured_plugin_description{
			font-size: 14px;
				min-height: 63px;
		}
		@media screen and (max-width: 1460px){
			.featured_plugin_main {
				margin-right: 20px;
				margin-bottom: 20px;
				width: calc((100% - 60px)/3);
				padding: 20px 10px;
			}
			.featured_plugin_description {
				font-size: 13px;
				min-height: 63px;
			}
		}
		@media screen and (max-width: 1279px){
			.featured_plugin_main {
				width: calc((100% - 60px)/2);
				padding: 20px 20px;
				min-height: 363px;
			}	
		}
		@media screen and (max-width: 768px){
			.featured_plugin_main {
				width: calc(100% - 30px);
				padding: 20px 20px;
				min-height: auto;
				margin: 0 auto 20px;
				float: none;
			}	
			.featured_plugin_title h4{
				min-height: auto;
			}	
			.featured_plugin_description{
				min-height: auto;
					font-size: 14px;
			}	
		}

        </style>
      
		<h1 style="text-align: center;font-size: 50px;font-weight: 700;color: #2b2350;margin: 20px auto 25px;line-height: 1.2;">Featured Plugins</h1>
		<?php foreach($plugins_array as $key=>$plugin) { ?>
		<div class="featured_plugin_main">
			<div class="featured_plugin_image"><a target="_blank" href="<?php echo $plugin['site_url'] ?>"><img src="<?php echo $plugin['image_url'] ?>"></a></div>
			<div class="featured_plugin_information">
				<div class="featured_plugin_title"><h4><a target="_blank" href="<?php echo $plugin['site_url'] ?>"><?php echo $plugin['title'] ?></a></h4></div>
				<p class="featured_plugin_description"><?php echo $plugin['description'] ?></p>
				<a target="_blank" href="<?php echo $plugin['site_url'] ?>" class="blue_button">Check The Plugin</a>
			</div>
			<div style="clear:both"></div>                
		</div>
		<?php } 
	}
	
}
?>
