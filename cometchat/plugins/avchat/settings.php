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

if (!defined('CCADMIN')) { echo "NO DICE"; exit; }

if (empty($_GET['process'])) {
	global $getstylesheet;
	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'config.php');

	$curl = 0;
	$errorMsg = '';

	$schkd = '';
	$wchkd = '';

	$hideSelfhostedSettings = '';
	
	$commonSettings = '';
	$avchat_mobile_warning = 'This option will work in mobile apps (iOS &amp; Android) and on modern desktop browsers which have support for webRTC.';
	
	if(!file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR.'OpenTok'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php')){
    	$curl = 1;
		$hideOTASettings = 'style="display:none;"';
		$errorMsg .= "<h2 id='errormsg' style='font-size: 11px; color: rgb(255, 0, 0);'>You must upload CometChat Opentok package before you can configure this plugin. Please visit the following <a href='http://www.cometchat.com/documentation/admin/plugins/audio-video-chat-plugin/opentok-2-0/' target = '_blank'> link</a> for directions. If you have already added it, please click <a href='#' onclick='javascript:window.location.reload();'>here</a> to refresh.</h2>";
    }
	$message = "<h3 id='data'></h3>";

	if ($videoPluginType == '1') {
		$schkd = "selected";
		$errorMsg = '';
        $hideSelfhostedSettings = '';
	}else if ($videoPluginType == '0') {
		$wchkd = "selected";
		$commonSettings = 'display:none;';
		$hideSelfhostedSettings = 'style="display:none;"';
        $avchat_mobile_warning = 'This option will work in mobile apps (iOS &amp; Android) and on modern desktop browsers which have support for webRTC (Chrome, Firefox &amp; Opera)';
	} else {
		$hideSelfhostedSettings = 'style="display:none;"';
		$errorMsg = '';
	}


echo <<<EOD
<!DOCTYPE html>

<html>
<head>
	<script type="text/javascript" src="../js.php?admin=1"></script>
	<script type="text/javascript" language="javascript">

		$(function() {
			$('#errormsg').hide();
			var selected = $("#pluginTypeSelector :selected").val();
			if(selected=="0") {
				$('h3').show();
				$('#data').html('This option will work in mobile apps (iOS &amp; Android) and on modern desktop browsers which have support for webRTC.');
				$('#avchat_mobile_warning').html('').hide();
			} else if(selected=="1") {
				$('h3').show();
				$('#data').html('This option will work in mobile apps (iOS &amp; Android) and on modern desktop browsers which have support for webRTC.');
				$('#avchat_mobile_warning').html('').hide();
			} else {
				$("#centernav").hide();
				$("#SelfhostedSettings").hide();
				$('h3').show();
				$('#data').html('This option will work in mobile apps (iOS &amp; Android) and on modern desktop browsers which have support for webRTC.');
			}

			$("#pluginTypeSelector").change(function() {
				var selected = $("#pluginTypeSelector :selected").val();
				var errorMsg = 0;
				$('#avchat_mobile_warning').html('This option does not support audio/video chat on mobile.');
				if(selected=="1") {
					$("#centernav").show();
                    $(".SelfhostedSettings").show();
					$('h3').show();
					$('#errormsg').hide();
					$('#data').html('This option will work in mobile apps (iOS &amp; Android) and on modern desktop browsers which have support for webRTC.');
				} else if(selected=="0") {
					$("#centernav").hide();
					$("#SelfhostedSettings").hide();
					$('h3').show();
					$('#data').html('This option will work in mobile apps (iOS &amp; Android) and on modern desktop browsers which have support for webRTC.');
				}
				resizeWindow();
			});

			setTimeout(function(){
				resizeWindow();
			},200);
		});
		function resizeWindow() {
			window.resizeTo(650, ($('form').outerHeight(false)+window.outerHeight-window.innerHeight));
		}
	</script>

	$getstylesheet

</head>

<body>
	<form style="height:100%" action="?module=dashboard&action=loadexternal&type=plugin&name=avchat&process=true" method="post">
	<div id="content" style="width:auto">
			<h2>Audio/Video Chat Settings</h2><br />
					{$message}
			<div style="margin-bottom:10px;">
					<div class="title">Use :</div>
					<div class="element" id="">
						<select name="videoPluginType" id="pluginTypeSelector">
							<option value="0" {$wchkd}>CometChat Servers (WebRTC)</option>
							<option value="1" {$schkd}>SelfHosted WebRTC</option>
						</select>
					</div>
					<div style="clear:both;padding:10px;"></div>
					<div id="avchat_mobile_warning" style="padding:8px; border-radius: 7px;border: 1px solid #cccccc;width: 90%;">{$avchat_mobile_warning}</div>
					<div style="clear:both;padding:10px;"></div>
					{$errorMsg}

					<div id="centernav" style="width:380px; $commonSettings ">
		                <div class="SelfhostedSettings" $hideSelfhostedSettings>
							<div class="title" >Server URL:</div><div class="element"><input type="text" class="inputbox" name="selfhostedwebrtc" value="$selfhostedwebrtc"></div>
						</div>
					</div>

				<div style="clear:both;padding:5px;"></div>
			</div>
				 
			<div style="clear:both;padding:7.5px;"></div>
			<input type="submit" value="Update Settings" class="button">&nbsp;&nbsp;or <a href="javascript:window.close();">cancel or close</a>
	</div>
	</form>
</body>
</html>
EOD;
} else {
	configeditor($_POST);
	header("Location:?module=dashboard&action=loadexternal&type=plugin&name=avchat");
}