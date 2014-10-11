<?php
/*
Plugin Name: Wp Cleanup Optimizer
Plugin URI: http://tech-banker.com
Description: It allows you to optimize your WordPress database without phpMyAdmin.
Author: Tech Banker
Version: 1.2
Author URI: http://tech-banker.com
*/

////////////////////////////////////  Define  Wp Cleanup Optimizer  Constants  /////////////////////////////

if (!defined("CLEANUP_BK_PLUGIN_DIR")) define("CLEANUP_BK_PLUGIN_DIR",  plugin_dir_path( __FILE__ ));
if (!defined("CLEANUP_BK_PLUGIN_DIRNAME")) define("CLEANUP_BK_PLUGIN_DIRNAME", plugin_basename(dirname(__FILE__)));
if (!defined("cleanup_optimizer")) define("cleanup_optimizer", "cleanup_optimizer");

/////////////////////////////////////  Call CSS & JS Scripts - Front End ///////////////////////////////////
function admin_panel_js_calls_for_cleanup_optimizer()
{
	wp_enqueue_script("jquery");
	wp_enqueue_script("jquery.dataTables.min.js", plugins_url("/assets/js/jquery.dataTables.min.js",__FILE__));
	wp_enqueue_script("jquery.validate.min.js", plugins_url("/assets/js/jquery.validate.min.js",__FILE__));
}
function admin_panel_css_calls_for_cleanup_optimizer()
{
	wp_enqueue_style("framework.css", plugins_url("/assets/css/framework.css",__FILE__));
	wp_enqueue_style("wp-cleanup-optimizer.css", plugins_url("/assets/css/wp-cleanup-optimizer.css",__FILE__));
}
/////////////////////////////////////  Include Menus on Dashboard //////////////////////////////////////////

function create_global_menus_for_cleanup_optimizer()
{
	include_once CLEANUP_BK_PLUGIN_DIR . "/lib/include-menus.php";
}
/////////////////////////////////////  Call Install Script on Plugin Activation ////////////////////////////

function plugin_install_script_for_cleanup_optimizer()
{
	include_once CLEANUP_BK_PLUGIN_DIR. "/lib/install-script.php";
}
/////////////////////////////////////  Functions for Returing Table Names  /////////////////////////////////

function wp_scheduler_tbl()
{
	global $wpdb;
	return $wpdb->prefix . "cpo_wp_scheduler";
}
function db_scheduler_tbl()
{
	global $wpdb;
	return $wpdb->prefix . "cpo_db_optimizer";
}

/////////////////////////////////////// Register Ajax Based Functions ////////////////////////////////////////

if (isset($_REQUEST["action"])) 
{
	switch ($_REQUEST["action"]) 
	{
		case "cleanup_library":
			add_action("admin_init", "cleanup_library");
			function cleanup_library()
			{	
				include_once CLEANUP_BK_PLUGIN_DIR . "/lib/manage-entries.php";
				global $wpdb,$current_user,$user_role_permission;
				$cpo_role = $wpdb->prefix . "capabilities";
				$current_user->role = array_keys($current_user->$cpo_role);
				$cpo_role = $current_user->role[0];
				include_once CLEANUP_BK_PLUGIN_DIR . "/lib/cleanup-optimizer-class.php";
				die();
			}
			break;
	}
}

////////////////////////////////////////Adding Top-bar Menus///////////////////////////////////////////

if(file_exists(CLEANUP_BK_PLUGIN_DIR . "/lib/top-bar-menu.php"))
{
	include_once CLEANUP_BK_PLUGIN_DIR . "/lib/top-bar-menu.php";
}

/////////////////////////////////////Language Convertions///////////////////////////////////

function plugin_load_textdomain_wp_cleanup_optimizer()
{
	if(function_exists( "plugin_load_textdomain_wp_cleanup_optimizer" ))
	{
		load_plugin_textdomain(cleanup_optimizer, false, CLEANUP_BK_PLUGIN_DIRNAME ."/languages");
	}
}
add_action("plugins_loaded", "plugin_load_textdomain_wp_cleanup_optimizer");

/////////////////////////////Setting shows at Activation/Deactivation of plugin/////////////////////////

function wp_cleanup_optimizer_settings_link($links)
{
	$data_optimizer_link = '<a href="' . admin_url( 'admin.php?page=wp_optimizer' ) . '">Data Optimizer</a>';
	$db_optimizer_link = '<a href="' . admin_url( 'admin.php?page=db_optimizer' ) . '">DB Optimizer</a>';
	array_unshift($links, $db_optimizer_link);
	array_unshift($links, $data_optimizer_link);
	return $links;
}
///////////////////////////////////  Calling Hooks   /////////////////////////////////////////////////////

add_action("admin_bar_menu", "add_wp_cleanup_optimizer_admin_bar",100);
add_action("admin_init", "plugin_install_script_for_cleanup_optimizer");
add_action("admin_init", "admin_panel_css_calls_for_cleanup_optimizer");
add_action("admin_init", "admin_panel_js_calls_for_cleanup_optimizer");
add_action("admin_menu", "create_global_menus_for_cleanup_optimizer");
add_filter("plugin_action_links_" . plugin_basename(__FILE__), "wp_cleanup_optimizer_settings_link");
?>