<?php

	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	add_filter('search_products_args', function($args) {
		$args['orderby'] = 'relevance';
		return $args;
	}, 10);
