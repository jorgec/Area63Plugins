<?php

namespace WP_Shopify\Processing;

if (!defined('ABSPATH')) {
	exit;
}

class Posts_Relationships_Products extends \WP_Shopify\Processing\Posts_Relationships {

	protected $action = 'wps_background_processing_posts_r_products';

	protected $DB_Settings_Syncing;
	protected $CPT_Meta;
	protected $CPT_Query;
	protected $DB_Collections;

	public $meta;


	public function __construct($DB_Settings_Syncing, $CPT_Meta, $CPT_Query, $DB_Collections) {

		$this->DB_Settings_Syncing 		= $DB_Settings_Syncing;
		$this->CPT_Meta 							= $CPT_Meta;
		$this->CPT_Query 							= $CPT_Query;
		$this->DB_Collections 				= $DB_Collections;

		parent::__construct($DB_Settings_Syncing, $CPT_Meta, $CPT_Query, $DB_Collections);

	}

}
