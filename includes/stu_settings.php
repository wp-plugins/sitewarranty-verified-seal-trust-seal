<?php
global $wpdb, $pagenow;		
$opts = $this->get_options();	  	
$id = $opts['sitestillup'];	
$si = $opts['stu_size'];
$st = $opts['stu_style'];	
$po = $opts['stu_protocol'];
?>

<div class="wrap">
    <h2>Sitestillup Settings 
    	<a href="http://www.sitestillup.com/" target="_blank" class="stu-logo">
			<img src="<?php echo STU_PLUGIN_URL.'includes/img/sitestillup-logo.png'; ?>">
		</a>
    </h2>        
	
    <?php
        if ( 'true' == esc_attr( $_GET['updated'] ) ) echo '<div class="updated" ><p>Sitestillup Settings updated.</p></div>';        
        if ( isset ( $_GET['tab'] ) ) sw_admin_tabs($_GET['tab']); else sw_admin_tabs('settings');
    ?>

    <div id="poststuff">    	
        
        <div class="error settings-error err_id" id="setting-error-settings_updated"> 
        	<p><strong>Enter a valid Sitestillup ID. If you need an account, <a href="https://www.sitestillup.com/cgi-bin/sws/uls_admin.cgi?register" target="_blank">click here</a> to create one.</strong></p>
        </div>
        <?php settings_errors(); ?>         
        <?php            
		if ( $pagenow == 'admin.php' && $_GET['page'] == 'warranty_settings' ){ 
		
			if ( isset ( $_GET['tab'] ) ) $tab = $_GET['tab']; 
			else $tab = 'settings'; 
			
			switch ( $tab ){
				case 'trustseal' :
					?> 
                    
					<form class="validate" id="frm" name="pt-settings" method="post" action="<?php echo admin_url(); ?>options.php">
					<?php settings_fields( 'stu-settings-page' ); ?>
					<table class="form-table">
					<tr>
						<td colspan="2"> 
						<strong>Sitestillup (Default Settings)</strong>
						<p>These settings are your default Sitestillup settings, they can be overidden when using the widget tool.</p>  
						</td>
					</tr>
					<tr>
						<th><br />Seal Type / Style:</th>
						<td>
							<table>
								<tr>
									<td valign="middle"><input type="radio" name="stu_style" value="a" <?php if($st=='a') echo"checked";?>></td>
									<td><img src = "<?php echo STU_PLUGIN_URL.'includes/img/Seal-A.png';?>"></td>
									<td valign="middle"><input type="radio" name="stu_style" value="b" <?php if($st=='b') echo"checked";?>></td>
									<td><img src = "<?php echo STU_PLUGIN_URL.'includes/img/Seal-B.png';?>"></td>                                    </tr>
								<tr>
									<td valign="middle"><input type="radio" name="stu_style" value="c" <?php if($st=='c') echo"checked";?>></td>
									<td><img src = "<?php echo STU_PLUGIN_URL.'includes/img/Seal-C.png';?>"></td>
									<td valign="middle"><input type="radio" name="stu_style" value="d" <?php if($st=='d') echo"checked";?>></td>
									<td><img src = "<?php echo STU_PLUGIN_URL.'includes/img/Seal-D.png';?>"></td>                                    </tr>
							</table>
						</td>
					</tr>
					
					<tr>
						<th>Seal Width:</th>
						<td>                            	
							<input type="text" value="<?php echo $si; ?>" name="stu_size" autocomplete="off" size="10" maxlength="3" onkeyup="if(!this.value.match(/^([0-9]+\s?)*$/i))this.value=this.value.replace(/[^0-9]/ig,'').replace(/\s+/g,' ')" />Pixels<br />
							<span class="description">Set this option between 80 and 300 pixels to change the display size of your seal.<br /> 
							The height is auto scaled on this setting.</span>
						</td>
					</tr>
					
					<tr>
						<th>Display on a secure page (https):</th>
						<td>                            	
							<p> 
								<input type="radio" name="stu_protocol" value="1" <?php if($po=='1') echo"checked";?>> Yes 
								<input type="radio" name="stu_protocol" value="2" <?php if($po=='2') echo"checked";?>> No 
							</p>
						</td>
					</tr>
					</table> 
					<p class="submit" style="clear: both;"> <?php submit_button();  ?></p>
					</form> 
                    
                    <table class="form-table">
                        <tr><th>Code for manual insertion in to pages and posts</th></tr>
                        <tr>
                            <td>Please use the Sitestillup widget to insert the trust seal quickly to your site or for manual insertion please copy and paste 
                            <br /> the code below anywhere you'd like the seal to appear.</td>
                        </tr>
                        <tr><td><div class="sw_shortcode"><?php echo '[webcertificate style="'.$st.'" size="'.$si.'" protocol="'.$po.'"]';?></div></td></tr>
                    </table>
                     
                    
					<?php
				break;                     
				case 'settings' : 
					?>
                    <table class="seal-table">
                    <tr><td>
					<form class="validate" id="frm" name="pt-settings" method="post" action="<?php echo admin_url(); ?>options.php">
					<?php settings_fields( 'stu_warrenty_id' ); ?>
					<table class="form-table">					
                    <?php if($id==''): ?>
                    <tr>
                    	<td colspan="2">							
                            <div class="setting_err">
                                <div style="float:left;">Please create your Sitestillup account to enable website monitoring. Click here to </div>
                                <a href="https://www.sitestillup.com/cgi-bin/sws/uls_admin.cgi?register" target="_blank">
                                <div class="signup">Sign Up</div></a>
                            </div>									
						</td>
					</tr>
                    <?php endif; ?>
					<tr>
						<th>Sitestillup Verification ID:</th>
						<td>
							<input type="text" value="<?php echo $id; ?>" name="sitestillup" id="warranty_no" autocomplete = "off" onkeyup="if(!this.value.match(/^([0-9]+\s?)*$/i))this.value=this.value.replace(/[^0-9]/ig,'').replace(/\s+/g,' ')"/> <br />
							<span class="description">If you haven't got a verification ID, you will need to sign up 
							<a href="https://www.sitestillup.com/cgi-bin/sws/uls_admin.cgi?register" target="_blank">here</a> for a free account. <br />
							Your verification ID is located in your Sitestillup control panel.
							</span>
						</td>
					</tr> 
					</table> 
					<p class="submit" style="clear: both; float:left;">
                    	<span class="spinner" style="display: none;"></span>                
						<input type="button" class="button button-primary" value="Update Settings" onclick="return (val_sw_id());">                            	                        </p>
					</form> 
                    
                    </td><td valign="top">
                    	<p><iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fsitestillup&amp;width&amp;layout=standard&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:35px;" allowTransparency="true"></iframe></p>
                    	<p><a href="https://www.sitestillup.com/cgi-bin/sws/uls_admin.cgi" target="_blank">
                        <img src="<?php echo STU_PLUGIN_URL.'includes/img/banner2.jpg'; ?>"></a></p>
                        <p><a href="http://www.sitestillup.com/affiliate-scheme/" target="_blank">
                        <img src="<?php echo STU_PLUGIN_URL.'includes/img/banner3.jpg'; ?>"></a></p>
                        <p><a href="http://www.emailergo.com/" target="_blank">
                        <img src="<?php echo STU_PLUGIN_URL.'includes/img/banner1.jpg'; ?>"></a></p>                        
                    </td></tr>
                    
                    </table>
                                         
					<?php
				break;
			}				              
		}
		?>
                            
                	        
                    
    </div>

</div>
<script type="text/javascript">
function val_sw_id()
{		
	jQuery(".spinner").show();
	var $id = jQuery("#warranty_no").val(); 	
	jQuery.ajax({
	  type: "GET",
	  url: '<?php echo STU_PLUGIN_URL; ?>includes/validate.php',
	  cache: false,		
	  data: {id : $id},
	  success: function(response) {
		  	jQuery(".spinner").hide();
			if(response.trim() == 'valid')
			{								
				jQuery("#frm").submit();
			}
			else
			{
				jQuery(".err_id").css({"display":"block"});
				jQuery(".updated").hide();
				jQuery("html, body").animate({ scrollTop: 0 }, 600);
				return false;
			}
	  }
	});
	return false;
}
</script>

<?php
function sw_admin_tabs( $current = 'settings' ) { 
    $tabs = array( 'settings' => 'Settings', 'trustseal' => 'Trust Seal Settings' ); 
    $links = array();
    echo '<div id="icon-themes" class="icon32"><br></div>';
    echo '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab$class' href='?page=warranty_settings&tab=$tab'>$name</a>";        
    }
    echo '</h2>';
}
?>