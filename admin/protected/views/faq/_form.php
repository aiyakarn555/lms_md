<?php
/* @var $this FaqController */
/* @var $model Faq */
/* @var $form CActiveForm */
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
			<div class="form">
				<?php $form = $this->beginWidget('AActiveForm', array(
					'id'=>'news-form',
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
				
                      if($lang_id == 1){ 
                        $att = array("class"=>"span8");
                        $modelList = FaqType::model()->findAll(array('condition'=>'active="y" and lang_id = '.$lang_id));
                        }else{ 
                        $att = array('class'=>'span8','readonly' => true);
                        $root = Faq::model()->find(array("condition"=>"active='y' and faq_nid_ = '".$parent_id."'"));

                        $modelList = FaqType::model()->findAll(array("condition"=>"active='y' and lang_id = '".$lang_id."' and parent_id = '".$root->faq_type_id."'"));
                        } 
                ?>
				<p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>

				<div class="row">
					<?php echo $form->labelEx($model,'faq_type_id'); ?>
					<!-- <?php
					echo $form->dropDownList($model, 'faq_type_id', CHtml::listData(FaqType::model()->findAll(array('condition'=>'active="y"')), 'faq_type_id', 'faq_type_title_TH'),array('class'=>'span8'));
					?> -->
					<?php
					echo $form->dropDownList($model, 'faq_type_id', CHtml::listData($modelList, 'faq_type_id', 'faq_type_title_TH'),$att);
					?>
					<?php echo $this->NotEmpty();?>
					<?php echo $form->error($model,'faq_type_id'); ?>
				</div>



				<div class="row">
					<?php echo $form->labelEx($model,'faq_THtopic'); ?>
					<?php echo $form->textField($model,'faq_THtopic',array('size'=>60,'maxlength'=>250,'class'=>'span8')); ?>
					<?php echo $this->NotEmpty();?>
					<?php echo $form->error($model,'faq_THtopic'); ?>
				</div>

				<div class="row">
					<?php echo $form->labelEx($model,'faq_THanswer'); ?>
					<?php echo $form->textArea($model,'faq_THanswer',array('rows'=>4, 'cols'=>40,'class'=>'span8 tinymce')); ?>
					<?php echo $this->NotEmpty();?>
					<?php echo $form->error($model,'faq_THanswer'); ?>
				</div>

				<br>

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
</script>

