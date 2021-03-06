<!--

Load default styles

-->
<div class="wps-form-group wps-form-group-align-top">

  <table class="form-table">
    <tbody>
      <tr valign="top">

        <th scope="row" class="titledesc" data-wpshopify-setting-input="Load styles">
          <?php esc_attr_e( 'Load styles', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>
          <span class="wps-help-tip" title="<?php esc_attr_e('Allows you to specify what WP Shopify stylesheets are loaded on the front-end. Useful for users looking to customize.', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>"></span>
        </th>

        <td class="forminp forminp-text wps-checkbox-wrapper">


          <div class="wps-label-block-wrapper wps-checkbox-all" data-wpshopify-setting-input="Load styles">

            <input name="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>[wps_general_styles_all]" id="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>_styles_all" type="checkbox" <?php echo $general->styles_all ? 'checked' : ''; ?>>

            <label for="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>_styles_all" class="wps-label-block wps-checkbox-all">
              <?php esc_html_e( 'All styles', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>
            </label>

          </div>


          <div class="wps-label-block-wrapper" data-wpshopify-setting-input="Load styles">

            <input name="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>[wps_general_styles_core]" id="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>_styles_core" type="checkbox" <?php echo $general->styles_core ? 'checked' : ''; ?> <?php echo $general->styles_all ? 'disabled' : ''; ?> class="wps-checkbox">

            <label for="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>_styles_core" class="wps-label-block">
              <?php printf(__('Core styles <small>(cart, hide/show classes, etc)</small>', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN)); ?>
            </label>

          </div>


          <div class="wps-label-block-wrapper" data-wpshopify-setting-input="Load styles">

            <input name="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>[wps_general_styles_grid]" id="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>_styles_grid" type="checkbox" <?php echo $general->styles_grid ? 'checked' : ''; ?> <?php echo $general->styles_all ? 'disabled' : ''; ?> class="wps-checkbox">

            <label for="<?= WP_SHOPIFY_SETTINGS_GENERAL_OPTION_NAME; ?>_styles_grid" class="wps-label-block">
              <?php esc_html_e( 'Grid styles', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>
            </label>

          </div>


        </td>

      </tr>

    </tbody>
  </table>

</div>
