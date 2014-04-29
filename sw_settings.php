<?php
wp_enqueue_script( 'ava-js', plugins_url( '/sitewarranty-verified-seal-trust-seal/js/sw.js', __FILE__ ));
	global $wpdb;	  	
	$id = $wpdb->get_var( "SELECT option_value FROM ".$wpdb->prefix."options WHERE option_name = 'sitewarranty'" );
	$st = $wpdb->get_var( "SELECT option_value FROM ".$wpdb->prefix."options WHERE option_name = 'sw_style'" );
	$si = $wpdb->get_var( "SELECT option_value FROM ".$wpdb->prefix."options WHERE option_name = 'sw_size'" );
	$po = $wpdb->get_var( "SELECT option_value FROM ".$wpdb->prefix."options WHERE option_name = 'sw_protocol'" );
	if($id=='')
	{?>
		<div class="setting_err">
			<div style="float:left;">Need a SiteWarranty ID? Sign up for free</div>
			<a href="https://www.sitewarranty.com/cgi-bin/swc/mreg_admin.cgi?register" target="_blank"><div class="signup">Sign Up</div></a>
		</div>		
	<?php
	}
	?>	
	<div class="setting_err err_id" id="err_close">
		<div id="new_err" style="float:left;">Enter a valid SiteWarranty ID.</div>	
		<img src="<?php echo plugins_url( '/sitewarranty-verified-seal-trust-seal/img/close.png'); ?>">			
	</div>
	<table>
	<tr>
	<td>
	<br />
	<h3> SiteWarranty (Default Settings)</h3>	
    <p>These settings are your default SiteWarranty settings, they can be <br />overidden when using the widget tool.</p>

	
	<h3> SiteWarranty Verification ID:</h3>	
    <p>If you haven't got a verification ID, you will need to sign up <a href="http://www.sitewarranty.com/" target="_blank">here</a> for a free account. <br />
Your verification ID is located in your SiteWarranty control panel.
</p>
	
<form method = "post" action = "" id="frm">
	<input type = "text" value = "<?php echo $id; ?>" name = "warranty" id="warranty_no" autocomplete = "off" size="15" maxlength="12" onkeyup="if(!this.value.match(/^([0-9]+\s?)*$/i))this.value=this.value.replace(/[^0-9]/ig,'').replace(/\s+/g,' ')"/>	
	<h3> Seal Type / Style:</h3>
	<table>
		<tr>
			<td>
				<img src = "<?php echo plugins_url( '/sitewarranty-verified-seal-trust-seal/img/wordpress-seal-a.png');?>">
			</td>
			<td valign="middle" style="width: 50px;">
				<input type="radio" name="style" value="a" <?php if($st=='a') echo"checked";?>>
			</td>
			<td>
				<img src = "<?php echo plugins_url( '/sitewarranty-verified-seal-trust-seal/img/wordpress-seal-b.png');?>">
			</td>
			<td valign="middle">
				<input type="radio" name="style" value="b" <?php if($st=='b') echo"checked";?>>
			</td>
		</tr>
		<tr>
			<td>
				<img src = "<?php echo plugins_url( '/sitewarranty-verified-seal-trust-seal/img/wordpress-seal-c.png');?>">
			</td>
			<td valign="middle" style="width: 50px;">
				<input type="radio" name="style" value="c" <?php if($st=='c') echo"checked";?>>
			</td>
			<td>
				<img src = "<?php echo plugins_url( '/sitewarranty-verified-seal-trust-seal/img/wordpress-seal-d.png');?>">
			</td>
			<td valign="middle">
				<input type="radio" name="style" value="d" <?php if($st=='d') echo"checked";?>>
			</td>
		</tr>
	</table>
	<h3> Seal Width:</h3>
	<p>Set this option between 80 and 300 pixels to change the display size of your seal.<br /> The height is auto scaled on this setting.</p>
	<input type = "text" value = "<?php echo $si; ?>" name = "size" autocomplete = "off" size="10" maxlength="3" onkeyup="if(!this.value.match(/^([0-9]+\s?)*$/i))this.value=this.value.replace(/[^0-9]/ig,'').replace(/\s+/g,' ')" />Pixels<br />
	<h3> Display on a secure page (https):</h3>
	<p> 
		Yes <input type="radio" name="protocol" value="1" <?php if($po=='1') echo"checked";?>>
		No <input type="radio" name="protocol" value="2" <?php if($po=='2') echo"checked";?>>
	</p>
	<br />
	<input type="button" class="button button-primary" value="Save" onclick="return (val_sw_id());">
</form>	
	<br />
	<br />
	<h3> Code for manual insertion in to pages and posts</h3>	
    <p>Please use the SiteWarranty widget to insert the trust seal quickly to your site <br />or for manual insertion please copy and paste the code below anywhere you'd <br />like the seal to appear.</p>	
	<br />
	<div class="sw_shortcode">		
			<?php echo '[webcertificate style="'.$st.'" size="'.$si.'" protocol="'.$po.'"]';?>		
	</div>
	</td>
	<td class="sw_add">
		<div class="sw_fb_txt">Go on, give us a Like!</div>
		<div class="sw_fb">
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
			<div class="fb-like" data-href="https://www.facebook.com/TheResponseControlGroup" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
		</div>
		<br>
		<!-- ad area -->
		<a href="http://www.emailergo.com" target="_blank">
			<img src="<?php echo plugins_url( '/sitewarranty-verified-seal-trust-seal/img/sw_add1.jpg');?>" id="im"/>
		</a>
		<a href="http://www.responsecontrol.net" target="_blank">
			<img src="<?php echo plugins_url( '/sitewarranty-verified-seal-trust-seal/img/sw_add2.jpg');?>" id="im"/>
		</a>
		<a href="http://www.clixgalore.co.uk" target="_blank">
			<img src="<?php echo plugins_url( '/sitewarranty-verified-seal-trust-seal/img/sw_add3.jpg');?>" id="im"/>
		</a>
	</td>
	</tr>
	</table>
	
	<script type="text/javascript">
	function val_sw_id()
	{		
		var $id = jQuery("#warranty_no").val();
		if($id == '')
		{
			jQuery("#frm").submit();
		}
		jQuery.ajax({
		  type: "GET",
		  url: '<?=plugins_url()?>/sitewarranty-verified-seal-trust-seal/validate.php',
          cache: false,		
		  data: {id : $id},
		  success: function(response) {
				if(response == 'valid')
				{				
					jQuery("#frm").submit();
				}
				else if(response == 'invalid')
				{
					jQuery(".err_id").css({"display":"block"});
					jQuery("html, body").animate({ scrollTop: 0 }, 600);
					return false;
				}
				else if(response == 'err01' )
				{
					var error = "Please enable curl or file_get_contents to get verified.";	
					jQuery("#new_err").text(error);
					jQuery(".err_id").css({"display":"block"});
					jQuery("html, body").animate({ scrollTop: 0 }, 600);
					return false;
				}
				else{
					jQuery("#new_err").text(response);
					jQuery(".err_id").css({"display":"block"});
					jQuery("html, body").animate({ scrollTop: 0 }, 600);
					return false;
				}
		  }
		});
		return false;
	}
	jQuery(document).ready(function(e)
	{
		jQuery( "#err_close" ).click(function() {
			jQuery(".err_id").hide("slow");
		});
	});
	//$(".err_id").css({"display":"block"});
	</script>