<?php
ob_start();
function camDetailItemFunction(){
	global $wpdb;
    $table = $_GET['table'];
    $id    = $_GET['id'];

    if ($table == 'cam_tickets') {
    	$table_name = $wpdb->prefix . $table;
	    $ticket = $wpdb->get_row( "SELECT * FROM ".$table_name." WHERE id='1'", OBJECT );

	    $table_name = $wpdb->prefix . 'cam_files';
	    $files = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE ticket_id='".$id."'", OBJECT );

	    $html_download_btn = '';

	    if (count($files) == 0) {
	    	$html_download_btn = 'No files';
	    }else{
	    	$i = 1;
	    	foreach ($files as $file) {
	    		$html_download_btn = $html_download_btn. '<a download href="'.$file->url.'" class="button button-primary"><span class="dashicons dashicons-category"></span> File - '.$i.'</a>&nbsp;';
	    		$i++;
	    	}
	    }
	    echo '
	    <div class="wrap">
	      <h2>Ticket Detail</h2>
	      <div class="welcome-panel"  id="welcome-panel">
	        <ul>
	          <li>
	            <p><b>Detail: </b></p>
	            <p>
	              '.$ticket->description.'
	            </p>
	          </li>
	          <li>
	            <p><b>Files: </b></p>

	            <p>
	            	'.$html_download_btn.'
	            </p>
	          </li>
	          
	        </ul>
	      </div>
	    ';


    }elseif($table == "cam_orders"){
    	$table_name = $wpdb->prefix . $table;
	    $order = $wpdb->get_row( "SELECT * FROM ".$table_name." WHERE id='".$id."'", OBJECT );

	    $table_name = $wpdb->prefix . 'cam_files';
	    $files = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE order_id='".$id."'", OBJECT );

	    $html_download_btn = '';

	    if (count($files) == 0) {
	    	$html_download_btn = 'No files';
	    }else{
	    	$i = 1;
	    	foreach ($files as $file) {
	    		$html_download_btn = $html_download_btn. '<a download href="'.$file->url.'" class="button button-primary"><span class="dashicons dashicons-category"></span> File - '.$i.'</a>&nbsp;';
	    		$i++;
	    	}
	    }
	    echo '
	    <div class="wrap">
	      <h2>Order Detail</h2>
	      <div class="welcome-panel"  id="welcome-panel">
	        <ul>
	          <li>
	            <p><b>Detail: </b></p>
	            <p>
	              '.strtoupper(str_replace('_', ' ', $order->order_type)).'
                </p>
              </li>
	          <li>
	            <p><b>Visa Number: </b></p>
	            <p>
	              '.
	              $order->visa_number.'
                </p>
              </li>
	          <li>
	            <p><b>No of person: </b></p>
	            <p>
	              '.
	              $order->no_of_person.'
                </p>
              </li>
	          <li>
	            <p><b>Trip Location id: </b></p>
	            <p>
	              '.
	              $order->trip_location_id.'
                </p>
              </li>
	          <li>
	            <p><b>No of ticket: </b></p>
	            <p>
	              '.
	              $order->no_of_tickets.'
                </p>
              </li>
	          <li>
	            <p><b>Direction: </b></p>
	            <p>
	              '.
	              $order->direction.'
                </p>
              </li>
	          <li>
	            <p><b>TIcket date: </b></p>
	            <p>
	              '.
	              $order->ticket_date.'
                </p>
              </li>
	          <li>
	            <p><b>Other: </b></p>
	            <p>
	              '.
	              $order->other_text.'
                </p>
              </li>
	          <li>
	            <p><b>Status: </b></p>
	            <p>
	              '.
	              $order->status.'
                </p>
              </li>
	          <li>
	            <p><b>Submission Date: </b></p>
	            <p>
	              '.
	              $order->submission_date.'
                </p>
              </li>


	          <li>
	            <p><b>Files: </b></p>

	            <p>
	            	'.$html_download_btn.'
	            </p>
	          </li>
	          
	        </ul>
	      </div>
	    ';
    }


}