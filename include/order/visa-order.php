<?php
ob_start();
function camOrderVisaListFunction(){
	$cam_display_order_visa_table = new Cam_Order_Visa_List_Table();
	$cam_display_order_visa_table->prepare_items();
	?>
		<div class="wrap">
			<div id="icon-users" class="icon32"></div>
			<h2>All Agents</h2><span>**List of all orders</span>
			<form method="post">
				<input type="hidden" name="page" value="example_list_table" />
			</form>
			<?php $cam_display_order_visa_table->display(); ?>
		</div>
	<?php
}


//Create a new table class that will extend the WP_List_Table
class Cam_Order_Visa_List_Table extends WP_List_Table {
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
			'ORDER NUMBER' => 'ORDER NUMBER',
			'DATE'         => 'DATE',
			'NAME'	       => 'NAME',
			'STATUS'      => 'STATUS',
			'ACTION'       => 'ACTION'
		);

		return $columns;
	}

	public function get_hidden_columns() {
		return array();
	}

	public function get_sortable_columns() {
		return array('ORDER NUMBER' => array('ORDER NUMBER', false));
	}

	private function table_data() {
		$data            = array();
		global $wpdb;
		$table_name      = $wpdb->prefix . 'cam_orders';
		$orders          = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE order_type='visa'", OBJECT );

		foreach($orders as $order){
			$table_name = $wpdb->prefix . 'users';
			$user       = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE id='".$order->user_id."'", OBJECT );
			$meta_data  = get_user_meta($order->user_id);
			$data[] = array(
				'ORDER NUMBER' => $order->id,
				'DATE'         => $order->submission_date,
				'NAME' 	       => isset($meta_data['fullName'][0])? $meta_data['fullName'][0]: '--',
				'STATUS'       => isset($meta_data['address'][0])? $meta_data['address'][0]: '--',
				'ACTION'       => '
					<a  href="'.admin_url().'?page=cam-detail-item&table=cam_orders&id='.$order->id.'" class="button button-primary">Detail</a>&nbsp;
					<a href="'.admin_url().'?page=cam-delete-item&table=cam_orders&id='.$order->id.'" class="button button-primary">Delete</a>'
			);
		}
		return $data;
	}

	public function column_default( $item, $column_name ) {
		switch( $column_name ) {
			case 'ORDER NUMBER':
			case 'DATE':
			case 'NAME':
			case 'STATUS':
			case 'ACTION':
			return $item[ $column_name ];

			default:
			return print_r( $item, true ) ;
		}
	}

	private function sort_data( $a, $b ) {
			// Set defaults
		$orderby = 'ORDER NUMBER';
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
