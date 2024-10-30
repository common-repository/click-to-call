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

function bte_c2c_is_valid_call($ip,$num) {
	global $wpdb;
	$now = date("Y-m-d H:i:s", time());
	$c2c_table_name = $wpdb->prefix . "bte_c2c_calls";
	
	$sql = "DELETE FROM ".$c2c_table_name." WHERE calltime<DATE_ADD(now(), INTERVAL - 60 MINUTE)";
	$res = $wpdb->query($sql);
	
	$sql = "SELECT COUNT(ID) FROM ".$c2c_table_name;

	if ($wpdb->get_var($sql." WHERE callmade=1")>=get_option('bte_c2c_totalcalls')) {
		$sql = "INSERT INTO ".$c2c_table_name." (calltime,ip,num,callmade) VALUES ('$now','$ip','$num',0);";
		$res = $wpdb->query($sql);
		return false;
	}
	
	$sql2 = $sql." WHERE ip='$ip'";
	if ($wpdb->get_var($sql2)>=get_option('bte_c2c_ipcalls')) {
		$sql = "INSERT INTO ".$c2c_table_name." (calltime,ip,num,callmade) VALUES ('$now','$ip','$num',0);";
		$res = $wpdb->query($sql);
		return false;
	}
		
	$sql2 = $sql." WHERE num='$num'";
	if ($wpdb->get_var($sql2)>=get_option('bte_c2c_numcalls')) {
		$sql = "INSERT INTO ".$c2c_table_name." (calltime,ip,num,callmade) VALUES ('$now','$ip','$num',0);";
		$res = $wpdb->query($sql);
		return false;
	}
	
	if (get_option('bte_c2c_US') && (strlen($num)!=15 || strpos($num,'1')!=4)) {
		$sql = "INSERT INTO ".$c2c_table_name." (calltime,ip,num,callmade) VALUES ('$now','$ip','$num',0);";
		$res = $wpdb->query($sql);
		return false;
	}
		
	$sql = "INSERT INTO ".$c2c_table_name." (calltime,ip,num,callmade) VALUES ('$now','$ip','$num',1);";
	$res = $wpdb->query($sql);
	return true;
}

function bte_c2c_get_html() {
	$bte_c2c_header = get_option('bte_c2c_header');
	if (!isset($bte_c2c_header)) {
		$bte_c2c_header = BTE_C2C_HEADER;
	}
	$bte_c2c_button = get_option('bte_c2c_button');
	if (!isset($bte_c2c_button)) {
		$bte_c2c_button = BTE_C2C_BUTTON;
	}
	$home = get_settings('siteurl');
	$base = '/'.end(explode('/', str_replace(array('\\','/BTE_c2c_core.php'),array('/',''),__FILE__)));
	$stylesheet = $home.'/wp-content/plugins' . $base . '/css/click2call.css';
	
	$s = $bte_c2c_header."<br/><form action=\"".$home."/wp-content/plugins" . $base . "/MakeCall.php\" method=\"post\"><input size=\"20\" name=\"bte_c2c_dest\" type=\"text\"  value=\"".BTE_C2C_FORM."\"/><br/><input type=\"submit\" name=\"submit\" value=\"" .$bte_c2c_button.
			"\"/>";
	if (get_option('bte_c2c_link')) {
		$s .= "<br/>Powered by <a href=\"http://www.blogtrafficexchange.com/click-to-call/\">Click to Call</a>";
	}
	$s.= "</form>";
	return $s;
}
?>