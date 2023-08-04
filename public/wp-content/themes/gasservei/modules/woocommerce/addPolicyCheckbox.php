<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

remove_action( 'woocommerce_checkout_terms_and_conditions', 'wc_checkout_privacy_policy_text', 20 );

remove_action( 'woocommerce_register_form', 'wc_registration_privacy_policy_text', 20 );
add_action( 'woocommerce_register_form', function () {
	woocommerce_form_field( 'privacy_policy_reg', array(
	'type'          => 'checkbox',
	'class'         => array('form-row privacy'),
	'label_class'   => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
	'input_class'   => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
	'required'      => true,
	'label'         => wp_kses_post( wc_replace_policy_page_link_placeholders( wc_get_privacy_policy_text( 'registration' ) ) ),
	));  
}, 50);
  
// Show error if user does not tick
add_filter( 'woocommerce_registration_errors', function ( $errors, $username, $email ) {
	if ( ! is_checkout() ) {
		if ( ! (int) isset( $_POST['privacy_policy_reg'] ) ) {
			$errors->add( 'privacy_policy_reg_error', __( 'Debes aceptar la política de privacidad.', 'woocommerce' ) );
		}
	}
	return $errors;
}, 10, 3 );
