<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<style>
	.checkbox label:after {
		content: '';
		display: table;
		clear: both;
	}

	.checkbox .cr {
		position: relative;
		display: inline-block;
		border: 1px solid #a9a9a9;
		border-radius: .25em;
		width: 1.3em;
		height: 1.3em;
		float: left;
		margin-right: .5em;
	}

	.radio .cr {
		border-radius: 50%;
	}

	.checkbox .cr .cr-icon {
		position: absolute;
		font-size: .8em;
		line-height: 0;
		top: 50%;
		left: 20%;
	}

	.checkbox label {
		display: inline-block;
	}

	.checkbox label input[type="checkbox"]{
		display: none;
	}

	.checkbox label input[type="checkbox"] + .cr > .cr-icon{
		transform: scale(3) rotateZ(-20deg);
		opacity: 0;
		transition: all .3s ease-in;
	}

	.checkbox label input[type="checkbox"]:checked + .cr > .cr-icon{
		transform: scale(1) rotateZ(0deg);
		opacity: 1;
	}

	.checkbox label input[type="checkbox"]:disabled + .cr{
		opacity: .5;
	}
</style>

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
				<?php $form=$this->beginWidget('AActiveForm', array(
					'id'=>'course-form',
					'enableClientValidation'=>true,
					'clientOptions'=>array(
						'validateOnSubmit'=>true
					),
					'errorMessageCssClass' => 'label label-important',
					'htmlOptions' => array('enctype' => 'multipart/form-data')
				)); ?>
				<?php 
				$lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
				$parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0 ;
				$modelLang = Language::model()->findByPk($lang_id);
				?>

				<?php if ($lang_id != 1){ ?>
					<p class="note"><span style="color:red;font-size: 20px;">เพิ่มเนื้อหาของภาษา <?= $modelLang->language; ?></span></p>
					<?php 
				}
				?>
				<p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>
				

				<div class="row">
					<div class="col-md-8">
						<?php echo $form->labelEx($model,'type_name'); ?>
						<?php echo $form->textField($model,'type_name',array('class'=>'form-control')); ?>
						<?php echo $this->NotEmpty();?>
						<?php echo $form->error($model,'type_name'); ?>
					</div>
				</div>
				<!-- <div class="row">
					<div class="col-md-8">
						<?php echo $form->labelEx($model,'status'); ?>
						<?php echo $form->checkBox($model,'status',array(
							'data-toggle'=>'toggle', 'value'=>"1", 'uncheckValue'=>"2", "data-on"=>"show", "data-off"=>"hide", "data-onstyle"=>"info"
						)); ?>
						<?php echo $form->error($model,'status'); ?>
					</div>
				</div> -->
				<br>
				<div class="row buttons">
					<div class="col-md-8">
						<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
					</div>
				</div>
					<?php $this->endWidget(); ?>
				</div><!-- form -->
			</div>
		</div>
	</div>
