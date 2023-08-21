<?php echo CHtml::form();?>

<?php echo CHtml::label('TH ชื่อหมวดคำถาม : ','');
	echo CHtml::textField('titleQuestionTH',$titleTH);?></br>

<?php echo CHtml::label('EN ชื่อหมวดคำถาม : ','');
	echo CHtml::textField('titleQuestionEN',$titleEN);?></br>

<?php echo CHtml::label('TH คำอธิบาย : ','');
	echo CHtml::textArea('titleDescriptionTH',$DescriptionTH);?></br>

<?php echo CHtml::label('EN คำอธิบาย : ','');
	echo CHtml::textArea('titleDescriptionEN',$DescriptionEN);?></br>

<?php 
	if($type_button=='VIEW'){
		echo CHtml::submitButton($button_text,array('name'=>$type_button));
	}else{
		echo CHtml::submitButton($button_text,array('name'=>$type_button, 'confirm' => 'Are you sure?'));
	}
	echo CHtml::submitButton('ยกเลิก',array('name'=>'Backward'));?></br>

<?php echo CHtml::endForm();?>