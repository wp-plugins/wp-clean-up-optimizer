<?php 
global $wpdb,$current_user,$user_role_permission;
$cpo_role = $wpdb->prefix . "capabilities";
$current_user->role = array_keys($current_user->$cpo_role);
$cpo_role = $current_user->role[0];

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
	<div id="welcome-panel" class="welcome-panel" style="width:1000px;padding:0px !important;background-color: #f9f9f9 !important">
		<div class="welcome-panel-content">
			<img src="<?php echo plugins_url("/assets/images/icons/wp-clean-up-optimizer-logo.png" , dirname(__FILE__))?>" style="margin-top:10px;"></img>
			<div class="welcome-panel-column-container">
				<div class="welcome-panel-column" style="width:240px !important;">
					<h4 class="welcome-screen-margin">
						<?php _e("Get Started", cleanup_optimizer); ?>
					</h4>
						<a class="button button-primary button-hero" href="#">
							<?php _e("Watch Clean Up Video!", cleanup_optimizer); ?>
						</a>
						<p>or, 
							<a target="_blank" href="http://tech-banker.com/products/wp-clean-up-optimizer/knowledge-base/">
								<?php _e("read documentation here", cleanup_optimizer); ?>
							</a>
						</p>
				</div>
				<div class="welcome-panel-column" style="width:250px !important;">
					<h4 class="welcome-screen-margin"><?php _e("Go Premium", cleanup_optimizer); ?></h4>
					<ul>
						<li>
							<a href="http://tech-banker.com/products/wp-clean-up-optimizer/" target="_blank" class="welcome-icon">
								<?php _e("Features", cleanup_optimizer); ?>
							</a>
						</li>
						<li>
							<a href="http://tech-banker.com/products/wp-clean-up-optimizer/demo/" target="_blank" class="welcome-icon">
								<?php _e("Online Demos", cleanup_optimizer); ?>
							</a>
						</li>
						<li>
							<a href="http://tech-banker.com/products/wp-clean-up-optimizer/pricing/" target="_blank" class="welcome-icon">
								<?php _e("Why Go for Premium ?", cleanup_optimizer); ?>
							</a>
						</li>
					</ul>
				</div>
				<div class="welcome-panel-column" style="width:240px !important;">
					<h4 class="welcome-screen-margin">
						<?php _e("Knowledge Base", cleanup_optimizer); ?>
					</h4>
					<ul>
						<li>
							<a href="http://tech-banker.com/forums/forum/wp-clean-up-optimizer-support/" target="_blank" class="welcome-icon">
								<?php _e("Support Forum", cleanup_optimizer); ?>
							</a>
						</li>
						<li>
							<a href="http://tech-banker.com/products/wp-clean-up-optimizer/knowledge-base/" target="_blank" class="welcome-icon">
								<?php _e("FAQ's", cleanup_optimizer); ?>
							</a>
						</li>
						<li>
							<a href="http://tech-banker.com/products/wp-clean-up-optimizer/" target="_blank" class="welcome-icon">
								<?php _e("Detailed Features", cleanup_optimizer); ?>
							</a>
						</li>
					</ul>
				</div>
				<div class="welcome-panel-column welcome-panel-last" style="width:250px !important;">
					<h4 class="welcome-screen-margin"><?php _e("More Actions", cleanup_optimizer); ?></h4>
					<ul>
						<li>
							<a href="http://tech-banker.com/products/wp-clean-up-optimizer/pricing/" target="_blank" class="welcome-icon">
								<?php _e("Premium Pricing Plans", cleanup_optimizer); ?>
							</a>
						</li>
						<li>
							<a href="admin.php?page=cpo_recommendations" class="welcome-icon">
								<?php _e("Recommendations", cleanup_optimizer); ?>
							</a>
						</li>
						<li>
							<a href="admin.php?page=cpo_other_services" class="welcome-icon">
								<?php _e("Our Other Services", cleanup_optimizer); ?>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<h2 class="nav-tab-wrapper" style="max-width: 1000px;">
		<a class="nav-tab coustom-nav-tab" id=cpo_dashboard href="admin.php?page=cpo_dashboard">
			<?php _e("Dashboard", cleanup_optimizer);?>
		</a>
		<a class="nav-tab coustom-nav-tab" id="cpo_login_logs" href="admin.php?page=cpo_login_logs">
			<?php _e("Login Logs", cleanup_optimizer);?>
		</a>
		<a class="nav-tab coustom-nav-tab" id="cpo_cron_jobs" href="admin.php?page=cpo_cron_jobs">
			<?php _e("Cron Jobs", cleanup_optimizer);?>
		</a>
		<a class="nav-tab coustom-nav-tab" id="cpo_general_settings" href="admin.php?page=cpo_general_settings">
			<?php _e("General Settings",cleanup_optimizer)?>
		</a>
		<a class="nav-tab coustom-nav-tab" id="cpo_premium_edition" href="admin.php?page=cpo_premium_edition">
			<?php _e("Premium Editions", cleanup_optimizer);?>
		</a>
		<a class="nav-tab coustom-nav-tab" id="cpo_recommendations" href="admin.php?page=cpo_recommendations">
			<?php _e("Recommendations",cleanup_optimizer)?>
		</a>
		<a class="nav-tab coustom-nav-tab" id="cpo_other_services" href="admin.php?page=cpo_other_services">
			<?php _e("Our Other Services",cleanup_optimizer)?>
		</a>
	</h2>
	<script>
	jQuery(document).ready(function()
	{
		jQuery(".nav-tab-wrapper > a#<?php echo $_REQUEST["page"];?>").addClass("nav-tab-active");
	});
	</script>
<?php 
}
?>