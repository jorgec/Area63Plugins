<div class="wps-form-group wps-form-group-align-top">

  <table class="form-table">

    <tbody>

      <tr valign="top">

        <th scope="row" class="titledesc" data-wpshopify-setting-input="Sync type">
          <?php esc_attr_e( 'Sync type', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>
          <span class="wps-help-tip" title="<?php esc_attr_e( 'When Lite sync is enabled, the plugin will skip syncing Shopify data as native WordPress posts. This will instead fetch the data directly from Shopify on page load using JavaScript. If you want PDP pages (product detail pages), you must choosse Sync posts and manually resync your store under the Tools tab.', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>"></span>
        </th>

        <td class="forminp forminp-text">
          <div id="wps-settings-syncing-type" data-wpshopify-setting-input="Sync type"></div>
        </td>

      </tr>

    </tbody>

  </table>

</div>
