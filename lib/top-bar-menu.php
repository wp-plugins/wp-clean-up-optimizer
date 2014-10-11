<?php 
///////////////////////////////////////////////////////////////////////////////////////////////////////
///////////                      Creating Top-bar Menus                                      //////////
//////////////////////////////////////////////////////////////////////////////////////////////////////

function add_wp_cleanup_optimizer_admin_bar($meta = TRUE)
{
	global $wp_admin_bar,$wpdb,$current_user;
	$cpo_role = $wpdb->prefix . "capabilities";
	$current_user->role = array_keys($current_user->$cpo_role);
	$cpo_role = $current_user->role[0];
	if (!is_user_logged_in()) {
		return;
	}

	switch ($cpo_role)
	{
		case "administrator":
			$wp_admin_bar->add_menu( array(
			"id" => "wp_cleanup_optimizer_links",
			"title" =>  "<img src=\"".plugins_url("/assets/images/icons/icon.png",dirname(__FILE__))."\" width=\"25\" height=\"25\" style=\"vertical-align:text-top; margin-right:5px;\" />WP Clean Up Optimizer" ,
			"href" => site_url() ."/wp-admin/admin.php?page=wp_optimizer",
			));
			$wp_admin_bar->add_menu( array(
					"parent" => "wp_cleanup_optimizer_links",
					"id"     => "wp_optimizer_links",
					"href"  => site_url() ."/wp-admin/admin.php?page=wp_optimizer",
					"title" => __( "WP Data Optimizer", cleanup_optimizer) )         /* set the sub-menu name */
			);
			$wp_admin_bar->add_menu( array(
					"parent" => "wp_cleanup_optimizer_links",
					"id"     => "db_optimizer_links",
					"href"  => site_url() ."/wp-admin/admin.php?page=db_optimizer",
					"title" => __( "WP DB Optimizer", cleanup_optimizer))         /* set the sub-menu name */
			);
			$wp_admin_bar->add_menu( array(
					"parent" => "wp_cleanup_optimizer_links",
					"id"     => "system_status_licensing_link",
					"href"  => site_url() ."/wp-admin/admin.php?page=wpcpo_system_status",
					"title" => __( "System Status", cleanup_optimizer))         /* set the sub-menu name */
			);
			break;

		case "editor":
			$wp_admin_bar->add_menu( array(
			"id" => "wp_cleanup_optimizer_links",
			"title" =>  "<img src=\"".plugins_url("/assets/images/icons/icon.png",dirname(__FILE__))."\" width=\"25\" height=\"25\" style=\"vertical-align:text-top; margin-right:5px;\" />WP Clean Up Optimizer" ,
			"href" => site_url() ."/wp-admin/admin.php?page=wp_optimizer",
			));
			$wp_admin_bar->add_menu( array(
					"parent" => "wp_cleanup_optimizer_links",
					"id"     => "wp_optimizer_links",
					"href"  => site_url() ."/wp-admin/admin.php?page=wp_optimizer",
					"title" => __( "WP Data Optimizer", cleanup_optimizer) )         /* set the sub-menu name */
			);
			$wp_admin_bar->add_menu( array(
					"parent" => "wp_cleanup_optimizer_links",
					"id"     => "db_optimizer_links",
					"href"  => site_url() ."/wp-admin/admin.php?page=db_optimizer",
					"title" => __( "WP DB Optimizer", cleanup_optimizer))         /* set the sub-menu name */
			);
			$wp_admin_bar->add_menu( array(
					"parent" => "wp_cleanup_optimizer_links",
					"id"     => "system_status_licensing_link",
					"href"  => site_url() ."/wp-admin/admin.php?page=wpcpo_system_status",
					"title" => __( "System Status", cleanup_optimizer))         /* set the sub-menu name */
			);
			break;

		case "author":
			$wp_admin_bar->add_menu( array(
			"id" => "wp_cleanup_optimizer_links",
			"title" =>  "<img src=\"".plugins_url("/assets/images/icons/icon.png",dirname(__FILE__))."\" width=\"25\" height=\"25\" style=\"vertical-align:text-top; margin-right:5px;\" />WP Clean Up Optimizer" ,
			"href" => site_url() ."/wp-admin/admin.php?page=wp_optimizer",
			));
			$wp_admin_bar->add_menu( array(
					"parent" => "wp_cleanup_optimizer_links",
					"id"     => "wp_optimizer_links",
					"href"  => site_url() ."/wp-admin/admin.php?page=wp_optimizer",
					"title" => __( "WP Data Optimizer", cleanup_optimizer) )         /* set the sub-menu name */
			);
			$wp_admin_bar->add_menu( array(
					"parent" => "wp_cleanup_optimizer_links",
					"id"     => "db_optimizer_links",
					"href"  => site_url() ."/wp-admin/admin.php?page=db_optimizer",
					"title" => __( "WP DB Optimizer", cleanup_optimizer))         /* set the sub-menu name */
			);
			$wp_admin_bar->add_menu( array(
					"parent" => "wp_cleanup_optimizer_links",
					"id"     => "system_status_licensing_link",
					"href"  => site_url() ."/wp-admin/admin.php?page=wpcpo_system_status",
					"title" => __( "System Status", cleanup_optimizer))         /* set the sub-menu name */
			);
			break;
	}
}

?>