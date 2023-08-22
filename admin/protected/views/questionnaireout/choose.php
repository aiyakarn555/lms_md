<style>
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

$(function(){


});

</script>
<?php
$this->breadcrumbs=array(
	'ระบบบทเรียน'=>array('Lesson/index'),
	'เลือกแบบสอบถาม',
);
?>
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
						<i></i> เลือกแบบสอบถาม
					</a>
				</li>
			</ul>
		</div>
		<div class="widget-body">
			<!-- FORM -->
			<h4>เลือกแบบสอบถาม สำหรับ <?php echo $lesson->title; ?></h4>
			<div class="form">
				<?php echo CHtml::beginForm(Yii::app()->request->requestUri,'POST',array(
					'id'=>'questionnaire',
					'name'=>'questionnaire',
					'enableAjaxValidation'=>false,
				));?>
				<div class="row">
					<div>
					<br>
					<select name="header_id">
						<option value="">--- แบบสอบถาม ---</option>
						<?php
						$headerModel = QHeader::model()->findAll();
						if(count($headerModel) > 0){
							foreach ($headerModel as $headerKey => $headerValue) {
						?>
							<option <?php echo ($lesson->header_id == $headerValue->survey_header_id)?'selected':''; ?> value="<?php echo $headerValue->survey_header_id; ?>"><?php echo $headerValue->survey_name; ?></option>
						<?php
							}
						}
						?>
					</select>
					</div>
				</div>
				<div class="row buttons" style="padding-top: 26px;">
					<?php echo CHtml::tag('button',array('type'=>'submit','class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
				</div>
				<?php echo CHtml::endForm(); ?>
			</div>
			<!-- END form -->
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		
	});
</script>
<!-- END innerLR -->
