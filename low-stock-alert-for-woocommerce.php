<?php
/*
 * Plugin Name: Low Stock Alert for WooCommerce
 * Description: Plugin to Show a alert in WooCommerce - Products and Product Loop when the current Stock is Low.
 * Version: 1.0
 * Author: Manuel Ramirez Coronel
 * Author URI: https://github.com/racmanuel
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Require the Composer - Autoload
 */
require_once __DIR__ . '/vendor/autoload.php';
/**
 * Require the CMB2 Settings
 */
require_once __DIR__ . '/cmb2-settings.php';
/**
 * Require the Enque Scripts and Styles
 */
require_once __DIR__ . '/enqueue.php';

/**
 * Get the CMB2 Options - Global Variable
 */
$lsafw_options = get_option('lsafw_options');

/*
 * Show a Alert in Single Product when the Product Stock is Low
 */
function lsafw_alert_in_single_product()
{
    if (is_product()) {

        /**
         * Get the CMB2 Options - Global Variable
         */
        global $lsafw_options;

        /**
         * WooCommerce Global Variable to access to the product
         */
        global $product;

        /**
         * If is a Simple Product do a code
         */

        if ($product->is_type('simple')) {

            /**
             * Variable to get a Random Number
             */
            $number_rand = rand($lsafw_options['lsafw_random_number_start'], $lsafw_options['lsafw_random_number_finish']);

            /**
             * Get the actual Product Stock Quantity
             */
            $Stock_Left = $product->get_stock_quantity();

            /**
             * Check if the Stock is < than the Options
             */
            if ($Stock_Left <= $lsafw_options['lsafw_minimum_stock']) {
                /**
                 * HTML Message to Show in Single Product
                 */
                ?>
            <div id="lsafw_alert">
                <div class="lsafw_alert_single_product">
                    <div class="lsafw_title">
                        <h4 class="animate__animated <?php echo $lsafw_options['lsafw_animation_title']; ?> animate__infinite">
                            <?php echo $lsafw_options['lsafw_title']; ?> <span
                                class="lsafw_call_to_action"><?php echo $lsafw_options['lsafw_call_to_action']; ?></span></h4>
                    </div>
                    <div class="lsafw_description animate__animated <?php echo $lsafw_options['lsafw_animation_description']; ?> animate__infinite"">
                            <?php if ($number_rand >= 2): ?>
                                <span><?php echo $number_rand; ?> <?php echo __('personas estan viendo el producto.'); ?></span>
                            <?php else: ?>
                                <span><?php echo $number_rand; ?> <?php echo __('persona esta viendo el producto.'); ?> </span>
                            <?php endif;?>
                    </div>
                </div>
            </div>
            <?php
            }
        }
    }
}
add_action('woocommerce_before_add_to_cart_quantity', 'lsafw_alert_in_single_product');

function bbloomer_show_stock_shop()
{
    if (is_shop()) {
        /**
         * Get the CMB2 Options - Global Variable
         */
        global $lsafw_options;

        /**
         * Get the Global Prodcut Varaible
         */
        global $product;

        /**
         * If is a Simple Product do a code
         */
        if ($product->is_type('simple')) {

            /**
             * Get the current Stock Quantity
             */
            $Stock_Left = $product->get_stock_quantity();

            /**
             * Check if the Current Stock is minor or the same to the Minimun Value in Settings
             */
            if ($Stock_Left <= $lsafw_options['lsafw_minimum_stock'] or $Stock_Left == $lsafw_options['lsafw_minimum_stock'] or $Stock_Left == !$lsafw_options['lsafw_minimum_stock']) {
                /**
                 * HTML Message to Show in Product Loop
                 */
                ?>
                    <div class=" lsafw_title">
            <span class="lsafw_call_to_action"><?php echo $lsafw_options['lsafw_call_to_action']; ?> quedan
                <?php echo wc_get_stock_html($product); ?></span>
        </div>
        <?php
            }
        }
    }
}
add_action('woocommerce_after_shop_loop_item', 'bbloomer_show_stock_shop', 10);