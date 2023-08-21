<?php echo CHtml::form();?>

<?php 
	echo CHtml::label('TH ชื่อประเภทคำตอบ : ','');
	echo CHtml::textField('nameTH',$TypeTH); ?></br>

<?php 
	echo CHtml::label('EN ชื่อประเภทคำตอบ : ','');
	echo CHtml::textField('nameEN',$TypeEN); ?></br>

<?php 
	echo CHtml::label('TH คำอธิบาย : ','');
	echo CHtml::textArea('detailTH',$DescriptionTH); ?></br>

<?php 
	echo CHtml::label('EN คำอธิบาย : ','');
	echo CHtml::textArea('detailEN',$DescriptionEN);?></br>

<?php 
	echo CHtml::label('TH ข้อบังคับ : ','');
	echo CHtml::textArea('ruleTH',$RulesTH);?></br>

<?php 
	echo CHtml::label('EN ข้อบังคับ : ','');
	echo CHtml::textArea('ruleEN',$RulesEN);?></br>

<?php 
	if($type_button=='VIEW'){
		echo CHtml::submitButton($button_text,array('name'=>$type_button));
	}else{
		echo CHtml::submitButton($button_text,array('name'=>$type_button, 'confirm' => 'Are you sure?'));
	}
	echo CHtml::submitButton('ยกเลิก',array('name'=>'Backward'));?></br>

<?php echo CHtml::endForm(); ?>
