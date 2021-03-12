<?php

namespace WP_Shopify;

if (!defined('ABSPATH')) {
   exit();
}

use WP_Shopify\Factories;
use WP_Shopify\Utils;

class Bootstrap
{

   /*

	The init() methods on each classes are responsible for registering
	the necessary hooks, so don't need to do them here.

	*/
   public function __construct()
   {

   }

   public function request_from_admin() {
      return Utils::str_contains($_SERVER['REQUEST_URI'], '/wp-admin/');
   }

   public function request_from_api() {
      return Utils::str_contains($_SERVER['REQUEST_URI'], '/wp-json/');
   }

   public function request_from_testing() {
      return (isset($_SERVER['argv']) && !empty($_SERVER['argv']) && $_SERVER['argv'][0] === '/usr/local/bin/phpunit');
   }

   public function initialize()
   {

      if ($this->request_from_admin() || $this->request_from_api()) {
         $is_admin_page = true;
      } else {
         $is_admin_page = false;
      }

      // Needed for PHPUnit to correctly Bootstrap is_admin()
      if ($this->request_from_testing()) {
         $is_testing = true;

      } else {
         $is_testing = false;
      }

      if ($is_admin_page || $is_testing) {

         $results['Config'] = Factories\Config_Factory::build();

         // Activator only needs to run within the Admin
         $results['Activator'] = Factories\Activator_Factory::build();
         $results['Activator']->init();

         if ( !is_plugin_active( WP_SHOPIFY_BASENAME ) && !$is_testing ) {
            return;  
         }
         
      }
   
      // The init action fires aftere plugins_loaded
      add_action('init', function() use($is_admin_page, $is_testing) {
         $this->build_plugin($is_admin_page, $is_testing);
      });

   }

   

   public function build_plugin($is_admin_page, $is_testing) {

      $results = [];

      do_action('wpshopify_before_build');

      $results['Config'] = Factories\Config_Factory::build();

      // Plugin settings are available at this point. Activator is responsible for creating tables
      $plugin_settings = Factories\DB\Settings_Plugin_Factory::build();


      if ($is_admin_page || $is_testing) {

         $results['Deactivator'] = Factories\Deactivator_Factory::build($plugin_settings);
         $results['Updater'] = Factories\Updater_Factory::build($plugin_settings);
         $results['Backend'] = Factories\Backend_Factory::build($plugin_settings);

      }

      $results['Admin_Menus'] = Factories\Admin_Menus_Factory::build($plugin_settings);

      $results['Shortcodes_Hooks'] = Factories\Shortcodes\Shortcodes_Factory::build($plugin_settings);
      $results['Templates'] = Factories\Templates_Factory::build($plugin_settings);
      
      $results['CPT'] = Factories\CPT_Factory::build($plugin_settings);
      $results['Hooks'] = Factories\Hooks_Factory::build($plugin_settings);
      $results['API_Options_Components_Factory'] = Factories\API\Options\Components_Factory::build($plugin_settings);

      if (!is_admin() || $is_testing) {
         $results['Frontend'] = Factories\Frontend_Factory::build($plugin_settings);
      }

      if ($is_admin_page || $is_testing) {

         $results['API_Items_Products_Factory'] = Factories\API\Items\Products_Factory::build($plugin_settings);
         

         $results['API_Settings_Checkout_Factory'] = Factories\API\Settings\Checkout_Factory::build($plugin_settings);
         $results['API_Settings_Cart_Factory'] = Factories\API\Settings\Cart_Factory::build($plugin_settings);
         $results['API_Settings_Collections_Factory'] = Factories\API\Settings\Collections_Factory::build($plugin_settings);
         $results['API_Settings_Layout_Factory'] = Factories\API\Settings\Layout_Factory::build($plugin_settings);
         $results['API_Settings_Products_Factory'] = Factories\API\Settings\Products_Factory::build($plugin_settings);
         $results['API_Settings_Related_Products_Factory'] = Factories\API\Settings\Related_Products_Factory::build($plugin_settings);
         $results['API_Settings_License_Factory'] = Factories\API\Settings\License_Factory::build($plugin_settings);
         $results['API_Settings_General_Factory'] = Factories\API\Settings\General_Factory::build($plugin_settings);
         $results['API_Settings_Connection_Factory'] = Factories\API\Settings\Connection_Factory::build($plugin_settings);
         
         $results['API_Status_Factory'] = Factories\API\Syncing\Status_Factory::build($plugin_settings);
         $results['API_Indicator_Factory'] = Factories\API\Syncing\Indicator_Factory::build($plugin_settings);
         $results['API_Counts_Factory'] = Factories\API\Syncing\Counts_Factory::build($plugin_settings);

         $results['API_Items_Collections_Factory'] = Factories\API\Items\Collections_Factory::build($plugin_settings);
         $results['API_Items_Shop_Factory'] = Factories\API\Items\Shop_Factory::build($plugin_settings);
         $results['API_Items_Variants_Factory'] = Factories\API\Items\Variants_Factory::build($plugin_settings);
         $results['API_Items_Collects_Factory'] = Factories\API\Items\Collects_Factory::build($plugin_settings);
         $results['API_Items_Posts_Factory'] = Factories\API\Items\Posts_Factory::build($plugin_settings);
         
         $results['API_Processing_Collections_Factory'] = Factories\API\Processing\Collections_Factory::build($plugin_settings);
         $results['API_Processing_Shop_Factory'] = Factories\API\Processing\Shop_Factory::build($plugin_settings);
         $results['API_Processing_Products_Factory'] = Factories\API\Processing\Products_Factory::build($plugin_settings);
         $results['API_Processing_Collects_Factory'] = Factories\API\Processing\Collects_Factory::build($plugin_settings);
         

         $results['API_Misc_Notices_Factory'] = Factories\API\Misc\Notices_Factory::build($plugin_settings);
         $results['API_Misc_Routes_Factory'] = Factories\API\Misc\Routes_Factory::build($plugin_settings);
         $results['API_Tools_Cache_Factory'] = Factories\API\Tools\Cache_Factory::build($plugin_settings);
         $results['API_Tools_Clear_Factory'] = Factories\API\Tools\Clear_Factory::build($plugin_settings);

      }
      
      return $this->init_classes($results);

   }

   public function init_classes($classes)
   {

      $results = [];

      foreach ($classes as $class_name => $class) {

         if (method_exists($class, 'init')) {

            if ($class_name === 'Activator') {
               $results[$class_name] = true;

            } else {
               $results[$class_name] = $class->init();
            }
         }
         
      }

      return $classes;
   }
}
