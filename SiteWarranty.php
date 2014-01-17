<?php
/* 
Plugin Name: SiteWarranty
Plugin URI: http://www.sitewarranty.com/
Description: Verified seals that increases sales and conversion
Author: Pertly for The Response Control Group
Version: 1.1
*/
wp_enqueue_style('wp-mem', plugins_url('/css/sw_wc.css',__FILE__)); 
wp_enqueue_style('wp-members', plugins_url('/css/style.css',__FILE__)); 
wp_enqueue_script( 'ava-js', plugins_url( '/js/sw.js', __FILE__ ));

/*update values from settings page - start*/
global $wpdb;
if(isset($_POST['warranty']))
{
	$up = $_POST['warranty'];
	$wpdb->query( "UPDATE ".$wpdb->prefix."options SET option_value = '$up' WHERE option_name = 'sitewarranty'" );
}
if(isset($_POST['style']))
{
	$st = $_POST['style'];
	$wpdb->query( "UPDATE ".$wpdb->prefix."options SET option_value = '$st' WHERE option_name = 'sw_style'" );
}
if(isset($_POST['size']))
{
	$si = $_POST['size'];
	$wpdb->query( "UPDATE ".$wpdb->prefix."options SET option_value = $si WHERE option_name = 'sw_size'" );
}
if(isset($_POST['protocol']))
{
	$po = $_POST['protocol'];
	$wpdb->query( "UPDATE ".$wpdb->prefix."options SET option_value = $po WHERE option_name = 'sw_protocol'" );
}
/*update values from settings page - end*/

add_action('admin_menu', 'Site_Warranty');
function Site_Warranty() {
    add_menu_page('SiteWarranty', 'SiteWarranty', 'administrator', 'warranty_settings', 'Update_id', plugins_url( '/sitewarranty-verified-seal-trust-seal/img/wordpress-icon16x16.png' ));
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 
	$plugin = 'woocommerce/woocommerce.php';
    if(is_plugin_active($plugin))
	{
		
		add_submenu_page('warranty_settings', 'CSSEditor', 'Woocommerce CSS', 'administrator', 'css_editor', 'Update_css' );	
	}
}

function Update_id()
{
	include('sw_settings.php');
}

function webcertificate_func( $atts = '' ){
	global $wpdb;	  	
	$id = $wpdb->get_var( "SELECT option_value FROM ".$wpdb->prefix."options WHERE option_name = 'sitewarranty'" );	
	$style = $wpdb->get_var( "SELECT option_value FROM ".$wpdb->prefix."options WHERE option_name = 'sw_style'" );	
	$size = $wpdb->get_var( "SELECT option_value FROM ".$wpdb->prefix."options WHERE option_name = 'sw_size'" );	
	$protocol = $wpdb->get_var( "SELECT option_value FROM ".$wpdb->prefix."options WHERE option_name = 'sw_prtocol'" );
	if($id!='')
	{
		return "<div class='wc_seal'><script type='text/javascript' src='http://www.sitewarranty.com/cgi-bin/swc/mreg.cgi?getCert=$id&sealstyle=$style&sealsize=$size&protocol=$protocol'></script></div>";
	}
	else
		return;
}

add_shortcode( 'webcertificate', 'webcertificate_func' );

//add values after activation of plugin - start
function sw_activate() {   
	  global $wpdb;	    
      if(!$myrows = $wpdb->query( "SELECT * FROM ".$wpdb->prefix."options WHERE option_name = 'sitewarranty'" ))
	  {	  
		$wpdb->query( "INSERT INTO `".$wpdb->prefix."options`(`option_name`, `option_value`, `autoload`) VALUES ('sitewarranty','','yes')" );	    
	  } 
	  if(!$myrows = $wpdb->query( "SELECT * FROM ".$wpdb->prefix."options WHERE option_name = 'sw_size'" ))
	  {	  
		$wpdb->query( "INSERT INTO `".$wpdb->prefix."options`(`option_name`, `option_value`, `autoload`) VALUES ('sw_size','220','yes')" );	    
	  }
	  if(!$myrows = $wpdb->query( "SELECT * FROM ".$wpdb->prefix."options WHERE option_name = 'sw_style'" ))
	  {	  
		$wpdb->query( "INSERT INTO `".$wpdb->prefix."options`(`option_name`, `option_value`, `autoload`) VALUES ('sw_style','d','yes')" );	    
	  }
	  if(!$myrows = $wpdb->query( "SELECT * FROM ".$wpdb->prefix."options WHERE option_name = 'sw_protocol'" ))
	  {	  
		$wpdb->query( "INSERT INTO `".$wpdb->prefix."options`(`option_name`, `option_value`, `autoload`) VALUES ('sw_protocol','2','yes')" );	    
	  }
	  add_option('activation_redirect', true);	 		  
}
register_activation_hook(__FILE__,'sw_activate');
//add values after activation of plugin - end

//remove values after activation of plugin - start
function sw_deactivate() {   
	  global $wpdb;	   
	  $wpdb->query( "DELETE FROM `".$wpdb->prefix."options`WHERE option_name IN ('sitewarranty','sw_size','sw_style','sw_protocol','widget_sitewarranty')" );	      	  
}
register_deactivation_hook( __FILE__, 'sw_deactivate' );
//remove values after activation of plugin - end

// redirect after plugin activation - start
add_action('admin_init', 'my_plugin_redirect');
function my_plugin_redirect() {
    if (get_option('activation_redirect', false)) {
        delete_option('activation_redirect');
		$admin_loc = admin_url();
		$re_url = $admin_loc."?page=warranty_settings";
        wp_redirect($re_url);
    }
}
// redirect after plugin activation - end

class Sitewarranty extends WP_Widget {

         
	public function __construct() {
		// widget actual processes
		parent::WP_Widget(false,SiteWarranty,'description=SiteWarranty verified seal');
	}

	public function form( $instance = '' ) {
	
		global $wpdb;	  	
		$id = $wpdb->get_var( "SELECT option_value FROM ".$wpdb->prefix."options WHERE option_name = 'sitewarranty'" );
		$instance = wp_parse_args( (array) $instance, array( 'style' => '','size' => '', 'protocol' => '') );
		if(empty($instance['style'])&&empty($instance['size'])&&empty($instance['protocol']))
		{			  	
			$id = $wpdb->get_var( "SELECT option_value FROM ".$wpdb->prefix."options WHERE option_name = 'sitewarranty'" ); 
				
			if($id!='')
			{
				$instance['style'] = $wpdb->get_var( "SELECT option_value FROM ".$wpdb->prefix."options WHERE option_name = 'sw_style'" );
				$instance['size'] = $wpdb->get_var( "SELECT option_value FROM ".$wpdb->prefix."options WHERE option_name = 'sw_size'" );
				$instance['protocol'] = $wpdb->get_var( "SELECT option_value FROM ".$wpdb->prefix."options WHERE option_name = 'sw_protocol'" );
			}
		}
		$style = esc_attr( $instance['style'] );
		$size = esc_attr( $instance['size'] );
		$protocol = esc_attr( $instance['protocol'] );					
	?>			
		<p><b>Seal Type / Style:</b></p>        
		<p><table class="wid_img">
		<tr>
			<td>
				<img src = "<?php echo plugins_url( '/sitewarranty-verified-seal-trust-seal/img/wordpress-seal-a.png');?>" width="68" height="85">
			</td>
			<td valign="middle" style="width: 50px;">
				<input type="radio" name="<?php echo $this->get_field_name('style'); ?>" id="<?php echo $this->get_field_id('style'); ?>" value="a" <?php if($style=='a') echo"checked";?>>
			</td>
			<td>
				<img src = "<?php echo plugins_url( '/sitewarranty-verified-seal-trust-seal/img/wordpress-seal-b.png');?>" width="68"  height="32">
			</td>
			<td valign="middle">
				<input type="radio" name="<?php echo $this->get_field_name('style'); ?>" id="<?php echo $this->get_field_id('style'); ?>" value="b" <?php if($style=='b') echo"checked";?>>
			</td>
		</tr>
		<tr>
			<td>
				<img src = "<?php echo plugins_url( '/sitewarranty-verified-seal-trust-seal/img/wordpress-seal-c.png');?>" width="68"  height="85">
			</td>
			<td valign="middle" style="width: 50px;">
				<input type="radio" name="<?php echo $this->get_field_name('style'); ?>" id="<?php echo $this->get_field_id('style'); ?>" value="c" <?php if($style=='c') echo"checked";?>>
			</td>
			<td>
				<img src = "<?php echo plugins_url( '/sitewarranty-verified-seal-trust-seal/img/wordpress-seal-d.png');?>" width="68"  height="25">
			</td>
			<td valign="middle">
				<input type="radio" name="<?php echo $this->get_field_name('style'); ?>" id="<?php echo $this->get_field_id('style'); ?>" value="d" <?php if($style=='d') echo"checked";?>>
			</td>
		</tr>
	</table></p>
		
		<p><b>Seal Width:</b></p>
        <p>Set this option between 80 and 300 pixels to change the display size of your seal. The height is auto scaled on this setting.</p>
		<p><input type="text" value="<?php echo $size; ?>" name="<?php echo $this->get_field_name('size'); ?>" id="<?php echo $this->get_field_id('size'); ?>" class="widefat sw_size" autocomplete = "off" maxlength="3" onkeyup="if(!this.value.match(/^([0-9]+\s?)*$/i))this.value=this.value.replace(/[^0-9]/ig,'').replace(/\s+/g,' ')" /></p>
		
		<P><b>Display on a secure page (https):</b> </P>
		<p>Yes <input type="radio" name="<?php echo $this->get_field_name('protocol'); ?>" id="<?php echo $this->get_field_id('protocol'); ?>" value="1" <?php if($protocol=='1') echo"checked";?>>
		No <input type="radio" name="<?php echo $this->get_field_name('protocol'); ?>" id="<?php echo $this->get_field_id('protocol'); ?>" value="2" <?php if($protocol=='2') echo"checked";?>>
		<br /></p>
	<?php					
	}	

	public function update( $new_instance = '' , $old_instance = '' ) {
		$instance = $old_instance;
		$instance['style'] = strip_tags($new_instance['style']);
		$instance['size'] = strip_tags($new_instance['size']);
		$instance['protocol'] = strip_tags($new_instance['protocol']);
		
		return $instance;				   
	}

	public function widget( $args = '' , $instance = '' ) {
	   $instance = wp_parse_args( (array) $instance, array( 'style' => '','size' => '', 'protocol' => '') );
	   $style = esc_attr( $instance['style'] );
	   $size = esc_attr( $instance['size'] );
	   $protocol = esc_attr( $instance['protocol'] );
	   global $wpdb; 	
	   $id = $wpdb->get_var( "SELECT option_value FROM ".$wpdb->prefix."options WHERE option_name = 'sitewarranty'" );
	   if($id!='')
	   {
			echo "<div class='wc_widget_seal'><script type='text/javascript' src='http://www.sitewarranty.com/cgi-bin/swc/mreg.cgi?getCert=$id&sealstyle=$style&sealsize=$size&protocol=$protocol'></script></div>";		
	   }	   
	}
}

add_action("widgets_init", "warranty_widget");
function warranty_widget(){
register_widget('Sitewarranty');
}

//woocommerce
// product page

include('sw_function.php');
function webcer( $atts ){	
	$meta = get_post_meta( get_the_ID() );
	
	if($meta['sw_seal_required'][0]=='on')
	{
		global $wpdb;	
		$id = $wpdb->get_var( "SELECT option_value FROM ".$wpdb->prefix."options WHERE option_name = 'sitewarranty'" );
		$style = $meta['sw_style'][0];
		$size = $meta['sw_size'][0];
		$protocol = $meta['sw_protocol'][0];
		if($id!='')
		{	
			echo "<div class='sw_wc_seal'><script type='text/javascript' src='http://www.sitewarranty.com/cgi-bin/swc/mreg.cgi?getCert=$id&sealstyle=$style&sealsize=$size&protocol=$protocol'></script></div>";
		}
	}	
}
add_action('woocommerce_single_product_summary', 'webcer');

// product page
function webcen( $atts ){	
	
		global $wpdb;	
		$id = $wpdb->get_var( "SELECT option_value FROM ".$wpdb->prefix."options WHERE option_name = 'sitewarranty'" );
		$style = $wpdb->get_var( "SELECT option_value FROM ".$wpdb->prefix."options WHERE option_name = 'sw_style'" );
		$size = $wpdb->get_var( "SELECT option_value FROM ".$wpdb->prefix."options WHERE option_name = 'sw_size'" );
		$protocol = $wpdb->get_var( "SELECT option_value FROM ".$wpdb->prefix."options WHERE option_name = 'sw_protocol'" );
		if($id!='')
		{
			echo "<div class='sw_wc_seal_cart'><script type='text/javascript' src='http://www.sitewarranty.com/cgi-bin/swc/mreg.cgi?getCert=$id&sealstyle=$style&sealsize=$size&protocol=$protocol'></script></div>";
		}
}
add_action('woocommerce_after_cart_table', 'webcen');

//submenu to edit css - woocommerce - start
function Update_css()
{
	include('sw_css.php');
}
//submenu to edit css - woocommerce - end

?>
