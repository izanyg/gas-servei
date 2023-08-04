<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}
function woocommerce_edit_cif()
{
    $fields = array(
        'cif' => array(
            'type'        => 'text',
            'label'       => __( 'CIF', ' gasservei' ),
            'placeholder' => __( 'X0000000', 'gasservei' ),
            'required'    => true,
        ),
    );
    if (is_gs_client())
      $fields['cif']['custom_attributes'] = ['readonly' => 1];
    return apply_filters( 'woocommerce_forms_field', $fields);
}
function edit_cif_woocommerce()
{
    $user_id = get_current_user_id(); 
    $fields = woocommerce_edit_cif();
    foreach ( $fields as $key => $field_args ) {
        woocommerce_form_field( $key, $field_args, isset($_POST[$key]) ? $_POST[$key] : get_user_meta( $user_id, $key, true ) );
    }
}
add_action( 'woocommerce_register_form', 'edit_cif_woocommerce', 15 );
add_action( 'woocommerce_edit_account_form', 'edit_cif_woocommerce', 15, 0 );


add_filter( 'woocommerce_checkout_fields' , 'edit_cif_woocommerce_checkout' );
function edit_cif_woocommerce_checkout( $fields ) {
  if (!is_user_logged_in())
    $fields['billing']['cif'] = [
      'label' => __( 'CIF', ' gasservei' ),
      'type' => 'text',
      'placeholder' => __( 'X0000000', 'gasservei' ),
      'required' => true,
      'class' => ['form-row-wide'],
      'priority' => 25,
    ];
  return $fields;
}


function gs_save_register_fields( $customer_id )
{
	if ( isset( $_POST['cif'] ) ) {
		update_user_meta( $customer_id, 'cif', wc_clean( $_POST['cif'] ) );
	}
}
add_action( 'woocommerce_created_customer', 'gs_save_register_fields' );
add_action( 'woocommerce_save_account_details', 'gs_save_register_fields' );


function gs_validate_registration_fields( $errors, $username, $email ) {	
  return gs_validate_cif($errors); 
}
add_filter( 'woocommerce_registration_errors', 'gs_validate_registration_fields', 10, 3 );


function gs_validate_edit_user_fields( $errors ) {
	gs_validate_cif($errors);
}
add_action( 'woocommerce_save_account_details_errors', 'gs_validate_edit_user_fields', 10, 3 );


function gs_validate_cif($errors){  
	if ( empty( $_POST['cif'] ) )
  {
		$errors->add( 'cif', __('El CIF es obligatorio', 'gasservei') );
	}else if( preg_match( '/[^a-z0-9 ]+/i', $_POST['cif'] ) )
  {
		$errors->add( 'cif', __('El CIF debe contener solamente letras y números', 'gasservei') );
  }
  return $errors;
}

function gs_address_remove_name($address) {
  unset($address['first_name']);
  unset($address['last_name']);
  return $address;
}
add_filter('woocommerce_my_account_my_address_formatted_address', 'gs_address_remove_name', 100, 1);
add_filter('woocommerce_order_formatted_billing_address', 'gs_address_remove_name', 100, 1);
add_filter('woocommerce_order_formatted_shipping_address', 'gs_address_remove_name', 100, 1);
