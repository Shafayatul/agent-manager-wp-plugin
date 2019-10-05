<?php
//Create new order function
function cam_user_sign_in(){
	ob_start();
	$message = '';
	if ( isset( $_POST['order_submit'])) {
		global $wpdb;
	    $user_password  = esc_attr($_POST["user_password"]);
	    $user_email     = esc_attr($_POST["user_email"]);
	    $user_login     = $user_email;

	    $creds = array();
	    $creds['user_login'] = $user_login;
	    $creds['user_password'] = $user_password;
	    $creds['remember'] = true;

	    $user = wp_signon( $creds, false );
	    $userID = $user->ID;
	    wp_set_current_user( $userID);
	    wp_set_auth_cookie( $userID, true, false );

	    if(is_user_logged_in()){
	      wp_redirect( site_url("/agent-profile/") );
	      exit;
	    }else{
	      $message = '<div data-alert="" class="alert-box alert alert-show">
	      <span>User email or password not correct. Please try again.</span>
	        <a class="close">×</a>
	      </div>';         
	    }
	    
	}



	echo $message;
	echo '
	<form action="" method="post" enctype="multipart/form-data" style="width: 100%; margin: 20px auto; padding: 20px;">

	<div class="visa_order_form" style="overflow: hidden; width: 100%; margin-top : 20px;">
	<label for="user_email" style="display: block; margin-bottom: 5px; font-size: 20px; font-weight: 400;">EMAIL:</label>
	<input type="text" name="user_email" value="" style="width: 100%; display: block; height: 60px; background-color: #fff; border: 1px solid #ececec; box-shadow: 0px 10px 10px -10px rgba(0,0,0,0.4); margin-bottom : 40px; padding: 10px; -webkit-box-sizing: border-box;">
	</div>


	<div class="visa_order_form" style="overflow: hidden; width: 100%; margin-top : 20px;">
	<label for="user_password" style="display: block; margin-bottom: 5px; font-size: 20px; font-weight: 400;">PASSWORD</label>
	<input type="password" name="user_password" value="" style="width: 100%; display: block; height: 60px; background-color: #fff; border: 1px solid #ececec; box-shadow: 0px 10px 10px -10px rgba(0,0,0,0.4); margin-bottom : 40px; padding: 10px; -webkit-box-sizing: border-box;">
	</div>


	<button type="submit" name="order_submit" value="submit" style="display: block;     padding: 15px 40px; margin-top: 20px; background-color: #20b368; color: #fff; border-width: 0px;">Submit</button>
	</form>
	';


	return ob_get_clean();
}

//Shortcodes create_new_orders
add_shortcode('cam-user-signin', 'cam_user_sign_in');