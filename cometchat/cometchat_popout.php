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


if(!empty($_REQUEST['basedata'])) {
	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'cometchat_init.php');
	$_SESSION['basedata']=$_REQUEST['basedata'];
	setcookie($cookiePrefix."data", $_REQUEST['basedata'], 0, "/");
}
$callbackfn='';
if(!empty($_REQUEST['callbackfn'])) {
	$callbackfn = "&callbackfn=".$_REQUEST['callbackfn'];
}
$id = 0;
if(!empty($_REQUEST['user'])){
	$id = $_REQUEST['user'];
}


if(!empty($_REQUEST['chatroomsonly'])) {
	$chatroomsonly = "&chatroomsonly=1";
} else {
	$chatroomsonly = "&chatroomsonly=0";
}

if(!empty($_REQUEST['crid'])) {
	$chatroomid = "&chatroomid=".$_REQUEST['crid'];
} else {
	$chatroomid = "&chatroomid=0";
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="user-scalable=0,width=device-width, minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0" />
	<meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<link rel="shortcut icon" type="image/png" href="favicon32.ico">
	<title>CometChat</title>
	<script type="text/javascript">
		var embeddedchatroomid = <?php echo (!empty($_REQUEST['crid']) ? $_REQUEST['crid'] : '0').';'; ?>
		var chatroomsonly = <?php echo (!empty($_REQUEST['chatroomsonly']) ? '1' : '0').';'; ?>
	</script>
	<link type="text/css" href="./cometchatcss.php?cc_theme=synergy<?php echo $chatroomid; ?><?php echo $chatroomsonly; ?><?php echo $callbackfn;?>" rel="stylesheet" charset="utf-8">
	<script type="text/javascript" src="./cometchatjs.php?cc_theme=synergy<?php echo $chatroomid; ?><?php echo $chatroomsonly; ?><?php echo $callbackfn;?>" charset="utf-8"></script>
	<script type="text/javascript" src="./js.php?type=core&name=jsapi"></script>
	<script type="text/javascript">
		jqcc(document).ready(function(){
			if (embeddedchatroomid != 0 && embeddedchatroomid !='null' && typeof(embeddedchatroomid) != "undefined" && typeof(jqcc.cometchat.chatroomHeartbeat) == "function") {
				var id = '1^'+embeddedchatroomid;
				jqcc.cometchat.chatroomHeartbeat(id);
			}
		});
		google.load("elements", "1", {
            packages: "transliteration"
        });
	
		document.addEventListener("dragover",function(e){
		   e = e || event;
		   e.preventDefault();
		},false);
		document.addEventListener("drop",function(e){
			e = e || event;
			e.preventDefault();
		},false);
		
		var uid = '<?php echo $id; ?>';
		if(uid > 0){
			var controlparameters = {"type":"core", "name":"cometchat", "method":"chatWith", "params":{"uid":uid, "synergy":"1"}};
	        controlparameters = JSON.stringify(controlparameters);
	        parent.postMessage('CC^CONTROL_'+controlparameters,'*');
	    }

	</script>
</head>
<body style="overflow: hidden;">
</body>
</html>