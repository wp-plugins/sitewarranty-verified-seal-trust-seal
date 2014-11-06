<?php
if(!class_exists('Sitestillup')) {
	class Sitestillup {
		private $options = array();
		private static $instance = null;
		
		public function __construct() {	
			global $wpdb, $post;	
			self::$instance = $this;
	
			$opts = $this->get_options();
			
			// widget hooks
			add_action( 'widgets_init', array( $this, 'register_widget' ) );
			
			add_action( 'admin_enqueue_scripts', array($this,'stu_scripts') );
			add_action('admin_menu', array($this, 'sitestill_menu'));				
			add_action( 'admin_init', array($this, 'register_stu_id') );
			add_shortcode( 'webcertificate', array($this, 'webcertificate_func') );
			add_action( 'admin_init', array($this,'register_my_setting') );				        
			
			add_action('woocommerce_after_cart_table', array($this,'webcen') );	
			add_action('woocommerce_single_product_summary', array($this, 'webcer') );								
		}
			   
		/**
		 * Initialize Sitestillup Scripts		 		
		 */	
		public function stu_scripts(){
			if( $_GET['page'] == 'warranty_settings' ){
				wp_register_style('stu_style', plugins_url('/css/stu_style.css',__FILE__) );					
				wp_register_script('ava-js', plugins_url( '/js/sw.js', __FILE__ ), array('jquery'), '1.1', true);			
				wp_enqueue_style('stu_style'); 
				wp_enqueue_script( 'ava-js');									
			}
			wp_localize_script( 'stu-scripts', 'sort_vars', 
				array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) 
			);				
			
		}
		/**
		 * Initialize Sitestillup Menu		 		
		 */	
		public function sitestill_menu() {
			add_menu_page('Sitestillup', 'Sitestillup', 'administrator', 'warranty_settings', array($this,'stu_settings'), STU_PLUGIN_URL.'includes/img/favicon-16.png' );
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 
			$plugin = 'woocommerce/woocommerce.php';
			if(is_plugin_active($plugin))
			{			
				add_submenu_page('warranty_settings', 'CSSEditor', 'Woocommerce CSS', 'administrator', 'css_editor', 'Update_css' );	
			}
		}
		
		public function register_stu_id() {
			register_setting( 'stu_warrenty_id', 'stu_warrenty_id', array($this,'stu_warranty_id') ); 
		} 
				
		public function stu_warranty_id($options){	
			$options['sitestillup'] = sanitize_text_field( (isset($_POST['sitestillup'])) ? $_POST['sitestillup'] : '' );		
			return $options;		
		}
		
		public function stu_settings()
		{
			include('stu_settings.php');
		}
		/**
		 * Initialize Shortcode webcertificate
		 *
		 * @return array $options
		 */
		public function webcertificate_func( $atts = '' ){
			$opts = $this->get_options();		
			if($opts['sitestillup']!='')
			{
				return "<div class='wc_seal'><script type='text/javascript' 
				src='https://www.sitestillup.com/cgi-bin/sws/uls.cgi?getCert=".$opts['sitestillup']."&sealstyle=".$opts['stu_style']."&sealsize=".$opts['size']."&protocol=".$opts['stu_protocol']."'></script></div>";
			}
			else
				return;
		}	
		
		/**
		 * Update Settings Page
		 *
		 * @return array $options
		 */
		public function register_my_setting() {
			register_setting( 'stu-settings-page', 'stu_settings', array($this,'stu_settings_options') ); 
		} 
				
		public function stu_settings_options($options){			
			$options['stu_size'] = sanitize_text_field( (isset($_POST['stu_size'])) ? $_POST['stu_size'] : '' );
			$options['stu_style'] = sanitize_text_field( (isset($_POST['stu_style'])) ? $_POST['stu_style'] : '' );
			$options['stu_protocol'] = sanitize_text_field( (isset($_POST['stu_protocol'])) ? $_POST['stu_protocol'] : '' );				
			return $options;		
		}
			
		/**
		 * Initialize options
		 *
		 * @return array $options
		 */
		public function get_options() {
			if ( empty( $this->options ) ) {
				$this->options['sitestillup'] = $this->options['stu_size'] = $this->options['stu_style'] = $this->options['stu_protocol'] = "";
				$opts = get_option('stu_warrenty_id');
				if( !empty($opts) ):
					$this->options['sitestillup'] = $opts['sitestillup'];
				endif;
				$opts = get_option('stu_settings');
				if( !empty($opts) ):				
					$this->options['stu_size'] = $opts['stu_size'];
					$this->options['stu_style'] = $opts['stu_style'];
					$this->options['stu_protocol'] = $opts['stu_protocol'];
				endif;
			}
			return $this->options;
		}
	
		/**
		 * Registers the Sitestillup Widget
		 *
		 * @return type
		 */
		public function register_widget() {
			require_once STU_PLUGIN_DIR . 'includes/SitestillupWidget.php';
			return register_widget( 'SitestillupWidget' );
		}
	
		/**
		 * Registers the Sitestillup if woocommerce exists
		 *
		 * @direct output type
		 */ 
		public function webcen( $atts ){	
			$opts = $this->get_options();			
			if($opts['sitestillup']!='')
			{
				echo "<div class='sw_wc_seal_cart'><script type='text/javascript' 
				src='https://www.sitestillup.com/cgi-bin/sws/uls.cgi?getCert=".$opts['sitestillup']."&sealstyle=".$opts['stu_style']."&sealsize=".$opts['size']."&protocol=".$opts['stu_protocol']."'></script></div>";
			}				
		}
		
		public function webcer( $atts ){	
			$meta = get_post_meta( get_the_ID() );
			
			if($meta['stu_seal_required'][0]=='on')
			{
				$opts = $this->get_options();			
				if($opts['sitestillup']!='')
				{
					echo "<div class='sw_wc_seal'><script type='text/javascript' 
					src='https://www.sitestillup.com/cgi-bin/sws/uls.cgi?getCert=".$opts['sitestillup']."&sealstyle=".$opts['stu_style']."&sealsize=".$opts['size']."&protocol=".$opts['stu_protocol']."'></script></div>";
				}
				
				
			}	
		}				
	
	
		
		
	}
}

?>
