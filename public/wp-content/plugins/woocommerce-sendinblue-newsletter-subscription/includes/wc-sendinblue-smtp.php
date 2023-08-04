<?php

class WC_Sendinblue_SMTP {

	const STATISTICS_DATE_FORMAT = 'Y-m-d';

	/**
	 * Smtp details.
	 */
	public static $smtp_details;

	public function __construct() {

	}

	/** Update smtp details. */
	public static function update_smtp_details() {
		self::$smtp_details = get_option( 'ws_smtp_detail', null );
		if ( null == self::$smtp_details ) {
			$mailin   = new SibApiClient();
			$response = $mailin->getAccount();
			if ( SibApiClient::RESPONSE_CODE_OK === $mailin->getLastResponseCode() ) {
				if ( true == $response['relay']['enabled'] ) {
					self::$smtp_details = $response['relay']['data'];
					update_option( 'ws_smtp_detail', self::$smtp_details );
					return true;
				} else {
					self::$smtp_details = array(
						'relay' => false,
					);
					update_option( 'ws_smtp_detail', self::$smtp_details );
					return false;
				}
			}
		}
		return false;
	}
	/**
	 * Send mail
	 *
	 * @params (type, to_email, subject, to_info, list_id)
	 */
	public static function send_email( $to_email, $subject, $type = 'double-optin', $code = '', $list_id = '', $template_id = 0, $attributes = null ) {
		$customizations   = get_option( 'wc_sendinblue_settings', array() );
		$general_settings = get_option( 'ws_main_option', array() );

		$mailin = new SibApiClient();

		// Get sender info.
		$sender_email = WC_Emails::instance()->get_from_address();
		$sender_name  = WC_Emails::instance()->get_from_name();
		if( '' === $sender_email ) {
			$sender_email = trim( get_bloginfo( 'admin_email' ) );
			$sender_name  = trim( get_bloginfo( 'name' ) );
		}

		// Send mail.
		$to   = array( array( 'email' => $to_email ) );
		$from = array(
			'email' => $sender_email,
			'name'  => $sender_name,
		);

		$null_array  = array();
		$site_domain = str_replace( 'https://', '', home_url() );
		$site_domain = str_replace( 'http://', '', $site_domain );

		if ( 0 == $template_id ) {
			// Default template.
			$template_contents = self::get_email_template( $type );
			$html_content      = $template_contents['html_content'];
		} else {
			$search_value = '({{\s*doubleoptin\s*}})';
			$templates    = WC_Sendinblue_API::get_templates();
			$template     = $templates[ $template_id ];
			$html_content = $template['content'];
			$text_content = $template['content'];
			$subject      = $template['subject'];
			$html_content = str_replace( 'https://[DOUBLEOPTIN]', '{subscribe_url}', $html_content );
			$html_content = str_replace( 'http://[DOUBLEOPTIN]', '{subscribe_url}', $html_content );
			$html_content = str_replace( 'https://{{doubleoptin}}', '{subscribe_url}', $html_content );
			$html_content = str_replace( 'http://{{doubleoptin}}', '{subscribe_url}', $html_content );
			$html_content = str_replace( 'https://{{ doubleoptin }}', '{subscribe_url}', $html_content );
			$html_content = str_replace( 'http://{{ doubleoptin }}', '{subscribe_url}', $html_content );
			$html_content = str_replace( '[DOUBLEOPTIN]', '{subscribe_url}', $html_content );
			$html_content = preg_replace( $search_value, '{subscribe_url}', $html_content );
		}
		$html_content = str_replace( '{title}', $subject, $html_content );
		$html_content = str_replace( '{site_domain}', $site_domain, $html_content );
		$html_content = str_replace(
			'{subscribe_url}',
			add_query_arg(
				array(
					'ws_action' => 'subscribe',
					'code'      => $code,
					'li'        => $list_id
				),
				home_url()
			),
			$html_content
		);
		if ( 'notify' == $type ) {
			// Code is current number of sms credits.
			$html_content = str_replace( '{present_credit}', $code, $html_content );
		}

		self::update_smtp_details();
		// All emails are sent using Sendinblue API.
		if ( false != self::$smtp_details['relay'] ) {
			$headers = array(
				'Content-Type' => 'text/html; charset=iso-8859-1',
				'X-Mailin-Tag' => 'Woocommerce Sendinblue',
			);
			$data    = array(
				'to'          => $to,
				'sender'      => $from,
				'subject'     => $subject,
				'htmlContent' => $html_content,
				'headers'     => $headers,
			);
			$result  = $mailin->sendEmail( $data );
			$result  = ( SibApiClient::RESPONSE_CODE_CREATED === $mailin->getLastResponseCode() ) ? true : false;
		} else {
			$headers[] = 'Content-Type: text/html; charset=UTF-8';
			$headers[] = "From: $sender_name <$sender_email>";

			$order_template_sib = WC_Sendinblue_Integration::$order_template_sib;
			if ( isset( $order_template_sib['id'] ) && 0 < $order_template_sib['id'] ) {
				if ( empty( $templates ) ) {
					$templates = WC_Sendinblue_API::get_templates();
				}
				if ( ! empty( $templates[ $order_template_sib['id'] ]['subject'] ) ) {
					$subject = $templates[ $order_template_sib['id'] ]['subject'];
				}
			}

			$result = @wp_mail( $to_email, $subject, $html_content, $headers );
		}
		return $result;
	}
	/**
	 * Get email template by type (test, confirmation, double-optin)
	 * Return @values : array ( 'html_content' => '...', 'text_content' => '...' );
	 */
	private static function get_email_template( $type = 'test' ) {
		$lang = get_bloginfo( 'language' );
		if ( 'fr-FR' == $lang ) {
			$file = 'temp_fr-FR';
		} else {
			$file = 'temp';
		}

		$file_path = plugin_dir_url( __FILE__ ) . 'templates/' . $type . '/';

		// Get html content.
		$html_content = file_get_contents( $file_path . $file . '.html' );

		// Get text content.
		if ( 'notify' != $type ) {
			$text_content = file_get_contents( $file_path . $file . '.txt' );
		} else {
			$text_content = 'This is a notify message.';
		}

		$templates = array(
			'html_content' => $html_content,
			'text_content' => $text_content,
		);

		return $templates;
	}
	/**
	 * Send double optin email
	 */
	public function double_optin_signup( $email, $list_id, $info, $template_id = 0 ) {
		// Db store.
		$data                  = SIB_Model_Contact::get_data_by_email( $email );
		$info['DOUBLE_OPT-IN'] = 1;
		if ( false == $data ) {
			$uniqid = uniqid();
			$data   = array(
				'email'       => $email,
				'info'        => base64_encode( maybe_serialize( $info ) ),
				'code'        => $uniqid,
				'is_activate' => 0,
				'extra'       => 0,
			);
			SIB_Model_Contact::add_record( $data );
		} else {
			$uniqid = $data['code'];
			$id     = $data['id'];
			$data   = array(
				'email'       => $email,
				'info'        => base64_encode( maybe_serialize( $info ) ),
				'code'        => $uniqid,
				'is_activate' => 0,
				'extra'       => 0,
			);
			SIB_Model_Contact::update_element( $id, $data );
		}

		// Send double optin email.
		$subject = __( 'Please confirm subscription', 'wc_sendinblue' );
		if ( ! self::send_email( $email, $subject, 'double-optin', $uniqid, $list_id, $template_id, $info ) ) {
			return 'fail';
		}

		return 'success';
	}
	/**
	 * Validation email.
	 */
	public function validation_email( $email, $list_id ) {
		$general_settings = get_option( 'ws_main_option', array() );

		$mailin   = new SibApiClient();
		$response = $mailin->getUser( $email );
		if ( SibApiClient::RESPONSE_CODE_OK != $mailin->getLastResponseCode() ) {
			$ret = array(
				'code'   => 'success',
				'listid' => array(),
			);
			return $ret;
		}

		$listid = $response['listIds'];
		if ( ! isset( $listid ) || ! is_array( $listid ) ) {
			$listid = array();
		}
		if ( true === $response['emailBlacklisted'] ) {
			$ret = array(
				'code'   => 'update',
				'listid' => $listid,
			);
		} else {
			if ( ! in_array( $list_id, $listid ) ) {
				$ret = array(
					'code'   => 'success',
					'listid' => $listid,
				);
			} else {
				$ret = array(
					'code'   => 'already_exist',
					'listid' => $listid,
				);
			}
		}
		return $ret;
	}

	/** Ajax module for get statistics regarding date range.  */
	public static function ajax_get_daterange() {
		wp_send_json( self::get_statistics() );
	}

	public static function get_statistics() {
		$today = gmdate( 'Y-m-d' );
		$begin = '';
		$end   = '';
		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( $_POST['nonce'] ) : '';
		if ( wp_verify_nonce( $nonce, 'stats_nonce' ) ) {
			if ( ! empty( $_POST['begin'] ) && isset( $_POST['begin'] ) && sanitize_text_field( $_POST['begin'] ) ) {
				$begin = ( new DateTime( sanitize_text_field( $_POST['begin'] ) ) )->format( self::STATISTICS_DATE_FORMAT );
			}
			if ( empty( $begin ) || $begin > $today ) {
				$begin = $today;
			}
			if ( ! empty( $_POST['end'] ) && isset( $_POST['end'] ) && sanitize_text_field( $_POST['end'] ) ) {
				$end = ( new DateTime( sanitize_text_field( $_POST['end'] ) ) )->format( self::STATISTICS_DATE_FORMAT );
			}
			if ( empty( $end ) || $end > $today ) {
				$end = $today;
			}
		} else {
			$begin = $today;
			$end   = $today;
		}
		return WC_Sendinblue::get_statistics( $begin, $end );
	}
}
