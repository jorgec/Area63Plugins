<?php

namespace WP_Shopify\Factories\API\Items;

defined('ABSPATH') ?: die;

use WP_Shopify\API;
use WP_Shopify\Factories;

class Media_Uploader_Factory {

	protected static $instantiated = null;

	public static function build($plugin_settings = false) {

		if (is_null(self::$instantiated)) {

			self::$instantiated = new API\Items\Media_Uploader(
            Factories\Processing\Media_Uploader_Factory::build(),
            Factories\Shopify_API_Factory::build(),
            Factories\DB\Settings_Syncing_Factory::build(),
            Factories\DB\Images_Factory::build()
			);

		}

		return self::$instantiated;

	}

}
