<?php
/* @var $this ChatController */
/* @var $model Chat */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	

	<div class="row">
		<?php echo $form->label($model,'time'); ?>
		<?php Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
    $this->widget('CJuiDateTimePicker',array(
        'model'=>$model, //Model object
		
    	
		//'name'=>'Process[time_up_from]',
        'attribute'=>'time', //attribute name
        'mode'=>'datetime', //use "time","date" or "datetime" (default)
        'options'=>array("dateFormat"=>'yy-mm-dd',
		"timeFormat"=>'hh:mm:ss',
		'showAnim'=>'slide',//'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
		),
		'language'=>'th' // jquery plugin options
    ));
?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Search',array(
					"class"=>"btn btn-primary",
				)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->