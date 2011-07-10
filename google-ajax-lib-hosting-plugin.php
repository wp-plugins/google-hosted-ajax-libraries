<?php
/*
Plugin Name: Google Hosted AJAX Libraries
Plugin URI: http://w3prodigy.com/wordpress-plugins/google-hosted-ajax-libraries/
Description: This plugin changes the internal WordPress script queues for the following AJAX Libraries: jQuery, jQuery UI, Prototype, Scriptaculous, MooTools, Yahoo! User Interface, Dojo, SWFObject, Ext-Core, Chrome Frame and WebFont Loader.
Version:  1.3
Author: Jay Fortner
Author URI: http://w3prodigy.com
License: GNU General Public License v2
*/

new w3p_Google_Hosted_AJAX_Libraries;

class w3p_Google_Hosted_AJAX_Libraries {
	
	function w3p_Google_Hosted_AJAX_Libraries()
	{
		$this->settings = array(
			'jquery' => 'http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js',
			'jquery-ui-core' => 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js',
			'prototype' => 'http://ajax.googleapis.com/ajax/libs/prototype/1.6.1.0/prototype.js',
			'scriptaculous' => 'http://ajax.googleapis.com/ajax/libs/scriptaculous/1.8.3/scriptaculous.js',
			'moo-tools' => 'http://ajax.googleapis.com/ajax/libs/mootools/1.2.4/mootools-yui-compressed.js',
			'dojo' => 'http://ajax.googleapis.com/ajax/libs/dojo/1.4.1/dojo/dojo.xd.js',
			'swfobject' => 'http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js',
			'yui' => 'https://ajax.googleapis.com/ajax/libs/yui/3.3.0/build/yui/yui-min.js',
			'extcore' => 'http://ajax.googleapis.com/ajax/libs/ext-core/3.1.0/ext-core.js',
			'chrome-frame' => 'http://ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js',
			'webfont-loader' => 'http://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js'
			);
		
		add_action('init', array(&$this,'init'));
	} // function
	
	function init()
	{	
		if( is_admin() )
			return false;
		
		foreach($this->settings as $slug => $url) {
			wp_deregister_script( $slug );
			wp_register_script($slug,$url);
		} // foreach
	} // function
	
} // class
