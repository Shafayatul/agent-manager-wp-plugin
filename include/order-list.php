<?php
ob_start();
function camOrderListFunction(){
	$cam_display_order_table = new Cam_Order_List_Table();
	$cam_display_order_table->prepare_items();
	?>
		<div class="wrap">
			<div id="icon-users" class="icon32"></div>
			<h2>All Agents</h2><span>**List of all agents</span>
			<form method="post">
				<input type="hidden" name="page" value="example_list_table" />
			</form>
			<?php $cam_display_order_table->display(); ?>
		</div>
	<?php
}


//Create a new table class that will extend the WP_List_Table
class Cam_Order_List_Table extends WP_List_Table {
	public function prepare_items()
	{
		$columns               = $this->get_columns();
		$hidden                = $this->get_hidden_columns();
		$sortable              = $this->get_sortable_columns();

		$data                  = $this->table_data();
		usort( $data, array( &$this, 'sort_data' ) );

		$perPage               = 20;
		$currentPage           = $this->get_pagenum();
		$totalItems            = count($data);

		$this->set_pagination_args( array(
			'total_items'        => $totalItems,
			'per_page'           => $perPage
		) );

		$data = array_slice($data,(($currentPage-1)*$perPage),$perPage);

		$this->_column_headers = array($columns, $hidden, $sortable);
		$this->items           = $data;
	}

	public function get_columns(){

		$columns = array(
			'ID'    => 'ID',
			'EMAIL'   => 'EMAIL',
			'PHONE'	  => 'PHONE',
			'ADDRESS' => 'ADDRESS',
			'COUNTRY' => 'COUNTRY',
			'ACTION'  => 'ACTION'
		);

		return $columns;
	}

	public function get_hidden_columns() {
		return array();
	}

	public function get_sortable_columns() {
		return array('ID' => array('ID', false));
	}

	private function table_data() {
		$data            = array();
		global $wpdb;
		$table_name      = $wpdb->prefix . 'usermeta';
		$agents          = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE meta_key = 'user_type' AND meta_value = 'agent'", OBJECT );
		$agent_id_array  = [];
		foreach ($agents as $agent) {
			array_push($agent_id_array, $agent->user_id);
		}
		$agent_ids = implode(',', $agent_id_array);

		$table_name  = $wpdb->prefix . 'users';
		$users       = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE  `id` IN ($agent_ids)", OBJECT );


		foreach($users as $user){
			$meta_data = get_user_meta($user->ID);
			$data[] = array(
				'ID'      => $user->user_login,
				'EMAIL'     => $user->user_email,
				'PHONE' 	  => $meta_data['phone'][0],
				'ADDRESS'   => $meta_data['address'][0],
				'COUNTRY'   => $meta_data['country'][0],
				'ACTION'    => ''
					// 'Action'      => '<a href="'.admin_url().'?page=cmr-edit-member&pervious_page=pending-member&id='.$user->id.'" class="button button-primary">Edit</a>&nbsp;<a href="'.admin_url().'?page=cmr-delete-member&pervious_page=pending-member&id='.$user->id.'" class="button button-primary">Delete</a>&nbsp;<a  href="'.admin_url().'?page=cmr-detail-member&id='.$user->id.'" class="button button-primary">Detail</a>'
			);
		}
		return $data;
	}

	public function column_default( $item, $column_name ) {
		switch( $column_name ) {
			case 'ID':
			case 'EMAIL':
			case 'PHONE':
			case 'ADDRESS':
			case 'COUNTRY':
			case 'ACTION':
			return $item[ $column_name ];

			default:
			return print_r( $item, true ) ;
		}
	}

	private function sort_data( $a, $b ) {
			// Set defaults
		$orderby = 'ID';
		$order = 'asc';

			// If orderby is set, use this as the sort column
		if(!empty($_GET['orderby']))
		{
			$orderby = $_GET['orderby'];
		}

			// If order is set use this as the order
		if(!empty($_GET['order']))
		{
			$order = $_GET['order'];
		}


		$result = strnatcmp( $a[$orderby], $b[$orderby] );

		if($order === 'asc')
		{
			return $result;
		}

		return -$result;
	}
}
