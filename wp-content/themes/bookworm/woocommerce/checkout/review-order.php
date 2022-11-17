<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;
?>
<table class="shop_table woocommerce-checkout-review-order-table d-block">
    <thead class="sr-only">
        <tr>
            <th class="product-name"><?php esc_html_e( 'Product', 'bookworm' ); ?></th>
            <th class="product-total"><?php esc_html_e( 'Subtotal', 'bookworm' ); ?></th>
        </tr>
    </thead>
    <tbody class="p-4d875 border-bottom d-block">
        <tr class="d-block mb-4"><td colspan="2" class="d-block p-0"><h3 class="checkout-title mb-0 font-weight-medium font-size-3"><?php esc_html_e( 'Your Order', 'bookworm' ); ?></h3></td></tr>
        <?php
        do_action( 'woocommerce_review_order_before_cart_contents' );

        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

            if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                ?>
                <tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
                    <td class="product-name pr-4">
                        <?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ) . '&nbsp;'; ?>
                        <?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        <?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </td>
                    <td class="product-total">
                        <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </td>
                </tr>
                <?php
            }
        }

        do_action( 'woocommerce_review_order_after_cart_contents' );
        ?>
    </tbody>

    <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
    <tbody class="p-4d875 border-bottom d-block">

        <tr class="d-block mb-4"><td colspan="2" class="d-block p-0"><h3 class="checkout-title mb-0 font-weight-medium font-size-3"><?php esc_html_e( 'Shipping', 'bookworm' ); ?></h3></td></tr>

        <?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

        <?php wc_cart_totals_shipping_html(); ?>

        <?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

    </tbody>
    <?php endif; ?>

    <tfoot class="p-4d875 border-bottom d-block">

        <?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

        <tr class="order-total d-flex justify-content-between">
            <th class="font-weight-medium font-size-3"><?php esc_html_e( 'Total', 'bookworm' ); ?></th>
            <td><?php wc_cart_totals_order_total_html(); ?></td>
        </tr>

        <?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

    </tfoot>
</table>
