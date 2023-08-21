<?php
Yii::import('zii.widgets.CPortlet');
 
class SimpleSearchForm extends CPortlet {
    protected function renderContent() {
		$form=$this->beginWidget('CActiveForm', array(
			'id'=>'simple-search-form',
			'action'=>array('search/index'),
			'enableAjaxValidation'=>false,
		));

			echo CHtml::hiddenField('choice','0');
			echo CHtml::hiddenField('type','0');
        ?>
        <div class="form-group input-group margin-none">
            <div class="row margin-none">
                <div class="col-xs-12 padding-none">
                    <?=CHtml::textField('search','', array('size'=>20,'maxlength'=>50,'class'=>'form-control','placeholder'=>'คำค้นหา'));?>
                </div>
            </div>
            <div class="input-group-btn">
                <?=CHtml::htmlButton('<i class="fa fa-search"></i>',array(
//                    'encode' => false,
                    'class'=>'btn btn-primary',
                    'type'=>'submit',
                ));?>
            </div>
        </div>

<?php
		$this->endWidget();
    }
}



