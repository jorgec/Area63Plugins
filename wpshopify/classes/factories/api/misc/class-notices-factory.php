<?php

namespace WP_Shopify\Factories\API\Misc;

defined('ABSPATH') ?: die;

use WP_Shopify\Factories;
use WP_Shopify\API;

class Notices_Factory {

	protected static $instantiated = null;

	public static function build($plugin_settings = false) {

      if (!$plugin_settings) {
         $plugin_settings = Factories\DB\Settings_Plugin_Factory::build();
      }

		if (is_null(self::$instantiated)) {

			self::$instantiated = new API\Misc\Notices(
				Factories\DB\Settings_General_Factory::build(),
				Factories\Backend_Factory::build($plugin_settings)
			);

		}

		return self::$instantiated;

	}

}
