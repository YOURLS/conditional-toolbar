<?php
/*
Plugin Name: Conditional Toolbar
Plugin URI: http://blog.yourls.org/2011/03/yourls-plugin-example-conditional-toolbar/
Description: Wraps short URLs in the Toolbar when requested with URL sho.rt/tb/keyword instead of sho.rt/keyword
Version: 1.0
Author: Ozh
Author URI: http://ozh.org/
*/

// Customize this: directory of your Toolbar plugin 
define( 'OZH_TBURL_PLUGINDIR', 'sample-toolbar' );

// Customize this: keyword prefix that will trigger the Toolbar plugin
define( 'OZH_TBURL_PREFIX', 'tb/' );

yourls_add_action( 'loader_failed', 'ozh_tburl_toolbar' );
function ozh_tburl_toolbar( $args ) {
	// short URL requested?
	$shorturl = $args[0];
	
	// If it's a /tb/stuff URL:
	if( preg_match( '!^'. OZH_TBURL_PREFIX .'(.*)!', $shorturl, $matches ) ) {
		$keyword = yourls_sanitize_keyword( $matches[1] ); // 'stuff'

		// activate the toolbar plugin just for now
		include_once( YOURLS_PLUGINDIR.'/'. OZH_TBURL_PLUGINDIR .'/plugin.php' );
		
		// attempt redirection
		include( YOURLS_ABSPATH.'/yourls-go.php' );
		
		// prevent other plugins or normal operations from triggering
		exit;
	}
	
	// If it's not a /tb/stuff URL, do nothing and return to normal operations
}