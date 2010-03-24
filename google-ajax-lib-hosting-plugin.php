<?php
/*
Plugin Name: Google Hosted AJAX Libraries
Plugin URI: 
Description: Allows administrators to enable or disable the use of Google hosted AJAX libraries.
Version:  1.0
Author: Jay Fortner
Author URI: http://code.google.com/p/w3prodigy-public
License: GNU General Public License v2
*/
global $google_ajax_lib_hosting_settings, $setting_pre;
$setting_pre = "google-ajax-lib-";
$google_ajax_lib_hosting_settings = array(
	'jquery' => 'http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js',
	'jquery-ui-core' => 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js',
	'prototype' => 'http://ajax.googleapis.com/ajax/libs/prototype/1.6.1.0/prototype.js',
	'scriptaculous' => 'http://ajax.googleapis.com/ajax/libs/scriptaculous/1.8.3/scriptaculous.js',
	'moo-tools' => 'http://ajax.googleapis.com/ajax/libs/mootools/1.2.4/mootools-yui-compressed.js',
	'dojo' => 'http://ajax.googleapis.com/ajax/libs/dojo/1.4.1/dojo/dojo.xd.js',
	'swfobject' => 'http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js',
	'yui' => 'http://ajax.googleapis.com/ajax/libs/yui/2.8.0r4/build/yuiloader/yuiloader-min.js',
	'extcore' => 'http://ajax.googleapis.com/ajax/libs/ext-core/3.1.0/ext-core.js',
	'chrome-frame' => 'http://ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js'
	);

add_action('init', 'google_ajax_lib_hosting_init');

function google_ajax_lib_hosting_init()
{
	global $google_ajax_lib_hosting_settings, $setting_pre;
	
	foreach($google_ajax_lib_hosting_settings as $slug => $url) {
		if(true == get_option($setting_pre . $slug)) {
			wp_deregister_script( $slug );
			wp_register_script($slug,$url);
			wp_enqueue_script($slug,$url);
		} // if
	} // foreach
	
} // function

add_action('admin_menu', 'google_ajax_lib_hosting_menu');

function google_ajax_lib_hosting_menu() 
{
	add_submenu_page('plugins.php', 'Google AJAX Libraries', 'Google AJAX Libraries', 'administrator', 'google-ajax-lib-hosting', 'google_ajax_lib_hosting_settings');
} // function

function google_ajax_lib_hosting_settings()
{
	global $google_ajax_lib_hosting_settings, $setting_pre;
	
	if( !empty($_POST) ) {
		$post_google = $_POST['google'];
		foreach($google_ajax_lib_hosting_settings as $slug => $url) {
			delete_option($setting_pre . $slug);
			if(!empty($post_google[$slug])) {
				update_option($setting_pre . $slug, $post_google[$slug]);
			} // if
		} // foreach
	} // if
	?>
	<div class="wrap">
	<div id="icon-themes" class="icon32"><br></div>
	<h2>Google AJAX Libraries</h2>
	<em><a href="http://code.google.com/apis/ajaxlibs/documentation/index.html" title="Google API for AJAX Libraries">http://code.google.com/apis/ajaxlibs/documentation/index.html</a></em>

	<form method="post" action="<?php echo $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']; ?>">
		<table class="form-table">

		<tr valign="top">
		<th scope="row">Available Libraries</th>
			<td>
				<?php
					$i = 0;
					foreach($google_ajax_lib_hosting_settings as $slug => $url){
						if(true == get_option($setting_pre . $slug)){ $checked = "checked='checked'"; } else { $checked = ""; } // if, else
						
						echo "<input type='checkbox' name='google[$slug]' value='true' $checked/> $slug";
						
						if($i % 2) { echo "</td><td>"; } else { echo "<br/>"; } // if, else
						$i++;
						
					} // foreach
				?>
			</td>
		</tr>
	
		</table>
	
		<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
	
	</form>
	</div>
	<?php
} // function

?>