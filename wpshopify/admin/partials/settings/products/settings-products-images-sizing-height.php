<!--

Images sizing

-->
<div class="wps-form-group wps-form-group-tight">

  <table class="form-table">
    <tbody>
      <tr valign="top">

        <th scope="row" class="titledesc" data-wpshopify-setting-input="Products Image Height">
          <?php esc_attr_e( 'Image height', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>
          <span class="wps-help-tip" title="<?php esc_attr_e( 'Sets a custom height for all product images. Maximum size of 5760 x 5760. Both the height and height values will maintain the image aspect ratio. Therefore, if you want to force all images to the same dimensions make sure to specify the crop option below as well. If you want to size by one dimension only, keep the other dimension blank.', WP_SHOPIFY_PLUGIN_TEXT_DOMAIN ); ?>"></span>
        </th>

        <td class="wps-input">
          <div id="wps-settings-products-images-sizing-height" data-wpshopify-setting-input="Products Image Height">
            <span class="wps-placeholder wps-placeholder-input"></span>
          </div>
        </td>

      </tr>

    </tbody>
  </table>

</div>
