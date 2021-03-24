<?php
/**
 * Email Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-addresses.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     3.2.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$text_align = is_rtl() ? 'right' : 'left';
$totals = $order->get_order_item_totals();
?><table id="addresses" cellspacing="0" cellpadding="0" style="width: 100%; vertical-align: top; margin-bottom: 40px; padding:0;" border="0">
	<tr>
		<td style="text-align:<?php echo $text_align; ?>; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; border:0; padding:0;" valign="top" width="50%">
			<h2 id="mail-teemplate-address"><?php _e( 'Customer', 'woocommerce' ); ?></h2>
			<?php
				if (!empty(get_post_meta( $order->id, 'delivery_options', true )) && get_post_meta( $order->id, 'delivery_options', true ) == 'Store Pickup') { ?>
					<address class="address">
						<?php echo ( $fname = $order->get_formatted_billing_full_name() ) ? $fname : __( 'N/A', 'woocommerce' ); ?>
					</address>
			<?php } else { ?>
			<address class="address">
				<?php echo ( $address = $order->get_formatted_billing_address() ) ? $address : __( 'N/A', 'woocommerce' ); ?>
			</address>
			<?php } ?>
			<?php if ( $order->get_billing_phone() ) : ?>
				<h4 id="email-phone"><?php echo __('Phone'); ?></h4>
				<p id="email-text"><?php echo esc_html( $order->get_billing_phone() ); ?></p>
			<?php endif; ?>
			<?php if ( $order->get_billing_email() ) : ?>
				<h4 id="email-id"><?php echo __('Email'); ?></h4>
				<p id="email-text"><?php echo esc_html( $order->get_billing_email() ); ?></p>
			<?php endif; ?>
			<?php

				if (isset($totals['payment_method']) && !empty($totals['payment_method'])) {
					?>
					<h4 id="email-id"><?php echo __('Payment via'); ?></h4>
					<p id="email-text"><?php echo esc_html( $totals['payment_method']['value'] ); ?></p>
					<?php
				}
			?>
		</td>
		<td style="text-align:<?php echo $text_align; ?>; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; padding:0;" valign="top" width="50%">
			<?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() && ( $shipping = $order->get_formatted_shipping_address() ) ) : ?>
				
					<h2 id="mail-teemplate-address"><?php _e( 'Shipping address', 'woocommerce' ); ?></h2>

					<address class="address"><?php echo $shipping; ?></address>
				
			<?php endif; ?>
			<?php
					if ( $order->get_customer_note() ) {
					?>
						<h4 id="email-id"><?php esc_html_e( 'Note', 'woocommerce' ); ?></h4>
						<p id="email-text"><?php echo wp_kses_post( wptexturize( $order->get_customer_note() ) ); ?></p>
					<?php
				}
				
				if (!empty(get_post_meta( $order->id, 'delivery_options', true ))) { ?>
					<h4 id="email-id"><?php esc_html_e( 'Delivery option', 'woocommerce' ); ?></h4>
					<p id="email-text"><?php echo get_post_meta( $order->id, 'delivery_options', true ); ?></p>
			<?php } ?>
		</td>
	</tr>
</table>
