<?php


require_once Yii::app()->basePath . '/extensions/virtualclassroomapi/includes/bbb-api.php';
$titleName = 'Virtual Classroom';
$formNameModel = 'VRoom';

$this->breadcrumbs=array($titleName);
Yii::app()->clientScript->registerScript('search', "
	$('#SearchFormAjax').submit(function(){
	    $.fn.yiiGridView.update('$formNameModel-grid', {
	        data: $(this).serialize()
	    });
	    return false;
	});
");

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
	$.updateGridView = function(gridID, name, value) {
	    $("#"+gridID+" input[name*="+name+"], #"+gridID+" select[name*="+name+"]").val(value);
	    $.fn.yiiGridView.update(gridID, {data: $.param(
	        $("#"+gridID+" input, #"+gridID+" .filters select")
	    )});
	}
	$.appendFilter = function(name, varName) {
	    var val = eval("$."+varName);
	    $("#$formNameModel-grid").append('<input type="hidden" name="'+name+'" value="">');
	}
	$.appendFilter("VirtualClassroom[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>
<script src="<?php echo $this->assetsBase;; ?>/js/jquery.uploadifive.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/uploadifive.css">
<script type="text/javascript">
	function deletevdo(filedoc_id,file_id){
         $.get("<?php echo $this->createUrl('VirtualClassroom/deletevdo'); ?>",{id:file_id,vdo_id:filedoc_id},function(data){
            if(data){
            	var obj = JSON.parse(data);
            	if (obj['success'] === true) {
            		swal(obj['message']);
            		location.reload();
            	}else{
            		swal(obj['message']);
            	}
             }else{
                swal('ไม่สามารถลบไฟล์ได้');
             }
         });
    }
    function deleteFile(file_id){

         $.get("<?php echo $this->createUrl('VirtualClassroom/deletefile'); ?>",{id:file_id},function(data){console.log(data);
            if(data){
            	var obj = JSON.parse(data);
            	if (obj['success'] === true) {
            		swal(obj['message']);
            		location.reload();
            	}else{
            		swal(obj['message']);
            	}
             }else{
                swal('ไม่สามารถลบไฟล์ได้');
             }
         });
    }
</script>
<div class="innerLR">
	
	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>
		</div>
		<div class="widget-body">
			<div class="separator bottom form-inline small">
				<span class="pull-right">
					<label class="strong">แสดงแถว:</label>
					<?php echo $this->listPageShow($formNameModel);?>
				</span>	
			</div>
			<div class="clear-div"></div>
			<div class="overflow-table">
				<?php $this->widget('AGridView', array(
					'id'=>$formNameModel.'-grid',
					'dataProvider'=>$model->search(),
					'filter'=>$model,
					'selectableRows' => 2,
					'rowCssClassExpression'=>'"items[]_{$data->id}"',
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("VirtualClassroom[news_per_page]");
						InitialSortTable();	
				        jQuery("#course_date").datepicker({
						   	"dateFormat": "dd/mm/yy",
						   	"showAnim" : "slideDown",
					        "showOtherMonths": true,
					        "selectOtherMonths": true,
				            "yearRange" : "-5+10", 
					        "changeMonth": true,
					        "changeYear": true,
				            "dayNamesMin" : ["อา.","จ.","อ.","พ.","พฤ.","ศ.","ส."],
				            "monthNamesShort" : ["ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.",
				                "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค."],
					   })
					}',
					'columns'=>array(
						array(
							'visible'=>Controller::DeleteAll(
								array("VirtualClassroom.*", "VirtualClassroom.Delete", "VirtualClassroom.MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),
						array(
							'name'=>'name',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"name")',
							'htmlOptions' => array(
								'style' => 'width:150px',
							),
						),

						array(
							'header'=>'ผู้เข้าร่วม',
							'type'=>'html',
							'value'=>function ($data){
								
								$bbb = new BigBlueButton();
								// Get the URL to join meeting:
								$itsAllGood = true;
								
								$infoParams = array(
									'meetingId' => $data->id,		
									'password' => $data->moderatorPw,
									'moderatorCount' => 100		
								);
								try {$result = $bbb->getMeetingInfoWithXmlResponseArray($infoParams);}
									catch (Exception $e) {
										//echo 'Caught exception: ', $e->getMessage(), "\n";
										echo 'Error';
										$itsAllGood = false;
									}

									// var_dump($returncode[0]);
								if ($itsAllGood == true) {
									//Output results to see what we're getting:
									$returncode = (array)$result['returncode'];
									if($returncode[0] == 'FAILED'){
										return "0 คน";											
									}else if($returncode[0] == 'SUCCESS'){
										return $result['participantCount']." คน";
									}
								}

								//return $data->name;
							},
			                'htmlOptions' => array(
			                   'style' => 'width:60px',
			                ),  
						),
						array(
							'header'=>'เอกสาร',
							'type'=>'raw',
							'value'=>function ($data){
								$btnUpload = '
								<div id="queue'.$data->id.'" style="margin-buttom:7px;"></div>
								<input id="file_upload'.$data->id.'" name="file_upload" type="file" multiple="true">
								<script type="text/javascript">
						            $(function() {

						                $("#file_upload'.$data->id.'").uploadifive({
						                	"formData"         : {
												"room_id" : "'.$data->id.'",
						                	},
						                	"fileSizeLimit" : "2MB",
						                	"buttonText" : "เลือกเอกสาร (ไม่เกิน 2 MB)",
						                	"width":200,
						                	"fileType"     : ["application/pdf","image/jpeg","application/vnd.ms-powerpoint","application/msword"],
						                    "checkScript"      : "'.Yii::app()->createUrl("VirtualClassroom/checkExists").'",
						                    "queueID"          : "queue'.$data->id.'",
						                    "uploadScript"     : "'.Yii::app()->createUrl("VirtualClassroom/uploadifive").'",
						                    "onQueueComplete" : function(data) {
						                    	if(data){
						                    		location.reload();
						                    	}
						                    	},
						                });
						            });
					        	</script>
								';

								$docList = '<br>';
								if(count($data->docs) > 0){
									foreach ($data->docs as $key => $doc) {
										if ($doc->active === "y") {
											$docList .= "<a target='_blank' href='".Yii::app()->getUploadUrl('vc').$doc->name."'>".($key+1).". ".$doc->name."</a>&nbsp;";
											$docList .= CHtml::link('<i></i>','', array('title'=>'ลบไฟล์','class'=>'btn-action fa fa-times btn-danger remove_2','style'=>'z-index:1; background-color:black; cursor:pointer;','onclick'=>'if(confirm("คุณต้องการลบไฟล์ใช่หรือไม่ ?\nเมื่อคุณตกลงระบบจะทำการลบไฟล์ออกจากระบบแบบถาวร")){ deleteFile("'.$doc->id.'"); }'));
											$docList .= "<br>";
										}
									}
								}

								return $btnUpload.$docList;
							}
						),
						array(
							'header'=>'ดูบันทึก',
							'type'=>'raw',
							'value'=>function ($data){
								$bbb = new BigBlueButton();

								$recordingsParams = array(
									'meetingId' => $data->id, 			// OPTIONAL - comma separate if multiples
								);
								
								// Get the URL to join meeting:
								$itsAllGood = true;
								try {$result = $bbb->getRecordingsWithXmlResponseArray($recordingsParams);}
								catch (Exception $e) {
									echo 'Caught exception: ', $e->getMessage(), "\n";
									$itsAllGood = false;
								}

								if ($itsAllGood == true) { 
									// If it's all good, then we've interfaced with our BBB php api OK:
									if ($result == null) {
										// If we get a null response, then we're not getting any XML back from BBB.
										echo "Failed to get any response. Maybe we can't contact the BBB server.";
									}	
									else { 
									// We got an XML response, so let's see what it says:
										if ($result['returncode'] == 'SUCCESS') {
											// Then do stuff ...
											unset($result['returncode']);
											unset($result['messageKey']);
											unset($result['message']);
											foreach ($result as $key => $record) {
														echo "<a href='".$record['playbackFormatUrl'][0]."' target='_blank'>".($key+1).". วีดีโอ</a>&nbsp;";
														echo CHtml::link('<i></i>','', array('title'=>'ลบไฟล์','class'=>'btn-action fa fa-times btn-danger remove_2','style'=>'z-index:1; background-color:black; cursor:pointer;','onclick'=>'if(confirm("คุณต้องการลบไฟล์ใช่หรือไม่ ?\nเมื่อคุณตกลงระบบจะทำการลบไฟล์ออกจากระบบแบบถาวร")){ deletevdo("'.$record['recordId'][0].'","'.$data->id.'"); }'));
														echo "<br>";
											}
											//echo "<p>Meeting info was found on the server.</p>";
										}
										else {
											echo "<p>Failed to get meeting info.</p>";
										}
									}
								}	
							}
						),
						// array(
						// 	'header'=>'ดาวน์โหลด',
						// 	'type'=>'raw',
						// 	'value'=>function ($data){
						// 		$bbb = new BigBlueButton();

						// 		$recordingsParams = array(
						// 			'recordId' => 'a2e33d344f272e100d4a8efeabc7ae8a60a8ba7a-1606211097089', 			
						// 			//'publish' => 'true',
						// 		);

						// 		$itsAllGood = true;
						// 		try {$result = $bbb->getRecordingTextTracksWithXmlResponseArray($recordingsParams);}
						// 		catch (Exception $e) {
						// 			echo 'Caught exception: ', $e->getMessage(), "\n";
						// 			$itsAllGood = false;
						// 		}

						// 		if ($itsAllGood == true) { 
						// 			// If it's all good, then we've interfaced with our BBB php api OK:
						// 			if ($result == null) {
						// 				// If we get a null response, then we're not getting any XML back from BBB.
						// 				echo "Failed to get any response. Maybe we can't contact the BBB server.";
						// 			}	
						// 			else { 
						// 			// We got an XML response, so let's see what it says:
						// 	//var_dump($result);
						// 				if ($result['returncode'] == 'SUCCESS') {
				
						// 					foreach ($result as $key => $record) {
                                  	
						// 						//header('Content-Disposition: attachment; filename="'.$record['playbackFormatUrl'][0].'.mp4"');

						// 						// echo "<a href='".$record['published'][0]."' target='_blank'>".($key+1).". วีดีโอ</a>";
						// 						// echo "<br>";
						// 						// echo "<a href='".$record['playbackFormatUrl'][0]."' target='_blank'>".($key+1).". วีดีโอ</a>";
						// 						// echo "<br>";
						// 					} 
						// 					//echo "<p>Meeting info was found on the server.</p>";
						// 				}
						// 				else {
						// 					echo "<p>Failed to get meeting info.</p>";
						// 				}
						// 			}
						// 		}	
						// 	}
						// ),
					   array(
							'header'=>'รหัสในการเข้าห้องเรียน',
							'type'=>'raw',
							'value'=>'$data->show_key'
						),
						array(
							'header'=>'จัดการ',
							'type'=>'raw',
							'value'=>function ($data){
								
								$bbb = new BigBlueButton();
								
								// Get the URL to join meeting:
								$itsAllGood = true;
								
								$infoParams = array(
									'meetingId' => $data->id,		
									'password' => $data->moderatorPw		
								);

								try {$result = $bbb->getMeetingInfoWithXmlResponseArray($infoParams);}
									catch (Exception $e) {
										//echo 'Caught exception: ', $e->getMessage(), "\n";
										echo 'Error';
										$itsAllGood = false;
									}

								if ($itsAllGood == true) {
									//Output results to see what we're getting:
									$returncode = (array)$result['returncode'];
									if($returncode[0] == 'FAILED'){
										$btnCreate = CHtml::link("เปิดห้องเรียน", array(
								      		"VirtualClassroom/createRoom",
								      		"id"=>$data->id
								      		), array(
											"class"=>"btn btn-primary btn-icon"
									    ));
										return $btnCreate;											
									}else if($returncode[0] == 'SUCCESS'){

										$userObject = Yii::app()->getModule('user')->user();
										$joinParams = array(
											'meetingId' => $data->id, 				// REQUIRED - We have to know which meeting to join.
											'username' => $userObject->username,		// REQUIRED - The user display name that will show in the BBB meeting.
											'password' => $data->moderatorPw,					// REQUIRED - Must match either attendee or moderator pass for meeting.
											// 'createTime' => '',					// OPTIONAL - string
											'userId' => $userObject->id,						// OPTIONAL - string
											// 'webVoiceConf' => ''				// OPTIONAL - string
										);
										// Get the URL to join meeting:
										$itsAllGood = true;
										try {$result = $bbb->getJoinMeetingURL($joinParams);}
											catch (Exception $e) {
												echo 'Caught exception: ', $e->getMessage(), "\n";
												$itsAllGood = false;
											}

										if ($itsAllGood == true) {
											//Output results to see what we're getting:
											$btnJoin = CHtml::link("เข้าสอน", $result, array(
												"class"=>"btn btn-primary btn-icon",
												"target"=>"_blank"
										    ));

										    $btnEnd = CHtml::link("ปิดห้องเรียน", array(
									      		"VirtualClassroom/endRoom",
									      		"id"=>$data->id
									      		), array(
												"class"=>"btn btn-primary btn-icon"
										    ));

										    return $btnJoin." ".$btnEnd;
										    
										}

									}
								}

								//return $data->name;
							},
			                'htmlOptions' => array(
			                   'style' => '',
			                ),  
						),
					
						array(            
							'class'=>'AButtonColumn',
							'visible'=>Controller::PButton( 
								array("VirtualClassroom.*", "VirtualClassroom.View", "VirtualClassroom.Update", "VirtualClassroom.Delete") 
							),
							'template'=>'{update}{delete}',
							'buttons' => array(
								// 'view'=> array( 
								// 	'visible'=>'Controller::PButton( array("VirtualClassroom.*", "VirtualClassroom.View") )' 
								// ),
								'update'=> array( 
									'visible'=>'Controller::PButton( array("VirtualClassroom.*", "VirtualClassroom.Update") )' 
								),
								'delete'=> array( 
									'visible'=>'Controller::PButton( array("VirtualClassroom.*", "VirtualClassroom.Delete") )' 
								),
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>

	<?php if( Controller::DeleteAll(array("VirtualClassroom.*", "VirtualClassroom.Delete", "VirtualClassroom.MultiDelete")) ) : ?>
		<!-- Options -->
		<div class="separator top form-inline small">
			<!-- With selected actions -->
			<div class="buttons pull-left">
				<?php echo CHtml::link("<i></i> ลบข้อมูลทั้งหมด","#",array(
					"class"=>"btn btn-primary btn-icon glyphicons circle_minus",
					"onclick"=>"return multipleDeleteNews('".$this->createUrl('//'.$formNameModel.'/MultiDelete')."','$formNameModel-grid');"
				)); ?>
			</div>
			<!-- // With selected actions END -->
			<div class="clearfix"></div>
		</div>
		<!-- // Options END -->
	<?php endif; ?>

</div>
