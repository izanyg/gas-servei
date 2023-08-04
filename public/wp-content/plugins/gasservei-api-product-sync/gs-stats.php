<?php

if (!defined('ABSPATH'))
    exit;

function gs_database_stats_no_update() {
	gs_database_stats(false);
}

function gs_database_stats($update=true) {
    $tables = ['gss_actionscheduler_actions', 'gss_actionscheduler_claims', 'gss_actionscheduler_groups', 'gss_actionscheduler_logs', 'gss_berocket_termmeta', 'gss_commentmeta', 'gss_comments', 'gss_icl_content_status', 'gss_icl_core_status', 'gss_icl_flags', 'gss_icl_languages', 'gss_icl_languages_translations', 'gss_icl_locale_map', 'gss_icl_message_status', 'gss_icl_mo_files_domains', 'gss_icl_node', 'gss_icl_reminders', 'gss_icl_string_batches', 'gss_icl_string_packages', 'gss_icl_string_positions', 'gss_icl_strings', 'gss_icl_string_status', 'gss_icl_string_translations', 'gss_icl_translate', 'gss_icl_translate_job', 'gss_icl_translation_batches', 'gss_icl_translation_downloads', 'gss_icl_translations', 'gss_icl_translation_status', 'gss_links', 'gss_options', 'gss_postmeta', 'gss_posts', 'gss_sib_model_contact', 'gss_sib_model_forms', 'gss_sib_model_lang', 'gss_sib_model_users', 'gss_termmeta', 'gss_term_relationships', 'gss_terms', 'gss_term_taxonomy', 'gss_usermeta', 'gss_users', 'gss_wc_admin_note_actions', 'gss_wc_admin_notes', 'gss_wc_category_lookup', 'gss_wc_customer_lookup', 'gss_wc_download_log', 'gss_wc_order_coupon_lookup', 'gss_wc_order_product_lookup', 'gss_wc_order_stats', 'gss_wc_order_tax_lookup', 'gss_wc_product_attributes_lookup', 'gss_wc_product_meta_lookup', 'gss_wc_rate_limits', 'gss_wc_reserved_stock', 'gss_wc_tax_rate_classes', 'gss_wc_webhooks', 'gss_woocommerce_api_keys', 'gss_woocommerce_attribute_taxonomies', 'gss_woocommerce_log', 'gss_woocommerce_order_itemmeta', 'gss_woocommerce_order_items', 'gss_woocommerce_payment_tokenmeta', 'gss_woocommerce_payment_tokens', 'gss_woocommerce_sessions', 'gss_woocommerce_shipping_zone_locations', 'gss_woocommerce_shipping_zone_methods', 'gss_woocommerce_shipping_zones', 'gss_woocommerce_tax_rate_locations', 'gss_woocommerce_tax_rates', 'gss_wpmm_subscribers', 'gss_wsal_metadata', 'gss_wsal_occurrences'];
    global $wpdb;
    $results = get_option('gs-stats', []);
    if (empty($results))
    	$results = [];
    foreach($tables as $table) {
        $count = $wpdb->get_results( "SELECT count(*) as c FROM $table" );
        $count = $count[0]->c;
        $results[$table][] = $count;
    }
    if ($update)
    	update_option('gs-stats', $results);
    foreach($results as $table => $values) {
    	echo str_pad($table,40,' ');
    	foreach($values as $value)
    		echo str_pad($value,7,' ').' ';
    	echo nl();
    }
    // echo array_to_table($result);
}

function array_to_table($array) {
	$tbody = array_reduce($array, function($a, $b){return $a.="<tr><td>".implode("</td><td>",$b)."</td></tr>";});
	$thead = "<tr><th>" . implode("</th><th>", array_keys($array)) . "</th></tr>";

	return "<table>\n$thead\n$tbody\n</table>";	
}