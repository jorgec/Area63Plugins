<!--

Load default styles

-->
<div class="wps-form-group wps-form-group-tight wps-form-group-align-top" id="wps-settings-wrapper-selective-sync">

  <table class="form-table">
    <tbody>
      <tr valign="top">

        <th scope="row" class="titledesc" data-wpshopify-setting-input="Selective sync">
          <?php esc_attr_e( 'Selective sync', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>

          <span class="wps-help-tip" title="<?php esc_attr_e('Determines which type of Shopify data to sync.', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>"></span>

        </th>

        <td class="forminp forminp-text wps-checkbox-wrapper" data-wpshopify-setting-input="Selective sync">

            <div class="wps-label-block-wrapper">
            <div id="wps-settings-selective-sync-all"></div>
         </div>

          <div class="wps-label-block-wrapper">
            <div id="wps-settings-selective-sync-products"></div>
          </div>


          <div class="wps-label-block-wrapper">
            <div id="wps-settings-selective-sync-collections"></div>
          </div>


          <div class="wps-label-block-wrapper">
            <div id="wps-settings-selective-sync-customers"></div>
          </div>


          <div class="wps-label-block-wrapper">
            <div id="wps-settings-selective-sync-orders"></div>
          </div>

        </td>

      </tr>

    </tbody>
  </table>

</div>
