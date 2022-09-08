<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://vk.com/id554858695
 * @since      1.0.0
 *
 * @package    Wvcl
 * @subpackage Wvcl/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Wvcl
 * @subpackage Wvcl/includes
 * @author     Виктор Шугуров <oren_rebel@mail.ru>
 */
class Wvcl_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		// При деактивации плагина, обязательно нужно удалить задачу:
		register_deactivation_hook( __FILE__, 'wvcl_cron' );
		function wvcl_cron(){
			wp_unschedule_hook( 'wvcl_cron_vacancy' );
		}
	}

}
