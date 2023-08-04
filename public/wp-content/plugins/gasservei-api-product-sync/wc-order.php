<?php

if (!defined('ABSPATH'))
    exit;

add_filter('woocommerce_checkout_posted_data', function($data) {
	$data['doc'] = get_next_order_number();
	if (is_gs_client())
		$data['gs_client_id'] = gs_get_api_client()['Codi'];
	return $data;
}, 99, 1);

add_action( 'woocommerce_checkout_update_order_meta', function ( $order_id, $data) {
    if ( isset( $data['warehouse']) )
        update_post_meta( $order_id, 'warehouse', $data['warehouse'] );
    if ( isset( $data['doc']) )
	    update_post_meta( $order_id, 'gsdoc', $data['doc'] );
    if ( isset( $data['gs_client_id']) )
	    update_post_meta( $order_id, 'gs_client_id', $data['gs_client_id'] );
}, 99, 2);

// add_action('woocommerce_new_order', function ($order_id) {
// add_action('woocommerce_checkout_order_processing', function ($order_id) {
add_action('woocommerce_checkout_create_order', function ($order, $data) {
// add_action('woocommerce_checkout_order_processed', function ($order_id, $posted_data, $order) {
	error_log('Creating WC order');
	// $order = new WC_Order( $order_id );
	// $warehouse = get_post_meta($order_id, 'warehouse', true);
	$warehouse = $data['warehouse']!=-1 ? $data['warehouse'] : '';
	$doc = $data['doc'];
	// $doc = get_post_meta($order_id, 'gsdoc', true);
	$current_user = wp_get_current_user();
	$cif = get_user_meta( get_current_user_id(), 'cif', true );
	$cli = gs_get_api_client() ? gs_get_api_client()['Codi'] : '0';
	$shipping_address = $order->get_shipping_address_1();
	if ($order->get_shipping_address_2())
		$shipping_address.= ' '.$order->get_shipping_address_2();
	$billing_address = $order->get_billing_address_1();
	if ($order->get_billing_address_2())
		$billing_address.= ' '.$order->get_billing_address_2();

	$order_cap = [
		'DOC' => $doc,
		'CLI' => $cli,
		'DATA' => '',
		'ALM' => $warehouse ?? '',
		'EMAIL' => $current_user->user_email,
		'CP1' => 'CREDIT',
		'ENVIO' => $order->get_shipping_total(),
		'TOT' => $order->get_total(),
		'NOMF' => $order->get_billing_first_name().' '.$order->get_billing_last_name(),
		'NOMC' => $order->get_billing_company(),
		'CIF' => $cif,
		'DIRF' => $billing_address,
		'POBF' => $order->get_billing_city(),
		'PROF' => wc_get_state_name($order->get_billing_country(), $order->get_billing_state()),
		'CPF' => $order->get_billing_postcode(),
		'PAISF' => $order->get_billing_country(),
		'TELF' => $order->get_billing_phone(),
		'MOV' => '',
		'FAX' => '',
		'WEB' => '',
		'HORF' => '',
		'PRI' => '1',
		'COM' => '1',
		'IVA' => '1',
		'DIR' => $shipping_address,
		'POB' => $order->get_shipping_city(),
		'PRO' => wc_get_state_name($order->get_shipping_country(), $order->get_shipping_state()),
		'CP' => $order->get_shipping_postcode(),
		'PAIS' => $order->get_shipping_country(),
		'TEL' => $order->get_shipping_phone(),
		'HOR' => '',
		'OBS' => $data['order_comments'],
	];
	global $gasserveiapi;
	error_log('Cabecera pedido: '.line_print($order_cap));
	$result = $gasserveiapi->order_cap($order_cap);
	if (!$result)
		throw new Exception("Error Processing Request", 1);
	if ($result[0]['NumErr']!=0)
		throw new Exception("Error Processing Request: ".$result[0]['DesErr'], 1);
	error_log('Cabecera pedido return: '.line_print($result));
	$order_body = [];
	$items = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
	foreach( $items as $item ) {
		$order_body[] = [
			'ARTI' => get_post_meta($item->get_variation_id(), 'gsean', true),
			'STKACT' => $item->get_quantity(),
			'PREU' => $item->get_total(),
			'DOC' => $order_cap['DOC'],
		];
	}
	error_log('Cuerpo pedido: '.line_print($order_body));
	$result = $gasserveiapi->order_body($order_body);
	error_log('Cuerpo pedido return: '.line_print($result));
	if (!$result)
		throw new Exception("Error Processing Request", 1);
	if ($result[0]['NumErr']!=0)
		throw new Exception("Error Processing Request: ".$result[0]['DesErr'], 1);
	gs_update_client_data();
}, 10, 3);

add_filter( 'woocommerce_order_number', function($id, $order) {
	return get_post_meta($order->get_id(), 'gsdoc', true);
}, 2, 99);

// add_action('woocommerce_before_account_orders', function($has_orders) {
add_filter('woocommerce_order_query_args', function($query_vars) {
	// $query_vars['paginate'] = false;
	$query_vars['limit'] = 1000;
	if (is_gs_client() && is_gs_tenant()) {
		$query_vars['customer'] = '';
		$query_vars['meta_key'] = 'gs_client_id';
		$query_vars['meta_value'] = gs_get_api_client()['Codi'];		
	}
	return $query_vars;
}, 1, 99);

add_filter('user_has_cap', function($allcaps, $caps, $args, $user) {
	if ( isset( $caps[0] ) ) {
		if ( $caps[0]=='view_order' && is_gs_client() && is_gs_tenant()) {
			$user_id = intval( $args[1] );
			$order = wc_get_order( $args[2] );
			if ($order->get_meta('gs_client_id')==gs_get_api_client()['Codi']) {
				$allcaps['view_order'] = true;
			}
		}
	}
	return $allcaps;
}, 10, 4);

add_filter('woocommerce_order_query', function($results, $args) {
	if (!isset($results->orders))
		return $results;
	if (!($client=gs_get_api_client()))
		return $results;
	$order_statuses = [
		0 => 'wc-gs-pending-accept',
		1 => 'wc-gs-accepted',
		2 => 'wc-gs-sent',
	];	
	global $gasserveiapi;
	$api_orders = $gasserveiapi->orders_id_keys($client['Codi']);

	foreach($results->orders as $key => &$order) {
		$doc = get_post_meta($order->get_id(), 'gsdoc', true);
		if (!isset($api_orders[$doc])) {
			wp_delete_post($order->get_id(),true);
			unset($results->orders[$key]);
			$results->total--;
			continue;
		}
		$api_order = $api_orders[$doc];
		// $api_order['url'] = 'https://www.youtube.com/';
		if (isset($api_order['url']) && $api_order['url'])
			$order->update_meta_data('mrv_url', $api_order['url']);
		// $api_order['mrv'] = '11111';
		if (isset($api_order['mrv']) && $api_order['mrv'])
			$order->update_meta_data('mrv_number', $api_order['mrv']);
		$order->set_status($order_statuses[$api_order['Fin']]);
		$order->save();
	}

	return $results;
}, 2, 99);

function get_next_order_number() {
	$number = get_option( 'gs_next_order_number', 0 );
	update_option( 'gs_next_order_number', ++$number );
	return $number;
}

add_filter('woocommerce_register_shop_order_post_statuses', function( $order_statuses ){
    return array_merge($order_statuses, get_gs_order_statuses());
}, 99, 1);

function get_gs_order_statuses() {
    // Status must start with "wc-"
    // Translate: _x('Pendiente de aceptar', 'Order status', 'woocommerce' )
    return [
		'wc-gs-pending-accept' => [                                            
		    'label'		=> _x('Pendiente de aceptar', 'Order status', 'woocommerce' ),
		    'public'                    => false,
		    'exclude_from_search'       => false,
		    'show_in_admin_all_list'    => true,                                         
		    'show_in_admin_status_list' => true,                                         
		],
		'wc-gs-accepted' => [
		    'label'		=> _x('Pedido Aceptado/ Pendiente de servir', 'Order status', 'woocommerce' ),
		    'public'                    => false,
		    'exclude_from_search'       => false,
		    'show_in_admin_all_list'    => true,                                         
		    'show_in_admin_status_list' => true,                                         
		],
		'wc-gs-sent' => [
		    'label'		=> _x('Pendiente enviado', 'Order status', 'woocommerce' ),
		    'public'                    => false,
		    'exclude_from_search'       => false,
		    'show_in_admin_all_list'    => true,                                         
		    'show_in_admin_status_list' => true,                                         
		],
    ];
}

add_filter( 'wc_order_statuses', function ( array $statuses ) {
	return array_merge($statuses, array_map(function($status) {
		return $status['label'];
	}, get_gs_order_statuses()));
});

add_filter('woocommerce_order_details_after_order_table', function($order) {
	$number = $order->get_meta('mrv_number');
	$url = $order->get_meta('mrv_url');
	if ($url || $number) {
		echo "
		<hr/>
		<section class='woocommerce-shipping-details'>";
		if ($url)
			echo "
			<a href='$url'>"._x('Seguir estado del envío', 'Order status', 'woocommerce' )."</a><br>";
		if ($number)
			echo "
			<span>Número de seguimiento: $number</span>";
		echo "
		</section>
		";
	}
});