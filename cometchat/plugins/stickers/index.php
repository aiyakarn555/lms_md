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

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR."en.php");
if (file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$lang.".php")) {
	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$lang.".php");
}

$basedata = $action = null;

if(!empty($_REQUEST['basedata'])) {
	$basedata = mysqli_real_escape_string($GLOBALS['dbh'],$_REQUEST['basedata']);
}

if(!empty($_REQUEST['action'])){
	$action = $_REQUEST['action'];
}

if($action == 'sendSticker') {
	$to = $_REQUEST['to'];
	$key = $_REQUEST['key'];
	$chatroommode = $_REQUEST['chatroommode'];
	$category = $_REQUEST['category'];
	$caller = $_REQUEST['caller'];
	if (!empty($chatroommode)) {
		$controlparameters = array('type' => 'plugins', 'name' => 'stickers', 'method' => 'sendSticker', 'params' => array('to' => $to, 'key' => $key, 'chatroommode' => $chatroommode, 'category' => $category, 'caller' => $caller));
		$controlparameters = json_encode($controlparameters);
		$response = sendChatroomMessage($to, 'CC^CONTROL_'.$controlparameters);
	} else {
		$controlparameters = array('type' => 'plugins', 'name' => 'stickers', 'method' => 'sendSticker', 'params' => array('to' => $to, 'key' => $key, 'chatroommode' => $chatroommode, 'category' => $category, 'caller' => $caller));
		$controlparameters = json_encode($controlparameters);
		$response = sendMessage($to,'CC^CONTROL_'.$controlparameters);
		parsePusher($to,$response['id'],$_SESSION['cometchat']['user']['n'].":".$stickers_language[2]);
	}
	if (!empty($_REQUEST['callback'])) {
		echo $_REQUEST['callback'].'('.json_encode($response).')';
	} else {
		echo json_encode($response);
	}
} else {
	$id = $_GET['id'];
	$text = '';
	$categories = array();
	$category = scandir(dirname(__FILE__).DIRECTORY_SEPARATOR."images");
	foreach($category as $c){
	    if($c != '.' && $c != '..'){
	        array_push($categories, $c);
	    }
	}

	$tab = '';
	$body_content = '';
	$used = array();

	$chatroommode = 0;
	$broadcastmode = 0;
	$caller = '';
	if (!empty($_GET['chatroommode'])) {
		$chatroommode = 1;
	}
	if (!empty($_GET['broadcastmode'])) {
		$broadcastmode = 1;
	}
	if (!empty($_GET['caller'])) {
		$caller = $_GET['caller'];
	}
	$embed = '';
	$embedcss = '';
	$close = "setTimeout('window.close()',2000);";
	$before = 'window.opener';

	if (!empty($_GET['embed']) && $_GET['embed'] == 'web') {
		$embed = 'web';
		$embedcss = 'embed';
		$close = "";
		$before = 'parent';

		if ($chatroommode == 1) {
			$before = "$('#cometchat_trayicon_chatrooms_iframe,#cometchat_container_chatrooms .cometchat_iframe,.cometchat_embed_chatrooms',parent.document)[0].contentWindow";
		}
		if ($broadcastmode == 1) {
			$before = "$('#cometchat_trayicon_chatrooms_iframe,#cometchat_container_chatrooms .cometchat_iframe,.cometchat_embed_chatrooms',parent.document)[0].contentWindow";
		}
	}

	if (!empty($_GET['embed']) && $_GET['embed'] == 'desktop') {
		$embed = 'desktop';
		$embedcss = 'embed';
		$close = "";
		$before = 'parentSandboxBridge';
	}

	$hideadditional = '';
	$tablength = "tab_length6";

	foreach ($categories as $key=>$value) {
		$selected = '';
		$sticker_selected = '';
		$content = '';
		if($key==0){
			$selected = 'selected';
			$sticker_selected = 'sticker_selected';
		}
		$tab .= '<div id="'.$value.'" class="tab '.$tablength.' '.$value.' '.$selected.' '.$sticker_selected.'" ></div>';
		$images = scandir(dirname(__FILE__).DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR.$value);
		foreach ($images as $key=>$val) {
			if($val != '.' && $val != '..'){
				$class = explode('.png',$val);
				$content .= '<span class="cometchat_sticker_image '.$class[0].'" category="'.$value.'" chatroommode="'.$chatroommode.'" caller = "'.$caller.'"></span>';
			}
		}
		$body_content .= '<div class="'.$value.' stickers '.$sticker_selected.'">'.$content.'</div>';
	}

	$extrajs = "";
	$scrollcss = "overflow-y:scroll;overflow-x:hidden;position:absolute;top:26px;";
	if ($sleekScroller == 1) {
		$extrajs = '<script src="../../js.php?type=core&name=scroll"></script>';
		$scrollcss = "";
	}

	$cc_theme = '';
	if(!empty($_REQUEST['cc_theme'])){
		$cc_theme = $_REQUEST['cc_theme'];
	}
echo <<<EOD
<!DOCTYPE html>
<html>
	<head>
		<title>{$stickers_language[0]}</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<meta name="viewport" content="width=device-width,initial-scale=1" />
		<link type="text/css" rel="stylesheet" media="all" href="../../css.php?type=plugin&name=stickers&subtype=stickers&cc_theme={$cc_theme}" />
		<script src="../../js.php?type=core&name=jquery"></script>
		<script src="../../js.php?type=core&name=slick"></script>
		<script src="../../js.php?type=plugin&name=stickers" type="text/javascript"></script>
		<script>
			$ = jQuery = jqcc;
		</script>
		{$extrajs}
		<style>
			.container_body {
				{$scrollcss};
			}
			.container_body.embed {
				{$scrollcss};
			}
		</style>
		<script type="text/javascript">
	    	$(function(){
	    		$('.tab').click(function(){
	    			$('.tab').removeClass('selected');
	    			$(this).addClass('selected');
	    			$('.stickers').removeClass('sticker_selected');
	    			$('.tab').removeClass('sticker_selected');
	    			$(this).addClass('sticker_selected');
	    			$('.'+$(this).attr('id')).addClass('sticker_selected');
	    		});
				$('.cometchat_sticker_image').click(function(){
					var key = $(this).attr('class').split(' ')[1];
					var category = $(this).attr('category');
					var chatroommode = $(this).attr('chatroommode');
					var caller = $(this).attr('caller');
					var controlparameters = {"type":"plugins", "name":"ccstickers", "method":"sendStickerMessage", "params":{"to":{$id}, "key":key, "chatroommode":chatroommode, "category":category, "caller":caller}};
					controlparameters = JSON.stringify(controlparameters);
					if(typeof(parent) != 'undefined' && parent != null && parent != self){
						parent.postMessage('CC^CONTROL_'+controlparameters,'*');
					} else {
						window.opener.postMessage('CC^CONTROL_'+controlparameters,'*');
					}
				});
				if (jQuery().slimScroll) {
					$(".container_body").slimScroll({ width: '100%'});
				}
				if (jQuery().slick) {
					jqcc('#tabs_container').slick({ infinite: false, slidesToShow: 4, slidesToScroll: 1 });
				}
			});
	    </script>
	</head>
	<body>
		<div class="container">
			<div class="container_title {$embedcss}">{$stickers_language[1]}</div>
			<div id="tabs_container">
				{$tab}
		    </div>
			<div class="container_body {$embedcss}">
				{$body_content}
			</div>
		</div>
	</body>
</html>
EOD;
}
