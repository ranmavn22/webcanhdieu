<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.6.0
 */

defined( 'ABSPATH' ) || exit;

$order = wc_get_order( $order_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.OverrideProhibited

if ( ! $order ) {
    return;
}

$order_items           = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
$show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
$downloads             = $order->get_downloadable_items();
$show_downloads        = $order->has_downloadable_item() && $order->is_download_permitted();

if ( $show_downloads ) {
    wc_get_template(
        'order/order-downloads.php',
        array(
            'downloads'  => $downloads,
            'show_title' => true,
        )
    );
}
?>



    <section class="woocommerce-order-details">
        <div class="row padding-left-15">
            <div class="col2-set col-md-6 col-lg-7 col-xl-8 mb-6 mb-md-0 border flex items-center justify-center checkout-detail-info">
                <div>
                    <?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>
                    <?php
                    $order_item_totals = $order->get_order_item_totals();
                    foreach ( $order_item_totals as $key => $total ) {
                        if ( $key === 'payment_method' ){
                            if($total['value'] == "COD"){
                                echo '<div class="text-center"><span class="font-weight-medium">Hình thức thanh toán: </span><strong> Thanh toán khi nhận hàng</strong></div>';
                            }
                            if($total['value'] == "Chuyển khoản ngân hàng"){
                                echo '<div class="text-center"><span class="font-weight-medium">Hình thức thanh toán: </span><strong> Chuyển khoản ngân hàng</strong></div>';
                            }
                            ?>

                        <?php }
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-6 col-lg-5 col-xl-4 custom-items-detail">
                <div id="checkoutAccordion">
                    <table class="shop_table woocommerce-checkout-review-order-table d-block">
                        <tbody class="p-4d875 border-bottom d-block">
                        <?php
                        do_action( 'woocommerce_order_details_before_order_table_items', $order );

                        foreach ( $order_items as $item_id => $item ) {
                            $product = $item->get_product();

                            wc_get_template(
                                'order/order-details-item.php',
                                array(
                                    'order'              => $order,
                                    'item_id'            => $item_id,
                                    'item'               => $item,
                                    'show_purchase_note' => $show_purchase_note,
                                    'purchase_note'      => $product ? $product->get_purchase_note() : '',
                                    'product'            => $product,
                                )
                            );
                        }

                        do_action( 'woocommerce_order_details_after_order_table_items', $order );
                        ?>
                        </tbody>

                        <tfoot class="p-4d875 border-bottom d-block">
                        <?php
                        $order_item_totals = $order->get_order_item_totals();
                        foreach ( $order_item_totals as $key => $total ) {
                            if ( $key === 'order_total' ){
                                ?>
                                <tr class="order-total d-flex justify-content-between">
                                    <th class="font-weight-medium font-size-3">Tổng đơn hàng</th>
                                    <td><?php echo ( 'payment_method' === $key ) ? esc_html( $total['value'] ) : wp_kses_post( $total['value'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
                                </tr>
                            <?php }
                        }
                        ?>
                        <?php if ( $order->get_customer_note() ) : ?>
                            <tr class="d-flex justify-content-between py-2">
                                <th class="font-weight-medium font-size-2 d-block p-0"><?php esc_html_e( 'Note:', 'bookworm' ); ?></th>
                                <td class="font-weight-medium font-size-2 text-muted d-block p-0"><?php echo wp_kses_post( nl2br( wptexturize( $order->get_customer_note() ) ) ); ?></td>
                            </tr>
                        <?php endif; ?>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </section>

<?php
//if ( $show_customer_details ) {
//    wc_get_template( 'order/order-details-customer.php', array( 'order' => $order ) );
//}
