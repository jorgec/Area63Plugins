<?php

namespace WP_Shopify;

if (!defined('ABSPATH')) {
    exit();
}

use WP_Shopify\Options;
use WP_Shopify\Utils;
use WP_Shopify\Utils\Data as Utils_Data;

class Backend
{
   
   public $plugin_settings;

    public function __construct($plugin_settings, $DB_Settings_General)
   {
      $this->plugin_settings = $plugin_settings;
      $this->DB_Settings_General = $DB_Settings_General;
   }

    /*

     Checks for a valid admin page

     */
    public function is_valid_admin_page()
    {
        $screen = \get_current_screen();

        if (empty($screen)) {
            return false;
        }

        if (!is_admin()) {
            return false;
        }

        return $screen;
    }

    /*

     Checks for a valid admin page

     */
    public function get_screen_id()
    {
        $screen = $this->is_valid_admin_page();

        if (empty($screen)) {
            return false;
        }

        return $screen->id;
    }

    /*

     Checks for the correct admin page to load CSS

     */
    public function should_load_css()
    {
        if (!$this->is_valid_admin_page()) {
            return;
        }

        $screen_id = $this->get_screen_id();

        if ($this->is_admin_settings_page($screen_id) || $this->is_admin_posts_page($screen_id) || $this->is_admin_plugins_page($screen_id) ) {
            return true;
        }

        return false;
    }

    public function is_plugin_specific_pages() {
      return $this->is_admin_settings_page($this->get_screen_id());
    }

    /*

     Checks for the correct admin page to load JS

     */
    public function should_load_js()
    {
        if (!$this->is_valid_admin_page()) {
            return;
        }

        $screen_id = $this->get_screen_id();

        // Might want to check these eventually
        // || $this->is_admin_posts_page($screen_id)

        if ($this->is_admin_settings_page($screen_id)) {
            return true;
        }

        return false;
    }

    /*

     Is wp posts page

     */
    public function is_admin_posts_page($current_admin_screen_id)
    {
        if ($current_admin_screen_id === WP_SHOPIFY_COLLECTIONS_POST_TYPE_SLUG || $current_admin_screen_id === WP_SHOPIFY_PRODUCTS_POST_TYPE_SLUG) {
            return true;
        }
    }

    /*

     Is wp nav menus page

     */
    public function is_admin_nav_page($current_admin_screen_id)
    {
        if ($current_admin_screen_id === 'nav-menus') {
            return true;
        }
    }

    /*

     Is wp plugins page

     */
    public function is_admin_plugins_page($current_admin_screen_id)
    {
        if ($current_admin_screen_id === 'plugins') {
            return true;
        }
    }

    /*

     Is plugin settings page

     */
    public function is_admin_settings_page($current_admin_screen_id = false)
    {
        if (Utils::str_contains($current_admin_screen_id, 'wp-shopify')) {
            return true;
        }
    }

    /*

     Admin styles

     */
    public function admin_styles()
    {
        if ($this->should_load_css()) {
            wp_enqueue_style('wp-color-picker');

            wp_enqueue_style('animate-css', WP_SHOPIFY_PLUGIN_URL . 'admin/css/vendor/animate.min.css', [], filemtime(WP_SHOPIFY_PLUGIN_DIR_PATH . 'admin/css/vendor/animate.min.css'));

            wp_enqueue_style('tooltipster-css', WP_SHOPIFY_PLUGIN_URL . 'admin/css/vendor/tooltipster.min.css', [], filemtime(WP_SHOPIFY_PLUGIN_DIR_PATH . 'admin/css/vendor/tooltipster.min.css'));

            wp_enqueue_style('chosen-css', WP_SHOPIFY_PLUGIN_URL . 'admin/css/vendor/chosen.min.css', [], filemtime(WP_SHOPIFY_PLUGIN_DIR_PATH . 'admin/css/vendor/chosen.min.css'));

            if (!Utils::is_wp_5()) {
               wp_enqueue_style('gutenberg-components-css', WP_SHOPIFY_PLUGIN_URL . 'dist/gutenberg-components.min.css', [], filemtime(WP_SHOPIFY_PLUGIN_DIR_PATH . 'dist/gutenberg-components.min.css'));
            }

            wp_enqueue_style(
                WP_SHOPIFY_PLUGIN_TEXT_DOMAIN . '-styles-backend',
                WP_SHOPIFY_PLUGIN_URL . 'dist/admin.min.css',
                ['wp-color-picker', 'wp-components', 'animate-css', 'tooltipster-css', 'chosen-css'],
                filemtime(WP_SHOPIFY_PLUGIN_DIR_PATH . 'dist/admin.min.css')
         );
        }
    }

    public function replace_rest_protocol() {

      if (is_ssl()) {
         return str_replace("http://", "https://", get_rest_url());
      }
      
      return get_rest_url();
      
    }

    /*

     Admin scripts

     */
    public function admin_scripts()
    {
        if ($this->should_load_js()) {

            $settings = $this->plugin_settings['general'];

            wp_enqueue_script('jquery-ui-slider');

            wp_enqueue_script('promise-polyfill', WP_SHOPIFY_PLUGIN_URL . 'admin/js/vendor/es6-promise.auto.min.js', ['jquery'], filemtime(WP_SHOPIFY_PLUGIN_DIR_PATH . 'admin/js/vendor/es6-promise.auto.min.js'));

            wp_enqueue_script('tooltipster-js', WP_SHOPIFY_PLUGIN_URL . 'admin/js/vendor/jquery.tooltipster.min.js', ['jquery'], filemtime(WP_SHOPIFY_PLUGIN_DIR_PATH . 'admin/js/vendor/jquery.tooltipster.min.js'));

            wp_enqueue_script('validate-js', WP_SHOPIFY_PLUGIN_URL . 'admin/js/vendor/jquery.validate.min.js', ['jquery'], filemtime(WP_SHOPIFY_PLUGIN_DIR_PATH . 'admin/js/vendor/jquery.validate.min.js'));

            wp_enqueue_script('chosen-js', WP_SHOPIFY_PLUGIN_URL . 'admin/js/vendor/chosen.jquery.min.js', ['jquery'], filemtime(WP_SHOPIFY_PLUGIN_DIR_PATH . 'admin/js/vendor/chosen.jquery.min.js'));

            wp_enqueue_script('anime-js', WP_SHOPIFY_PLUGIN_URL . 'admin/js/vendor/anime.min.js', [], filemtime(WP_SHOPIFY_PLUGIN_DIR_PATH . 'admin/js/vendor/anime.min.js'));

            // Third-party libs first ...
            wp_enqueue_script(WP_SHOPIFY_PLUGIN_TEXT_DOMAIN . '-scripts-vendors-admin', WP_SHOPIFY_PLUGIN_URL . 'dist/vendors-admin.08ddc92c.min.js', []);

            // Commonly shared third-party libs second ...
            wp_enqueue_script(
                  WP_SHOPIFY_PLUGIN_TEXT_DOMAIN . '-scripts-vendors-common',
                  WP_SHOPIFY_PLUGIN_URL . 'dist/vendors-admin-public.08ddc92c.min.js',
                  []
            );

            wp_enqueue_script(
                  WP_SHOPIFY_PLUGIN_TEXT_DOMAIN . '-scripts-backend',
                  WP_SHOPIFY_PLUGIN_URL . 'dist/admin.08ddc92c.min.js',
                  ['jquery', 'promise-polyfill', 'tooltipster-js', 'validate-js', 'chosen-js', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN . '-scripts-vendors-admin', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN . '-scripts-vendors-common'],
                  '',
                  true
            );

            wp_localize_script(WP_SHOPIFY_PLUGIN_TEXT_DOMAIN . '-scripts-backend', WP_SHOPIFY_PLUGIN_NAME_JS, [
               'ajax' => __(admin_url('admin-ajax.php')),
               'pluginsPath' => __(plugins_url()),
               'siteUrl' => site_url(),
               'pluginsDirURL' => plugin_dir_url(dirname(__FILE__)),
               'nonce_api' => wp_create_nonce('wp_rest'),
               'selective_sync' => [
                  'all' => $settings->selective_sync_all,
                  'products' => $settings->selective_sync_products,
                  'smart_collections' => $settings->selective_sync_collections,
                  'custom_collections' => $settings->selective_sync_collections,
                  'customers' => $settings->selective_sync_customers,
                  'orders' => $settings->selective_sync_orders,
                  'shop' => $settings->selective_sync_shop
               ],
               'reconnectingWebhooks' => false,
               'hasConnection' => empty($this->plugin_settings['connection']) ? false : !empty($this->plugin_settings['connection']->storefront_access_token),
               'isSyncing' => false,
               'manuallyCanceled' => false,
               'isClearing' => false,
               'isDisconnecting' => false,
               'isConnecting' => false,
               'latestVersion' => WP_SHOPIFY_NEW_PLUGIN_VERSION,
               'latestVersionCombined' => str_replace('.', '', WP_SHOPIFY_NEW_PLUGIN_VERSION),
               'migrationNeeded' => Options::get('wp_shopify_migration_needed'),
               'itemsPerRequest' => $settings->items_per_request,
               'maxItemsPerRequest' => WP_SHOPIFY_MAX_ITEMS_PER_REQUEST,
               'settings' => [
                  'layoutAlignHeight' => Utils_Data::coerce($settings->align_height, 'bool'),
                  'colorAddToCart' => $settings->add_to_cart_color,
                  'colorVariant' => $settings->variant_color,
                  'colorCheckout' => $settings->checkout_color,
                  'colorCartCounter' => $settings->cart_counter_color,
                  'colorCartIcon' => $settings->cart_icon_color,
                  'colorCartIconFixed' => $settings->cart_icon_fixed_color,
                  'productsHeading' => $settings->products_heading,
                  'collectionsHeading' => $settings->collections_heading,
                  'relatedProductsHeading' => $settings->related_products_heading,
                  'productsHeadingToggle' => $settings->products_heading_toggle,
                  'productsPLPDescriptionsToggle' => $settings->products_plp_descriptions_toggle,
                  'collectionsHeadingToggle' => $settings->collections_heading_toggle,
                  'relatedProductsHeadingToggle' => $settings->related_products_heading_toggle,
                  'productsImagesSizingToggle' => $settings->products_images_sizing_toggle,
                  'productsImagesSizingWidth' => $settings->products_images_sizing_width,
                  'productsImagesSizingHeight' => $settings->products_images_sizing_height,
                  'productsImagesSizingCrop' => $settings->products_images_sizing_crop,
                  'productsImagesSizingScale' => $settings->products_images_sizing_scale,

                  'productsThumbnailImagesSizingToggle' => Utils_Data::coerce($settings->products_thumbnail_images_sizing_toggle, 'bool'),
                  'productsThumbnailImagesSizingWidth' => Utils_Data::coerce($settings->products_thumbnail_images_sizing_width, 'int'),
                  'productsThumbnailImagesSizingHeight' => Utils_Data::coerce($settings->products_thumbnail_images_sizing_height, 'int'),
                  'productsThumbnailImagesSizingCrop' => Utils_Data::coerce($settings->products_thumbnail_images_sizing_crop, 'string'),
                  'productsThumbnailImagesSizingScale' => Utils_Data::coerce($settings->products_thumbnail_images_sizing_scale, 'int'),
                  'productsImagesShowZoom' => Utils_Data::coerce($settings->products_images_show_zoom, 'bool'),
                  'collectionsImagesSizingToggle' => $settings->collections_images_sizing_toggle,
                  'collectionsImagesSizingWidth' => $settings->collections_images_sizing_width,
                  'collectionsImagesSizingHeight' => $settings->collections_images_sizing_height,
                  'collectionsImagesSizingCrop' => $settings->collections_images_sizing_crop,
                  'collectionsImagesSizingScale' => $settings->collections_images_sizing_scale,
                  'relatedProductsImagesSizingToggle' => $settings->related_products_images_sizing_toggle,
                  'relatedProductsImagesSizingWidth' => $settings->related_products_images_sizing_width,
                  'relatedProductsImagesSizingHeight' => $settings->related_products_images_sizing_height,
                  'relatedProductsImagesSizingCrop' => $settings->related_products_images_sizing_crop,
                  'relatedProductsImagesSizingScale' => $settings->related_products_images_sizing_scale,
                  'enableCustomCheckoutDomain' => $settings->enable_custom_checkout_domain,
                  'pricingCompareAt' => $settings->products_compare_at,
                  'enableCustomerAccounts' => Utils_Data::coerce($settings->enable_customer_accounts, 'bool'),
                  'enableCartNotes' => Utils_Data::coerce($settings->enable_cart_notes, 'bool'),
                  'cartNotesPlaceholder' => Utils_Data::coerce($settings->cart_notes_placeholder, 'string'),
                  'enableCartTerms' => Utils_Data::coerce($settings->enable_cart_terms, 'bool'),
                  'cartTerms' => Utils_Data::coerce($settings->cart_terms_content, 'string'),
                  'pricingShowPriceRange' => Utils_Data::coerce($settings->products_show_price_range, 'bool'),
                  'pricingCurrencyDisplayStyle' => Utils_Data::coerce($settings->currency_display_style, 'string'),
                  'checkoutButtonTarget' => Utils_Data::coerce($settings->checkout_button_target, 'string'),
                  'cartShowFixedCartTab' => Utils_Data::coerce($settings->show_fixed_cart_tab, 'bool'),
                  'cartIconFixedColor' => Utils_Data::coerce($settings->cart_icon_fixed_color, 'string'),
                  'cartCounterFixedColor' => Utils_Data::coerce($settings->cart_counter_fixed_color, 'string'),
                  'cartFixedBackgroundColor' => Utils_Data::coerce($settings->cart_fixed_background_color, 'string'),
                  'pricingLocalCurrencyToggle' => Utils_Data::coerce($settings->pricing_local_currency_toggle, 'bool'),
                  'pricingLocalCurrencyWithBase' => Utils_Data::coerce($settings->pricing_local_currency_with_base, 'bool'),
                  'synchronousSync' => Utils_Data::coerce($settings->synchronous_sync, 'bool'),
                  'isLiteSync' => Utils_Data::coerce($settings->is_lite_sync, 'bool'),
                  'isSyncingPosts' => Utils_Data::coerce($settings->is_syncing_posts, 'bool'),
                  'selectiveSyncAll' => Utils_Data::coerce($settings->selective_sync_all, 'bool'),
                  'selectiveSyncProducts' => Utils_Data::coerce($settings->selective_sync_products, 'bool'),
                  'selectiveSyncCollections' => Utils_Data::coerce($settings->selective_sync_collections, 'bool'),
                  'selectiveSyncCustomers' => Utils_Data::coerce($settings->selective_sync_customers, 'bool'),
                  'selectiveSyncOrders' => Utils_Data::coerce($settings->selective_sync_orders, 'bool'),
                  'disableDefaultPages' => Utils_Data::coerce($settings->disable_default_pages, 'bool'),
                  'searchBy' => Utils_Data::coerce($settings->search_by, 'string'),
                  'searchExactMatch' => Utils_Data::coerce($settings->search_exact_match, 'bool'),
                  'connection' => [
                     'saveConnectionOnly' => Utils_Data::coerce($settings->save_connection_only, 'bool')
                  ],
                  'accountPageLogin' => Utils_Data::coerce($settings->account_page_login, 'string'),
                  'accountPageRegister' => Utils_Data::coerce($settings->account_page_register, 'string'),
                  'accountPageAccount' => Utils_Data::coerce($settings->account_page_account, 'string'),
                  'accountPageForgotPassword' => Utils_Data::coerce($settings->account_page_forgot_password, 'string'),
                  'accountPageSetPassword' => Utils_Data::coerce($settings->account_page_set_password, 'string'),
                  'hideDecimals' => Utils_Data::coerce($settings->hide_decimals, 'bool'),
                  'hideDecimalsAll' => Utils_Data::coerce($settings->hide_decimals_all, 'bool'),
                  'hideDecimalsOnlyZeros' => Utils_Data::coerce($settings->hide_decimals_only_zeros, 'bool'),
                  'enableDataCache' => Utils_Data::coerce($settings->enable_data_cache, 'bool'),
                  'dataCacheLength' => Utils_Data::coerce($settings->data_cache_length, 'string'),
                  'directCheckout' => Utils_Data::coerce($settings->direct_checkout, 'bool'),
                  'enableAutomaticSyncing' => Utils_Data::coerce($settings->enable_automatic_syncing, 'bool'),
                  'syncByWebhooks' => maybe_unserialize(Utils_Data::coerce($settings->sync_by_webhooks, 'string')),
                  'allowTracking' => Utils_Data::coerce($settings->allow_tracking, 'bool'),
                  'syncMedia' => Utils_Data::coerce($settings->sync_media, 'bool'),
               ],
               'API' => [
                  'namespace' => WP_SHOPIFY_SHOPIFY_API_NAMESPACE,
                  'baseUrl' => site_url(),
                  'urlPrefix' => rest_get_url_prefix(),
                  'restUrl' => $this->replace_rest_protocol(),
                  'isSSL' => is_ssl()
               ],
               'timers' => [
                  'syncing' => false
               ],
               'pages' => get_pages(['post_type' => 'page', 'post_status' => 'publish', 'sort_order' => 'asc', 'sort_column' => 'post_title'])
            ]
         );

        }
    }

    /*

     Registering the admin menu into the WordPress Dashboard menu.
     Adding a settings page to the Settings menu.

     */
    public function add_dashboard_menus()
    {
        if (current_user_can('manage_options')) {

            if (empty($this->plugin_settings['general'])) {
               $setting_lite_sync = true;
               $setting_is_syncing_posts = false;

            } else {
               $setting_lite_sync = $this->plugin_settings['general']->is_lite_sync;
               $setting_is_syncing_posts = $this->plugin_settings['general']->is_syncing_posts;
            }
            
            $plugin_name = WP_SHOPIFY_PLUGIN_NAME_FULL;


            global $submenu;

            $icon_svg =
            'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDIzLjAuNCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPgo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IgoJIHZpZXdCb3g9IjAgMCAxMDAgMTAwIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCAxMDAgMTAwOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxnPgoJPHBhdGggZD0iTTE4LjksMjYuOGM1LjIsMCw5LjksMi45LDEyLjMsNy42bDEwLDE5LjljMCwwLDQuMy02LjksOC40LTEzLjFsMC44LTEuMmwtNS43LTEyLjVjLTAuMi0wLjQsMC4xLTAuOCwwLjUtMC44aDEzCgkJYzUuNSwwLDEwLjQsMy4yLDEyLjYsOC4ybDguNSwxOS4ybDMuOC02LjFjMi40LTQsNS41LTkuMSw4LjEtMTIuOGwyLjItMy41Qzg2LjIsMTUsNjkuNSwzLjMsNTAuMiwzLjNjLTE3LjQsMC0zMi42LDkuNS00MC43LDIzLjUKCQlIMTguOXoiLz4KCTxwYXRoIGQ9Ik05NC42LDM1bC0yLjMsMy43bDAuMSwwbC0yNSw0MC4xYy0wLjUsMC42LTEuMywwLjgtMiwwLjRjLTAuNi0wLjQtMC44LTEuMy0wLjQtMS45bDQuNS03LjNjLTIuOSwwLjMtNS45LTEtNy4yLTRMNTEuOCw0MwoJCUwyOSw3OC43Yy0wLjIsMC4zLTAuNywwLjQtMSwwLjJsLTEtMC42Yy0wLjMtMC4yLTAuNC0wLjctMC4yLTFsNC41LTcuMmMtMi44LDAuMy01LjgtMS4xLTcuMS00bC0xNy0zNC44Yy0yLjYsNS44LTQsMTIuMi00LDE5CgkJYzAsMjYsMjEsNDcsNDcsNDdzNDctMjEsNDctNDdDOTcuMiw0NC45LDk2LjMsMzkuOCw5NC42LDM1eiIvPgo8L2c+Cjwvc3ZnPgo=';

            // Main menu
            add_menu_page(
                __($plugin_name, WP_SHOPIFY_PLUGIN_TEXT_DOMAIN),
                __($plugin_name, WP_SHOPIFY_PLUGIN_TEXT_DOMAIN),
                'manage_options',
                WP_SHOPIFY_PLUGIN_TEXT_DOMAIN,
                [$this, 'plugin_admin_page'],
                $icon_svg,
                null
         );

         add_submenu_page(WP_SHOPIFY_PLUGIN_TEXT_DOMAIN, __('Connect', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), __('Connect', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), 'manage_options', 'wps-connect', [$this, 'plugin_admin_page']);

         add_submenu_page(WP_SHOPIFY_PLUGIN_TEXT_DOMAIN, __('Settings', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), __('Settings', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), 'manage_options', 'wps-settings', [$this, 'plugin_admin_page']);

         // if (!Utils_Data::coerce($setting_lite_sync, 'bool') && Utils_Data::coerce($setting_is_syncing_posts, 'bool')) {

            add_submenu_page(WP_SHOPIFY_PLUGIN_TEXT_DOMAIN, __('Products', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), __('Products', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), 'manage_options', 'edit.php?post_type=' . WP_SHOPIFY_PRODUCTS_POST_TYPE_SLUG, null);
         
            add_submenu_page(WP_SHOPIFY_PLUGIN_TEXT_DOMAIN, __('Collections', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), __('Collections', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), 'manage_options', 'edit.php?post_type=' . WP_SHOPIFY_COLLECTIONS_POST_TYPE_SLUG, null);

         // }

         add_submenu_page(WP_SHOPIFY_PLUGIN_TEXT_DOMAIN, __('Tools', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), __('Tools', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), 'manage_options', 'wps-tools', [$this, 'plugin_admin_page']);

         add_submenu_page(WP_SHOPIFY_PLUGIN_TEXT_DOMAIN, __('License', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), __('License', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), 'manage_options', 'wps-license', [$this, 'plugin_admin_page']);

         // add_submenu_page(WP_SHOPIFY_PLUGIN_TEXT_DOMAIN, __('Add-ons', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), __('Add-ons', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), 'manage_options', 'wps-addons', [$this, 'plugin_admin_page']);

         add_submenu_page(WP_SHOPIFY_PLUGIN_TEXT_DOMAIN, __('Help', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), __('Help', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN), 'manage_options', 'wps-help', [$this, 'plugin_admin_page']);

         remove_submenu_page(WP_SHOPIFY_PLUGIN_TEXT_DOMAIN, WP_SHOPIFY_PLUGIN_TEXT_DOMAIN);

        }
    }

      /*

      Add settings action link to the plugins page.

      */
    public function add_action_links($links)
    {

        $settings_link = ['<a href="' . esc_url(admin_url('/admin.php?page=' . WP_SHOPIFY_PLUGIN_NAME) . '-settings') . '">' . esc_html__('Settings', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN) . '</a>'];
         
        $settings_link[] = '<a href="' . esc_url('https://wpshop.io/purchase') . '" target="_blank">' . esc_html__('Upgrade to Pro', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN) . '</a>';

        return array_merge($settings_link, $links);
    }

    /*

     Render the settings page for this plugin.

     */
    public function plugin_admin_page()
    {
        include_once WP_SHOPIFY_PLUGIN_DIR_PATH . 'admin/partials/wps-admin-display.php';
    }

    /*

     Register / Update plugin options
     Currently only updating connection form

     */
    public function on_options_update()
    {
        register_setting(WP_SHOPIFY_SETTINGS_CONNECTION_OPTION_NAME, WP_SHOPIFY_SETTINGS_CONNECTION_OPTION_NAME, [$this, 'connection_form_validate']);
    }

    /*

     Validate connection form settings

     */
    public function connection_form_validate($input)
    {
        $valid = [];

        // Nonce
        $valid['nonce'] = isset($input['nonce']) && !empty($input['nonce']) ? sanitize_text_field($input['nonce']) : '';

        return $valid;
    }

    public function get_active_tab($GET)
    {
        if (isset($GET['activetab']) && $GET['activetab']) {
            return $GET['activetab'];
        }

         // $active_tab = 'tab-connect';

        if ($GET['page'] === 'wps-tools') {
            return 'tab-tools';
        }

        if ($GET['page'] === 'wps-connect') {
            return 'tab-connect';
        }

        if ($GET['page'] === 'wps-settings') {
            return 'tab-settings';
        }

        if ($GET['page'] === 'wps-license') {
            return 'tab-license';
        }

        if ($GET['page'] === 'wps-help') {
            return 'tab-help';
        }

        if ($GET['page'] === 'wps-addons') {
            return 'tab-addons';
        }

        return 'tab-connect';
    }

    public function get_active_sub_tab($GET)
    {
        if (isset($GET['activesubnav']) && $GET['activesubnav']) {
            $active_sub_nav = $GET['activesubnav'];
        } else {
            $active_sub_nav = 'wps-admin-section-general'; // default sub nav
        }

        return $active_sub_nav;
    }



   public function wps_admin_body_class( $classes ) {

      // If the settings are empty ...
      if (empty($this->plugin_settings['general'])) {
         return $classes;
      }

      // If the right admin page ...
      $screen_id = $this->get_screen_id();

      if ($screen_id !== 'edit-wps_products' && $screen_id !== 'edit-wps_collections') {
         return $classes;
      }

      // On a WPS admin page
      if (!$this->plugin_settings['general']->is_syncing_posts) {
         return  $classes . ' wps-is-lite-sync';
      }
      
      return $classes;

   }

   public function wps_posts_notice() {

      // If the settings aren't empty ...
      if (empty($this->plugin_settings['general'])) {
         return;
      }

      // If the right admin page ...
      $screen_id = $this->get_screen_id();

      if ($screen_id !== 'edit-wps_products' && $screen_id !== 'edit-wps_collections') {
         return;
      }

      if (!$this->plugin_settings['general']->is_syncing_posts) {
         echo '<div class="wps-posts-notice">
         <h1>👋 Almost ready...</h1>
         <p>You need to <a href="/wp-admin/admin.php?page=wps-settings&activesubnav=wps-admin-section-syncing">turn on the "Sync posts" setting</a> before your products / collections are listed here. Simply turn off <code>Lite sync</code> and turn on <code>Sync posts</code>.</p>
         <p>Be sure to <a href="/wp-admin/admin.php?page=wps-tools">manually resync</a> afterwords!</p>
         </div>';
      }

      
   }


      public function user_allowed_tracking() {

         $settings = $this->plugin_settings['general'];
         return (bool) $settings->allow_tracking;

      }


      public function wpshopify_usage_tracking_analytics_head() {
         
         if (is_admin() && $this->is_plugin_specific_pages() && $this->user_allowed_tracking()) {

            echo "<script async src='https://www.googletagmanager.com/gtag/js?id=UA-101619037-3'></script><script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'UA-101619037-3');</script><script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-NKB2G3Z');</script>";
         }

      }

      public function wpshopify_usage_tracking_analytics_footer() {
         
         if (is_admin() && $this->is_plugin_specific_pages() && $this->user_allowed_tracking()) {
            echo "<noscript><iframe src='https://www.googletagmanager.com/ns.html?id=GTM-NKB2G3Z' height='0' width='0' style='display:none;visibility:hidden'></iframe></noscript>";
         }

      }


    /*

     Hooks

     */
    public function hooks()
    {

      add_action('admin_menu', [$this, 'add_dashboard_menus']);
      add_action('admin_enqueue_scripts', [$this, 'admin_styles']);
      add_action('admin_enqueue_scripts', [$this, 'admin_scripts']);
      add_filter('plugin_action_links_' . WP_SHOPIFY_BASENAME, [$this, 'add_action_links']);
      add_action('admin_init', [$this, 'on_options_update']);

      add_filter('admin_body_class', [$this, 'wps_admin_body_class'] );
      add_action('in_admin_header', [$this, 'wps_posts_notice']);

      add_action( 'admin_head', [$this, 'wpshopify_usage_tracking_analytics_head'] );
      add_action( 'admin_footer', [$this, 'wpshopify_usage_tracking_analytics_footer'] );
     
    }

    /*

     Init

     */
    public function init()
    {
        $this->hooks();
    }
}