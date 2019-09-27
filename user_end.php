<?php
ob_start();
//Calling custom js file
function cam_enqueue_related_pages_scripts_and_styles(){
        // wp_enqueue_style('related-styles', plugins_url('/css/bootstrap.min.css', __FILE__));
        wp_enqueue_script('releated-script', plugins_url( '/js/custom.js' , __FILE__ ), array('jquery','jquery-ui-droppable','jquery-ui-draggable', 'jquery-ui-sortable'));
    }
add_action('wp_enqueue_scripts','cam_enqueue_related_pages_scripts_and_styles');

//Create new order function
function cam_create_new_order(){
  ob_start();
  if (is_user_logged_in()) {
    global $wpdb;
    if ( isset( $_POST['order_submit'] ) && isset( $_POST['order_type'])) {
      $user_id = 1;
      $order_type       = $_POST['order_type'];
      $visa_number      = $_POST['visa_number'];
      $no_of_person     = $_POST['no_of_person'];

      if (isset( $_POST['trip_location_id'] )) {
        $trip_location_id = $_POST['trip_location_id'];
      }else {
        $trip_location_id = '';
      }

      $no_of_tickets    = $_POST['no_of_tickets'];
      if (isset( $_POST['direction'] )) {
        $direction        = $_POST['direction'];
      }else {
        $direction = '';
      }

      $ticket_date      = $_POST['ticket_date'];
      $other_text       = $_POST['other_text'];
      $status           = $_POST['status'];

      // insert dsta to database except file
  		$table_name = $wpdb->prefix . 'cam_orders'; //to get the table name

      $wpdb->insert($table_name, array(
         "user_id"          => $user_id,
         "order_type"       => $order_type,
         "visa_number"      => $visa_number,
         "no_of_person"     => $no_of_person,
         "trip_location_id" => $trip_location_id,
         "no_of_tickets"    => $no_of_tickets,
         "direction"        => $direction,
         "ticket_date"      => $ticket_date,
         "other_text"       => $other_text,
         "status"           => $status
  		));

  		// last inserted id
  		$lastid = $wpdb->insert_id;
      if ($lastid != null) {

      /**
      * uploading files
      */
      $total = count($_FILES['file']['name']);
      // Loop through each file
      for( $i=0 ; $i < $total ; $i++ ) {
        //Get the temp file path
        $tmpFilePath = $_FILES['file']['tmp_name'][$i];
        //Make sure we have a file path
        if ($tmpFilePath != ""){
          $uploaded_file = wp_upload_bits( $_FILES['file']['name'][$i], null, @file_get_contents( $_FILES['file']['tmp_name'][$i] ) );

          $table_name = $wpdb->prefix . 'cam_files'; //to get the table name

          $wpdb->insert($table_name, array(
             "order_id" => $lastid,
             "url"      => $uploaded_file['url']
          ));

        }
      } //file upload ends

        echo "Order Added Successfully Added Successfully";
      }

    }

    $table_name      = $wpdb->prefix . 'cam_trip_location';
    $trips           = $wpdb->get_results( "SELECT * FROM ".$table_name, OBJECT );

    $options_html = '';
    foreach ($trips as $trip) {
      $options_html = $options_html.'<option value="'.$trip->id.'">'.$trip->name.'<options>';
    }

    echo '
      <form action="" method="post" enctype="multipart/form-data" style="margin-bottom: 20px; padding: 20px;">
        <label for="order_type" style="display: block; margin-bottom: 5px;">Select Order Type</label>
        <select name="order_type" id="order_type" style="width: 400px; height: 40px;">
          <option disabled selected>Select Order Type</option>
          <option value="visa">Visa</option>
          <option value="tourism_trip">Tourism Trip</option>
          <option value="train_ticket">Train Ticket</option>
          <option value="others">Others</option>
        </select>

        <div class="visa_order_form" style="display:none;">
          <label for="visa_number" style="display: block; margin-bottom: 5px;">Number Of Requested Visas</label>
          <input type="number" name="visa_number" value="" style="width: 400px; padding: 10px;">
        </div>

        <div class="tourism_trip" style="display:none;">
          <label for="no_of_person" style="display: block; margin-bottom: 5px;">Number Of Persons</label>
          <input type="number" name="no_of_person" value="" style="width: 400px; padding: 10px;">

          <label for="trip_location_id" style="display: block; margin-bottom: 5px;">Select Trip Location</label>
          <select name="trip_location_id" id="trip_location_id" style="width: 400px; height: 40px;">
            <option disabled selected>Select Trip Location</option>
            '.$options_html.'
            </select>
        </div>

        <div class="train_ticket_order_form" style="display:none;">
          <label for="no_of_tickets" style="display: block; margin-bottom: 5px;">Number Of Requested Tickets</label>
          <input type="number" name="no_of_tickets" value="" style="width: 400px; padding: 10px;">

          <label for="direction" style="display: block; margin-bottom: 5px;">Select Direction</label>
          <select name="direction" id="direction" style="width: 400px; height: 40px;">
            <option disabled selected>Select Direction</option>
            <option value="one_way">One Way</option>
            <option value="two_way">Two Way</option>
          </select>

          <label for="ticket_date" style="display: block; margin-bottom: 5px;">Date</label>
          <input type="date" name="ticket_date" id="ticket_date" value="" style="width: 400px; padding: 10px;">

        </div>

        <div class="other_order_form" style="display:none;">
          <label for="other_text" style="display: block; margin-bottom: 5px;">Description</label>
          <textarea name="other_text" rows="8" cols="80"></textarea>
        </div>


        <label for="passport" style="display: block; margin-top: 20px; margin-bottom: 5px;">Upload Passport</label>
        <input name="file[]" type="file" id="passport"/>

        <button class="add_more">Add More Files</button>


        <input name="status" type="hidden" value="pending"/>

        <button type="submit" name="order_submit" value="submit" style="padding: 10px; margin-top: 20px; background-color: #20b368; color: #fff; border-width: 0px;">Submit</button>
      </form>
    ';
  }else {
    echo '<p style="color:red">Please Login to view this page</p>';
  }

  return ob_get_clean();
}

//Shortcodes create_new_orders
add_shortcode('cam-create-new-order', 'cam_create_new_order');


//Create new Ticket function
function cam_create_new_ticket(){
  ob_start();

  if (is_user_logged_in()) {
    global $wpdb;

    if ( isset( $_POST['ticket_submit'] ) ) {

      $description = $_POST['ticket_description'];

      // insert dsta to database except file
      $table_name = $wpdb->prefix . 'cam_tickets'; //to get the table name

      $wpdb->insert($table_name, array(
         "description" => $description
      ));

      // last inserted id
      $lastid = $wpdb->insert_id;
      echo 'DATA SUBMITTED '.$lastid;
    }

    echo '
      <form action="" method="post" enctype="multipart/form-data" style="margin-bottom: 20px; padding: 20px;">

        <div class="ticket_description">
          <label for="ticket_description" style="display: block; margin-bottom: 5px;">Description</label>
          <textarea name="ticket_description" rows="8" cols="80"></textarea>
        </div>


        <label for="ticket_file" style="display: block; margin-top: 20px; margin-bottom: 5px;">Upload Files</label>
        <input name="file[]" type="file" id="ticket_file"/>
        <button class="add_more">Add More Files</button>


        <button type="submit" name="ticket_submit" value="submit" style="padding: 10px; margin-top: 20px; background-color: #20b368; color: #fff; border-width: 0px;">Submit</button>
      </form>
    ';
  }else {
    echo '<p style="color:red">Please Login to view this page</p>';
  }


  return ob_get_clean();
}


//Shortcodes create_new_tickets
add_shortcode('cam-create-new-ticket', 'cam_create_new_ticket');

?>
