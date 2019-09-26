<?php
ob_start();
//Calling custom js file
function enqueue_related_pages_scripts_and_styles(){
        // wp_enqueue_style('related-styles', plugins_url('/css/bootstrap.min.css', __FILE__));
        wp_enqueue_script('releated-script', plugins_url( '/js/custom.js' , __FILE__ ), array('jquery','jquery-ui-droppable','jquery-ui-draggable', 'jquery-ui-sortable'));
    }
add_action('wp_enqueue_scripts','enqueue_related_pages_scripts_and_styles');

//Create new order function
function create_new_order(){
  ob_start();

  global $wpdb;
  $table_name      = $wpdb->prefix . 'trip_location';
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
        <label for="no_of_requested_visas" style="display: block; margin-bottom: 5px;">Number Of Requested Visas</label>
        <input type="number" name="no_of_requested_visas" value="" style="width: 400px; padding: 10px;">
      </div>

      <div class="tourism_trip" style="display:none;">
        <label for="no_of_persons" style="display: block; margin-bottom: 5px;">Number Of Persons</label>
        <input type="number" name="no_of_persons" value="" style="width: 400px; padding: 10px;">

        <label for="trip_location" style="display: block; margin-bottom: 5px;">Select Trip Location</label>
        <select name="trip_location" id="trip_location" style="width: 400px; height: 40px;">
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
        <input type="number" name="other_text" value="" style="width: 400px; padding: 10px;">
      </div>


      <label for="passport" style="display: block; margin-top: 20px; margin-bottom: 5px;">Upload Passport</label>
      <input name="file[]" type="file" id="passport"/>

      <button class="add_more">Add More Files</button>


      <input name="status" type="hidden" value="pending"/>

      <button type="submit" name="order_type_submit" value="submit" style="padding: 10px; margin-top: 20px; background-color: #20b368; color: #fff; border-width: 0px;">Submit</button>
    <form>
  ';

}

//Shortcodes create_new_orders
add_shortcode('create_new_orders', 'create_new_order');

//Visa Order Form
function visaOrderForm(){
  ob_start();

  return ob_get_clean();
}

?>
