<?php 

	$prefix = 'stu_';
	$meta_box = array(
		'id' => 'Sitestillup',
		'title' => 'Sitestillup',
		'page' => 'product',
		'context' => 'normal',
		'priority' => 'high',
		'stu_field' => array(			
			array(
				'name' => 'Seal',
				'title' => 'Show Sitestillup Seal on Products',
				'id' => $prefix . 'seal_required',
				'type' => 'checkbox',
			)/*,
			array(
				'name' => 'Size',
				'id' => $prefix . 'size',
				'type' => 'text',
			),
			array(
				'name' => 'Style',
				'id' => $prefix . 'style',
				'type' => 'radio',
				
			),
			array(
				'name' => 'Protocol',
				'id' => $prefix . 'protocol',
				'type' => 'text',
			)*/
		)
	);
	
	add_action('admin_menu', 'site_stillup_func');
	
	function site_stillup_func() {
		global $meta_box;
		add_meta_box($meta_box['id'], $meta_box['title'], 'site_stillup_show_box', $meta_box['page'], $meta_box['context'], $meta_box['priority']);
	}
	
	function site_stillup_show_box() {
		global $meta_box, $post;
		echo '<input type="hidden" name="site_stillup_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
		echo '<table class="menu_table">';
		$i=0;
		foreach ($meta_box['stu_field'] as $field) {
			$meta = get_post_meta($post->ID, $field['id'], true);
			if($i==0)
			{
				echo '<tr>',
					'<td style="width:25%; min-width:100px;"><label for="', $field['id'], '">', $field['title'], '</label></td>';
					
			}
			else
			{
				echo '<tr  class="val">',
					'<td style="width:25%;"><label for="', $field['id'], '">', $field['name'], '</label></td>';		
			}
			if($field['name']=='Seal')
			{
				echo '<td>';
				echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
				echo '</td></tr>';
			}
			if($field['name']=='Size')
			{
				echo '<td>';
				echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:100px;" autocomplete="off"/>', '<br />', $field['desc'];
				echo '</td></tr>';
			}
			if($field['name']=='Style')
			{
				
				echo '<td>';
				echo '<table class="func_table">';
					echo '<tr>';						
						echo '<td valign="middle">';
						echo '<input type="radio" value="a" name="', $field['id'], '" id="', $field['id'], '"', ($meta=='a') ? ' checked="checked"' : '', ' />';
						echo '</td>';
						echo '<td><img src = "'.STU_PLUGIN_URL.'includes/img/Seal-A.png"></td>';
												
						echo '<td valign="middle">';													
						echo '<input type="radio" value="b" name="', $field['id'], '" id="', $field['id'], '"', ($meta=='b') ? ' checked="checked"' : '', ' />';
						echo '</td>';
						echo '<td><img src = "'.STU_PLUGIN_URL.'includes/img/Seal-B.png"></td>';
					echo '</tr>';
					echo '<tr>';						
						echo '<td valign="middle">';						
						echo '<input type="radio" value="c" name="', $field['id'], '" id="', $field['id'], '"', ($meta=='c') ? ' checked="checked"' : '', ' />';
						echo '</td>';
						echo '<td><img src = "'.STU_PLUGIN_URL.'includes/img/Seal-C.png"></td>';
						
						
						echo '<td valign="middle">';
						echo '<input type="radio" value="d" name="', $field['id'], '" id="', $field['id'], '"', ($meta=='d') ? ' checked="checked"' : '', ' />';
						echo '</td>';
						echo '<td><img src = "'.STU_PLUGIN_URL.'includes/img/Seal-D.png"></td>';
					echo '</tr>';
				echo '</table>';
				echo '</td></tr>';
			}
			if($field['name']=='Protocol')
			{
				
				echo '<td>';
				echo '<table class="func_table">';
					echo '<tr>';
						echo '<td>';							
						echo '<input type="radio" value="1" name="', $field['id'], '" id="', $field['id'], '"', ($meta=='1') ? ' checked="checked"' : '', ' />';
						echo ' Yes';							
						echo '</td>';
						echo '<td>';
						echo '<input type="radio" value="2" name="', $field['id'], '" id="', $field['id'], '"', ($meta=='2') ? ' checked="checked"' : '', ' />';
						echo ' No';
						echo '</td>';
					echo '</tr>';
				echo '</table>';
				echo '</td></tr>';
					
			}
			$i++;
		
    }
		echo '</table>';		
	}
		
	add_action('save_post', 'site_stillup_save_data');

	function site_stillup_save_data($post_id) {
		global $meta_box;
		
		if (!wp_verify_nonce($_POST['site_stillup_meta_box_nonce'], basename(__FILE__))) {
			return $post_id;
		}
		if ('page' == $_POST['post_type']) {
			if (!current_user_can('edit_page', $post_id)) {
				return $post_id;
			}
		} elseif (!current_user_can('edit_post', $post_id)) {
			return $post_id;
		}
		foreach ($meta_box['stu_field'] as $field) {
			$old = get_post_meta($post_id, $field['id'], true);
			$new = $_POST[$field['id']];
			if ($new && $new != $old) {
				update_post_meta($post_id, $field['id'], $new);
			} elseif ('' == $new && $old) {
				delete_post_meta($post_id, $field['id'], $old);
			}
		}
	}


?>