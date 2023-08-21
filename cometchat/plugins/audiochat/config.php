<?php

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'config.php');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* SETTINGS START */

$audioPluginType = setConfigValue('audioPluginType','0');
$selfhostedwebrtc = setConfigValue('selfhostedwebrtc','');

/* SETTINGS END */

$camWidth = '225';
$camHeight = '200';

/* audioPluginType Codes
1. CometChat Servers (WebRTC)
*/

$webRTCServer = 'r.chatforyoursite.com';
$webRTCPHPServer = 's.chatforyoursite.com';

if($audioPluginType == '1'){
	$webRTCServer = $webRTCPHPServer = $selfhostedwebrtc;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////