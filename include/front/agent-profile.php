<?php
//Create new order function
function cam_agent_profile(){
	ob_start();
	global $wpdb;
	$user_id      = get_current_user_id();
	$table_name      = $wpdb->prefix . 'users';
	$user           = $wpdb->get_row( "SELECT * FROM ".$table_name." WHERE ID='".$user_id."'", OBJECT );
	$meta_data = get_user_meta($user_id);

?>
<table cellpadding="0" cellspacing="0" style="width: 100%; text-align: center;">
	<tr>
		<th style="width: 50%;">
			Field Name
		</th>
		<td style="width: 50%;">
			Value
		</td>
	</tr>

	<tr>
		<th style="width: 50%;">
			Name
		</th>
		<td style="width: 50%;">
			<?php echo isset($meta_data['fullName'][0])? $meta_data['fullName'][0]: ''; ?>
		</td>
	</tr>
	
	<tr>
		<th style="width: 50%;">
			Email
		</th>
		<td style="width: 50%;">
			<?php echo $user->user_email; ?>
		</td>
	</tr>
	
	<tr>
		<th style="width: 50%;">
			Phone
		</th>
		<td style="width: 50%;">
			<?php echo isset($meta_data['phone'][0])? $meta_data['phone'][0]: ''; ?>
		</td>
	</tr>
	
	<tr>
		<th style="width: 50%;">
			Country
		</th>
		<td style="width: 50%;">
			<?php echo isset($meta_data['country'][0])? $meta_data['country'][0]: ''; ?>
		</td>
	</tr>
	
	<tr>
		<th style="width: 50%;">
			Address
		</th>
		<td style="width: 50%;">
			<?php echo isset($meta_data['address'][0])? $meta_data['address'][0]: ''; ?>
		</td>
	</tr>
	


	<tr>
		<th style="width: 50%;">
			Wallet balance
		</th>
		<td style="width: 50%;">
			<?php echo isset($meta_data['wallet_balance'][0])? $meta_data['wallet_balance'][0]: ''; ?>
		</td>
	</tr>
	
	<tr>
		<th style="width: 50%;">
			Issued visas
		</th>
		<td style="width: 50%;">
			<?php echo isset($meta_data['issued_visas'][0])? $meta_data['issued_visas'][0]: ''; ?>
		</td>
	</tr>
		
	<tr>
		<th style="width: 50%;">
			Additional services balance
		</th>
		<td style="width: 50%;">
			<?php echo isset($meta_data['additional_services_balance'][0])? $meta_data['additional_services_balance'][0]: ''; ?>
		</td>
	</tr>
	
</table>


<a href="<?php echo site_url('/add-order');?>" type="submit" name="order_submit" value="submit" style="display: block;     padding: 15px 40px; margin-top: 20px; background-color: #20b368; color: #fff; border-width: 0px;">Add Order</a>
<a href="<?php echo site_url('/order-list');?>" type="submit" name="order_submit" value="submit" style="display: block;     padding: 15px 40px; margin-top: 20px; background-color: #20b368; color: #fff; border-width: 0px;">Order List</a>
<a href="<?php echo site_url('/add-ticket');?>" type="submit" name="order_submit" value="submit" style="display: block;     padding: 15px 40px; margin-top: 20px; background-color: #20b368; color: #fff; border-width: 0px;">Add Ticket</a>

<?php
	return ob_get_clean();
}

//Shortcodes create_new_orders
add_shortcode('cam-agent-profile', 'cam_agent_profile');