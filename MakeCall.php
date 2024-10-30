<?php
/*  Copyright 2009-  Click to Call
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
require_once('../../../wp-blog-header.php');
require_once("Click2Call.php");
require_once("BTE_c2c_core.php");
require_once("ribbit/Ribbit.php");

if (isset($_POST['bte_c2c_dest'])) {
	$dest = preg_replace("/\D/","",$_POST['bte_c2c_dest']);
	$ln = '';
	if (strlen($dest)==10) {
		$ln = '1';
	}
	$dest = 'tel:'.$ln.$dest;
	if (bte_c2c_is_valid_call($_SERVER['REMOTE_ADDR'],$dest)) {
		try {
			$s = '<html><head><meta http-equiv="refresh" content="15;url='.$_SERVER["HTTP_REFERER"].'" /><title>Calling...</title></head><body><ul>';
			$s.= '<li>Calling...</li>';
			$src = 'tel:'.preg_replace("/\D/","",get_option('bte_c2c_number'));
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
			$ribbit = Ribbit::getInstance();
			$ribbit->setApplicationCredentials($bte_c2c_consumerkey, $bte_c2c_secretkey, $bte_c2c_appid, "", "");
			$ribbit->Login($bte_c2c_user,$bte_c2c_pass);
			$c = $ribbit->Calls()->createCall(array($src,$dest));
			$s .= '<li>Your phone is about to ring from '.get_option('bte_c2c_number').'. Answer it!</li>';
			$s .= '</ul> You should be redirected shortly to your original page: <a href="'.$_SERVER["HTTP_REFERER"].'">'.$_SERVER["HTTP_REFERER"].'</body></html>';
			echo $s;
			flush();
		} catch (Exception $e) {
			echo '<html><head><title>Not Calling...</title></head><body><ul>';
			echo '<li>Not calling due to unexpected error...</li>';
			echo '<li>At this time you must dial the number directly. Please dial '.get_option('bte_c2c_number').'.</li>';
			echo '</ul> You will not be redirected to return to your original page click here: <a href="'.$_SERVER["HTTP_REFERER"].'">'.$_SERVER["HTTP_REFERER"].'</body></html>';
			flush();	
		}
	} else {
		echo '<html><head><title>Not Calling...</title></head><body><ul>';
		echo '<li>Not calling due to high call volume or number is outside of allowed country...</li>';
		echo '<li>At this time you must dial the number directly. Please dial '.get_option('bte_c2c_number').'.</li>';
		echo '</ul> You will not be redirected to return to your original page click here: <a href="'.$_SERVER["HTTP_REFERER"].'">'.$_SERVER["HTTP_REFERER"].'</body></html>';
		flush();	
	}
} else {
header('Location: '.$_SERVER["HTTP_REFERER"]);
}
?>