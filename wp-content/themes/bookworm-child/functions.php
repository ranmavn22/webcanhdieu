<?php
/**
 * Bookworm Child
 *
 * @package bookworm-child
 */

/**
 * Include all your custom code here
 */

add_filter('woocommerce_currency_symbol', 'change_existing_currency_symbol', 10, 2);
function change_existing_currency_symbol( $currency_symbol, $currency ) {
//    switch( $currency ) {
//        case 'AUD': $currency_symbol = 'AUD$'; break;
//    }
    return ' VND';
}
