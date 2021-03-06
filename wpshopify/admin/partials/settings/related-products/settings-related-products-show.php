<!--

Related Products Show

-->
<div class="wps-admin-section">
  <div class="wps-form-group wps-form-group-tight wps-form-group-align-top">

    <table class="form-table">

      <tbody>

        <tr valign="top">

          <th scope="row" class="titledesc" data-wpshopify-setting-input="Related products show related products">
            <?php esc_html_e( 'Show related products', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>
            <span class="wps-help-tip" title="<?php esc_attr_e( 'When enabled, will show related products on the bottom of each product single page.', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>"></span>
          </th>

          <td class="forminp forminp-text" data-wpshopify-setting-input="Related products show related products">
            <input name="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>[wps_general_related_products_show]" id="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>_related_products_show" type="checkbox" <?php echo $general->related_products_show ? 'checked' : ''; ?>>
          </td>

        </tr>

      </tbody>

    </table>

  </div>
</div>
