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
		<a href="?module=language&amp;ts={$ts}" id="available_langs">Languages</a>
		<a href="?module=language&amp;action=additionallanguages&amp;ts={$ts}" id="additional_langs">Additional languages</a>
		<a href="?module=language&amp;action=createlanguage&amp;ts={$ts}" id="new_langs">Create new language</a>
		<a href="?module=language&amp;action=uploadlanguage&amp;ts={$ts}" id="upload_langs">Upload language</a>
	</div>
EOD;

function index() {
	global $body;
	global $languages;
	global $navigation;
	global $lang;
    global $ts;
    global $dbh;

    $sql = ("select distinct `code` from `cometchat_languages`");
    $query = mysqli_query($dbh,$sql);

    $languages = '';
	$no = 0;
	$activelanguages = '';
    while ($language = mysqli_fetch_assoc($query)) {
    	$code = $language['code'];
    	$default = '';
		$opacity = '0.5;cursor:default;';
		$titlemakedefault = 'title="Make language default"';
		$setdefault = 'onclick="javascript:language_makedefault(\''.$code.'\')"';
		$removelanguage = '<a href="javascript:void(0)" onclick="javascript:language_removelanguage(\''.$code.'\')"><img src="images/remove.png" title="Remove Language" /></a>';
		if (strtolower($lang) == strtolower($code)) {
			$default = ' (Active)';
			$opacity = '';
			$titlemakedefault = '';
			$setdefault = '';
			$removelanguage = '<img src="images/remove.png" title="Cannot remove an Active Language" style="opacity:0.5;cursor:default;" /> ';
		}

		++$no;

		$activelanguages .= '<li class="ui-state-default" id="'.$no.'" d1="'.$code.'"><span style="font-size:11px;float:left;margin-top:3px;margin-left:5px;" id="'.$code.'_title">'.$code.$default.'</span><span style="font-size:11px;float:right;margin-top:0px;margin-right:5px;"><a href="javascript:void(0)" '.$setdefault.' style="margin-right:5px;"><img src="images/default.png" '.$titlemakedefault.' style="opacity:'.$opacity.';" /></a><a href="?module=language&amp;action=editlanguage&amp;data='.$code.'&amp;ts='.$ts.'" style="margin-right:5px"><img src="images/config.png" title="Edit Language" /></a><a href="?module=language&amp;action=exportlanguage&amp;data='.$code.'&amp;ts='.$ts.'" target="_blank" style="margin-right:5px;"><img src="images/export.png" title="Download Language" /></a>'.$removelanguage.'</span><div style="clear:both"></div></li>';
    }

	$body = <<<EOD
	$navigation
	<div id="rightcontent" style="float:left;width:720px;border-left:1px dotted #ccc;padding-left:20px;">
		<h2>Languages</h2>
		<h3>To set the language, click on the star button next to the language.</h3>

		<div>
			<div id="centernav">
					<div>
						<ul id="modules_livelanguage">
							$activelanguages
						</ul>
					</div>
				</div>
			</div>
		</div>


	<div style="clear:both"></div>
	<script type="text/javascript">
		$(function() {
			$("#leftnav").find('a').removeClass('active_setting');
			$("#available_langs").addClass('active_setting');
		});
	</script>
EOD;

	template();

}

function makedefault() {

	if (!empty($_POST['lang'])) {
		configeditor($_POST);
	}
	$_SESSION['cometchat']['error'] = 'Language details updated successfully';

	echo "1";

}

function removelanguageprocess() {
    global $ts;
    global $dbh;
    global $client;

	$lang = $_GET['data'];

	if ($lang != 'en') {
		$sql = ("delete from `cometchat_languages` where `code` = '".mysqli_real_escape_string($dbh,$lang)."'");
		mysqli_query($dbh,$sql);
		removeCachedSettings($client.'cometchat_language');
		$_SESSION['cometchat']['error'] = 'Language deleted successfully';
	} else {
		$_SESSION['cometchat']['error'] = 'Sorry, this language cannot be deleted.';
	}

	header("Location:?module=language&ts={$ts}");


}

function editlanguage() {
	global $body;
	global $navigation;
    global $rtl;
	global $languages;
	$plugins_core = setConfigValue('plugins_core',array());
	$extensions_core = setConfigValue('extensions_core',array());
	$modules_core = setConfigValue('modules_core',array());
	$data ='';

	$lang = $_GET['data'];

	if(empty($data)){
		$rtly = "";
		$rtln = "";

		if ($rtl == 1) {
			$rtly = "checked";
		} else {
			$rtln = "checked";
		}

		$data .= '<div class="rtltitle">Right to left text:</div><div class="element"><input type="radio" id="rtl" lang_key = "rtl" name="rtl" value="1" '.$rtly.' onchange="javascript:language_updatelanguage($(this));" code="'.$lang.'" addontype="core" addonname="default">Yes <input id="rtl" type="radio" '.$rtln.' name="rtl" lang_key = "rtl" value="0" onchange="javascript:language_updatelanguage($(this));" code="'.$lang.'" addontype="core" addonname="default">No</div><div style="clear:both;padding:7.5px;"></div>';
	}

	if(file_exists(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.'en.php')) {
		$array = 'language';
		global $$array;
		include_once(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.'en.php');
		$$array = setNewLanguageValue($$array,$lang,'core','default');
		$x = 0;
		$data .= '<h4 onclick="javascript:$(\'#'.md5('').'\').slideToggle(\'slow\')">core</h4>';
		$data .= '<div id="'.md5('').'" style="display:none"><form>';

		foreach ($$array as $key => $value) {
			$x++;
			$data .= '<div style="clear:both"></div><div class="title langtitle" title="'.$key.'">'.$x.':</div><div class="element"><textarea id="textarea_'.$lang.'_core_default_'.$key.'" lang_key = "'.$key.'" code="'.$lang.'" addontype="core" addonname="default" class="inputbox inputboxlong">'.(stripslashes($value)).'</textarea><input type="button" value="Update" onclick="javascript:language_updatelanguage($(this));" class="button updatelanguage" /></div>';
		}
		$data.='</form></div>';
	}
	$addontypes = array('modules','plugins','extensions');
	foreach($addontypes as $addon_type){
		foreach (${$addon_type."_core"} as $addon => $addondata) {
			if(file_exists(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.$addon_type.DIRECTORY_SEPARATOR.$addon.DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.'en.php')){
				include_once(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.$addon_type.DIRECTORY_SEPARATOR.$addon.DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.'en.php');
				$array = $addon.'_language';
				$$array = setNewLanguageValue($$array,$lang,rtrim($addon_type,'s'),$addon);
				$data .= '<div style="clear:both"></div><h4 onclick="javascript:$(\'#'.md5($addon).'\').slideToggle(\'slow\')">'.rtrim($addon_type,'s').': '.$addon.'</h4>';
				$data .= '<div id="'.md5($addon).'" style="display:none"><form>';
				$x = 0;
				foreach (${$array} as $key => $value) {
					$x++;
					$data .= '<div style="clear:both"></div><div title="'.$key.'" ><div class="title langtitle" >'.$x.':</div><div class="element"><textarea id="textarea_'.$lang.'_'.$addon_type.'_'.$addon.'_'.$key.'" lang_key = "'.$key.'" code="'.$lang.'" addontype="'.rtrim($addon_type,'s').'" addonname="'.$addon.'" class="inputbox inputboxlong">'.(stripslashes($value)).'</textarea><input type="button" value="Update" onclick="javascript:language_updatelanguage($(this));" class="button updatelanguage" /></div></div>';
				}
				$data.='</form></div>';
			}else{
				unset(${$addon_type."_core"}[$addon]);
			}
		}
	}

	$body = <<<EOD
	$navigation
	<div id="rightcontent" style="float:left;width:720px;border-left:1px dotted #ccc;padding-left:20px;">
		<h2>Edit language - {$lang}</h2>
		<h3>Please select the section you would like to edit.</h3>
		<div>
			<div id="centernav" class="centernavextend">
				$data
				<div style="clear:both;padding:10px;"></div>
			</div>
		</div>

	</div>

	<div style="clear:both"></div>
EOD;

	template();

}

function editlanguageprocess() {
	if(isset($_POST)){
		languageeditor($_POST);
	}
	echo "1";
	exit;
}

function restorelanguageprocess() {

	$lang = $_POST['lang'];

	if (!empty($_POST['id'])) {
		$_POST['id'] .= '/';
	}

	$file = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.$_POST['id'].'lang'.DIRECTORY_SEPARATOR.'en.bak';
	$fh = fopen($file, 'r');
	$restoredata = fread($fh, filesize($file));
	fclose($fh);

	$file = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.$_POST['id'].'lang'.DIRECTORY_SEPARATOR.strtolower($lang).".php";
	$fh = fopen($file, 'w');
	if (fwrite($fh, $restoredata) === FALSE) {
			echo "Cannot write to file ($file)";
			exit;
	}
	fclose($fh);
	chmod($file, 0777);

	$_SESSION['cometchat']['error'] = 'Language has been restored successfully.';

	echo "1";
	exit;
}

function createlanguage() {
	global $body;
	global $navigation;
    global $ts;

	$body = <<<EOD
	$navigation
	<form action="?module=language&action=createlanguageprocess&ts={$ts}" method="post" enctype="multipart/form-data">
	<div id="rightcontent" style="float:left;width:720px;border-left:1px dotted #ccc;padding-left:20px;">
		<h2>Create new language</h2>
		<h3>Enter the first two letters of your new language.</h3>
		<div>
			<div id="centernav">
				<div class="title">Language:</div><div class="element"><input type="text" class="inputbox" name="lang" maxlength=2 required="true"/></div>
				<div style="clear:both;padding:10px;"></div>
			</div>
		</div>

		<div style="clear:both;padding:7.5px;"></div>
		<input type="submit" value="Add language" class="button">&nbsp;&nbsp;or <a href="?module=language&amp;ts={$ts}">cancel</a>
	</div>

	<div style="clear:both"></div>

	<script type="text/javascript">
		$(function() {
			$("#leftnav").find('a').removeClass('active_setting');
			$("#new_langs").addClass('active_setting');
		});
	</script>

EOD;

	template();

}

function createlanguageprocess() {
    global $ts;
    global $languages;

    if(empty($languages[$_POST['lang']]['core']['default']['rtl'])){
    	$new_lang = array('lang_key' 	=> 'rtl',
    					  'lang_text' 	=> '0',
    					  'code' 		=> $_POST['lang'],
    					  'type' 		=> 'core',
    					  'name' 		=> 'default');
    	languageeditor($new_lang);
    	$_SESSION['cometchat']['error'] = 'New language added successfully';
    }else{
		$_SESSION['cometchat']['error'] = 'Language already exists. Please remove it and then try again.';
	}
	header("Location:?module=language&ts={$ts}");
}

function getlanguage($lang) {
	global $dbh;
	$sql = 'select * from `cometchat_languages` where `code` = "'.mysqli_real_escape_string($dbh,$lang).'"';
	$query = mysqli_query($GLOBALS['dbh'],$sql);

	while ($lang = mysqli_fetch_array($query)) {
		if(empty($languages[$lang['code']])){
			$languages[$lang['code']] = array();
		}
		if(empty($languages[$lang['code']][$lang['type']])){
			$languages[$lang['code']][$lang['type']] = array();
		}
		if(empty($languages[$lang['code']][$lang['type']][$lang['name']])){
			$languages[$lang['code']][$lang['type']][$lang['name']] = array();
		}
		$languages[$lang['code']][$lang['type']][$lang['name']][$lang['lang_key']] = $lang['lang_text'];
	}

	return serialize($languages);
}

function additionallanguages() {
	global $body;
	global $navigation;
    global $ts;

	$body = <<<EOD
	$navigation
	<form action="?module=language&action=updatelanguage&ts={$ts}" method="post">
	<div id="rightcontent" style="float:left;width:720px;border-left:1px dotted #ccc;padding-left:20px;">
		<h2>Additional Languages</h2>
		<h3>Official languages available from CometChat. If your language is not in the list below, you can create your own.</h3>

		<div>
			<div id="centernav">
				<div style="clear:both;">
					<ul id="modules_livelanguage">

					</ul>
				</div>
			</div>



			</div>
		</div>
		<div id = "over" ><div id ="loadingimage" ><img src="images/loading.gif" height="100" width ="100" /></div></div>
	<div style="clear:both"></div>
	</form>
	<script>
		$(function() { language_getlanguages(); });
	</script>
	<script type="text/javascript">
		$(function() {
			$("#leftnav").find('a').removeClass('active_setting');
			$("#additional_langs").addClass('active_setting');
		});
	</script>
	<style type="text/css">
 		#loadingimage{
 			top: 45%;
 			left: 45%;
 			position: fixed;
 		}
 		#over{
			 z-index: 1000001;
			 background-color:black;
			 opacity:0.7;
			 position: fixed;
			 left: 0px;
			 height:100%;
			 width:100%;
			 display:none;
 		}
 	</style>
EOD;

	template();

}

function mb_unserialize($string) {
    $string2 = preg_replace_callback(
        '!s:(\d+):"(.*?)";!s',
        function($m){
            $len = strlen($m[2]);
            $result = "s:$len:\"{$m[2]}\";";
            return $result;

        },
        $string);
    return unserialize($string2);
}

function previewlanguage() {
	if (!empty($_POST['data'])) {
		$langdata = mb_unserialize($_POST['data']['data']);
		foreach ($langdata as $code => $addon) {
			foreach ($addon as $addon_type => $addondata) {
				foreach ($addondata as $addon_name => $addonvalue) {
					if($addon_name == 'default'){
						$addon_name = 'core';
					}
					$x = 0;
					echo "\n-- ";
					echo $addon_name;
					echo " ----------------------\r\n\n";
					foreach ($addonvalue as $key => $value) {
						if($key!='rtl'){
							$x++;
							$d = $x.".".$value."\n";
							echo $d;
						}
					}
				}
			}
		}
	}
}

function importlanguage(){
	global $client;
	if(!empty($_POST['data'])){
		$newlanguage = mb_unserialize($_POST['data']['data']);
		$sql="";
		$cumulative_rows = 0;
		foreach($newlanguage as $code => $langdata){
			foreach($langdata as $type => $addondata){
				foreach($addondata as $name => $lang_keys){
					foreach($lang_keys as $lang_key => $lang_text){
						$sql .= ("insert into `cometchat_languages` set `lang_key` = '".mysqli_real_escape_string($GLOBALS['dbh'],$lang_key)."', `lang_text` = '".mysqli_real_escape_string($GLOBALS['dbh'],$lang_text)."', `code` = '".mysqli_real_escape_string($GLOBALS['dbh'],$code)."', `type` = '".mysqli_real_escape_string($GLOBALS['dbh'],$type)."', `name` = '".mysqli_real_escape_string($GLOBALS['dbh'],$name)."' on duplicate key update `lang_key` = '".mysqli_real_escape_string($GLOBALS['dbh'],$lang_key)."', `lang_text` = '".mysqli_real_escape_string($GLOBALS['dbh'],$lang_text)."', `code` = '".mysqli_real_escape_string($GLOBALS['dbh'],$code)."', `type` = '".mysqli_real_escape_string($GLOBALS['dbh'],$type)."', `name` = '".mysqli_real_escape_string($GLOBALS['dbh'],$name)."';");
					}
				}
			}
		}
		if(mysqli_multi_query($GLOBALS['dbh'],$sql)){
		    do{
		    	$cumulative_rows+=mysqli_affected_rows($GLOBALS['dbh']);
		    }while(mysqli_more_results($GLOBALS['dbh']) && mysqli_next_result($GLOBALS['dbh']));
		}
		removeCachedSettings($client.'cometchat_language');
	}
	echo "1";
}

function uploadlanguage() {
	global $body;
	global $navigation;
    global $ts;

	$body = <<<EOD
	$navigation
	<form action="?module=language&action=uploadlanguageprocess&ts={$ts}" method="post" enctype="multipart/form-data">
	<div id="rightcontent" style="float:left;width:720px;border-left:1px dotted #ccc;padding-left:20px;">
		<h2>Upload new language</h2>
		<h3>Have you downloaded a new CometChat language? Upload only the .lng file e.g. "en.lng".</h3>

		<div>
			<div id="centernav">
				<div class="title">Language:</div><div class="element"><input type="file" class="inputbox" name="file"></div>
				<div style="clear:both;padding:10px;"></div>
			</div>

		</div>

		<div style="clear:both;padding:7.5px;"></div>
		<input type="submit" value="Add language" class="button">&nbsp;&nbsp;or <a href="?module=language&amp;ts={$ts}">cancel</a>
	</div>

	<div style="clear:both"></div>

	<script type="text/javascript">
		$(function() {
			$("#leftnav").find('a').removeClass('active_setting');
			$("#upload_langs").addClass('active_setting');
		});
	</script>

EOD;

	template();

}

function uploadlanguageprocess() {
    global $ts;
    global $dbh;
    global $client;

	$error = '';
	if (!empty($_FILES["file"]["size"])) {
		if ($_FILES["file"]["error"] > 0) {
			$error = "Language corrupted. Please try again.";
		} else {
			if($newlanguage = unserialize(file_get_contents($_FILES['file']['tmp_name']))){
				$sql="";
			    foreach($newlanguage as $code => $langdata){
					foreach($langdata as $type => $addondata){
						foreach($addondata as $name => $lang_keys){
							foreach($lang_keys as $lang_key => $lang_text){
								$sql .= ("insert into `cometchat_languages` set `lang_key` = '".mysqli_real_escape_string($dbh,$lang_key)."', `lang_text` = '".mysqli_real_escape_string($dbh,$lang_text)."', `code` = '".mysqli_real_escape_string($dbh,$code)."', `type` = '".mysqli_real_escape_string($dbh,$type)."', `name` = '".mysqli_real_escape_string($dbh,$name)."' on duplicate key update `lang_key` = '".mysqli_real_escape_string($dbh,$lang_key)."', `lang_text` = '".mysqli_real_escape_string($dbh,$lang_text)."', `code` = '".mysqli_real_escape_string($dbh,$code)."', `type` = '".mysqli_real_escape_string($dbh,$type)."', `name` = '".mysqli_real_escape_string($dbh,$name)."';");
							}
						}
					}
				}
				mysqli_multi_query($dbh,$sql);
			}else{
				$error = "Invalid language file.";
			}
		}
	} else {
		$error = "Language not found. Please try again.";
	}

	if (!empty($error)) {
		$_SESSION['cometchat']['error'] = $error;
		header("Location: ?module=language&action=uploadlanguage&ts={$ts}");
		exit;
	}

	$_SESSION['cometchat']['error'] = 'Language added successfully';
	removeCachedSettings($client.'cometchat_language');
	header("Location: ?module=language&ts={$ts}");
	exit;

}

function exportlanguage() {

	$lang = $_GET['data'];

	$data = getlanguage($lang);

	header('Content-Description: File Transfer');
	header('Content-Type: application/force-download');
	header('Content-Disposition: attachment; filename='.$lang.'.lng');
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	ob_clean();
	flush();
	echo ($data);

}