<?php
ob_start();
//Function For Trip Lists
function tripListFunction(){
  $display_trip_table = new Trip_List_Table();
			$display_trip_table->prepare_items();
			?>
				<div class="wrap">
					<div id="icon-users" class="icon32"></div>
					<h2>All Trip Location</h2><span>**List of all trip location</span>
					<form method="post">
						<input type="hidden" name="page" value="example_list_table" />
						<?php //$display_agent_table->search_box('search', 'search_id'); ?>
					</form>
					<?php $display_trip_table->display(); ?>
				</div>
			<?php
}

//Create a new table class that will extend the WP_List_Table
class Trip_List_Table extends WP_List_Table {
	public function prepare_items() {
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
	  	'ID'     => 'ID',
	  	'NAME'   => 'NAME',
	  	'ACTION' => 'ACTION'
	  );

		return $columns;
	}

	public function get_hidden_columns() {
				return array();
			}

	public function get_sortable_columns() {
			return array('NAME' => array('NAME', false));
	}

	private function table_data() {
	   $data            = array();
	   global $wpdb;
	   $table_name      = $wpdb->prefix . 'cam_trip_location';
	   $trips           = $wpdb->get_results( "SELECT * FROM ".$table_name, OBJECT );


			foreach($trips as $trip){
				$data[] = array(
						'ID'     => $trip->id,
						'NAME'   => $trip->name,
						'ACTION' => '<a href="'.admin_url().'?page=cam-delete-item&table=cam_trip_location&id='.$trip->id.'" class="button button-primary">Delete</a>'
						);
			}
		return $data;
	}

	public function column_default( $item, $column_name ) {
		switch( $column_name ) {
			case 'ID':
			case 'NAME':
			case 'ACTION':
				return $item[ $column_name ];

			default:
				return print_r( $item, true ) ;
		}
	}

	private function sort_data( $a, $b ) {
		// Set defaults
		$orderby = 'NAME';
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