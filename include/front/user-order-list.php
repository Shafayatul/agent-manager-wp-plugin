<?php
//Create new order function
function cam_front_order_list(){
	ob_start();
	global $wpdb;
	$user_id    = get_current_user_id();
	$table_name      = $wpdb->prefix . 'cam_orders';
	$orders          = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE user_id='".$user_id."'", OBJECT );
?>
<h1>Order List</h1>
<table cellpadding="0" cellspacing="0" style="width: 100%; text-align: center;">
	<tr>
		<th style="width: 40%;">
			Order Type
		</th>
		<td style="width: 30%;">
			Date
		</td>
		<td style="width: 30%;">
			Status
		</td>
	</tr>
	<?php 
	foreach ($orders as $order) {
	?>
		<tr>
			<th style="width: 40%;">
				<?php echo strtoupper(str_replace('_', ' ', $order->order_type)); ?>
			</th>
			<td style="width: 30%;">
				<?php echo $order->submission_date; ?>
			</td>
			<td style="width: 30%;">
				<?php echo strtoupper($order->status); ?>
			</td>
		</tr>
	<?php
	}
	?>

	
</table>


<a href="<?php echo site_url('/add-order');?>" type="submit" name="order_submit" value="submit" style="display: block;     padding: 15px 40px; margin-top: 20px; background-color: #20b368; color: #fff; border-width: 0px;">Add Order</a>
<a href="<?php echo site_url('/order-list');?>" type="submit" name="order_submit" value="submit" style="display: block;     padding: 15px 40px; margin-top: 20px; background-color: #20b368; color: #fff; border-width: 0px;">Order List</a>
<a href="<?php echo site_url('/add-ticket');?>" type="submit" name="order_submit" value="submit" style="display: block;     padding: 15px 40px; margin-top: 20px; background-color: #20b368; color: #fff; border-width: 0px;">Add Ticket</a>

<?php
	return ob_get_clean();
}

//Shortcodes create_new_orders
add_shortcode('cam-agent-order-list', 'cam_front_order_list');