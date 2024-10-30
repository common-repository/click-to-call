<?php
/*  Copyright 2008-2009  Blog Traffic Exchange (email : kevin@blogtrafficexchange.com)
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
require_once('Click2Call.php');
require_once('BTE_c2c_core.php');
function bte_c2c_head_admin() {
	wp_enqueue_script('jquery-ui-tabs');
	$home = get_settings('siteurl');
	$base = '/'.end(explode('/', str_replace(array('\\','/BTE_c2c_admin.php'),array('/',''),__FILE__)));
	$stylesheet = $home.'/wp-content/plugins' . $base . '/css/click2call.css';
	echo('<link rel="stylesheet" href="' . $stylesheet . '" type="text/css" media="screen" />');
}

function bte_c2c_options() {		
	$message = null;
	$message_updated = __("Click to Call Options Updated.", 'bte_c2c');
	if (!empty($_POST['bte_c2c_action'])) {
		$message = $message_updated;
		if (isset($_POST['bte_c2c_appid'])) {
			update_option('bte_c2c_appid',$_POST['bte_c2c_appid']);
		}
		if (isset($_POST['bte_c2c_consumerkey'])) {
			update_option('bte_c2c_consumerkey',$_POST['bte_c2c_consumerkey']);
		}
		if (isset($_POST['bte_c2c_secretkey'])) {
			update_option('bte_c2c_secretkey',$_POST['bte_c2c_secretkey']);
		}
		if (isset($_POST['bte_c2c_user'])) {
			update_option('bte_c2c_user',$_POST['bte_c2c_user']);
		}
		if (isset($_POST['bte_c2c_pass'])) {
			update_option('bte_c2c_pass',$_POST['bte_c2c_pass']);
		}
		if (isset($_POST['bte_c2c_number'])) {
			update_option('bte_c2c_number',$_POST['bte_c2c_number']);
		}
		if (isset($_POST['bte_c2c_header'])) {
			update_option('bte_c2c_header',$_POST['bte_c2c_header']);
		}
		if (isset($_POST['bte_c2c_button'])) {
			update_option('bte_c2c_button',$_POST['bte_c2c_button']);
		}
		if (isset($_POST['bte_c2c_totalcalls'])) {
			update_option('bte_c2c_totalcalls',$_POST['bte_c2c_totalcalls']);
		}
		if (isset($_POST['bte_c2c_ipcalls'])) {
			update_option('bte_c2c_ipcalls',$_POST['bte_c2c_ipcalls']);
		}
		if (isset($_POST['bte_c2c_numcalls'])) {
			update_option('bte_c2c_numcalls',$_POST['bte_c2c_numcalls']);
		}
		if (isset($_POST['bte_c2c_US'])) {
			update_option('bte_c2c_US',$_POST['bte_c2c_US']);
		}
		
		
		print('
			<div id="message" class="updated fade">
				<p>'.__('Click to Call Options Updated.', 'bte_c2c').'</p>
			</div>');
	}
	$bte_c2c_appid = get_option('bte_c2c_appid');
	if (!isset($bte_c2c_appid)) {
		$bte_c2c_appid = "";
	}
	$bte_c2c_consumerkey = get_option('bte_c2c_consumerkey');
	if (!isset($bte_c2c_consumerkey)) {
		$bte_c2c_consumerkey = "";
	}
	$bte_c2c_secretkey = get_option('bte_c2c_secretkey');
	if (!isset($bte_c2c_secretkey)) {
		$bte_c2c_secretkey = "";
	}
	$bte_c2c_user = get_option('bte_c2c_user');
	if (!isset($bte_c2c_user)) {
		$bte_c2c_user = "";
	}
	$bte_c2c_pass = get_option('bte_c2c_pass');
	if (!isset($bte_c2c_pass)) {
		$bte_c2c_pass = "";
	}
	$bte_c2c_number = get_option('bte_c2c_number');
	if (!isset($bte_c2c_number)) {
		$bte_c2c_number = "";
	}
	$bte_c2c_header = get_option('bte_c2c_header');
	if (!isset($bte_c2c_header)) {
		$bte_c2c_header = BTE_C2C_HEADER;
	}
	$bte_c2c_button = get_option('bte_c2c_button');
	if (!isset($bte_c2c_button)) {
		$bte_c2c_button = BTE_C2C_BUTTON;
	}
	$bte_c2c_totalcalls = get_option('bte_c2c_totalcalls');
	if (!isset($bte_c2c_totalcalls)) {
		$bte_c2c_totalcalls = 100;
	}
	$bte_c2c_ipcalls = get_option('bte_c2c_ipcalls');
	if (!isset($bte_c2c_ipcalls)) {
		$bte_c2c_ipcalls = 5;
	}
	$bte_c2c_numcalls = get_option('bte_c2c_numcalls');
	if (!isset($bte_c2c_numcalls)) {
		$bte_c2c_numcalls = 5;
	}
	$bte_c2c_US = get_option('bte_c2c_US');
	if (!isset($bte_c2c_US)) {
		$bte_c2c_US = true;
	}
	
	
		
	print('
			<div class="wrap">
				<h2>'.__('Click to Call', 'Click2Call').' <a href="http://www.blogtrafficexchange.com">Blog Traffic Exchange</a></h2>
				<form id="bte_c2c" name="bte_click2call" action="'.get_bloginfo('wpurl').'/wp-admin/options-general.php?page=BTE_c2c_admin.php" method="post">
					<input type="hidden" name="bte_c2c_action" value="bte_c2c_update_settings" />
					<fieldset class="options">
						<div class="option">
							<p>To use Click to Call you need a Ribbit developer account.</p>
							<p>Here is how you get one: <a href="http://developer.ribbit.com">Ribbit Developer Center</a></p>
							<p>Once you have your Ribbit App created populate the values below and save:</p>
						</div>
						<div class="option">
							<label for="bte_c2c_appid">'.__('App ID: ', 'bte_c2c').'</label>
							<input size="80" name="bte_c2c_appid" type="text" value="'.htmlspecialchars(stripslashes($bte_c2c_appid)).'" /><br/>
							<label for="bte_c2c_consumerkey">'.__('Consumer Key: ', 'bte_c2c').'</label>
							<input size="80" name="bte_c2c_consumerkey" type="text" value="'.htmlspecialchars(stripslashes($bte_c2c_consumerkey)).'" /><br/>
							<label for="bte_c2c_secretkey">'.__('Secret Key: ', 'bte_c2c').'</label>
							<input size="80" name="bte_c2c_secretkey" type="text" value="'.htmlspecialchars(stripslashes($bte_c2c_secretkey)).'" /><br/>
							<label for="bte_c2c_user">'.__('Ribbit Username: ', 'bte_c2c').'</label>
							<input size="80" name="bte_c2c_user" type="text" value="'.htmlspecialchars(stripslashes($bte_c2c_user)).'" /><br/>
							<label for="bte_c2c_pass">'.__('Ribbit Password: ', 'bte_c2c').'</label>
							<input size="80" name="bte_c2c_pass" type="password" value="'.htmlspecialchars(stripslashes($bte_c2c_pass)).'" /><br/>
							<label for="bte_c2c_number">'.__('Your number: ', 'bte_c2c').'</label>
							<input size="80" name="bte_c2c_number" type="text" value="'.htmlspecialchars(stripslashes($bte_c2c_number)).'" /><br/>
							<label for="bte_c2c_header">'.__('Header Text: ', 'bte_c2c').'</label>
							<input size="80" name="bte_c2c_header" type="text" value="'.htmlspecialchars(stripslashes($bte_c2c_header)).'" /><br/>
							<label for="bte_c2c_button">'.__('Button Text: ', 'bte_c2c').'</label>
							<input size="80" name="bte_c2c_button" type="text" value="'.htmlspecialchars(stripslashes($bte_c2c_button)).'" /><br/>
							<label for="bte_c2c_totalcalls">'.__('Calls per hour: ', 'bte_c2c').'</label>
							<input size="80" name="bte_c2c_totalcalls" type="text" value="'.htmlspecialchars(stripslashes($bte_c2c_totalcalls)).'" /><br/>
							<label for="bte_c2c_ipcalls">'.__('Calls per hour per IP: ', 'bte_c2c').'</label>
							<input size="80" name="bte_c2c_ipcalls" type="text" value="'.htmlspecialchars(stripslashes($bte_c2c_ipcalls)).'" /><br/>
							<label for="bte_c2c_numcalls">'.__('Calls per hour per Number: ', 'bte_c2c').'</label>
							<input size="80" name="bte_c2c_numcalls" type="text" value="'.htmlspecialchars(stripslashes($bte_c2c_numcalls)).'" /><br/>
						</div>
						<div class="option">
							<label for="bte_c2c_US">'.__('Only allow calls to US? ', 'bte_c2c').'</label>
							<select name="bte_c2c_US" id="bte_c2c_US">
									<option value="0" '.bte_c2c_optionselected(0,$bte_c2c_US).'>'.__('No', 'bte_c2c').'</option>
									<option value="1" '.bte_c2c_optionselected(1,$bte_c2c_US).'>'.__('Yes', 'bte_c2c').'</option>
							</select>
						</div>
						
						<div class="option">
							<p>Code to place Click to Call widget.</p>
							<p><strong>PHP: <code>&lt;?php if (function_exists(\'bte_c2c\')) { bte_c2c(); } ?&gt;</code></strong></p>
							<p><strong>HTML: <code>'.htmlspecialchars(bte_c2c_get_html()).'</code></strong></p>
						</div>
					</fieldset>
					<p class="submit">
						<input type="submit" name="submit" value="'.__('Update Click to Call Options', 'bte_c2c').'" />
					</p>
				</form>' );

}

function bte_c2c_optionselected($opValue, $value) {
	if($opValue==$value) {
		return 'selected="selected"';
	}
	return '';
}

function bte_c2c_options_setup() {	
	add_options_page('Click2Call', 'Click to Call', 10, basename(__FILE__), 'bte_c2c_options');
}

?>