<?php

namespace WP_Shopify\Factories\API\Settings;

defined('ABSPATH') ?: die;

use WP_Shopify\API;
use WP_Shopify\Factories;

class General_Factory {

	protected static $instantiated = null;

	public static function build($plugin_settings = false) {

		if (is_null(self::$instantiated)) {

			self::$instantiated = new API\Settings\General(
            Factories\DB\Settings_General_Factory::build(),
            Factories\DB\Collections_Factory::build(),
				Factories\Routes_Factory::build()
			);

		}

		return self::$instantiated;

	}

}
