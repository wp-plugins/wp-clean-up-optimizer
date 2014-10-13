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
	global $wpdb;
	function wp_clean_up_optimizer_count($type)
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
				
			case "remove_pingbacks":
				$count=$wpdb->get_var
				(
					"SELECT COUNT(*) FROM $wpdb->comments WHERE comment_type = 'pingback'"
				);
				break;
				
			case "remove_transient_options":
				$count=$wpdb->get_var
				(
					"SELECT COUNT(*) FROM $wpdb->options WHERE option_name LIKE '_transient_%' OR option_name LIKE '_site_transient_%'"
				);
				break;
				
			case "remove_trackbacks":
				$count=$wpdb->get_var
				(
					"SELECT COUNT(*) FROM $wpdb->comments WHERE comment_type = 'trackback'"
				);
				break;
		}
		return $count;
	}
	$trackbacks_status=$wpdb->get_var
	(
		"SELECT ping_status FROM `$wpdb->posts` WHERE post_status = 'publish' AND post_type = 'post'"
	);
	
	$comments_status=$wpdb->get_var
	(
			"SELECT comment_status FROM `$wpdb->posts` WHERE post_status = 'publish' AND post_type = 'post'"
	);
?>
	<form id="ux_frm_cleanup" name="ux_frm_cleanup" class="layout-form" style="width:1000px">
		<div class="fluid-layout">
			<div class="layout-span12 responsive">
				<div class="widget-layout background-none">
					<div class="widget-layout-title">
						<h4><?php _e("WP Data Optimizer", cleanup_optimizer); ?></h4>
					</div>
					<div class="widget-layout-body">
						<div class="layout-span6 responsive">
							<div class="widget-layout">
								<div class="widget-layout-title">
									<h4><?php _e("Database Information", cleanup_optimizer); ?></h4>
								</div>
								<div class="widget-layout-body ">
									<div class="layout-control-group"> 
										<label class="layout-control-label"><?php _e("Database Host ", cleanup_optimizer); ?> : </label>
										<div class="layout-controls wpcpo-label-system-status">
											<?php echo DB_HOST;?>
										</div>
									</div>
									<div class="layout-control-group"> 
										<label class="layout-control-label"><?php _e("Database Name ", cleanup_optimizer); ?> : </label>
										<div class="layout-controls wpcpo-label-system-status">
											<?php echo DB_NAME;?>
										</div>
									</div>
									<div class="layout-control-group"> 
										<label class="layout-control-label"><?php _e("Database User ", cleanup_optimizer); ?> : </label>
										<div class="layout-controls wpcpo-label-system-status">
											<?php echo DB_USER;?>
										</div>
									</div>
									<div class="layout-control-group"> 
										<label class="layout-control-label"><?php _e("Database Type ", cleanup_optimizer); ?> : </label>
										<div class="layout-controls wpcpo-label-system-status">
											<?php 
												echo "MYSQL"; 
											?>
										</div>
									</div>
									<div class="layout-control-group"> 
										<label class="layout-control-label"><?php _e("Database Version", cleanup_optimizer); ?> : </label>
										<div class="layout-controls wpcpo-label-system-status">
											<?php 
												echo "v".$wpdb->db_version()." - ".PHP_OS;
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="layout-span6 responsive">
							<div class="widget-layout">
								<div class="widget-layout-title">
									<h4><?php _e("Manage Trackbacks / Comments", cleanup_optimizer); ?></h4>
								</div>
								<div class="widget-layout-body">
									<div class="layout-control-group"> 
										<label class="layout-control-label"><?php _e("Trackbacks", cleanup_optimizer); ?> : </label>
										<div class="layout-controls wpcpo-label-system-status">
											<?php 
												if($trackbacks_status == "open")
												{
													?>
														<input type="radio" id="ux_rdl_tackbacks_on" name="ux_rdl_trackbacks" onclick="wpcpo_trackbacks_action();" checked="checked" value="1"><?php echo _e("Enable",cleanup_optimizer)?>
														<input type="radio" id="ux_rdl_tackbacks_off" name="ux_rdl_trackbacks" onclick="wpcpo_trackbacks_action();" value="0"/><?php echo _e("Disable",cleanup_optimizer)?>
													<?php 
												}
												else
												{
													?>
														<input type="radio" id="ux_rdl_tackbacks_on" name="ux_rdl_trackbacks" onclick="wpcpo_trackbacks_action();" value="1"><?php echo _e("Enable",cleanup_optimizer)?>
														<input type="radio" id="ux_rdl_tackbacks_off" name="ux_rdl_trackbacks" onclick="wpcpo_trackbacks_action();" checked="checked" value="0"/><?php echo _e("Disable",cleanup_optimizer)?>
													<?php 
												}
											?>
										</div>
									</div>
									<div class="layout-control-group"> 
										<label class="layout-control-label"><?php _e("Comments", cleanup_optimizer); ?> : </label>
										<div class="layout-controls wpcpo-label-system-status">
											<?php 
												if($comments_status == "open")
												{
													?>
														<input type="radio" id="ux_rdl_comments_on" name="ux_rdl_comments_action" onclick="wpcpo_comments_action();" checked="checked" value="1"><?php echo _e("Enable",cleanup_optimizer)?>
														<input type="radio" id="ux_rdl_comments_off" name="ux_rdl_comments_action" onclick="wpcpo_comments_action();" value="0"/><?php echo _e("Disable",cleanup_optimizer)?>
													<?php 
												}
												else
												{
													?>
														<input type="radio" id="ux_rdl_comments_on" name="ux_rdl_comments_action" onclick="wpcpo_comments_action();" value="1"><?php echo _e("Enable",cleanup_optimizer)?>
														<input type="radio" id="ux_rdl_comments_off" name="ux_rdl_comments_action" onclick="wpcpo_comments_action();" checked="checked" value="0"/><?php echo _e("Disable",cleanup_optimizer)?>
													<?php 
												}
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="fluid-layout">
							<div class="layout-span12 responsive">
								<div class="layout-control-group">
									<select id="ux_ddl_bulk_action" name="ux_ddl_bulk_action" style="vertical-align:top">
										<option value="0"><?php _e("Bulk Action", cleanup_optimizer); ?></option>
										<option value="1"><?php _e("Clean", cleanup_optimizer); ?></option>
									</select>
									<input type="button" id="ux_btn_action" onclick="bulk_delete();" name="ux_btn_action" class="button-primary apply_btn_align"  value="<?php _e("Apply", cleanup_optimizer); ?>" />
								</div>
								<table class="widefat" style="background-color:#fff !important">
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
												<input type="checkbox" id="ux_chk_cleanup_1" name="ux_chk_cleanup[]" style="margin:0px" value="1" />
											</td>
											<td class="column-name">
												Auto Draft 
											</td>
											<td class="column-name">
												<?php echo wp_clean_up_optimizer_count("autodraft"); ?>
											</td>
											<td class="column-name">
												<input type="button" onclick="cleanup_function(1);" class="<?php echo wp_clean_up_optimizer_count("autodraft") > 0  ? "button-primary" : "button"; ?>" <?php echo wp_clean_up_optimizer_count("autodraft") == 0 ? "disabled" : "" ?> value="<?php _e("Clean",cleanup_optimizer); ?>" />
											</td>
										</tr>
										<tr>
											<td>
												<input type="checkbox" id="ux_chk_cleanup_2" name="ux_chk_cleanup[]" style="margin:0px"  value="2" />
											</td>
											<td class="column-name">
												Dashboard Transient Feed
											</td>
											<td class="column-name">
												<?php echo wp_clean_up_optimizer_count("feed"); ?>
											</td>
											<td class="column-name">
												<input type="button" onclick="cleanup_function(2);" class="<?php echo wp_clean_up_optimizer_count("feed") > 0 ? "button-primary" : "button"; ?>" <?php echo wp_clean_up_optimizer_count("feed") == 0 ? "disabled" : "" ?> value="<?php _e("Clean",cleanup_optimizer); ?>" />
											</td>
										</tr>
										<tr class="alternate">
											<td>
												<input type="checkbox" id="ux_chk_cleanup_3" name="ux_chk_cleanup[]" style="margin:0px"  value="3" />
											</td>
											<td class="column-name">
												Draft
											</td>
											<td class="column-name">
												<?php echo wp_clean_up_optimizer_count("draft"); ?>
											</td>
											<td class="column-name">
												<input type="button" onclick="cleanup_function(3);" class="<?php echo wp_clean_up_optimizer_count("draft") > 0 ? "button-primary" : "button"; ?>" <?php echo wp_clean_up_optimizer_count("draft") == 0 ? "disabled" : "" ?> value="<?php _e("Clean",cleanup_optimizer); ?>" />
											</td>
										</tr>
										<tr>
											<td>
												<input type="checkbox" id="ux_chk_cleanup_4" name="ux_chk_cleanup[]" style="margin:0px"  value="4" />
											</td>
											<td class="column-name">
												Moderated Comments
											</td>
											<td class="column-name">
												<?php echo wp_clean_up_optimizer_count("moderated"); ?>
											</td>
											<td class="column-name">
												<input type="button" onclick="cleanup_function(4);" class="<?php echo wp_clean_up_optimizer_count("moderated") > 0 ? "button-primary" : "button"; ?>" <?php echo wp_clean_up_optimizer_count("moderated") == 0 ? "disabled" : "" ?> value="<?php _e("Clean",cleanup_optimizer); ?>" />
											</td>
										</tr>
										<tr class="alternate">
											<td>
												<input type="checkbox" id="ux_chk_cleanup_5" name="ux_chk_cleanup[]" style="margin:0px"  value="5" />
											</td>
											<td class="column-name">
												Orphan Comments Meta
											</td>
											<td class="column-name">
												<?php echo wp_clean_up_optimizer_count("commentmeta"); ?>
											</td>
											<td class="column-name">
												<input type="button" onclick="cleanup_function(5);" class="<?php echo wp_clean_up_optimizer_count("commentmeta") > 0 ? "button-primary" : "button"; ?>" <?php echo wp_clean_up_optimizer_count("commentmeta") == 0 ? "disabled" : "" ?> value="<?php _e("Clean",cleanup_optimizer); ?>" />
											</td>
										</tr>
										<tr>
											<td>
												<input type="checkbox" id="ux_chk_cleanup_6" name="ux_chk_cleanup[]" style="margin:0px" value="6" />
											</td>
											<td class="column-name">
												Orphan Posts Meta
											</td>
											<td class="column-name">
												<?php echo wp_clean_up_optimizer_count("postmeta"); ?>
											</td>
											<td class="column-name">
												<input type="button" onclick="cleanup_function(6);" class="<?php echo wp_clean_up_optimizer_count("postmeta") > 0 ? "button-primary" : "button"; ?>"  <?php echo wp_clean_up_optimizer_count("postmeta") == 0 ? "disabled" : "" ?> value="<?php _e("Clean",cleanup_optimizer); ?>" />
											</td>
										</tr>
										<tr class="alternate">
											<td>
												<input type="checkbox" id="ux_chk_cleanup_7" name="ux_chk_cleanup[]" style="margin:0px"  value="7" />
											</td>
											<td class="column-name">
												Orphan Relationships
											</td>
											<td class="column-name">
												<?php echo wp_clean_up_optimizer_count("relationships"); ?>
											</td>
											<td class="column-name">
												<input type="button" onclick="cleanup_function(7);" class="<?php echo wp_clean_up_optimizer_count("relationships") > 0 ? "button-primary" : "button"; ?>" <?php echo wp_clean_up_optimizer_count("relationships") == 0 ? "disabled" : "" ?> value="<?php _e("Clean",cleanup_optimizer); ?>" />
											</td>
										</tr>
										<tr>
											<td>
												<input type="checkbox" id="ux_chk_cleanup_8" name="ux_chk_cleanup[]" style="margin:0px"  value="8" />
											</td>
											<td class="column-name">
												Revision
											</td>
											<td class="column-name">
												<?php echo wp_clean_up_optimizer_count("revision"); ?>
											</td>
											<td class="column-name">
												<input type="button" onclick="cleanup_function(8);" class="<?php echo wp_clean_up_optimizer_count("revision") > 0 ? "button-primary" : "button"; ?>" <?php echo wp_clean_up_optimizer_count("revision") == 0 ? "disabled" : "" ?> value="<?php _e("Clean",cleanup_optimizer); ?>" />
											</td>
										</tr>
										<tr class="alternate">
											<td>
												<input type="checkbox" id="ux_chk_cleanup_9" name="ux_chk_cleanup[]" style="margin:0px"  value="9" />
											</td>
											<td class="column-name">
												Remove Pingbacks
											</td>
											<td class="column-name">
												<?php echo wp_clean_up_optimizer_count("remove_pingbacks"); ?>
											</td>
											<td class="column-name">
												<input type="button" onclick="cleanup_function(9);" class="<?php echo wp_clean_up_optimizer_count("remove_pingbacks") > 0 ? "button-primary" : "button"; ?>" <?php echo wp_clean_up_optimizer_count("remove_pingbacks") == 0 ? "disabled" : "" ?> value="<?php _e("Clean",cleanup_optimizer); ?>" />
											</td>
										</tr>
										<tr>
											<td>
												<input type="checkbox" id="ux_chk_cleanup_10" name="ux_chk_cleanup[]" style="margin:0px"  value="10" />
											</td>
											<td class="column-name">
												Remove Transient Options 
											</td>
											<td class="column-name">
												<?php echo wp_clean_up_optimizer_count("remove_transient_options"); ?>
											</td>
											<td class="column-name">
												<input type="button" onclick="cleanup_function(10);" class="<?php echo wp_clean_up_optimizer_count("remove_transient_options") > 0 ? "button-primary" : "button"; ?>" <?php echo wp_clean_up_optimizer_count("remove_transient_options") == 0 ? "disabled" : "" ?> value="<?php _e("Clean",cleanup_optimizer); ?>" />
											</td>
										</tr>
										<tr class="alternate">
											<td>
												<input type="checkbox" id="ux_chk_cleanup_11" name="ux_chk_cleanup[]" style="margin:0px"  value="11" />
											</td>
											<td class="column-name">
												Remove Trackbacks 
											</td>
											<td class="column-name">
												<?php echo wp_clean_up_optimizer_count("remove_trackbacks"); ?>
											</td>
											<td class="column-name">
												<input type="button" onclick="cleanup_function(11);" class="<?php echo wp_clean_up_optimizer_count("remove_trackbacks") > 0 ? "button-primary" : "button"; ?>" <?php echo wp_clean_up_optimizer_count("remove_trackbacks") == 0 ? "disabled" : "" ?> value="<?php _e("Clean",cleanup_optimizer); ?>" />
											</td>
										</tr>
										<tr>
											<td>
												<input type="checkbox" id="ux_chk_cleanup_12" name="ux_chk_cleanup[]" style="margin:0px"  value="12" />
											</td>
											<td class="column-name">
												Spam Comments
											</td>
											<td class="column-name">
												<?php echo wp_clean_up_optimizer_count("spam"); ?>
											</td>
											<td class="column-name">
												<input type="button" onclick="cleanup_function(12);" class="<?php echo wp_clean_up_optimizer_count("spam") > 0 ? "button-primary" : "button"; ?>" <?php echo wp_clean_up_optimizer_count("spam") == 0 ? "disabled" : "" ?> value="<?php _e("Clean",cleanup_optimizer); ?>" />
											</td>
										</tr>
										<tr class="alternate">
											<td>
												<input type="checkbox" id="ux_chk_cleanup_13" name="ux_chk_cleanup[]" style="margin:0px"  value="13" />
											</td>
											<td class="column-name">
												Trash Comments
											</td>
											<td class="column-name">
												<?php echo wp_clean_up_optimizer_count("trash"); ?>
											</td>
											<td class="column-name">
												<input type="button" onclick="cleanup_function(13);" class="<?php echo wp_clean_up_optimizer_count("trash") > 0 ? "button-primary" : "button"; ?>" <?php echo wp_clean_up_optimizer_count("trash") == 0 ? "disabled" : "" ?> value="<?php _e("Clean",cleanup_optimizer); ?>" />
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
	
	<script type="text/javascript">

		function wpcpo_trackbacks_action()
		{
			var trackbacks=jQuery("#ux_rdl_tackbacks_on").prop("checked");
			if(trackbacks == true)
			{
				var enable_trackbacks=jQuery("#ux_rdl_tackbacks_on").val();
				jQuery.post(ajaxurl, "enable_trackbacks="+enable_trackbacks+"&param=trackbacks&action=cleanup_library", function(data)
				{
				});
			}
			else
			{
				var disable_trackbacks=jQuery("#ux_rdl_tackbacks_off").val();
				jQuery.post(ajaxurl, "disable_trackbacks="+disable_trackbacks+"&param=trackbacks&action=cleanup_library", function(data)
				{
				});
			}
		}
		function wpcpo_comments_action()
		{
			var enable_comments=jQuery("#ux_rdl_comments_on").prop("checked");
			if(enable_comments == true)
			{
				var enable_comments=jQuery("#ux_rdl_comments_on").val();
				jQuery.post(ajaxurl, "enable_comments="+enable_comments+"&param=comments&action=cleanup_library", function(data)
				{
				});
			}
			else
			{
				var disable_comments=jQuery("#ux_rdl_comments_off").val();
				jQuery.post(ajaxurl, "disable_comments="+disable_comments+"&param=comments&action=cleanup_library", function(data)
				{
				});
			}
		}
		
		function cleanup_function(typeClean)
		{
			var confirm_delete =  confirm("<?php _e( "Are you sure, you want to Clean?",cleanup_optimizer ); ?>");
			if(confirm_delete == true)
			{
				jQuery("body").css("opacity",".5");
			 	var overlay = jQuery("<div class=\"processing_overlay\"></div>");
			 	jQuery("body").append(overlay);
			 	
				jQuery.post(ajaxurl, "typeClean="+typeClean+"&param=wp_cleanup&action=cleanup_library", function(data)
				{
					jQuery(".processing_overlay").remove();
					jQuery("body").css("opacity","1");
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
					jQuery("body").css("opacity",".5");
				 	var overlay = jQuery("<div class=\"processing_overlay\"></div>");
				 	jQuery("body").append(overlay);
				 	
					jQuery.post(ajaxurl, jQuery("#ux_frm_cleanup").serialize()+"&param=bulk_delete_action&action=cleanup_library", function(data)
					{
						jQuery(".processing_overlay").remove();
						jQuery("body").css("opacity","1");
						window.location.href = "admin.php?page=wp_optimizer";
					});
				}
			}
			else
			{
				alert("<?php _e( "Please choose Action to Proceed!", cleanup_optimizer ); ?>");
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