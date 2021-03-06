<!--

Enable custom checkout domain

-->
<div class="wps-form-group wps-form-group-tight">

  <table class="form-table">
    <tbody>

      <tr valign="top" class="wps-checkbox-row">

        <th scope="row" class="titledesc wps-checkbox-row-label" data-wpshopify-setting-input="Checkout enable custom domain">
          <?php esc_attr_e( 'Enable custom domain', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>
          <span class="wps-help-tip" title="<?php esc_attr_e( 'When enabled, will use your custom primary domain (e.g., yourstore.com) when redirecting to the checkout page instead of the default .myshopify.com domain.', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>"></span>
        </th>

        <td class="forminp forminp-text wps-checkbox-row-input">
          <div id="wps-enable-custom-checkout-domain" data-wpshopify-setting-input="Checkout enable custom domain">
            <span class="wps-placeholder wps-placeholder-checkbox"></span>
          </div>
        </td>

      </tr>

    </tbody>
  </table>

</div>
