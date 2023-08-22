<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validate.js"></script>
<script src="<?php echo Yii::app()->baseUrl; ?>/js/tinymce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">
	function initTiny(){
		$('input[type="text"],textarea').tinymce({
		// Location of TinyMCE script
			script_url : '<?php echo Yii::app()->baseUrl; ?>/js/tinymce/tiny_mce.js',
			// General options
			mode : "textareas",
			theme : "advanced",
			plugins : "youtubeIframe,openmanager,autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",

			// Theme options
			theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
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
		    theme_advanced_resizing_max_width: '700',
		    theme_advanced_resizing_min_height: '300',
		    width: '700',
		    height: '300',
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
	}

	// $('body').on('click', 'a.btn-success', function(event) {
	// 	event.preventDefault();
	// 	/* Act on the event */
	// 	initTiny();
	// });

</script>
<?php
$this->breadcrumbs=array(
	'จัดการชุดข้อสอบบทเรียนออนไลน์'=>array('//Grouptesting/Index'),
	'เพิ่มข้อสอบชุด'.$modelGroup->group_title,
);
?>
<script type="text/javascript">
$(function() {
	var scntDiv = $('#rowUp');
	var Int = 0;
	var IntNum = 1;
	var i = $('#p_scents p').size() + 1;
	Int = Int+1;
	IntNum = IntNum+1;
	$('#addScnt').live('click', function() {
		var questionBox = $('#countQuestionBox').val();
		var quesBox = parseInt(questionBox)+1;
		var title = '<p><div class="progress progress-inverse progress-mini"><div class="bar" style="width: 100%;"></div></div></p><div class="row"><label for="Question_ques_title" class="required">โจทย์ข้อสอบ <span class="required">*</span></label></div><div class="row"> <textarea class="required" name="Question[ques_title]['+Int+']" id="Question_ques_title_'+Int+'" rows="3" style="width:500px;" maxlength="255"></textarea><input type="hidden" name="QuestionType['+Int+']" id="QuestionType_'+Int+'" value="2"> <?php echo ClassFunction::CircleQuestionMark();?> <div class="row"><div class="span4"><div id="ErrorChoice'+Int+'"></div></div></div><div class="row"><div class="span4"><label for="Question_ques_title_'+Int+'" class="error errorMessage"><span class="label label-important">กรุณากรอกโจทย์ข้อนี้</span></label></div></div>';
		var btnAns = '<div class="row"><p><a class="btn btn-icon btn-success" onclick="addChoiceUp('+Int+');"><i class="icon-book"></i> เพิ่มคำตอบ</a> <a onclick="RemoveDiv('+i+',1);" class="btn btn-icon btn-inverse circle_ok" id="remScnt"><i class="icon-remove"></i> Remove</a></div></p><input id="countBox'+Int+'" name="countBox['+Int+']" type="hidden" value="4"> </div>'
		var type0 = '<input name="Choice[choice_type]['+Int+'][0]" id="choice_type'+Int+'0" type="hidden" value="radio">';
		var type1 = '<input name="Choice[choice_type]['+Int+'][1]" id="choice_type'+Int+'1" type="hidden" value="radio">';
		var exam = '<div class="row"><label for="Choice_choice_detail" class="required">คำตอบช้อยส์ <span class="required">*</span></label> <input name="Choice[choice_answer]['+Int+'][0]" onclick="ReSetClick('+Int+',0);" type="radio" value="1"> <input class="required span7" name="Choice[choice_detail]['+Int+'][0]" id="Choice_choice_detail_'+Int+'_0" type="text" maxlength="255">'+type0+' <?php echo ClassFunction::CircleQuestionMark();?></div><div class="row"><div class="span4"><label for="Choice_choice_detail_'+Int+'_0" class="error errorMessage"><span class="label label-important">กรุณากรอกคำตอบช้อยส์นี้</span></label></div></div>';
		exam+= '<div class="row"><input name="Choice[choice_answer]['+Int+'][1]" onclick="ReSetClick('+Int+',1);" type="radio" value="1"> <input class="required span7" name="Choice[choice_detail]['+Int+'][1]" id="Choice_choice_detail_'+Int+'_1" type="text" maxlength="255"> '+type1+' <?php echo ClassFunction::CircleQuestionMark();?></div><div class="row"><div class="span4"><label for="Choice_choice_detail_'+Int+'_1" class="error errorMessage"><span class="label label-important">กรุณากรอกคำตอบช้อยส์นี้</span></label></div></div>';
		var rowUpChoiceCheck = '<div id="rowUpChoice'+Int+'"></div>';
		var rowUp = $('<div id="d_'+i+'"> '+title+' '+ btnAns +' '+exam+' '+rowUpChoiceCheck+' </div>');
		$("#rowUp").append(rowUp);
		$('#countQuestion').val(i);
		$('#countQuestionBox').val(quesBox);
		$('#CountNumAll').html(quesBox);
		i++;
		Int++;
		IntNum++;
		initTiny();
		return false;
	});

	$('#addScntMulti').live('click', function() {
		var questionBox = $('#countQuestionBox').val();
		var quesBox = parseInt(questionBox)+1;
		var title = '<p><div class="progress progress-inverse progress-mini"><div class="bar" style="width: 100%;"></div></div></p><div class="row"><label for="Question_ques_title" class="required">โจทย์ข้อสอบ <span class="required">*</span></label></div><div class="row"> <textarea class="required" name="Question[ques_title]['+Int+']" id="Question_ques_title_'+Int+'" rows="3" style="width:500px;" maxlength="255"></textarea> <input type="hidden" name="QuestionType['+Int+']" id="QuestionType_'+Int+'" value="1"> <?php echo ClassFunction::CircleQuestionMark();?> <div class="row"><div class="span4"><div id="ErrorChoice'+Int+'"></div></div></div><div class="row"><div class="span4"><label for="Question_ques_title_'+Int+'" class="error errorMessage"><span class="label label-important">กรุณากรอกโจทย์ข้อนี้</span></label></div></div>';
		var btnAns = '<div class="row"><p><a class="btn btn-icon btn-success" onclick="addChoiceUpMulti('+Int+');"><i class="icon-book"></i> เพิ่มคำตอบ</a> <a onclick="RemoveDiv('+i+',1);" class="btn btn-icon btn-inverse circle_ok" id="remScnt"><i class="icon-remove"></i> Remove</a></div></p><input id="countBox'+Int+'" name="countBox['+Int+']" type="hidden" value="4"> </div>'
		var type0 = '<input name="Choice[choice_type]['+Int+'][0]" id="choice_type'+Int+'0" type="hidden" value="checkbox">';
		var type1 = '<input name="Choice[choice_type]['+Int+'][1]" id="choice_type'+Int+'1" type="hidden" value="checkbox">';
		var exam = '<div class="row"><label for="Choice_choice_detail" class="required">คำตอบช้อยส์ <span class="required">*</span></label> <input name="Choice[choice_answer]['+Int+'][0]" type="checkbox" value="1"> <input class="required span7" name="Choice[choice_detail]['+Int+'][0]" id="Choice_choice_detail_'+Int+'_0" type="text" maxlength="255">'+type0+' <?php echo ClassFunction::CircleQuestionMark();?></div><div class="row"><div class="span4"><label for="Choice_choice_detail_'+Int+'_0" class="error errorMessage"><span class="label label-important">กรุณากรอกคำตอบช้อยส์นี้</span></label></div></div>';
		exam+= '<div class="row"><input name="Choice[choice_answer]['+Int+'][1]" type="checkbox" value="1"> <input class="required span7" name="Choice[choice_detail]['+Int+'][1]" id="Choice_choice_detail_'+Int+'_1" type="text" maxlength="255">'+type1+' <?php echo ClassFunction::CircleQuestionMark();?></div><div class="row"><div class="span4"><label for="Choice_choice_detail_'+Int+'_1" class="error errorMessage"><span class="label label-important">กรุณากรอกคำตอบช้อยส์นี้</span></label></div></div>';
		var rowUpChoiceCheck = '<div id="rowUpChoice'+Int+'"></div>';
		var rowUp = $('<div id="d_'+i+'"> '+title+' '+ btnAns +' '+exam+' '+rowUpChoiceCheck+' </div>');
		$("#rowUp").append(rowUp);
		$('#countQuestion').val(i);
		$('#countQuestionBox').val(quesBox);
		$('#CountNumAll').html(quesBox);
		i++;
		Int++;
		IntNum++;
		initTiny();
		return false;
	});

	$('#addScntText').live('click', function() {
		var questionBox = $('#countQuestionBox').val();
		var quesBox = parseInt(questionBox)+1;
		var title = '<p><div class="progress progress-inverse progress-mini"><div class="bar" style="width: 100%;"></div></div></p><div class="row"><label for="Question_ques_title" class="required">โจทย์ข้อสอบ <span class="required">*</span></label></div><div class="row"> <textarea class="required" name="Question[ques_title]['+Int+']" id="Question_ques_title_'+Int+'" rows="3" style="width:500px;" maxlength="255"></textarea><input type="hidden" name="QuestionType['+Int+']" id="QuestionType_'+Int+'" value="3"> <?php echo ClassFunction::CircleQuestionMark();?> <div class="row"><div class="span4"><div id="ErrorChoice'+Int+'"></div></div></div><div class="row"><div class="span4"><label for="Question_ques_title_'+Int+'" class="error errorMessage"><span class="label label-important">กรุณากรอกโจทย์ข้อนี้</span></label></div></div>';
		var btnAns = '<div class="row"><p><a onclick="RemoveDiv('+i+',1);" class="btn btn-icon btn-inverse circle_ok" id="remScnt"><i class="icon-remove"></i> Remove</a></div></p><input id="countBox'+Int+'" name="countBox['+Int+']" type="hidden" value="4"> </div>'
		var type0 = '<input name="Choice[choice_type]['+Int+'][0]" id="choice_type'+Int+'0" type="hidden" value="text">';
		var exam = '<div class="row"><label for="Choice_choice_detail" class="required">คำตอบบรรยาย <span class="required">*</span></label> <input name="Choice[choice_answer]['+Int+'][0]" type="radio" checked="checked" style="display:none;" value="1"> <input class="required span7" name="Choice[choice_detail]['+Int+'][0]" id="Choice_choice_detail_'+Int+'_0" type="hidden" maxlength="255" value="text">'+type0+' <?php echo ClassFunction::CircleQuestionMark();?></div><div class="row"><div class="span4"><label for="Choice_choice_detail_'+Int+'_0" class="error errorMessage"><span class="label label-important">กรุณากรอกคำตอบช้อยส์นี้</span></label></div></div>';
		var rowUpChoiceCheck = '<div id="rowUpChoice'+Int+'"></div>';
		var rowUp = $('<div id="d_'+i+'"> '+title+' '+ btnAns +' '+exam+' '+rowUpChoiceCheck+' </div>');
		$("#rowUp").append(rowUp);
		$('#countQuestion').val(i);
		$('#countQuestionBox').val(quesBox);
		$('#CountNumAll').html(quesBox);
		i++;
		Int++;
		IntNum++;
		initTiny();
		return false;
	});


//	$("#Question").validate({
//		submitHandler: function (form) {
//			SubMitCheck();
//		}
//	});

	initTiny();

});
function SubMitCheck(){
	var count = $('#countQuestionBox').val();
	var countQ = $('#countQuestion').val();
	var countCheck = 0;
	for(i=0; i<=countQ; i++){
		$('#ErrorChoice'+i).hide();
		var countBox = $('#countBox'+i).val();
		if(countBox){
			var countInt = 0;
			for(z=0; z<countBox; z++){
				if($("[name='Choice[choice_answer]["+i+"]["+z+"]']:checked").is(':checked') == true){
					countInt = 1;
				}
            }
           if(countInt != 0){
           		$('#ErrorChoice'+i).hide();
           		countCheck++;
           }else{
				$('#Question_ques_title_'+i).focus();
				$('#ErrorChoice'+i).show().html('<div class="row"><div class="span4"><label><div class="error help-block"><span class="label label-important">กรุณาเลือก (ถูก) อย่างน้อย 1 ข้อ</span></div></label></div></div>');
           }
           if(countCheck == count){ Question.submit(); }
		}
	}
}
function RemoveDiv(id,num,CheckNum){
	var IntCheck;
	var CheckBox = $('#countQuestionBox').val();
	var DropSum = parseInt(CheckBox)-1;
	if(CheckNum == 1){ IntCheck = 0; }else{ IntCheck = ''; }
	if(num == '1'){ $('#d_'+id).remove(); $('#countQuestionBox').val(DropSum); $('#CountNumAll').html(DropSum); }
	if(num == '2'){
		var CheckOk = IntCheck+''+id;
		$('#choice_answer'+IntCheck+''+id).removeAttr('checked');
		$('#choice'+IntCheck+''+id).remove();
	}
}
var IntChoice = 1;
var IntChoiceBox = 2;
function addChoiceUp(num){
	var CheckNum;
	var countBox = $('#countBox'+num).val();
	countBox = parseInt(countBox)+1;
	var countBoxCheck = parseInt(countBox)-1;
	var countRemove = num+''+countBoxCheck;
	if(num == 0){ CheckNum = '1'; }else{ CheckNum = '2'; }
	var checkbox = '<input name="Choice[choice_answer]['+num+']['+countBoxCheck+']" id="choice_answer'+num+''+countBoxCheck+'" onclick="ReSetClick('+num+','+countBoxCheck+');" type="radio" value="1">';
	var type = '<input name="Choice[choice_type]['+num+']['+countBoxCheck+']" id="choice_type'+num+''+countBoxCheck+'" type="hidden" value="radio">';
	var input = '<input class="required span7" name="Choice[choice_detail]['+num+']['+countBoxCheck+']" id="Choice_choice_detail_'+num+'_'+countBoxCheck+'" type="text"  maxlength="255"> <?php echo ClassFunction::CircleQuestionMark();?>';
	var choice = '<div class="row"> '+checkbox+' '+input+' '+type+' <a onclick="RemoveDiv('+parseInt(countRemove)+',2,'+CheckNum+');" class="btn btn-icon btn-inverse circle_ok"><i class="icon-remove"></i> Remove</a></div> <div class="row"><div class="span4"><label for="Choice_choice_detail_'+num+'_'+countBoxCheck+'" class="error errorMessage"><span class="label label-important">กรุณากรอกคำตอบช้อยส์นี้</span></label></div></div>';
	var rowUpChoice = $('<div id="choice'+num+''+countBoxCheck+'"> '+choice+' </div>');
	$("#rowUpChoice"+num).append(rowUpChoice);
	IntChoice++;
	IntChoiceBox++;
	$('#countBox'+num).val(countBox);
	initTiny();
}
function addChoiceUpMulti(num){
	var CheckNum;
	var countBox = $('#countBox'+num).val();
	countBox = parseInt(countBox)+1;
	var countBoxCheck = parseInt(countBox)-1;
	var countRemove = num+''+countBoxCheck;
	if(num == 0){ CheckNum = '1'; }else{ CheckNum = '2'; }
	var checkbox = '<input name="Choice[choice_answer]['+num+']['+countBoxCheck+']" id="choice_answer'+num+''+countBoxCheck+'" type="checkbox" value="1">';
	var type = '<input name="Choice[choice_type]['+num+']['+countBoxCheck+']" id="choice_type'+num+''+countBoxCheck+'" type="hidden" value="checkbox">';
	var input = '<input class="required span7" name="Choice[choice_detail]['+num+']['+countBoxCheck+']" id="Choice_choice_detail_'+num+'_'+countBoxCheck+'" type="text"  maxlength="255"> <?php echo ClassFunction::CircleQuestionMark();?>';
	var choice = '<div class="row"> '+checkbox+' '+input+' '+type+' <a onclick="RemoveDiv('+parseInt(countRemove)+',2,'+CheckNum+');" class="btn btn-icon btn-inverse circle_ok"><i class="icon-remove"></i> Remove</a></div> <div class="row"><div class="span4"><label for="Choice_choice_detail_'+num+'_'+countBoxCheck+'" class="error errorMessage"><span class="label label-important">กรุณากรอกคำตอบช้อยส์นี้</span></label></div></div>';
	var rowUpChoice = $('<div id="choice'+num+''+countBoxCheck+'"> '+choice+' </div>');
	$("#rowUpChoice"+num).append(rowUpChoice);
	IntChoice++;
	IntChoiceBox++;
	$('#countBox'+num).val(countBox);
	initTiny();
}
function ReSetClick(num,id)
{
	var countBox = $('#countBox'+num).val();
	if(countBox){
		for(z=0; z<countBox; z++){
			$("[name='Choice[choice_answer]["+num+"]["+z+"]']").attr("checked",false);
        }
	}
	$("[name='Choice[choice_answer]["+num+"]["+id+"]']").attr("checked",true);
}
</script>
<style type="text/css">
.block { display: block; }
label.error { display: none; }
</style>

<!-- innerLR -->
<div class="innerLR">
	<div class="widget widget-tabs border-bottom-none">
		<div class="widget-head">
			<ul>
				<li class="active">
					<a class="glyphicons edit" href="#account-details" data-toggle="tab">
						<i></i>เพิ่มข้อสอบ
					</a>
				</li>
			</ul>
		</div>
		<div class="widget-body">
			<p class="note">ค่าที่มี <?php echo ClassFunction::CircleQuestionMark();?> จำเป็นต้องใส่ให้ครบ</p>
			<!-- FORM -->
			<div class="form">
				<?php echo CHtml::beginForm(Yii::app()->request->requestUri,'POST',array(
					'id'=>'Question',
					'name'=>'Question',
					'enableAjaxValidation'=>false,
				));?>
				<div class="row">
					<?php echo CHtml::activehiddenField($modelQues,'countQuestion',array(
					'type'=>'hidden',
					'id'=>'countQuestion',
					'name'=>'countQuestion',
					'value'=>'1'
					));
					echo CHtml::activehiddenField($modelQues,'countQuestionBox',array(
						'type'=>'hidden',
						'id'=>'countQuestionBox',
						'value'=>'0'
					)); ?>
				</div>
				<div class="row">
					<div class="pull-left">
					<?php
					echo CHtml::link('<i class="icon-book"></i> เพิ่มข้อสอบคำตอบเดียว', '', array(
						'class'=>'btn btn-icon btn-success',
						'id'=>'addScnt'
					));?>
					<?php
					echo CHtml::link('<i class="icon-book"></i> เพิ่มข้อสอบหลายคำตอบ', '', array(
						'class'=>'btn btn-icon btn-success',
						'id'=>'addScntMulti'
					));?>
					<?php
					echo CHtml::link('<i class="icon-book"></i> เพิ่มข้อสอบบรรยาย', '', array(
						'class'=>'btn btn-icon btn-success',
						'id'=>'addScntText'
					));?>
					</div>
					<div class="pull-left" style="margin:4px 15px;">
						<h4>จำนวนข้อที่สร้าง <span id="CountNumAll">1</span> ข้อ</h4>
					</div>
				</div>
				<br>
				<div id="rowUp">
					<!-- <div id="d_0">
						<div class="row">
							<?php echo CHtml::activelabelEx($modelQues,'ques_title'); ?>
							<?php echo CHtml::activeTextArea($modelQues,'ques_title[0]',array(
							'size'=>60,'maxlength'=>250,'style'=>'width:550px;','rows'=>'3','class'=>'required'
							)); ?>
							<?php echo ClassFunction::CircleQuestionMark();?>
						</div>
						<div class="row">
							<div class="span4">
								<label for="Question_ques_title_0" class="error errorMessage">
									<span class="label label-important">กรุณากรอกโจทย์ข้อนี้</span>
								</label>
							</div>
						</div>
						<div class="row"><div class="span4"><div id="ErrorChoice0"></div></div></div>
						<div class="row">
							<p><?php
							echo CHtml::link('<i class="icon-book"></i> เพิ่มคำตอบ', '', array(
								'onclick'=>'addChoiceUp("0");',
								'class'=>'btn btn-icon btn-success',
							));?></p>
							<?php
							echo CHtml::activehiddenField($modelQues,'countBox',array(
							'type'=>'hidden',
							'id'=>'countBox0',
							'name'=>'countBox[0]',
							'value'=>'2'
							)); ?>
						</div>
						<div class="row">
							<?php echo CHtml::activelabelEx($modelChoice,'choice_detail'); ?>
							<?php echo CHtml::activeRadioButton($modelChoice,'choice_answer[0][0]',array(
								'onclick' => 'ReSetClick("0","0");'
							));?>
							<?php echo CHtml::activeTextField($modelChoice,'choice_detail[0][0]',array(
							'maxlength'=>255,
							'class' =>'required span7',
							)); ?>
							<?php echo ClassFunction::CircleQuestionMark();?>
						</div>
						<div class="row">
							<div class="span4">
								<label for="Choice_choice_detail_0_0" class="error errorMessage">
									<span class="label label-important">กรุณากรอกคำตอบช้อยส์นี้</span>
								</label>
							</div>
						</div>
						<div class="row">
							<?php echo CHtml::activeRadioButton($modelChoice,'choice_answer[0][1]',array(
								'onclick' => 'ReSetClick("0","1");'
							));?>
							<?php echo CHtml::activeTextField($modelChoice,'choice_detail[0][1]',array(
							'maxlength'=>255,
							'class' =>'required span7',
							)); ?>
							<?php echo ClassFunction::CircleQuestionMark();?>
						</div>
						<div class="row">
							<div class="span4">
								<label for="Choice_choice_detail_0_1" class="error errorMessage">
									<span class="label label-important">กรุณากรอกคำตอบช้อยส์นี้</span>
								</label>
							</div>
						</div>
						<div id="rowUpChoice0"></div>
					</div> -->
				</div>
				<div class="row buttons">
				<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2','onclick'=>'tinyMCE.triggerSave();'),'<i></i>บันทึกข้อมูล');?>
				</div>
				<?php echo CHtml::endForm(); ?>
			</div>
			<!-- END form -->
		</div>
	</div>
</div>
<!-- END innerLR -->
