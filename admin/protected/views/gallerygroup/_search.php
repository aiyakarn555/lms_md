<?php
/* @var $this ExamWorkController */
/* @var $model ExamWork */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row mbl">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-body">
                    <form action="#" class="form-horizontal">
                        <div class="form-body pal">
                            <div class="col-md-4 col-md-offset-2">
                                <!-- <div class="col-lg-12"> -->
                               		<!-- <?php // echo $form->textField($model,'ex_titleTH',array('class'=>'form-control','placeholder'=>'ชื่อผลงาน TH')); ?> -->
                                    <?php echo $form->labelEx($model,'gallery_type_id',array('class'=>'control-label text-center','style'=>
                                    'width:100%; margin:2em 0;')); ?> 
                                    <?php echo $form->dropDownList($model, 'gallery_type_id', CHtml::listData(GalleryType::model()->findAll(), 'id', 'name_gallery_type'),array('class'=>'form-control','style'=>
                                    'width:100%;','prompt'=>'เลือก')); ?>
                                <?php echo $form->error($model,'gallery_type_id'); ?>
                                <!-- </div> -->
                            </div>
                             
                            <div class="col-md-2">
                                <br>
                                <?php echo CHtml::submitButton('Search',array('class' => 'btn btn-info','style'=>'margin-top:4em;')); ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


	

<?php $this->endWidget(); ?>

</div><!-- search-form -->