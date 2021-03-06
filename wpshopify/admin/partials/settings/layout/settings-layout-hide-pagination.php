<!--

Load cart

-->
<div class="wps-form-group wps-form-group-align-top">

  <table class="form-table">

    <tbody>
      <tr valign="top">

        <th scope="row" class="titledesc" data-wpshopify-setting-input="Layout hide pagination">
          <?php esc_html_e( 'Hide all pagination', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>
          <span class="wps-help-tip" title="<?php esc_attr_e( 'When enabled, pagination will be hidden globally from all pages and shortcodes. You can still "turn on" pagination on a per shortcode basis by using the "pagination" shortcode attribute.', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>"></span>
        </th>

        <td class="forminp forminp-text" data-wpshopify-setting-input="Layout hide pagination">
          <input name="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>[wps_general_hide_pagination]" id="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>_hide_pagination" type="checkbox" <?php echo $general->hide_pagination ? 'checked' : ''; ?>>
        </td>

      </tr>
    </tbody>

  </table>

</div>
