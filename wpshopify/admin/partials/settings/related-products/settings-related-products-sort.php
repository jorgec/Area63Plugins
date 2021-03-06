<!--

Related Products Sort Type

-->
<div class="wps-admin-section">

  <div class="wps-form-group wps-form-group-tight wps-form-group-align-top" id="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>_related_products_sort_type">

    <table class="form-table">

      <tbody>

        <tr valign="top">

          <th scope="row" class="titledesc" data-wpshopify-setting-input="Related products filter by">

            <?php esc_html_e( 'Filter by', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>

            <span class="wps-help-tip" title="<?php esc_attr_e( 'Performs a fuzzy search based on the below selection. For example, when filtering by Tags WP Shopify will locate all products which share at least one tag as the product in question. By default, related products are filtered and ordered randomly. Shortcode filtering will override this setting. ', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>"></span>

          </th>

          <td class="forminp forminp-text wps-checkbox-wrapper" data-wpshopify-setting-input="Related products filter by">

            <div class="wps-label-block-wrapper wps-checkbox-all">

              <input id="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>_related_products_sort_random" class="tog" value="random" type="radio" name="related_proudcts_filter" <?php echo $general->related_products_sort === 'random' ? 'checked' : ''; ?>>

              <label for="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>_related_products_sort_random" class="wps-label-block wps-checkbox-all">
                 <?php esc_html_e( 'Random', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>
              </label>

            </div>


            <div class="wps-label-block-wrapper">

              <input id="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>_related_products_sort_collections" class="tog" value="collections" type="radio" name="related_proudcts_filter" <?php echo $general->related_products_sort === 'collections' ? 'checked' : ''; ?>>

              <label for="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>_related_products_sort_collections" class="wps-label-block wps-checkbox-all">
                <?php esc_html_e( 'Collections', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>
              </label>

            </div>


            <div class="wps-label-block-wrapper">

              <input id="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>_related_products_sort_tags" class="tog" value="tags" type="radio" name="related_proudcts_filter" <?php echo $general->related_products_sort === 'tags' ? 'checked' : ''; ?>>

              <label for="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>_related_products_sort_tags" class="wps-label-block wps-checkbox-all">
                <?php esc_html_e( 'Tags', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>
              </label>

            </div>


            <div class="wps-label-block-wrapper">

              <input id="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>_related_products_sort_vendors" class="tog" value="vendors" type="radio" name="related_proudcts_filter" <?php echo $general->related_products_sort === 'vendors' ? 'checked' : ''; ?>>

              <label for="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>_related_products_sort_vendors" class="wps-label-block wps-checkbox-all">
                <?php esc_html_e( 'Vendors', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>
              </label>

            </div>


            <div class="wps-label-block-wrapper">

              <input id="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>_related_products_sort_types" class="tog" value="types" type="radio" name="related_proudcts_filter" <?php echo $general->related_products_sort === 'types' ? 'checked' : ''; ?>>

              <label for="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>_related_products_sort_types" class="wps-label-block wps-checkbox-all">
                 <?php esc_html_e( 'Types', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>
              </label>

            </div>

          </td>

        </tr>

      </tbody>

    </table>

  </div>
</div>
