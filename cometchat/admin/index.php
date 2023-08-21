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
define('CCADMIN',true);

include_once (dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."config.php");
include_once (dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."cometchat_shared.php");
include_once (dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."php4functions.php");

$menuoptions = array("Dashboard","Announcements","Chatrooms","Modules","Plugins","Extensions","Themes","Language","Settings","Monitor","Logs","Logout");

$ts = time();

if(!session_id()){
	session_name('CCADMIN');
	@session_start();
}

if(get_magic_quotes_runtime()){
	set_magic_quotes_runtime(false);
}

include_once (dirname(__FILE__).DIRECTORY_SEPARATOR."shared.php");
function stripSlashesDeep($value){
	$value = is_array($value) ? array_map('stripSlashesDeep',$value) : stripslashes($value);
	return $value;
}

if(get_magic_quotes_gpc()||(defined('FORCE_MAGIC_QUOTES')&&FORCE_MAGIC_QUOTES==1)){
	$_GET = stripSlashesDeep($_GET);
	$_POST = stripSlashesDeep($_POST);
	$_COOKIE = stripSlashesDeep($_COOKIE);
}

cometchatDBConnect();
cometchatMemcacheConnect();

$usertable = TABLE_PREFIX.DB_USERTABLE;
$usertable_username = DB_USERTABLE_NAME;
$usertable_userid = DB_USERTABLE_USERID;

$body = '';

if (!empty($_POST['username']) && !empty($_POST['password'])) {
	if ($_POST['username'] == ADMIN_USER && $_POST['password'] == ADMIN_PASS){
		$_SESSION['cometchat']['cometchat_admin_user'] = $_POST['username'];
		$_SESSION['cometchat']['cometchat_admin_pass'] = $_POST['password'];
	} else {
		$_SESSION['cometchat']['error'] = "Incorrect username/password. Please try again.";
	}
}

authenticate();

$module = "dashboard";
$action = "index";
error_reporting(E_ALL);
ini_set('display_errors','On');
if(!empty($_GET['module'])){
	if(file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR.$_GET['module'].'.m.php')){
		$module = $_GET['module'];
	}
}

if(!file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR.$module.'.m.php')){
	$_SESSION['cometchat']['error'] = 'Oops. This module does not exist.';
	$module = 'dashboard';
}

include_once (dirname(__FILE__).DIRECTORY_SEPARATOR.$module.'.m.php');

$allowedActions = array('deleteannouncement','updateorder','ccauth','addauthmode','updateauthmode','index','updatesettings','moderator','newchatroomprocess','newannouncement','newannouncementprocess','newchatroom','updatechatroomorder','loadexternal','makedefault','editcolor','removecolorprocess','viewuser','viewuserchatroomconversation',
'viewuserconversation','updatecolorsprocess','updatevariablesprocess','restorecolorprocess','editlanguage','editlanguageprocess','restorelanguageprocess','importlanguage','previewlanguage','removelanguageprocess','sharelanguage','data','moderatorprocess','createmodule','createmoduleprocess','chatroomplugins','clonecolor',
'clonecolorprocess','additionallanguages','createlanguage','createlanguageprocess','uploadlanguage','uploadlanguageprocess','comet','guests','banuser','baseurl','changeuserpass','disablecometchat','updatecomet','updateguests','banuserprocess','updatebaseurl','changeuserpassprocess',
'updatedisablecometchat','chatroomlog','searchlogs','addmodule','addplugin','addextension','deletechatroom','finduser','updatelanguage','newlogprocess','addchatroomplugin','whosonline','updatewhosonline','cron','processcron','getlanguage','exportlanguage','caching','updatecaching','loadthemetype',
'themestypemakedefault','removecustommodules','clearcachefiles','clearcachefilesprocess','makemoderatorprocess','removemoderatorprocess','banusersprocess','unbanusersprocess','ccautocomplete','themeembedcodesettings');

if(!empty($_GET['action'])&&in_array($_GET['action'],$allowedActions)&&function_exists($_GET['action'])){
	$action = mysqli_real_escape_string($GLOBALS['dbh'],$_GET['action']);
}

call_user_func($action);
function onlineusers(){
	global $db;

	$sql = ("select count(distinct(cometchat.from)) users from cometchat where ('".mysqli_real_escape_string($GLOBALS['dbh'],getTimeStamp())."'-cometchat.sent)<300");

	$query = mysqli_query($GLOBALS['dbh'],$sql);
	$chat = mysqli_fetch_assoc($query);

	return $chat['users'];
}
function authenticate(){
	if(empty($_SESSION['cometchat']['cometchat_admin_user'])||empty($_SESSION['cometchat']['cometchat_admin_pass'])||!($_SESSION['cometchat']['cometchat_admin_user']==ADMIN_USER&&$_SESSION['cometchat']['cometchat_admin_pass']==ADMIN_PASS)){
		global $body;
		$body = <<<EOD
			<script>
				$(function(){
					var todaysDate = new Date();
					var currentTime = Math.floor(todaysDate.getTime()/1000);
					$(".currentTime").val(currentTime);
				});

			</script>
			<form method="post" action="?module=dashboard"+currentTime>
			<div class="" style="padding-bottom:30px;"><div style="float:left"><h2 style="font-size:18px;">CometChat Administration Panel</h2></div><div style="clear:both"></div></div>
			<div class="chat chatnoline">Username: <input type="text" name="username" class="login_inputbox" required="true"/></div>
			<div class="chat chatnoline">Password: <input type="password" name="password" class="login_inputbox" required="true"/></div>
			<div class="" style="padding-top:30px"><input type="submit" value="Login" class="button"> or <a href="#" onclick="javascript:alert('Please manually edit cometchat/config.php and find ADMIN_USER & ADMIN_PASS')">forgot password?</a></div>
			<input type="hidden" name="currentTime" class="login_inputbox currentTime">
			</form>
EOD;
		template(1);
	}
}
function template($auth = 0){
	global $ts;
	global $body;
	global $menuoptions;
	global $module;
	global $navigation;

	$tabs = $menuoptions;

	$tabstructure = '';

	foreach($tabs as $tab){
		$tabslug = strtolower($tab);
		$tabslug = str_replace(" ","",$tabslug);
		$tabslug = str_replace("/","",$tabslug);

		$current = '';

		if(!empty($module)&&$module==$tabslug){
			$current = 'class="current"';
		}

		$tabstructure .= <<<EOD
		  <li {$current}>
			<a href="?module={$tabslug}&amp;ts={$ts}">{$tab}</a>
		  </li>
EOD;
	}

	$errorjs = '';

	if(!empty($_SESSION['cometchat']['error'])){
		$errorjs = <<<EOD
<script>
\$(function() {
	\$.fancyalert('{$_SESSION['cometchat']['error']}');
});
</script>
EOD;
		unset($_SESSION['cometchat']['error']);
	}

$testnavigation = <<<EOD
	<div id="leftnav">
	</div>
EOD;

	if ($navigation == $testnavigation || empty($navigation)) {
		$body = '<div id="rightcontent" style="float:left;width:720px;border-left:1px dotted #ccc;padding-left:35px !important;">'.$body.'</div>';
		$nosubnav = 'nosubnav';
	} else {
		$nosubnav = '';
	}

	if ($auth == 1) {
		$tabstructure = '';
		$auth = 'login';
	} else {
		$auth = '';
	}

	echo <<<EOD
<!DOCTYPE html>
<html>
<head>
<title>CometChat Administration</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link href="../css.php?admin=1" media="all" rel="stylesheet" type="text/css" />
<script src="../js.php?admin=1"></script>
<script>
	\$(function() {
		\$('.chat_time').each(function(key,value){
			var ts = new Date(\$(this).attr('timestamp') * 1000);
			var timest = getTimeDisplay(ts);
			\$(this).html(timest);
		});
	});
</script>
</head>
<body class="$auth">
<div id="container">
<div id="logo" style="float:right;padding-bottom:30px;padding-right:20px"><img src="images/logo.png"></div>
<div style="clear:both"></div>
<div id="views">
<ol class="tabs">
{$tabstructure}
</ol>
</div>
<div style="clear:both"></div>
<div id="content" class="$nosubnav">
{$body}
</div>
<div id="power" style="text-align:center;padding-top:10px;display:none;"><a href="http://www.cometchat.com" target="_blank">Powered by CometChat</a></div>
</div>
{$errorjs}
</body>
</html>
EOD;
	exit();
}
