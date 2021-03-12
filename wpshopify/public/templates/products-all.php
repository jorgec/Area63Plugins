<?php

defined('ABSPATH') ?: die;

get_header('wpshopify');

$Products = WP_Shopify\Factories\Render\Products\Products_Factory::build();
$Settings = WP_Shopify\Factories\DB\Settings_General_Factory::build();

$description_toggle = $Settings->get_col_value('products_plp_descriptions_toggle');

if (!$description_toggle) {
   
   $products_options = [
      'excludes' => ['description']
   ];

} else {
   $products_options = [];
}

$args = apply_filters('wps_products_all_args', $products_options);

?>

<section class="wps-container">
   <?= do_action('wps_breadcrumbs') ?>

   <div class="wps-products-all">
      
      <?php if ($Settings->get_col_value('products_heading_toggle')) { ?>
         <h1 class="wps-heading"><?= $Settings->get_col_value('products_heading'); ?></h1>
      <?php }

      $Products->products($args); 
      
      ?>

   </div>

</section>

<?php

get_footer('wpshopify');