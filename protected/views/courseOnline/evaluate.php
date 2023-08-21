<?php
$this->breadcrumbs = array(
	'หมวดหลักสูตรอบรมออนไลน์'=>array('//cateOnline/index'),
	'สั่งซื้อหลักสูตรอบรมออนไลน์',	
	'รายการสินค้า'=>array('cart')
);
?>

<table width="100%" class="table-striped table-bordered table" style="background: #fff;">
	<thead>
		<tr>
			<th rowspan="2" style="text-align:center;">หัวข้อแบบสอบถาม</th>
			<th colspan="5" style="text-align:center;">ระดับความพึงพอใจ</th>
		</tr>
		<tr>
			<th style="text-align:center;">มากที่สุด (5)</th>
			<th style="text-align:center;">มาก (4)</th>
			<th style="text-align:center;">ปานกลาง (3)</th>
			<th style="text-align:center;">น้อย (2)</th>
			<th style="text-align:center;">น้อยที่สุด (1)</th>
		</tr>
	</thead>
	<tbody>
<?php
echo CHtml::beginForm(array("//question/index"),'POST',array( 
	'id'=>'questionnaire-question-answer',
	'onSubmit'=>'JavaScript:return SubMitCheck();'
)); 
?>
		<?php foreach ($model as $key => $value): ?>
			<tr>
				<td style="text-align:center;"><?php echo $value->eva_title; ?></td>
				<td style="text-align:center;">
					<?php echo CHtml::radioButton('name'.$key.'[]', false,array(
						'value'=>5
					)); ?>
				</td>
				<td style="text-align:center;">
					<?php echo CHtml::radioButton('name'.$key.'[]', false,array(
						'value'=>4
					)); ?>
				</td>
				<td style="text-align:center;">
					<?php echo CHtml::radioButton('name'.$key.'[]', false,array(
						'value'=>3
					)); ?>
				</td>
				<td style="text-align:center;">
					<?php echo CHtml::radioButton('name'.$key.'[]', false,array(
						'value'=>2
					)); ?>
				</td>
				<td style="text-align:center;">
					<?php echo CHtml::radioButton('name'.$key, false,array(
						'value'=>1
					)); ?>
				</td>
			</tr>
		<?php endforeach; ?>	
	</tbody>
</table>
<?php echo CHtml::tag('button',array('class' => 'btn btn-icon btn-warning'),'บันทึกข้อมูล'); ?>
<?php echo CHtml::endForm(); ?>