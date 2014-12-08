<?php 
switch($cpo_role)
{
	case "administrator":
		$user_role_permission = "manage_options";
		break;
	case "editor":
		$user_role_permission = "publish_pages";
		break;
	case "author":
		$user_role_permission = "publish_posts";
		break;
}
if (!current_user_can($user_role_permission))
{
	return;
}
else
{
	function clean_data($type)
	{
		global $wpdb;
		switch($type)
		{
			case 1:
				$delete = new delete_data();
				$where = array();
				$where["post_status"] ="auto-draft";
				$delete->delete_revision($where);
			break;
			case 2:
				$wpdb->query
				(
					$wpdb->prepare
					(
						"DELETE FROM $wpdb->options WHERE option_name LIKE %s OR option_name LIKE %s OR option_name LIKE %s OR option_name LIKE %s",
						"_site_transient_browser_%",
						"_site_transient_timeout_browser_%",
						"_transient_feed_%",
						"_transient_timeout_feed_%"
					)
				);
			break;
			case 3:
				$delete = new delete_data();
				$where = array();
				$where["post_status"] ="draft";
				$delete->delete_revision($where);
			break;
			case 5:
				$wpdb->query
				(
					"DELETE FROM $wpdb->commentmeta WHERE comment_id NOT IN (SELECT comment_id FROM $wpdb->comments)"
				);
			break;
			case 6:
				$wpdb->query
				(
					"DELETE pm FROM $wpdb->postmeta pm LEFT JOIN $wpdb->posts wp ON wp.ID = pm.post_id WHERE wp.ID IS NULL"
				);
			break;
			case 7:
				$wpdb->query
				(
					$wpdb->prepare
					(
						"DELETE FROM $wpdb->term_relationships WHERE term_taxonomy_id=%d AND object_id NOT IN (SELECT id FROM $wpdb->posts)",
						1
					)
				);
			break;
			case 8:
				$delete = new delete_data();
				$where = array();
				$where["post_type"] ="revision";
				$delete->delete_revision($where);
			break;
			case 9:
				$delete = new delete_data();
				$where = array();
				$where["comment_type"] ="pingback";
				$delete->delete_comments($where);
			break;	
			case 10:
				$wpdb->query
				(
					$wpdb->prepare
					(
						"DELETE FROM $wpdb->options WHERE option_name LIKE %s OR option_name LIKE %s",
						"_transient_%",
						"_site_transient_%"
					)
				);
			break;
			case 11:
				$delete = new delete_data();
				$where = array();
				$where["comment_type"] ="trackback";
				$delete->delete_comments($where);
			break;
			case 12:
				$delete = new delete_data();
				$where = array();
				$where["comment_approved"] ="spam";
				$delete->delete_comments($where);
			break;
			case 13:
				$delete = new delete_data();
				$where = array();
				$where["comment_approved"] ="trash";
				$delete->delete_comments($where);
			break;
		}
	}
	if(isset($_REQUEST["param"]))
	{
		switch($_REQUEST["param"])
		{
			case "wp_cleanup":
				if(wp_verify_nonce( $_REQUEST["_wpnonce"], "clear_wp_data"))
				{
					$type= $_REQUEST["typeClean"];
					clean_data($type);
					die();
				}
			break;
			case "bulk_delete_action":
				if(wp_verify_nonce( $_REQUEST["_wpnonce"], "bulk_clear_wp_data"))
				{
					$val="";
					$types= $_REQUEST["ux_chk_cleanup"];
					print_r($types);
					for($flag=0; $flag<count($types); $flag++)
					{
						clean_data($types[$flag]);
					}
					die();
				}
			break;
			case "bulk_selected_action":
				if(wp_verify_nonce( $_REQUEST["_wpnonce"], "bulk_action_table"))
				{
					$types= $_REQUEST["ux_ddl_bulk_action_db_optimzier"];
					$chk_value=$_REQUEST["ux_chk_cleanup_arr_db"];
					$test=array();
					if(is_multisite())
					{
						for($flag1=0; $flag1 < count($chk_value); $flag1++)
						{
							if((strstr($chk_value[$flag1],$wpdb->terms) || strstr($chk_value[$flag1],$wpdb->term_taxonomy) || strstr($chk_value[$flag1],$wpdb->term_relationships) || strstr($chk_value[$flag1],$wpdb->commentmeta) || strstr($chk_value[$flag1],$wpdb->comments)
								|| strstr($chk_value[$flag1],$wpdb->links) || strstr($chk_value[$flag1],$wpdb->options)|| strstr($chk_value[$flag1],$wpdb->postmeta) || strstr($chk_value[$flag1], $wpdb->posts) || strstr($chk_value[$flag1],$wpdb->users) || strstr($chk_value[$flag1],$wpdb->usermeta)
								|| strstr($chk_value[$flag1],$wpdb->prefix."cleanup_optimizer_wp_scheduler") || strstr($chk_value[$flag1],$wpdb->prefix . "cleanup_optimizer_db_scheduler") || strstr($chk_value[$flag1],$wpdb->prefix . "cleanup_optimizer_login_log")
								|| strstr($chk_value[$flag1],$wpdb->prefix . "cleanup_optimizer_plugin_settings") || strstr($chk_value[$flag1],$wpdb->prefix . "cleanup_optimizer_licensing") || strstr($chk_value[$flag1],$wpdb->prefix . "cleanup_optimizer_block_single_ip")
								|| strstr($chk_value[$flag1],$wpdb->prefix . "cleanup_optimizer_block_range_ip") || strstr($chk_value[$flag1],$wpdb->signups) || strstr($chk_value[$flag1],$wpdb->sitemeta) || strstr($chk_value[$flag1],$wpdb->site) || strstr($chk_value[$flag1],$wpdb->registration_log)
								|| strstr($chk_value[$flag1],$wpdb->blogs) || strstr($chk_value[$flag1],$wpdb->blog_versions)) == true)
							{
							
							}
							else
							{
								switch($types)
								{
									case 1:
										$wpdb->query
										(
											"TRUNCATE TABLE $chk_value[$flag1]"
										);
									break;
								}
							}
						}
					}
					else
					{
						for($flag1=0; $flag1 < count($chk_value); $flag1++)
						{
							if((strstr($chk_value[$flag1],$wpdb->terms) || strstr($chk_value[$flag1],$wpdb->term_taxonomy) || strstr($chk_value[$flag1],$wpdb->term_relationships) || strstr($chk_value[$flag1],$wpdb->commentmeta) || strstr($chk_value[$flag1],$wpdb->comments)
								|| strstr($chk_value[$flag1],$wpdb->links) || strstr($chk_value[$flag1],$wpdb->options)|| strstr($chk_value[$flag1],$wpdb->postmeta) || strstr($chk_value[$flag1], $wpdb->posts) || strstr($chk_value[$flag1],$wpdb->users) || strstr($chk_value[$flag1],$wpdb->usermeta)
								|| strstr($chk_value[$flag1],$wpdb->prefix."cleanup_optimizer_wp_scheduler") || strstr($chk_value[$flag1],$wpdb->prefix . "cleanup_optimizer_db_scheduler") || strstr($chk_value[$flag1],$wpdb->prefix . "cleanup_optimizer_login_log")
								|| strstr($chk_value[$flag1],$wpdb->prefix . "cleanup_optimizer_plugin_settings") || strstr($chk_value[$flag1],$wpdb->prefix . "cleanup_optimizer_licensing") || strstr($chk_value[$flag1],$wpdb->prefix . "cleanup_optimizer_block_single_ip")
								|| strstr($chk_value[$flag1],$wpdb->prefix . "cleanup_optimizer_block_range_ip")) == true)
							{
								
							}
							else
							{
								switch($types)
								{
									case 1:
										$wpdb->query
										(
											"TRUNCATE TABLE $chk_value[$flag1]"
										);
									break;
								}
							}
						}
					}
					die();
				}
			break;
			case "table_action":
				if(wp_verify_nonce( $_REQUEST["_wpnonce"], "clear_db_data"))
				{
					$perform_action=intval($_REQUEST["perform_action"]);
					$table_name=esc_attr($_REQUEST["table_name"]);
					switch($perform_action)
					{
						case 1:
							$wpdb->query
							(
								"TRUNCATE TABLE $table_name"
							);
						break;
					}
					die();
				}
			break;
		}
		die();
	}
}
?>