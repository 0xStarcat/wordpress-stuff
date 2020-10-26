<?php


// Provides various API related functions relating to a gatsby app.
// include this file into a `functions.php` theme file with:
// include('wp-gatsby-config.php');



//
//
// CUSTOMIZE POST PREVIEW LINK
// Make sure to edit the $preview_domain variable!
// 
// 

add_filter('preview_post_link', function ($link) {
  global $post;
	$post_ID = $post->ID;

	return PREVIEW_DOMAIN
		. wp_make_link_relative(get_permalink($post -> ID))
		. '?preview=true&nonce='
		. wp_create_nonce('wp_rest')
	    . '&id='
    . $post_ID
    . '&post_type='
		. get_post_type($post);
});


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