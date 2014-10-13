<?php 
global $wpdb,$current_user,$user_role_permission;
$cpo_role = $wpdb->prefix . "capabilities";
$current_user->role = array_keys($current_user->$cpo_role);
$cpo_role = $current_user->role[0];

switch($cpo_role)
{
	case "administrator":
		$cb_user_role_permission = "manage_options";
		break;
	case "editor":
		$cb_user_role_permission = "publish_pages";
		break;
	case "author":
		$cb_user_role_permission = "publish_posts";
		break;
}
if (!current_user_can($cb_user_role_permission))
{
	return;
}
else
{
	class manage_data
	{
		function insert_data($tbl, $data)
		{
			global $wpdb;
			$wpdb->insert($tbl,$data);
		}
		function update_data($tbl,$data,$where)
		{
			global $wpdb;
			$wpdb->update($tbl,$data,$where);
		}
		function delete_data($tbl,$where)
		{
			global $wpdb;
			$wpdb->delete($tbl, $where);
		}
	}
	class delete_data
	{
		function  delete_revision($where)
		{
			global $wpdb;
			$wpdb->delete($wpdb->posts, $where);
		}
		function  delete_comments($where)
		{
			global $wpdb;
			$wpdb->delete($wpdb->comments, $where);
		}
	}
}
?>