<?php

// Provides various API related functions.
// include this file into a `functions.php` theme file with:
// include('wp-api-config.php');


//
//
//
//
// REGISTER ACF FIELDS TO API RESPONSES
// https://stackoverflow.com/questions/56473929/how-to-expose-all-the-acf-fields-to-wordpress-rest-api-in-both-pages-and-custom
// https://support.advancedcustomfields.com/forums/topic/json-rest-api-and-acf/
//
//
//
//

function create_ACF_meta_in_REST() {
  $postypes_to_exclude = ['acf-field-group','acf-field'];
  $extra_postypes_to_include = ["page", "people", "post"];
  $post_types = array_diff(get_post_types(["_builtin" => false], 'names'),$postypes_to_exclude);

  array_push($post_types, $extra_postypes_to_include);

  foreach ($post_types as $post_type) {
      register_rest_field( $post_type, 'ACF', [
          'get_callback'    => 'expose_ACF_fields',
          'schema'          => null,
     ]
   );
  }

}

function expose_ACF_fields( $object ) {
  $ID = $object['id'];
  return get_fields($ID);
}

add_action( 'rest_api_init', 'create_ACF_meta_in_REST' );


//
//
//
//
//// HIDE USERS API ENDPOINT
//
//
//
//

add_filter( 'rest_endpoints', function( $endpoints ){
  if ( isset( $endpoints['/wp/v2/users'] ) ) {
      unset( $endpoints['/wp/v2/users'] );
  }
  if ( isset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] ) ) {
      unset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
  }
  return $endpoints;
});

?>