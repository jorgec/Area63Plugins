<?php

namespace WP_Shopify\Factories\API\Processing;

defined('ABSPATH') ?: die;

use WP_Shopify\Factories;
use WP_Shopify\API;

class Options_Factory {

	protected static $instantiated = null;

	public static function build($plugin_settings = false) {

		if (is_null(self::$instantiated)) {

			self::$instantiated = new API\Processing\Options(
				Factories\Processing\Options_Factory::build()
			);

		}

		return self::$instantiated;

	}

}
