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
<?php
$this->breadcrumbs=array(
	'จัดการชุดข้อสอบบทเรียนออนไลน์'=>array('//Grouptesting/Index'),
	'จัดการข้อสอบ'=>array('//question/index','id'=>Yii::app()->user->getState('getReturn')),
    strip_tags(CHtml::decode($modelQues->ques_title)),
);
?>
<style type="text/css">
.block { display: block; }
label.error { display: none; }
</style>

<script type="text/javascript">

	function initTinyChoice(question_id,id){
		tinymce.EditorManager.execCommand('mceAddEditor', true, "choice-"+question_id+"-"+id+"-tilte-input");
	}

	function initTinyQuestionTextarea(id){
		tinymce.EditorManager.execCommand('mceAddEditor', true, "question-"+id+"-title");
	}

	$(function() {
		$('#question-list').on('click','.choice-remove',function(){
			if(confirm('คุณต้องการลบข้อมูล?')) {
				var em_index = $(this).index('.choice-remove');
				$('.choice').eq(em_index).remove();
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
							$(this).find("input:radio").first().focus();
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
<!-- innerLR -->
<div class="innerLR">
	<div class="widget widget-tabs border-bottom-none">
		<div class="widget-head">
			<ul>
				<li class="active">
					<a class="glyphicons edit" href="#account-details" data-toggle="tab">
						<i></i>แก้ไขข้อสอบ
					</a>
				</li>
			</ul>
		</div>
		<div class="widget-body">
			<!--<p class="note">ค่าที่มี <?php echo ClassFunction::CircleQuestionMark();?> จำเป็นต้องใส่ให้ครบ</p>-->
			<!-- FORM -->
			<?php
			/*
			$old = array(1, 3, 4);
			$new = array(3, 4, 5, 6);
			echo '$old = array(1, 3, 4)<br>';
			echo '$new = array(3, 4, 5, 6)<br>';
			echo 'Case Insert : '.implode(",",array_diff($new,$old))."<br>";
			echo 'Case Update : '.implode(",",array_intersect($new,$old))."<br>";
			echo 'Case Delete : '.implode(",",array_diff($old,$new))."<br>";
			*/
			?>
			<div class="form">
				<?php echo CHtml::beginForm(Yii::app()->request->requestUri,'POST',array(
					'id'=>'Question',
					'name'=>'Question',
					'enableAjaxValidation'=>false,
				));?>
				<div id="question-list">
					<div class="question-group" data-index="<?php echo $modelQues->ques_id; ?>">
						<div class="row question">
							<?php
							$questionTypeArray = array(1 => 'checkbox', 2 => 'radio', 3 => 'textarea');
							?>
							<label><h3>โจทย์ <input type="hidden" name="Question_type[<?php echo $modelQues->ques_id; ?>]" value="<?php echo $questionTypeArray[$modelQues->ques_type]; ?>"> <!--ข้อที่ <span class="question-numbers" style="color:green; font-size: 20px;">'+question_total+'</span>--></h3>
								</label>
							<div class="span12">
								<textarea name="Question[<?php echo $modelQues->ques_id; ?>]" class="question-title" id="question-<?php echo $modelQues->ques_id; ?>-title" cols="30" rows="10"><?php echo $modelQues->ques_title; ?></textarea>
								</div>
							</div>
						<?php if($modelQues->ques_type != 3){ ?>
							<div class="row choice-list" style="margin-top:20px;">
							<label><h3>ตัวเลือก <a class="btn btn-icon btn-success add-chocie" data-question-id="<?php echo $modelQues->ques_id; ?>">
										<i class="icon-book"></i> เพิ่มตัวเลือก</a></h3></label>
							<?php
							$modelChoice = $modelQues->choices;
							if(count($modelChoice) > 0){
								foreach($modelChoice as $key => $choice){
							?>

								<div class="row choice" style="margin-top:20px;">
									<div class="span1">
										<input type="<?php echo $questionTypeArray[$modelQues->ques_type]; ?>" name="Choice[<?php echo $modelQues->ques_id; ?>][]"
											   class="choice-<?php echo $modelQues->ques_id; ?>-input pull-right" value="<?php echo $choice->choice_id; ?>" <?php echo ($choice->choice_answer == 1)?'checked':''; ?>>
									</div>
									<div class="span8">
										<textarea name="ChoiceTitle[<?php echo $modelQues->ques_id; ?>][<?php echo $choice->choice_id; ?>]"
												  class="choice-tilte-input"
												  id="choice-<?php echo $modelQues->ques_id; ?>-<?php echo $choice->choice_id; ?>-tilte-input" cols="30"
												  rows="10"><?php echo $choice->choice_detail; ?></textarea>
										<a class="btn btn-icon btn-danger circle_ok choice-remove">
											<i class="icon-remove"></i> ลบตัวเลือก</a>
									</div>
								</div>

							<?php
								}
							}
							?>
							</div>
						<?php } ?>
						</div>
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
<!-- END innerLR -->
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
