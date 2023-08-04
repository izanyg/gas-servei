<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

// removes form tags and changes action name
add_shortcode( 'sibwp_form_fields', function($attrs) {
    $id = $attrs['id'];
    $return = do_shortcode("[sibwp_form id=$id]");
    $return = preg_replace ('/<form[^>]*>/', ' ', $return);
    $return = str_replace ('</form>', ' ', $return);
    $return = str_replace ('subscribe_form_submit', 'subscribe_form_submit_register', $return);
    return $return;
});

add_action('init', function() {
	// Copied from sendinblue.php:367
	if ( isset( $_POST['sib_form_action'] ) && ( 'subscribe_form_submit_register' == sanitize_text_field($_POST['sib_form_action']) ) ) {
		register_checkbox_signup_process();
	}
});

// Copied from sendinblue.php:712
function register_checkbox_signup_process() {
	//Handling of backslash added by WP because magic quotes are enabled by default
	array_walk_recursive( $_POST, function(&$value) {
		$value = stripslashes($value);
	});
	
	if ( empty( $_POST['sib_security'] ) ) {
		wp_send_json(
			array(
				'status' => 'sib_security',
				'msg' => 'Token not found.',
			)
		);
	}
	$formID = isset( $_POST['sib_form_id'] ) ? sanitize_text_field( $_POST['sib_form_id'] ) : 1;
	if ( 'oldForm' == $formID ) {
		$formID = get_option( 'sib_old_form_id' );
	}
	$formData = SIB_Forms::getForm( $formID );

    if (!SIB_Manager::is_done_validation(false) || 0 == count($formData)) {
        wp_send_json(
            array(
                'status' => 'failure',
                'msg' => array("errorMsg" => "Something wrong occurred"),
            )
        );
    }

    // Recapcha removed

	$listID = $formData['listID'];
	// only suscribe if checked
	$listID = isset( $_POST['listIDs'] ) ? array_map( 'sanitize_text_field', $_POST['listIDs'] ) : [];
	if (empty($listID)) {
		$listID = array();
	}
	$interestingLists = isset( $_POST['interestingLists']) ?  array_map( 'sanitize_text_field', $_POST['interestingLists'] ) : array();
	$expectedLists = isset( $_POST['listIDs'] ) ? array_map( 'sanitize_text_field', $_POST['listIDs'] ) : array();
	if ( empty($interestingLists) )
    {
        $unlinkedLists = [];
    }
    else{
	    $unwantedLists = array_diff( $interestingLists, $expectedLists );
	    $unlinkedLists = array_diff( $unwantedLists, $listID);
	    $listID = array_unique(array_merge( $listID, $expectedLists ));
    }

	$email = isset( $_POST['email'] ) ? sanitize_email( $_POST['email'] ) : '';
	if ( ! is_email( $email ) ) {
		return;
	}

	$isDoubleOptin = $formData['isDopt'];
	$isOptin = $formData['isOpt'];
	$redirectUrlInEmail = $formData['redirectInEmail'];
	$redirectUrlInForm = $formData['redirectInForm'];

	$info = array();
	$attributes = explode( ',', $formData['attributes'] ); // String to array.
    if ( isset( $attributes ) && is_array( $attributes ) ) {
        foreach ( $_POST as $postAttribute => $postAttributeValue ) {
            $correspondingSibAttribute = register_getCorrespondingSibAttribute($postAttribute, $attributes);
            if (!empty($correspondingSibAttribute)) {
                $info[ $correspondingSibAttribute ] = sanitize_text_field( $postAttributeValue );
            }
        }
    }
	$templateID = $formData['templateID'];

	// if ( $isDoubleOptin ) {
	// 	/*
	// 	 * Double optin process
 //         * 1. add record to db
 //         * 2. send confirmation email with activate code
 //         */
	// 	$result = "success";
	// 	// Send a double optin confirm email.
	// 	if ( 'success' == $result ) {
	// 		// Add a recode with activate code in db.
	// 		$activateCode = $this->create_activate_code( $email, $info, $formID, $listID, $redirectUrlInEmail, $unlinkedLists );
	// 		SIB_API_Manager::send_comfirm_email( $email, 'double-optin', $templateID, $info, $activateCode );
	// 	}
	// } elseif ( $isOptin ) {
	// 	$result = SIB_API_Manager::create_subscriber( $email, $listID, $info, 'confirm', $unlinkedLists );
	// 	if ( 'success' == $result ) {
	// 		// Send a confirm email.
	// 		SIB_API_Manager::send_comfirm_email( $email, 'confirm', $templateID, $info );
	// 	}
	// } else {
		$result = SIB_API_Manager::create_subscriber( $email, $listID, $info, 'simple', $unlinkedLists );
	// }
	$msg = array(
		'successMsg' => $formData['successMsg'],
		'errorMsg' => $formData['errorMsg'],
		'existMsg' => $formData['existMsg'],
		'invalidMsg' => $formData['invalidMsg'],
	);

	// wp_send_json(
	// 	array(
	// 		'status' => $result,
	// 		'msg' => $msg,
	// 		'redirect' => $redirectUrlInForm,
	// 	)
	// );
}

// Copied from sendinblue.php:1416
/**
 * @param string $postAttribute
 * @param array $sibAttributes
 * @return null|string the corresponding sib attribute or null if not found
 */
function register_getCorrespondingSibAttribute($postAttribute, $sibAttributes)
{
    $normalizedPostAttribute = strtoupper(sanitize_text_field($postAttribute));
    foreach ($sibAttributes as $sibAttribute) {
        if ($normalizedPostAttribute == strtoupper($sibAttribute)) {
            return $sibAttribute;
        }
    }

    return null;
}

add_action('woocommerce_register_form', function() {
    echo do_shortcode("[sibwp_form_fields id=3]");
}, 80);