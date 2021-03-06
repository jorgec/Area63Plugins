<!--

Load cart

-->
<div class="wps-form-group wps-form-group-align-top">

  <table class="form-table">

    <tbody>
      <tr valign="top">

        <th scope="row" class="titledesc" data-wpshopify-setting-input="Layout show breadcrumbs">
          <?php esc_html_e( 'Show breadcrumbs', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>
          <span class="wps-help-tip" title="<?php esc_attr_e( 'When enabled, will show breadcrumbs above all PDP and PLP pages.', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>"></span>
        </th>

        <td class="forminp forminp-text" data-wpshopify-setting-input="Layout show breadcrumbs">
          <input name="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>[wps_general_show_breadcrumbs]" id="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>_show_breadcrumbs" type="checkbox" <?php echo $general->show_breadcrumbs ? 'checked' : ''; ?>>
        </td>

      </tr>
    </tbody>

  </table>

</div>
