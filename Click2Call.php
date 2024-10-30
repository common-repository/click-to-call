<?php
/*
Plugin Name: Click to Call
Plugin URI: http://www.blogtrafficexchange.com/click-to-call
Description: Adding click to call capability to your blog will enable users to call you directly from your website. <a href="options-general.php?page=BTE_c2c_admin.php">Configuration options are here.</a></a>
Version: 1.4.6
Author: Blog Traffic Exchange
Author URI: http://www.blogtrafficexchange.com/
License: GPL
*/
/*  Copyright 2009-  Blog Traffic Exchange
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

require_once('BTE_c2c_admin.php');
require_once('BTE_c2c_core.php');

define (BTE_C2C_HEADER, 'Call My Phone'); 
define (BTE_C2C_FORM, '1xxxyyyzzzz'); 
define (BTE_C2C_BUTTON, 'Call Me'); 

// Play nice to PHP 5 installations with REGISTER_LONG_ARRAYS off
if(!isset($HTTP_POST_VARS) && isset($_POST))
{
	$HTTP_POST_VARS = $_POST;
}

register_activation_hook(__FILE__, 'bte_c2c_activate');
register_deactivation_hook(__FILE__, 'bte_c2c_deactivate');
add_action('admin_menu', 'bte_c2c_options_setup');
add_action('admin_head', 'bte_c2c_head_admin');
add_filter('plugin_action_links', 'bte_c2c_plugin_action_links', 10, 2);

function bte_c2c_widget($args) {
    extract($args);
	$bte_c2c_header = get_option('bte_c2c_header');
	if (!isset($bte_c2c_header)) {
		$bte_c2c_header = BTE_C2C_HEADER;
	}
	$bte_c2c_button = get_option('bte_c2c_button');
	if (!isset($bte_c2c_button)) {
		$bte_c2c_button = BTE_C2C_BUTTON;
	}
	$home = get_settings('siteurl');
	$base = '/'.end(explode('/', str_replace(array('\\','/Click2Call.php'),array('/',''),__FILE__)));
	$stylesheet = $home.'/wp-content/plugins' . $base . '/css/click2call.css';
	
	$s = "<form action=\"".$home."/wp-content/plugins" . $base . "/MakeCall.php\" method=\"post\"><input size=\"20\" name=\"bte_c2c_dest\" type=\"text\" value=\"".BTE_C2C_FORM."\"/><br/><input type=\"submit\" name=\"submit\" value=\"" .$bte_c2c_button.
			"\"/>";
	if (get_option('bte_c2c_link')) {
		$s .= "<br/>Powered by <a href=\"http://www.blogtrafficexchange.com/click-to-call/\">Click to Call</a>";
	}
	$s.= "</form>";
    ?>
        <?php echo $before_widget; ?>
            <?php echo $before_title
                . $bte_c2c_header
                . $after_title; ?>
           <?php echo $s; ?>
        <?php echo $after_widget; ?>
<?php
}
register_sidebar_widget('Click to Call',
    'bte_c2c_widget');


function bte_c2c_plugin_action_links($links, $file) {
	$plugin_file = basename(__FILE__);
	if (basename($file) == $plugin_file) {
		$settings_link = '<a href="options-general.php?page=BTE_c2c_admin.php">'.__('Settings', 'ClickToCall').'</a>';
		array_unshift($links, $settings_link);
	}
	return $links;
}

function bte_c2c() {
	echo bte_c2c_get_html();
}

function bte_c2c_deactivate() {
	global $wpdb;
	
	delete_option('bte_c2c_link');
	
	$c2c_table_name = $wpdb->prefix . "bte_c2c_calls";
	$sql = "DROP TABLE $c2c_table_name;";
	$res = $wpdb->query($sql);	
}

function bte_c2c_activate() {
	global $wpdb;
	
	add_option('bte_c2c_appid','');
	add_option('bte_c2c_consumerkey','');
	add_option('bte_c2c_secretkey','');
	add_option('bte_c2c_username','');
	add_option('bte_c2c_password','');
	add_option('bte_c2c_number','');
	add_option('bte_c2c_totalcalls','25');
	add_option('bte_c2c_ipcalls','3');
	add_option('bte_c2c_numcalls','3');
	add_option('bte_c2c_link',true);
	add_option('bte_c2c_US',true);
	add_option('bte_c2c_header',BTE_C2C_HEADER);
	add_option('bte_c2c_button',BTE_C2C_BUTTON);
	
	$result = mysql_list_tables(DB_NAME);
	$tables = array();
	while ($row = mysql_fetch_row($result)) {
		$tables[] = $row[0];
	}
	$c2c_table_name = $wpdb->prefix . "bte_c2c_calls";
	if (in_array($c2c_table_name, $tables)) {
		$sql = "DROP TABLE $c2c_table_name;";
		$res = $wpdb->query($sql);	
	}
   	$sql = "CREATE TABLE $c2c_table_name (
			ID bigint(20) NOT NULL AUTO_INCREMENT,
			calltime datetime NOT NULL,
			ip varchar(40) NOT NULL,
			num varchar(40) NOT NULL,
			callmade int NOT NULL,
			UNIQUE KEY id (id)
			);";
	$res = $wpdb->query($sql);
	$sql = "CREATE INDEX bte_c2c_calls_calltime_idx ON $c2c_table_name(calltime);";
	$res = $wpdb->query($sql);
	$sql = "CREATE INDEX bte_c2c_calls_ip_idx ON $c2c_table_name(ip);";
	$res = $wpdb->query($sql);
	$sql = "CREATE INDEX bte_c2c_calls_num_idx ON $c2c_table_name(num);";
	$res = $wpdb->query($sql);
	$sql = "CREATE INDEX bte_c2c_calls_callmade_idx ON $c2c_table_name(callmade);";
	$res = $wpdb->query($sql);
}

?>