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
		add_menu_page("WP Cleanup Opt", __("WP Cleanup Optimizer", cleanup_optimizer), "read", "wp_optimizer", "",plugins_url("/assets/images/icon.png" , dirname(__FILE__)));
		add_submenu_page("wp_optimizer", "WP Optimizer", __("WP Optimizer", cleanup_optimizer), "read", "wp_optimizer",  "wp_optimizer");
		add_submenu_page("wp_optimizer", "Database Optimizer", __("Database Optimizer", cleanup_optimizer), "read", "db_optimizer",  "db_optimizer");
		break;
	case "editor":
		add_menu_page("WP Cleanup Bank", __("WP Cleanup Bank", cleanup_optimizer), "read", "cleanup_optimizer", "", plugins_url("/assets/images/icon.png" , dirname(__FILE__)));
		add_submenu_page("cleanup_optimizer", "Dashboard", __("Dashboard", cleanup_optimizer), "read", "cleanup_optimizer",  "cleanup_optimizer");
		break;
	case "author":
		add_menu_page("WP Cleanup Bank", __("WP Cleanup Bank", cleanup_optimizer), "read", "cleanup_optimizer", "", plugins_url("/assets/images/icon.png" , dirname(__FILE__)));
		add_submenu_page("cleanup_optimizer", "Dashboard", __("Dashboard", cleanup_optimizer), "read", "cleanup_optimizer",  "cleanup_optimizer");
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
