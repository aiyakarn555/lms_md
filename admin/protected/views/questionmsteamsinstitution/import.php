<?php
$this->breadcrumbs=array(
    'ระบบชุดข้อสอบบทเรียนออนไลน์(สถาบัน)'=>array('GrouptestingMsTeamsInstitution/index'),
    'เพิ่มชุดข้อสอบอบรมออนไลน์(สถาบัน)',
);
$formtext = "Import excel ข้อสอบ(สถาบัน)";
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
						<span class="label label-primary">1</span><h4>แบบฟอร์มรูปแบบนำเข้าแบบทดสอบ</label></h4>
						<a href="<?php echo Yii::app()->getBaseUrl().'/../uploads/templete_import_questions.xls'; ?>" class="glyphicons download_alt"><i></i>Download Excel</a>
					</div>

					<div class="span8" style="padding-top: 20px;">
						<?php echo '<span class="label label-primary">2</span>'.$form->labelEx($model,'excel_file'); ?>
						<?php echo $form->fileField($model,'excel_file'); ?>
						<?php echo $this->NotEmpty();?>
						<?php echo $form->error($model,'excel_file'); ?>
						<div class="row buttons">
							<!-- <?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2','id'=>'formSave','onclick'=>'disable()'),'<i></i>บันทึกข้อมูล');?> -->
							<?php 
							echo CHtml::submitButton('บันทึกข้อมูล', array('class' => 'btn btn-primary btn-icon ok_2','id'=>'formSave','name' => 'submit'));
							?>
						</div>
					</div>

				
				<?php $this->endWidget(); ?>
			</div><!-- form -->
			<div style="margin-top: 20px;">
					<br>
					<table class="table">
						<tr>
							<th>ประเภทคำตอบ</th>
							<th>ความหมาย</th>
						</tr>
						<tr>
							<td>radio</td>
							<td>ข้อสอบคำตอบเดียว</td>
						</tr>
						<tr>
							<td>checkbox</td>
							<td>ข้อสอบหลายคำตอบ</td>
						</tr>
            			<tr>
							<td>textarea</td>
							<td>ข้อสอบบรรยาย</td>
						</tr>
						<tr>
							<td>dropdown</td>
							<td>ข้อสอบจับคู่</td>
						</tr>
						<tr>
							<td>hidden</td>
							<td>จัดเรียง</td>
						</tr>
						<tr>
							<td colspan="2">การใส่สัญลักษณ์ <span style="color: #fc0031">*หน้าตัวเลือก</span> หมายความว่า ตัวเลือกนั้นคือคำตอบที่ถูกต้อง</td>
						</tr>
					</table>
				</div>
				</div>
		</div>
	</div>
</div>
<!-- END innerLR -->
<script type="text/javascript">
	$(document).ready(function(){
		$('#news-form').submit(function(){
			if( document.getElementById("Question_excel_file").files.length > 0 ){
				setTimeout(function () {
					document.getElementById('formSave').value = 'กำลังประมวล…';
					document.getElementById('formSave').disabled = true;
				}, 300);
			}
			
		});
		
	});
</script>
