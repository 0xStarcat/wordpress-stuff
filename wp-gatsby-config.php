<?php

// Provides various API related functions relating to a gatsby app.
// include this file into a `functions.php` theme file with:
// include('wp-gatsby-config.php');

//
//
// ALLOWS X-WP-NONCE HEADER
//
//

add_filter( 'graphql_access_control_allow_headers', function( $headers ) {
	return array_merge( $headers, [ 'x-wp-nonce' ] );
});

//
//
// allows the wpgraphql endpoint /graphql to 
// accept live preview requests from localhost
//
//

add_filter( 'graphql_response_headers_to_send', function( $headers ) {
  return array_merge( $headers, [
    'Access-Control-Allow-Origin'  => 'http://localhost:8000',
    'Access-Control-Allow-Credentials' => 'true'
  ] );
} );
?>