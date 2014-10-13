<?php
//--------------------------------------------------------------------------------------------------------------//
// CODE FOR CREATING MENUS
//---------------------------------------------------------------------------------------------------------------//
global $wpdb,$current_user;
$cpo_role = $wpdb->prefix . "capabilities";
$current_user->role = array_keys($current_user->$cpo_role);
$cpo_role = $current_user->role[0];

switch($cpo_role)
{
	case "administrator":
		add_menu_page("WP Clean Up Optimizer", "WP Clean Up Optimizer", "read", "wp_optimizer", "",plugins_url("/assets/images/icons/icon.png" , dirname(__FILE__)));
		add_submenu_page("wp_optimizer", "WP Data Optimizer","WP Data Optimizer", "read", "wp_optimizer",  "wp_optimizer");
		add_submenu_page("wp_optimizer", "WP DB Optimizer", "WP DB Optimizer", "read", "db_optimizer",  "db_optimizer");
		add_submenu_page("wp_optimizer", "System Status", "System Status", "read", "cpo_system_status",  "cpo_system_status");
		break;
	case "editor":
		add_menu_page("WP Clean Up Optimizer", "WP Clean Up Optimizer", "read", "cleanup_optimizer", "", plugins_url("/assets/images/icons/icon.png" , dirname(__FILE__)));
		add_submenu_page("wp_optimizer", "WP Data Optimizer","WP Data Optimizer", "read", "wp_optimizer",  "wp_optimizer");
		add_submenu_page("wp_optimizer", "WP DB Optimizer", "WP DB Optimizer", "read", "db_optimizer",  "db_optimizer");
		add_submenu_page("wp_optimizer", "System Status", "System Status", "read", "cpo_system_status",  "cpo_system_status");
		break;
	case "author":
		add_menu_page("WP Clean Up Optimizer", "WP Clean Up Optimizer", "read", "cleanup_optimizer", "", plugins_url("/assets/images/icons/icon.png" , dirname(__FILE__)));
		add_submenu_page("wp_optimizer", "WP Data Optimizer","WP Data Optimizer", "read", "wp_optimizer",  "wp_optimizer");
		add_submenu_page("wp_optimizer", "WP DB Optimizer", "WP DB Optimizer", "read", "db_optimizer",  "db_optimizer");
		add_submenu_page("wp_optimizer", "System Status", "System Status", "read", "cpo_system_status",  "cpo_system_status");
		break;
}

//--------------------------------------------------------------------------------------------------------------//
// CODE FOR CREATING PAGES
//---------------------------------------------------------------------------------------------------------------//

function wp_optimizer()
{
	include_once CLEANUP_BK_PLUGIN_DIR."lib/nav-menus.php";
	global $wpdb,$current_user,$user_role_permission;
	$cpo_role = $wpdb->prefix . "capabilities";
	$current_user->role = array_keys($current_user->$cpo_role);
	$cpo_role = $current_user->role[0];
	include_once CLEANUP_BK_PLUGIN_DIR . "/views/wp-optimizer.php";
}
function db_optimizer()
{
	include_once CLEANUP_BK_PLUGIN_DIR."lib/nav-menus.php";
	global $wpdb,$current_user,$user_role_permission;
	$cpo_role = $wpdb->prefix . "capabilities";
	$current_user->role = array_keys($current_user->$cpo_role);
	$cpo_role = $current_user->role[0];
	include_once CLEANUP_BK_PLUGIN_DIR . "/views/db-optimizer.php";
}
function cpo_system_status()
{
	include_once CLEANUP_BK_PLUGIN_DIR."lib/nav-menus.php";
	global $wpdb,$current_user,$user_role_permission;
	$cpo_role = $wpdb->prefix . "capabilities";
	$current_user->role = array_keys($current_user->$cpo_role);
	$cpo_role = $current_user->role[0];
	include_once CLEANUP_BK_PLUGIN_DIR . "/views/wp-cleanup-optimizer-system-status.php";
}
?>
