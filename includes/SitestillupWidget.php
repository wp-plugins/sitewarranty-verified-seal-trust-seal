<?php

if(!class_exists('SitestillupWidget')) {

	class SitestillupWidget extends WP_Widget {
				
		function __construct() {
			$widget_ops = array('classname' => 'stu_widget', 'description' => __('Sitestillup Verified Seal.'));
			$control_ops = array('width' => 400, 'height' => 350);
			parent::__construct(false, 'Sitestillup', $widget_ops, $control_ops);
		}		
		
		public function form( $instance = '' ) {
	
			global $wpdb;	  	
			$opts = Sitestillup::get_options();
			
			$instance = wp_parse_args( (array) $instance, array( 'style' => '','size' => '', 'protocol' => '') );
			if(empty($instance['style'])&&empty($instance['size'])&&empty($instance['protocol']))
			{											
				if($opts['sitestillup']!='')
				{
					$instance['id'] = $opts['sitestillup'];
					$instance['size'] = $opts['stu_size'];
					$instance['style'] = $opts['stu_style'];
					$instance['protocol'] = $opts['stu_protocol'];			
				}
			}
			$id = $instance['id'];		
			$style = esc_attr( $instance['style'] );
			$size = esc_attr( $instance['size'] );
			$protocol = esc_attr( $instance['protocol'] );					
			?>			
			<p><b><?php _e('Seal Type / Style:'); ?></b></p>        
            <p><table class="wid_img">
            <tr>
                <td>
                    <img src = "<?php echo STU_PLUGIN_URL.'includes/img/Seal-A.png';?>" width="90" >
                </td>
                <td valign="middle" style="width: 50px;">
                    <input type="radio" name="<?php echo $this->get_field_name('style'); ?>" id="<?php echo $this->get_field_id('style'); ?>" value="a" <?php if($style=='a') echo"checked";?>>
                </td>
                <td>
                    <img src = "<?php echo STU_PLUGIN_URL.'includes/img/Seal-B.png';?>" width="90" >
                </td>
                <td valign="middle">
                    <input type="radio" name="<?php echo $this->get_field_name('style'); ?>" id="<?php echo $this->get_field_id('style'); ?>" value="b" <?php if($style=='b') echo"checked";?>>
                </td>
            </tr>
            <tr>
                <td>
                    <img src = "<?php echo STU_PLUGIN_URL.'includes/img/Seal-C.png';?>" width="90" >
                </td>
                <td valign="middle" style="width: 50px;">
                    <input type="radio" name="<?php echo $this->get_field_name('style'); ?>" id="<?php echo $this->get_field_id('style'); ?>" value="c" <?php if($style=='c') echo"checked";?>>
                </td>
                <td>
                    <img src = "<?php echo STU_PLUGIN_URL.'includes/img/Seal-D.png';?>" width="90" >
                </td>
                <td valign="middle">
                    <input type="radio" name="<?php echo $this->get_field_name('style'); ?>" id="<?php echo $this->get_field_id('style'); ?>" value="d" <?php if($style=='d') echo"checked";?>>
                </td>
            </tr>
        	</table></p>
		
            <p><b><?php _e('Seal Width:'); ?></b></p>
            <p>Set this option between 80 and 300 pixels to change the display size of your seal. The height is auto scaled on this setting.</p>
            <p><input type="text" value="<?php echo $size; ?>" name="<?php echo $this->get_field_name('size'); ?>" id="<?php echo $this->get_field_id('size'); ?>" class="widefat sw_size" autocomplete = "off" maxlength="3" onkeyup="if(!this.value.match(/^([0-9]+\s?)*$/i))this.value=this.value.replace(/[^0-9]/ig,'').replace(/\s+/g,' ')" /></p>
            
            <P><b><?php _e('Display on a secure page (https):'); ?></b> </P>
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
		   $opts = Sitestillup::get_options();
		   $instance = wp_parse_args( (array) $instance, array( 'style' => '','size' => '', 'protocol' => '') );
		   $style = esc_attr( $instance['style'] );
		   $size = esc_attr( $instance['size'] );
		   $protocol = esc_attr( $instance['protocol'] );	   	
		   $id = esc_attr($opts['sitestillup']) ;
		   if($id!='')
		   {
				echo "<div class='wc_widget_seal'><script type='text/javascript' src='https://www.sitestillup.com/cgi-bin/sws/uls.cgi?getCert=$id&sealstyle=$style&sealsize=$size&protocol=$protocol'></script></div>";		
		   }	   
		}
			
	}
}