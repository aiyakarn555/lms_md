<?php
		include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."config.php");
		include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR."en.php");

		if (file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$lang.".php")) {
			include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."lang".DIRECTORY_SEPARATOR.$lang.".php");
		}

		foreach ($avchat_language as $i => $l) {
			$avchat_language[$i] = str_replace("'", "\'", $l);
		}

		if ($videoPluginType == 3) {
			$width = 330;
			$height = 330;
		} else {
			$width = 434;
			$height = 356;
		}
		if ($videoPluginType == '1') {
			$videoPluginType = '0';
		}
?>

/*
 * CometChat
 * Copyright (c) 2016 Inscripts - support@cometchat.com | http://www.cometchat.com | http://www.inscripts.com
*/

String.prototype.replaceAll=function(s1, s2) {return this.split(s1).join(s2)};
(function($){

		$.ccavchat = (function () {
		var title = '<?php echo $avchat_language[0];?>';
		var type = '<?php echo $videoPluginType;?>';
		var supported = true;
		<?php
			if($videoPluginType == 0) :
		?>
		var Browser = (function(){
		    var ua= navigator.userAgent, tem,
		    M= ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
		    if(/trident/i.test(M[1])){
		        tem=  /\brv[ :]+(\d+)/g.exec(ua) || [];
		        return 'IE '+(tem[1] || '');
		    }
		    if(M[1]=== 'Chrome'){
		        tem= ua.match(/\bOPR\/(\d+)/)
		        if(tem!= null) return 'Opera '+tem[1];
		    }
		    M= M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
		    if((tem= ua.match(/version\/(\d+)/i))!= null) M.splice(1, 1, tem[1]);
		    return M;
		})();
		if(Browser[0]=='MSIE' && parseInt(Browser[1]) < 11 ){
			supported = false;
		}
		<?php
			endif;
		?>
		var lastcall = 0;
                if(type == 3) {allowresize = 0} else {allowresize = 1}

        return {

			getTitle: function() {
				return title;
			},
			init: function (params) {
				var id = params.to;
				var chatroommode = params.chatroommode;
				var caller = '';
				if(typeof(caller) != "undefined"){
					caller = params.caller;
				}
				var windowMode = 0;
				if(typeof(params.windowMode) == "undefined") {
					windowMode = 0;
				} else {
					windowMode = 1;
				}
				if(location.protocol === 'http:' && type == '0') {
					windowMode = 1;
				}
				if(supported) {
					var currenttime = new Date();
					currenttime = parseInt(currenttime.getTime()/1000);
					if (currenttime-lastcall > 10) {
						baseUrl = $.cometchat.getBaseUrl();
						baseData = $.cometchat.getBaseData();
						if(chatroommode == 1){
							jqcc.ajax({
								url : baseUrl+'plugins/avchat/index.php?chatroommode=1&action=request',
								type : 'GET',
								data : {to: id, basedata: baseData, caller: caller},
								dataType : 'jsonp',
								success : function(data) {
									if(typeof(data) != "undefined" && data != null && data != ''){
										id = data;
									}
									if(jqcc.cometchat.getThemeVariable('mobileDevice') == null){
										loadCCPopup(baseUrl+'plugins/avchat/index.php?action=call&caller='+caller+'&chatroommode=1&grp='+id+'&basedata='+baseData, 'audiovideochat',"status=0,toolbar=0,menubar=0,directories=0,resizable=1,location=0,status=0,scrollbars=0, width=<?php echo $width;?>,height=<?php echo $height;?>",<?php echo $width;?>,<?php echo $height;?>,'<?php echo $avchat_language[8];?>',1,1,allowresize,1,windowMode);
									} else {
										loadCCPopup(baseUrl+'plugins/avchat/index.php?action=call&caller='+caller+'&chatroommode=1&grp='+id+'&basedata='+baseData, 'audiovideochat',"status=0,toolbar=0,menubar=0,directories=0,resizable=1,location=0,status=0,scrollbars=0, width=<?php echo $width;?>,height=<?php echo $height;?>",<?php echo $width;?>,<?php echo $height;?>,'<?php echo $avchat_language[8];?>',1,1,allowresize,1,1);
									}
								},
								error : function(data) {
								}
							});
						}else{
							jqcc.ajax({
								url : baseUrl+'plugins/avchat/index.php?action=request',
								type : 'GET',
								data : {to: id, basedata: baseData, caller: caller},
								dataType : 'jsonp',
								success : function(data) {
								},
								error : function(data) {
								}
							});
							if (jqcc.cometchat.getThemeArray('buddylistIsDevice',id) == 1) {
								jqcc.ccmobilenativeapp.sendnotification('<?php echo $avchat_language[5];?>', id, jqcc.cometchat.getName(jqcc.cometchat.getThemeVariable('userid')));
							}
						}
						lastcall = currenttime;
					} else {
						alert('<?php echo $avchat_language[1];?>');
					}
				} else {
					alert('<?php echo $avchat_language[48];?>');
				}
			},

			accept: function (params) {
				id = params.to;
				grp = params.grp;
				join_url = params.join_url;
				start_url = params.start_url;
				chatroommode = params.chatroommode;
				windowMode = 0;
				var caller = '';
				if(typeof(params.caller) != "undefined"){
					caller = params.caller;
				}
				if(typeof(params.windowMode) == "undefined") {
					windowMode = 0;
				} else {
					windowMode = 1;
				}
				if(location.protocol === 'http:' && type == '0') {
					windowMode = 1;
				}
				if(supported){
					baseUrl = $.cometchat.getBaseUrl();
					baseData = $.cometchat.getBaseData();
					<?php
					if($videoPluginType == 0) :
					?>
					var controlparameters = {"grp":params.grp};
					jqcc.ccavchat.delinkAvchat(controlparameters);
					if(caller != "" && caller != "undefined") {
						var returnparameters = {"type":"plugins", "name":"ccavchat", "method":"delinkAvchat", "params":{"grp":grp}};
						returnparameters = JSON.stringify(returnparameters);
						jqcc('#'+caller)[0].contentWindow.postMessage('CC^CONTROL_'+returnparameters,'*');
					}
					<?php
						endif;
					?>
					if(chatroommode == 1){
						$.getJSON(baseUrl+'plugins/avchat/index.php?chatroommode=1&action=accept&callback=?', {to: id, start_url:start_url, grp: grp, basedata: baseData, caller: caller});
					} else {
						$.getJSON(baseUrl+'plugins/avchat/index.php?action=accept&callback=?', {to: id, start_url:start_url, grp: grp, basedata: baseData, caller: caller});
					}
					
					if(jqcc.cometchat.getCcvariable().callbackfn=='desktop'){
						loadCCPopup(baseUrl+'plugins/avchat/index.php?action=call&grp='+grp+'&basedata='+baseData+'&to='+id, 'audiovideochat',"status=0,toolbar=0,menubar=0,directories=0,resizable=1,location=0,status=0,scrollbars=0, width=<?php echo $camWidth;?>,height=<?php echo $camHeight;?>",<?php echo $camWidth;?>,<?php echo $camHeight;?>,'<?php echo $avchat_language[8];?>',0,1,allowresize,1,windowMode);
					}else if(jqcc.cometchat.getThemeVariable('mobileDevice') == null) {
						loadCCPopup(baseUrl+'plugins/avchat/index.php?action=call&caller='+caller+'&grp='+grp+'&basedata='+baseData+'&to='+id, 'audiovideochat',"status=0,toolbar=0,menubar=0,directories=0,resizable=1,location=0,status=0,scrollbars=0, width=<?php echo $camWidth;?>,height=<?php echo $camHeight;?>",<?php echo $camWidth;?>,<?php echo $camHeight;?>,'<?php echo $avchat_language[8];?>',0,1,allowresize,null,windowMode);
					} else{
						loadCCPopup(baseUrl+'plugins/avchat/index.php?action=call&caller='+caller+'&grp='+grp+'&basedata='+baseData+'&to='+id, 'audiovideochat',"status=0,toolbar=0,menubar=0,directories=0,resizable=1,location=0,status=0,scrollbars=0, width=<?php echo $camWidth;?>,height=<?php echo $camHeight;?>",<?php echo $camWidth;?>,<?php echo $camHeight;?>,'<?php echo $avchat_language[8];?>',0,1,allowresize,null,1);
					}
				} else {
					alert('<?php echo $avchat_language[48];?>');
				}
			},

			accept_fid: function (params) {
				id = params.to;
				grp = params.grp;
				start_url = params.start_url;
				windowMode = 0;
				var caller = '';
				if(typeof(params.caller) != "undefined"){
					caller = params.caller;
				}
				if(location.protocol === 'http:' && type == '0') {
					windowMode = 1;
				}
				<?php
					if($videoPluginType == 0) :
				?>
				var controlparameters = {"grp":params.grp};
				jqcc.ccavchat.delinkAvchat(controlparameters);
				if(caller != "" && caller != "undefined") {
					var returnparameters = {"type":"plugins", "name":"ccavchat", "method":"delinkAvchat", "params":{"grp":grp}};
					returnparameters = JSON.stringify(returnparameters);
					jqcc('#'+caller)[0].contentWindow.postMessage('CC^CONTROL_'+returnparameters,'*');
				}
				<?php
					endif;
				?>
				baseUrl = $.cometchat.getBaseUrl();
				baseData = $.cometchat.getBaseData();
				if(jqcc.cometchat.getCcvariable().callbackfn=='desktop'){
					loadCCPopup(baseUrl+'plugins/avchat/index.php?action=call&grp='+grp+'&basedata='+baseData+'&to='+id, 'audiovideochat',"status=0,toolbar=0,menubar=0,directories=0,resizable=1,location=0,status=0,scrollbars=0, width=<?php echo $camWidth;?>,height=<?php echo $camHeight;?>",<?php echo $camWidth;?>,<?php echo $camHeight;?>,'<?php echo $avchat_language[8];?>',0,1,allowresize,1,1);
				}else if(jqcc.cometchat.getThemeVariable('mobileDevice') == null){
					loadCCPopup(baseUrl+'plugins/avchat/index.php?action=call&caller='+caller+'&grp='+grp+'&basedata='+baseData+'&to='+id, 'audiovideochat',"status=0,toolbar=0,menubar=0,directories=0,resizable=1,location=0,status=0,scrollbars=0, width=<?php echo $camWidth;?>,height=<?php echo $camHeight;?>",<?php echo $camWidth;?>,<?php echo $camHeight;?>,'<?php echo $avchat_language[8];?>',0,1,allowresize,1,windowMode);
				} else{
					loadCCPopup(baseUrl+'plugins/avchat/index.php?action=call&caller='+caller+'&grp='+grp+'&basedata='+baseData+'&to='+id, 'audiovideochat',"status=0,toolbar=0,menubar=0,directories=0,resizable=1,location=0,status=0,scrollbars=0, width=<?php echo $camWidth;?>,height=<?php echo $camHeight;?>",<?php echo $camWidth;?>,<?php echo $camHeight;?>,'<?php echo $avchat_language[8];?>',0,1,allowresize,1,1);
				}
			},
           	ignore_call : function(id,grp){
           		basedata = $.cometchat.getBaseData();
           		baseUrl = $.cometchat.getBaseUrl();
            	$.ajax({
					url : baseUrl+'plugins/avchat/index.php?action=noanswer',
					type : 'GET',
					data : {to: id,grp: grp,basedata:basedata},
					dataType : 'jsonp',
					success : function(data) {

					},
					error : function(data) {
						console.log('Something went wrong');
					}
				});
			},
           	cancel_call : function(id,grp){
           		baseUrl = $.cometchat.getBaseUrl();
           		basedata = $.cometchat.getBaseData();
           		var controlparameters = {"grp":grp};
				jqcc.ccavchat.delinkAvchat(controlparameters);
            	$.ajax({
					url : baseUrl+'plugins/avchat/index.php?action=canceloutgoingcall',
					type : 'GET',
					data : {to: id,grp: grp,basedata:basedata},
					dataType : 'jsonp',
					success : function(data) {

					},
					error : function(data) {
						console.log('Something went wrong');
					}
				});
			},
			reject_call : function(id,grp){
				baseUrl = $.cometchat.getBaseUrl();
				basedata = $.cometchat.getBaseData();
				var controlparameters = {"grp":grp};
				jqcc.ccavchat.delinkAvchat(controlparameters);
            	jqcc.ajax({
					url : baseUrl+'plugins/avchat/index.php?action=rejectcall',
					type : 'GET',
					data : {to: id,grp: grp,basedata:basedata},
					dataType : 'jsonp',
					success : function(data) {

					},
					error : function(data) {
						console.log('Something went wrong');
					}
				});
			},
            end_call : function(params){
            	var id = params.to;
            	var grp = params.grp;
            	baseUrl = $.cometchat.getBaseUrl();
            	baseData = $.cometchat.getBaseData();
	            if((jqcc.cometchat.getInternalVariable('endcallOnceWindow_'+grp) !== '1' && jqcc.cometchat.getInternalVariable('endcallOnce_'+grp) !== '1')){
					var popoutopencalled = jqcc.cometchat.getInternalVariable('avchatpopoutcalled');
	            	var endcallrecieved = jqcc.cometchat.getInternalVariable('endcallrecievedfrom_'+grp);
	            	if(popoutopencalled !== '1'){
		            	if(endcallrecieved !== '1') {
		            		$.ajax({
								url : baseUrl+'plugins/avchat/index.php?action=endcall',
								type : 'GET',
								data : {to: id, basedata: baseData , grp: grp},
								dataType : 'jsonp',
								success : function(data) {

								},
								error : function(data) {
									console.log('Something went wrong');
								}
							});
		            	}
		            }
	            	jqcc.cometchat.setInternalVariable('endcallrecievedfrom_'+grp,'0');
	            	jqcc.cometchat.setInternalVariable('avchatpopoutcalled','0');
	            }
			},

		   	join: function (params) {
		   		var id = params.to;
				if(type == '0' || type == '3'){
					id = params.grp;
				}
		   		windowMode = 0;
		   		var caller = '';
				if(typeof(params.caller) != "undefined"){
					caller = params.caller;
				}
		   		if(typeof(params.windowMode) == "undefined") {
					windowMode = 0;
				} else {
					windowMode = 1;
				}
				if(location.protocol === 'http:' && type == '0') {
					windowMode = 1;
				}
				baseUrl = $.cometchat.getBaseUrl();
				basedata = $.cometchat.getBaseData();
				if(jqcc.cometchat.getThemeVariable('mobileDevice') == null){
					loadCCPopup(baseUrl+'plugins/avchat/index.php?action=call&chatroommode=1&caller='+caller+'&type=0&join=1&grp='+id+'&basedata='+basedata, 'audiovideochat',"status=0,toolbar=0,menubar=0,directories=0,resizable=1,location=0,status=0,scrollbars=0, width=<?php echo $camWidth;?>,height=<?php echo $camHeight;?>",<?php echo $camWidth;?>,<?php echo $camHeight;?>,'<?php echo $avchat_language[8];?>',1,1,allowresize,1,windowMode);
				} else{
					loadCCPopup(baseUrl+'plugins/avchat/index.php?action=call&chatroommode=1&caller='+caller+'&type=0&join=1&grp='+id+'&basedata='+basedata, 'audiovideochat',"status=0,toolbar=0,menubar=0,directories=0,resizable=1,location=0,status=0,scrollbars=0, width=<?php echo $camWidth;?>,height=<?php echo $camHeight;?>",<?php echo $camWidth;?>,<?php echo $camHeight;?>,'<?php echo $avchat_language[8];?>',1,1,allowresize,1,1);
				}
			},

			getLangVariables: function() {
				return <?php echo json_encode($avchat_language); ?>;
			},

			delinkAvchat: function(params){
				var grp = params.grp;
				$('a.avchat_link_'+grp).each(function(){
					$(this).attr('onclick','').unbind('click');
					$(this).removeClass('acceptAVChat accept_AVfid');
					this.style.setProperty( 'text-decoration', 'line-through', 'important' );
					$(this).css('cursor','text');
				});
			},

			processControlMessage : function(controlparameters) {
				var avchat_language = jqcc.ccavchat.getLangVariables();
				var processedmessage = null;

				<?php
					if($videoPluginType == 0) :
				?>
				jqcc.ccavchat.delinkAvchat(controlparameters.params);
	           	switch(controlparameters.method){
	                case 'endcall':
	                    jqcc.cometchat.setInternalVariable('endcallrecievedfrom_'+controlparameters.params.grp,'1');
	                    processedmessage = avchat_language[38];
	                    break;
	                case 'rejectcall':
	                    processedmessage = avchat_language[39];
	                    break;
	                case 'noanswer':
	                    processedmessage = avchat_language[40];
	                    break;
	                case 'busycall':
	                    processedmessage = avchat_language[39];
	                    break;
	                case 'canceloutgoingcall':
	                    processedmessage = avchat_language[37];
	                    break;

	                default :
                    	processedmessage = null;
                    break;
	            }
	            <?php
					endif;
				?>
				return processedmessage;
			}
        };
    })();

})(jqcc);

jqcc(document).ready(function(){
	jqcc('.join_Avchat').live('click',function(){
		var to = jqcc(this).attr('to');
		var grp = jqcc(this).attr('grp');
		var caller = jqcc(this).attr('caller');
		if(typeof(parent) != 'undefined' && parent != null && parent != self){
			var controlparameters = {"type":"plugins", "name":"ccavchat", "method":"join", "params":{"to":to, "caller":caller, "grp":grp}};
			controlparameters = JSON.stringify(controlparameters);
			if(typeof(parent) != 'undefined' && parent != null && parent != self){
				parent.postMessage('CC^CONTROL_'+controlparameters,'*');
			} else {
				window.opener.postMessage('CC^CONTROL_'+controlparameters,'*');
			}
		} else {
			var controlparameters = {"to":to, "grp":grp};
            jqcc.ccavchat.join(controlparameters);
		}
	});

	jqcc('.acceptAVChat').live('click',function(){
		var to = jqcc(this).attr('to');
		var grp = jqcc(this).attr('grp');
		var join_url = jqcc(this).attr('join_url');
		var start_url = jqcc(this).attr('start_url');
		var chatroommode = jqcc(this).attr('chatroommode');
		var caller = jqcc(this).attr('caller');
		if((typeof(parent) != 'undefined' && parent != null && parent != self) || window.top != window.self){
			var controlparameters = {"type":"plugins", "name":"ccavchat", "method":"accept", "params":{"to":to, "grp":grp, "join_url":join_url, "start_url":start_url, "caller":caller, "chatroommode":chatroommode}};
			controlparameters = JSON.stringify(controlparameters);
			parent.postMessage('CC^CONTROL_'+controlparameters,'*');
		} else {
			var controlparameters = {"to":to, "grp":grp, "join_url":join_url, "start_url":start_url, "chatroommode":chatroommode};
            jqcc.ccavchat.accept(controlparameters);
		}
	});

	jqcc('.accept_AVfid').live('click',function(){
		var to = jqcc(this).attr('to');
		var grp = jqcc(this).attr('grp');
		var start_url = jqcc(this).attr('start_url');
		var caller = jqcc(this).attr('caller');
		if((typeof(parent) != 'undefined' && parent != null && parent != self) || window.top != window.self){
			var controlparameters = {"type":"plugins", "name":"ccavchat", "method":"accept_fid", "params":{"to":to, "grp":grp, "start_url":start_url, "caller":caller}};
			controlparameters = JSON.stringify(controlparameters);
			parent.postMessage('CC^CONTROL_'+controlparameters,'*');
		} else {
			var controlparameters = {"to":to, "grp":grp, "start_url":start_url};
            jqcc.ccavchat.accept_fid(controlparameters);
		}
	});
});