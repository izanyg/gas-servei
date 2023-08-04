<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}


/**
 * my_acf_google_map_api
 *
 * @param  mixed $api
 * @return void
 */
function my_acf_google_map_api( $api ){
    
  $api['key'] = dotEnvReader('GOOGLE_API_KEY', 'AIzaSyAaDb7lUF_AuRN6gEqavXxTHLIZLxnemj0');

  return $api;

}

add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');