<?php

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'config.php');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* SETTINGS START */

$screensharePluginType = setConfigValue('screensharePluginType','0');
$selfhostedwebrtc = setConfigValue('selfhostedwebrtc','');

/* SETTINGS END */

$hostAddress = '';
$port = '1935';
$application = 'screenshare';
$scrWidth = '640';
$scrHeight = '480';

/* videoPluginType Codes
0. CometChat Servers (WebRTC)
1. Self-hosted WebRTC
2. RED5
*/

$webRTCServer = 'r.chatforyoursite.com';
$webRTCPHPServer = 's.chatforyoursite.com';

if ($screensharePluginType == '0') {
	$scrWidth = '640';
	$scrHeight = '480';
}

if ($screensharePluginType == '1') {
	$webRTCServer = $webRTCPHPServer = $selfhostedwebrtc;
}