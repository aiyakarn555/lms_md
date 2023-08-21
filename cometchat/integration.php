<?php
require_once(dirname(__FILE__).'/../../framework/yii.php');
Yii::createWebApplication(dirname(__FILE__).'/../protected/config/main.php');
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



/* ADVANCED */
$cms = "socialengine";
define('SET_SESSION_NAME','');			// Session name
define('SWITCH_ENABLED','1');
define('INCLUDE_JQUERY','1');
define('FORCE_MAGIC_QUOTES','0');

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* DATABASE */

define('_ENGINE', true);


define('DB_SERVER','112.121.150.4');
define('DB_PORT','3306');
define('DB_USERNAME','dbd_database');
define('DB_PASSWORD','dbd@passw0rd');
define('DB_NAME','db_dbd');
$table_prefix = 'tbl_';                                 // Table prefix(if any)
$db_usertable = 'users';                            // Users or members information table name
$db_usertable_userid = 'id';                        // UserID field in the users or members table
$db_usertable_name = 'username';                    // Name containing field in the users or members table
$db_avatartable = " left join ".$table_prefix."storage_files on file_id = ".$table_prefix.$db_usertable.".photo_id";
$db_avatarfield =  " (select storage_path from ".$table_prefix."storage_files where parent_file_id is null and file_id = ".$table_prefix.$db_usertable.".photo_id)";
$db_linkfield = ' '.$table_prefix.$db_usertable.'.'.$db_usertable_userid.' ';

/*COMETCHAT'S INTEGRATION CLASS USED FOR SITE AUTHENTICATION */

class Integration{

    function __construct(){
        if(!defined('TABLE_PREFIX')){
            $this->defineFromGlobal('table_prefix');
            $this->defineFromGlobal('db_usertable');
            $this->defineFromGlobal('db_usertable_userid');
            $this->defineFromGlobal('db_usertable_name');
            $this->defineFromGlobal('db_avatartable');
            $this->defineFromGlobal('db_avatarfield');
            $this->defineFromGlobal('db_linkfield');
        }
    }

    function defineFromGlobal($key){
        if(isset($GLOBALS[$key])){
            define(strtoupper($key), $GLOBALS[$key]);
            unset($GLOBALS[$key]);
        }
    }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* FUNCTIONS */

	function getUserID() {
		$userid = 0;
		if (!empty($_SESSION['basedata']) && $_SESSION['basedata'] != 'null') {
			$_REQUEST['basedata'] = $_SESSION['basedata'];
		}

		if (!empty($_REQUEST['basedata'])) {

			if (function_exists('mcrypt_encrypt') && defined('ENCRYPT_USERID') && ENCRYPT_USERID == '1') {
				$key = "";
				if( defined('KEY_A') && defined('KEY_B') && defined('KEY_C') ){
					$key = KEY_A.KEY_B.KEY_C;
				}
				$uid = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode(rawurldecode($_REQUEST['basedata'])), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
				if (intval($uid) > 0) {
					$userid = $uid;
				}
			} else {
				$userid = $_REQUEST['basedata'];
			}
		}

		if (!empty($_COOKIE['PHPSESSID']) && (empty($userid) || $userid == 'null')) {
			$sql = ("SELECT data,user_id from ".TABLE_PREFIX."core_session where id = '".mysqli_real_escape_string($GLOBALS['dbh'],$_COOKIE['PHPSESSID'])."'");
			$result = mysqli_query($GLOBALS['dbh'],$sql);
			$row = mysqli_fetch_assoc($result);
			if(strpos($row['data'], 'login_id') !== false){
				$userid = $row['user_id'];
			}
		}
		if (!empty($_COOKIE['PHPSESSID']) && (empty($userid) || $userid == 'null')){
			$sql = ("SELECT user_id from ".TABLE_PREFIX."core_session where id = '".mysqli_real_escape_string($GLOBALS['dbh'],$_COOKIE['PHPSESSID'])."'");
			$result = mysqli_query($GLOBALS['dbh'],$sql);
			$row = mysqli_fetch_assoc($result);
			$user_id = $row['user_id'];
			if($user_id > 0){
				$sql = ("SELECT * from ".TABLE_PREFIX."user_online where user_id = '".mysqli_real_escape_string($GLOBALS['dbh'],$user_id)."'");
				$query = mysqli_query($GLOBALS['dbh'],$sql);
				$result = mysqli_fetch_assoc($query);
				$row = mysqli_num_rows($query);
				if($row>0){
					$userid = $result['user_id'];
				}else{
					$userid = 0;
				}
			}
		}

		if(isset($_REQUEST['hash_val']) && isset($_REQUEST['cc_social_userid'])){
			$sql = "SELECT name from ".TABLE_PREFIX."authorization_permissions where type='hash_value' and level_id= 999";
			$result = mysqli_query($GLOBALS['dbh'],$sql);
			$row = mysqli_fetch_assoc($result);
			$hash = $row['name'];
			$hashval = md5($hash.$_REQUEST['cc_social_userid']);
			if($_REQUEST['hash_val'] == $hashval){
				$userid = $_REQUEST['cc_social_userid'];
			}
		}
		if($row>0){
			$userid = $result['user_id'];
		}else{
			$userid = 0;
		}
		$userid = intval($userid);
		return $userid;
	}

	function chatLogin($userName,$userPass) {
		$userid = 0;
		global $guestsMode;

		if (filter_var($userName, FILTER_VALIDATE_EMAIL)) {
			$sql = ("SELECT * FROM ".TABLE_PREFIX.DB_USERTABLE." WHERE email = '".mysqli_real_escape_string($GLOBALS['dbh'],$userName)."'");
		} else {
			$sql = ("SELECT * FROM ".TABLE_PREFIX.DB_USERTABLE." WHERE username = '".mysqli_real_escape_string($GLOBALS['dbh'],$userName)."'");
		}

		$result = mysqli_query($GLOBALS['dbh'],$sql);
		$row = mysqli_fetch_assoc($result);
		$sql1 = ("SELECT * FROM `".TABLE_PREFIX."core_settings` WHERE name = 'core.secret'");
		$result1 = mysqli_query($GLOBALS['dbh'],$sql1);
		$row1 = mysqli_fetch_assoc($result1);
		$salted_password = md5($row1['value'].$userPass.$row['salt']);
		if($row['password'] == $salted_password) {
			$userid = $row['user_id'];
		}
		$sql = "select value from ".TABLE_PREFIX."authorization_permissions where type='hide_cometchat' and level_id= 101";
		$result = mysqli_query($GLOBALS['dbh'],$sql);
		$row1 = mysqli_fetch_assoc($result);
		if(!empty($row1) && $row1['value'] == 1 ){
			return 0;
		}
		$sql = "select value from ".TABLE_PREFIX."authorization_permissions where type='CometChat' and level_id=".mysqli_real_escape_string($GLOBALS['dbh'],$row['level_id']);
		$result = mysqli_query($GLOBALS['dbh'],$sql);
		$row = mysqli_fetch_assoc($result);
		if(!empty($row) && $row['value']==0){
			return 0;
		}
		if(!empty($userName) && !empty($_REQUEST['social_details'])) {
			$social_details = json_decode($_REQUEST['social_details']);
			$userid = socialLogin($social_details);
		}
		if(!empty($_REQUEST['guest_login']) && $userPass == "CC^CONTROL_GUEST" && $guestsMode == 1){
			$userid = getGuestID($userName);
		}
		if(!empty($userid) && isset($_REQUEST['callbackfn']) && $_REQUEST['callbackfn'] == 'mobileapp'){
			$sql = ("insert into cometchat_status (userid,isdevice) values ('".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."','1') on duplicate key update isdevice = '1'");
                mysqli_query($GLOBALS['dbh'], $sql);
		}
		if($userid && function_exists('mcrypt_encrypt') && defined('ENCRYPT_USERID') && ENCRYPT_USERID == '1') {
			$key = "";
			if( defined('KEY_A') && defined('KEY_B') && defined('KEY_C') ){
				$key = KEY_A.KEY_B.KEY_C;
			}
			$userid = rawurlencode(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $userid, MCRYPT_MODE_CBC, md5(md5($key)))));
		}
		return $userid;
	}

	function getFriendsList($userid,$time) {
		global $hideOffline;
		$offlinecondition = '';
		$sql = ("select ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." userid, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." username, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." link, ".DB_AVATARFIELD." avatar, cometchat_status.lastactivity lastactivity, cometchat_status.lastseen lastseen, cometchat_status.lastseensetting lastseensetting, cometchat_status.status, cometchat_status.message, cometchat_status.isdevice from  ".TABLE_PREFIX."user_membership join ".TABLE_PREFIX.DB_USERTABLE."  on ".TABLE_PREFIX."user_membership.user_id = ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." left join cometchat_status on ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = cometchat_status.userid ".DB_AVATARTABLE." where ".TABLE_PREFIX."user_membership.resource_id = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."' and active = 1 order by username asc");

		if ((defined('MEMCACHE') && MEMCACHE <> 0) || DISPLAY_ALL_USERS == 1) {
			if ($hideOffline) {
				$offlinecondition = "where ((cometchat_status.lastactivity > (".mysqli_real_escape_string($GLOBALS['dbh'],$time)."-".((ONLINE_TIMEOUT)*2).")) OR cometchat_status.isdevice = 1) and (cometchat_status.status IS NULL OR cometchat_status.status <> 'invisible' OR cometchat_status.status <> 'offline') ";
			}
			$sql = ("select ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." userid, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." username, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." link, ".DB_AVATARFIELD." avatar, cometchat_status.lastactivity lastactivity, cometchat_status.lastseen lastseen, cometchat_status.lastseensetting lastseensetting, cometchat_status.status, cometchat_status.message, cometchat_status.isdevice from  ".TABLE_PREFIX.DB_USERTABLE."  left join cometchat_status on ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = cometchat_status.userid ".DB_AVATARTABLE." ".$offlinecondition." order by username asc");
		}

		return $sql;
	}

	function getFriendsIds($userid) {

		$sql = ("select ".TABLE_PREFIX."user_membership.user_id friendid from ".TABLE_PREFIX."user_membership where ".TABLE_PREFIX."user_membership.resource_id = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."' and active = 1");

		return $sql;
	}

	function getUserDetails($userid) {
		$sql = ("select ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." userid, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." username, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." link, ".DB_AVATARFIELD." avatar, cometchat_status.lastactivity lastactivity, cometchat_status.lastseen lastseen, cometchat_status.lastseensetting lastseensetting, cometchat_status.status, cometchat_status.message, cometchat_status.isdevice from ".TABLE_PREFIX.DB_USERTABLE." left join cometchat_status on ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = cometchat_status.userid ".DB_AVATARTABLE." where ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."'");

		return $sql;
	}

	function getActivechatboxdetails($userids) {
		$sql = ("select DISTINCT ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." userid, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." username,  ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." link, ".DB_AVATARFIELD." avatar, cometchat_status.lastactivity lastactivity, cometchat_status.lastseen lastseen, cometchat_status.lastseensetting lastseensetting, cometchat_status.status, cometchat_status.message, cometchat_status.isdevice from ".TABLE_PREFIX.DB_USERTABLE." left join cometchat_status on ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = cometchat_status.userid ".DB_AVATARTABLE." where ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." IN (".$userids.")");

		return $sql;
	}

	function getUserStatus($userid) {
		$sql = ("select ".TABLE_PREFIX.DB_USERTABLE.".status message, cometchat_status.lastseen lastseen, cometchat_status.lastseensetting lastseensetting, cometchat_status.status from ".TABLE_PREFIX.DB_USERTABLE." left join cometchat_status on ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = cometchat_status.userid where ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."'");

		return $sql;
	}

	function fetchLink($link) {
		$cc_url = (defined('CC_SITE_URL') ? CC_SITE_URL : BASE_URL);
		return $cc_url."../profile/".$link;
	}

	function getAvatar($image) {
		$cc_url = (defined('CC_SITE_URL') ? CC_SITE_URL : BASE_URL);
		if (is_file(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.''.$image)) {
			return $cc_url."../".$image;
		} else {
			return $cc_url."../application/modules/User/externals/images/nophoto_user_thumb_icon.png";
		}
	}

	function getTimeStamp() {
		return time();
	}

	function processTime($time) {
		return $time;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/* HOOKS */

	function hooks_message($userid,$to,$unsanitizedmessage,$dir) {
		if($dir == 2){
			return;
		}
		$key = "inbox_sync";
		if(!is_array(getCache($key))) {
			$sql = "SELECT value from ".TABLE_PREFIX."authorization_permissions where type = 'cometchat' AND level_id=100";
			$query = mysqli_query($GLOBALS['dbh'], $sql);
			$result = mysqli_fetch_assoc($query);
			if(empty($result)){
				$arr = array();
				$arr[0] = "sync_disabled";
				setCache($key,$arr,30);
				return;
			}else{
				$val = $result['value'];
				if($val == 1){
					$arr = array();
					$arr[0] = "sync_enabled";
					setCache($key,$arr,30);
				}else{
					$arr = array();
					$arr[0] = "sync_disabled";
					setCache($key,$arr,30);
					return;
				}
			}
		}elseif(key(getCache($key))==='sync_disabled') {
			return;
		}
		if( strpos($unsanitizedmessage,'acceptAVChat')!=false){
			$unsanitizedmessage = 'has sent you Audio/Video chat request';
		}


		if(!empty($unsanitizedmessage)){
			$sql = ("SELECT DISTINCT a.title,a.conversation_id from ".TABLE_PREFIX."messages_conversations a join ".TABLE_PREFIX."messages_recipients b on  a.conversation_id=b.conversation_id join ".TABLE_PREFIX."messages_recipients c where ((b.user_id = ".$userid." and c.user_id = ".$to.") or (c.user_id = ".$userid." and b.user_id = ".$to.")) and a.title = 'chat'");
			$query = mysqli_query($GLOBALS['dbh'],$sql);
			$result = mysqli_fetch_assoc($query);
			$time = date("Y-m-d h:i:s");
			if($result['title'] == 'chat'){
				$convid = $result['conversation_id'];
				$sql = ("Insert into ".TABLE_PREFIX."messages_messages (`conversation_id`, `user_id`, `title`, `body`,`date`) values(".$convid.",".$userid.",'','".$unsanitizedmessage."','".$time."')");
				$query = mysqli_query($GLOBALS['dbh'],$sql);
				$msgid = mysqli_insert_id($GLOBALS['dbh']);
				$sql = "Update ".TABLE_PREFIX."messages_recipients set outbox_message_id= ".$msgid. ", inbox_deleted = 0, outbox_updated = '".$time."' where user_id = ".$userid." and conversation_id = ".$convid;
				$t  = mysqli_query($GLOBALS['dbh'],$sql);
				$sql = "Update ".TABLE_PREFIX."messages_recipients set inbox_message_id= ".$msgid. ", inbox_deleted = 0,inbox_updated = '".$time."' where user_id = ".$to." and conversation_id = ".$convid;
				$u = mysqli_query($GLOBALS['dbh'],$sql);
			}else{
				$sql = ("Insert into ".TABLE_PREFIX."messages_conversations (`title`, `user_id`, `recipients`, `modified`) values('chat',".$userid.",1,'".$time."')");
				$res = mysqli_query($GLOBALS['dbh'],$sql);
				$convid = mysqli_insert_id($GLOBALS['dbh']);
				$sql = ("Insert into ".TABLE_PREFIX."messages_messages (`conversation_id`, `user_id`, `title`, `body`,`date`) values(".$convid.",".$to.",'chat','".$unsanitizedmessage."','".$time."')");
				$query = mysqli_query($GLOBALS['dbh'],$sql);
				$msgid = mysqli_insert_id($GLOBALS['dbh']);
				$sql = ("Insert into ".TABLE_PREFIX."messages_recipients (`user_id`, `conversation_id`, `inbox_message_id`, `inbox_updated`,`inbox_read`,`inbox_deleted`,`outbox_message_id`,`outbox_updated`,`outbox_deleted`) values(".$userid.",".$convid.",NULL,NULL,1,1,".$msgid.",'".$time."',0)");
				$query = mysqli_query($GLOBALS['dbh'],$sql);
				$sql = ("Insert into ".TABLE_PREFIX."messages_recipients (`user_id`, `conversation_id`, `inbox_message_id`, `inbox_updated`,`inbox_read`,`inbox_deleted`,`outbox_message_id`,`outbox_updated`,`outbox_deleted`) values(".$to.",".$convid.",".$msgid.",'".$time."',0,0,0,NULL,1)");
				$query = mysqli_query($GLOBALS['dbh'],$sql);
			}
		}
	}

	function hooks_forcefriends() {

	}

	function hooks_updateLastActivity($userid) {

	}

	function hooks_statusupdate($userid,$statusmessage) {
		$sql = ("update ".TABLE_PREFIX.DB_USERTABLE." set status = '".mysqli_real_escape_string($GLOBALS['dbh'],$statusmessage)."', status_date = '".date("Y-m-d H:i:s",getTimeStamp())."' where ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."'");
		$query = mysqli_query($GLOBALS['dbh'],$sql);
	}

	function hooks_activityupdate($userid,$status) {

	}

}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* Nulled by MisterWizard */

$p_ = 4;


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
