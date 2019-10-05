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
<table cellpadding="0" cellspacing="0" style="width: 100%; text-align: center; margin-bottom: 40px;">
	<tr>
		<th style="width: 50%; background: #20b368; border-bottom: 1px solid #20b368; border-right: 1px solid #ffffff; padding: 20px; color: #ffffff;">
			Field Name
		</th>
		<th style="width: 50%; background: #20b368; border-bottom: 1px solid #20b368; padding: 20px; color: #ffffff;">
			Value
		</th>
	</tr>

	<tr>
		<th style="width: 50%; border-bottom: 1px solid #20b368; border-right: 1px solid #20b368; padding: 20px;">
			Name
		</th>
		<td style="width: 50%; border-bottom: 1px solid #20b368; padding: 20px;">
			<?php echo isset($meta_data['fullName'][0])? $meta_data['fullName'][0]: ''; ?>
		</td>
	</tr>
	
	<tr>
		<th style="width: 50%; border-bottom: 1px solid #20b368; border-right: 1px solid #20b368; padding: 20px;">
			Email
		</th>
		<td style="width: 50%; border-bottom: 1px solid #20b368; padding: 20px;">
			<?php echo $user->user_email; ?>
		</td>
	</tr>
	
	<tr>
		<th style="width: 50%; border-bottom: 1px solid #20b368; border-right: 1px solid #20b368; padding: 20px;">
			Phone
		</th>
		<td style="width: 50%; border-bottom: 1px solid #20b368; padding: 20px;">
			<?php echo isset($meta_data['phone'][0])? $meta_data['phone'][0]: ''; ?>
		</td>
	</tr>
	
	<tr>
		<th style="width: 50%; border-bottom: 1px solid #20b368; border-right: 1px solid #20b368; padding: 20px;">
			Country
		</th>
		<td style="width: 50%; border-bottom: 1px solid #20b368; padding: 20px;">
			<?php echo isset($meta_data['country'][0])? $meta_data['country'][0]: ''; ?>
		</td>
	</tr>
	
	<tr>
		<th style="width: 50%; border-bottom: 1px solid #20b368; border-right: 1px solid #20b368; padding: 20px;">
			Address
		</th>
		<td style="width: 50%; border-bottom: 1px solid #20b368; padding: 20px;">
			<?php echo isset($meta_data['address'][0])? $meta_data['address'][0]: ''; ?>
		</td>
	</tr>
	


	<tr>
		<th style="width: 50%; border-bottom: 1px solid #20b368; border-right: 1px solid #20b368; padding: 20px;">
			Wallet balance
		</th>
		<td style="width: 50%; border-bottom: 1px solid #20b368; padding: 20px;">
			<?php echo isset($meta_data['wallet_balance'][0])? $meta_data['wallet_balance'][0]: ''; ?>
		</td>
	</tr>
	
	<tr>
		<th style="width: 50%; border-bottom: 1px solid #20b368; border-right: 1px solid #20b368; padding: 20px;">
			Issued visas
		</th>
		<td style="width: 50%; border-bottom: 1px solid #20b368; padding: 20px;">
			<?php echo isset($meta_data['issued_visas'][0])? $meta_data['issued_visas'][0]: ''; ?>
		</td>
	</tr>
		
	<tr>
		<th style="width: 50%; border-bottom: 1px solid #20b368; border-right: 1px solid #20b368; padding: 20px;">
			Additional services balance
		</th>
		<td style="width: 50%; border-bottom: 1px solid #20b368; padding: 20px;">
			<?php echo isset($meta_data['additional_services_balance'][0])? $meta_data['additional_services_balance'][0]: ''; ?>
		</td>
	</tr>
	
</table>

<div style="width: 100%; margin: 0 auto; display: block; overflow:hidden; text-align: center;">
    <a href="<?php echo site_url('/submit-order');?>" type="submit" name="order_submit" value="submit" style="display: block; padding: 15px; margin-top: 20px; background-color: #20b368; color: #fff; border-width: 0px; width: 300px; margin-right: 10px; float: left; text-align:center;">Submit Order</a>
<a href="<?php echo site_url('/order-list');?>" type="submit" name="order_submit" value="submit" style="display: block;   margin-right: 10px;   padding: 15px; margin-top: 20px; background-color: #20b368; color: #fff; border-width: 0px; width: 300px; float: left; text-align:center;">Order List</a>
<a href="<?php echo site_url('/support-ticket');?>" type="submit" name="order_submit" value="submit" style="display: block;     padding: 15px; margin-top: 20px; background-color: #20b368; color: #fff; border-width: 0px; width: 300px; float: left; text-align:center;">Submit Ticket</a>
</div>


<?php
	return ob_get_clean();
}

//Shortcodes create_new_orders
add_shortcode('cam-agent-profile', 'cam_agent_profile');