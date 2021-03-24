<?php
class Woo_Email {

	public function __construct() {

		add_filter( 'woocommerce_locate_template', array($this, 'woo_email_adon_plugin_template'), 100, 3 );
		add_action( 'woocommerce_email_header', array($this, 'email_header_before'), 1, 2 );
		add_action( 'woocommerce_display_item_meta', array($this, 'woo_display_item_meta'), 10, 3 );
	}
	public function woo_email_adon_plugin_template( $template, $template_name, $template_path ) {
		
		global $woocommerce;
		$_template = $template;
		if ( ! $template_path ) {
			$template_path = $woocommerce->template_url;
		}

		$plugin_path  = WOO_EMAIL_TEMPLATE_PATH;
		
		// Look within passed path within the theme - this is priority
		$template = locate_template(
									array(
										$template_path . $template_name,
										$template_name
									)
								);
		
		// ! $template && 
		if( file_exists( $plugin_path . $template_name ) ){

			$template = $plugin_path . $template_name;
		}

		if ( ! $template ){
			$template = $_template;
		}

		return $template;
	}

	public function email_header_before( $email_heading, $email ){
	    $GLOBALS['wooemail'] = $email;
	}

	public function woo_display_item_meta($html, $item, $args) {
		$order_options = get_option('woocommerce_new_order_settings');
		if (isset($order_options['email_type']) && $order_options['email_type'] == 'plain') {
			
			$strings = array();
			$html    = '';
			$args    = wp_parse_args( $args, array(
				'before'    => '<ul class="wc-item-meta"><li>',
				'after'     => '</li></ul>',
				'separator' => '</li><li>',
				'echo'      => true,
				'autop'     => false,
			) );

			foreach ( $item->get_formatted_meta_data() as $meta_id => $meta ) {
				$value     = $args['autop'] ? wp_kses_post( $meta->display_value ) : wp_kses_post( make_clickable( trim( $meta->display_value ) ) );

				$arr_val = array_filter(explode("\n",strip_tags($value)));
				$value = '';
				foreach ($arr_val as $val) {
					$value .= '- ' . $val . "\n";
				}

				$strings[] = '<strong class="wc-item-meta-label">' . wp_kses_post( $meta->display_key ) . ':</strong> ' . "\n" . $value;
			}

			if ( $strings ) {
				$html = $args['before'] . implode( $args['separator'], $strings ) . $args['after'];
			}
		}
		return $html;
	}
}
new Woo_Email;