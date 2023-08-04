<?php

/*
 * Plugin Name:  Add-on: WPML - Back In Stock Notifier for WooCommerce
 * Description: WPML Support Add-on for Back In Stock Notifier
 * Author: codewoogeek
 * Plugin URI: https://codewoogeek.online/shop/back-instock-notifier/wpml/
 * Author URI: https://codewoogeek.online
 * Version: 2.0
 */

if (!defined('ABSPATH')) {
	exit;
}

if (!class_exists('CWG_Instock_Notifier_WPML')) {

	class CWG_Instock_Notifier_WPML {

		public function __construct() {
			add_filter('cwginstock_localization_array', array($this, 'translate_localization_array'));
			add_action('cwginstock_after_insert_subscriber', array($this, 'insert_data_about_current_lang'), 1, 2);
			add_filter('cwginstock_trigger_status_product', array($this, 'add_translated_ids'), 10, 2);
			add_filter('cwginstock_trigger_status_variation', array($this, 'add_translated_ids'), 10, 2);
			//for instock mail
			add_action('cwg_instock_before_instock_mail', array($this, 'perform_before_mail'), 1, 2);
			add_action('cwg_instock_after_instock_mail', array($this, 'perform_after_mail'), 1, 2);

			add_filter('wpml_user_language', array($this, 'fetch_default_language'), 999, 2);
			add_filter('cwginstock_cart_link', array($this, 'validate_cart_url'), 10, 3);
		}

		public function translate_localization_array( $translation) {
			if (defined('ICL_LANGUAGE_CODE')) {
				$translation['wpml_current_lang'] = ICL_LANGUAGE_CODE;
			}
			return $translation;
		}

		public function insert_data_about_current_lang( $id, $data) {
			if (isset($data['dataobj']['wpml_current_lang'])) {
				update_post_meta($id, 'cwg_wpml_lang', $data['dataobj']['wpml_current_lang']);
			}
		}

		public function get_translated_ids_from_wpml( $ids, $type) {
			$get_translated_ids = array();
			//run only when wpml is enabled
			if (function_exists('icl_get_languages')) {

				$all_languages = icl_get_languages();
				if (is_array($ids) && !empty($ids)) {
					foreach ($ids as $each_id) {
						foreach ($all_languages as $lang => $row) {
							$get_translated_ids[] = icl_object_id($each_id, $type, false, $lang);
						}
					}
				}
			}

			return $get_translated_ids;
		}

		public function add_translated_ids( $subscriber_ids, $pid) {
			$array_of_id = array($pid);
			$translated_ids = $this->get_translated_ids_from_wpml($array_of_id, 'product');
			$get_subscriber_ids = $this->get_posts($translated_ids);
			if (is_array($get_subscriber_ids) && !empty($get_subscriber_ids)) {
				$subscriber_ids = array_unique(array_merge($subscriber_ids, $get_subscriber_ids));
			}
			return $subscriber_ids;
		}

		public function perform_before_mail( $to, $id) {
			global $sitepress;
			$lang = get_post_meta($id, 'cwg_wpml_lang', true);
			if (!$lang) {
				$lang = $sitepress->get_default_language();
			}

			$current_lang = $sitepress->get_current_language();
			$sitepress->switch_lang($lang, true);
		}

		public function perform_after_mail( $to, $id) {
			global $sitepress;
			$default_language = $sitepress->get_default_language();
			$sitepress->switch_lang($default_language, true);
		}

		public function fetch_default_language( $lang, $email) {
			// fetch the last choosed language of corresponding email user
			$lang = $this->get_subscriber_lang($lang, $email);
			return $lang;
		}

		public function get_subscriber_lang( $lang, $email) {
			$args = array(
				'post_type' => 'cwginstocknotifier',
				'fields' => 'ids',
				'posts_per_page' => 1,
				'post_status' => array('cwg_subscribed', 'cwg_mailsent'),
				'meta_query' => array(
					array(
						'key' => 'cwginstock_subscriber_email',
						'value' => $email,
						'compare' => '=',
					),
				),
			);

			//fetch the last language of corresponding user
			$get_posts = get_posts($args);
			if (is_array($get_posts) && !empty($get_posts)) {
				foreach ($get_posts as $each_id) {
					$lang = get_post_meta($each_id, 'cwg_wpml_lang', true);
					if ('' != $lang) {
						return $lang;
					}
				}
			}
			return $lang;
		}

		public function get_posts( $array_of_ids) {
			$get_data = array();
			if ($array_of_ids) {
				$args = array(
					'post_type' => 'cwginstocknotifier',
					'fields' => 'ids',
					'posts_per_page' => -1,
					'post_status' => 'cwg_subscribed',
					'meta_query' => array(
						array(
							'key' => 'cwginstock_pid',
							'value' => (array) $array_of_ids,
							'compare' => 'IN',
						)
					)
				);
				$get_data = get_posts($args);
			}
			return $get_data;
		}

		public function validate_cart_url( $url, $pid, $id) {
			if (filter_var($url, FILTER_VALIDATE_URL) === false) {
				$product = wc_get_product($pid);
				if ($product) {
					$get_permalink = $product->get_permalink();
					$url = esc_url_raw(add_query_arg(array('add-to-cart' => $pid), $get_permalink));
				}
			}
			return $url;
		}

	}

	new CWG_Instock_Notifier_WPML();
}
