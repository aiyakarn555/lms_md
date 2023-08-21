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

$navigation = <<<EOD
	<div id="leftnav">
		<a href="?module=plugins&amp;ts={$ts}" id="chat_plugins">One-on-one chat plugins</a>
		<a href="?module=plugins&amp;action=chatroomplugins&amp;ts={$ts}" id="chatroom_plugins">Chatroom plugins</a>
	</div>
EOD;

function index() {
	global $body;
	global $plugins;
	global $navigation;
    global $ts;
    $plugins_core = setConfigValue('plugins_core',array());

	if(defined('TAPATALK')&&TAPATALK==1&&in_array('stickers',$plugins)){
		unset($plugins_core['stickers']);
		if(!empty($plugins['stickers'])){
			unset($plugins['stickers']);
		}
	}

	$pluginslist = '';
	foreach ($plugins_core as $plugin => $plugininfo) {
		if (is_dir(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.$plugin)) {
			if($plugininfo[1] === 0 || $plugininfo[1] === 1){
				$titles[$plugin] = $plugininfo;

				$pluginhref = 'href="?module=plugins&amp;action=addplugin&amp;data='.$plugin.'&amp;ts='.$ts.'"';
				if (in_array($plugin,$plugins)) {
					$pluginhref = 'href="javascript: void(0)" style="opacity: 0.5;cursor: default;"';
				}

				$pluginslist .= '<li class="ui-state-default"><div class="cometchat_pluginsicon cometchat_'.$plugin.'" style="margin:0;margin-right:5px;float:left;"></div><span style="font-size:11px;float:left;margin-top:2px;margin-left:5px;width:100px">'.$plugininfo[0].'</span><span style="font-size:11px;float:right;margin-top:2px;margin-right:5px;"><a '.$pluginhref.' id="'.$plugin.'">add</a></span><div style="clear:both"></div></li>';
			}
		}	
	}

	$activeplugins = '';
	$no_plugins = '';
	$no = 0;

	foreach ($plugins as $ti) {
		$title = ucwords($ti);

		if(isset($plugins_core[$ti])) {
			$title = $titles[$ti][0];
		}

		++$no;

		$config = '';

		if (file_exists(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.$ti.DIRECTORY_SEPARATOR.'settings.php')) {
			$config = ' <a href="javascript:void(0)" onclick="javascript:plugins_configplugin(\''.$ti.'\')" style="margin-right:5px"><img src="images/config.png" title="Configure Plugin"></a>';
		}

		$activeplugins .= '<li class="ui-state-default" id="'.$no.'" d1="'.$ti.'" rel="'.$ti.'"><div class="cometchat_pluginsicon cometchat_'.$ti.'" style="margin:0;margin-right:5px;margin-top:2px;float:left;"></div><span style="font-size:11px;float:left;margin-top:3px;margin-left:5px;" id="'.$ti.'_title">'.stripslashes($title).'</span><span style="font-size:11px;float:right;margin-top:0px;margin-right:5px;"> '.$config.'<a href="javascript:void(0)" onclick="javascript:plugins_removeplugin(\''.$no.'\')"><img src="images/remove.png" title="Remove Plugin"></a></span><div style="clear:both"></div></li>';
	}

	if(!$activeplugins){
		$no_plugins .= '<div id="no_plugin" style="width: 480px;float: left;color: #333333;">You have no Plugins activated at the moment. To activate a plugin, please add the plugin from the list of available plugins.</div>';
	}
	else{
		$activeplugins = '<ul id="modules_liveplugins">'.$activeplugins.'</ul>';
	}

	$body = <<<EOD
	$navigation

	<div id="rightcontent" style="float:left;width:720px;border-left:1px dotted #ccc;padding-left:20px;">
		<h2>One-on-one Chat Plugins</h2>
		<h3>Use your mouse to change the order in which the plugins appear in the chatbox (left-to-right). You can add available plugins from the right.</h3>

		<div>
			{$no_plugins}
			{$activeplugins}
			<div id="rightnav" style="margin-top:5px">
				<h1>Available plugins</h1>
				<ul id="modules_availableplugins">
				$pluginslist
				</ul>
			</div>
		</div>

		<div style="clear:both;padding:7.5px;"></div>
		<input type="button" onclick="javascript:plugins_updateorder()" value="Update order" class="button">&nbsp;&nbsp;or <a href="?module=plugins&amp;ts={$ts}">cancel</a>
	</div>

	<div style="clear:both"></div>

	<script type="text/javascript">
		$(function() {
			$("#modules_liveplugins").sortable({ connectWith: 'ul' });
			$("#modules_liveplugins").disableSelection();
			$("#leftnav").find('a').removeClass('active_setting');
			$("#chat_plugins").addClass('active_setting');
		});
	</script>

EOD;

	template();

}

function updateorder() {
	if (!empty($_POST['order'])) {
		configeditor(array('plugins' => $_POST['order']));
	} else {
		configeditor(array('plugins' => array()));
	}
	echo "1";
}

function addplugin() {
    global $ts;
	global $plugins;
	if (!empty($_GET['data'])) {
		array_push($plugins, $_GET['data']);
		configeditor(array('plugins' => $plugins));
	}
	$_SESSION['cometchat']['error'] = 'Plugin successfully activated!';

	header("Location:?module=plugins&ts={$ts}");
}

function chatroomplugins() {
	global $body;
	global $crplugins;
	global $navigation;
	global $lang;
    global $ts;
    $plugins_core = setConfigValue('plugins_core',array());

	$pluginslist = '';

	foreach ($plugins_core as $plugin => $plugininfo) {
		if (is_dir(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.$plugin)) {
			if($plugininfo[1] === 0 || $plugininfo[1] === 2){
				$titles[$plugin] = $plugininfo;
				$crpluginhref = 'href="?module=plugins&amp;action=addchatroomplugin&amp;data='.$plugin.'&amp;ts='.$ts.'"';
		        if (in_array($plugin, $crplugins)) {
		           $crpluginhref = 'href="javascript: void(0)" style="opacity: 0.5;cursor: default;"';
		        }
		        $pluginslist .= '<li class="ui-state-default"><div class="cometchat_pluginsicon cometchat_'.$plugin.'" style="margin:0;margin-right:5px;float:left;"></div><span style="font-size:11px;float:left;margin-top:2px;margin-left:5px;">'.$plugininfo[0].'</span><span style="font-size:11px;float:right;margin-top:2px;margin-right:5px;"><a '.$crpluginhref.' id="'.$plugin.'">add</a></span><div style="clear:both"></div></li>';
	    	}
    	}
	}

	$activeplugins = '';
	$no_plugins = '';
	$no = 0;

	foreach ($crplugins as $ti) {
		$title = ucwords($ti);

		if(isset($plugins_core[$ti])) {
			$title = $titles[$ti][0];
		}

		++$no;

		$config = '';

		if (file_exists(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.$ti.DIRECTORY_SEPARATOR.'settings.php') && $ti != 'clearconversation') {
			$config = ' <a href="javascript:void(0)" onclick="javascript:plugins_configplugin(\''.$ti.'\')" style="margin-right:5px"><img src="images/config.png" title="Configure Plugin"></a>';
		}

		$activeplugins .= '<li class="ui-state-default" id="'.$no.'" d1="'.$ti.'" rel="'.$ti.'"><div class="cometchat_pluginsicon cometchat_'.$ti.'" style="margin:0;margin-right:5px;margin-top:2px;float:left;"></div><span style="font-size:11px;float:left;margin-top:3px;margin-left:5px;" id="'.$ti.'_title">'.stripslashes($title).'</span><span style="font-size:11px;float:right;margin-top:0px;margin-right:5px;"> '.$config.'<a href="javascript:void(0)" onclick="javascript:plugins_removechatroomplugin(\''.$no.'\')"><img src="images/remove.png" title="Remove Plugin"></a></span><div style="clear:both"></div></li>';
	}

	if(!$activeplugins){
		$no_plugins .= '<div id="no_plugin" style="width: 480px;float: left;color: #333333;">You have no Plugins activated at the moment. To activate a plugin, please add the plugin from the list of available plugins.</div>';
	}
	else{
		$activeplugins = '<ul id="modules_liveplugins">'.$activeplugins.'</ul>';
	}

	$body = <<<EOD
	$navigation

	<div id="rightcontent" style="float:left;width:720px;border-left:1px dotted #ccc;padding-left:20px;">
		<h2>Chatroom Plugins</h2>
		<h3>Use your mouse to change the order in which the plugins appear in the chatroom (left-to-right). You can add available plugins from the right.</h3>

		<div>
			{$no_plugins}
			{$activeplugins}
			<div id="rightnav" style="margin-top:5px">
				<h1>Available Chatroom plugins</h1>
				<ul id="modules_availableplugins">
				$pluginslist
				</ul>
			</div>
		</div>

		<div style="clear:both;padding:7.5px;"></div>
		<input type="button" onclick="javascript:plugins_updatechatroomorder()" value="Update order" class="button">&nbsp;&nbsp;or <a href="?module=plugins&amp;action=chatroomplugins&amp;ts={$ts}">cancel</a>
	</div>

	<div style="clear:both"></div>

	<script type="text/javascript">
		$(function() {
			$("#modules_liveplugins").sortable({ connectWith: 'ul' });
			$("#modules_liveplugins").disableSelection();
			$("#leftnav").find('a').removeClass('active_setting');
			$("#chatroom_plugins").addClass('active_setting');
		});
	</script>

EOD;

	template();

}

function updatechatroomorder() {
	if (!empty($_POST['order'])) {
		configeditor(array('crplugins' => $_POST['order']));
	} else {
		configeditor(array('crplugins' => array()));
	}
	echo "1";
}

function addchatroomplugin() {
    global $ts;
	global $crplugins;
	if (!empty($_GET['data'])) {
		array_push($crplugins, $_GET['data']);
		configeditor(array('crplugins' => $crplugins));

		$_SESSION['cometchat']['error'] = 'Plugin successfully activated!';
	}
	header("Location:?module=plugins&action=chatroomplugins&ts={$ts}");
}