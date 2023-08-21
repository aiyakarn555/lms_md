<?php echo CHtml::form();?>

	<?php echo CHtml::textField('txtSearch','',array('id'=>'txtSearch'
						,'autocomplete'=>'off'));?>
	<?php echo chtml::openTag('ul', array('id'=>'autocomplete'));?>
	<?php echo chtml::closeTag('ul', array('id'=>'autocomplete'));?>

	<?php echo CHtml::submitButton('ค้นหา',array('name'=>'btnSearch'));?>
	<?php /*echo CHtml::ajaxButton('ค้นหาข้อมูล',
		Yii::app()->createAbsoluteUrl('Questionnaire/actionGroupQuestion'),
		array(
	        'type' => 'POST', // รูปแบบการส่งข้อมูล POST | GET
	        'dataType' => 'text', // รูปแบบข้อมูล xml | json | jsonp | html | script | text
	        'data' => array('filter' => $this->txtSearch), // ข้อมูลที่ส่งไป
	        'beforeSend' => 'function(){
	            alert("ข้อความก่อนส่งข้อมูลไปยัง URL");
	        }',
	        'success' => 'function(data){
	            alert(data);
	        }',
	    )
	);*/?>

	<?php echo CHtml::openTag('table');?>
	<?php echo CHtml::openTag('tr');?>
	<?php //echo CHtml::tag('th', array(), CHtml::checkBox('gqCheck',false));?>
	<?php echo CHtml::tag('th', array(), 'ลำดับ');?>
	<?php echo CHtml::tag('th', array(), 'หมวดคำถาม TH');?>
	<?php echo CHtml::tag('th', array(), 'หมวดคำถาม EN');?>
	<?php echo CHtml::tag('th', array(), 'ดู');?>
	<?php echo CHtml::tag('th', array(), 'แก้ไข');?>
	<?php echo CHtml::tag('th', array(), 'ลบ');?>

	<?php echo CHtml::closeTag('tr');?>

	<?php 
	foreach ($model as $rows){
		echo CHtml::openTag('tr');

		//Row
		echo CHtml::tag('td',array(),++$startnum);
		//Name TH
		echo CHtml::tag('td',array(),$rows->Tan_cNameTH);
		//Name EN
		echo CHtml::tag('td',array(),$rows->Tan_cNameEN);
		//View
		echo CHtml::tag('td',array(),
			CHtml::link(CHtml::image('../images/image2.png'),
				array('Questionnaire/ManageTypeAnswer','stat'=>'VIEW','id'=>$rows->Tan_nID))
			);
		//Edit
		echo CHtml::tag('td',array(), 
			CHtml::link(CHtml::image('../images/image2.png'),
				array('Questionnaire/ManageTypeAnswer','stat'=>'EDIT','id'=>$rows->Tan_nID))
			);
		//Delete
		echo CHtml::tag('td',array(), 
			CHtml::link(CHtml::image('../images/image2.png'),
				array('Questionnaire/ManageTypeAnswer','stat'=>'DEL','id'=>$rows->Tan_nID))
			);


		echo CHtml::closeTag('tr');
    	//echo $rows->Gqu_cNameEN;  // แสดงข้อมูล field attribute_name
	}
	echo CHtml::closeTag('table');
	
	if($countpage>1){
		for ($i=1; $i <=$countpage ; $i++) { 
			echo CHtml::link(CHtml::button($i),
					array('Questionnaire/TypeAnswer','page'=>$i,'filter'=>$filter)
				);
		}
	}
	
	echo CHtml::link(CHtml::button('เพิ่มข้อมูล'),
				array('Questionnaire/ManageTypeAnswer','stat'=>'ADD')
			);
	echo CHtml::link(CHtml::button('ลบทั้งหมด'),
				array('Questionnaire/ManageTypeAnswer','stat'=>'DELALL'
				),array('confirm'=>'Do you want to delete all?')
			);
?>

<?php echo CHtml::endForm();?>


<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/jquery/jquery-1.11.3.min.js"); ?>
<script type="text/javascript"> 
    $(document).ready(function(){
        $("#txtSearch").keyup(function(){
        	if($('#txtSearch').val().length>0){
	            $.post("index.php?r=Questionnaire/ACTypeAnswer", {
	                filter : $('#txtSearch').val()
	                }
	                ,function(result){
	                	if(result.length>4){
							$('#autocomplete').html(result);
	                	}else{
	                		$('#autocomplete').html(null);
	                	}
	                }
	            );
        	}else{
				$('#autocomplete').html(null);
        	}
        });
    });
</script>

<style>
#autocomplete{
	position: absolute;
    z-index: 999;
} 
</style>