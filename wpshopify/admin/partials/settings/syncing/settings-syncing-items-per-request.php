<div class="wps-form-group wps-form-group-align-top">

  <table class="form-table">
    <tbody>
      <tr valign="top">

        <th scope="row" class="titledesc" data-wpshopify-setting-input="Items per request">
          <?php esc_attr_e( 'Items per request', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>
          <span class="wps-help-tip" title="<?php esc_attr_e( 'Determines the number of "items" (products, collections, etc) that are transfered per second during the syncing process. Reduce this number if you\'re running into timeout or syncing issues.', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>"></span>
        </th>

        <td class="forminp forminp-text wps-slider-wrapper" data-wpshopify-setting-input="Items per request">

          <div class="wps-slider-label-wrapper wps-l-row">
            <div class="wps-slider-amount" id="wps-items-per-request-amount"><?= $general->items_per_request; ?></div>
          </div>

          <div class="slider wps-slider-items-per-request"></div>

        </td>

      </tr>

    </tbody>
  </table>

</div>
