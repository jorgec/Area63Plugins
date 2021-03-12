<?php

namespace WP_Shopify\API\Options;

use WP_Shopify\Utils;

defined('ABSPATH') ?: exit();

class Components extends \WP_Shopify\API
{
   public function __construct()
   {
   }

   /*

	Get Custom Components Count

   $data represents an associative array with "type" props, such as

   [
      products => [1223, 12313],
      collections => [1223, 12313],
      cartButtons => [32234, 32234]
   ]

	*/
   public function get_components_options($request)
   {

      $data = $request->get_param('data');

      if (!is_array($data)) {
         
         return Utils::wp_error([
            'message_lookup' 	=> 'Component options is of wrong type',
            'call_method' 		=> __METHOD__,
            'call_line' 		=> __LINE__
         ]);

      }

      $existing_options = array_values(maybe_unserialize(get_option('wpshopify_component_options')));
      

      $component_options_mapped = array_map(function ($component) use($existing_options) {

         $found_key = $this->find_cached_component_index($component, $existing_options);

         if ($found_key !== false) {

            // if (array_key_exists($found_key, $existing_options)) {
            //    return $existing_options[$found_key];
            // }

            return $existing_options[$found_key];
         }

      }, $data);

      return $this->handle_response([
         'response' => $component_options_mapped
      ]);
      
   }

   public function find_cached_component_by_id($existing_component, $components_from_client) {

      $found_key = $this->find_cached_component_index($existing_component, $components_from_client);

      if ($found_key !== false) {
         return $components_from_client[$found_key];
      }
      
      return false;

   }

   public function find_cached_component_index($existing_component, $components_from_client) {

      if (empty($components_from_client) || !isset($existing_component['componentId'])) {
         return false;
      }

      return array_search($existing_component['componentId'], array_column($components_from_client, 'componentId'));
   }


   public function add_payload_to_components_cache($existing_options, $data, $cacheLength) {
      
      return array_filter(array_values(array_map(function($existing_option) use($data, $cacheLength) {

         $matched_component_from_client = $this->find_cached_component_by_id($existing_option, $data);

         if ($matched_component_from_client !== false) {

            $cache_start_time = time();

            $existing_option['componentPayload'] = $matched_component_from_client['componentPayload'];
            $existing_option['componentPayloadLastCursor'] = $matched_component_from_client['componentPayloadLastCursor'];
            $existing_option['cacheStartTime'] = $cache_start_time;
            $existing_option['cacheExpireTime'] = $cache_start_time + $cacheLength;

         } 

         return $existing_option;

      }, $existing_options)));

   }


   /*
   
   This method is called if cache is empty, or a page hasn't been cached yet.

   */
   public function set_components_payload($request)
   {

      // New stuff to cache
      $data = $request->get_param('data');
      $cacheLength = $request->get_param('cacheLength');
      $existing_options = maybe_unserialize(get_option('wpshopify_component_options'));

      // If client components are empty, nothing to do ...
      if (!is_array($data)) {
         
         return Utils::wp_error([
            'message_lookup' 	=> 'Component options is of wrong type',
            'call_method' 		=> __METHOD__,
            'call_line' 		=> __LINE__
         ]);

      }

      // If cache is empty, nothing to do ...
      if ( empty($existing_options) ) {
         return $this->handle_response([
            'response' => $existing_options
         ]);
      }

      // Main work
      $new_cache_with_payload = $this->add_payload_to_components_cache($existing_options, $data, $cacheLength);
      
      $updated_response = update_option('wpshopify_component_options', $new_cache_with_payload);

      return $this->handle_response([
         'response' => $updated_response
      ]);
      
   }



   /*

	Register route: cart_icon_color

	*/
   public function register_route_components_options()
   {
      return register_rest_route(WP_SHOPIFY_SHOPIFY_API_NAMESPACE, '/components/options', [
         [
            'methods' => \WP_REST_Server::CREATABLE,
            'callback' => [$this, 'get_components_options']
         ]
      ]);
   }


   public function register_route_components_payload()
   {
      return register_rest_route(WP_SHOPIFY_SHOPIFY_API_NAMESPACE, '/components/payload', [
         [
            'methods' => \WP_REST_Server::CREATABLE,
            'callback' => [$this, 'set_components_payload']
         ]
      ]);
   }


   /*

	Hooks

	*/
   public function hooks()
   {
      add_action('rest_api_init', [$this, 'register_route_components_options']);
      add_action('rest_api_init', [$this, 'register_route_components_payload']);
   }

   /*

  Init

  */
   public function init()
   {
      $this->hooks();
   }
}
