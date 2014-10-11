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
	?>
	<img src="<?php echo plugins_url("/assets/images/icons/wp-clean-up-optimizer-logo.png" , dirname(__FILE__))?>" style="margin-top:10px;"></img>
	<h2 class="nav-tab-wrapper" style="width:1000px;">
		
		<a class="nav-tab wpcpo_nav-tab" readonly id="wp_optimizer"
		href="<?php echo "admin.php?page=wp_optimizer";?>"
		><?php _e("WP Data Optimizer",cleanup_optimizer)?></a>
	
		<a class="nav-tab wpcpo_nav-tab" id="db_optimizer"
		href="<?php echo "admin.php?page=db_optimizer";?>"
		><?php _e("DB Optimizer",cleanup_optimizer)?></a>
		
	</h2>
	
	<script>
	jQuery(document).ready(function()
	{
		jQuery(".nav-tab-wrapper > a#<?php echo $_REQUEST["page"];?>").addClass("nav-tab-active");
		jQuery("#wpab_add_staff_member").attr("disabled","disabled");
		jQuery(".wpab-btn-disable").click(function(){
			
		});
	});
	</script>
<?php 
}
?>