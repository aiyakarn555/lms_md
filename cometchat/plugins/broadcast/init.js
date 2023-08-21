<?php

		include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR."en.php");
		include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."config.php");
		if (file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$lang.".php")) {
			include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$lang.".php");
		}

		foreach ($broadcast_language as $i => $l) {
			$broadcast_language[$i] = str_replace("'", "\'", $l);
		}

                $width = $camWidth;
				$height = $camHeight;

                if($videoPluginType == 3) {
                    $width = $vidWidth;
                    $height = $vidHeight;
                }

                if($videoPluginType == 1) {
                	$videoPluginType == 0;
                }
?>

/*
 * CometChat
 * Copyright (c) 2016 Inscripts - support@cometchat.com | http://www.cometchat.com | http://www.inscripts.com
*/

(function($){

		$.ccbroadcast = (function () {
		var title = '<?php echo $broadcast_language[0];?>';
		var type = <?php echo $videoPluginType;?>;
		if(type == 3) {allowresize = 0; force = 0;} else {allowresize = 1; force = 1;}

		var lastcall = 0;
		var supported = true;
		var mobileDevice = navigator.userAgent.match(/ipad|ipod|iphone|android|windows ce|Windows Phone|blackberry|palm|symbian/i);
		var Browser = (function(){
			var ua= navigator.userAgent, tem,
			M= ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
			if(/trident/i.test(M[1])){
				tem=  /\brv[ :]+(\d+)/g.exec(ua) || [];
				return 'IE '+(tem[1] || '');
			}
			if(M[1]=== 'Chrome'){
				tem= ua.match(/\bOPR\/(\d+)/);
				if(tem!= null) return 'Opera '+tem[1];
			}
			M= M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
			if((tem= ua.match(/version\/(\d+)/i))!= null) M.splice(1, 1, tem[1]);
			return M;
		})();
		if(Browser[0]=='MSIE' && parseInt(Browser[1]) < 11 ){
			supported = false;
		}
		   return {
				getTitle: function() {
					return title;
				},

				init: function (params) {
					var id = params.to;
					var chatroommode = params.chatroommode;
					var windowMode = 0;
					if(typeof(params.windowMode) == "undefined") {
						windowMode = 0;
					} else {
						windowMode = 1;
					}
					if(location.protocol === 'http:') {
						windowMode = 1;
					}
					if(supported) {
					var caller = "";
					if(typeof(params.caller) != "undefined") {
						caller = params.caller;
					}
						if(chatroommode == 1) {
							baseUrl = $.cometchat.getBaseUrl();
							basedata = $.cometchat.getBaseData();
							if(mobileDevice == null){
								loadCCPopup(baseUrl+'plugins/broadcast/index.php?action=call&chatroommode=1&broadcast=0&type=1&caller='+caller+'&to='+id+'&grp='+id+'&basedata='+basedata, 'broadcast',"status=0,toolbar=0,menubar=0,directories=0,resizable=1,location=0,status=0,scrollbars=0, width=<?php echo $width;?>,height=<?php echo $height;?>",<?php echo $width;?>,<?php echo $height;?>,'<?php echo $broadcast_language[8];?>',1,1,allowresize,1,windowMode);
							} else{
								loadCCPopup(baseUrl+'plugins/broadcast/index.php?action=call&chatroommode=1&broadcast=0&type=1&caller='+caller+'&to='+id+'&grp='+id+'&basedata='+basedata, 'broadcast',"status=0,toolbar=0,menubar=0,directories=0,resizable=1,location=0,status=0,scrollbars=0, width=<?php echo $width;?>,height=<?php echo $height;?>",<?php echo $width;?>,<?php echo $height;?>,'<?php echo $broadcast_language[8];?>',1,1,allowresize,1,1);
							}
						} else {
							var random = '';
							var currenttime = new Date();
							currenttime = parseInt(currenttime.getTime()/1000);
							if (currenttime-lastcall > 10) {
								baseUrl = $.cometchat.getBaseUrl();
								baseData = $.cometchat.getBaseData();
								if (jqcc.cometchat.getThemeArray('buddylistIsDevice',id) == 1) {
									jqcc.ccmobilenativeapp.sendnotification('<?php echo $broadcast_language[5];?>', id, jqcc.cometchat.getName(jqcc.cometchat.getThemeVariable('userid')));
								}
								if(mobileDevice == null){
					  				loadCCPopup(baseUrl+'plugins/broadcast/index.php?action=request&broadcast=0&type=1&caller='+caller+'&to='+id+'&basedata='+baseData, 'broadcast',"status=0,toolbar=0,menubar=0,directories=0,resizable=1,location=0,status=0,scrollbars=0, width=<?php echo $width;?>,height=<?php echo $height;?>",<?php echo $width;?>,<?php echo $height;?>,'<?php echo $broadcast_language[8];?>',1,1,allowresize,1,windowMode);
					  			} else{
					  				loadCCPopup(baseUrl+'plugins/broadcast/index.php?action=request&broadcast=0&type=1&caller='+caller+'&to='+id+'&basedata='+baseData, 'broadcast',"status=0,toolbar=0,menubar=0,directories=0,resizable=1,location=0,status=0,scrollbars=0, width=<?php echo $width;?>,height=<?php echo $height;?>",<?php echo $width;?>,<?php echo $height;?>,'<?php echo $broadcast_language[8];?>',1,1,allowresize,1,1);
					  			}

								lastcall = currenttime;
							} else {
								alert('<?php echo $broadcast_language[1];?>');
							}
						}
					} else {
						alert('<?php echo $broadcast_language[25];?>');
					}
				},

				accept: function (params) {
					id = params.to;
					grp = params.grp;
					if(typeof(params.windowMode) == "undefined") {
						windowMode = 0;
					} else {
						windowMode = 1;
					}
					if(location.protocol === 'http:') {
						windowMode = 1;
					}
					baseUrl = $.cometchat.getBaseUrl();
					baseData = $.cometchat.getBaseData();
					if(jqcc.cometchat.getCcvariable().callbackfn=='desktop'){
						loadCCPopup(baseUrl+'plugins/broadcast/index.php?action=call&broadcast=1&type=0&grp='+grp+'&basedata='+baseData, 'broadcast',"status=0,toolbar=0,menubar=0,directories=0,type=0,resizable=1,location=0,status=0,scrollbars=0, width=<?php echo $width;?>,height=<?php echo $height;?>",<?php echo $width;?>,<?php echo $height;?>,'<?php echo $broadcast_language[8];?>',1,1,allowresize,1,1);
					}else if(mobileDevice == null){
						loadCCPopup(baseUrl+'plugins/broadcast/index.php?action=call&broadcast=1&type=0&grp='+grp+'&basedata='+baseData, 'broadcast',"status=0,toolbar=0,menubar=0,directories=0,type=0,resizable=1,location=0,status=0,scrollbars=0, width=<?php echo $width;?>,height=<?php echo $height;?>",<?php echo $width;?>,<?php echo $height;?>,'<?php echo $broadcast_language[8];?>',1,1,allowresize,1,windowMode);
					} else{
						loadCCPopup(baseUrl+'plugins/broadcast/index.php?action=call&broadcast=1&type=0&grp='+grp+'&basedata='+baseData, 'broadcast',"status=0,toolbar=0,menubar=0,directories=0,type=0,resizable=1,location=0,status=0,scrollbars=0, width=<?php echo $width;?>,height=<?php echo $height;?>",<?php echo $width;?>,<?php echo $height;?>,'<?php echo $broadcast_language[8];?>',1,1,allowresize,1,1);
					}
				},

				join: function (params) {
					id = params.grp;
					chatroommode = 0;
					if(typeof(params.chatroommode) !== "undefined"){
					    chatroommode = params.chatroommode;
					}
					baseUrl = $.cometchat.getBaseUrl();
					basedata = $.cometchat.getBaseData();
					var windowMode = 0;
					if(typeof(params.windowMode) == "undefined") {
						windowMode = 0;
					} else {
						windowMode = 1;
					}
					if((location.protocol === 'http:' && type == '0') || mobileDevice != null) {
						windowMode = 1;
					}
					if(typeof(parent) != 'undefined' && parent != null && parent != self){
						var controlparameters = {"type":"plugins", "name":"core", "method":"loadCCPopup", "params":{"url": baseUrl+'plugins/broadcast/index.php?action=call&broadcast=1&chatroommode=1&type=0&join=1&grp='+id+'&basedata='+basedata, "name":"broadcast", "properties":"status=0,toolbar=0,menubar=0,directories=0,resizable=1,location=0,status=0,scrollbars=0, width=<?php echo $width;?>,height=<?php echo $height;?>", "width":"<?php echo $width;?>", "height":"<?php echo $height;?>", "title":'<?php echo $broadcast_language[8];?>', "force":force, "allowmaximize":"1", "allowresize":allowresize, "allowpopout":"1", "windowMode":windowMode}};
	                    controlparameters = JSON.stringify(controlparameters);
	                    parent.postMessage('CC^CONTROL_'+controlparameters,'*');
					} else { 
						loadCCPopup(baseUrl+'plugins/broadcast/index.php?action=call&broadcast=1&chatroommode=1&type=0&join=1&grp='+id+'&basedata='+basedata, 'broadcast',"status=0,toolbar=0,menubar=0,directories=0,resizable=1,location=0,status=0,scrollbars=0, width=<?php echo $width;?>,height=<?php echo $height;?>",<?php echo $width;?>,<?php echo $height;?>,'<?php echo $broadcast_language[8];?>',force,1,allowresize,1,windowMode);
					}
				},

				end_call : function(params){
					var id = params.to;
					var grp = params.grp;
					var chatroommode = params.chatroommode;
					baseUrl = $.cometchat.getBaseUrl();
					baseData = $.cometchat.getBaseData();
					var popoutopencalled = 0;
					var endcallrecieved = 0;
					if(chatroommode == 0){
						popoutopencalled = jqcc.cometchat.getInternalVariable('broadcastpopoutcalled');
						endcallrecieved = jqcc.cometchat.getInternalVariable('endcallrecievedfrom_'+grp);
					}
					if(chatroommode==1 || (jqcc.cometchat.getInternalVariable('endcallOnceWindow_'+grp) !== '1' && jqcc.cometchat.getInternalVariable('endcallOnce_'+grp) !== '1')) {
						if(popoutopencalled !== '1' && endcallrecieved !== '1'){
							$.ajax({
								url : baseUrl+'plugins/broadcast/index.php?action=endcall',
								type : 'GET',
								data : {to: id, basedata: baseData , grp: grp, chatroommode: chatroommode},
								dataType : 'jsonp',
								success : function(data) {

								},
								error : function(data) {

								}
							});
						}
					}
					if(chatroommode == 0){
						jqcc.cometchat.setInternalVariable('endcallrecievedfrom_'+grp,'0');
						jqcc.cometchat.setInternalVariable('broadcastpopoutcalled','0');
					}
				},

				inviteBroadcast: function(params) {
					var id = params.id;
					var caller = '';
					if(typeof(params.caller) != "undefined") {
						caller = params.caller;
					}
					baseData = $.cometchat.getBaseData();
					baseUrl = $.cometchat.getBaseUrl();
					var windowMode = 0;
					if(typeof(params.windowMode) == "undefined") {
						windowMode = 0;
					} else {
						windowMode = 1;
					}
					if(location.protocol === 'http:') {
						windowMode = 1;
					}
					if(location.protocol === 'http:') {
						windowMode = 1;
					}
					if(mobileDevice == null){
						loadCCPopup(baseUrl + "plugins/broadcast/invite.php?action=invite&caller="+caller+"&grp="+ id +"&basedata="+ baseData ,"invitebroadcast","status=0,toolbar=0,menubar=0,directories=0,resizable=0,location=0,status=0,scrollbars=1, width=400,height=190",400,190,"<?php echo $broadcast_language[11];?>",0,0,0,0,windowMode);
					} else{
						loadCCPopup(baseUrl + "plugins/broadcast/invite.php?action=invite&caller="+caller+"&grp="+ id +"&basedata="+ baseData ,"invitebroadcast","status=0,toolbar=0,menubar=0,directories=0,resizable=0,location=0,status=0,scrollbars=1, width=400,height=190",400,190,"<?php echo $broadcast_language[11];?>",0,0,0,0,1);
					}
				},
				getLangVariables: function() {
					return <?php echo json_encode($broadcast_language); ?>;
				},
				processControlMessage : function(controlparameters) {
					var broadcast_language = jqcc.ccbroadcast.getLangVariables();
					var processedmessage = null;
					<?php if($videoPluginType == 0) : ?>

					switch(controlparameters.method){
						case 'endcall':
							if(controlparameters.params.chatroommode==0){
								jqcc.cometchat.setInternalVariable('endcallrecievedfrom_'+controlparameters.params.grp,'1');
							}
							processedmessage = broadcast_language[24];
						break;
						default :
						processedmessage = null;
						break;
					}
					<?php endif; ?>
					return processedmessage;
				}
			};
		})();

})(jqcc);

jqcc(document).ready(function(){
	jqcc('.join_Broadcast').live('click',function(){
		var grp = jqcc(this).attr('grp');
		if(typeof(parent) != 'undefined' && parent != null && parent != self){
			var controlparameters = {"type":"plugins", "name":"ccbroadcast", "method":"join", "params":{"grp":grp, "chatroommode":"1"}};
			controlparameters = JSON.stringify(controlparameters);
			if(typeof(parent) != 'undefined' && parent != null && parent != self){
				parent.postMessage('CC^CONTROL_'+controlparameters,'*');
			} else {
				window.opener.postMessage('CC^CONTROL_'+controlparameters,'*');
			}
		} else {
			var controlparameters = {"grp":grp};
            jqcc.ccbroadcast.join(controlparameters);
		}
	});

	jqcc('.broadcastAccept').live('click',function(){
		var to = jqcc(this).attr('to');
		var grp = jqcc(this).attr('grp');
		if((typeof(parent) != 'undefined' && parent != null && parent != self) || window.top != window.self){
			var controlparameters = {"type":"plugins", "name":"ccbroadcast", "method":"accept", "params":{"to":to, "grp":grp}};
			controlparameters = JSON.stringify(controlparameters);
			parent.postMessage('CC^CONTROL_'+controlparameters,'*');
		} else {
			var controlparameters = {"to":to, "grp":grp};
            jqcc.ccbroadcast.accept(controlparameters);
		}
	});

	jqcc('.broadcastInvite').live('click',function(){
		var to = jqcc(this).attr('to');
		var grp = jqcc(this).attr('grp');
		if((typeof(parent) != 'undefined' && parent != null && parent != self) || window.top != window.self){
			var controlparameters = {"type":"plugins", "name":"ccbroadcast", "method":"accept", "params":{"to":to, "grp":grp}};
			controlparameters = JSON.stringify(controlparameters);
			parent.postMessage('CC^CONTROL_'+controlparameters,'*');
		} else {
			var controlparameters = {"to":to, "grp":grp};
            jqcc.ccbroadcast.join(controlparameters);
		}
	});
});