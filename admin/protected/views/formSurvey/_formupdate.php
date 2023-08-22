<script src="<?php echo Yii::app()->baseUrl; ?>/js/tinymce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
	$('textarea.tinymce').tinymce({
	// Location of TinyMCE script
		script_url : '<?php echo Yii::app()->baseUrl; ?>/js/tinymce/tiny_mce.js',
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "youtubeIframe,openmanager,autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,youtubeIframe,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		relative_urls: false,

		//FILE UPLOAD MODS
		file_browser_callback: "openmanager",
		open_manager_upload_path: '../../../../../uploads/',

		// Example content CSS (should be your site CSS)
		//content_css : "<?php echo Yii::app()->baseUrl; ?>/css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

	    theme_advanced_resizing : false,
	    theme_advanced_resize_horizontal: false,
	    theme_advanced_resizing_max_width: '500',
	    theme_advanced_resizing_min_height: '500',
	    width: '500',
	    height: '500',	

		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
});
 $(function() {
    $( "#datepickerStart" ).datepicker();
  });
 $(function() {
    $( "#datepickerEnd" ).datepicker();
  });
</script>

<!-- innerLR -->
<div class="innerLR">
	<div class="widget widget-tabs border-bottom-none">
		<div class="widget-head">
			<ul>
				<li class="active">
					<a class="glyphicons edit" href="#account-details" data-toggle="tab">
						<i></i><?php echo $formtext;?>
					</a>
				</li>
			</ul>
		</div>

		<div class="widget-body">
			<div class="form">
				<?php $form = $this->beginWidget('AActiveForm', array(
					'id'=>'form-survey-form',
			        'enableClientValidation'=>true,
			        'clientOptions'=>array(
			            'validateOnSubmit'=>true
			        ),
			         'errorMessageCssClass' => 'label label-important',
			        'htmlOptions' => array('enctype' => 'multipart/form-data')
				)); ?>
				<p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>
					<div class="row">
						<?php echo $form->labelEx($model,'fs_head'); ?>
						<?php echo $form->textField($model,'fs_head',array('size'=>60,'maxlength'=>250, 'class'=>'span8')); ?>
						<?php echo $form->error($model,'fs_head'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'fs_type'); ?>
						<?php echo $form->dropdownlist($model,'fs_type',array('all'=>'ทั้งหมด','university'=>'นักศึกษา','company'=>'ผู้ประกอบวิชาชีพ')); ?>
						<?php echo $form->error($model,'fs_type'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'startdate'); ?>
						<?php echo $form->textField($model,'startdate',array('id'=>'datepickerStart')); ?>
						<?php echo $form->error($model,'startdate'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'enddate'); ?>
						<?php echo $form->textField($model,'enddate',array('id'=>'datepickerEnd')); ?>
						<?php echo $form->error($model,'enddate'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'fs_title'); ?>
						<?php echo $form->textarea($model,'fs_title',array('rows'=>10, 'cols'=>50, 'class'=>'span5 tinymce')); ?>
						<?php echo $form->error($model,'fs_title'); ?>
					</div>

					<div class="row">
						<div class="widget widget-tabs border-bottom-none">
								            <div class="widget-head">
								                <ul>
								                    <li class="active">
								                        <a class="glyphicons edit" data-toggle="tab">
								                            <i></i>คำถาม
								                        </a>
								                    </li>
								                </ul>
								            </div>
								       <!--  <div id='dataichange'></div> -->
					<?php $datai='1' ?>
					<?php foreach ($model->FormSurveyHeader as $key => $value) { ?>
					<?php if($value->fsh_title=="0"){

									addQuest(1);

						}
						else
						{
						 ?>
						
						<div class='widget-body' id='answerchoice-<?php echo $datai ?>'>
						 
							<div class='widget-head'>
								<ul><li class='active'><a class='glyphicons edit' data-toggle='tab' style='width:50px'><i></i>ข้อที่ <?php echo $datai; ?></a></li>
								<li class='active'><a href='javascript:void(0)' onclick='deleteQuest(<?php echo $datai; ?>,<?php echo $value->fsh_id ?>)' class='btn btn-primary'>ลบคำถาม</a></li>
								</ul>
							</div>

							<div class='widget-body'>
									<div class='row'>
										<label for='ansAdd-'>หัวข้อที่ถาม</label>
										<input type="hidden" name="fsh_id[]" value="<?php echo $value->fsh_id ?>">
										<input size='60' maxlength='250' class='span8' name='fsh_title[]' id='ansAdd-<?php echo $datai; ?>' type='text' value="<?php echo $value->fsh_title; ?>">
									</div>
									<div class='row'>
										<label for='selectChoichType-<?php echo $datai; ?>'>เลือกวิธีการตอบ</label>
										<select name='selectChoichType-<?php echo $datai; ?>' id='selectChoichType-<?php echo $datai; ?>' onChange='selectChangeType(<?php echo $datai; ?>)'>
										<option value=>-- กรุณาเลือก --</option>
										<option value='checkbox' <?php echo $value->fsh_type == "checkbox" ? "selected" : ""; ?>>คำตอบแบบเลือกได้หลายคำตอบ (Checkbox)</option>
										<option value='radio' <?php echo $value->fsh_type == "radio" ? "selected" : ""; ?> >คำตอบแบบเลือกคำตอบเดียว (radio)</option>
										<option value='tablescore' <?php echo $value->fsh_type == "tablescore" ? "selected" : ""; ?> >คำตอบแบบคะแนนความพึงพอใจ</option>
										<option value='textField' <?php echo $value->fsh_type == "textField" ? "selected" : ""; ?> >คำตอบแบบบรรทัดเดียว</option>
										<option value='textArea' <?php echo $value->fsh_type == "textArea" ? "selected" : ""; ?> >คำตอบแบบหลายบรรทัด</option>
										</select>
									</div>
									<div class='row'>
										<div id="selectChangeShow-<?php echo $datai; ?>">
												
									<?php 
										if($value->fsh_type=='radio' || $value->fsh_type=='checkbox' || $value->fsh_type=='tablescore'){
											?>
											<div id='choicelist-<?php echo $datai; ?>'>
												<a href='javascript:void(0)' id='addChoice' onclick='addChoice(<?php echo $datai; ?>)' class='btn btn-primary'>เพิ่มคำตอบ</a>
												</div>
												<br/>
											<?php
											$ii=1;
											foreach ($value->FormSurveyList as $key => $valuelist) {
												
											?>
											
												<div id="choicelistdataDiv<?php echo $datai ?>-<?php echo $ii ?>">
												<label for="choicelistdata<?php echo $datai ?>-<?php echo $ii ?>">
												
												<input type="text" id="choicelistdata<?php echo $datai ?>-<?php echo $ii ?>" size="20" name="choicelistdata-<?php echo $datai ?>[]" value="<?php echo $valuelist->fsl_value ?>" />
												 <a href="javascript:void(0)" id="remScnt" class="btn btn-primary" onclick="deleteChoice('<?php echo $datai ?>','<?php echo $ii ?>')">ลบคำตอบ</a>
												 </label>
												 </div>
												
											<?php
											$ii++;
												}
												?>
												 <input type="hidden" id='valuehidden-<?php echo $datai ?>' name="valuehiddendata" value="<?php echo $ii; ?>">
												<?php
											}

									?>
										
										</div>
										
									</div>

							</div>
						</div>
					<?php $datai++; ?>
					<?php } } ?>	

								        <div id='questAdd'></div>
										<div id='linkaddanswer'></div>
										<div id='hidediv'><a href='javascript:void(0)' onclick='addQuest(<?php echo $datai ?>)' class='btn btn-primary'>เพิ่มคำถาม</a>
										</div>
								

					
					</div>

					<div class="row buttons">
						<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
					</div>
				<?php $this->endWidget(); ?>
			</div><!-- form -->
		</div>

	</div>
</div>
<!-- END innerLR -->
<script type="text/javascript">

function addQuest(datai){
	var dataihtml=1;
	
	var addhtmlAns='';
	addhtmlAns +="<div class='widget-body' id='answerchoice-"+datai+"'>";
		addhtmlAns +="<div class='widget-head'>";
			addhtmlAns +="<ul><li class='active'><a class='glyphicons edit' data-toggle='tab' style='width:50px'><i></i>ข้อที่"+ datai +"</a></li>";
			addhtmlAns +="<li class='active'><a href='javascript:void(0)' onclick='deleteQuest("+datai+")' class='btn btn-primary'>ลบคำถาม</a></li>";
			addhtmlAns +="</ul>";
		addhtmlAns +="</div>";

		addhtmlAns +="<div class='widget-body'>";
				addhtmlAns +="<div class='row'>";
					addhtmlAns +="<label for='ansAdd-"+datai+"'>หัวข้อที่ถาม</label>";
					addhtmlAns +="<input size='60' maxlength='250' class='span8' name='fsh_title[]'' id='ansAdd-"+datai+"' type='text'>";
				addhtmlAns +="</div>";

				addhtmlAns +="<div class='row'>";
					addhtmlAns +="<label for='selectChoichType-"+datai+"'>เลือกวิธีการตอบ</label>";
					addhtmlAns +="<select name='selectChoichType-"+datai+"' id='selectChoichType-"+datai+"' onChange='selectChangeType("+datai+")'>";
					addhtmlAns +="<option value=>-- กรุณาเลือก --</option>";
					addhtmlAns +="<option value='checkbox'>คำตอบแบบเลือกได้หลายคำตอบ (Checkbox)</option>";
					addhtmlAns +="<option value='radio'>คำตอบแบบเลือกคำตอบเดียว (radio)</option>";
					addhtmlAns +="<option value='tablescore'>คำตอบแบบคะแนนความพึงพอใจ</option>";
					addhtmlAns +="<option value='textField'>คำตอบแบบบรรทัดเดียว</option>";
					addhtmlAns +="<option value='textArea'>คำตอบแบบหลายบรรทัด</option>";
					addhtmlAns +="</select>";
				addhtmlAns +="</div>";

				addhtmlAns +="<div class='row'>";
					addhtmlAns +="<div id='selectChangeShow-"+datai+"'></div>";
				addhtmlAns +="</div>";

		addhtmlAns +="</div>";
	addhtmlAns +="</div>";
	
	var datasum=datai+1;	
	answer ="<a href='javascript:void(0)' onclick='addQuest("+datasum+")' class='btn btn-primary'>เพิ่มคำถาม</a>";
	answer +="<input type='hidden' name='valuehiddenall' value='"+datai+"'> ";
	// $('#dataichange').html(dataihtml);
	$('#questAdd').append(addhtmlAns);
	$('#linkaddanswer').html(answer);		
	$('#hidediv').hide();		            


}
	
$(function(){
	//addQuest(1);
});


function selectChangeType(idchange){
		var datachange=$('#selectChoichType-'+idchange+'').val();
		if(datachange=='radio' || datachange=='checkbox' || datachange=='tablescore'){
		checkboxlist(idchange);
		}
		else
		{
			$("#selectChangeShow-"+idchange+"").html('');
		}

}

function checkboxlist(idchange){
		 var checkboxadd='';
		checkboxadd +="<div class='widget-body' id='choicelist-"+idchange+"'>";
		checkboxadd +="<a href='javascript:void(0)' id='addChoice' onclick='addChoice2("+idchange+",1)' class='btn btn-primary'>เพิ่มคำตอบ</a>";
		checkboxadd +="</div>";
		$("#selectChangeShow-"+idchange+"").html(checkboxadd);
}
function addChoice(idlistbox){

        var addscanDiv = $("#choicelist-"+idlistbox+" ");
        var i = $("#valuehidden-"+idlistbox+" ").val();
        var ii=parseInt(i)+1;
        //alert(i);

                $('<p><div id="choicelistdataDiv'+idlistbox+'-'+i+'"><label for="choicelistdata'+idlistbox+'-'+i+'"><input type="text" id="choicelistdata'+idlistbox+'-'+i+'" size="20" name="choicelistdata-' + idlistbox +'[]" value="" /> <a href="javascript:void(0)" id="remScnt" class="btn btn-primary" onclick="deleteChoice('+idlistbox+','+i+')">ลบคำตอบ</a></label></div></p>').appendTo(addscanDiv);
                //i++;
                $("#valuehidden-"+idlistbox+" ").val(ii);
                return false;
        
}
function addChoice2(idlistbox){

        var addscanDiv = $("#choicelist-"+idlistbox+" ");
        var i = $("#choicelist-"+idlistbox+" p").size() + 1;

                $('<p><div id="choicelistdataDiv'+idlistbox+'-'+i+'"><label for="choicelistdata'+idlistbox+'-'+i+'"><input type="text" id="choicelistdata'+idlistbox+'-'+i+'" size="20" name="choicelistdata-' + idlistbox +'[]" value="" /> <a href="javascript:void(0)" id="remScnt" class="btn btn-primary" onclick="deleteChoice('+idlistbox+','+i+')">ลบคำตอบ</a></label></p>').appendTo(addscanDiv);
                i++;
                return false;
        
}
function deleteChoice(idlistbox,i){
	$("#choicelistdataDiv"+idlistbox+"-"+i+"").remove();
}

function deleteQuest(idquest,idheader){
	if(idquest>1){
	$("#answerchoice-"+idquest+" ").remove();
	}
}

</script>


