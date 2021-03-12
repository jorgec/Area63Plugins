<?php

namespace WP_Shopify\Factories\DB;

if (!defined('ABSPATH')) {
	exit;
}

use WP_Shopify\DB;

class Settings_Plugin_Factory {

	protected static $settings = [];

   public static function get_data($class) {
      return $class->table_exists($class->table_name) ? $class->get_all_rows() : false;
   }

   public static function sanitize_data($class_result, $class) {

      if (empty($class_result)) {
         return $class->get_column_defaults();
      }

      return $class_result[0];

   }

	public static function build($plugin_settings = false) {

		if (empty(self::$settings)) {

         $general = new DB\Settings_General();
         $connection = new DB\Settings_Connection();
         $license = new DB\Settings_License();
         $syncing = new DB\Settings_Syncing();
         $shop = new DB\Shop();

         self::$settings['general'] = self::sanitize_data(self::get_data($general), $general);
         self::$settings['connection'] = self::sanitize_data(self::get_data($connection), $connection);
         self::$settings['license'] = self::sanitize_data(self::get_data($license), $license);
         self::$settings['syncing'] = self::sanitize_data(self::get_data($syncing), $syncing);
         self::$settings['shop'] = self::sanitize_data(self::get_data($shop), $shop);

		}

		return self::$settings;

	}

}
