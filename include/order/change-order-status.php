<?php
function camChangeOrderStatus(){
	$msg = '';
	global $wpdb;
	//Agent data submit to SQLiteDatabase
	if ( isset( $_POST['agent_submit'] ) ) {
		$status = $_POST['status'];
		$id     = $_GET['order_id'];
		$table_name      = $wpdb->prefix . 'cam_orders';
		$wpdb->update($table_name, 
			["status"          => $status],
			["id"          => $id]
		);

		$msg = 'Update successful';
	}


echo '
<div class="wrap">
	<h2>Chagne order status</h2>
	<p>'.$msg.'</p>
	<div class="welcome-panel"  id="welcome-panel">
		<form action="" method="post" style="margin-bottom: 20px; padding: 20px;">
				<div class="right" style="width:50%; float:left">
				<label for="status" style="display: block; margin-bottom: 5px;">Status</label>
				<select id="status" name="status" style="width: 400px; height: 40px;">
					<option value="PENDING">PENDING</option>
					<option value="IN PROCESS">IN PROCESS</option>
					<option value="COMPLETE">COMPLETE</option>
					<option value="CANCELLED">CANCELLED</option>
				</select>
			</div>
			<button type="submit" name="agent_submit" value="submit" style="width: 100px; height: 50px; padding: 10px; margin-top: 20px; background-color: #20b368; color: #fff; border-width: 0px;">Submit</button>
		</form>
	</div>
</div>
';
}