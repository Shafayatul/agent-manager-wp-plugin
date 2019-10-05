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
		<th style="width: 40%; background: #20b368; border-bottom: 1px solid #20b368; border-right: 1px solid #ffffff; padding: 20px; color: #ffffff;">
			Order Type
		</th>
		<th style="width: 30%; background: #20b368; border-bottom: 1px solid #20b368; border-right: 1px solid #ffffff; padding: 20px; color: #ffffff;">
			Date
		</th>
		<th style="width: 30%; background: #20b368; border-bottom: 1px solid #20b368; padding: 20px; border-right: 1px solid #20b368; color: #ffffff;">
			Status
		</th>
	</tr>
	<?php 
	foreach ($orders as $order) {
	?>
		<tr>
			<td style="width: 40%; border-bottom: 1px solid #20b368; border-right: 1px solid #20b368; border-left: 1px solid #20b368; padding: 20px;">
				<?php echo strtoupper(str_replace('_', ' ', $order->order_type)); ?>
			</td>
			<td style="width: 30%; border-bottom: 1px solid #20b368; border-right: 1px solid #20b368; border-left: 1px solid #20b368; padding: 20px;">
				<?php echo $order->submission_date; ?>
			</td>
			<td style="width: 30%; border-bottom: 1px solid #20b368; border-right: 1px solid #20b368; border-left: 1px solid #20b368; padding: 20px;">
				<?php echo strtoupper($order->status); ?>
			</td>
		</tr>
	<?php
	}
	?>

	
</table>

<div style="width: 100%; margin: 0 auto; display: block; overflow:hidden; text-align: center;">
<a href="<?php echo site_url('/add-order');?>" type="submit" name="order_submit" value="submit" style="display: block; padding: 15px; margin-top: 20px; background-color: #20b368; color: #fff; border-width: 0px; width: 300px; margin-right: 10px; float: left; text-align:center;">Add Order</a>
<a href="<?php echo site_url('/order-list');?>" type="submit" name="order_submit" value="submit" style="display: block; padding: 15px; margin-top: 20px; background-color: #20b368; color: #fff; border-width: 0px; width: 300px; margin-right: 10px; float: left; text-align:center;">Order List</a>
<a href="<?php echo site_url('/add-ticket');?>" type="submit" name="order_submit" value="submit" style="display: block; padding: 15px; margin-top: 20px; background-color: #20b368; color: #fff; border-width: 0px; width: 300px; margin-right: 10px; float: left; text-align:center;">Add Ticket</a>
</div>
<?php
	return ob_get_clean();
}

//Shortcodes create_new_orders
add_shortcode('cam-agent-order-list', 'cam_front_order_list');