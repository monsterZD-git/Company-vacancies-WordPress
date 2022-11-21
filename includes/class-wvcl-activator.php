<?php

/**
 * Fired during plugin activation
 *
 * @link       https://vk.com/id554858695
 * @since      1.0.4
 *
 * @package    Wvcl
 * @subpackage Wvcl/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.4
 * @package    Wvcl
 * @subpackage Wvcl/includes
 * @author     Виктор Шугуров <oren_rebel@mail.ru>
 */
class Wvcl_Activator {

	public $recruitment;

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.4
	 */
	public static function activate() {

		global $wpdb;
		$table_name = esc_sql( $wpdb->prefix . "wvcl" );
		$sql = $wpdb->prepare( "SHOW TABLES LIKE %s", $table_name );

		if($wpdb->get_var($sql) != htmlspecialchars($table_name)) {
			$create = "CREATE TABLE $table_name ( id mediumint(9) NOT NULL AUTO_INCREMENT, recruitment varchar(255) NOT NULL, pages int(11) NOT NULL, found int(11) NOT NULL, result longtext NOT NULL COLLATE utf8_general_ci, options longtext NOT NULL COLLATE utf8_general_ci, update_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, UNIQUE KEY id (id) )";
			
			if(!function_exists('dbDelta')) {
                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            }
			dbDelta($create);
		}

	}
}