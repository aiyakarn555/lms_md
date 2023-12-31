<?php

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$addonfolder = str_replace(DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.'en.php','', __FILE__);
$addonarray = explode(DIRECTORY_SEPARATOR, $addonfolder);
$addonname = end($addonarray);
$addontype = rtrim(prev($addonarray),'s');

/* LANGUAGE */

${$addonname.'_language'}['title']			 = setLanguageValue('title','Start an audio call',$lang,$addontype,$addonname);
${$addonname.'_language'}['wait_message']	 = setLanguageValue('wait_message','Please wait atleast 10 seconds before trying to call again.',$lang,$addontype,$addonname);
${$addonname.'_language'}['audio_chat_request'] = setLanguageValue('audio_chat_request','has sent you an audio chat request.',$lang,$addontype,$addonname);
${$addonname.'_language'}['accept_request'] = setLanguageValue('accept_request','Click here to accept it',$lang,$addontype,$addonname);
${$addonname.'_language'}['ignore_request'] = setLanguageValue('ignore_request','or simply ignore this message.',$lang,$addontype,$addonname);
${$addonname.'_language'}['request_success'] = setLanguageValue('request_success','has successfully sent an audio chat request.',$lang,$addontype,$addonname);
${$addonname.'_language'}['request_accepted'] = setLanguageValue('request_accepted','has accepted your audio chat request.',$lang,$addontype,$addonname);
${$addonname.'_language'}['launch_window'] = setLanguageValue('launch_window','Click here to launch the audio chat window',$lang,$addontype,$addonname);
${$addonname.'_language'}['audio_chat'] = setLanguageValue('audio_chat','Audio Chat',$lang,$addontype,$addonname);
${$addonname.'_language'}['connection_issues'] = setLanguageValue('connection_issues','Having issues connecting?',$lang,$addontype,$addonname);
${$addonname.'_language'}['audio_chat_stuck'] = setLanguageValue('audio_chat_stuck','There are several reasons why the audio chat may be stuck at initializing:
<br/><br/>
1. audio chat requires P2P to establish connection. In order for it to work, your firewall must be configured to allow outgoing UDP traffic. While this is the case with most consumer or small office/home office (SOHO) firewalls, many corporate firewalls block UDP traffic altogether.
<br/><br/>
2. The user at the other end is behind a UDP blocking firewall and is unable to connect to you.
<br/><br/>
3. Our servers are facing issues and you are unable to connect.
',$lang,$addontype,$addonname);
${$addonname.'_language'}['closing_window'] = setLanguageValue('closing_window','Closing window shortly',$lang,$addontype,$addonname);
${$addonname.'_language'}['invite_success_close_win'] = setLanguageValue('invite_success_close_win','Users have been successfully invited. You can safely close this window.',$lang,$addontype,$addonname);
${$addonname.'_language'}['invite_success'] = setLanguageValue('invite_success','Users Invited Successfully!',$lang,$addontype,$addonname);
${$addonname.'_language'}['acon_invite'] = setLanguageValue('acon_invite','has invited you to join a audio conference.',$lang,$addontype,$addonname);
${$addonname.'_language'}['click_to_join'] = setLanguageValue('click_to_join','Click here to join',$lang,$addontype,$addonname);
${$addonname.'_language'}['select_users'] = setLanguageValue('select_users','Please select users',$lang,$addontype,$addonname);
${$addonname.'_language'}['invite_users_1'] = setLanguageValue('invite_users_1','Invite Users',$lang,$addontype,$addonname);
${$addonname.'_language'}['invite_users_2'] = setLanguageValue('invite_users_2','Invite Users',$lang,$addontype,$addonname);
${$addonname.'_language'}['acon_started'] = setLanguageValue('acon_started','has started a audio conversation.',$lang,$addontype,$addonname);
${$addonname.'_language'}['join_conversation'] = setLanguageValue('join_conversation','Click here to join the conversation.',$lang,$addontype,$addonname);
${$addonname.'_language'}['settings'] = setLanguageValue('','Settings',$lang,$addontype,$addonname);
${$addonname.'_language'}['done'] = setLanguageValue('done','Done',$lang,$addontype,$addonname);
${$addonname.'_language'}['play_test_sound'] = setLanguageValue('play_test_sound','Play test sound',$lang,$addontype,$addonname);
${$addonname.'_language'}['install_plugin'] = setLanguageValue('install_plugin','Install plug-in',$lang,$addontype,$addonname);
${$addonname.'_language'}['no_users_available'] = setLanguageValue('no_users_available','Sorry, there are no users available at the moment to invite.',$lang,$addontype,$addonname);
${$addonname.'_language'}['click_to_open'] = setLanguageValue('click_to_open','Click here to open it',$lang,$addontype,$addonname);
${$addonname.'_language'}['check_email'] = setLanguageValue('check_email','Please check your email for verification zoom account at',$lang,$addontype,$addonname);
${$addonname.'_language'}['call'] = setLanguageValue('call','Call',$lang,$addontype,$addonname);
${$addonname.'_language'}['call_from'] = setLanguageValue('call_from','Call from',$lang,$addontype,$addonname);
${$addonname.'_language'}['call_to'] = setLanguageValue('call_to','Call to',$lang,$addontype,$addonname);
${$addonname.'_language'}['call_ended'] = setLanguageValue('call_ended','Call ended, duration',$lang,$addontype,$addonname);
${$addonname.'_language'}['rejected'] = setLanguageValue('rejected','rejected',$lang,$addontype,$addonname);
${$addonname.'_language'}['no_answer_from'] = setLanguageValue('no_answer_from','No answer from',$lang,$addontype,$addonname);
${$addonname.'_language'}['cancelled'] = setLanguageValue('cancelled','Cancelled',$lang,$addontype,$addonname);
${$addonname.'_language'}['call_new'] = setLanguageValue('call_new','Would you like to call',$lang,$addontype,$addonname);
${$addonname.'_language'}['busy'] = setLanguageValue('busy','busy',$lang,$addontype,$addonname);
${$addonname.'_language'}['call_cancelled'] = setLanguageValue('call_cancelled','This call has been cancelled',$lang,$addontype,$addonname);
${$addonname.'_language'}['call_ended_1'] = setLanguageValue('call_ended_1','This call has ended',$lang,$addontype,$addonname);
${$addonname.'_language'}['user_busy'] = setLanguageValue('user_busy','The user is busy right now. Please try again later',$lang,$addontype,$addonname);
${$addonname.'_language'}['user_not_answering'] = setLanguageValue('user_not_answering','The user is not answering the call right now. Please try again later',$lang,$addontype,$addonname);
${$addonname.'_language'}['err_sending_message'] = setLanguageValue('err_sending_message','Sorry, we are unable to send this message.',$lang,$addontype,$addonname);
${$addonname.'_language'}['err_no_device_support'] = setLanguageValue('err_no_device_support','Sorry, your device does not support this feature.',$lang,$addontype,$addonname);
${$addonname.'_language'}['click_here'] = setLanguageValue('click_here','click here',$lang,$addontype,$addonname);
${$addonname.'_language'}['cancel_outgoing_call'] = setLanguageValue('cancel_outgoing_call','To cancel outgoing call ',$lang,$addontype,$addonname);
${$addonname.'_language'}['reject_call'] = setLanguageValue('reject_call','To reject call ',$lang,$addontype,$addonname);
${$addonname.'_language'}['ignore_message'] = setLanguageValue('ignore_message','You can also simply ignore this message.',$lang,$addontype,$addonname);
${$addonname.'_language'}['configure_plugin'] = setLanguageValue('configure_plugin','Please configure this plugin using administration panel before using. <a href="http://www.cometchat.com/documentation/admin/plugins/audio-chat-plugin/" target="_blank">Click Here</a> for more information.',$lang,$addontype,$addonname);
${$addonname.'_language'}['err_no_browser_support'] = setLanguageValue('err_no_browser_support','Sorry, your browser does not support this feature. Please upgrade your browser to the latest version or try a different browser.',$lang,$addontype,$addonname);
${$addonname.'_language'}['end_call'] = setLanguageValue('end_call','End Call',$lang,$addontype,$addonname);
${$addonname.'_language'}['turn_on_mic'] = setLanguageValue('turn_on_mic','Turn On Mic',$lang,$addontype,$addonname);
${$addonname.'_language'}['turn_off_mic'] = setLanguageValue('turn_off_mic','Turn Off Mic',$lang,$addontype,$addonname);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


${$addonname.'_key_mapping'} = array(
	'0'		=>	'title',
	'1'		=>	'wait_message',
	'2'		=>	'audio_chat_request',
	'3'		=>	'accept_request',
	'4'		=>	'ignore_request',
	'5'		=>	'request_success',
	'6'		=>	'request_accepted',
	'7'		=>	'launch_window',
	'8'		=>	'audio_chat',
	'9'		=>	'connection_issues',
	'10'	=>	'audio_chat_stuck',
	'11'	=>	'closing_window',
	'12'	=>	'invite_success_close_win',
	'13'	=>	'invite_success',
	'14'	=>	'acon_invite',
	'15'	=>	'click_to_join',
	'16'	=>	'select_users',
	'17'	=>	'invite_users_1',
	'18'	=>	'invite_users_2',
	'19'	=>	'acon_started',
	'20'	=>	'join_conversation',
	'21'	=>	'settings',
	'22'	=>	'done',
	'23'	=>	'play_test_sound',
	'24'	=>	'install_plugin',
	'25'	=>	'no_users_available',
	'26'	=>	'click_to_open',
	'27'	=>	'check_email',
	'28'	=>	'call',
	'29'	=>	'call_from',
	'30'	=>	'call_to',
	'31'	=>	'call_ended',
	'32'	=>	'rejected',
	'33'	=>	'no_answer_from',
	'34'	=>	'cancelled',
	'35'	=>	'call_new',
	'36'	=>	'busy',
	'37'	=>	'call_cancelled',
	'38'	=>	'call_ended_1',
	'39'	=>	'user_busy',
	'40'	=>	'user_not_answering',
	'41'	=>	'err_sending_message',
	'42'	=>	'err_no_device_support',
	'43'	=>	'click_here',
	'44'	=>	'cancel_outgoing_call',
	'45'	=>	'reject_call',
	'46'	=>	'ignore_message',
	'47'	=>	'configure_plugin',
	'48'	=>	'err_no_browser_support',
	'49'	=>	'end_call',
	'50'	=>	'turn_on_mic',
	'51'	=>	'turn_off_mic'
);

${$addonname.'_language'} = mapLanguageKeys(${$addonname.'_language'},${$addonname.'_key_mapping'},$addontype,$addonname);