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
	
	function wpcpo_format_size($rawSize) {
		if($rawSize / 1073741824 > 1)
			return number_format_i18n($rawSize/1073741824, 2) . ' '.__('GB', 'wp-optimize');
		else if ($rawSize / 1048576 > 1)
			return number_format_i18n($rawSize/1048576, 1) . ' '.__('MB', 'wp-optimize');
		else if ($rawSize / 1024 > 1)
			return number_format_i18n($rawSize/1024, 1) . ' '.__('KB', 'wp-optimize');
		else
			return number_format_i18n($rawSize, 0) . ' '.__('bytes', 'wp-optimize');
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
	<form id="ux_frm_optimizer" class="layout-form" name="ux_frm_optimizer" style="width:1000px;">
		<div class="fluid-layout">
			<div class="layout-span12 responsive">
				<div class="widget-layout background-none">
					<div class="widget-layout-title">
						<h4><?php _e("Database Optimizer", cleanup_optimizer); ?></h4>
					</div>
					<div class="framework_message red custom_icon_red" style="display: block;">
						<span>
							<strong  style="line-height: 2em;"><?php _e("Note : Table Names highlighted with red color and an asterisk (*) are wordpress inbuilt Tables. <br/> They are disabled by us  so not to perform delete and clean action because they can destroy your Wordpress unintentionally.", cleanup_optimizer); ?></strong>
						</span>
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
									<select id="ux_ddl_bulk_action" name="ux_ddl_bulk_action" style="vertical-align:top;">
										<option value="0"><?php _e("Bulk Action", cleanup_optimizer); ?></option>
										<option value="1"><?php _e("Clean", cleanup_optimizer); ?></option>
										<option value="2"><?php _e("Delete", cleanup_optimizer); ?></option>
									</select>
									<input type="button" id="ux_btn_action" onclick="bulk_action();" name="ux_btn_action" class="button-primary apply_btn_align" value="<?php _e("Apply", cleanup_optimizer); ?>" />
								</div>
								<table class="widefat" style="background-color:#fff !important;" id="ux_preview_table">
									<thead>
										<tr class="alternate">
											<th><input type="checkbox" id="ux_chk_select_all" name="ux_chk_cleanup" style="margin:0px;"/></th>	
											<th scope="col" style="width:71%"><?php _e("Table",cleanup_optimizer); ?></th>	
											<th scope="col" style="width:7%"><?php _e("Rows",cleanup_optimizer); ?></th>
											<th scope="col" style="width:10%"><?php _e("Type",cleanup_optimizer); ?></th>
											<th scope="col"  style="width:12%"><?php _e("Size",cleanup_optimizer); ?></th>
											<th scope="col" colspan="5"><?php _e("Action",cleanup_optimizer); ?></th>
										</tr>
									</thead>
									<tbody id="the-list">
										<?php
											global $wpdb;
											$total_size = 0;
											$alternate = " class='alternate'";
											$wcpo_sql = "SHOW TABLE STATUS FROM `".DB_NAME."`";
											$result = $wpdb->get_results($wcpo_sql);
									
											foreach($result as $row){
												$table_size = $row->Data_length + $row->Index_length;
												$table_size = $table_size / 1024;
												$table_size = sprintf("%0.3f",$table_size);
												$increment=0;
									
												$every_size = $row->Data_length + $row->Index_length;
												$every_size = $every_size / 1024;
												$total_size += $every_size;
												$count_rows=$wpdb->get_var
												(
													"SELECT COUNT(*) FROM $row->Name"
												);
												$alternate = (empty($alternate)) ? " class='alternate'" : "";
												$tables=$row->Name;
												if((strstr($tables,"users") || strstr($tables,"usermeta") || strstr($tables,"term_taxonomy") || strstr($tables,"term_relationships") || strstr($tables,"terms") 
													|| strstr($tables,"posts") || strstr($tables,"postmeta")|| strstr($tables,"options") || strstr($tables,"links") || strstr($tables,"comments") || strstr($tables,"commentmeta") ) == true)
												{
													echo "<tr". $alternate .">
													<td class=\"column-name\"></td>
													<td class=\"column-name\"><a href=\"#ux_preview_table\" style=\"font-size:13px;color:#FF0000 !important;\" onclick=\"table_preview('$row->Name');\" >".$row->Name."*"."</a></td>
													<td class=\"column-name\">".$count_rows."</td>
													<td class=\"column-name\">". $row->Engine ."</td>
													<td class=\"column-name\">". sprintf("%0.1f",$table_size) ." KB"."</td>
													<td class=\"column-name\"><input type=\"button\"  value=\"Clean\" disabled=\"disabled\" class=\"button\" style=\"font-size:11px;\"  onclick=\"truncate_table('$row->Name');\" ></td>
													<td class=\"column-name\" colspan=\"4\"><input type=\"button\" value=\"Delete\" disabled=\"disabled\" class=\"button\" style=\"font-size:11px;\" ></td>
									
													</tr>\n";
													
												}
												else
												{
													if($count_rows == 0)
													{
														$show_rows="disabled";
														$btn_class="button";
													}
													else
													{
														$show_rows="";
														$btn_class="button-primary";
													}
														
													echo "<tr". $alternate .">
													<td class=\"column-name\"><input type=\"checkbox\" id=\"ux_chk_cleanup\" name=\"ux_chk_cleanup_arr[]\" value=\"$row->Name\"></td>
													<td class=\"column-name\"><a href=\"#ux_preview_table\" style=\"font-size:13px;\" onclick=\"table_preview('$row->Name');\" >".$row->Name."</a></td>
													<td class=\"column-name\">".$count_rows."</td>
													<td class=\"column-name\">". $row->Engine ."</td>
													<td class=\"column-name\">". sprintf("%0.1f",$table_size) ." KB"."</td>
													<td class=\"column-name\"><input type=\"button\" value=\"Clean\" class=\"$btn_class\" style=\"font-size:11px;\" onclick=\"truncate_table('$row->Name');\" $show_rows></td>
													<td class=\"column-name\" colspan=\"4\"><input type=\"button\" value=\"Delete\" class=\"button-primary\" onclick=\"delete_table('$row->Name');\" style=\"font-size:11px;\"  ></td>
														
													</tr>\n";
													
												}
											}
										?>
									</tbody>
									<tfoot>
										<tr style="border-top:1px solid #efefef;">
											<td scope="col"><strong><?php _e("Total",cleanup_optimizer); ?></strong></td>
											<td></td>
											<td></td>
											<td></td>
											<td scope="col" style="font-family:Tahoma;" colspan="6"><strong><?php echo sprintf("%0.1f",$total_size)." KB"; ?></strong></td>
										</tr>
									</tfoot>
								</table>
								<div  class="widget-layout-body" style="border-bottom: none;">
									<div class="white_content" id="setting_controls_postback">
										<div id="post_back_div" class="postback-div">
										</div>
									</div>
								</div>
								<div class="black_overlay"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>	
	<script type="text/javascript">
	jQuery(document).ready(function()
	{
		jQuery(window).resize(function()
		{
			var windowHeight =  window.innerHeight - 200;
			var windowWidth =  window.innerWidth - 200;
			var lightboxHeight = jQuery("#setting_controls_postback").height();
			var lightboxWidth = jQuery("#setting_controls_postback").width();
			var proposedTop =  (window.innerHeight - lightboxHeight - 40) / 2 ;
			var proposedLeft =  (window.innerWidth - lightboxWidth - 40) / 2 ;
			jQuery("#setting_controls_postback").css("top",proposedTop + "px");
			jQuery("#setting_controls_postback").css("left",proposedLeft + "px");
		});
	});
	
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
	
	function show_Popup()
	{
		jQuery(".black_overlay").css("display","block");
		jQuery(".white_content").css("display","block");
		var windowHeight =  window.innerHeight - 200;
		var windowWidth =  window.innerWidth - 200;
		var anchor = jQuery("<a class=\"closeButtonLightbox\" onclick=\"CloseLightbox();\"></a>");
		jQuery("#setting_controls_postback").append(anchor);
		var lightboxHeight = jQuery("#setting_controls_postback").height();
		var lightboxWidth = jQuery("#setting_controls_postback").width();
		var proposedTop =  (window.innerHeight - lightboxHeight - 40) / 2 ;
		var proposedLeft =  (window.innerWidth - lightboxWidth - 40) / 2 ;
		jQuery("#setting_controls_postback").css("top",proposedTop + "px");
		jQuery("#setting_controls_postback").css("left",proposedLeft + "px");
		jQuery("#setting_controls_postback").fadeIn(200);
	}
	
	function CloseLightbox()
	{
		jQuery("#setting_controls_postback").css("display","none");
		jQuery(".black_overlay").css("display","none");
		jQuery("#fade").fadeOut(200);
	}
	
	function table_preview(tbl_name)
	{
		jQuery.post(ajaxurl, "tbl_name="+tbl_name+"&param=preview_tbl&action=cleanup_library", function(data)
		{
			
			if(jQuery("#post_back_table").length > 0)
			{
				oTable = jQuery("#post_back_table").dataTable();
				oTable.fnDestroy();
				jQuery("#post_back_div").empty();
				jQuery("#post_back_div").append(data);
				oTable.fnDraw();
			}
			else
			{
				jQuery("#post_back_div").append(data);
			}
			show_Popup();
			
		});
	}	

	function delete_table(table_name)
	{
	
		var confirm_delete =  confirm("<?php _e( "Are you sure, you want to Delete?", cleanup_optimizer ); ?>");
		if(confirm_delete == true)
		{
			jQuery("body").css("opacity",".5");
		 	var overlay = jQuery("<div class=\"processing_overlay\"></div>");
		 	jQuery("body").append(overlay);
		 	
			jQuery.post(ajaxurl, "table_name="+table_name+"&param=delete_table&action=cleanup_library", function(data)
			{
				jQuery("#form_success_message").css("display","none");
				jQuery(".processing_overlay").remove();
				jQuery("body").css("opacity","1");
				window.location.reload();
			});
		}
	}
	
	function bulk_action()
	{
		var bulk_type=jQuery("#ux_ddl_bulk_action").val();
		var typeMessage="";
		switch(parseInt(bulk_type))
		{
			case 1:
				typeMessage="<?php _e("Cleaned Successfully!",cleanup_optimizer); ?>";
				break;
			case 2:
				typeMessage="<?php _e("Deleted Successfully!",cleanup_optimizer); ?>";
				break;
		}
		
		chk_tables_array = [];
		var searchIDs = jQuery("#ux_frm_optimizer input:checkbox:checked").map(function()
		{
			chk_tables_array.push(jQuery(this).val());
		}).get();
		if(chk_tables_array != "" && jQuery("#ux_ddl_bulk_action").val() != 0)
		{
			var confirm_delete =  confirm("<?php _e( "Are you sure, you want to Perform this Action?", cleanup_optimizer ); ?>");
			if(confirm_delete == true)
			{
				jQuery("body").css("opacity",".5");
			 	var overlay = jQuery("<div class=\"processing_overlay\"></div>");
			 	jQuery("body").append(overlay);
			 	
				jQuery.post(ajaxurl, jQuery("#ux_frm_optimizer").serialize()+"&param=bulk_selected_action&action=cleanup_library", function(data)
				{
					jQuery(".processing_overlay").remove();
					jQuery("body").css("opacity","1");
					alert(typeMessage);
					window.location.reload();
				});
			}
		}
		else
		{
			alert("<?php _e( "Please choose Action or Table to proceed!.", cleanup_optimizer ); ?>");
		}
	}
	
	function truncate_table(table_name)
	{
		var confirm_delete =  confirm("<?php _e( "Are you sure, you want to Clean?", cleanup_optimizer ); ?>");
		if(confirm_delete == true)
		{
			jQuery("body").css("opacity",".5");
		 	var overlay = jQuery("<div class=\"processing\"></div>");
		 	jQuery("body").append(overlay);
		 	
			jQuery.post(ajaxurl, "table_name="+table_name+"&param=truncate_table&action=cleanup_library", function(data)
			{
				jQuery(".processing").remove();
				jQuery("body").css("opacity","1");
				window.location.reload();
			});
		}
	}
	
	function preview_table(table_name)
	{
		jQuery.post(ajaxurl, "table_name="+table_name+"&param=preview_table&action=cleanup_library", function(data)
		{
			window.location.reload();
		});	
	}
	
	function repair_table(table_name)
	{
		var confirm_delete =  confirm("<?php _e( "Are you sure, you want to Repair?", cleanup_optimizer ); ?>");
		if(confirm_delete == true)
		{
			jQuery("body").css("opacity",".5");
		 	var overlay = jQuery("<div class=\"processing_overlay\"></div>");
		 	jQuery("body").append(overlay);
		 	
			jQuery.post(ajaxurl, "table_name="+table_name+"&param=repair_table&action=cleanup_library", function(data)
			{
				jQuery(".processing_overlay").remove();
				jQuery("body").css("opacity","1");
				window.location.reload();
			});
		}
	}
	
	jQuery("#ux_chk_select_all").click(function()
	{
		if(jQuery("#ux_chk_select_all").prop("checked") == true)
		{
			jQuery("input:checkbox[name=\"ux_chk_cleanup_arr[]\"]").attr("checked","checked");
		}
		else
		{
			jQuery("input:checkbox[name=\"ux_chk_cleanup_arr[]\"]").removeAttr("checked","checked");
		}
	});
	
	jQuery("input:checkbox[name=\"ux_chk_cleanup_arr[]\"]").click(function()
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