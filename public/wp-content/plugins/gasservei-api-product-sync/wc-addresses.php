<?php

if (!defined('ABSPATH'))
    exit;

function gs_get_warehouses() {
	if (!is_user_logged_in())
		return null;
	$current_user = wp_get_current_user();
	$email = $current_user->user_email;
	if ($warehouses = get_transient('gs_api_warehouses_'.$email))
		return $warehouses;	
	if (!($client=gs_get_api_client()))
		return null;
	global $gasserveiapi;
	$warehouses = $gasserveiapi->warehouses($client['CIF']);
	$warehouses = array_map(function($wh) {
		$wh['state_code'] = wc_get_state_code($wh['pais'], $wh['Nac']);
		return $wh;
	}, $warehouses);
	set_transient('gs_api_warehouses_'.$email, $warehouses, GS_TRANSIENT_EXPIRATION);
	return $warehouses;
}

// add_action( 'init', 'gs_init' );

function gs_init() {
	var_dump(gs_get_warehouses());
	die();
}

add_filter( 'woocommerce_checkout_fields' , 'gs_checkout_fields' );
function gs_checkout_fields( $fields ) {
	if ($warehouses=gs_get_warehouses()) {
		$options = [-1 => __('Selecciona un almacén', 'gasservei')];
		foreach($warehouses as $warehouse)
			$options[$warehouse['Num']] = 
				$warehouse['Pob'].' ('.
				(strlen($warehouse['Dir']) > 30 ? 
					substr($warehouse['Dir'],0,30)."..." : 
					$warehouse['Dir']).
				')';
		$fields['shipping']['warehouse'] = [
			'label' => 'Almacén',
			'type' => 'select',
			'options' => $options,
			'required' => false,
			'class' => ['form-row-wide'],
			'priority' => 5,
		];
	}
	return $fields;
}

add_action( 'woocommerce_before_checkout_shipping_form', 'gs_before_checkout_shipping_addresses' );
add_action( 'woocommerce_after_checkout_shipping_form', 'gs_after_checkout_shipping_addresses' );

function gs_before_checkout_shipping_addresses() {
	if ($warehouses=gs_get_warehouses()) {
		$js_warehouses = [];
		foreach($warehouses as $warehouse) {
			$js_warehouses[$warehouse['Num']] = $warehouse;
		}
		echo '<script>jQuery(document).ready(function($){
		var warehouses = '.json_encode($js_warehouses).';
		var ajaxurl = "'.admin_url('admin-ajax.php').'";
		var nonce = "'.wp_create_nonce("add_warehouse_nonce").'";

		$("#warehouse").change(function(e) {
			var num = $(e.target).val();
			if (num==-1) {
				$("#shipping_address_1").prop( "readonly", false );
				$("#shipping_address_2").prop( "readonly", false );
				$("#shipping_postcode").prop( "readonly", false );
				$("#shipping_city").prop( "readonly", false );
				// $("#shipping_state").prop( "readonly", false ).change();
				// $("#shipping_state").selectWoo( "readonly", false );
				$("#shipping_country").prop( "readonly", false ).change();
				$("#add_warehouse").prop( "disabled", false );
			} else {
				var warehouse = warehouses[num];
				$("#shipping_address_1").val(warehouse["Dir"]);
				$("#shipping_postcode").val(warehouse["Dis"]);
				$("#shipping_city").val(warehouse["Pob"]);
				$("#shipping_state").val(warehouse["state_code"]).change();
				$("#shipping_country").val(warehouse["pais"]).change();
				$("#shipping_address_1").prop( "readonly", true );
				$("#shipping_address_2").prop( "readonly", true );
				$("#shipping_postcode").prop( "readonly", true );
				$("#shipping_city").prop( "readonly", true );
				// $("#shipping_state").prop( "readonly", true ).change();
				// $("#shipping_state").selectWoo( "readonly", true );
				$("#shipping_country").prop( "readonly", true ).change();
				$("#add_warehouse").prop( "disabled", true );
			}
		});
		$("#warehouse>option:eq(1)").attr("selected", true);
		$("#warehouse").trigger("change");

		$("#add_warehouse").click(function(e) {
			e.preventDefault(); 
			jQuery.ajax({
				type : "post",
				dataType : "json",
				url : ajaxurl,
				data : {
					action: "add_warehouse", 
					nonce: nonce,
					shipping_address_1: $("#shipping_address_1").val(),
					shipping_postcode: $("#shipping_postcode").val(),
					shipping_city: $("#shipping_city").val(),
					shipping_state: $("#shipping_state").val(),
					shipping_country: $("#shipping_country").val(),
				},
				success: function(response) {
					if(response.type == "success") {
						alert("Almacén añadido correctamente")
					} else {
						alert("Hubo un error añadiendo el almacén")
					}
				}
			});
		});
		})</script>';
	}
}

function gs_after_checkout_shipping_addresses() {
	if (is_gs_client())
		echo '<button class="button" id="add_warehouse">Añadir como almacén</button>';
}

add_action("wp_ajax_add_warehouse", "gs_add_warehouse");
add_action("wp_ajax_nopriv_add_wharehouse", "gs_must_login");
function gs_add_warehouse() {
	if ( !wp_verify_nonce( $_REQUEST['nonce'], "add_warehouse_nonce")) {
		exit("No naughty business please");
	}
	$client = gs_get_api_client();
	$country = sanitize_text_field($_REQUEST['shipping_country']);
	$warehouse = [
		'Codi' => ''.$client['Codi'],
		'NUM' => '0',
		'DIR' => sanitize_text_field($_REQUEST['shipping_address_1']),
		'DIR2' => '',
		'DIS' => sanitize_text_field($_REQUEST['shipping_postcode']),
		'POB' => sanitize_text_field($_REQUEST['shipping_city']),
		'NAC' => wc_get_state_name($country, sanitize_text_field($_REQUEST['shipping_state'])),
		'OBS' => '',
		'PAIS' => $country,
	];
	// $result = $warehouse;
	// var_dump($warehouse);
	global $gasserveiapi;
	$result = $gasserveiapi->put_warehouse($warehouse);

	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		$result = json_encode($result);
		echo $result;
		die();
	}
	else {
		header("Location: ".$_SERVER["HTTP_REFERER"]);
	}	
}

function wc_get_state_code($country_code, $state_name) {
	$translations = [
		'A CORUÑA' => 'La Coruña',
		'BILBAO' => 'Bizkaia',
		'OVIEDO' => 'Asturias',
		'MALLORCA (ISLAS BALEARES)' => 'Las Palmas',
	];
	if (isset($translations[$state_name]))
		$state_name = $translations[$state_name];
	$states = WC()->countries->get_states( $country_code );
	foreach($states as $code => $state)
		if (stripAccents(strtolower($state))==stripAccents(strtolower($state_name)))
			return $code;
	return '';
}

function wc_get_state_name($country_code, $state_code) {
	$states = WC()->countries->get_states( $country_code );
	return $states[$state_code] ?? '';
}