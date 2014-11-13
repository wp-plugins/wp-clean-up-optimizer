<?php
/*
Plugin Name: Wp Cleanup Optimizer Standard Edition
Plugin URI: http://tech-banker.com
Description: It allows you to optimize your WordPress database without phpMyAdmin.
Author: Tech Banker
Version: 2.0
Author URI: http://tech-banker.com
*/

////////////////////////////////////  Define  Wp Cleanup Optimizer  Constants  /////////////////////////////

if (!defined("CLEANUP_BK_PLUGIN_DIR")) define("CLEANUP_BK_PLUGIN_DIR",  plugin_dir_path( __FILE__ ));
if (!defined("CLEANUP_BK_PLUGIN_DIRNAME")) define("CLEANUP_BK_PLUGIN_DIRNAME", plugin_basename(dirname(__FILE__)));
if (!defined("cleanup_optimizer")) define("cleanup_optimizer", "cleanup_optimizer");

/////////////////////////////////////  Call Install Script on Plugin Activation ////////////////////////////
if(!function_exists("plugin_install_script_for_cleanup_optimizer"))
{
	function plugin_install_script_for_cleanup_optimizer()
	{
		if(file_exists(CLEANUP_BK_PLUGIN_DIR. "/lib/install-script.php"))
		{
			include_once CLEANUP_BK_PLUGIN_DIR. "/lib/install-script.php";
		}
	}
}
/////////////////////////////////////  Functions for Returing Table Names  /////////////////////////////////
if(!function_exists("wp_scheduler_tbl"))
{
	function wp_scheduler_tbl()
	{
		global $wpdb;
		return $wpdb->prefix . "cleanup_optimizer_wp_scheduler";
	}
}
if(!function_exists("db_scheduler_tbl"))
{
	function db_scheduler_tbl()
	{
		global $wpdb;
		return $wpdb->prefix . "cleanup_optimizer_db_scheduler";
	}
}
if(!function_exists("cleanup_optimizer_log"))
{
	function cleanup_optimizer_log()
	{
		global $wpdb;
		return $wpdb->prefix . "cleanup_optimizer_login_log";
	}
}
if(!function_exists("cleanup_optimizer_plugin_settings"))
{
	function cleanup_optimizer_plugin_settings()
	{
		global $wpdb;
		return $wpdb->prefix . "cleanup_optimizer_plugin_settings";
	}
}
if(!function_exists("wp_cleanup_optimizer_licensing"))
{
	function wp_cleanup_optimizer_licensing()
	{
		global $wpdb;
		return $wpdb->prefix . "cleanup_optimizer_licensing";
	}
}
if(!function_exists("wp_cleanup_optimizer_block_single_ip"))
{
	function wp_cleanup_optimizer_block_single_ip()
	{
		global $wpdb;
		return $wpdb->prefix . "cleanup_optimizer_block_single_ip";
	}
}
if(!function_exists("wp_cleanup_optimizer_block_range_ip"))
{
	function wp_cleanup_optimizer_block_range_ip()
	{
		global $wpdb;
		return $wpdb->prefix . "cleanup_optimizer_block_range_ip";
	}
}
/////////////////////////////////////  Call CSS & JS Scripts - Back End ///////////////////////////////////
if(!function_exists("admin_panel_js_calls_for_cleanup_optimizer"))
{
	function admin_panel_js_calls_for_cleanup_optimizer()
	{
		wp_enqueue_script("jquery");
		wp_enqueue_script("jquery.dataTables.min.js", plugins_url("/assets/js/jquery.dataTables.min.js",__FILE__));
		wp_enqueue_script("jquery.validate.min.js", plugins_url("/assets/js/jquery.validate.min.js",__FILE__));
		wp_enqueue_script("jquery_google_map.js", plugins_url("/assets/js/jquery_google_map.js",__FILE__));
		wp_enqueue_script("jquery.Tooltip.js", plugins_url("/assets/js/jquery.Tooltip.js",__FILE__));
	}
}
if(!function_exists("admin_panel_css_calls_for_cleanup_optimizer"))
{
	function admin_panel_css_calls_for_cleanup_optimizer()
	{
		wp_enqueue_style("wp-cleanup-optimizer-framework.css", plugins_url("/assets/css/framework.css",__FILE__));
		wp_enqueue_style("wp-cleanup-optimizer.css", plugins_url("/assets/css/wp-cleanup-optimizer.css",__FILE__));
		wp_enqueue_style("premium-edition.css", plugins_url("/assets/css/premium-edition.css",__FILE__));
		wp_enqueue_style("responsive.css", plugins_url("/assets/css/responsive.css",__FILE__));
		wp_enqueue_style("google-fonts-roboto", "//fonts.googleapis.com/css?family=Roboto Condensed:300|Roboto Condensed:300|Roboto Condensed:300|Roboto Condensed:regular|Roboto Condensed:300");
		
	}
}

/////////////////////////////////////  Include Menus on Dashboard //////////////////////////////////////////
if(!function_exists("create_global_menus_for_cleanup_optimizer"))
{
	function create_global_menus_for_cleanup_optimizer()
	{
		if(file_exists(CLEANUP_BK_PLUGIN_DIR . "/lib/menus.php"))
		{
			global $wpdb,$current_user;
			$cpo_role = $wpdb->prefix . "capabilities";
			$current_user->role = array_keys($current_user->$cpo_role);
			$cpo_role = $current_user->role[0];
			switch($cpo_role)
			{
				case "administrator":
					if (file_exists(CLEANUP_BK_PLUGIN_DIR . "/lib/menus.php"))
					{
						include_once CLEANUP_BK_PLUGIN_DIR . "/lib/menus.php";
					}
				break;
				case "editor":
					if (file_exists(CLEANUP_BK_PLUGIN_DIR . "/lib/menus.php"))
					{
						include_once CLEANUP_BK_PLUGIN_DIR . "/lib/menus.php";
					}
				break;
				case "author":
					if (file_exists(CLEANUP_BK_PLUGIN_DIR . "/lib/menus.php"))
					{
						include_once CLEANUP_BK_PLUGIN_DIR . "/lib/menus.php";
					}
				break;
			}
		}
	}
}
/////////////////////////////////////// Register Ajax Based Functions ////////////////////////////////////////

if (isset($_REQUEST["action"])) 
{
	switch ($_REQUEST["action"]) 
	{
		case "cleanup_library":
			add_action("admin_init", "cleanup_library");
			if(!function_exists("cleanup_library"))
			{
				function cleanup_library()
				{	
					global $wpdb,$current_user,$user_role_permission;
					$cpo_role = $wpdb->prefix . "capabilities";
					$current_user->role = array_keys($current_user->$cpo_role);
					$cpo_role = $current_user->role[0];
					
					if(file_exists(CLEANUP_BK_PLUGIN_DIR . "/lib/db-helper.php"))
					{
						include CLEANUP_BK_PLUGIN_DIR . "/lib/db-helper.php";
					}
					if(file_exists(CLEANUP_BK_PLUGIN_DIR . "/lib/cleanup-optimizer-class.php"))
					{
						include_once CLEANUP_BK_PLUGIN_DIR . "/lib/cleanup-optimizer-class.php";
					}
					die();
				}
			}
			break;
	}
}

/////////////////////////////Setting shows at Activation/Deactivation of plugin/////////////////////////

if(!function_exists("wp_cleanup_optimizer_settings_link"))
{
	function wp_cleanup_optimizer_settings_link($links)
	{
		$data_optimizer_link = '<a href="' . admin_url( 'admin.php?page=cpo_dashboard' ) . '">Dashboard</a>';
		array_unshift($links, $data_optimizer_link);
		return $links;
	}
}
/////////////////////////////////////Language Convertions///////////////////////////////////

if(!function_exists("plugin_load_textdomain_wp_cleanup_optimizer"))
{
	function plugin_load_textdomain_wp_cleanup_optimizer()
	{
		if(function_exists( "plugin_load_textdomain_wp_cleanup_optimizer" ))
		{
			load_plugin_textdomain(cleanup_optimizer, false, CLEANUP_BK_PLUGIN_DIRNAME ."/languages");
		}
	}
}
add_action("plugins_loaded", "plugin_load_textdomain_wp_cleanup_optimizer");

/////////////////////////////////////Login Logs///////////////////////////////////

if(file_exists(CLEANUP_BK_PLUGIN_DIR . "/lib/login-logs-class.php"))
{
	include_once CLEANUP_BK_PLUGIN_DIR . "/lib/login-logs-class.php";
}
////////////////////////////////////////Adding Top-bar Menus///////////////////////////////////////////

if(file_exists(CLEANUP_BK_PLUGIN_DIR . "/lib/top-bar-menu.php"))
{
	global $wpdb;
	include_once CLEANUP_BK_PLUGIN_DIR . "/lib/top-bar-menu.php";
}
///////////////////////////////////  Calling Hooks   /////////////////////////////////////////////////////

//------------------------------------------------------------------------------------------------------------//
// Activation Hook called for function plugin_install_script_for_cleanup_optimizer
//------------------------------------------------------------------------------------------------------------//
register_activation_hook(__FILE__,"plugin_install_script_for_cleanup_optimizer");
//------------------------------------------------------------------------------------------------------------//
// add_action Hook called for function admin_panel_css_calls_for_cleanup_optimizer
//------------------------------------------------------------------------------------------------------------//
add_action("admin_init", "admin_panel_css_calls_for_cleanup_optimizer");
//------------------------------------------------------------------------------------------------------------//
// add_action Hook called for function admin_panel_js_calls_for_cleanup_optimizer
//------------------------------------------------------------------------------------------------------------//
add_action("admin_init", "admin_panel_js_calls_for_cleanup_optimizer");
//------------------------------------------------------------------------------------------------------------//
// add_action Hook called for function add_wp_cleanup_optimizer_admin_bar
//------------------------------------------------------------------------------------------------------------//
add_action("admin_bar_menu", "add_wp_cleanup_optimizer_admin_bar",100);
//------------------------------------------------------------------------------------------------------------//
// plugin_action_links Hook called for function wp_cleanup_optimizer_settings_link
//------------------------------------------------------------------------------------------------------------//
add_filter("plugin_action_links_" . plugin_basename(__FILE__), "wp_cleanup_optimizer_settings_link");
//------------------------------------------------------------------------------------------------------------//
// add_action Hook called for function create_global_menus_for_cleanup_optimizer
//------------------------------------------------------------------------------------------------------------//
add_action("admin_menu", "create_global_menus_for_cleanup_optimizer");
?>