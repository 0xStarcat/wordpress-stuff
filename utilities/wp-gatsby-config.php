<?php


// Provides various API related functions relating to a gatsby app.
// include this file into a `functions.php` theme file with:
// include('wp-gatsby-config.php');


// gets permalink for draft posts
// https://wordpress.stackexchange.com/questions/41588/how-to-get-the-clean-permalink-in-a-draft
function get_draft_permalink( $post_id ) {

  require_once ABSPATH . '/wp-admin/includes/post.php';
  list( $permalink, $postname ) = get_sample_permalink( $post_id );

  return str_replace( '%pagename%', 'draft', $permalink );
}


//
//
// CUSTOMIZE POST PREVIEW LINK
// Make sure to edit the PREVIEW_DOMAIN variable in functions.php!
// 
// 

add_filter('preview_post_link', function ($link) {
  global $post;
	$post_ID = $post->ID;
	
	if ($post->post_status != 'publish') {
         $uri = get_draft_permalink($post_ID);
    } else {
		$uri = get_permalink($post -> ID);
	}

	return PREVIEW_DOMAIN
		. wp_make_link_relative($uri)
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