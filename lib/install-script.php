<?php 
global $wpdb;
require_once(ABSPATH . "wp-admin/includes/upgrade.php");

if (count($wpdb->get_var("SHOW TABLES LIKE '" . wp_scheduler_tbl() . "'")) == 0)
{
	//create_table_wp_scheduler();
}
if (count($wpdb->get_var("SHOW TABLES LIKE '" . db_scheduler_tbl() . "'")) == 0)
{
	//create_table_db_optimizer();
}
function create_table_wp_scheduler()
{
	$sql = "CREATE TABLE " . wp_scheduler_tbl() . "(
			scheduler_id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
			wp_schedule VARCHAR(1000),
			start_date DATE,
			schedule_type VARCHAR(100),
			cron_name VARCHAR(100),
			PRIMARY KEY (scheduler_id)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci";
	dbDelta($sql);
}

function create_table_db_optimizer()
{
	$sql = "CREATE TABLE " . db_scheduler_tbl() . "(
			scheduler_id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
			db_optimizer VARCHAR(700),
			start_date DATE,
			schedule_type VARCHAR(100),
			cron_name VARCHAR(100),
			scheduler_action INTEGER(50),
			PRIMARY KEY (scheduler_id)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE utf8_general_ci";
	dbDelta($sql);
}
?>