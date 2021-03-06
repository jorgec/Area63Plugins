<?php

    /*

    @description   Cart icon

    @version       1.0.1
    @since         1.0.49
    @path          templates/components/cart/cart-icon.php

    @docs          https://wpshop.io/docs/templates/cart/cart-icon

    */

    defined('ABSPATH') ?: die;

?>

<svg xmlns="http://www.w3.org/2000/svg" class="<?= apply_filters('wps_cart_icon_class', ''); ?> wps-icon wps-icon-cart"
     viewBox="0 0 25 25" enable-background="new 0 0 25 25">
    <g fill="<?= !empty($data->button_color) ? $data->button_color : '#000'; ?>">
        <path d="M24.6 3.6c-.3-.4-.8-.6-1.3-.6h-18.4l-.1-.5c-.3-1.5-1.7-1.5-2.5-1.5h-1.3c-.6 0-1 .4-1 1s.4 1 1 1h1.8l3 13.6c.2 1.2 1.3 2.4 2.5 2.4h12.7c.6 0 1-.4 1-1s-.4-1-1-1h-12.7c-.2 0-.5-.4-.6-.8l-.2-1.2h12.6c1.3 0 2.3-1.4 2.5-2.4l2.4-7.4v-.2c.1-.5-.1-1-.4-1.4zm-4 8.5v.2c-.1.3-.4.8-.5.8h-13l-1.8-8.1h17.6l-2.3 7.1z"></path>
        <circle cx="9" cy="22" r="2"></circle>
        <circle cx="19" cy="22" r="2"></circle>
    </g>
</svg>
