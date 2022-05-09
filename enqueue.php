<?php
function lsafw_enqueue_scripts_and_styles()
{
    wp_register_style('lsafw-css', plugin_dir_url(__FILE__) . 'assets/css/lsafw.css', array(), '1.0', 'all');
    wp_enqueue_style('lsafw-css');
    wp_register_style('lsafw-animate-css', plugin_dir_url(__FILE__) . 'assets/css/animate.min.css', array(), '1.0', 'all');
    wp_enqueue_style('lsafw-animate-css');
}
add_action('wp_enqueue_scripts', 'lsafw_enqueue_scripts_and_styles');

function lsafw_enqueue_scripts_and_styles_admin(){
    wp_register_style( 'lsafw-css-admin', plugin_dir_url( __FILE__ ) . 'assets/css/lsafw-admin.css', array(), '1.0', 'all' );
    wp_enqueue_style('lsafw-css-admin');
}
add_action( 'admin_enqueue_scripts', 'lsafw_enqueue_scripts_and_styles_admin');