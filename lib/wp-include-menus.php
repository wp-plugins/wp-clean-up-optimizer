<?php
//--------------------------------------------------------------------------------------------------------------//
// CODE FOR CREATING MENUS
//---------------------------------------------------------------------------------------------------------------//
global $wpdb,$current_user;
$role = $wpdb->prefix . "capabilities";
$current_user->role = array_keys($current_user->$role);
$role = $current_user->role[0];

switch($role)
{
	case "administrator":
		add_menu_page("WP Cleanup Optimizer", "WP Cleanup Optimizer", "read", "wp_optimizer", "",plugins_url("/assets/images/icon.png" , dirname(__FILE__)));
		add_submenu_page("wp_optimizer", "WP Optimizer","WP Optimizer", "read", "wp_optimizer",  "wp_optimizer");
		add_submenu_page("wp_optimizer", "Database Optimizer", "Database Optimizer", "read", "db_optimizer",  "db_optimizer");
		break;
	case "editor":
		add_menu_page("WP Cleanup Optimizer", "WP Cleanup Optimizer", "read", "cleanup_optimizer", "", plugins_url("/assets/images/icon.png" , dirname(__FILE__)));
		add_submenu_page("cleanup_optimizer", "Database Optimizer", "Database Optimizer", "read", "cleanup_optimizer",  "cleanup_optimizer");
		break;
	case "author":
		add_menu_page("WP Cleanup Optimizer", "WP Cleanup Optimizer", "read", "cleanup_optimizer", "", plugins_url("/assets/images/icon.png" , dirname(__FILE__)));
		add_submenu_page("cleanup_optimizer", "Database Optimizer", "Database Optimizer", "read", "cleanup_optimizer",  "cleanup_optimizer");
		break;
}

//--------------------------------------------------------------------------------------------------------------//
// CODE FOR CREATING PAGES
//---------------------------------------------------------------------------------------------------------------//

function wp_optimizer()
{
	global $wpdb,$current_user,$user_role_permission;
	$role = $wpdb->prefix . "capabilities";
	$current_user->role = array_keys($current_user->$role);
	$role = $current_user->role[0];
	include_once CLEANUP_BK_PLUGIN_DIR . "/views/wp-optimizer.php";
}
function db_optimizer()
{
	global $wpdb,$current_user,$user_role_permission;
	$role = $wpdb->prefix . "capabilities";
	$current_user->role = array_keys($current_user->$role);
	$role = $current_user->role[0];
	include_once CLEANUP_BK_PLUGIN_DIR . "/views/db-optimizer.php";
}
?>
