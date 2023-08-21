<?php

/*

CometChat
Copyright (c) 2016 Inscripts

CometChat ('the Software') is a copyrighted work of authorship. Inscripts
retains ownership of the Software and any copies of it, regardless of the
form in which the copies may exist. This license is not a sale of the
original Software or any copies.

By installing and using CometChat on your server, you agree to the following
terms and conditions. Such agreement is either on your own behalf or on behalf
of any corporate entity which employs you or which you represent
('Corporate Licensee'). In this Agreement, 'you' includes both the reader
and any Corporate Licensee and 'Inscripts' means Inscripts (I) Private Limited:

CometChat license grants you the right to run one instance (a single installation)
of the Software on one web server and one web site for each license purchased.
Each license may power one instance of the Software on one domain. For each
installed instance of the Software, a separate license is required.
The Software is licensed only to you. You may not rent, lease, sublicense, sell,
assign, pledge, transfer or otherwise dispose of the Software in any form, on
a temporary or permanent basis, without the prior written consent of Inscripts.

The license is effective until terminated. You may terminate it
at any time by uninstalling the Software and destroying any copies in any form.

The Software source code may be altered (at your risk)

All Software copyright notices within the scripts must remain unchanged (and visible).

The Software may not be used for anything that would represent or is associated
with an Intellectual Property violation, including, but not limited to,
engaging in any activity that infringes or misappropriates the intellectual property
rights of others, including copyrights, trademarks, service marks, trade secrets,
software piracy, and patents held by individuals, corporations, or other entities.

If any of the terms of this Agreement are violated, Inscripts reserves the right
to revoke the Software license at any time.

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

*/

include_once(dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."plugins.php");
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."config.php");

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR."en.php");
if (file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$lang.".php")) {
	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$lang.".php");
}

if ($p_<4) exit;

if($screensharePluginType == '1') {
	$screensharePluginType = '0';
}

checkScreenshareConfig();

	if ($screensharePluginType == '0') {
		$to = mysqli_real_escape_string($GLOBALS['dbh'],$_REQUEST['to']);
		if (!empty($_REQUEST['chatroommode']) && !empty($_REQUEST['initiator'])) {
			$grp = md5($to).md5(mysqli_real_escape_string($GLOBALS['dbh'],$_REQUEST['initiator']));
		} else {
			$grp = $userid<$to? md5($userid).md5($to) : md5($to).md5($userid);
		}
	} else {
		$grp = mysqli_real_escape_string($GLOBALS['dbh'],$_REQUEST['id']);
	}

	if ($_GET['action'] == 'request') {
        if (!empty($_REQUEST['chatroommode'])) {
   			sendChatroomMessage($_REQUEST['to'],$screenshare_language[2]." <a href='javascript:void(0);' class='acceptSceenshare' to='".$_REQUEST['to']."' grp='".$grp."' initiator='".$userid."' join_url='' start_url='' chatroommode='1' mobileAction=\"javascript:jqcc.ccscreenshare.accept('".$_REQUEST['to']."','".$grp."','','', 'chatroommode');\">".$screenshare_language[3]."</a>",0);
        } else {
   			sendMessage($_REQUEST['to'],$screenshare_language[2]." <a href='javascript:void(0);' class='acceptSceenshare' to='".$userid."' grp='".$grp."' join_url='' start_url='' chatroommode='0' mobileAction=\"javascript:jqcc.ccscreenshare.accept('".$userid."','".$grp."');\">".$screenshare_language[3]."</a> ".$screenshare_language[4],1);
            $temp_callback = $_REQUEST['callback'];
            $_REQUEST['callback'] = time();
            sendMessage($_REQUEST['to'],$screenshare_language[5],2);
            $_REQUEST['callback'] = $temp_callback;
        }

		if (!empty($_GET['callback'])) {
			header('content-type: application/json; charset=utf-8');
			echo $_GET['callback'].'()';
		}
	}

	if ($_GET['action'] == 'accept') {
		sendMessage($_REQUEST['to'],$screenshare_language[6],1);

		if (!empty($_GET['callback'])) {
			header('content-type: application/json; charset=utf-8');
			echo $_GET['callback'].'()';
		}
	}

	if ($_GET['action'] == 'screenshare') {
		global $lightboxWindows;

		$id = $_GET['id'];
		$type = $_GET['type'];

		if (!empty($_GET['chatroommode'])) {
			if(!empty($_GET['roomid'])){
				sendChatroomMessage($_GET['roomid'],$screenshare_language[2]." <a href='javascript:void(0);' class='acceptSceenshare' to='".$userid."' grp='".$_GET['id']."' join_url='' start_url='' chatroommode='1' mobileAction=\"javascript:jqcc.ccscreenshare.accept('".$userid."','".$_GET['id']."');\">".$screenshare_language[3]."</a>",0);
			}
		}

		ini_set('display_errors', 0);

		if ($screensharePluginType == '2') {
			$connectUrl = "rtmp://" . $hostAddress . "/" . $application;

			if ($type == 1) {
				echo <<<EOD
					<!DOCTYPE html>
					<html>
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
					<title>{$screenshare_language[0]}</title>
					<style>
					html, body, div, span, applet, object, iframe,
					h1, h2, h3, h4, h5, h6, p, blockquote, pre,
					a, abbr, acronym, address, big, cite, code,
					del, dfn, em, font, img, ins, kbd, q, s, samp,
					small, strike, strong, sub, sup, tt, var,
					dl, dt, dd, ol, ul, li,
					fieldset, form, label, legend,
					table, caption, tbody, tfoot, thead, tr, th, td {
						margin: 0;
						padding: 0;
						border: 0;
						outline: 0;
						font-weight: inherit;
						font-style: inherit;
						font-size: 100%;
						font-family: inherit;
						vertical-align: baseline;
						text-align: center;
					}

					html {
					  height: 100%;
					  overflow: hidden; /* Hides scrollbar in IE */
					}

					body {
					  height: 100%;
					  margin: 0;
					  padding: 0;
					  background:#000000;
					}

					#flashcontent {
					  height: 100%;
					}
					</style>
					</head>
					<body>
						<applet name="Screensharing" code="screenshare.ScreenShare.class" archive="ScreenShare.jar" width="430" height="100">
							<param name="streamId" value="{$id}"/>
							<param name="host" value="{$hostAddress}"/>
							<param name="application" value="{$application}"/>
						</applet>
					</body>
					</html>
EOD;
			} else {
			echo <<<EOD
			<html>
				<head>
				<title>ScreenViewer</title>
					<script src="../../js.php?type=core&name=jquery"></script>
					<script>
						$ = jQuery = jqcc;
					</script>
					<script type="text/javascript" src="../../js.php?type=plugin&name=screenshare&subtype=fmsred5"></script>
					<script type="text/javascript">
					var screenViewer = null;
					</script>
				</head>
				<body topmargin="0" leftmargin="0" bottommargin="0" rightmargin="0" onload="setupApp()" onUnload="stopApp()">
				<div id="screenViewerDIV"></div>
				<script type="text/javascript">
						var stream = getPageParameter('stream', '{$id}');
						var url = getPageParameter('url', '{$connectUrl}');
						var control = getPageParameter('control', 'true');

						fo = new SWFObject("ScreenSharing.swf?rtmpUrl=" + url + "&recieverStream=" + stream + "&control=" + control, "screenViewerID", "100%", "100%", "9");
						fo.addParam("swLiveConnect", "true");
						fo.addParam("name", "screenViewerID");
						fo.write("screenViewerDIV");
				</script>
				</body>
				</html>
EOD;
			}
		} else if ($screensharePluginType == '0') {
			$grp = md5($channelprefix.$grp);

			if ($type == 1) {
				echo <<<EOD
					<!DOCTYPE html>
					<html>
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
					<title>{$screenshare_language[0]}</title>
					<script src="../../js.php?type=core&name=jquery"></script>
					<script>
						window.location = "https://{$webRTCPHPServer}/?room={$grp}&pluginname=screenshare&screenshare=1&cssurl=";
					</script>
					<style>
					html, body, div, span, applet, object, iframe,
					h1, h2, h3, h4, h5, h6, p, blockquote, pre,
					a, abbr, acronym, address, big, cite, code,
					del, dfn, em, font, img, ins, kbd, q, s, samp,
					small, strike, strong, sub, sup, tt, var,
					dl, dt, dd, ol, ul, li,
					fieldset, form, label, legend,
					table, caption, tbody, tfoot, thead, tr, th, td {
						margin: 0;
						padding: 0;
						border: 0;
						outline: 0;
						font-weight: inherit;
						font-style: inherit;
						font-size: 100%;
						font-family: inherit;
						vertical-align: baseline;
					}

					html {
					  height: 100%;
					  overflow: hidden; /* Hides scrollbar in IE */
					}

					body {
					  height: 100%;
					  margin: 0;
					  padding: 0;
					  background:#000000;
					}
					</style>
					</head>
					<body>
						<iframe id ="webrtc" src="//{$webRTCPHPServer}/?room={$grp}&pluginname=screenshare&screenshare=1&cssurl=" width=100% height=100% seamless allowfullscreen></iframe>
					</body>
					</html>
EOD;
			} else {
				echo <<<EOD
				<html>
					<head>
					<title>ScreenViewer</title>
						<script src="../../js.php?type=core&name=jquery"></script>
						<script>
						    window.location = "https://{$webRTCPHPServer}/?room={$grp}&pluginname=screenshare&screenshare=0&cssurl=";
						</script>
					</head>
					<body topmargin="0" leftmargin="0" bottommargin="0" rightmargin="0">
					<div id="screenViewerDIV"></div>
						<iframe id ="webrtc" src="//{$webRTCPHPServer}/?room={$grp}&pluginname=screenshare&screenshare=0&cssurl=" width=100% height=100% seamless allowfullscreen></iframe>
					</body>
					</html>
EOD;
			}
		}
	}


function checkScreenshareConfig(){

	global $hostAddress, $screensharePluginType, $webRTCPHPServer;

	$error = "<div style='background:white;'>Please configure this plugin using administration panel before using. <a href='http://www.cometchat.com/documentation/admin/plugins/screensharing-plugin/' target='_blank'>Click here</a> for more information.</div>";

	switch ($screensharePluginType) {
		case '2':
			if (empty($hostAddress)) {
				echo $error;
				exit;
			}
			break;
		case '0':
			if (empty($webRTCPHPServer)) {
				echo $error;
				exit;
			}
			break;
	}
}