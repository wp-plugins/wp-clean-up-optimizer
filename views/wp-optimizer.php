<?php
switch($role)
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
	function wp_clean_up_count($type)
	{
		global $wpdb;
		switch($type)
		{
			case "revision":
				$count=$wpdb->get_var
					(
						$wpdb->prepare
						(
							"SELECT COUNT(*) FROM $wpdb->posts WHERE post_type = %s",
							"revision"
						)
					);
				break;
			case "draft":
				$count=$wpdb->get_var
				(
					$wpdb->prepare
					(
						"SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = %s",
						"draft"
					)
				);
				break;
			case "autodraft":
				$count=$wpdb->get_var
					(
						$wpdb->prepare
						(
							"SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = %s",
							"auto-draft"
						)
					);
				break;
			case "moderated":
				$count=$wpdb->get_var
					(
						$wpdb->prepare
						(
							"SELECT COUNT(*) FROM $wpdb->comments WHERE comment_approved = %d",
							"0"
						)
					);
				break;
			case "spam":
				$count=$wpdb->get_var
					(
						$wpdb->prepare
						(
							"SELECT COUNT(*) FROM $wpdb->comments WHERE comment_approved = %s",
							"spam"
						)
					);
				break;
			case "trash":
				$count=$wpdb->get_var
					(
						$wpdb->prepare
						(
								"SELECT COUNT(*) FROM $wpdb->comments WHERE comment_approved = %s",
								"trash"
						)
					);
				break;
			case "postmeta":
				$count=$wpdb->get_var
					(
						"SELECT COUNT(*) FROM $wpdb->postmeta pm LEFT JOIN $wpdb->posts wp ON wp.ID = pm.post_id WHERE wp.ID IS NULL"
					);
				break;
			case "commentmeta":
				$count=$wpdb->get_var
					(
						"SELECT COUNT(*) FROM $wpdb->commentmeta WHERE comment_id NOT IN (SELECT comment_id FROM $wpdb->comments)"
					);
				break;
			case "relationships":
				$count=$wpdb->get_var
					(
						"SELECT COUNT(*) FROM $wpdb->term_relationships WHERE term_taxonomy_id=1 AND object_id NOT IN (SELECT id FROM $wpdb->posts)"
					);
				break;
			case "feed":
				$count=$wpdb->get_var
					(
						"SELECT COUNT(*) FROM $wpdb->options WHERE option_name LIKE '_site_transient_browser_%' OR option_name LIKE '_site_transient_timeout_browser_%' OR option_name LIKE '_transient_feed_%' OR option_name LIKE '_transient_timeout_feed_%'"
					);
				break;
		}
		return $count;
	}
	?>
	<form id="ux_frm_cleanup" name="ux_frm_cleanup" >
		<div>
		<p>
			<select id="ux_ddl_bulk_action" name="ux_ddl_bulk_action" class="bulk-action-width">
				<option value="0"><?php _e("Bulk Action", cleanup_optimizer); ?></option>
				<option value="1"><?php _e("Clean", cleanup_optimizer); ?></option>
			</select>
			<input type="button" id="ux_btn_action" onclick="bulk_delete();" name="ux_btn_action" class="button-primary apply_btn_align"  value="<?php _e("Apply", cleanup_optimizer); ?>" />
			<table class="widefat" style="width:1000px;">
				<thead>
					<tr>
						<th style="width:10%;"><input type="checkbox" id="ux_chk_select_all" name="ux_chk_clean" style="margin:0px"/></th>
						<th scope="col"><?php _e("Type of Data",cleanup_optimizer); ?></th>
						<th scope="col"><?php _e("Count",cleanup_optimizer); ?></th>
						<th scope="col"><?php _e("Action",cleanup_optimizer); ?></th>
					</tr>
				</thead>
				<tbody id="the-list">
					<tr class="alternate">
						<td>
							<input type="checkbox" id="ux_chk_cleanup_1" name="ux_chk_cleanup[]" style="margin:0px" value="autodraft"/>
						</td>
						<td class="column-name">
							Auto Draft 
						</td>
						<td class="column-name">
							<?php echo wp_clean_up_count("autodraft"); ?>
						</td>
						<td class="column-name">
							<input type="button" onclick="cleanup_function('autodraft');" class="<?php echo wp_clean_up_count("autodraft") > 0  ? "button-primary" : "button"; ?>" <?php echo wp_clean_up_count("autodraft") == 0 ? "disabled" : "" ?> value="<?php _e("Clean",cleanup_optimizer); ?>" />
						</td>
					</tr>
					<tr>
						<td>
							<input type="checkbox" id="ux_chk_cleanup_2" name="ux_chk_cleanup[]" value="feed" style="margin:0px"  />
						</td>
						<td class="column-name">
							Dashboard Transient Feed
						</td>
						<td class="column-name">
							<?php echo wp_clean_up_count("feed"); ?>
						</td>
						<td class="column-name">
							<input type="button" onclick="cleanup_function('feed');" class="<?php echo wp_clean_up_count("feed") > 0 ? "button-primary" : "button"; ?>" <?php echo wp_clean_up_count("feed") == 0 ? "disabled" : "" ?> value="<?php _e("Clean",cleanup_optimizer); ?>" />
						</td>
					</tr>
					<tr class="alternate">
						<td>
							<input type="checkbox" id="ux_chk_cleanup_3" name="ux_chk_cleanup[]" style="margin:0px"  value="draft"/>
						</td>
						<td class="column-name">
							Draft
						</td>
						<td class="column-name">
							<?php echo wp_clean_up_count("draft"); ?>
						</td>
						<td class="column-name">
							<input type="button" onclick="cleanup_function('draft');" class="<?php echo wp_clean_up_count("draft") > 0 ? "button-primary" : "button"; ?>" <?php echo wp_clean_up_count("draft") == 0 ? "disabled" : "" ?> value="<?php _e("Clean",cleanup_optimizer); ?>" />
						</td>
					</tr>
					<tr>
						<td>
							<input type="checkbox" id="ux_chk_cleanup_4" name="ux_chk_cleanup[]" style="margin:0px"  value="moderated"/>
						</td>
						<td class="column-name">
							Moderated Comments
						</td>
						<td class="column-name">
							<?php echo wp_clean_up_count("moderated"); ?>
						</td>
						<td class="column-name">
							<input type="button" onclick="cleanup_function('moderated');" class="<?php echo wp_clean_up_count("moderated") > 0 ? "button-primary" : "button"; ?>" <?php echo wp_clean_up_count("moderated") == 0 ? "disabled" : "" ?> value="<?php _e("Clean",cleanup_optimizer); ?>" />
						</td>
					</tr>
					<tr class="alternate">
						<td>
							<input type="checkbox" id="ux_chk_cleanup_5" name="ux_chk_cleanup[]" style="margin:0px"  value="commentmeta"/>
						</td>
						<td class="column-name">
							Orphan Comments Meta
						</td>
						<td class="column-name">
							<?php echo wp_clean_up_count("commentmeta"); ?>
						</td>
						<td class="column-name">
							<input type="button" onclick="cleanup_function('commentmeta');" class="<?php echo wp_clean_up_count("commentmeta") > 0 ? "button-primary" : "button"; ?>" <?php echo wp_clean_up_count("commentmeta") == 0 ? "disabled" : "" ?> value="<?php _e("Clean",cleanup_optimizer); ?>" />
						</td>
					</tr>
					<tr>
						<td>
							<input type="checkbox" id="ux_chk_cleanup_6" name="ux_chk_cleanup[]" style="margin:0px" value="postmeta"/>
						</td>
						<td class="column-name">
							Orphan Posts Meta
						</td>
						<td class="column-name">
							<?php echo wp_clean_up_count("postmeta"); ?>
						</td>
						<td class="column-name">
							<input type="button" onclick="cleanup_function('postmeta');" class="<?php echo wp_clean_up_count("postmeta") > 0 ? "button-primary" : "button"; ?>"  <?php echo wp_clean_up_count("postmeta") == 0 ? "disabled" : "" ?> value="<?php _e("Clean",cleanup_optimizer); ?>" />
						</td>
					</tr>
					<tr class="alternate">
						<td>
							<input type="checkbox" id="ux_chk_cleanup_7" name="ux_chk_cleanup[]" style="margin:0px"  value="relationships"/>
						</td>
						<td class="column-name">
							Orphan Relationships
						</td>
						<td class="column-name">
							<?php echo wp_clean_up_count("relationships"); ?>
						</td>
						<td class="column-name">
							<input type="button" onclick="cleanup_function('relationships');" class="<?php echo wp_clean_up_count("relationships") > 0 ? "button-primary" : "button"; ?>" <?php echo wp_clean_up_count("relationships") == 0 ? "disabled" : "" ?> value="<?php _e("Clean",cleanup_optimizer); ?>" />
						</td>
					</tr>
					<tr>
						<td>
							<input type="checkbox" id="ux_chk_cleanup_8" name="ux_chk_cleanup[]" style="margin:0px"  value="revision"/>
						</td>
						<td class="column-name">
							Revision
						</td>
						<td class="column-name">
							<?php echo wp_clean_up_count("revision"); ?>
						</td>
						<td class="column-name">
							<input type="button" onclick="cleanup_function('revision');" class="<?php echo wp_clean_up_count("revision") > 0 ? "button-primary" : "button"; ?>" <?php echo wp_clean_up_count("revision") == 0 ? "disabled" : "" ?> value="<?php _e("Clean",cleanup_optimizer); ?>" />
						</td>
					</tr>
					<tr class="alternate">
						<td>
							<input type="checkbox" id="ux_chk_cleanup_9" name="ux_chk_cleanup[]" style="margin:0px"  value="spam"/>
						</td>
						<td class="column-name">
							Spam Comments
						</td>
						<td class="column-name">
							<?php echo wp_clean_up_count("spam"); ?>
						</td>
						<td class="column-name">
							<input type="button" onclick="cleanup_function('spam');" class="<?php echo wp_clean_up_count("spam") > 0 ? "button-primary" : "button"; ?>" <?php echo wp_clean_up_count("spam") == 0 ? "disabled" : "" ?> value="<?php _e("Clean",cleanup_optimizer); ?>" />
						</td>
					</tr>
					<tr>
						<td>
							<input type="checkbox" id="ux_chk_cleanup_10" name="ux_chk_cleanup[]" style="margin:0px"  value="trash"/>
						</td>
						<td class="column-name">
							Trash Comments
						</td>
						<td class="column-name">
							<?php echo wp_clean_up_count("trash"); ?>
						</td>
						<td class="column-name">
							<input type="button" onclick="cleanup_function('trash');" class="<?php echo wp_clean_up_count("trash") > 0 ? "button-primary" : "button"; ?>" <?php echo wp_clean_up_count("trash") == 0 ? "disabled" : "" ?> value="<?php _e("Clean",cleanup_optimizer); ?>" />
						</td>
					</tr>
				</tbody>
			</table>
			</p>
		</div>
	</form>
	
	<script type="text/javascript">
	
	function cleanup_function(typeClean)
	{
		var confirm_delete =  confirm("<?php _e( "Are you sure, you want to Clean?",cleanup_optimizer ); ?>");
		if(confirm_delete == true)
		{
			jQuery.post(ajaxurl, "typeClean="+typeClean+"&param=wp_cleanup&action=cleanup_library", function(data)
			{
				alert("Successfully Cleaned!");
				window.location.reload();
			});
		}
	}
	
	function bulk_delete()
	{
		if(jQuery("#ux_ddl_bulk_action").val() == 1)
		{
			var confirm_selection =  confirm("<?php _e( "Are you sure, you want to Clean?", cleanup_optimizer ); ?>");
			if(confirm_selection == true)
			{
				jQuery.post(ajaxurl, jQuery("#ux_frm_cleanup").serialize()+"&param=bulk_delete_action&action=cleanup_library", function(data)
				{
					window.location.href = "admin.php?page=wp_optimizer";
				});
			}
		}
		else
		{
			alert("<?php _e( "Please Choose Action First.", cleanup_optimizer ); ?>");
		}
	}
	
	jQuery("#ux_chk_select_all").click(function()
		{
			if(jQuery("#ux_chk_select_all").prop("checked") == true)
			{
				jQuery("input:checkbox[name=\"ux_chk_cleanup[]\"]").attr("checked","checked");
			}
			else
			{
				jQuery("input:checkbox[name=\"ux_chk_cleanup[]\"]").removeAttr("checked","checked");
			}
		});
	jQuery("input:checkbox[name=\"ux_chk_cleanup[]\"]").click(function()
		{
			if(jQuery("#"+this.id).prop("checked") == false)
			{
				jQuery("#ux_chk_select_all").removeAttr("checked","checked");
			}
		});
	</script>
<?php 
}
?>	