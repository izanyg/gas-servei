<?php
/**
 * Model class <i>SIB_Model_Country</i> represents country code
 *
 * @package SIB_Model
 */

class SIB_Model_Country {

	/** Create Table */
	public static function create_table() {
		global $wpdb;

		$result = $wpdb->query(
			"CREATE TABLE IF NOT EXISTS {$wpdb->prefix}sib_model_country (
			`id` int(20) NOT NULL AUTO_INCREMENT,
			`iso_code` varchar(255),
            `call_prefix` int(10),
            PRIMARY KEY (`id`)
			)"
		);

		return $result;
	}

	/**
	 * Remove table.
	 */
	public static function remove_table() {
		global $wpdb;

		$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}sib_model_country" );
	}

	/**
	 * Get data by id
	 *
	 * @param $id
	 */
	public static function get_prefix( $code ) {
		global $wpdb;

		$results = $wpdb->get_var( $wpdb->prepare( "select call_prefix from {$wpdb->prefix}sib_model_country where iso_code= %s", array( esc_sql( $code ) ) ) );

		if ( null !== $results ) {
			return $results;
		} else {
			return false;
		}
	}

	/** Add record */
	public static function add_record( $iso_code, $call_prefix ) {
		global $wpdb;

		$wpdb->query( $wpdb->prepare( "INSERT INTO {$wpdb->prefix}sib_model_country (iso_code,call_prefix)  VALUES (%s,%d)", array( esc_sql( $iso_code ), esc_sql( $call_prefix ) ) ) );

		return true;

	}

	public static function Initialize( $data ) {
		foreach ( $data as $code => $prefix ) {
			self::add_record( $code, $prefix );
		}
	}

	/** Add prefix to the table */
	public static function add_prefix() {
		global $wpdb;

		if ( 'sib_model_country' === $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', array( 'sib_model_country' ) ) ) ) {
				$wpdb->query( "ALTER TABLE sib_model_country  RENAME TO {$wpdb->prefix}sib_model_country" );
		}
	}

}
