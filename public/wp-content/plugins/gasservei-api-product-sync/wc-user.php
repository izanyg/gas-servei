<?php

if (!defined('ABSPATH'))
    exit;

function gs_check_cif($username, $email, $errors)
{
	if (empty($_POST['cif']) || trim($_POST['cif']) == '') {
		$errors->add('cif_error', __('Por favor, rellene su cif.', 'textdomain'));
		return $errors;
	}
	$cif = trim($_POST['cif']);

	global $gasserveiapi;
	$client = $gasserveiapi->clients($email);
	if (!$client) {
		$client = $gasserveiapi->clients(null, $cif);
		// Dont pass if cif exists in ERP and doesnt match email
		if ($client)
			$errors->add('cif_error', __('Cif erroneo.', 'textdomain'));
		// Pass if both email and cif don't exists in ERP
		return $errors;
	}
	if ($client['CIF']!=$cif) {
		$errors->add('cif_error', __('Cif erroneo.', 'textdomain'));
	} else {
		set_transient('gs_api_client_'.$email, $client, GS_TRANSIENT_EXPIRATION);
	}
	// Pass if both email and cif do exists and match in ERP
	return $errors;
}

add_action('woocommerce_register_post', 'gs_check_cif', 10, 3);

function gs_new_customer_data($customer_data) {
	if (!isset($customer_data['meta_input']))
		$customer_data['meta_input'] = [];
	if ($api_client=get_transient('gs_api_client_'.$customer_data['user_email'])) {
		$customer_data['meta_input'] = array_merge(
			$customer_data['meta_input'],
			gs_get_customer_data($api_client),
			[
				'gs_client' => true,
				'first_name' => ' ',
			]
			);
		// $customer_data['meta_input']['gs_client'] = true;
	} else {
		$customer_data['meta_input'] = array_merge(
			$customer_data['meta_input'],
			['gs_client' => false]
		);
	}
	return $customer_data;
}
add_filter('woocommerce_new_customer_data', 'gs_new_customer_data', 10, 1);

// update gs_client metadata on login
add_action( 'wp_login', 'gs_update_client_data', 10, 2);

function gs_update_client_data(string $user_login=null, WP_User $user=null) {
	if ($user!=null || is_user_logged_in()) {
		$user = $user ?? wp_get_current_user();
		$email = $user->user_email;
		global $gasserveiapi;
		$client = $gasserveiapi->clients($email);
		$gs_client = $client && get_cif($user)==$client['CIF'];
		if ($client)
			set_transient('gs_api_client_'.$email, $client, GS_TRANSIENT_EXPIRATION);
		update_user_meta( $user->ID, 'gs_client', $gs_client);
		$tenant = (bool) $gs_client && $gasserveiapi->tenant($client['Codi'], $email);
		update_user_meta( $user->ID, 'gs_tenant', $tenant);
	}
};

function woocommerce_remove_gateway_COD( $methods ) {
	if (is_admin())
		return $methods;
	// If gasservei client and fpago
	if (($client=gs_get_api_client()) && $client['FPago']=='1')
		return $methods;
		// $methods[] = 'WC_Gateway_Credit';

	$key = null;
	foreach($methods as $i => $method)
		if ($method=='WC_Gateway_COD')
			$key = $i;
	if ($key!==null)
		unset($methods[$key]);
	return $methods;
}
add_filter( 'woocommerce_payment_gateways', 'woocommerce_remove_gateway_COD' );

function gs_get_api_client() {
	if (is_user_logged_in()) {
		if (!is_gs_client())
			return null;
		$current_user = wp_get_current_user();
		$email = $current_user->user_email;
		if ($api_client = get_transient('gs_api_client_'.$email))
			return $api_client;
		global $gasserveiapi;
		$client = $gasserveiapi->clients($email);
		gs_update_customer_data($current_user->ID, $client);
		set_transient('gs_api_client_'.$email, $client, GS_TRANSIENT_EXPIRATION);
		return $client;
    }
    return null;
}

function gs_get_customer_data($api_client) {
	$country = $api_client['pais'];
	$billing_state = wc_get_state_code($country, $api_client['Nacio']);
	$data = array(
	    'billing_company'   => $api_client['Nom'],
	    'billing_city'          => $api_client['Poblacio'],
	    'billing_postcode'      => $api_client['Districte'],
	    'billing_phone'         => $api_client['Telefon'],
	    'billing_address_1'    => $api_client['Direccio'],
	    'billing_country'    => $country,
	    'billing_state'    => $billing_state,
	);
	return $data;
}

function gs_update_customer_data($user_id, $api_client) {
	$data = gs_get_customer_data($api_client);
	foreach ($data as $meta_key => $meta_value ) {
	    update_user_meta( $user_id, $meta_key, $meta_value );
	}	
}
add_filter( 'woocommerce_registration_auth_new_customer', '__return_false' );

function is_gs_client() {
	return get_user_meta( get_current_user_id(), 'gs_client', true );
}

function is_gs_tenant() {
	return get_user_meta( get_current_user_id(), 'gs_tenant', true );
}

function get_cif($user=null) {
	return get_user_meta( $user ? $user->ID : get_current_user_id(), 'cif', true);
}

add_filter('woocommerce_new_customer_username',
function($username, $email) {
	return $email;
}, 10, 2);