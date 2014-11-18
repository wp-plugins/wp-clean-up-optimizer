<?php 
///////////////////////////////////////////////////////////////////////////////////////////////////////
///////////                      Creating Top-bar Menus                                      //////////
//////////////////////////////////////////////////////////////////////////////////////////////////////

if(!function_exists("add_wp_cleanup_optimizer_admin_bar"))
{
	function add_wp_cleanup_optimizer_admin_bar($meta = TRUE)
	{
		global $wp_admin_bar,$wpdb,$current_user;
		$role = $wpdb->prefix . "capabilities";
		$current_user->role = array_keys($current_user->$role);
		$role = $current_user->role[0];
		if (!is_user_logged_in()) {
			return;
		}
		switch ($role)
		{
			case "administrator":
				$wp_admin_bar->add_menu( array(
					"id" => "wp_cleanup_optimizer_links",
					"title" =>  "<img src=\"".plugins_url("/assets/images/icons/icon.png",dirname(__FILE__))."\" width=\"25\" height=\"25\" style=\"vertical-align:text-top; margin-right:5px;\" />WP Clean Up Optimizer" ,
					"href" => site_url() ."/wp-admin/admin.php?page=cpo_dashboard",
				));
				$wp_admin_bar->add_menu( array(
					"parent" => "wp_cleanup_optimizer_links",
					"id"     => "dashboard_links",
					"href"  => site_url() ."/wp-admin/admin.php?page=cpo_dashboard",
					"title" => __( "Dashboard", cleanup_optimizer) )         /* set the sub-menu name */
				);
				$wp_admin_bar->add_menu( array(
					"parent" => "wp_cleanup_optimizer_links",
					"id"     => "login_logs",
					"href"  => site_url() ."/wp-admin/admin.php?page=cpo_login_logs",
					"title" => __( "Login Logs", cleanup_optimizer))         /* set the sub-menu name */
				);
				$wp_admin_bar->add_menu( array(
					"parent" => "wp_cleanup_optimizer_links",
					"id"     => "cron_job",
					"href"  => site_url() ."/wp-admin/admin.php?page=cpo_cron_jobs",
					"title" => __( "Cron Jobs", cleanup_optimizer))         /* set the sub-menu name */
				);
				$wp_admin_bar->add_menu( array(
					"parent" => "wp_cleanup_optimizer_links",
					"id"     => "security_settings",
					"href"  => site_url() ."/wp-admin/admin.php?page=cpo_general_settings",
					"title" => __( "General Settings", cleanup_optimizer))         /* set the sub-menu name */
				);
				$wp_admin_bar->add_menu( array(
					"parent" => "wp_cleanup_optimizer_links",
					"id"     => "system_status_licensing_link",
					"href"  => site_url() ."/wp-admin/admin.php?page=cpo_system_status",
					"title" => __( "System Status", cleanup_optimizer))         /* set the sub-menu name */
				);
				$wp_admin_bar->add_menu( array(
					"parent" => "wp_cleanup_optimizer_links",
					"id"     => "premium_edition_link",
					"href"  => site_url() ."/wp-admin/admin.php?page=cpo_premium_edition",
					"title" => __( "Premium Editions", cleanup_optimizer))         /* set the sub-menu name */
				);
				$wp_admin_bar->add_menu( array(
					"parent" => "wp_cleanup_optimizer_links",
					"id"     => "recommendations",
					"href"  => site_url() ."/wp-admin/admin.php?page=cpo_recommendations",
					"title" => __( "Recommendations", cleanup_optimizer))         /* set the sub-menu name */
				);
				$wp_admin_bar->add_menu( array(
					"parent" => "wp_cleanup_optimizer_links",
					"id"     => "our_other_services",
					"href"  => site_url() ."/wp-admin/admin.php?page=cpo_other_services",
					"title" => __( "Our Other Services", cleanup_optimizer))         /* set the sub-menu name */
				);
				break;
				
			case "editor":
				$wp_admin_bar->add_menu( array(
					"id" => "wp_cleanup_optimizer_links",
					"title" =>  "<img src=\"".plugins_url("/assets/images/icons/icon.png",dirname(__FILE__))."\" width=\"25\" height=\"25\" style=\"vertical-align:text-top; margin-right:5px;\" />WP Clean Up Optimizer" ,
					"href" => site_url() ."/wp-admin/admin.php?page=cpo_dashboard",
				));
				$wp_admin_bar->add_menu( array(
					"parent" => "wp_cleanup_optimizer_links",
					"id"     => "dashboard_links",
					"href"  => site_url() ."/wp-admin/admin.php?page=cpo_dashboard",
					"title" => __( "Dashboard", cleanup_optimizer) )         /* set the sub-menu name */
				);
				$wp_admin_bar->add_menu( array(
					"parent" => "wp_cleanup_optimizer_links",
					"id"     => "login_logs",
					"href"  => site_url() ."/wp-admin/admin.php?page=cpo_login_logs",
					"title" => __( "Login Logs", cleanup_optimizer))         /* set the sub-menu name */
				);
				$wp_admin_bar->add_menu( array(
					"parent" => "wp_cleanup_optimizer_links",
					"id"     => "cron_job",
					"href"  => site_url() ."/wp-admin/admin.php?page=cpo_cron_jobs",
					"title" => __( "Cron Jobs", cleanup_optimizer))         /* set the sub-menu name */
				);
				$wp_admin_bar->add_menu( array(
					"parent" => "wp_cleanup_optimizer_links",
					"id"     => "security_settings",
					"href"  => site_url() ."/wp-admin/admin.php?page=cpo_general_settings",
					"title" => __( "General Settings", cleanup_optimizer))         /* set the sub-menu name */
				);
				$wp_admin_bar->add_menu( array(
					"parent" => "wp_cleanup_optimizer_links",
					"id"     => "system_status_licensing_link",
					"href"  => site_url() ."/wp-admin/admin.php?page=cpo_system_status",
					"title" => __( "System Status", cleanup_optimizer))         /* set the sub-menu name */
				);
				$wp_admin_bar->add_menu( array(
					"parent" => "wp_cleanup_optimizer_links",
					"id"     => "premium_edition_link",
					"href"  => site_url() ."/wp-admin/admin.php?page=cpo_premium_edition",
					"title" => __( "Premium Editions", cleanup_optimizer))         /* set the sub-menu name */
				);
				$wp_admin_bar->add_menu( array(
					"parent" => "wp_cleanup_optimizer_links",
					"id"     => "recommendations",
					"href"  => site_url() ."/wp-admin/admin.php?page=cpo_recommendations",
					"title" => __( "Recommendations", cleanup_optimizer))         /* set the sub-menu name */
				);
				$wp_admin_bar->add_menu( array(
					"parent" => "wp_cleanup_optimizer_links",
					"id"     => "our_other_services",
					"href"  => site_url() ."/wp-admin/admin.php?page=cpo_other_services",
					"title" => __( "Our Other Services", cleanup_optimizer))         /* set the sub-menu name */
				);
				break;
				
			case "author":
				$wp_admin_bar->add_menu( array(
					"id" => "wp_cleanup_optimizer_links",
					"title" =>  "<img src=\"".plugins_url("/assets/images/icons/icon.png",dirname(__FILE__))."\" width=\"25\" height=\"25\" style=\"vertical-align:text-top; margin-right:5px;\" />WP Clean Up Optimizer" ,
					"href" => site_url() ."/wp-admin/admin.php?page=cpo_dashboard",
				));
				$wp_admin_bar->add_menu( array(
					"parent" => "wp_cleanup_optimizer_links",
					"id"     => "dashboard_links",
					"href"  => site_url() ."/wp-admin/admin.php?page=cpo_dashboard",
					"title" => __( "Dashboard", cleanup_optimizer) )         /* set the sub-menu name */
				);
				$wp_admin_bar->add_menu( array(
					"parent" => "wp_cleanup_optimizer_links",
					"id"     => "login_logs",
					"href"  => site_url() ."/wp-admin/admin.php?page=cpo_login_logs",
					"title" => __( "Login Logs", cleanup_optimizer))         /* set the sub-menu name */
				);
				$wp_admin_bar->add_menu( array(
					"parent" => "wp_cleanup_optimizer_links",
					"id"     => "cron_job",
					"href"  => site_url() ."/wp-admin/admin.php?page=cpo_cron_jobs",
					"title" => __( "Cron Jobs", cleanup_optimizer))         /* set the sub-menu name */
				);
				$wp_admin_bar->add_menu( array(
					"parent" => "wp_cleanup_optimizer_links",
					"id"     => "security_settings",
					"href"  => site_url() ."/wp-admin/admin.php?page=cpo_general_settings",
					"title" => __( "General Settings", cleanup_optimizer))         /* set the sub-menu name */
				);
				$wp_admin_bar->add_menu( array(
					"parent" => "wp_cleanup_optimizer_links",
					"id"     => "system_status_licensing_link",
					"href"  => site_url() ."/wp-admin/admin.php?page=cpo_system_status",
					"title" => __( "System Status", cleanup_optimizer))         /* set the sub-menu name */
				);
				$wp_admin_bar->add_menu( array(
					"parent" => "wp_cleanup_optimizer_links",
					"id"     => "premium_edition_link",
					"href"  => site_url() ."/wp-admin/admin.php?page=cpo_premium_edition",
					"title" => __( "Premium Editions", cleanup_optimizer))         /* set the sub-menu name */
				);
				$wp_admin_bar->add_menu( array(
					"parent" => "wp_cleanup_optimizer_links",
					"id"     => "recommendations",
					"href"  => site_url() ."/wp-admin/admin.php?page=cpo_recommendations",
					"title" => __( "Recommendations", cleanup_optimizer))         /* set the sub-menu name */
				);
				$wp_admin_bar->add_menu( array(
					"parent" => "wp_cleanup_optimizer_links",
					"id"     => "our_other_services",
					"href"  => site_url() ."/wp-admin/admin.php?page=cpo_other_services",
					"title" => __( "Our Other Services", cleanup_optimizer))         /* set the sub-menu name */
				);
				break;
		}
	}
}
?>