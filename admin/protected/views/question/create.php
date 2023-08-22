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

<script type="text/javascript" src="<?php echo $this->assetsBase; ?>/js/jquery.validate.js"></script>

<?php
$this->breadcrumbs=array(
	'จัดการชุดข้อสอบบทเรียนออนไลน์'=>array('//Grouptesting/Index'),
	'เพิ่มข้อสอบชุด'.$modelGroup->group_title,
);
?>
<style type="text/css">
	.block { display: block; }
	label.error { display: none; }
</style>

<!-- innerLR -->
<div class="innerLR">
	<textarea id="init" style="display:none;"></textarea>
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
						<?php
						echo CHtml::link('<i class="icon-book"></i> เพิ่มข้อสอบจับคู่', '', array(
							'class'=>'btn btn-icon btn-success',
							'id'=>'add-dropdown-question'
						));?>
						<?php
						echo CHtml::link('<i class="icon-book"></i> เพิ่มข้อสอบจัดเรียง', '', array(
							'class'=>'btn btn-icon btn-success',
							'id'=>'add-sort-question'
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
					<!-- <?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2','onclick'=>'tinyMCE.triggerSave();','id'=>'formSave'),'<i></i>บันทึกข้อมูล');?> -->
					<?php 
					echo CHtml::submitButton('บันทึกข้อมูล', array('class' => 'btn btn-primary btn-icon  ok_2','onclick'=>'tinyMCE.triggerSave();','id'=>'formSave','name' => 'submit'));
					?>
				</div>
				<?php echo CHtml::endForm(); ?>
			</div>
			<!-- END form -->
		</div>
	</div>
</div>

<!-- END innerLR -->
<script>
    $(function () {
        init_tinymce_question();

        $('#Question').submit(function(){
				setTimeout(function () {
					document.getElementById('formSave').value = 'กำลังประมวล…';
					document.getElementById('formSave').disabled = true;
				}, 200);
		});
    });
</script>