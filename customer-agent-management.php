<?php
/*
Plugin Name: Customer Agent Management
Plugin URI: http://webencoder.net/
Description: This is simple registration form for customer agent management.
Version: 1.0
Author: Webencoder
Author URI: http://webencoder.net/
*/

include 'user_end.php';
include 'admin_end.php';

//Create Trip Table When Plugins is activated

//action hook for plugin activation
register_activation_hook( __FILE__, 'cam_create_trip_location_table' );

//callback function
function cam_create_trip_location_table(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'cam_trip_location';
  	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
  		$sql = "CREATE TABLE $table_name (
  		  id int(11) NOT NULL AUTO_INCREMENT,
  		  name varchar(80) DEFAULT NULL,
  		  PRIMARY KEY id (id)
  		);";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
  	}

    $table_name = $wpdb->prefix . 'cam_orders';
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
      $sql = "CREATE TABLE $table_name (
  		  id int(11) NOT NULL AUTO_INCREMENT,
  		  user_id int(11) DEFAULT NULL,
        order_type varchar(50) DEFAULT NULL,
        visa_number int(11) DEFAULT NULL,
        no_of_person int(11) DEFAULT NULL,
        trip_location_id int(11) DEFAULT NULL,
        no_of_tickets int(11) DEFAULT NULL,
        direction varchar(50) DEFAULT NULL,
        ticket_date varchar(50) DEFAULT NULL,
        other_text varchar(80) DEFAULT NULL,
        status varchar(50) DEFAULT NULL,
  		  PRIMARY KEY id (id)
  		);";
      require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
      dbDelta( $sql );
    }

    $table_name = $wpdb->prefix . 'cam_files';
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
      $sql = "CREATE TABLE $table_name (
  		  id int(11) NOT NULL AUTO_INCREMENT,
  		  order_id int(11) DEFAULT NULL,
        url varchar(191) DEFAULT NULL,
  		  PRIMARY KEY id (id)
  		);";
      require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
      dbDelta( $sql );
    }

}






?>
