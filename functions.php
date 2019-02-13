<?php

/**
 * Child Theme Function
 *
 */

add_action( 'after_setup_theme', 'mantis_child_theme_setup' );
add_action( 'wp_enqueue_scripts', 'mantis_child_enqueue_styles', 20);

if( !function_exists('mantis_child_enqueue_styles') ) {
    function mantis_child_enqueue_styles() {
        wp_enqueue_style( 'mantis-child-style',
            get_stylesheet_directory_uri() . '/style.css',
            array( 'mantis-theme' ),
            wp_get_theme()->get('Version')
        );

    }
}

if( !function_exists('mantis_child_theme_setup') ) {
    function mantis_child_theme_setup() {
        load_child_theme_textdomain( 'mantis-child', get_stylesheet_directory() . '/languages' );
    }
}

function extend_mimetypes($mime_types){
    $mime_types['woff'] = 'application/x-font-woff';
    return $mime_types;
}
add_filter('upload_mimes', 'extend_mimetypes', 1, 1);

function hook_javascript() {
    ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-118293806-2"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-118293806-2');
       </script>
    <?php
}
add_action('wp_head', 'hook_javascript');

function delivery_time() {
  echo '<tr><th>' . esc_html__( 'Delivery time', 'mantis-child' ) . '</th><td>3-5 ' . esc_html__( 'days', 'mantis-child' )  . '</td></tr>';
}
add_action( 'woocommerce_review_order_before_submit', 'add_checkout_privacy_policy', 9 );

function add_checkout_privacy_policy() {

    woocommerce_form_field( 'newsletter', array(
        'type'          => 'checkbox',
        'class'         => array('form-row newsletter'),
        'label_class'   => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
        'input_class'   => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
        'required'      => false,
        'label'         => __('I want to subscribe to the newsletter', 'mantis-child'),
    ));
}

add_action( 'woocommerce_cart_totals_after_shipping', 'delivery_time', 90);
add_action( 'woocommerce_review_order_after_shipping', 'delivery_time', 90);

add_filter( 'woocommerce_billing_fields', 'wc_npr_filter_phone', 10, 1 );

function wc_npr_filter_phone( $address_fields ) {
    $address_fields['billing_phone']['required'] = false;
    return $address_fields;
}
