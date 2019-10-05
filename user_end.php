<?php
ob_start();
//Calling custom js file
function cam_enqueue_related_pages_scripts_and_styles(){
        // wp_enqueue_style('related-styles', plugins_url('/css/bootstrap.min.css', __FILE__));
        wp_enqueue_script('releated-script', plugins_url( '/js/custom.js' , __FILE__ ), array('jquery','jquery-ui-droppable','jquery-ui-draggable', 'jquery-ui-sortable'));
    }
add_action('wp_enqueue_scripts','cam_enqueue_related_pages_scripts_and_styles');

include('include/front/agent-login.php');
include('include/front/agent-profile.php');
include('include/front/user-order-list.php');

//Create new order function
function cam_create_new_order(){
  ob_start();
  if (is_user_logged_in()) {
    global $wpdb;
    if ( isset( $_POST['order_submit'] ) && isset( $_POST['order_type'])) {
      $user_id      = get_current_user_id();
      $order_type   = $_POST['order_type'];
      $visa_number  = $_POST['visa_number'];
      $no_of_person = $_POST['no_of_person'];

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

      $sdfsdf = $wpdb->insert($table_name, array(
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

      // Email notifications
      $to        = "mdshafayatul@gmail.com";
      $subject   = "New Order";
      // Always set content-type when sending HTML email
      $headers   = "MIME-Version: 1.0" . "\r\n";
      $headers  .= "Content-type:text/html;charset=UTF-8" . "\r\n";

      $message   = '
      <html>
        <head>
          <title>New Order</title>
        </head>
        <body>
          <p>This email contains HTML Tags!</p>
          <table>
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
                Type
              </th>
              <td style="width: 50%;">
                '.$order_type.'
              </td>
            </tr>
            <tr>
              <th style="width: 50%;">
                Visa
              </th>
              <td style="width: 50%;">
                '.$visa_number.'
              </td>
            </tr>
            <tr>
              <th style="width: 50%;">
                No. of person
              </th>
              <td style="width: 50%;">
                '.$no_of_person.'
              </td>
            </tr>
            <tr>
              <th style="width: 50%;">
                Trip location
              </th>
              <td style="width: 50%;">
                '.$trip_location_id.'
              </td>
            </tr>
            <tr>
              <th style="width: 50%;">
                No of ticket
              </th>
              <td style="width: 50%;">
                '.$no_of_tickets.'
              </td>
            </tr>
            <tr>
              <th style="width: 50%;">
                Direction
              </th>
              <td style="width: 50%;">
                '.$direction.'
              </td>
            </tr>
            <tr>
              <th style="width: 50%;">
                Ticket date
              </th>
              <td style="width: 50%;">
                '.$ticket_date.'
              </td>
            </tr>
            <tr>
              <th style="width: 50%;">
                Other Text
              </th>
              <td style="width: 50%;">
                '.$other_text.'
              </td>
            </tr>
          </table>
        </body>
      </html>
      ';

        wp_mail($to, $subject, $message, $headers = '');
        echo "Order Added Successfully Added Successfully";

      }

    }

    $table_name      = $wpdb->prefix . 'cam_trip_location';
    $trips           = $wpdb->get_results( "SELECT * FROM ".$table_name, OBJECT );

    $options_html = '';
    foreach ($trips as $trip) {
      $options_html = $options_html.'<option value="'.$trip->name.'">'.$trip->name.'<options>';
    }

    echo '
      <form action="" method="post" enctype="multipart/form-data" style="width: 100%; margin: 20px auto; padding: 20px;">
        <label for="order_type" style="display: block; margin-bottom: 5px; font-size: 20px; font-weight: 400;">SELECT ORDER TYPE</label>
        <select name="order_type" id="order_type" style="width: 100%; height: 60px; background-color: #fff; border: 1px solid #ececec; box-shadow: 0px 10px 10px -10px rgba(0,0,0,0.4); margin-bottom : 40px; padding: 10px;">
          <option style="padding: 10px;" disabled selected>Select Order Type</option>
          <option style="padding: 10px;" value="visa">Visa</option>
          <option style="padding: 10px;" value="tourism_trip">Tourism Trip</option>
          <option style="padding: 10px;" value="train_ticket">Train Ticket</option>
          <option style="padding: 10px;" value="others">Others</option>
        </select>

        <div class="visa_order_form" style="display:none; overflow: hidden; width: 100%; margin-bottom : 40px;">
          <label for="visa_number" style="display: block; margin-bottom: 5px; font-size: 20px; font-weight: 400;">NUMBER OF REQUESTED VISAS</label>
          <input type="number" name="visa_number" value="" style="width: 100%; display: block; height: 60px; background-color: #fff; border: 1px solid #ececec; box-shadow: 0px 10px 10px -10px rgba(0,0,0,0.4); margin-bottom : 40px; padding: 10px; -webkit-box-sizing: border-box;">
        </div>

        <div class="tourism_trip" style="display:none; overflow: hidden; width: 100%;">
          <label for="no_of_person" style="display: block; margin-bottom: 5px; font-size: 20px; font-weight: 400;">NUMBER OF PERSONS</label>
          <input type="number" name="no_of_person" value="" style="width: 100%; display: block; height: 60px; background-color: #fff; border: 1px solid #ececec; box-shadow: 0px 10px 10px -10px rgba(0,0,0,0.4); margin-bottom : 40px; padding: 10px; -webkit-box-sizing: border-box;">

          <label for="trip_location_id" style="display: block; margin-bottom: 5px; font-size: 20px; font-weight: 400;">SELECT TRIP LOCATIONS</label>
          <select name="trip_location_id" id="trip_location_id" style="width: 100%; height: 60px; background-color: #fff; border: 1px solid #ececec; box-shadow: 0px 10px 10px -10px rgba(0,0,0,0.4); margin-bottom : 40px; padding-left: 10px;">
            <option disabled selected>Select Trip Location</option>
            '.$options_html.'
            </select>
        </div>

        <div class="train_ticket_order_form" style="display:none;">
          <label for="no_of_tickets" style="display: block; margin-bottom: 5px; font-size: 20px; font-weight: 400;">NUMBER OF REQUESTED TICKETS</label>
          <input type="number" name="no_of_tickets" value="" style="width: 100%; display: block; height: 60px; background-color: #fff; border: 1px solid #ececec; box-shadow: 0px 10px 10px -10px rgba(0,0,0,0.4); margin-bottom : 40px; padding: 10px; -webkit-box-sizing: border-box;">

          <label for="direction" style="display: block; margin-bottom: 5px; font-size: 20px; font-weight: 400;">SELECT DIRECTION</label>
          <select name="direction" id="direction" style="width: 100%; height: 60px; background-color: #fff; border: 1px solid #ececec; box-shadow: 0px 10px 10px -10px rgba(0,0,0,0.4); margin-bottom : 40px; padding-left: 10px;">
            <option disabled selected>Select Direction</option>
            <option value="one_way">One Way</option>
            <option value="two_way">Two Way</option>
          </select>

          <label for="ticket_date" style="display: block; margin-bottom: 5px; font-size: 20px; font-weight: 400;">DATE</label>
          <input type="date" name="ticket_date" id="ticket_date" value="" style="width: 100%; display: block; height: 60px; background-color: #fff; border: 1px solid #ececec; box-shadow: 0px 10px 10px -10px rgba(0,0,0,0.4); margin-bottom : 40px; padding: 10px; -webkit-box-sizing: border-box;">

        </div>

        <div class="other_order_form" style="display:none;">
          <label for="other_text" style="display: block; margin-bottom: 5px; font-size: 20px; font-weight: 400;">DESCRIPTION</label>
          <textarea name="other_text" rows="5" style="display: block; height: 200px; background-color: #fff; border: 1px solid #ececec; box-shadow: 0px 10px 10px -10px rgba(0,0,0,0.4); margin-bottom : 40px; padding: 10px; width: 100%; display: block;"></textarea>
        </div>


        <label for="passport" style="display: block; margin-top: 20px; margin-bottom: 5px; font-size: 20px; font-weight: 400;">UPLOAD PASSPORT</label>
        
        <div style="min-height: 60px; background-color: #fff; border: 1px solid #ececec; box-shadow: 0px 10px 10px -10px rgba(0,0,0,0.4); margin-bottom: 40px; padding: 15px 10px;">
            
            <input name="file[]" type="file" id="passport" style="width: 300px;"/>

            <button class="add_more" style="padding: 10px; margin-top: 0px; background-color: #378ac4; color: #fff; border-width: 0px; font-weight: bold; float:right; ">Add More Files</button>
          </div>
        
        <input name="status" type="hidden" value="PENDING"/>

        <button type="submit" name="order_submit" value="submit" style="display: block; padding: 15px 40px; background-color: #20b368; color: #fff; border-width: 0px; font-size: 17px; font-weight: bold;">SUBMIT</button>
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
             "ticket_id" => $lastid,
             "url"      => $uploaded_file['url']
          ));

        }
      } //file upload ends
      echo 'Ticket successfully submitted.';
    }

    echo '
      <form action="" method="post" enctype="multipart/form-data" style="width: 100%; margin: 20px auto; padding: 20px;">

        <div class="ticket_description">
          <label for="ticket_description" style="display: block; margin-bottom: 5px; font-size: 20px; font-weight: 400;">DESCRIPTION</label>
          <textarea name="ticket_description" rows="5" style="display: block; height: 200px; background-color: #fff; border: 1px solid #ececec; box-shadow: 0px 10px 10px -10px rgba(0,0,0,0.4); margin-bottom : 40px; padding: 10px; width: 100%; display: block;"></textarea>
        </div>
        
        <label for="ticket_file" style="display: block; margin-bottom: 5px; font-size: 20px; font-weight: 400;">UPLOAD FILES</label>
        
        <div style="min-height: 60px; background-color: #fff; border: 1px solid #ececec; box-shadow: 0px 10px 10px -10px rgba(0,0,0,0.4); margin-bottom: 40px; padding: 15px 10px;">
        
            <input name="file[]" type="file" id="ticket_file" style="width: 300px;"/>
            
            <button class="add_more" style="padding: 10px; margin-top: 0px; background-color: #378ac4; color: #fff; border-width: 0px; font-weight: bold; float:right; ">Add More Files</button>

          </div>


        <button type="submit" name="ticket_submit" value="submit" style="display: block;     padding: 15px 40px; margin-top: 20px; background-color: #20b368; color: #fff; border-width: 0px; font-size: 17px; font-weight: bold;">SUBMIT</button>
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
