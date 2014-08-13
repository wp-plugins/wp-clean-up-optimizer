<?php
/*
Plugin Name: Wp Cleanup Optimizer
Plugin URI: http://tech-banker.com
Description: It allows you to optimize your WordPress database without phpMyAdmin.
Author: Tech Banker
Version: 1.1
Author URI: http://tech-banker.com
*/
/////////////////////////////////////  Define  Wp Cleanup Optimizer  Constants  ////////////////////////////////////////

if (!defined("CLEANUP_BK_PLUGIN_DIR")) define("CLEANUP_BK_PLUGIN_DIR",  plugin_dir_path( __FILE__ ));
if (!defined("CLEANUP_BK_PLUGIN_DIRNAME")) define("CLEANUP_BK_PLUGIN_DIRNAME", plugin_basename(dirname(__FILE__)));
if (!defined("cleanup_optimizer")) define("cleanup_optimizer", "cleanup_optimizer");


/////////////////////////////////////  Call CSS & JS Scripts - Front End ////////////////////////////////////////

function admin_panel_js_calls()
{
	wp_enqueue_script("jquery");
	wp_enqueue_script("jquery.dataTables.min.js", plugins_url("/assets/js/jquery.dataTables.min.js",__FILE__));
}

function admin_panel_css_calls()
{
	wp_enqueue_style("wpcpb-stylesheet.css", plugins_url("/assets/css/wp-stylesheet.css",__FILE__));
}
/////////////////////////////////////  Include Menus on Dashboard ////////////////////////////////////////
function create_global_menus_for_cleanup_bank()
{
	include_once CLEANUP_BK_PLUGIN_DIR . "/lib/wp-include-menus.php";
}

///////////////////////////////////// Register Ajax Based Functions /////////////////////////////////////

if (isset($_REQUEST["action"])) 
{
	switch ($_REQUEST["action"]) 
	{
		case "cleanup_library":
			add_action("admin_init", "cleanup_library");
			function cleanup_library()
			{	
				global $wpdb,$current_user,$user_role_permission;
				$role = $wpdb->prefix . "capabilities";
				$current_user->role = array_keys($current_user->$role);
				$role = $current_user->role[0];
				include_once CLEANUP_BK_PLUGIN_DIR . "/lib/wp-cleanup-class.php";
				die();
			}
			break;
	}
}
function plugin_load_textdomain_optimizer()
{
	if(function_exists( "load_plugin_textdomain" ))
	{
		load_plugin_textdomain(cleanup_optimizer, false, CLEANUP_BK_PLUGIN_DIRNAME ."/languages");
	}
}

///////////////////////////////////  Call Hooks   /////////////////////////////////////////////////////
add_action("plugins_loaded", "plugin_load_textdomain_optimizer");
add_action("admin_init", "admin_panel_css_calls");
add_action("admin_init", "admin_panel_js_calls");
add_action("admin_menu", "create_global_menus_for_cleanup_bank");
?>