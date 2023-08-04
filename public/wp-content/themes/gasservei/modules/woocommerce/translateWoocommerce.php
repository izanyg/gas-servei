<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

// TRASNALATE HACER OTRO PEDIDO
add_filter( 'gettext', function ( $translated, $untranslated, $domain ) {
    if ( ! is_admin() && 'woocommerce' === $domain ) {
        if ('Hacer otro pedido' === $translated) {
            $translated = 'Repetir pedido';
        }
    }

    return $translated;
}, 999, 3 );
