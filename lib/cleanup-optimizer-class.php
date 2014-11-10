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
	
				$delete = new manage_data();
				$where = array();
				$where["post_status"] ="auto-draft";
				$delete->delete_data($wpdb->posts,$where);
				break;
	
			case 2:

				$wpdb->query
				(
					"DELETE FROM $wpdb->options WHERE option_name LIKE '_site_transient_browser_%' OR option_name LIKE '_site_transient_timeout_browser_%' OR option_name LIKE '_transient_feed_%' OR option_name LIKE '_transient_timeout_feed_%'"
				);
				break;
	
			case 3:
	
				$delete = new manage_data();
				$where = array();
				$where["post_status"] ="draft";
				$delete->delete_data($wpdb->posts,$where);
				break;
	
			case 4:
	
				$delete = new manage_data();
				$where = array();
				$where["comment_approved"] ="0";
				$delete->delete_data($wpdb->comments,$where);
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
					"DELETE FROM $wpdb->term_relationships WHERE term_taxonomy_id=1 AND object_id NOT IN (SELECT id FROM $wpdb->posts)"
				);
				break;
				
			case 8:
				
				$delete = new manage_data();
				$where = array();
				$where["post_type"] ="revision";
				$delete->delete_data($wpdb->posts,$where);
				break;
				
			case 9:
				
				$delete = new delete_data();
				$where = array();
				$where["comment_type"] ="pingback";
				$delete->delete_data($wpdb->comments,$where);
				break;
					
			case 10:
				$wpdb->query
				(
					"DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_%' OR option_name LIKE '_site_transient_%'"
				);
				break;
						
			case 11:
						
				$delete = new delete_data();
				$where = array();
				$where["comment_type"] ="trackback";
				$delete->delete_data($wpdb->comments,$where);
				break;
				
			case 12:
				
				$delete = new delete_data();
				$where = array();
				$where["comment_approved"] ="spam";
				$delete->delete_data($wpdb->comments,$where);
				break;
				
			case 13:
				
				$delete = new delete_data();
				$where = array();
				$where["comment_approved"] ="trash";
				$delete->delete_data($wpdb->comments,$where);
				break;
		}
	}
	if(isset($_REQUEST["param"]))
	{
		global $wpdb;
		if($_REQUEST["param"] == "truncate_table")
		{
			$truncate_table=esc_attr($_REQUEST["table_name"]);
			$wpdb->query
			(
				"TRUNCATE TABLE $truncate_table"
			);
			die();
		}
		else if($_REQUEST["param"] == "wp_cleanup")
		{
			$type= $_REQUEST["typeClean"];
			clean_data($type);
			die();
		}
		else if($_REQUEST["param"] == "bulk_delete_action")
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
		else if($_REQUEST["param"] == "bulk_selected_action")
		{
			$types= $_REQUEST["ux_ddl_bulk_action"];
			print_r($chk_value=$_REQUEST["ux_chk_cleanup_arr"]);
			switch($types)
			{
				case 1:
					foreach($chk_value as $val)
					{
						$wpdb->query
						(
							"TRUNCATE TABLE $val"
						);
					}
					break;
				case 2:
					foreach($chk_value as $val)
					{
						$wpdb->query
						(
							"DROP TABLE $val"
						);
					}
					break;
			}
			die();
		}
		else if($_REQUEST["param"] =="preview_tbl")
		{
			$columns_name = array();
			$tbl_name =  $_REQUEST["tbl_name"];
			$data = $wpdb->get_results
			(
				"SELECT * FROM $tbl_name"
			);
			$columns = $wpdb->get_results
			(
				"SHOW COLUMNS FROM $tbl_name"
			);
			for($flag=0;$flag<count($columns);$flag++)
	 		{
	 			$count = 0;
				foreach($columns[$flag] as $col=>$key)
				{
					if($count < 1)
					{
						array_push($columns_name,$key) ;
					}
					$count++;
				}
			}
			?>
			<div id="dDiv">
				<table class="table table-striped" id="post_back_table" style="width:100%;">
					<p class="custom-tbl-name"><?php echo "Table : ".$tbl_name;?></p>
					<thead>
						<tr>
							<?php
								for($flag2=0;$flag2<count($columns_name);$flag2++)
								{
									echo "<th>".$columns_name[$flag2]."</th>";
								}
							?>
						</tr>
					</thead>
					<tbody>
						<?php 
							for($flag1=0;$flag1<count($data);$flag1++)
							{
								?>
								<tr>
									<?php 
										for($flag3=0;$flag3<count($columns_name);$flag3++)
										{
											echo "<td>".esc_html($data[$flag1]->$columns_name[$flag3])."</td>";
										}
									?>
								</tr>
								<?php 
							}
						?>
					</tbody>
				</table>
			</div>
			<script type="text/javascript">
				oTable = jQuery("#post_back_table").dataTable
				({
					"bJQueryUI": false,
					"bAutoWidth": true,
					"sPaginationType": "full_numbers",
					"sDom": '<"datatable-header"fl>t<"datatable-footer"ip>',
					"oLanguage":
					{
						"sLengthMenu": "<span>Show entries:</span> _MENU_"
					},
					"aaSorting": [[ 0, "asc" ]]
				});
			</script>
			<?php 
			die();
		}
		else if($_REQUEST["param"] == "delete_table")
		{
			$delete_table=esc_attr($_REQUEST["table_name"]);
			$wpdb->query
			(
				"DROP TABLE $delete_table"
			);
			die();
		}
		else if($_REQUEST["param"] == "trackbacks")
		{
			global $wpdb;
			$enable_trackbacks=isset($_REQUEST["enable_trackbacks"]) ? esc_attr($_REQUEST["enable_trackbacks"]) : "";
			$disable_trackbacks=isset($_REQUEST["disable_trackbacks"]) ? esc_attr($_REQUEST["disable_trackbacks"]) : "";
			
			if($enable_trackbacks == "1")
			{
				$wpdb->query
				(
					"UPDATE `$wpdb->posts` SET ping_status='open' WHERE post_status = 'publish' AND post_type = 'post'"
				);
			}
			else
			{
				$wpdb->query
				(
					"UPDATE `$wpdb->posts` SET ping_status='closed' WHERE post_status = 'publish' AND post_type = 'post'"
				);
			}
			die();
		}
		else if($_REQUEST["param"] == "comments")
		{
			global $wpdb;
			$enable_comments=isset($_REQUEST["enable_comments"]) ? esc_attr($_REQUEST["enable_comments"]) : "";
			$disable_comments=isset($_REQUEST["disable_comments"]) ? esc_attr($_REQUEST["disable_comments"]) : "";
			
			if($enable_comments == "1")
			{
				$wpdb->query
				(
					"UPDATE `$wpdb->posts` SET comment_status='open' WHERE post_status = 'publish' AND post_type = 'post'"
				);
			}
			else
			{
				$wpdb->query
				(
					"UPDATE `$wpdb->posts` SET comment_status='closed' WHERE post_status = 'publish' AND post_type = 'post'"
				);
			}
			
			die();
		}
		die();
	}
}
?>