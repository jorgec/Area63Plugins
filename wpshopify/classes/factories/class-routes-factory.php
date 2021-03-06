<?php

namespace WP_Shopify\Factories;

use WP_Shopify\Factories;
use WP_Shopify\Routes;

if (!defined('ABSPATH')) {
	exit;
}

class Routes_Factory {

	protected static $instantiated = null;

	public static function build($plugin_settings = false) {

		if ( is_null(self::$instantiated) ) {
			self::$instantiated = new Routes();
		}

		return self::$instantiated;

	}

}
