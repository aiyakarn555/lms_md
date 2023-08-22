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

				<?php $form=$this->beginWidget('AActiveForm', array(
					'id'=>'terms-form',
			        'enableClientValidation'=>true,
			        'clientOptions'=>array(
			            'validateOnSubmit'=>true
			        ),
			        'errorMessageCssClass' => 'label label-important',
			        'htmlOptions' => array('enctype' => 'multipart/form-data')
				)); ?>

				<p class="note">ค่าที่มี <?php //echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>
				<div class="row">
					<?php echo $form->labelEx($model,'terms_title'); ?>
					<?php echo $form->textField($model,'terms_title',array('size'=>60,'maxlength'=>250, 'class'=>'span8')); ?>
					<?php echo $this->NotEmpty();?>
					<?php echo $form->error($model,'terms_title'); ?>
				</div> 

				<div class="row">
					<?php echo $form->labelEx($model,'terms_detail'); ?>
					<?php echo $form->textArea($model,'terms_detail',array('rows'=>6, 'cols'=>50, 'class'=>'span8 tinymce')); ?>
					<?php echo $form->error($model,'terms_detail'); ?>
				</div>

				<br/>

				<div class="row buttons">
					<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
				</div>

				<?php $this->endWidget(); ?>

			</div><!-- form -->
		</div>
	</div>
</div>
<!-- END innerLR -->
<script>
	$(function () {
		init_tinymce();
	});
//  $(document).ready(function(){
// // 	// $("#terms_terms_detail").keydown(function(){
// //   //$('#terms_terms_detail').click( function() {
// //        alert(tinyMCE.activeEditor.getContent());
// //         alert(tinyMCE.activeEditor.getContent({format : 'raw'}));
// //         alert(tinyMCE.get('terms_terms_detail').getContent());
// //         alert(tinyMCE.activeEditor.getContent({format : 'text'}));
// //    //  });
// // 	// });
 	
// var rrrrr = $(tinymce.get('#terms_terms_detail').getBody()).html('<p>This is my new content!</p>');
// alert(rrrrr);
// });
</script>