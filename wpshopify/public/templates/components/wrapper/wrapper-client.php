<?php

use WP_Shopify\Options;
use WP_Shopify\Utils;

defined('ABSPATH') ?: exit();



global $wp_scripts;
$localized_data = $wp_scripts->get_data('wpshopify-scripts-frontend', 'data');
$localized_data_decoded = json_decode(str_replace('var WP_Shopify = ', '', substr($localized_data, 0, -1)), true);
$existing_options = $localized_data_decoded['componentOptions'];


$component_options = $data->data;

if (isset($component_options['products']['reverse'])) {

    if ($component_options['products']['reverse'] === true || $component_options['products']['reverse'] === 'true' || $component_options['reverse'] === 1 || $component_options['reverse'] === '1') {
        $reverse = true;
    } else {
        $reverse = false;
    }
} else {

    $reverse = false;
}

if (isset($component_options['reverse'])) {

    if ($component_options['reverse'] === true || $component_options['reverse'] === 'true' || $component_options['reverse'] === 1 || $component_options['reverse'] === '1') {
        $reverse_main = true;
    } else {
        $reverse_main = false;
    }
} else {
    $reverse_main = false;
}


if (isset($component_options['products'])) {

    $connection_params = [
        'query' => isset($component_options['products']['query']) ? $component_options['products']['query'] : false,
        'sortKey' => isset($component_options['products']['sort_by']) ? $component_options['products']['sort_by'] : false,
        'reverse' => $reverse,
        'first' => isset($component_options['products']['page_size']) ? $component_options['products']['page_size'] : false,
    ];
} else {
    $connection_params = false;
}


$component_hash = Utils::hash($data->data, true);

$both = [
    'componentQueryParams' => [
        'query' => isset($component_options['query']) ? $component_options['query'] : false,
        'sortKey' => isset($component_options['sort_by']) ? $component_options['sort_by'] : false,
        'reverse' => $reverse_main,
        'first' => isset($component_options['page_size']) ? $component_options['page_size'] : false,
    ],
    'componentConnectionParams' => $connection_params,
    'componentOptions' => $component_options,
    'componentId' => $component_hash
];

?>

<div 
   data-wps-is-client-component-wrapper 
   data-wps-client-component-type="<?=$data->type;?>" 
   data-wps-component-options-id="<?=$component_hash;?>"
   data-wps-hide-component-wrapper="<?=$component_options['hide_wrapper']; ?>" 
   class="wps-client-component wps-container">

   <div class="wps-loading-placeholder"><?= apply_filters('wps_loading_text', 'Loading ' . $data->type . ' ...', $data); ?></div>

</div>
 

<?php 

if (empty($existing_options)) {

   $newnew = array_merge([], [$both]);

   $localized_data_decoded['componentOptions'] = $newnew;

   Options::update('wpshopify_component_options', $newnew);

   $wp_scripts->add_data(WP_SHOPIFY_PLUGIN_TEXT_DOMAIN . '-scripts-frontend', 'data', '');
   wp_localize_script(WP_SHOPIFY_PLUGIN_TEXT_DOMAIN . '-scripts-frontend', WP_SHOPIFY_PLUGIN_NAME_JS, $localized_data_decoded);


} else {

   $found = false;

   foreach ($existing_options as $existing_option) {

      if (!empty($existing_option)) {

         if ($component_hash === $existing_option['componentId']) {
            $found = true;
            break;
         }
      }

   }


   if (!$found) {

      $new_components = array_merge($existing_options, [$both]);

      $localized_data_decoded['componentOptions'] = $new_components;

      Options::update('wpshopify_component_options', $new_components);

      $wp_scripts->add_data(WP_SHOPIFY_PLUGIN_TEXT_DOMAIN . '-scripts-frontend', 'data', '');
      wp_localize_script(WP_SHOPIFY_PLUGIN_TEXT_DOMAIN . '-scripts-frontend', WP_SHOPIFY_PLUGIN_NAME_JS, $localized_data_decoded);

   }

}
