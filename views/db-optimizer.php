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
	
?>
<form id="ux_frm_optimizer" class="layout-form" name="ux_frm_optimizer">
	<div class="fluid-layout">
		<div class="layout-span12">
			<select id="ux_ddl_bulk_action" name="ux_ddl_bulk_action" class="bulk-action-width">
				<option value="0"><?php _e("Bulk Action", cleanup_optimizer); ?></option>
				<option value="1"><?php _e("Clean", cleanup_optimizer); ?></option>
				<option value="2"><?php _e("Delete", cleanup_optimizer); ?></option>
				<option value="3"><?php _e("Optimize", cleanup_optimizer); ?></option>
				<option value="4"><?php _e("Repair", cleanup_optimizer); ?></option>
			</select>
			<input type="button" id="ux_btn_action" onclick="bulk_delete();" name="ux_btn_action" class="button-primary apply_btn_align" value="<?php _e("Apply", cleanup_optimizer); ?>" />
			<p>
			<table class="widefat" style="width:1000px;">
				<thead>
					<tr>
						<th style="width:10%;"><input type="checkbox" id="ux_chk_select_all" name="ux_chk_cleanup" style="margin:0px"/></th>	
						<th scope="col"><?php _e("Table",cleanup_optimizer); ?></th>	
						<th scope="col"><?php _e("Total Rows",cleanup_optimizer); ?></th>
						<th scope="col"><?php _e("Size",cleanup_optimizer); ?></th>
						<th scope="col" colspan="5"><?php _e("Action",cleanup_optimizer); ?></th>
					</tr>
				</thead>
				<tbody id="the-list">
					<?php
						global $wpdb;
						$total_size = 0;
						$alternate = " class='alternate'";
						$wcu_sql = 'SHOW TABLE STATUS FROM `'.DB_NAME.'`';
						$result = $wpdb->get_results($wcu_sql);
				
						foreach($result as $row){
				
							$table_size = $row->Data_length + $row->Index_length;
							$table_size = $table_size / 1024;
							$table_size = sprintf("%0.3f",$table_size);
				
							$every_size = $row->Data_length + $row->Index_length;
							$every_size = $every_size / 1024;
							$total_size += $every_size;
							$count_rows=$wpdb->get_var
							(
								"SELECT COUNT(*) FROM $row->Name"
							);
							if($count_rows == 0)
							{
								$show_rows="disabled";
								$tbn_class="button";
							}
							else
							{
								$show_rows="";
								$tbn_class="button-primary";
							}
							echo "<tr". $alternate .">
									<td class=\"column-name\"><input type=\"checkbox\" id=\"ux_chk_cleanup\" name=\"ux_chk_cleanup_arr[]\" value=\"$row->Name\"></td>
									<td class=\"column-name\">". $row->Name ."</td>
									<td class=\"column-name\"  style=\"padding-left:4%\" >".$count_rows."</td>
									<td class=\"column-name\">". $table_size ." KB"."</td>
									<td class=\"column-name\"><input type=\"button\" value=\"Preview\" class=\"button-primary\" style=\"font-size:12px;\" onclick=\"table_preview('$row->Name');\" /></td>
									<td class=\"column-name\"><input type=\"button\" value=\"Clean\" class=\"$tbn_class\" style=\"font-size:12px;\"  onclick=\"truncate_table('$row->Name');\" $show_rows /></td>
									<td class=\"column-name\"><input type=\"button\" value=\"Delete\" class=\"button-primary\" style=\"font-size:12px;\" onclick=\"delete_table('$row->Name');\" /></td>
									<td class=\"column-name\"><input type=\"button\" value=\"Optimize\" class=\"button-primary\" style=\"font-size:12px;\" onclick=\"optimize_table('$row->Name');\" /></td>
									<td class=\"column-name\"><input type=\"button\" value=\"Repair\" class=\"button-primary\" style=\"font-size:12px;\" onclick=\"repair_table('$row->Name');\" /></td>
								</tr>\n";
							$alternate = (empty($alternate)) ? " class='alternate'" : "";
						}
					?>
				</tbody>
				<tfoot>
					<tr>
						<th scope="col"><?php _e('Total',cleanup_optimizer); ?></th>
						<th></th>
						<th></th>
						<th scope="col" style="font-family:Tahoma;" colspan="6"><?php echo sprintf("%0.3f",$total_size).' KB'; ?></th>
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
		
		if(jQuery('#post_back_table').length > 0)
		{
			oTable = jQuery('#post_back_table').dataTable();
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
function bulk_delete()
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
		case 3:
			typeMessage="<?php _e("Optimized Successfully!",cleanup_optimizer); ?>";
			break;
		case 4:
			typeMessage="<?php _e("Repaired Successfully!",cleanup_optimizer); ?>";
			break;
	}
	if(jQuery("#ux_ddl_bulk_action").val() != 0)
	{
		var confirm_delete =  confirm("<?php _e( "Are you sure, you want to Perform this Action?", cleanup_optimizer ); ?>");
		if(confirm_delete == true)
		{
			jQuery.post(ajaxurl, jQuery("#ux_frm_optimizer").serialize()+"&param=bulk_selected_action&action=cleanup_library", function(data)
			{
				alert(typeMessage);
				window.location.href = "admin.php?page=db_optimizer";
			});
		}
	}
	else
	{
		alert("<?php _e( "Please Choose Action First.", cleanup_optimizer ); ?>");
	}
}
function truncate_table(table_name)
{
	var confirm_delete =  confirm("<?php _e( "Are you sure, you want to Clean?", cleanup_optimizer ); ?>");
	if(confirm_delete == true)
	{
		jQuery.post(ajaxurl, "table_name="+table_name+"&param=truncate_table&action=cleanup_library", function(data)
		{
			window.location.reload();
		});
	}
}
function delete_table(table_name)
{

	var confirm_delete =  confirm("<?php _e( "Are you sure, you want to Delete?", cleanup_optimizer ); ?>");
	if(confirm_delete == true)
	{
		jQuery.post(ajaxurl, "table_name="+table_name+"&param=delete_table&action=cleanup_library", function(data)
		{
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
function optimize_table(table_name)
{
	var confirm_delete =  confirm("<?php _e( "Are you sure, you want to Optimize?", cleanup_optimizer ); ?>");
	if(confirm_delete == true)
	{
		jQuery.post(ajaxurl, "table_name="+table_name+"&param=optimize_table&action=cleanup_library", function(data)
		{
			window.location.reload();
		});
	}
}
function repair_table(table_name)
{
	var confirm_delete =  confirm("<?php _e( "Are you sure, you want to Repair?", cleanup_optimizer ); ?>");
	if(confirm_delete == true)
	{
		jQuery.post(ajaxurl, "table_name="+table_name+"&param=repair_table&action=cleanup_library", function(data)
		{
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