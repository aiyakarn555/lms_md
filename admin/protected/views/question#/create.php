<style>
	input[type="radio"] { /* Change width and height */
		width:3em;
		height:3em;
	}
	input[type="checkbox"] { /* Change width and height */
		width:3em;
		height:3em;
	}
	hr.soften {
		height: 1px;
		background-image: -webkit-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,.8), rgba(0,0,0,0));
		background-image:    -moz-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,.8), rgba(0,0,0,0));
		background-image:     -ms-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,.8), rgba(0,0,0,0));
		background-image:      -o-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,.8), rgba(0,0,0,0));
		border: 0;
	}
</style>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validate.js"></script>
<script src="<?php echo Yii::app()->baseUrl; ?>/js/tinymce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">

	$('input[type="text"],textarea').tinymce({
		// Location of TinyMCE script
		script_url : '<?php echo Yii::app()->baseUrl; ?>/js/tinymce/tiny_mce.js',
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "youtubeIframe,openmanager,autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",

		// Theme options
		theme_advanced_buttons1 : "image",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "right",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		relative_urls: false,

		//FILE UPLOAD MODS
		file_browser_callback: "openmanager",
		open_manager_upload_path: '../../../../../uploads/',


		theme_advanced_resizing : false,
		theme_advanced_resize_horizontal: false,
		theme_advanced_resizing_max_width: '700',
		theme_advanced_resizing_min_height: '100',
		width: '700',
		height: '100',

	});

</script>
<?php
$this->breadcrumbs=array(
	'จัดการชุดข้อสอบบทเรียนออนไลน์'=>array('//Grouptesting/Index'),
	'เพิ่มข้อสอบชุด'.$modelGroup->group_title,
);
?>
<script type="text/javascript">

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
			<!-- FORM -->
			<div class="form">
				<?php echo CHtml::beginForm(Yii::app()->request->requestUri,'POST',array(
					'id'=>'Question',
					'name'=>'Question',
					'enableAjaxValidation'=>false,
				));?>
				<div class="row">
					<div class="pull-left">
					<?php
					echo CHtml::link('<i class="icon-book"></i> เพิ่มข้อสอบคำตอบเดียว', '', array(
						'class'=>'btn btn-icon btn-success',
						'id'=>'add-radio-question'
					));?>
					<?php
					echo CHtml::link('<i class="icon-book"></i> เพิ่มข้อสอบหลายคำตอบ', '', array(
						'class'=>'btn btn-icon btn-success',
						'id'=>'add-checkbox-question'
					));?>
					<?php
					echo CHtml::link('<i class="icon-book"></i> เพิ่มข้อสอบบรรยาย', '', array(
						'class'=>'btn btn-icon btn-success',
						'id'=>'add-textarea-question'
					));?>
					</div>
					<div class="pull-left" style="margin:4px 15px;">
						<h4>จำนวนข้อที่สร้าง <span id="CountNumAll">0</span> ข้อ</h4>
					</div>
				</div>
				<br>
				<div id="question-list">
				</div>
				<div class="row buttons" style="padding-top: 26px;">
					<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2','onclick'=>'tinyMCE.triggerSave();'),'<i></i>บันทึกข้อมูล');?>
				</div>
				<?php echo CHtml::endForm(); ?>
			</div>
			<!-- END form -->
		</div>
	</div>
</div>
<script type="text/javascript">

	function initTinyChoice(question_id,id){
		tinymce.EditorManager.execCommand('mceAddEditor', true, "choice-"+question_id+"-"+id+"-tilte-input");
	}

	function initTinyQuestion(id){
		tinymce.EditorManager.execCommand('mceAddEditor', true, "question-"+id+"-title");
		tinymce.EditorManager.execCommand('mceAddEditor', true, "choice-"+id+"-0-tilte-input");
		tinymce.EditorManager.execCommand('mceAddEditor', true, "choice-"+id+"-1-tilte-input");
		tinymce.EditorManager.execCommand('mceAddEditor', true, "choice-"+id+"-2-tilte-input");
		tinymce.EditorManager.execCommand('mceAddEditor', true, "choice-"+id+"-3-tilte-input");
	}

	function initTinyQuestionTextarea(id){
		tinymce.EditorManager.execCommand('mceAddEditor', true, "question-"+id+"-title");
	}

	$(function(){
		$('#question-list').on('click','.choice-remove',function(){
			if(confirm('คุณต้องการลบข้อมูล?')) {
				var em_index = $(this).index('.choice-remove');
				$('.choice').eq(em_index).remove();
			}
		});

		$('#question-list').on('click','.question-remove',function(){
			if(confirm('คุณต้องการลบข้อมูล?')) {
				var em_index = $(this).index('.question-remove');
				$('.question-group').eq(em_index).remove();
				var em_question_total = $('#question-list').children('.question-group');
				var question_total = 0;
				if(em_question_total.length){
					question_total = parseInt(em_question_total.length);
				}
				$('#CountNumAll').text(question_total);
			}
		});

		$('#question-list').on('click','.add-chocie',function(){
			var em_index = $(this).index('.add-chocie');
			var question_id = $(this).attr('data-question-id');
			var value_index_choice = $('.choice-list').eq(em_index).children().last().find('.choice-'+question_id+'-input')

			var type = $('.question-group').eq(em_index).find("input[name^='Question_type']");
			if(type.length){
				type = type.val();
			}else{
				type = 'text';
			}

			var new_index = 0;
			if(value_index_choice.length){
				new_index = parseInt(value_index_choice.val())+1;
			}

			var choice = "";
			choice += '<div class="row choice" style="margin-top:20px;">';
			choice += '<div class="span1">';
			choice += '<input type="'+type+'" name="Choice['+question_id+'][]" class="choice-'+question_id+'-input pull-right" value="'+new_index+'">';
			choice += '</div>';
			choice += '<div class="span8">';
			choice += '<textarea name="ChoiceTitle['+question_id+']['+new_index+']" class="choice-tilte-input" id="choice-'+question_id+'-'+new_index+'-tilte-input" cols="30" rows="10"></textarea>';
			choice += '<a class="btn btn-icon btn-danger circle_ok choice-remove"><i class="icon-remove"></i> ลบตัวเลือก</a>';
			choice += '</div>';
			choice += '</div>';

			$('.choice-list').eq(em_index).append(choice);
			initTinyChoice(question_id,new_index);

		});

		$('.form').on('click','#add-radio-question',function(){
			var value_index_question = $('#question-list').children('.question-group').last();
			var em_question_total = $('#question-list').children('.question-group');
			var question_index = 0;
			var question_total = 0;
			if(value_index_question.length){
				question_index = parseInt(value_index_question.attr('data-index'))+1;
			}
			if(em_question_total.length){
				question_total = parseInt(em_question_total.length);
			}
			question_total += 1;
			$('#CountNumAll').text(question_total);
			var question_radio = "";

			question_radio += '<div class="question-group" data-index="'+question_index+'">';
			question_radio += '<hr class="soften" />';
			question_radio += '<div class="row question">';
			question_radio += '<label><h3>โจทย์ (คำตอบเดียว) <input type="hidden" name="Question_type['+question_index+']" value="radio"> <!--ข้อที่ <span class="question-numbers" style="color:green; font-size: 20px;">'+question_total+'</span>--> ';
			question_radio += '<a class="btn btn-icon btn-danger circle_ok question-remove"><i class="icon-remove"></i> ลบโจทย์</a></h3>';
			question_radio += '</label>';
			question_radio += '<div class="span12">';
			question_radio += '<textarea name="Question['+question_index+']" class="question-title" id="question-'+question_index+'-title" cols="30" rows="10"></textarea>';
			question_radio += '</div>';
			question_radio += '</div>';
			question_radio += '<div class="row choice-list" style="margin-top:20px;">';
			question_radio += '<label><h3>ตัวเลือก <a class="btn btn-icon btn-success add-chocie" data-question-id="'+question_index+'"><i class="icon-book"></i> เพิ่มตัวเลือก</a></h3></label>';
			question_radio += '<div class="row choice" style="margin-top:20px;">';
			question_radio += '<div class="span1">';
			question_radio += '<input type="radio" name="Choice['+question_index+'][]" class="choice-'+question_index+'-input pull-right" value="0">';
			question_radio += '</div>';
			question_radio += '<div class="span8">';
			question_radio += '<textarea name="ChoiceTitle['+question_index+'][0]" class="choice-tilte-input" id="choice-'+question_index+'-0-tilte-input" cols="30" rows="10"></textarea>';
			question_radio += '<a class="btn btn-icon btn-danger circle_ok choice-remove"><i class="icon-remove"></i> ลบตัวเลือก</a>';
			question_radio += '</div>';
			question_radio += '</div>';
			question_radio += '<div class="row choice" style="margin-top:20px;">';
			question_radio += '<div class="span1">';
			question_radio += '<input type="radio" name="Choice['+question_index+'][]" class="choice-'+question_index+'-input pull-right" value="1">';
			question_radio += '</div>';
			question_radio += '<div class="span8">';
			question_radio += '<textarea name="ChoiceTitle['+question_index+'][1]" class="choice-tilte-input" id="choice-'+question_index+'-1-tilte-input" cols="30" rows="10"></textarea>';
			question_radio += '<a class="btn btn-icon btn-danger circle_ok choice-remove"><i class="icon-remove"></i> ลบตัวเลือก</a>';
			question_radio += '</div>';
			question_radio += '</div>';
			question_radio += '<div class="row choice" style="margin-top:20px;">';
			question_radio += '<div class="span1">';
			question_radio += '<input type="radio" name="Choice['+question_index+'][]" class="choice-'+question_index+'-input pull-right" value="2">';
			question_radio += '</div>';
			question_radio += '<div class="span8">';
			question_radio += '<textarea name="ChoiceTitle['+question_index+'][2]" class="choice-tilte-input" id="choice-'+question_index+'-2-tilte-input" cols="30" rows="10"></textarea>';
			question_radio += '<a class="btn btn-icon btn-danger circle_ok choice-remove"><i class="icon-remove"></i> ลบตัวเลือก</a>';
			question_radio += '</div>';
			question_radio += '</div>';
			question_radio += '<div class="row choice" style="margin-top:20px;">';
			question_radio += '<div class="span1">';
			question_radio += '<input type="radio" name="Choice['+question_index+'][]" class="choice-'+question_index+'-input pull-right" value="3">';
			question_radio += '</div>';
			question_radio += '<div class="span8">';
			question_radio += '<textarea name="ChoiceTitle['+question_index+'][3]" class="choice-tilte-input" id="choice-'+question_index+'-3-tilte-input" cols="30" rows="10"></textarea>';
			question_radio += '<a class="btn btn-icon btn-danger circle_ok choice-remove"><i class="icon-remove"></i> ลบตัวเลือก</a>';
			question_radio += '</div>';
			question_radio += '</div>';
			question_radio += '</div>';
			question_radio += '</div>';

			$('#question-list').append(question_radio);
			initTinyQuestion(question_index);

		});

		$('.form').on('click','#add-checkbox-question',function(){
			var value_index_question = $('#question-list').children('.question-group').last();
			var em_question_total = $('#question-list').children('.question-group');
			var question_index = 0;
			var question_total = 0;
			if(value_index_question.length){
				question_index = parseInt(value_index_question.attr('data-index'))+1;
			}
			if(em_question_total.length){
				question_total = parseInt(em_question_total.length);
			}
			question_total += 1;
			$('#CountNumAll').text(question_total);
			var question_checkbox = "";

			question_checkbox += '<div class="question-group" data-index="'+question_index+'">';
			question_checkbox += '<hr class="soften" />';
			question_checkbox += '<div class="row question">';
			question_checkbox += '<label><h3>โจทย์ (หลายคำตอบ) <input type="hidden" name="Question_type['+question_index+']" value="checkbox"> <!--ข้อที่ <span class="question-numbers" style="color:green; font-size: 20px;">'+question_total+'</span>--> ';
			question_checkbox += '<a class="btn btn-icon btn-danger circle_ok question-remove"><i class="icon-remove"></i> ลบโจทย์</a></h3>';
			question_checkbox += '</label>';
			question_checkbox += '<div class="span12">';
			question_checkbox += '<textarea name="Question['+question_index+']" class="question-title" id="question-'+question_index+'-title" cols="30" rows="10"></textarea>';
			question_checkbox += '</div>';
			question_checkbox += '</div>';
			question_checkbox += '<div class="row choice-list" style="margin-top:20px;">';
			question_checkbox += '<label><h3>ตัวเลือก <a class="btn btn-icon btn-success add-chocie" data-question-id="'+question_index+'"><i class="icon-book"></i> เพิ่มตัวเลือก</a></h3></label>';
			question_checkbox += '<div class="row choice" style="margin-top:20px;">';
			question_checkbox += '<div class="span1">';
			question_checkbox += '<input type="checkbox" name="Choice['+question_index+'][]" class="choice-'+question_index+'-input pull-right" value="0">';
			question_checkbox += '</div>';
			question_checkbox += '<div class="span8">';
			question_checkbox += '<textarea name="ChoiceTitle['+question_index+'][0]" class="choice-tilte-input" id="choice-'+question_index+'-0-tilte-input" cols="30" rows="10"></textarea>';
			question_checkbox += '<a class="btn btn-icon btn-danger circle_ok choice-remove"><i class="icon-remove"></i> ลบตัวเลือก</a>';
			question_checkbox += '</div>';
			question_checkbox += '</div>';
			question_checkbox += '<div class="row choice" style="margin-top:20px;">';
			question_checkbox += '<div class="span1">';
			question_checkbox += '<input type="checkbox" name="Choice['+question_index+'][]" class="choice-'+question_index+'-input pull-right" value="1">';
			question_checkbox += '</div>';
			question_checkbox += '<div class="span8">';
			question_checkbox += '<textarea name="ChoiceTitle['+question_index+'][1]" class="choice-tilte-input" id="choice-'+question_index+'-1-tilte-input" cols="30" rows="10"></textarea>';
			question_checkbox += '<a class="btn btn-icon btn-danger circle_ok choice-remove"><i class="icon-remove"></i> ลบตัวเลือก</a>';
			question_checkbox += '</div>';
			question_checkbox += '</div>';
			question_checkbox += '<div class="row choice" style="margin-top:20px;">';
			question_checkbox += '<div class="span1">';
			question_checkbox += '<input type="checkbox" name="Choice['+question_index+'][]" class="choice-'+question_index+'-input pull-right" value="2">';
			question_checkbox += '</div>';
			question_checkbox += '<div class="span8">';
			question_checkbox += '<textarea name="ChoiceTitle['+question_index+'][2]" class="choice-tilte-input" id="choice-'+question_index+'-2-tilte-input" cols="30" rows="10"></textarea>';
			question_checkbox += '<a class="btn btn-icon btn-danger circle_ok choice-remove"><i class="icon-remove"></i> ลบตัวเลือก</a>';
			question_checkbox += '</div>';
			question_checkbox += '</div>';
			question_checkbox += '<div class="row choice" style="margin-top:20px;">';
			question_checkbox += '<div class="span1">';
			question_checkbox += '<input type="checkbox" name="Choice['+question_index+'][]" class="choice-'+question_index+'-input pull-right" value="3">';
			question_checkbox += '</div>';
			question_checkbox += '<div class="span8">';
			question_checkbox += '<textarea name="ChoiceTitle['+question_index+'][3]" class="choice-tilte-input" id="choice-'+question_index+'-3-tilte-input" cols="30" rows="10"></textarea>';
			question_checkbox += '<a class="btn btn-icon btn-danger circle_ok choice-remove"><i class="icon-remove"></i> ลบตัวเลือก</a>';
			question_checkbox += '</div>';
			question_checkbox += '</div>';
			question_checkbox += '</div>';
			question_checkbox += '</div>';

			$('#question-list').append(question_checkbox);
			initTinyQuestion(question_index);

		});

		$('.form').on('click','#add-textarea-question',function(){
			var value_index_question = $('#question-list').children('.question-group').last();
			var em_question_total = $('#question-list').children('.question-group');
			var question_index = 0;
			var question_total = 0;
			if(value_index_question.length){
				question_index = parseInt(value_index_question.attr('data-index'))+1;
			}
			if(em_question_total.length){
				question_total = parseInt(em_question_total.length);
			}
			question_total += 1;
			$('#CountNumAll').text(question_total);
			var question_textarea = "";

			question_textarea += '<div class="question-group" data-index="'+question_index+'">';
			question_textarea += '<hr class="soften" />';
			question_textarea += '<div class="row question">';
			question_textarea += '<label><h3>โจทย์ (คำตอบบรรยาย) <input type="hidden" name="Question_type['+question_index+']" value="textarea"> <!--ข้อที่ <span class="question-numbers" style="color:green; font-size: 20px;">'+question_total+'</span>--> ';
			question_textarea += '<a class="btn btn-icon btn-danger circle_ok question-remove"><i class="icon-remove"></i> ลบโจทย์</a></h3>';
			question_textarea += '</label>';
			question_textarea += '<div class="span12">';
			question_textarea += '<textarea name="Question['+question_index+']" class="question-title" id="question-'+question_index+'-title" cols="30" rows="10"></textarea>';
			question_textarea += '</div>';
			question_textarea += '</div>';
			question_textarea += '</div>';

			$('#question-list').append(question_textarea);
			initTinyQuestionTextarea(question_index);

		});

		$('form#Question').submit(function(){
			tinyMCE.triggerSave();
			var validate = true;

			$('.question-title').each(function(index){
				if($(this).val() == ''){
//					tinyMCE.execCommand('mceFocus', false, $(this).attr('id'));
					alert('กรุณากรอกข้อมูลโจทย์ให้ครบ');
					validate = false;
					return false;
				}
			});
			if(validate) {
				$('.choice-tilte-input').each(function (index) {
					if ($(this).val() == '') {
//						tinyMCE.execCommand('mceFocus', false, $(this).attr('id'));
						alert('กรุณากรอกข้อมูลตัวเลือกให้ครบ');
						validate = false;
						return false;
					}
				});
			}
			if(validate) {
				$('.question-group').each(function (index) {

					var type = $(this).find("input[name^='Question_type']");
					if(type.length){
						type = type.val();
					}else{
						type = 'error';
					}

					if(type != 'textarea') {
						var radiochecked = $(this).find("input:checked").length;
						if (!radiochecked) {
							alert('กรุณาเลือกคำตอบที่ถูกต้องให้ครบ');
							$(this).find("input:"+type).first().focus();
							validate = false;
							return false;
						}
					}

				});
			}

			return validate;
		});


	});
</script>
<!-- END innerLR -->
