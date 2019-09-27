<?php
ob_start();
// WP_List_Table is not loaded automatically so we need to load it in our application
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
include('include/order-list.php');
include('include/trip-list.php');
include('include/ticket-list.php');
//Adding menu
add_action('admin_menu', 'cam_main_menu');

function cam_main_menu(){
    add_menu_page( 'Custom Agent Management Main Menu', 'Custom Agent Management', 'manage_options', 'cam-custom-agent-management-main-menu', 'mainCustomerAgentFunction' );
	add_submenu_page("custom-agent-management-main-menu", "Add Agent", "Add Agent", "manage_options", "cam-add-agent", "addAgentFunction");
	add_submenu_page("custom-agent-management-main-menu", "Agent List", "Agent List", "manage_options", "cam-agent-list", "agentListFunction");
	add_submenu_page("custom-agent-management-main-menu", "Order List", "Order List", "manage_options", "cam-order-list", "camOrderListFunction");
    add_submenu_page("custom-agent-management-main-menu", "Order List", "Order List", "manage_options", "cam-order-list", "camOrderListFunction");

    // Trip
    add_menu_page( 'Trip', 'Trip', 'manage_options', 'cam-trip', 'tripListFunction' );
    add_submenu_page("trip", "Add Trip", "Add Trip", "manage_options", "cam-add-trip", "addTripFunction");

    // Ticket
    add_menu_page( 'Tickets', 'Tickets', 'manage_options', 'cam-ticket', 'ticketListFunction' );
}



//Function Custom Agent Management Main Page
function mainCustomerAgentFunction(){
  echo '
    <div class="wrap">
      <h2>Add Trip</h2>
      <div class="welcome-panel"  id="welcome-panel">
        <h2>How to use: </h2><br>
        <h3>Use of shortcode: </h3>
        There are two shortcodes available for use.
        <ul>
          <li>
            <p><b>1. Offer form: </b></p>
            <p>
              This shortcode is used for the order form. Copy and paste <b>[cam-create-new-order]</b> where you want to use the offer form.
            </p>
          </li>
          <li>
            <p><b>2. Ticket form: </b></p>
            <p>
              For showing ticket form, one has to use [cam-create-new-ticket] shortcode.
            </p>
          </li>
          
        </ul>
      </div>
    ';
}


//Function for Add Agent
function addAgentFunction(){
  global $wpdb;
  //Agent data submit to SQLiteDatabase
  if ( isset( $_POST['agent_submit'] ) ) {

    $name       = $_POST['name'];
    $email      = $_POST['email'];
    $phone      = $_POST['phone'];
    $country    = $_POST['country'];
    $password   = $_POST['password'];
    $address    = $_POST['address'];

    $wallet_balance               = $_POST['wallet_balance'];
    $issued_visas                 = $_POST['issued_visas'];
    $additional_services_balance  = $_POST['additional_services_balance'];

    $user_id    = wp_create_user( $name, $password, $email);

    if ($user_id != null) {
      add_user_meta( $user_id, 'user_type', 'agent');
      add_user_meta( $user_id, 'phone', $phone);
      add_user_meta( $user_id, 'country', $country);
      add_user_meta( $user_id, 'address', $address);
      add_user_meta( $user_id, 'wallet_balance', $wallet_balance);
      add_user_meta( $user_id, 'issued_visas', $issued_visas);
      add_user_meta( $user_id, 'additional_services_balance', $additional_services_balance);
      echo "Agent Added Successfully";
    }else {
      echo "Error while adding agent.";
    }
  }

  echo '
    <div class="wrap">
      <h2>Add Agent</h2>
      <div class="welcome-panel"  id="welcome-panel">
        <form action="" method="post" style="margin-bottom: 20px; padding: 20px;">
          <div class="row" style="display : block; overflow: hidden; width: 100%; margin-bottom: 20px;">
        	 <div class="left" style="width:50%; float:left">
            <label for="agent-name" style="display: block; margin-bottom: 5px;">Agent Name : </label>
            <input type="text" name="name" id="agent-name" value="" style="width: 400px; padding: 10px;"/>
          </div>
        	 <div class="right" style="width:50%; float:left">
            <label for="agent-email" style="display: block; margin-bottom: 5px;">Agent Email : </label>
            <input type="text" name="email" id="agent-email" value="" style="width: 400px; padding: 10px;"/>
          </div>
          </div>
          <div class="row" style="display : block; overflow: hidden; width: 100%; margin-bottom: 20px;">
            <div class="left" style="width:50%; float:left">
            <label for="agent-phone" style="display: block; margin-bottom: 5px;">Agent Phone : </label>
            <input type="text" name="phone" id="agent-phone" value="" style="width: 400px; padding: 10px;"/>
          </div>
        	  <div class="right" style="width:50%; float:left">
            <label for="country" style="display: block; margin-bottom: 5px;">Country</label>
            <select id="country" name="country" style="width: 400px; height: 40px;">
                <option value="Afghanistan">Afghanistan</option>
                <option value="Åland Islands">Åland Islands</option>
                <option value="Albania">Albania</option>
                <option value="Algeria">Algeria</option>
                <option value="American Samoa">American Samoa</option>
                <option value="Andorra">Andorra</option>
                <option value="Angola">Angola</option>
                <option value="Anguilla">Anguilla</option>
                <option value="Antarctica">Antarctica</option>
                <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                <option value="Argentina">Argentina</option>
                <option value="Armenia">Armenia</option>
                <option value="Aruba">Aruba</option>
                <option value="Australia">Australia</option>
                <option value="Austria">Austria</option>
                <option value="Azerbaijan">Azerbaijan</option>
                <option value="Bahamas">Bahamas</option>
                <option value="Bahrain">Bahrain</option>
                <option value="Bangladesh">Bangladesh</option>
                <option value="Barbados">Barbados</option>
                <option value="Belarus">Belarus</option>
                <option value="Belgium">Belgium</option>
                <option value="Belize">Belize</option>
                <option value="Benin">Benin</option>
                <option value="Bermuda">Bermuda</option>
                <option value="Bhutan">Bhutan</option>
                <option value="Bolivia">Bolivia</option>
                <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                <option value="Botswana">Botswana</option>
                <option value="Bouvet Island">Bouvet Island</option>
                <option value="Brazil">Brazil</option>
                <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                <option value="Brunei Darussalam">Brunei Darussalam</option>
                <option value="Bulgaria">Bulgaria</option>
                <option value="Burkina Faso">Burkina Faso</option>
                <option value="Burundi">Burundi</option>
                <option value="Cambodia">Cambodia</option>
                <option value="Cameroon">Cameroon</option>
                <option value="Canada">Canada</option>
                <option value="Cape Verde">Cape Verde</option>
                <option value="Cayman Islands">Cayman Islands</option>
                <option value="Central African Republic">Central African Republic</option>
                <option value="Chad">Chad</option>
                <option value="Chile">Chile</option>
                <option value="China">China</option>
                <option value="Christmas Island">Christmas Island</option>
                <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                <option value="Colombia">Colombia</option>
                <option value="Comoros">Comoros</option>
                <option value="Congo">Congo</option>
                <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
                <option value="Cook Islands">Cook Islands</option>
                <option value="Costa Rica">Costa Rica</option>
                <option value="Cote D ivoire">Cote D ivoire</option>
                <option value="Croatia">Croatia</option>
                <option value="Cuba">Cuba</option>
                <option value="Cyprus">Cyprus</option>
                <option value="Czech Republic">Czech Republic</option>
                <option value="Denmark">Denmark</option>
                <option value="Djibouti">Djibouti</option>
                <option value="Dominica">Dominica</option>
                <option value="Dominican Republic">Dominican Republic</option>
                <option value="Ecuador">Ecuador</option>
                <option value="Egypt">Egypt</option>
                <option value="El Salvador">El Salvador</option>
                <option value="Equatorial Guinea">Equatorial Guinea</option>
                <option value="Eritrea">Eritrea</option>
                <option value="Estonia">Estonia</option>
                <option value="Ethiopia">Ethiopia</option>
                <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                <option value="Faroe Islands">Faroe Islands</option>
                <option value="Fiji">Fiji</option>
                <option value="Finland">Finland</option>
                <option value="France">France</option>
                <option value="French Guiana">French Guiana</option>
                <option value="French Polynesia">French Polynesia</option>
                <option value="French Southern Territories">French Southern Territories</option>
                <option value="Gabon">Gabon</option>
                <option value="Gambia">Gambia</option>
                <option value="Georgia">Georgia</option>
                <option value="Germany">Germany</option>
                <option value="Ghana">Ghana</option>
                <option value="Gibraltar">Gibraltar</option>
                <option value="Greece">Greece</option>
                <option value="Greenland">Greenland</option>
                <option value="Grenada">Grenada</option>
                <option value="Guadeloupe">Guadeloupe</option>
                <option value="Guam">Guam</option>
                <option value="Guatemala">Guatemala</option>
                <option value="Guernsey">Guernsey</option>
                <option value="Guinea">Guinea</option>
                <option value="Guinea-bissau">Guinea-bissau</option>
                <option value="Guyana">Guyana</option>
                <option value="Haiti">Haiti</option>
                <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                <option value="Honduras">Honduras</option>
                <option value="Hong Kong">Hong Kong</option>
                <option value="Hungary">Hungary</option>
                <option value="Iceland">Iceland</option>
                <option value="India">India</option>
                <option value="Indonesia">Indonesia</option>
                <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                <option value="Iraq">Iraq</option>
                <option value="Ireland">Ireland</option>
                <option value="Isle of Man">Isle of Man</option>
                <option value="Israel">Israel</option>
                <option value="Italy">Italy</option>
                <option value="Jamaica">Jamaica</option>
                <option value="Japan">Japan</option>
                <option value="Jersey">Jersey</option>
                <option value="Jordan">Jordan</option>
                <option value="Kazakhstan">Kazakhstan</option>
                <option value="Kenya">Kenya</option>
                <option value="Kiribati">Kiribati</option>
                <option value="Korea, Democratic Peoples Republic of">Korea, Democratic Peoples Republic of</option>
                <option value="Korea, Republic of">Korea, Republic of</option>
                <option value="Kuwait">Kuwait</option>
                <option value="Kyrgyzstan">Kyrgyzstan</option>
                <option value="Lao Peoples Democratic Republic">Lao Peoples Democratic Republic</option>
                <option value="Latvia">Latvia</option>
                <option value="Lebanon">Lebanon</option>
                <option value="Lesotho">Lesotho</option>
                <option value="Liberia">Liberia</option>
                <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                <option value="Liechtenstein">Liechtenstein</option>
                <option value="Lithuania">Lithuania</option>
                <option value="Luxembourg">Luxembourg</option>
                <option value="Macao">Macao</option>
                <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
                <option value="Madagascar">Madagascar</option>
                <option value="Malawi">Malawi</option>
                <option value="Malaysia">Malaysia</option>
                <option value="Maldives">Maldives</option>
                <option value="Mali">Mali</option>
                <option value="Malta">Malta</option>
                <option value="Marshall Islands">Marshall Islands</option>
                <option value="Martinique">Martinique</option>
                <option value="Mauritania">Mauritania</option>
                <option value="Mauritius">Mauritius</option>
                <option value="Mayotte">Mayotte</option>
                <option value="Mexico">Mexico</option>
                <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                <option value="Moldova, Republic of">Moldova, Republic of</option>
                <option value="Monaco">Monaco</option>
                <option value="Mongolia">Mongolia</option>
                <option value="Montenegro">Montenegro</option>
                <option value="Montserrat">Montserrat</option>
                <option value="Morocco">Morocco</option>
                <option value="Mozambique">Mozambique</option>
                <option value="Myanmar">Myanmar</option>
                <option value="Namibia">Namibia</option>
                <option value="Nauru">Nauru</option>
                <option value="Nepal">Nepal</option>
                <option value="Netherlands">Netherlands</option>
                <option value="Netherlands Antilles">Netherlands Antilles</option>
                <option value="New Caledonia">New Caledonia</option>
                <option value="New Zealand">New Zealand</option>
                <option value="Nicaragua">Nicaragua</option>
                <option value="Niger">Niger</option>
                <option value="Nigeria">Nigeria</option>
                <option value="Niue">Niue</option>
                <option value="Norfolk Island">Norfolk Island</option>
                <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                <option value="Norway">Norway</option>
                <option value="Oman">Oman</option>
                <option value="Pakistan">Pakistan</option>
                <option value="Palau">Palau</option>
                <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                <option value="Panama">Panama</option>
                <option value="Papua New Guinea">Papua New Guinea</option>
                <option value="Paraguay">Paraguay</option>
                <option value="Peru">Peru</option>
                <option value="Philippines">Philippines</option>
                <option value="Pitcairn">Pitcairn</option>
                <option value="Poland">Poland</option>
                <option value="Portugal">Portugal</option>
                <option value="Puerto Rico">Puerto Rico</option>
                <option value="Qatar">Qatar</option>
                <option value="Reunion">Reunion</option>
                <option value="Romania">Romania</option>
                <option value="Russian Federation">Russian Federation</option>
                <option value="Rwanda">Rwanda</option>
                <option value="Saint Helena">Saint Helena</option>
                <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                <option value="Saint Lucia">Saint Lucia</option>
                <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                <option value="Samoa">Samoa</option>
                <option value="San Marino">San Marino</option>
                <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                <option value="Saudi Arabia">Saudi Arabia</option>
                <option value="Senegal">Senegal</option>
                <option value="Serbia">Serbia</option>
                <option value="Seychelles">Seychelles</option>
                <option value="Sierra Leone">Sierra Leone</option>
                <option value="Singapore">Singapore</option>
                <option value="Slovakia">Slovakia</option>
                <option value="Slovenia">Slovenia</option>
                <option value="Solomon Islands">Solomon Islands</option>
                <option value="Somalia">Somalia</option>
                <option value="South Africa">South Africa</option>
                <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
                <option value="Spain">Spain</option>
                <option value="Sri Lanka">Sri Lanka</option>
                <option value="Sudan">Sudan</option>
                <option value="Suriname">Suriname</option>
                <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                <option value="Swaziland">Swaziland</option>
                <option value="Sweden">Sweden</option>
                <option value="Switzerland">Switzerland</option>
                <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                <option value="Taiwan, Province of China">Taiwan, Province of China</option>
                <option value="Tajikistan">Tajikistan</option>
                <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                <option value="Thailand">Thailand</option>
                <option value="Timor-leste">Timor-leste</option>
                <option value="Togo">Togo</option>
                <option value="Tokelau">Tokelau</option>
                <option value="Tonga">Tonga</option>
                <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                <option value="Tunisia">Tunisia</option>
                <option value="Turkey">Turkey</option>
                <option value="Turkmenistan">Turkmenistan</option>
                <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                <option value="Tuvalu">Tuvalu</option>
                <option value="Uganda">Uganda</option>
                <option value="Ukraine">Ukraine</option>
                <option value="United Arab Emirates">United Arab Emirates</option>
                <option value="United Kingdom">United Kingdom</option>
                <option value="United States">United States</option>
                <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                <option value="Uruguay">Uruguay</option>
                <option value="Uzbekistan">Uzbekistan</option>
                <option value="Vanuatu">Vanuatu</option>
                <option value="Venezuela">Venezuela</option>
                <option value="Viet Nam">Viet Nam</option>
                <option value="Virgin Islands, British">Virgin Islands, British</option>
                <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                <option value="Wallis and Futuna">Wallis and Futuna</option>
                <option value="Western Sahara">Western Sahara</option>
                <option value="Yemen">Yemen</option>
                <option value="Zambia">Zambia</option>
                <option value="Zimbabwe">Zimbabwe</option>
              </select>
          </div>
          </div>
          <div class="row" style="display : block; overflow: hidden; width: 100%;">
            <div class="left" style="width:50%; float:left">
              <label for="agent-password" style="display: block; margin-bottom: 5px;">Agent Password : </label>
              <input type="text" name="password" id="agent-password" value="" style="width: 400px; padding: 10px;"/>
            </div>
            <div class="right" style="width:50%; float:left">
             <label for="agent-address" style="display: block; margin-bottom: 5px;">Agent Address : </label>
             <input type="text" name="address" id="agent-address" value="" style="width: 400px; padding: 10px;"/>
            </div>
          </div>
          <div class="row" style="display : block; overflow: hidden; width: 100%;">
            <div class="left" style="width:50%; float:left">
              <label for="wallet_balance" style="display: block; margin-bottom: 5px;">Wallet Balance : </label>
              <input type="text" name="wallet_balance" id="wallet_balance" value="" style="width: 400px; padding: 10px;"/>
            </div>
            <div class="right" style="width:50%; float:left">
               <label for="issued_visas" style="display: block; margin-bottom: 5px;">Issued Visas : </label>
              <select id="issued_visas" name="issued_visas" style="width: 400px; height: 40px;">
                <option value="yes">Yes</option>
                <option value="no">No</option>
              </select>
            </div>
          </div>
          <div class="row" style="display : block; overflow: hidden; width: 100%;">
            <div class="left" style="width:50%; float:left">
              <label for="additional_services_balance" style="display: block; margin-bottom: 5px;">Additional Services Balance : </label>
              <input type="text" name="additional_services_balance" id="additional_services_balance" value="" style="width: 400px; padding: 10px;"/>
            </div>
          </div>
          <button type="submit" name="agent_submit" value="submit" style="width: 100px; height: 50px; padding: 10px; margin-top: 20px; background-color: #20b368; color: #fff; border-width: 0px;">Submit</button>
        </form>
      </div>
    </div>
  ';
}


//Function for Agent List
function agentListFunction(){
  $display_agent_table = new Agent_List_Table();
			$display_agent_table->prepare_items();
			?>
				<div class="wrap">
					<div id="icon-users" class="icon32"></div>
					<h2>All Agents</h2><span>**List of all agents</span>
					<form method="post">
						<input type="hidden" name="page" value="example_list_table" />
						<?php //$display_agent_table->search_box('search', 'search_id'); ?>
					</form>
					<?php $display_agent_table->display(); ?>
				</div>
			<?php
}


//Create a new table class that will extend the WP_List_Table
class Agent_List_Table extends WP_List_Table {
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
    'NAME'     => 'NAME',
  	'EMAIL'    => 'EMAIL',
  	'PHONE' 	 => 'PHONE',
  	'ADDRESS'  => 'ADDRESS',
  	'COUNTRY'  => 'COUNTRY',
  	'ACTION'   => 'ACTION'
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
					'NAME'      => $user->user_login,
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
				case 'NAME':
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

//Function for Main Trip Menu
function mainTripFunction(){
  echo '
    <div class="wrap">
      <h2>Trip</h2>
      <div class="welcome-panel"  id="welcome-panel">
        <h2>How to use: </h2><br>
        <ul>
          <li>
            <p><b>About Trip: </b></p>
            <p>
              It is being used in offer form.
            </p>
          </li>
        </ul>
      </div>
	';
}


//Function for adding trip
function addTripFunction(){

  global $wpdb;

  //Trip Location data submit to SQLiteDatabase
  if ( isset( $_POST['trip_submit'] ) ) {

    $name       = $_POST['name'];

    // insert dsta to database except photo
		$table_name = $wpdb->prefix . 'cam_trip_location'; //to get the table name

    $wpdb->insert($table_name, array(
		   "name" => $name,
		));

		// last inserted id
		$lastid = $wpdb->insert_id;
    if ($lastid != null) {
      echo "Trip Location Added Successfully";
    }
  }



  echo '
  <div class="wrap">
    <h2>Add Trip</h2>
    <div class="welcome-panel" id="welcome-panel">
      <form action="" method="post" style="margin-bottom: 20px; padding: 20px;">
        <div class="row" style="display : block; overflow: hidden; width: 100%; margin-bottom: 20px;">
          <div class="left" style="width:50%; float:left">
            <label for="agent-name" style="display: block; margin-bottom: 5px;">Trip Location : </label>
            <input type="text" name="name" id="agent-name" value="" style="width: 400px; padding: 10px;" />
          </div>
        </div>

          <button type="submit" name="trip_submit" value="submit" style="width: 100px; height: 50px; padding: 10px; margin-top: 20px; background-color: #20b368; color: #fff; border-width: 0px;">Submit</button>
      </form>
    </div>
  </div>
  ';
}
?>