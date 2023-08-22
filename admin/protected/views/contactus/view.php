<?php
$this->breadcrumbs=array(
	'ระบบติดต่อเรา'=>array('index'),
	$model->contac_id,
);
?>
<div id="detail-form" class="innerLR">
	<?php
$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'contac_by_name',
		'contac_by_surname',
    'contac_by_email',
    'contac_by_tel',
    'contac_subject',
    'contac_detail',
	),
));
?>
&nbsp;&nbsp;
<?php
	if($model->contac_answer=='n'){
            echo CHtml::tag('button', array(
                'name'=>'btnCreateMail',
								'id'=>'btnCreateMail',
                'type'=>'button',
                'class'=>'btn btn-icon btn-primary glyphicons circle_ok',
            ), '<i></i>'.("ตอบกลับ"));
    ?>
		</div>
		<div id="email-form" class="innerLR">
			<!-- Form -->
		<?php $form=$this->beginWidget('AActiveForm', array(
		'id'=>'create-mail-form',
		'enableAjaxValidation'=>false,
		));
		?>
				<!-- Widget -->
				<div class="widget">
					<!-- Widget heading -->
					<div class="widget-head">
						<h4 class="heading">ตอบเมล์</h4>
					</div>
					<!-- // Widget heading END -->
					<?php //echo $form->errorSummary($model); ?>
					<div class="widget-body">
						<!-- Row -->
						<div class="row-fluid">
							<!-- Column -->
							<div class="span12">

								<!-- Group -->
								<div class="control-group">
									รายละเอียดจากผู้ส่ง
								<div class="controls">
										<?php $this->widget('ADetailView', array(
		                                    'data'=>$model,
		                                    'attributes'=>array(
		                                        'contac_by_name',
		                                        'contac_by_surname',
		                                        'contac_by_email',
		                                        'contac_by_tel',
		                                        'contac_subject',
		                                        'contac_detail',
		                                    ),
		                                )); ?>
		                        </div>

								</div>
								<!-- // Group END -->
								<!-- Group -->
								<div class="control-group">
									ข้อความตอบกลับ
								<div class="controls">
		                        	<input type="text" name="ans-subject" id="ans-subject" class="span6" placeholder="หัวข้อ(ต้องกรอก)" required/>
		                        </div>
									<?php //echo $form->error($model,'about_detail'); ?>
								</div>
								<!-- // Group END -->

								<!-- Group -->
								<div class="control-group">

								<div class="controls">
		                        	<textarea name="ans-detail" class="span12" rows="5" placeholder="ข้อความตอบกลับ(ต้องกรอก)" required></textarea>
		                        </div>
									<?php //echo $form->error($model,'about_detail'); ?>
		                            <input type="hidden" name="ans-mail" id="ans-mail" value="<?php echo $model->contac_by_email; ?>" />
		                            <input type="hidden" name="ans-name" id="ans-name" value="<?php echo $model->contac_by_name; ?>" />
		                            <input type="hidden" name="ans-surname" id="ans-surname" value="<?php echo $model->contac_by_surname; ?>" />
								</div>
								<!-- // Group END -->
							</div>
							<!-- // Column END -->
						</div>
						<!-- // Row END -->
						<hr class="separator" />
						<!-- Row -->
						<!-- // Row END -->
						<!-- Form actions -->
						<div class="form-actions">
						<?php
		                    echo CHtml::tag('button', array(
		                        'name'=>'btnSubmit',
		                        'type'=>'submit',
		                        'class'=>'btn btn-icon btn-primary glyphicons circle_ok',
		                    ), '<i></i>'.("ส่งเมล์"));
		                ?>
						<?php
		                    echo CHtml::tag('button', array(
		                        'name'=>'btnCancel',
		                        'id'=>'btnCancel',
		                        'class'=>'btn btn-icon btn-default glyphicons circle_remove',
		                    ), '<i></i>ยกเลิก');
		                ?>
						</div>
						<!-- // Form actions END -->
					</div>
				</div>
				<!-- // Widget END -->
		<?php $this->endWidget(); ?>
		<!--	</form>
		-->	<!-- // Form END -->
		</div>
		<?php
		}else{
		?>
		<h4>ข้อความที่ตอบ <?php //echo $model->contac_id; ?></h4>
		<?php $this->widget('ADetailView', array(
		    'data'=>$model,
		    'attributes'=>array(
		        'contac_ans_subject',
		        'contac_ans_detail',
		    ),
		)); ?>
		<br/>
		<?php
		}
		?>
		<script type="text/javascript">
		$(document).ready(function(){
			$("#email-form").hide();
			$("#btnCreateMail").click(function(){
				$("#detail-form").hide();
				$("#email-form").show();
			});

			$("#btnCancel").click(function(){
				$("#detail-form").show();
				$("#email-form").hide();
			});


		});
		</script>
