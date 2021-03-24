<?php
/**
 * Loop Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
?>

<?php if ( $price_html = $product->get_price_html() ) : 

	$get_variation_arr = get_post_meta($product->id, 'woo_product_variation_data', true);
    
    if (isset($get_variation_arr['size']) && !empty($get_variation_arr['size'])) {
    	$arr_price = array();
    	foreach ($get_variation_arr['size'] as $get_size) {
    		$arr_price[] = $get_size['size-price'];
    	}
    	$price = min($arr_price);
    	?>
    	<span class="price">
			<span class="woocommerce-Price-amount amount"><?php echo get_woocommerce_currency_symbol(); ?><?php echo $price; ?></span>+
		</span>
    	<?php
    } else {
    	?><span class="price"><?php echo $price_html; ?></span><?php
    }
	?>
	
<?php endif; ?>
