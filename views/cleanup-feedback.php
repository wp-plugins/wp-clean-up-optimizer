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
	?>
	<div class="custom-message green" style="display: block;margin-top:30px;max-width:963px;">
		<div style="padding: 4px 0;">
			<p style="font:12px/1.0em Arial !important;font-weight:bold;">If you have any Feature Request which you would like to have in your plugin, please fill in the below form. We assure you that soon this will be taken care off!</p>
		</div>
	</div>
	<form id="frm_feedback" class="layout-form" style = "max-width:1000px;">
		<div class="fluid-layout">
			<div class="layout-span12">
				<div class="widget-layout">
					<div class="widget-layout-title">
						<h4>
							<?php _e("Feature Requests", cleanup_optimizer); ?>
						</h4>
					</div>
					<div class="widget-layout-body">
						<a class="btn btn-inverse" href="admin.php?page=cpo_dashboard"><?php _e("Back to Dashboard", cleanup_optimizer); ?></a>
						<div class="separator-doubled" style="margin-top:20px;"></div> 
						<div class="fluid-layout">
							<div class="layout-span12 responsive">
								<div class="widget-layout">
									<div class="widget-layout-title">
										<h4><?php _e("Feature Requests / Suggestions", cleanup_optimizer); ?></h4>
									</div>
									<div class="widget-layout-body">
										<div class="layout-control-group">
											<label class="layout-control-label"><?php _e("Name", cleanup_optimizer); ?> : <span class="error">*</span></label>
											<div class="layout-controls">
												<input type="text" class="layout-span12" name="ux_name" id="ux_name" placeholder="<?php _e("Enter your Name", cleanup_optimizer); ?>"/>
											</div>
										</div>
										<div class="layout-control-group">
											<label class="layout-control-label"><?php _e("Email Id", cleanup_optimizer); ?> : <span class="error">*</span></label>
											<div class="layout-controls">
												<input type="text" class="layout-span12" name="ux_email" id="ux_email" placeholder="<?php _e("Enter your Email Address", cleanup_optimizer); ?>"/>
											</div>
										</div>
										<div class="layout-control-group">
											<label class="layout-control-label"><?php _e("Feature Requests / Suggestions", cleanup_optimizer); ?> : <span class="error">*</span></label>
											<div class="layout-controls">
												<textarea rows="5" class="layout-span12" name="ux_suggestion" id="ux_suggestion" placeholder="<?php _e("Enter your Feature Requests / Suggestions", cleanup_optimizer); ?>"></textarea>
											</div>
										</div>
										<div class="layout-control-group">
											<div class="layout-controls">
												<button type="submit" class="btn btn-danger"><?php _e("Send", cleanup_optimizer); ?></button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
	<script type="text/javascript">
	
		var url = "<?php echo get_option("tech-banker-updation-check-url");?>";
		var suggestion_array = [];
		jQuery("#frm_feedback").validate
		({
			rules:
			{
				ux_name : 
				{
					required: true
				},
				ux_email:
				{
					required: true,
					email: true
				},
				ux_suggestion:
				{
					required: true
				}
			},
			submitHandler: function()
			{
				var overlay_opacity = jQuery("<div class=\"opacity_overlay\"></div>");
				jQuery("body").append(overlay_opacity);
				var overlay = jQuery("<div class=\"loader_opacity\"><div class=\"processing_overlay\"></div></div>");
				jQuery("body").append(overlay);
				suggestion_array.push(jQuery("#ux_name").val());
				suggestion_array.push(jQuery("#ux_email").val());
				suggestion_array.push(jQuery("#ux_suggestion").val());
				jQuery.post(url,
				{
					data : JSON.stringify(suggestion_array),
					param: "cleanup_feedbacks",
					action: "feedbacks"
				},
				function (data)
				{
					setTimeout(function () {
						jQuery(".loader_opacity").remove();
						jQuery(".opacity_overlay").remove();
						window.location.href = "admin.php?page=cpo_feedback";
					}, 2000);
				});
			}
		});
	</script>
	<?php
}
?>