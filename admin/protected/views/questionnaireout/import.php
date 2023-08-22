<?php
$this->breadcrumbs=array(
    'ระบบชุดข้อสอบบทเรียนออนไลน์'=>array('index'),
    'เพิ่มชุดข้อสอบอบรมออนไลน์',
);
$formtext = "Import excel ข้อสอบ";
?>

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
			<div class="row-fluid">
			<div class="form">
				<?php if(Yii::app()->user->hasFlash('success')):?>
					<div class="info">
						<?php echo Yii::app()->user->getFlash('success'); ?>
					</div>
				<?php endif; ?>
				<?php $form = $this->beginWidget('AActiveForm', array(
					'id'=>'news-form',
			        'enableClientValidation'=>true,
			        'clientOptions'=>array(
			            'validateOnSubmit'=>true
			        ),
			        'errorMessageCssClass' => 'label label-important',
			        'htmlOptions' => array('enctype' => 'multipart/form-data')
				)); ?>
				<p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>

					<div class="span4">
						<?php echo $form->labelEx($model,'excel_file'); ?>
						<?php echo $form->fileField($model,'excel_file'); ?>
						<?php echo $this->NotEmpty();?>
						<?php echo $form->error($model,'excel_file'); ?>
						<div class="row buttons">
							<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
						</div>
					</div>

				<div class="span4">
					<h4>แบบฟอร์มรูปแบบนำเข้าแบบทดสอบ</label></h4>
					<a href="<?php echo Yii::app()->getBaseUrl().'/uploads/templete_import_questions.xls'; ?>" class="glyphicons download_alt"><i></i>Download Excel</a>
				</div>
				<?php $this->endWidget(); ?>
			</div><!-- form -->
				</div>
		</div>
	</div>
</div>
<!-- END innerLR -->
