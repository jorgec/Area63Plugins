<?php

namespace WP_Shopify\API\Settings;

use WP_Shopify\Options;
use WP_Shopify\Transients;
use WP_Shopify\Utils\Data;

if (!defined('ABSPATH')) {
    exit();
}

class General extends \WP_Shopify\API
{
    public $DB_Settings_General;
    public $DB_Collections;
    public $Routes;

    public function __construct($DB_Settings_General, $DB_Collections, $Routes)
    {
        $this->DB_Settings_General = $DB_Settings_General;
        $this->DB_Collections = $DB_Collections;        
        $this->Routes = $Routes;
    }

    public function setting_to_int($settings, $name, $default = false)
    {
        if (isset($settings[$name])) {
            return Data::coerce($settings[$name], 'int');
        }

        if ($default) {
            return (int) $default;
        }

        return 0;
    }

    

    public function setting_to_string($settings, $name, $default = false)
    {
        if (isset($settings[$name]) && !empty($settings[$name])) {
            return sanitize_text_field(Data::coerce($settings[$name], 'string'));
        }

        if ($default) {
            return sanitize_text_field($default);
        }

        return '';
   }

   public function setting_to_comma_string($settings, $name) {
        return join(",",$settings[$name]);
    }

    public function setting_to_url($settings, $name, $default = false)
    {
        return esc_url_raw($this->setting_to_string($settings, $name, $default));
    }

    public function setting_to_serialize($settings, $name, $default = false)
    {
        return maybe_serialize($settings[$name]);
    }

   public function setting_to_slug($settings, $name, $default = false)
    {
        return sanitize_text_field($settings[$name]);
    }


    public function setting_to_terms($settings, $name, $default = false)
    {
        return wp_kses(Data::coerce($settings[$name], 'string'), [
         'strong' => [],
         'b' => [],
         'i' => [],
         'em' => [],
         'a' => [
            'href' => [],
            'title' => [],
            'target' => []
         ]
      ]);
    }

    public function massage_selective_sync($new_settings)
    {
        if (
         $new_settings['selective_sync_all'] === 0 &&
         $new_settings['selective_sync_products'] === 0 &&
         $new_settings['selective_sync_collections'] === 0 &&
         $new_settings['selective_sync_customers'] === 0 &&
         $new_settings['selective_sync_orders'] === 0
      ) {
            return 1;
        }

        return $new_settings['selective_sync_all'];
    }

    public function massage_styles_selection($new_settings)
    {
        if ($new_settings['styles_all'] === 0 && $new_settings['styles_core'] === 0 && $new_settings['styles_grid'] === 0) {
            return 1;
        }

        return (int) $new_settings['styles_all'];
    }

    public function sanitize_collection_ids($collections) {

      if (empty($collections)) {
         return [];
      }

      return array_map(function($collection) {
         return json_decode(base64_decode($collection));
      }, $collections);

    }

    /*

     Update Settings General

     */
    public function update_settings($request)
    {

        $new_settings = [];
        $settings = $request->get_param('settings');

        $new_settings['enable_cart_terms'] = Data::setting_to_bool_int($settings, 'wps_settings_general_enable_cart_terms');
        $new_settings['cart_terms_content'] = $this->setting_to_terms($settings, 'wps_settings_general_cart_terms_content');
        $new_settings['enable_cart_notes'] = Data::setting_to_bool_int($settings, 'wps_settings_general_enable_cart_notes');
        $new_settings['cart_notes_placeholder'] = $this->setting_to_string($settings, 'wps_settings_general_cart_notes_placeholder');        

        $new_settings['save_connection_only'] = Data::setting_to_bool_int($settings, 'wps_settings_general_save_connection_only');
        $new_settings['related_products_sort'] = $this->setting_to_string($settings, 'wps_settings_general_related_products_sort', 'random');
        $new_settings['related_products_amount'] = $this->setting_to_int($settings, 'wps_settings_general_related_products_amount');
        $new_settings['items_per_request'] = $this->setting_to_int($settings, 'wps_settings_general_items_per_request');
        $new_settings['related_products_show'] = Data::setting_to_bool_int($settings, 'wps_settings_general_related_products_show');

        $new_settings['products_images_sizing_toggle'] = Data::setting_to_bool_int($settings, 'wps_settings_products_images_sizing_toggle');
        $new_settings['products_images_sizing_width'] = $this->setting_to_int($settings, 'wps_settings_products_images_sizing_width');
        $new_settings['products_images_sizing_height'] = $this->setting_to_int($settings, 'wps_settings_products_images_sizing_height');
         $new_settings['products_images_sizing_crop'] = $this->setting_to_string($settings, 'wps_settings_products_images_sizing_crop');
        $new_settings['products_images_sizing_scale'] = $this->setting_to_string($settings, 'wps_settings_products_images_sizing_scale', WP_SHOPIFY_DEFAULT_PRODUCTS_IMAGES_SIZING_SCALE);


        $new_settings['enable_data_cache'] = Data::setting_to_bool_int($settings, 'wps_settings_enable_data_cache');
         $new_settings['data_cache_length'] = $this->setting_to_string($settings, 'wps_settings_data_cache_length');

        $new_settings['products_thumbnail_images_sizing_toggle'] = Data::setting_to_bool_int($settings, 'wps_settings_products_thumbnail_images_sizing_toggle');
        $new_settings['products_thumbnail_images_sizing_width'] = $this->setting_to_int($settings, 'wps_settings_products_thumbnail_images_sizing_width');
        $new_settings['products_thumbnail_images_sizing_height'] = $this->setting_to_int($settings, 'wps_settings_products_thumbnail_images_sizing_height');
         $new_settings['products_thumbnail_images_sizing_crop'] = $this->setting_to_string($settings, 'wps_settings_products_thumbnail_images_sizing_crop');
        $new_settings['products_thumbnail_images_sizing_scale'] = $this->setting_to_string($settings, 'wps_settings_products_thumbnail_images_sizing_scale', WP_SHOPIFY_DEFAULT_PRODUCTS_IMAGES_SIZING_SCALE);

        $new_settings['add_to_cart_color'] = $this->setting_to_string($settings, 'wps_settings_general_add_to_cart_color');
        $new_settings['variant_color'] = $this->setting_to_string($settings, 'wps_settings_general_variant_color');
        $new_settings['checkout_color'] = $this->setting_to_string($settings, 'wps_settings_general_checkout_button_color');
        $new_settings['cart_icon_color'] = $this->setting_to_string($settings, 'wps_settings_general_cart_icon_color');
        $new_settings['cart_counter_color'] = $this->setting_to_string($settings, 'wps_settings_general_cart_counter_color');
        $new_settings['collections_heading'] = $this->setting_to_string($settings, 'wps_settings_general_collections_heading');
        $new_settings['products_heading'] = $this->setting_to_string($settings, 'wps_settings_general_products_heading');

        $new_settings['cart_fixed_background_color'] = $this->setting_to_string($settings, 'wps_settings_general_cart_fixed_background_color');
        $new_settings['cart_counter_fixed_color'] = $this->setting_to_string($settings, 'wps_settings_general_cart_counter_fixed_color');
        $new_settings['cart_icon_fixed_color'] = $this->setting_to_string($settings, 'wps_settings_general_cart_icon_fixed_color');

        $new_settings['collections_images_sizing_crop'] = $this->setting_to_string($settings, 'wps_settings_collections_images_sizing_crop');


        $new_settings['checkout_button_target'] = $this->setting_to_string($settings, 'wps_settings_checkout_button_target', WP_SHOPIFY_DEFAULT_CHECKOUT_BUTTON_TARGET);

   
        $new_settings['show_fixed_cart_tab'] = Data::setting_to_bool_int($settings, 'wps_settings_show_fixed_cart_tab');

        $new_settings['synchronous_sync'] = Data::setting_to_bool_int($settings, 'wps_settings_synchronous_sync');
        $new_settings['sync_media'] = Data::setting_to_bool_int($settings, 'wps_settings_sync_media');

        $new_settings['is_lite_sync'] = Data::setting_to_bool_int($settings, 'wps_settings_is_lite_sync');
        $new_settings['is_syncing_posts'] = Data::setting_to_bool_int($settings, 'wps_settings_is_syncing_posts');

        $new_settings['collections_images_sizing_scale'] = $this->setting_to_string($settings, 'wps_settings_collections_images_sizing_scale', WP_SHOPIFY_DEFAULT_COLLECTIONS_IMAGES_SIZING_SCALE);

        $new_settings['url_products'] = $this->setting_to_slug($settings, 'wps_settings_general_products_url');
        $new_settings['url_collections'] = $this->setting_to_slug($settings, 'wps_settings_general_collections_url');
        $new_settings['disable_default_pages'] = Data::setting_to_bool_int($settings, 'wps_settings_general_disable_default_pages');


        $new_settings['allow_tracking'] = Data::setting_to_bool_int($settings, 'wps_settings_plugin_allow_tracking');
        $new_settings['products_compare_at'] = Data::setting_to_bool_int($settings, 'wps_settings_products_compare_at');
        $new_settings['products_show_price_range'] = Data::setting_to_bool_int($settings, 'wps_settings_products_show_price_range');
        $new_settings['enable_custom_checkout_domain'] = Data::setting_to_bool_int($settings, 'wps_settings_checkout_enable_custom_checkout_domain');
        $new_settings['enable_beta'] = Data::setting_to_bool_int($settings, 'wps_settings_general_enable_beta');
        $new_settings['related_products_images_sizing_toggle'] = Data::setting_to_bool_int($settings, 'wps_settings_related_products_images_sizing_toggle');
        $new_settings['collections_images_sizing_toggle'] = Data::setting_to_bool_int($settings, 'wps_settings_collections_images_sizing_toggle');
        $new_settings['related_products_heading_toggle'] = Data::setting_to_bool_int($settings, 'wps_settings_general_related_products_heading_toggle');
        $new_settings['products_heading_toggle'] = Data::setting_to_bool_int($settings, 'wps_settings_general_products_heading_toggle');
        $new_settings['products_plp_descriptions_toggle'] = Data::setting_to_bool_int($settings, 'wps_settings_general_products_plp_descriptions_toggle');
        $new_settings['collections_heading_toggle'] = Data::setting_to_bool_int($settings, 'wps_settings_general_collections_heading_toggle');
        $new_settings['products_link_to_shopify'] = Data::setting_to_bool_int($settings, 'wps_settings_general_products_link_to_shopify');
        $new_settings['show_breadcrumbs'] = Data::setting_to_bool_int($settings, 'wps_settings_general_show_breadcrumbs');
        $new_settings['hide_pagination'] = Data::setting_to_bool_int($settings, 'wps_settings_general_hide_pagination');
        $new_settings['align_height'] = Data::setting_to_bool_int($settings, 'wps_settings_general_align_height');
        $new_settings['styles_all'] = Data::setting_to_bool_int($settings, 'wps_settings_general_styles_all');
        $new_settings['styles_core'] = Data::setting_to_bool_int($settings, 'wps_settings_general_styles_core');
        $new_settings['styles_grid'] = Data::setting_to_bool_int($settings, 'wps_settings_general_styles_grid');
        $new_settings['price_with_currency'] = Data::setting_to_bool_int($settings, 'wps_settings_general_price_with_currency');
        $new_settings['currency_display_style'] = $this->setting_to_string($settings, 'wps_settings_pricing_currency_display_style');
        $new_settings['cart_loaded'] = Data::setting_to_bool_int($settings, 'wps_settings_general_cart_loaded');
        $new_settings['related_products_images_sizing_height'] = $this->setting_to_int($settings, 'wps_settings_related_products_images_sizing_height');
        $new_settings['related_products_images_sizing_width'] = $this->setting_to_int($settings, 'wps_settings_related_products_images_sizing_width');
        $new_settings['collections_images_sizing_width'] = $this->setting_to_int($settings, 'wps_settings_collections_images_sizing_width');
        $new_settings['collections_images_sizing_height'] = $this->setting_to_int($settings, 'wps_settings_collections_images_sizing_height');
        $new_settings['num_posts'] = $this->setting_to_int($settings, 'wps_settings_general_num_posts', Options::get('posts_per_page'));
        $new_settings['hide_decimals'] = Data::setting_to_bool_int($settings, 'wps_settings_pricing_hide_decimals');
        $new_settings['hide_decimals_all'] = Data::setting_to_bool_int($settings, 'wps_settings_pricing_hide_decimals_all');
        $new_settings['hide_decimals_only_zeros'] = Data::setting_to_bool_int($settings, 'wps_settings_pricing_hide_decimals_only_zeros');
        $new_settings['styles_all'] = $this->massage_styles_selection($new_settings);


        $results = $this->DB_Settings_General->update_general($new_settings);

        Transients::delete_cached_settings();
        Transients::delete_cached_prices();

        $this->Routes->flush_routes();

        return $this->handle_response([
            'response' => $results
      ]);

    }

    /*

     Register route: collections_heading

     */
    public function register_route_settings()
    {
        return register_rest_route(WP_SHOPIFY_SHOPIFY_API_NAMESPACE, '/settings', [
         [
            'methods' => \WP_REST_Server::CREATABLE,
            'callback' => [$this, 'update_settings'],
            'permission_callback' => [$this, 'pre_process']
         ]
      ]);
    }

    /*

     Hooks

     */
    public function hooks()
    {
        add_action('rest_api_init', [$this, 'register_route_settings']);
    }

    /*

  Init

  */
    public function init()
    {
        $this->hooks();
    }
}